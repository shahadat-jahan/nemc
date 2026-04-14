<?php
/**
 * Created by PhpStorm.
 * User: office
 * Date: 2/14/19
 * Time: 2:54 PM
 */

namespace App\Services;

use App\Events\UpdateStudentCredit;
use App\Imports\PaymentBulkImport;
use App\Models\AdvanceAmountUseHistories;
use App\Models\Attachment;
use App\Models\Course;
use App\Models\PaymentType;
use App\Models\Student;
use App\Models\StudentFee;
use App\Models\StudentFeeDetail;
use App\Models\StudentPayment;
use App\Models\StudentPaymentDetail;
use App\Services\Admin\PaymentDetailService;
use App\Services\CronLogService;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Exception;

class StudentFeeService extends BaseService
{

    protected $studentFeeDetail;
    protected $studentPaymentModel;
    protected $attachmentModel;
    protected $emailService;
    protected $student;
    protected $cronLogService;
    protected $paymentDetailService;
    protected $studentPaymentDetailModel;
    protected $courseModel;
    protected $paymentTypeModel;
    protected $advanceAmountUseHistories;

    public function __construct(
        StudentFee           $studentFee, StudentFeeDetail $studentFeeDetail, StudentPayment $studentPayment, Attachment $attachment,
        EmailService         $emailService, Student $student, CronLogService $cronLogService, PaymentDetailService $paymentDetailService,
        StudentPaymentDetail $studentPaymentDetail, Course $course, PaymentType $paymentTypeModel, AdvanceAmountUseHistories $advanceAmountUseHistories
    )
    {
        $this->model                     = $studentFee;
        $this->studentFeeDetail          = $studentFeeDetail;
        $this->studentPaymentModel       = $studentPayment;
        $this->attachmentModel           = $attachment;
        $this->emailService              = $emailService;
        $this->student                   = $student;
        $this->cronLogService            = $cronLogService;
        $this->paymentDetailService      = $paymentDetailService;
        $this->studentPaymentDetailModel = $studentPaymentDetail;
        $this->courseModel               = $course;
        $this->paymentTypeModel          = $paymentTypeModel;
        $this->advanceAmountUseHistories = $advanceAmountUseHistories;
    }

    public function getInstallmentsDataTable($request, $id)
    {
        $query = $this->studentFeeDetail->whereHas('fee', function ($q) use ($id) {
            $q->where('student_id', $id);
        })
                                        ->where(function ($q) {
                                            $q->where('payment_type_id', 1)->orWhere('payment_type_id', 7);
                                        })
                                        ->orderBy('last_date_of_payment', 'asc')->select();

        return Datatables::of($query)
                         ->editColumn('title', function ($row) {
                             return $row->fee->title;
                         })
                         ->editColumn('payable_amount', function ($row) {
                             return formatAmount($row->payable_amount);
                         })
            /*->editColumn('paid_amount', function ($row) {
                return '';
            })*/
            /*->addColumn('action', function ($row) {
                $actions= '<a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View"><i class="flaticon-eye"></i></a>';

                return $actions;
            })*/
                         ->editColumn('status', function ($row) {
                $sPayments = $row->studentPaymentDetails;
                $disCount  = [];
                if (!empty($sPayments)) {
                    foreach ($sPayments as $item) {
                        $disCount[] = $item->studentPayment->discount_amount;
                    }
                }
                $discount   = array_sum($disCount);
                $due_amount = $row->fee->due_amount;
                $due_amount = $due_amount - $discount;
                if ($due_amount <= 0) {
                    $status = paymentStatus(1);
                } else {
                    $status = paymentStatus($row->status);
                }
                return $status;
            })
                         ->rawColumns(['status', 'action'])
                         ->make(true);
    }

    public function saveStudentInstallment($request, $id)
    {
        $totalAmount   = str_replace(',', '', $request->total_development_fee);
        $payableAmount = str_replace(',', '', $request->total_payable_amount);

        DB::beginTransaction();

        $studentPayment = $this->create([
            'student_id'      => $id,
            'title'           => $request->fee_title,
            'total_amount'    => $totalAmount,
            'discount_amount' => ($totalAmount - $payableAmount),
            'payable_amount'  => $payableAmount,
            'due_amount'      => $payableAmount,
            'status'          => 0,
        ]);

        if (!empty($request->amount)) {
            $paymentDetail = [];
            foreach ($request->amount as $key => $amount) {
                $installmentAmount   = str_replace(',', '', $amount);
                $paymentDetail[$key] = [
                    'payment_type_id'      => $request->payment_type_id,
                    'total_amount'         => $installmentAmount,
                    'discount_amount'      => 0,
                    'payable_amount'       => $installmentAmount,
                    'due_amount'           => $installmentAmount,
                    'last_date_of_payment' => $request->last_date_of_payment[$key],
                ];
            }

            $studentPayment->feeDetails()->createMany($paymentDetail);
        }

        DB::commit();

        return $studentPayment;
    }

    public function updateStudentInstallment($request, $id)
    {
        $totalAmount   = str_replace(',', '', $request->total_development_fee);
        $payableAmount = str_replace(',', '', $request->total_payable_amount);

        DB::beginTransaction();

        $studentFee = $this->findBy(['student_id' => $id]);

        $studentFee->total_amount    = $totalAmount;
        $studentFee->discount_amount = ($totalAmount - $payableAmount);
        $studentFee->payable_amount  = $payableAmount;
        $studentFee->due_amount      = $payableAmount;
        $studentFee->save();

        $studentFee->feeDetails->each(function ($detail) {
            $detail->delete();
        });

        if (!empty($request->amount)) {
            $paymentDetail = [];
            foreach ($request->amount as $key => $amount) {
                $installmentAmount   = str_replace(',', '', $amount);
                $paymentDetail[$key] = [
                    'payment_type_id'      => $request->payment_type_id,
                    'total_amount'         => $installmentAmount,
                    'discount_amount'      => 0,
                    'payable_amount'       => $installmentAmount,
                    'due_amount'           => $installmentAmount,
                    'last_date_of_payment' => $request->last_date_of_payment[$key],
                ];
            }

            $studentFee->feeDetails()->createMany($paymentDetail);
        }

        DB::commit();

        return $studentFee;
    }

    public function getTotalPayableAmountByPaymentIdAndStudentId($paymentTypeId, $studentId)
    {
        return $this->studentFeeDetail->where('payment_type_id', $paymentTypeId)
                                      ->whereHas('fee', function ($q) use ($studentId) {
                                          $q->where('student_id', $studentId);
                                      })
                                      ->sum('payable_amount');
    }

    //get student fee by student_id
    public function getStudentFeeByStudentId($studentId)
    {
        return $this->model->where([
            ['student_id', $studentId],
            ['status', '!=', 1],
        ])->get();
    }

    public function studentFeeDetailsByStudentFeeId($studentFeeId)
    {
        return $this->studentFeeDetail->where([
            ['student_fee_id', '=', $studentFeeId],
            ['status', '!=', 1],
        ])->get();
    }

    // get student fee details from student fee detail table by student_id
    public function getStudentFeeDetailsByStudentId($studentId)
    {
        return $this->studentFeeDetail->where([
            ['student_fee_id', '=', $studentId],
            ['status', '=', '0'],
        ])->get();
    }

    public function getStudentInstallments($studentId)
    {
        return $this->studentFeeDetail->whereHas('fee', function ($q) use ($studentId) {
            $q->where('student_id', $studentId);
        })->where('payment_type_id', 1)->orderBy('last_date_of_payment', 'asc')->get();
    }

    // get payable amount to show in amount field
    public function getStudentFeeDetailByFeeDetailId($studentFeeDetailId)
    {
        return $this->studentFeeDetail->find($studentFeeDetailId);
    }

    public function saveStudentFeeByStudentIdAndStudentFeeDetailId($request)
    {
        //work on bank slip file
        if ($request->hasFile('bank_slip') and empty($request->attachment_id)) {
            $file     = $request->file('bank_slip');
            $fileName = $file->getClientOriginalName();
            //if directory not exist make directory
            if (!file_exists('nemc_files/payment')) {
                mkdir('nemc_files/payment', 0777, true);
            }
            //move file to directory
            $file->move('nemc_files/payment', $fileName);
            //Save bank slip file to attachment table
            $bankSlip     = $this->attachmentModel->create([
                'attachment_type_id' => 7,
                'student_id'         => $request->student_id,
                'title'              => $request->bank_slip_number,
                'file_path'          => $fileName,
            ]);
            $attachmentId = $bankSlip->id;
        } else {
            $attachmentId = $request->attachment_id;
        }

        //work on discount application file
        if ($request->hasFile('discount_application')) {
            $file             = $request->file('discount_application');
            $discountFileName = $file->getClientOriginalName();
            $file->move('nemc_files/payment', $discountFileName);
            $discount_application = $discountFileName;
        } else {
            $discount_application = null;
        }
        //save fee payment data to the student_payments table
        $studentPaymentData = $this->studentPaymentModel->create([
            'student_id'            => $request->student_id,
            'student_fee_id'        => $request->student_fee_id,
            'student_fee_detail_id' => checkEmpty($request->student_fee_detail_id),
            'attachment_id'         => $attachmentId,
            'discount_application'  => $discount_application,
            'amount'                => $request->amount,
            'discount'              => checkEmpty($request->discount),
            'payment_date'          => $request->payment_date,
            'remarks'               => checkEmpty($request->remarks),
        ]);

        //get payable amount in student_fee_details table
        if (!empty($request->student_fee_detail_id)) {
            $feeDetailAmount = $this->studentFeeDetail->where([
                ['id', $request->student_fee_detail_id],
                ['student_fee_id', $request->student_fee_id],
            ])->first()->payable_amount;

            //get amount in student_payments table
            $feePaidAmount = $this->studentPaymentModel->where([
                ['student_id', $request->student_id],
                ['student_fee_id', $request->student_fee_id],
                ['student_fee_detail_id', $request->student_fee_detail_id],
            ])->sum('amount');

            //if mark the payment as clear
            if ($request->payment_paid == 1) {
                $this->studentFeeDetail->where('id', $request->student_fee_detail_id)->update(['status' => 1]);
            } elseif ($feePaidAmount == $feeDetailAmount) {
                //Update status to student_fee_details table comparing amount between student_fee_details and student_payments
                $this->studentFeeDetail->where('id', $request->student_fee_detail_id)->update(['status' => 1]);
            } else {
                $this->studentFeeDetail->where('id', $request->student_fee_detail_id)->update(['status' => 2]);
            }

            //get all step student chosen(student_fee_details) to pay full amount(in student_fees table) in
            $totalPaymentStep = $this->studentFeeDetail->where('student_fee_id', $request->student_fee_id)->count();

            //get all amount paid step from student_fee_details table
            $totalPaymentPaidStep = $this->studentFeeDetail->where([
                ['student_fee_id', $request->student_fee_id],
                ['status', 1],
            ])->count();

            if ($totalPaymentPaidStep != 0) {
                //if fully paid then change status to 1 in student fee table
                if ($totalPaymentStep == $totalPaymentPaidStep) {
                    $this->model->where([
                        ['id', $request->student_fee_id],
                        ['student_id', $request->student_id],
                    ])->update(['status' => 1]);
                } else {
                    //if partial paid then change status to 2 in student fee table
                    $this->model->where([
                        ['id', $request->student_fee_id],
                        ['student_id', $request->student_id],
                    ])->update(['status' => 2]);
                }
            }
        } else {
            if ($request->payment_paid == 1) {
                //update student_fee_details table status
                $this->studentFeeDetail->where('student_fee_id', $request->student_fee_id)->update(['status' => 1]);
                //update student_fees table status
                $this->model->where([
                    ['id', $request->student_fee_id],
                    ['student_id', $request->student_id],
                ])->update(['status' => 1]);
            } else {
                //update student_fee_details table status
                $this->studentFeeDetail->where('student_fee_id', $request->student_fee_id)->update(['status' => 2]);
                //update student_fees table status
                $this->model->where([
                    ['id', $request->student_fee_id],
                    ['student_id', $request->student_id],
                ])->update(['status' => 2]);
            }
        }
        //Send mail to student and parent after payment paid
        $studentPayment    = $studentPaymentData;
        $studentFees       = '';
        $studentFeeDetails = '';
        if ($studentPayment->student_fee_detail_id == null) {
            //get data from student fee table
            $studentFees = $this->model->where('student_id', $request->student_id)->where('id', $studentPaymentData->student_fee_id)->first();
        } else {
            //get data from student fee detail table
            $studentFeeDetails = $this->studentFeeDetail->where([
                ['student_fee_id', $request->student_fee_id],
                ['id', $request->student_fee_detail_id],
            ])->get();
        }
        $data            = [
            'studentPayment'    => $studentPayment,
            'studentFees'       => $studentFees,
            'studentFeeDetails' => $studentFeeDetails,
        ];
        $studentMailBody = view('payments.paymentCollect.paymentTemplate', $data);

        $this->emailService->mailSend($studentPayment->student->email, $studentPayment->student->parent->father_email, 'NEMC: Payment generated', 'payment', $studentMailBody);

        return $studentPaymentData;
    }

    //single student installment payment detail
    public function getStudentInstallmentDetailsByStudentIdAndDate($studentId, $fromDate, $toDate = null)
    {
        $query = $this->studentFeeDetail->with('studentPaymentDetails.studentPayment', 'paymentType')->whereHas('fee', function ($q) use ($studentId) {
            $q->where('student_id', $studentId);
        })->where('payment_type_id', 1);

        if (!empty($toDate)) {
            //change request date format like db date format
            $fromDate = Carbon::createFromFormat('d/m/Y', $fromDate)->format('Y-m-d');
            $toDate   = Carbon::createFromFormat('d/m/Y', $toDate)->format('Y-m-d');
            //$query = $query->whereBetween('last_date_of_payment', [$fromDate, $toDate]);
            $query = $query->whereBetween('created_at', [$fromDate, $toDate]);
        } else {
            //change request date format like db date format
            $fromDate = Carbon::createFromFormat('d/m/Y', $fromDate)->format('Y-m-d');
            $query    = $query->whereDate('created_at', '>=', $fromDate);
        }

        return $query->orderBy('last_date_of_payment', 'asc')->get();
    }

    //single student payments detail
    public function getStudentPaymentDetailsByStudentIdAndDate($studentId, $fromDate, $toDate = null)
    {
        $query = $this->model->where('student_id', $studentId)->with('studentPaymentDetails.studentPayment')
                             ->whereHas('feeDetails', function ($q) use ($fromDate, $toDate) {
                                 $q = $q->where('payment_type_id', '<>', 1);
                                 if (!empty($toDate)) {
                                     $fromDate = Carbon::createFromFormat('d/m/Y', $fromDate)->format('Y-m-d');
                                     $toDate   = Carbon::createFromFormat('d/m/Y', $toDate)->format('Y-m-d');
                                     //$q = $q->whereBetween('last_date_of_payment', [$fromDate, $toDate]);
                                     $q = $q->whereBetween('created_at', [$fromDate, $toDate]);
                                 } else {
                                     $fromDate = Carbon::createFromFormat('d/m/Y', $fromDate)->format('Y-m-d');
                                     $q        = $q->whereDate('created_at', '>=', $fromDate);
                                 }
                             })->get();

        return $query;
    }

    //all student installment payment detail
    public function getAllStudentInstallmentDetailsByStudentIdsAndDate($request)
    {
        $studentIds = $this->student->where([
            ['session_id', $request->session_id],
            ['course_id', $request->course_id],
        ])->pluck('id');

        $query = $this->studentFeeDetail->with('studentPaymentDetails.studentPayment', 'fee.student', 'paymentType')->whereHas('fee', function ($q) use ($studentIds) {
            $q->whereIn('student_id', $studentIds);
        })->where('payment_type_id', 1);

        if (!empty($request->to_date)) {
            //change request date format like db date format
            $fromDate = Carbon::createFromFormat('d/m/Y', $request->from_date)->format('Y-m-d');
            $toDate   = Carbon::createFromFormat('d/m/Y', $request->to_date)->format('Y-m-d');
            //$query = $query->whereBetween('last_date_of_payment', [$fromDate, $toDate]);
            $query = $query->whereBetween('created_at', [$fromDate, $toDate]);
        } else {
            //change request date format like db date format
            $fromDate = Carbon::createFromFormat('d/m/Y', $request->from_date)->format('Y-m-d');
            $query    = $query->whereDate('created_at', '>=', $fromDate);
        }

        return $query->orderBy('student_fee_id', 'asc')->orderBy('last_date_of_payment', 'asc')->get();
    }

    //all student tuition and other payment detail
    public function getALlStudentPaymentDetailsByStudentIdsAndDate($sessionId, $courseId, $fromDate, $toDate = null)
    {
        $studentIds = $this->student->where([
            ['session_id', $sessionId],
            ['course_id', $courseId],
        ])->pluck('id');

        $query = $this->model->whereIn('student_id', $studentIds)->with('studentPaymentDetails.studentPayment', 'student')
                             ->whereHas('feeDetails', function ($q) use ($fromDate, $toDate) {
                                 $q = $q->where('payment_type_id', '<>', 1);
                                 if (!empty($toDate)) {
                                     $fromDate = Carbon::createFromFormat('d/m/Y', $fromDate)->format('Y-m-d');
                                     $toDate   = Carbon::createFromFormat('d/m/Y', $toDate)->format('Y-m-d');
                                     //$q = $q->whereBetween('last_date_of_payment', [$fromDate, $toDate]);
                                     $q = $q->whereBetween('created_at', [$fromDate, $toDate]);
                                 } else {
                                     $fromDate = Carbon::createFromFormat('d/m/Y', $fromDate)->format('Y-m-d');
                                     $q        = $q->whereDate('created_at', '>=', $fromDate);
                                 }
                             });

        return $query->orderBy('student_id', 'asc')->get();
    }

    ////all student payment detail by payment type
    public function getALlStudentPaymentDetailsByStudentIdsPaymentTypeAndDate($sessionId, $courseId, $paymentTypeId, $fromDate, $toDate = null)
    {
        $studentIds = $this->student->where([
            ['session_id', $sessionId],
            ['course_id', $courseId],
        ])->pluck('id');

        //Prepared Student Fee Details Array
        $query = DB::table('students as student')->whereIn('student.id', $studentIds)
                   ->leftJoin('student_fees as fee', 'student.id', '=', 'fee.student_id')
                   ->leftJoin('student_fee_details as fee_detail', 'fee.id', '=', 'fee_detail.student_fee_id')
                   ->where('fee_detail.payment_type_id', $paymentTypeId)
                   ->select('student.id as student_id', 'student.full_name_en as name', 'student.roll_no as roll', 'fee_detail.id as fee_detail_id',
                       DB::raw('(CASE
                WHEN fee_detail.payment_type_id = 1 THEN "Development Fee"
                WHEN fee_detail.payment_type_id = 2 THEN "Admission Fee"
                WHEN fee_detail.payment_type_id = 3 THEN "Tuition Fee"
                WHEN fee_detail.payment_type_id = 4 THEN "Class Absent Fee"
                WHEN fee_detail.payment_type_id = 5 THEN "Late Fee"
                WHEN fee_detail.payment_type_id = 6 THEN "Re-admission Fee"
                END) AS fee_payment_type'), 'fee_detail.payment_type_id as fee_payment_type_id',
                       'fee_detail.payable_amount as payable_amount',
                       'fee_detail.discount_amount', 'fee_detail.last_date_of_payment as last_date_of_payment',
                       'fee_detail.bill_month as bill_month', 'fee_detail.bill_year as bill_year');
        if (!empty($toDate)) {
            $fromDate = Carbon::createFromFormat('d/m/Y', $fromDate)->format('Y-m-d');
            $toDate   = Carbon::createFromFormat('d/m/Y', $toDate)->format('Y-m-d');
            $query->whereBetween('fee_detail.created_at', [$fromDate, $toDate]);
        } else {
            $fromDate = Carbon::createFromFormat('d/m/Y', $fromDate)->format('Y-m-d');
            $query->whereDate('fee_detail.created_at', '>=', $fromDate);
        }
        return $query->get()->toArray();
    }

    //get student total paid amount
    public function getTotalPaidAmountByStudentId($studentId)
    {
        return $this->studentPaymentModel->where('student_id', $studentId)->sum('amount');
    }

    //get student total payable amount
    public function getTotalPayableAmountForStudent($studentId)
    {
        return $this->model->where('student_id', $studentId)->sum('payable_amount');
    }

    public function getTotalDiscountForStudent($studentId)
    {
        return $this->model->where('student_id', $studentId)->sum('discount_amount');
    }

    public function generateMonthlyTuitionFeeForAllStudents()
    {
        $students    = $this->student->where('status', 1)->get();
        $allPayments = [];

        if (!empty($students)) {
            foreach ($students as $key => $student) {
                $sessionDetail = $student->session->sessionDetails->filter(function ($item) use ($student) {
                    return $item->course_id == $student->course_id;
                })->first();

                $now = Carbon::now();

                $payments = $this->paymentDetailService->getPaymentsByStudentCategoryIdAndTypes($student->student_category_id, $student->session_id, $student->course_id, [
                    3, 4, 5, 6
                ]);

                if ($now->month == 1) {
                    $billYear  = $now->year - 1;
                    $billMonth = 12;
                } else {
                    $billYear  = $now->year;
                    $billMonth = $now->month - 1;
                }

                if ($student->student_category_id == 1) {
                    //tuition fee
                    $allPayments[$key][0] = [
                        'student_id'           => $student->id,
                        'payment_type_id'      => 3,
                        'payable_amount'       => $sessionDetail['tuition_fee_local'],
                        'last_date_of_payment' => Carbon::create($billYear, $billMonth + 1, 1)->addDays(9)->format('Y-m-d'),
                        'bill_year'            => $billYear,
                        'bill_month'           => $billMonth,
                        'status'               => 0
                    ];

                    //re-admission fee fee
                    $check = $this->studentFeeDetail->whereHas('fee', function ($q) use ($student) {
                        $q->where('student_id', $student->id);
                    })->whereIn('payment_type_id', [
                        3, 5, 6
                    ])->where('status', '!=', 1)->groupBy('bill_year')->groupBy('bill_month')->get();

                    if (count($check->toArray()) == 3) {
                        $reAdmissionFee = $payments->filter(function ($item) {
                            return ($item->payment_type_id == 6);
                        })->first()->amount;

                        $allPayments[$key][1] = [
                            'student_id'           => $student->id,
                            'payment_type_id'      => 6,
                            'payable_amount'       => $reAdmissionFee,
                            'last_date_of_payment' => Carbon::create($billYear, $billMonth + 1, 1)->addDays(9)->format('Y-m-d'),
                            'bill_year'            => $billYear,
                            'bill_month'           => $billMonth,
                            'status'               => 0
                        ];
                    }
                }
            }
        }
        return $this->saveStudentFees($allPayments);
    }

    public function saveStudentFees($data)
    {
        $processStatus  = false;
        $studentPayment = [];

        DB::beginTransaction();

        foreach ($data as $row) {
            $studentId = collect($row)->first()['student_id'];
            $amountSum = collect($row)->sum('payable_amount');
            $billYear  = collect($row)->first()['bill_year'];
            $billMonth = collect($row)->first()['bill_month'];

            $studentPayment = $this->model->create([
                'student_id'      => $studentId,
                'title'           => 'Tuition fee of ' . Carbon::create($billYear, $billMonth, 1)->format('F, Y'),
                'total_amount'    => $amountSum,
                'discount_amount' => 0,
                'payable_amount'  => $amountSum,
                'due_amount'      => $amountSum,
                'status'          => 0,
            ]);

            $paymentDetail = [];
            foreach ($row as $key => $item) {
                $paymentDetail[$key] = [
                    'payment_type_id'      => $item['payment_type_id'],
                    'total_amount'         => $item['payable_amount'],
                    'discount_amount'      => 0,
                    'payable_amount'       => $item['payable_amount'],
                    'due_amount'           => $item['payable_amount'],
                    'last_date_of_payment' => Carbon::parse($item['last_date_of_payment'])->format('d/m/Y'),
                    'bill_year'            => $billYear,
                    'bill_month'           => $billMonth,
                    'status'               => $item['status'],
                ];
            }

            $studentPayment->feeDetails()->createMany($paymentDetail);
            if (!empty($studentPayment->feeDetails->toArray())) {
                $processStatus = true;
            }

            if ($processStatus) {
                $this->cronLogService->create([
                    'student_id' => $studentId,
                    'type'       => 'monthly_tuition_fee',
                    'bill_year'  => Carbon::parse($item['last_date_of_payment'])->year,
                    'bill_month' => Carbon::parse($item['last_date_of_payment'])->month,
                    'message'    => 'Tuition fee generated successfully',
                    'status'     => 1,
                ]);
            } else {
                $this->cronLogService->create([
                    'student_id' => $studentId,
                    'type'       => 'monthly_tuition_fee',
                    'bill_year'  => $billYear,
                    'bill_month' => $billMonth,
                    'message'    => 'Problem in generating tuition fee',
                    'status'     => 0
                ]);
            }
        }

        DB::commit();

        return $studentPayment;
    }

    public function generateMonthlyLateForAllStudents()
    {
        $generatelateFees = $this->studentFeeDetail->where('payment_type_id', 5)->pluck('student_fee_id');

        $fees = $this->studentFeeDetail->where([
            ['payment_type_id', '=', 3],
            ['status', '<>', '1'],
        ])->whereNotIn('student_fee_id', $generatelateFees)
                                       ->with(['fee'])->get();

        $processStatus = false;
        foreach ($fees as $fee) {
            $billingMonth = Carbon::create($fee->bill_year, $fee->bill_month, 1);
            if ($billingMonth->diffInMonths(now()) >= 2) {
                $billYear  = $fee->bill_year;
                $billMonth = $fee->bill_month;

                $student = $fee->fee->student;
                $payment = $this->paymentDetailService->getPaymentsByStudentCategoryIdAndTypes($student->student_category_id, $student->session_id, $student->course_id, [5])->first();
                DB::beginTransaction();
                if (!empty($payment->amount)) {
                    $feeDetail = $this->studentFeeDetail->create([
                        'student_fee_id'       => $fee->student_fee_id,
                        'payment_type_id'      => 5,
                        'total_amount'         => $payment->amount,
                        'discount_amount'      => 0,
                        'payable_amount'       => $payment->amount,
                        'due_amount'           => $payment->amount,
                        'last_date_of_payment' => $fee->last_date_of_payment,
                        'bill_year'            => $billYear,
                        'bill_month'           => $billMonth,
                    ]);

                    $processStatus = $feeDetail->fee()->update([
                        'total_amount'    => $fee->fee->total_amount + $payment->amount,
                        'discount_amount' => 0,
                        'payable_amount'  => $fee->fee->payable_amount + $payment->amount,
                        'due_amount'      => $fee->fee->due_amount + $payment->amount,
                    ], $fee->student_fee_id);

                    if ($processStatus) {
                        $this->cronLogService->create([
                            'student_id' => $student->id,
                            'type'       => 'monthly_late_fee',
                            'bill_year'  => $billYear,
                            'bill_month' => $billMonth,
                            'message'    => 'Late fee generated successfully',
                            'status'     => 1,
                        ]);
                    } else {
                        $this->cronLogService->create([
                            'student_id' => $student->id,
                            'type'       => 'monthly_late_fee',
                            'bill_year'  => $billYear,
                            'bill_month' => $billMonth,
                            'message'    => 'Problem in generating late fee',
                            'status'     => 0
                        ]);
                    }
                }
                DB::commit();
            }
        }

        return $processStatus;
    }

    public function generateStudentPaymentWhenCreditAvailable()
    {
        $students = $this->student->where('status', 1)->get();

        foreach ($students as $key => $student) {
            $totalDevelopmentAmount = $this->studentPaymentModel->where([
                ['student_id', '=', $student->id],
                ['payment_type_id', '=', 1]
            ])->sum('available_amount');

            $totalTuitionAmount = $this->studentPaymentModel->where([
                ['student_id', '=', $student->id],
                ['payment_type_id', '=', 3]
            ])->sum('available_amount');

            if ($totalDevelopmentAmount > 0) {
                $this->_processStudentPayments($student, 1);
            }

            if ($totalTuitionAmount > 0) {
                $this->_processStudentPayments($student, 3);
            }

            // update student credit
            event(new UpdateStudentCredit($student->id));
        }
    }

    private function _processStudentPayments($student, $paymentTypeId)
    {
        $payments = $this->studentPaymentModel->where('student_id', $student->id)->where('payment_type_id', $paymentTypeId)->where('available_amount', '>', 0)->get();

        foreach ($payments as $payment) {
            if ($payment->available_amount > 0) {
                $availableAmount = $payment->available_amount;
                $status          = 2;

                $allFees = $this->studentFeeDetail->whereHas('fee', function ($q) use ($student) {
                    $q->where('student_id', $student->id);
                })->where('payment_type_id', $paymentTypeId)->where('status', '<>', 1)->orderBy('last_date_of_payment', 'ASC')->with('fee')->get();

                if (!empty($allFees->toArray())) {
                    foreach ($allFees as $fee) {
                        if ($availableAmount > 0) {
                            if ($fee->due_amount <= $availableAmount) {
                                $payable = $fee->due_amount;
                                $status  = 1;
                            } else {
                                $payable = $availableAmount;
                            }
                            $availableAmount = $availableAmount - $fee->due_amount;

                            $payment->studentPaymentDetails()->create([
                                'student_fee_id'        => $fee->student_fee_id,
                                'student_fee_detail_id' => $fee->id,
                                'amount'                => $payable,
                                'status'                => 1,
                            ]);

                            $this->advanceAmountUseHistories->create([
                                'student_id'            => $student->id,
                                'student_fee_detail_id' => $fee->id,
                                'from_payment_type_id'  => $payment->payment_type_id,
                                'to_payment_type_id'    => $payment->payment_type_id,
                                'amount'                => $payable,
                            ]);

                            $payment->available_amount = ($payment->available_amount - $payable);
                            $payment->save();

                            $fee->due_amount = ($fee->due_amount - $payable);
                            $fee->status     = $status;
                            $fee->save();

                            $fee->fee->paid_amount = ($fee->fee->paid_amount + $payable);
                            $fee->fee->due_amount  = ($fee->fee->due_amount - $payable);

                            $checkStatus = $this->studentFeeDetail->where('student_fee_id', $fee->student_fee_id)->where('status', '<>', 1)->count();

                            if (empty($checkStatus)) {
                                $fee->fee->status = 1;
                            } else {
                                $fee->fee->status = 2;
                            }
                            $fee->fee->save();
                        }
                    }
                }
            }
        }
    }

    public function getStudentAvailableCreditByStudentId($studentId)
    {
        $totalDevelopmentAmount = $this->studentPaymentModel->where([
            ['student_id', '=', $studentId],
            ['payment_type_id', '=', 1]
        ])->sum('available_amount');

        $totalTuitionAmount = $this->studentPaymentModel->where([
            ['student_id', '=', $studentId],
            ['payment_type_id', '=', 3]
        ])->sum('available_amount');

        return [
            'available_development_amount' => $totalDevelopmentAmount, 'available_tuition_amount' => $totalTuitionAmount
        ];
    }

    public function showIndividualStudentFee($id)
    {
        $feeDetail = $this->model->find($id);
        return $feeDetail;
    }

    public function getStudentPaymentsByStudentId($studentId, $paymentStartDate = null, $paymentEndDate = null)
    {
        if ($paymentStartDate == null && $paymentEndDate == null) {
            return $this->studentPaymentModel->where('student_id', $studentId)->orderBy('payment_date', 'desc')->where('advance_used', '!=', 1)->paginate(10);
        }

        if ($paymentStartDate == !null && $paymentEndDate == !null) {
            //change date format as in database
            $paymentStartDate = Carbon::createFromFormat('d/m/Y', $paymentStartDate)->format('Y-m-d');
            $paymentEndDate   = Carbon::createFromFormat('d/m/Y', $paymentEndDate)->format('Y-m-d');
            return $this->studentPaymentModel->where('student_id', $studentId)->whereBetween('payment_date', [
                $paymentStartDate, $paymentEndDate
            ])->where('advance_used', '!=', 1)->orderBy('payment_date', 'desc')->paginate(10);
        }

        if ($paymentStartDate == !null) {
            //change date format as in database
            $paymentStartDate = Carbon::createFromFormat('d/m/Y', $paymentStartDate)->format('Y-m-d');
            return $this->studentPaymentModel->where('student_id', $studentId)->where('payment_date', '>=', $paymentStartDate)->where('advance_used', '!=', 1)->orderBy('payment_date', 'desc')->paginate(10);
        }

        return $this->studentPaymentModel->where('student_id', $studentId)->where('advance_used', '!=', 1)->orderBy('payment_date', 'desc')->paginate(10);
    }

    public function getStudentPaymentsByStudentIdInvoice($studentId, $paymentStartDate = null, $paymentEndDate = null)
    {
        if ($paymentStartDate == null and $paymentEndDate == null) {
            $data = $this->studentPaymentModel->select(
                'student_payments.*',
                DB::raw('SUM(student_payments.amount) AS totalamount')
            )
                                              ->where('student_id', $studentId)->orderBy('invoice_no', 'desc')->groupBy('invoice_no')->paginate(10);
            return $data;
        } elseif ($paymentStartDate == !null and $paymentEndDate == !null) {
            //change date format as in database
            $paymentStartDate = Carbon::createFromFormat('d/m/Y', $paymentStartDate)->format('Y-m-d');
            $paymentEndDate   = Carbon::createFromFormat('d/m/Y', $paymentEndDate)->format('Y-m-d');
            return $this->studentPaymentModel->select(
                'student_payments.*',
                DB::raw('SUM(student_payments.amount) AS totalamount')
            )
                                             ->where('student_id', $studentId)->whereBetween('payment_date', [
                    $paymentStartDate, $paymentEndDate
                ])->orderBy('invoice_no', 'desc')->groupBy('invoice_no')->paginate(10);
        } elseif ($paymentStartDate == !null) {
            //change date format as in database
            $paymentStartDate = Carbon::createFromFormat('d/m/Y', $paymentStartDate)->format('Y-m-d');
            return $this->studentPaymentModel->select(
                'student_payments.*',
                DB::raw('SUM(student_payments.amount) AS totalamount')
            )
                                             ->where('student_id', $studentId)->where('payment_date', '>=', $paymentStartDate)->orderBy('invoice_no', 'desc')->groupBy('invoice_no')->paginate(10);
        } else {
            $data = $this->studentPaymentModel->select(
                'student_payments.*',
                DB::raw('SUM(student_payments.amount) AS totalamount')
            )
                                              ->where('student_id', $studentId)->orderBy('invoice_no', 'desc')->groupBy('invoice_no')->paginate(10);
            return $data;
        }
    }

    public function getStdPaymentById($invoiceNo)
    {
        $data    = [];
        $data1   = $this->studentPaymentModel->where('invoice_no', $invoiceNo)->first();
        $payment = $this->studentPaymentModel->where('invoice_no', $invoiceNo)->get();
        if (!empty($payment)) {
            foreach ($payment as $value) {
                $data[] = [
                    'payment_type_id'              => $value->payment_type_id,
                    'total_due'                    => $value->due_amount,
                    'total_amount'                 => $value->amount,
                    'single_total_discount_amount' => $value->discount_amount,
                    'avilable_amount'              => $value->available_amount,
                    'payment_type_title'           => $value->paymentType->title,
                ];
            }
        }
        return [
            'info'     => $data1,
            'payments' => $data
        ];
    }

    public function getStudentPaymentById($invoiceNo)
    {
        $data1     = $this->studentPaymentModel->where('invoice_no', $invoiceNo)->first();
        $studentId = $data1->student_id;
        $data      = [];
        $result    = DB::table('student_fees')
                       ->select('students.roll_no', 'payment_types.title', 'student_fee_details.payment_type_id', \DB::raw('SUM(student_fee_details.discount_amount) as total_discount_amount'), \DB::raw('SUM(student_fee_details.due_amount) as total_due_amount'))
                       ->join('student_fee_details', 'student_fee_details.student_fee_id', '=', 'student_fees.id')
                       ->join('students', 'students.id', '=', 'student_fees.student_id')
                       ->join('payment_types', 'payment_types.id', '=', 'student_fee_details.payment_type_id')
                       ->where('student_fees.student_id', $studentId)
                       ->groupBy('student_fee_details.payment_type_id')
            //->where(['something' => 'something', 'otherThing' => 'otherThing'])
                       ->get();
        if (!empty($result)) {
            foreach ($result as $value) {
                $result2 = StudentPayment::select(\DB::raw('SUM(amount) as total_amount'), \DB::raw('SUM(discount_amount) as single_total_discount_amount'), \DB::raw('SUM(available_amount) as total_available_amount'))
                                         ->where('student_id', $studentId)
                                         ->where('payment_type_id', $value->payment_type_id)
                                         ->first();

                if ($value->total_due_amount == 0) {
                    $total_due = $result2->single_total_discount_amount - $result2->total_available_amount;
                } else {
                    $total_due = $value->total_due_amount - $value->total_discount_amount - $result2->single_total_discount_amount - $result2->total_available_amount;
                }

                $data[] = [
                    'roll_no'                      => $value->roll_no,
                    'payment_type_id'              => $value->payment_type_id,
                    'total_due_amount'             => $value->total_due_amount,
                    'total_amount'                 => $result2->total_amount,
                    'total_discount_amount'        => $value->total_discount_amount,
                    'total_available_amount'       => $result2->total_available_amount,
                    'single_total_discount_amount' => $result2->single_total_discount_amount,
                    'payment_type_title'           => $value->title,
                    'total_due'                    => $total_due,
                ];
            }
        }

        return [
            'info'     => $data1,
            'payments' => $data
        ];
    }

    public function updateStudentPayment($request, $id)
    {
        $studentPayment = $this->studentPaymentModel->where('invoice_no', $id)->firstOrFail();

        $bankCopy = $studentPayment->bank_copy; // default to old file

        if ($request->hasFile('bank_copy')) {
            $file     = $request->file('bank_copy');
            $fileName = Carbon::now()->format('Y-m-d') . '_' . uniqid() . '_' . $file->getClientOriginalName();

            $destination = 'nemc_files/payment';
            if (!file_exists($destination)) {
                mkdir($destination, 0777, true);
            }

            $file->move($destination, $fileName);
            $bankCopy = $fileName;
        }

        $discountAmount = is_numeric($request->discount_amount) ? (float)$request->discount_amount : 0;
        $amount         = is_numeric($request->amount) ? (float)$request->amount : 0;
        $dueAmount      = (float)$studentPayment->due_amount;

        $availableAmount = ($amount > $dueAmount)
            ? $amount - $dueAmount - $discountAmount
            : 0;

        $studentPayment->update([
            'payment_method_id' => $request->payment_method_id,
            'bank_id'           => checkEmpty($request->bank_id),
            'bank_copy'         => checkEmpty($bankCopy),
            'payment_date'      => $request->payment_date,
            'discount_amount'   => $discountAmount,
            'amount'            => $amount,
            'available_amount'  => $availableAmount,
            'remarks'           => $request->remarks,
        ]);

        event(new UpdateStudentCredit($studentPayment->student_id));

        return $studentPayment;
    }

    public function updateStudentFeeAndFeeDetail($request, $id)
    {
        $studentFee = $this->model->find($id);
        if ($request->request_discount_amount <= $studentFee->payable_amount) {
            $studentFeeDetails  = $studentFee->feeDetails->where('status', '!=', 1)->sortByDesc('total_amount');
            $studentFeeDiscount = $request->request_discount_amount;

            //work on discount application file
            if ($request->hasFile('discount_application_file')) {
                $file = $request->file('discount_application_file');
                //$currentDate = Carbon::now()->toDateString();
                $fileName = Carbon::now()->toDateString() . '_' . uniqid() . '_' . $file->getClientOriginalName();
                // create folder
                if (!file_exists('nemc_files/payment')) {
                    mkdir('nemc_files/payment', 0777, true);
                }
                //move file to folder
                $file->move('nemc_files/payment', $fileName);
            }
            DB::beginTransaction();

            foreach ($studentFeeDetails as $studentFeeDetail) {
                if ($studentFeeDiscount > 0) {
                    $payableAmount = $studentFeeDetail->payable_amount;

                    if ($studentFeeDetail->payable_amount >= $studentFeeDiscount) {
                        $studentFeeDetail->payable_amount  = $studentFeeDetail->payable_amount - $studentFeeDiscount;
                        $studentFeeDetail->discount_amount = $studentFeeDetail->discount_amount + $studentFeeDiscount;
                        $studentFeeDetail->due_amount      = $studentFeeDetail->payable_amount;
                        if ($payableAmount == $studentFeeDiscount) {
                            $studentFeeDetail->status = 1;
                        } else {
                            $studentFeeDetail->status = 2;
                        }
                        $remainingDiscount = 0;
                    } else {
                        $studentFeeDetail->payable_amount  = 0;
                        $studentFeeDetail->discount_amount = $studentFeeDetail->discount_amount + $studentFeeDetail->total_amount;
                        $studentFeeDetail->due_amount      = $studentFeeDetail->payable_amount;
                        $studentFeeDetail->status          = 1;
                        $remainingDiscount                 = $studentFeeDiscount - $studentFeeDetail->total_amount;
                    }
                    $studentFeeDiscount                     = $remainingDiscount;
                    $studentFeeDetail->discount_application = 'nemc_files/payment/' . $fileName;
                    $studentFeeDetail->save();
                }
            }

            //get discount, payable and due amount sum after discount from student fee detail table
            $feeTableAmount = $this->studentFeeDetail->where('student_fee_id', $studentFee->id)
                                                     ->select(
                                                         DB::raw('SUM(discount_amount) AS discount_amount'),
                                                         DB::raw('SUM(payable_amount) AS payable_amount'),
                                                         DB::raw('SUM(due_amount) AS due_amount')
                                                     )
                                                     ->first();

            //if discount and payable amount is same then make status 1
            if ($studentFee->payable_amount == $feeTableAmount->discount_amount) {
                $request['status'] = 1;
            } else {
                $request['status'] = $studentFee->status;
            }

            //update fee data to student fee table by above data
            $studentFee->update([
                'discount_amount'      => $feeTableAmount->discount_amount,
                'payable_amount'       => $feeTableAmount->payable_amount,
                'due_amount'           => $feeTableAmount->due_amount,
                'discount_application' => $request->discount_application,
                'status'               => $request->status,
                'remarks'              => $request->remarks,
            ]);

            DB::commit();
        }
        return $studentFee;
    }

    public function adjustStudentFeeAndFeeDetail($request, $id)
    {
        $studentFee = $this->model->find($id);
        try {
            // Check if the request adjust amount is valid
            if ($request->request_adjust_amount <= $studentFee->due_amount) {
                DB::beginTransaction();

                // Upload File if exists
                $fileName = null;
                if ($request->hasFile('adjustment_application_file')) {
                    $file     = $request->file('adjustment_application_file');
                    $fileName = Carbon::now()->toDateString() . '_' . uniqid() . '_' . $file->getClientOriginalName();

                    // Create folder if doesn't exist
                    if (!file_exists('nemc_files/payment')) {
                        mkdir('nemc_files/payment', 0777, true);
                    }
                    $file->move('nemc_files/payment', $fileName);
                }

                // History + Deletion of Related FeeDetails (status != 1)
                $deletableDetails = $studentFee->feeDetails()
                                               ->whereIn('payment_type_id', $request->payment_type_id)
                                               ->where('status', '!=', 1)
                                               ->get();

                if ($deletableDetails->isNotEmpty()) {
                    $historyData = $deletableDetails->map(function ($detail) use ($request) {
                        return [
                            'student_fee_detail_id' => $detail->id,
                            'student_fee_id'        => $detail->student_fee_id,
                            'payment_type_id'       => $detail->payment_type_id,
                            'total_amount'          => $detail->total_amount,
                            'payable_amount'        => $detail->payable_amount,
                            'discount_amount'       => $detail->discount_amount,
                            'due_amount'            => $detail->due_amount,
                            'status'                => $detail->status,
                            'adjust_reason'         => $request->remarks ?? 'Adjustment Delete',
                            'adjust_by'             => auth()->id(),
                            'created_at'            => now(),
                            'updated_at'            => now(),
                        ];
                    })->toArray();

                    // Insert into history table
                    DB::table('student_fee_adjust_histories')->insert($historyData);

                    // Delete the fee details
                    $this->studentFeeDetail
                        ->whereIn('id', $deletableDetails->pluck('id'))
                        ->delete();
                }

                // Recalculate and Update Fee
                $remainingDetails = $this->studentFeeDetail
                    ->where('student_fee_id', $studentFee->id);

                // Determine student_fee.status based on feeDetails.status
                $statuses = $remainingDetails->pluck('status')->unique()->sort()->values();
                $amounts  = $remainingDetails
                    ->selectRaw('SUM(discount_amount) as discount_amount, SUM(payable_amount) as payable_amount, SUM(due_amount) as due_amount')
                    ->first();

                if ($statuses->count() === 1) {
                    $feeStatus = $statuses[0];
                } else {
                    $feeStatus = 2;
                }

                // Update the student fee record
                $studentFee->update([
                    'discount_amount'      => $amounts->discount_amount ?? 0,
                    'payable_amount'       => $amounts->payable_amount ?? 0,
                    'due_amount'           => $amounts->due_amount ?? 0,
                    'status'               => $feeStatus,
                    'discount_application' => $fileName ? $fileName : $studentFee->discount_application,
                    'remarks'              => $request->remarks,
                ]);

                DB::commit();
            } else {
                throw new Exception('Adjustment amount cannot be greater than the due amount.');
            }

            return $studentFee;
        } catch (Exception $e) {
            DB::rollBack();

            // Handle errors and throw exception with message
            throw new Exception('Transaction failed: ' . $e->getMessage());
        }
    }

    //find student development fee installment
    public function getStudentSingleInstallmentFee($id)
    {
        return $this->studentFeeDetail->find($id);
    }

    //update student development fee installment
    public function updateStudentSingleInstallmentFee($request, $id)
    {
        $singleInstallment = $this->studentFeeDetail->find($id);
        if ($request->hasFile('discount_application_file')) {
            //accept file from file type field
            $file = $request->file('discount_application_file');
            //create name for file
            $fileName = Carbon::now()->toDateString() . '_' . uniqid() . '_' . $file->getClientOriginalName();

            //if directory not exist make directory
            if (!file_exists('nemc_files/payment')) {
                mkdir('nemc_files/payment', 0777, true);
            }
            //move file to directory
            $file->move('nemc_files/payment', $fileName);
        }
        DB::beginTransaction();
        if ($singleInstallment->payable_amount >= $request->request_discount_amount) {
            //update detail table for development installment
            $singleInstallment->discount_amount      = $singleInstallment->discount_amount + $request->request_discount_amount;
            $singleInstallment->payable_amount       = $singleInstallment->payable_amount - $request->request_discount_amount;
            $singleInstallment->due_amount           = $singleInstallment->payable_amount;
            $singleInstallment->discount_application = $request->discount_application;
            $singleInstallment->remarks              = $request->remarks;
            $singleInstallment->last_date_of_payment = !empty($request->last_date_of_payment) ? $request->last_date_of_payment : $singleInstallment->last_date_of_payment;

            if ($singleInstallment->due_amount == 0) {
                $singleInstallment->status = 1;
            } else {
                $singleInstallment->status = $singleInstallment->status;
            }
            $singleInstallment->discount_application = 'nemc_files/payment/' . $fileName;
            $singleInstallment->save();

            // get sum of amounts from student fee details
            $feeTableInstallmentAmount = $this->studentFeeDetail->where('student_fee_id', $singleInstallment->student_fee_id)->where('payment_type_id', $singleInstallment->payment_type_id)
                                                                ->select(
                                                                    DB::raw('SUM(discount_amount) AS discount_amount'),
                                                                    DB::raw('SUM(payable_amount) AS payable_amount'),
                                                                    DB::raw('SUM(due_amount) AS due_amount')
                                                                )
                                                                ->first();

            //update student fee table by above data
            $singleInstallment->fee()->update([
                'discount_amount' => $feeTableInstallmentAmount->discount_amount,
                'payable_amount'  => $feeTableInstallmentAmount->payable_amount,
                'due_amount'      => $feeTableInstallmentAmount->due_amount,
            ]);

            DB::commit();
        }
        return $singleInstallment;
    }

    public function showIndividualStudentPayment($id)
    {
        return $this->studentPaymentModel->find($id);
    }

    //process student student tuition fee data
    public function studentTuitionFeeInfo($request)
    {
        $student = $this->student->find($request->student_id);

        //count total bill month
        //take 1st date of selected date from date picker
        $fromDate = Carbon::parse(Carbon::createFromFormat('d/m/Y', $request->bill_month_from)->format('Y-m-01'));
        //take last date of selected date from date picker
        if ($request->bill_month_to != null) {
            $toDate = Carbon::parse(Carbon::createFromFormat('d/m/Y', $request->bill_month_to)->format('Y-m-t'));
        } //when bill_month_to is empty then take 1st tuition fee year and month then create bill month to
        else {
            $studentId       = $student->id;
            $toDateMonthYear = $this->studentFeeDetail->where('payment_type_id', 3)
                                                      ->whereHas('fee', function ($query) use ($studentId) {
                                                          $query->where('student_id', $studentId);
                                                      })->first();

            $toDate = Carbon::createFromFormat('Y-m', $toDateMonthYear->bill_year . '-' . $toDateMonthYear->bill_month)->subMonth(1)->endOfMonth();
        }

        $diffInMonths = $fromDate->diffInMonths($toDate);
        $totalMonth   = $diffInMonths + 1;
        $nextMonth    = 0;

        $allPayments = [];

        for ($i = 1; $i <= $totalMonth; $i++) {
            $sessionDetail = $student->session->sessionDetails->filter(function ($item) use ($student) {
                return $item->course_id == $student->course_id;
            })->first();

            //get payment type details
            $payments  = $this->paymentDetailService->getPaymentsByStudentCategoryIdAndTypes($student->student_category_id, $student->session_id, $student->course_id, [
                3, 4, 5, 6
            ]);
            $billYear  = $fromDate->year;
            $billMonth = $fromDate->month + $nextMonth;

            //when to date select from next year
            if ($billMonth > 12) {
                $billYear  = Carbon::parse(Carbon::create($billYear, $billMonth + 1, 1)->addDays(9)->format('Y-m-d'))->year;
                $billMonth = Carbon::parse(Carbon::create($billYear, $billMonth + 1, 1)->addDays(9)->format('Y-m-d'))->month - 1;
            }

            //gather all fees to an array
            if ($student->student_category_id == 1) {
                //tuition fee
                $allPayments[$i][0] = [
                    'student_id'           => $student->id,
                    'payment_type_id'      => 3,
                    'payable_amount'       => $sessionDetail['tuition_fee_local'],
                    'last_date_of_payment' => Carbon::create($billYear, $billMonth + 1, 1)->addDays(9)->format('Y-m-d'),
                    'bill_year'            => $billYear,
                    'bill_month'           => $billMonth,
                    'status'               => 0
                ];

                //re-admission fee fee
                $check = $this->studentFeeDetail->whereHas('fee', function ($q) use ($student) {
                    $q->where('student_id', $student->id);
                })->whereIn('payment_type_id', [
                    3, 5, 6
                ])->where('status', '!=', 1)->groupBy('bill_year')->groupBy('bill_month')->get();

                if (count($check->toArray()) >= 3) {
                    $reAdmissionFee = $payments->filter(function ($item) {
                        return ($item->payment_type_id == 6);
                    })->first()->amount;

                    $allPayments[$i][1] = [
                        'student_id'           => $student->id,
                        'payment_type_id'      => 6,
                        'payable_amount'       => $reAdmissionFee,
                        'last_date_of_payment' => Carbon::create($billYear, $billMonth + 1, 1)->addDays(9)->format('Y-m-d'),
                        'bill_year'            => $billYear,
                        'bill_month'           => $billMonth,
                        'status'               => 0
                    ];
                }
            }
            $nextMonth++;
        }

        return $this->saveStudentFees($allPayments);
    }

    public function studentRollNumber($request)
    {
        return $this->student->find($request->studentId)->roll_no;
    }

    public function checkStudentTuitionFeeGeneratedForMonthTo($request)
    {
        $studentId         = $request->student_id;
        $tuitionFeeMonthTo = $this->studentFeeDetail->where('payment_type_id', 3)->orderBy('bill_year')->orderBy('bill_month')
                                                    ->whereHas('fee', function ($query) use ($studentId) {
                                                        $query->where('student_id', $studentId);
                                                    })->get()->first();
        $requestToDate     = Carbon::parse(Carbon::createFromFormat('d/m/Y', $request->billMonthTo)->format('Y-m-t'));
        $paidToDate        = Carbon::parse(Carbon::createFromFormat('Y-m', $tuitionFeeMonthTo->bill_year . '-' . $tuitionFeeMonthTo->bill_month)->format('Y-m-t'));
        if ($requestToDate >= $paidToDate) {
            $value = 0;
        } else {
            $value = 1;
        }
        return $value;
    }

    //total development fee of BD students
    public function getTotalDevelopmentFeeOfBdBySessionIdAndCourseIds($sessionId, $courseIds)
    {
        return $this->studentFeeDetail->where('payment_type_id', 1)->whereHas('fee.student', function ($q) use ($sessionId, $courseIds) {
            $q->where('session_id', $sessionId)->where('student_category_id', '<>', 2)->whereIn('course_id', [$courseIds]);
        })->sum('total_amount');
    }

    //total development fee of foreign students
    public function getTotalDevelopmentFeeOfForeignBySessionIdAndCourseIds($sessionId, $courseIds)
    {
        return $this->studentFeeDetail->where('payment_type_id', 1)->whereHas('fee.student', function ($q) use ($sessionId, $courseIds) {
            $q->where('session_id', $sessionId)->where('student_category_id', 2)->whereIn('course_id', [$courseIds]);
        })->sum('total_amount');
    }

    //total tuition fee of BD students
    public function getTotalTuitionFeeOfBdBySessionIdAndCourseIds($sessionId, $courseIds)
    {
        return $this->studentFeeDetail->where('payment_type_id', 3)->whereHas('fee.student', function ($q) use ($sessionId, $courseIds) {
            $q->where('session_id', $sessionId)->where('student_category_id', '<>', 2)->whereIn('course_id', [$courseIds]);
        })->sum('total_amount');
    }

    //total tuition fee of foreign students
    public function getTotalTuitionFeeOfForeignBySessionIdAndCourseIds($sessionId, $courseIds)
    {
        return $this->studentFeeDetail->where('payment_type_id', 3)->whereHas('fee.student', function ($q) use ($sessionId, $courseIds) {
            $q->where('session_id', $sessionId)->where('student_category_id', 2)->whereIn('course_id', [$courseIds]);
        })->sum('total_amount');
    }

    //total readmission fee of BD students
    public function getTotalReadmissionFeeOfBdBySessionIdAndCourseIds($sessionId, $courseIds)
    {
        return $this->studentFeeDetail->where('payment_type_id', 6)->whereHas('fee.student', function ($q) use ($sessionId, $courseIds) {
            $q->where('session_id', $sessionId)->where('student_category_id', '<>', 2)->whereIn('course_id', [$courseIds]);
        })->sum('total_amount');
    }

    //total readmission fee of Foreign students
    public function getTotalReadmissionFeeOfForeignBySessionIdAndCourseIds($sessionId, $courseIds)
    {
        return $this->studentFeeDetail->where('payment_type_id', 6)->whereHas('fee.student', function ($q) use ($sessionId, $courseIds) {
            $q->where('session_id', $sessionId)->where('student_category_id', 2)->whereIn('course_id', [$courseIds]);
        })->sum('total_amount');
    }

    //total class absent fee of BD students
    public function getTotalAbsentFeeOfBdBySessionIdAndCourseIds($sessionId, $courseIds)
    {
        return $this->studentFeeDetail->where('payment_type_id', 4)->whereHas('fee.student', function ($q) use ($sessionId, $courseIds) {
            $q->where('session_id', $sessionId)->where('student_category_id', '<>', 2)->whereIn('course_id', [$courseIds]);
        })->sum('total_amount');
    }

    //total class absent fee of Foreign students
    public function getTotalAbsentFeeOfForeignBySessionIdAndCourseIds($sessionId, $courseIds)
    {
        return $this->studentFeeDetail->where('payment_type_id', 4)->whereHas('fee.student', function ($q) use ($sessionId, $courseIds) {
            $q->where('session_id', $sessionId)->where('student_category_id', 2)->whereIn('course_id', [$courseIds]);
        })->sum('total_amount');
    }

    //get student fee amount by payment type id for BD students
    public function getTotalFeeAmountBySessionIdCourseIdPhaseIdAndPaymentTypeId($request, $paymentTypeId)
    {
        if ($request->filled('course_id')) {
            $courseIds = $request->course_id;
        } else {
            $courseIds = $this->courseModel->pluck('id');
        }
        return $this->studentFeeDetail->where('payment_type_id', $paymentTypeId)->whereHas('fee.student', function ($q) use ($request, $courseIds) {
            $q->where('session_id', $request->session_id)->where('phase_id', $request->phase_id)->where('student_category_id', '<>', 2)
              ->whereIn('course_id', [$courseIds]);
        })->sum('payable_amount');
    }

    //get student payment(paid) amount by payment type id for BD students
    public function getTotalPaidAmountBySessionIdCourseIdPhaseIdAndPaymentTypeId($request, $paymentTypeId)
    {
        if ($request->filled('course_id')) {
            $courseIds = $request->course_id;
        } else {
            $courseIds = $this->courseModel->pluck('id');
        }
        return $this->studentPaymentModel->where('payment_type_id', $paymentTypeId)->where('status', 1)->whereHas('student', function ($q) use ($request, $courseIds) {
            $q->where('session_id', $request->session_id)->where('phase_id', $request->phase_id)->where('student_category_id', '<>', 2)
              ->whereIn('course_id', [$courseIds]);
        })->sum('amount');
    }

    //get student fee amount by payment type id for foreign students
    public function getTotalForeignFeeAmountBySessionIdCourseIdPhaseIdAndPaymentTypeId($request, $paymentTypeId)
    {
        if ($request->filled('course_id')) {
            $courseIds = $request->course_id;
        } else {
            $courseIds = $this->courseModel->pluck('id');
        }
        return $this->studentFeeDetail->where('payment_type_id', $paymentTypeId)->whereHas('fee.student', function ($q) use ($request, $courseIds) {
            $q->where('session_id', $request->session_id)->where('phase_id', $request->phase_id)->where('student_category_id', 2)
              ->whereIn('course_id', [$courseIds]);
        })->sum('payable_amount');
    }

    //get student payment(paid) amount by payment type id for foreign students
    public function getTotalPaidAmountBySessionIdCourseIdPhaseIdAndPaymentTypeIdForForeignStudents($request, $paymentTypeId)
    {
        if ($request->filled('course_id')) {
            $courseIds = $request->course_id;
        } else {
            $courseIds = $this->courseModel->pluck('id');
        }
        return $this->studentPaymentModel->where('payment_type_id', $paymentTypeId)->where('status', 1)->whereHas('student', function ($q) use ($request, $courseIds) {
            $q->where('session_id', $request->session_id)->where('phase_id', $request->phase_id)->where('student_category_id', 2)
              ->whereIn('course_id', [$courseIds]);
        })->sum('amount');
    }

    /*return $this->studentFeeDetail->where('payment_type_id', 1)->whereHas('fee.student', function ($q) use ($sessionId, $courseIds){
                $q->where('session_id', $sessionId)->where('student_category_id', '<>', 2)->whereIn('course_id', [$courseIds]);
            })->sum('total_amount');*/

    public function getAllFeeAmountSumBySessionAndCourseId($sessionId, $courseId, $studentCategory)
    {
        $paymentTypes = $this->paymentTypeModel->where('status', 1)->pluck('id');
        $amount       = array();
        if ($studentCategory == 'normal') {
            foreach ($paymentTypes as $paymentType) {
                $amount[] = (int)$this->studentFeeDetail->where('payment_type_id', $paymentType)->whereHas('fee.student', function ($q) use ($sessionId, $courseId) {
                    $q->where('session_id', $sessionId)->where('student_category_id', '<>', 2)->where('course_id', [$courseId]);
                })->sum('total_amount');
            }
        } elseif ($studentCategory == 'foreign') {
            foreach ($paymentTypes as $paymentType) {
                $amount[] = (int)$this->studentFeeDetail->where('payment_type_id', $paymentType)->whereHas('fee.student', function ($q) use ($sessionId, $courseId) {
                    $q->where('session_id', $sessionId)->where('student_category_id', '=', 2)->where('course_id', [$courseId]);
                })->sum('total_amount');
            }
        }

        return json_encode($amount);
    }

    public function showIndividualStudentPaymentInvoicePDF($id)
    {
        //$invoice=  StudentPayment::where('invoice_no', $invoiceNo)->get();
        // return $this->studentPaymentModel->with('student','paymentMethod','bank','paymentType')->find($id);
        $studentInfo = $this->studentPaymentModel->where('invoice_no', $id)->first();
        $invoice     = $this->studentPaymentModel->where('invoice_no', $id)->get();
        return array(
            'studentInfo' => !empty($studentInfo) ? $studentInfo : '',
            'invoice'     => !empty($invoice) ? $invoice : ''
        );
    }

    public function saveBulkPaymentData($request)
    {
        if (!$request->hasFile('payment_file')) {
            return response()->json([
                'message' => 'No file was uploaded',
                'status'  => false
            ]);
        }

        try {
            $file = $request->file('payment_file');
            Excel::import($import = new PaymentBulkImport($this), $file);
            return $import;
        } catch (\Exception $e) {
            Log::error('Payments excel import failed: ' . $e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    public function getStudentsDueBySession($sessionId)
    {
        $students = $this->student
            ->with(['user', 'fee' => fn($q) => $q->whereNull('deleted_at')])
            ->where('followed_by_session_id', $sessionId)
            ->whereIn('status', [1, 3])
            ->whereNull('deleted_at')
            ->orderBy('id')
            ->get();

        return $students;
    }
}
