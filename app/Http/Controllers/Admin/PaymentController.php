<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentType;
use App\Models\User;
use App\Services\Admin\BankService;
use App\Services\Admin\CourseService;
use App\Services\Admin\PaymentMethodService;
use App\Services\Admin\PaymentTypeService;
use App\Services\Admin\PhaseService;
use App\Services\Admin\SessionService;
use App\Services\Admin\StudentService;
use App\Services\AttachmentService;
use App\Services\StudentFeeService;
use App\Services\UtilityServices;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Validators\ValidationException;
use PDF;

class PaymentController extends Controller
{
    /**
     *
     */
    const moduleName = 'Payment';
    /**
     *
     */
    const redirectUrl = 'admin/payment_generate';
    /**
     *
     */
    const moduleDirectory = 'payments.';

    protected $service;
    protected $sessionService;
    protected $courseService;
    protected $paymentTypeService;
    protected $studentFeeService;
    protected $attachmentService;
    protected $phaseService;
    protected $paymentMethodService;
    protected $bankService;

    public function __construct(
        StudentService    $service, SessionService $sessionService, CourseService $courseService, PaymentTypeService $paymentTypeService,
        StudentFeeService $studentFeeService, AttachmentService $attachmentService, PaymentMethodService $paymentMethodService, BankService $bankService,
        PhaseService      $phaseService
    )
    {
        $this->service = $service;
        $this->sessionService = $sessionService;
        $this->courseService = $courseService;
        $this->paymentTypeService = $paymentTypeService;
        $this->studentFeeService = $studentFeeService;
        $this->attachmentService = $attachmentService;
        $this->phaseService = $phaseService;
        $this->paymentMethodService = $paymentMethodService;
        $this->bankService = $bankService;
    }

    public function payment_generate_list(Request $request)
    {

        $data = [
            'pageTitle' => 'Generate Class Absent Fee',
            'sessions' => $this->sessionService->listByStatus(),
            'courses' => $this->courseService->lists(),
            'paymentTypes' => $this->paymentTypeService->listByStatus()
        ];

        if (!empty($request->student_id)) {
            $data['studentFees'] = $this->service->getStudentFeesByType($request->student_id, 4);
        }

        return view(self::moduleDirectory . 'payment_generate.index', $data);
    }

    public function generate_payment()
    {
        $data = [
            'pageTitle' => 'Generate Class Absent Fee',
            'sessions' => $this->sessionService->listByStatus(),
            'courses' => $this->courseService->lists(),
            'phases' => $this->phaseService->listByStatus(),
//            'paymentTypes' => $this->paymentTypeService->listByStatus(),
        ];

        return view(self::moduleDirectory . 'payment_generate.create', $data);
    }

    public function checkPayment(Request $request)
    {
        $check = 'true';
        if ($request->has('student_id')) {
            $payment = $this->service->checkPaymentExists($request);

            if (!empty($payment)) {
                $lastBillDate = Carbon::create($payment->bill_year, $payment->bill_month, 1)->diffInMonths(now());
                if ($lastBillDate == 1) {
                    $check = 'false';
                }
            }
        }

        echo $check;
    }

    //check absent fee already generated
    public function checkAbsentFeeAlreadyGenerated(Request $request)
    {
        if ($request->has('student_id')) {
            $check = $this->service->checkAbsentFeeExistsByStudentIdAndPhaseId($request);
            if (empty($check)) {
                return 'true';
            }

            return 'false';
        }
    }

    public function savePayment(Request $request)
    {
        $studentId = null;

        if ($request->student_user_id) {
            $user = User::where('user_id', $request->student_user_id)->first();
            $studentId = $user && $this->service->findBy(['user_id' => $user->id])
                ? $this->service->findBy(['user_id' => $user->id])->id
                : null;
        } elseif ($request->student_id) {
            $studentId = $request->student_id;
        }
        $request['student_id'] = $studentId;

        $payment = $this->service->generateClassAbsentFeePayment($request);

        if ($payment) {
            $request->session()->flash('success', setMessage('create', 'Payment Generate'));
        } else {
            $request->session()->flash('error', setMessage('create.error', 'Payment Generate'));
        }

        return redirect()->route('student.absent.fee.list');

    }

    public function getBillDetail($id)
    {

        $data = [
            'pageTitle' => 'Payment Detail',
            'sessions' => $this->sessionService->listByStatus(),
            'courses' => $this->courseService->lists(),
        ];

        $data['studentFees'] = $this->service->getStudentFeesByFeeId($id);

        return view(self::moduleDirectory . 'payment_generate.view', $data);
    }

    /* public function editBillDetail($id){
         $data = [
             'pageTitle' => 'Edit Payment Detail',
             'sessions' => $this->sessionService->listByStatus(),
             'courses' => $this->courseService->lists(),
         ];

         $data['studentFees'] = $this->service->getStudentFeesByFeeId($id);

         return view(self::moduleDirectory.'payment_generate.edit', $data);
     }*/

    //get student fee list by student id
    public function getStudentFee(Request $request)
    {
        $data['pageTitle'] = 'Payment Collect';
        $data['sessions'] = $this->sessionService->getAllSession();
        $data['courses'] = $this->courseService->getAllCourse();
        if ($request->has('student_id') && !empty($request->student_id)) {
            $data['studentFees'] = $this->studentFeeService->getStudentFeeByStudentId($request->only('student_id'));
        }
        return view('payments.paymentCollect.index', $data);

    }

    //get student by details by student fee id
    public function getStudentFeeDetails($studentFeeId)
    {
        $data['studentFeeId'] = $studentFeeId;
        $data['pageTitle'] = 'Student fee detail';
        $data['studentFeeDetails'] = $this->studentFeeService->studentFeeDetailsByStudentFeeId($studentFeeId);
        return view('payments.paymentCollect.paymentDetail', $data);
    }

    //collect fee form
    public function feeCollect($studentFeeId, $studentFeeDetailId = null)
    {
        $data['studentFeeId'] = $studentFeeId;
        $data['studentFeeDetailId'] = $studentFeeDetailId;
        $data['pageTitle'] = 'Get Payment Fee';
        $studentFeeService = $this->studentFeeService->find($studentFeeId);
        //get student id
        $data['studentId'] = $studentFeeService->student_id;
        if (!empty($studentFeeDetailId)) {
            //get amount to show in input field
            $data['payableAmount'] = $this->studentFeeService->getStudentFeeDetailByFeeDetailId($studentFeeDetailId)->payable_amount;
        } else {
            $data['payableAmount'] = $studentFeeService->payable_amount;
        }
        return view('payments.paymentCollect.create', $data);

    }

    //get attachment id if bank slip number is exist in attachment table
    public function findAndGetAttachmentId(Request $request)
    {
        $bankSlipNumber = $request->input('bankSlipNumber');
        $student_id = $request->input('student_id');
        $attachment = $this->attachmentService->getAttachmentIdByStudentIdAndBankSlip($student_id, $bankSlipNumber);

        return response()->json($attachment);
    }

    //Save fee data
    public function saveStudentCollectedFee(Request $request)
    {
        $paymentData = $this->studentFeeService->saveStudentFeeByStudentIdAndStudentFeeDetailId($request);

        if ($paymentData) {
            $request->session()->flash('success', setMessage('create', 'Collect Payment Success'));
        } else {
            $request->session()->flash('error', setMessage('create.error', 'Collect Payment Error'));
        }

        if (!empty($request->student_fee_detail_id)) {
            return redirect()->route('student.fee.detail', $paymentData->student_fee_id);
        }

        return redirect()->route('get.student.fee');
    }

    //get student fee
    public function collectStudentFee(Request $request)
    {
        $data = [
            'pageTitle' => 'Collect Student Fee',
            'sessions' => $this->sessionService->listByStatus(),
            'courses' => $this->courseService->lists(),
            'paymentTypes' => $this->paymentTypeService->lists(),
        ];

        if ($request->payment_type_id) {
            $studentId = null;

            if ($request->student_user_id) {
                $user = User::where('user_id', $request->student_user_id)->first();
                $studentId = $user && $this->service->findBy(['user_id' => $user->id])
                    ? $this->service->findBy(['user_id' => $user->id])->id
                    : null;
            } elseif ($request->student_id) {
                $studentId = $request->student_id;
            }

            if ($studentId) {
                $data['studentFees'] = $this->service->getStudentFeeByStudentAndPaymentTypeId($studentId, $request->payment_type_id);
                $data['studentPayments'] = $this->studentFeeService->getStudentPaymentsByStudentId($studentId);
            }
        }

        return view(self::moduleDirectory . 'collectFee.index', $data);
    }

    //get single student fee details from collect fee page
    public function collectSingleStudentFeeDetails(Request $request)
    {
        $data = [
            'pageTitle' => 'Single Student Fee details',
        ];

        if (!empty($request->student_id) and !empty($request->payment_type_id)) {
            $data['studentFees'] = $this->service->getStudentFeeByStudentAndPaymentTypeId($request->student_id, $request->payment_type_id);
            $data['studentPayments'] = $this->studentFeeService->getStudentPaymentsByStudentId($request->student_id);
        }
        return view(self::moduleDirectory . 'collectFee.singleStudentFeeDetails', $data);
    }


    // show student fee info
    public function showStudentFee($id)
    {
        $data = [
            'pageTitle' => 'Student Fee Info',
            'studentFeeInfo' => $this->studentFeeService->showIndividualStudentFee($id),
        ];
        return view(self::moduleDirectory . 'collectFee.view', $data);
    }

    public function studentFeeCollectForm(Request $request)
    {
        $data = [
            'pageTitle' => 'Collect Student Fee',
            'sessions' => $this->sessionService->listByStatus(),
            'courses' => $this->courseService->lists(),
            'paymentTypes' => $this->paymentTypeService->listByStatus(),
            'paymentMethods' => $this->paymentMethodService->lists(),
            'banks' => $this->bankService->listByStatus()->unique(),
        ];
        return view(self::moduleDirectory . 'collectFee.create', $data);
    }

    public function saveStudentPaymentData(Request $request)
    {
        $studentId = null;

        if ($request->student_user_id) {
            $user = User::where('user_id', $request->student_user_id)->first();
            $studentId = $user && $this->service->findBy(['user_id' => $user->id])
                ? $this->service->findBy(['user_id' => $user->id])->id
                : null;
        } elseif ($request->student_id) {
            $studentId = $request->student_id;
        }
        $request['student_id'] = $studentId;

        $payment = $this->service->saveStudentPayments($request);

        if ($payment) {
            $request->session()->flash('success', setMessage('create', 'Student Payment'));
            $data = [
                'pageTitle' => 'Invoice Collect Fee',
                'studentPayment' => $payment,
            ];
            return view('payments.collectFee.invoice', $data);
        }

        $request->session()->flash('error', setMessage('create.error', 'Student Payment'));
        return redirect()->route('student.fee.collect.form');
    }


    public function generateInvoicePdf($id, $stream = '')
    {
        $studentFee = $this->studentFeeService->showIndividualStudentPaymentInvoicePDF($id);
        $student_id = $studentFee['studentInfo']->student_id;
        $id = $studentFee['studentInfo']->id;

        $data = [
            'paymentInvoice' => $studentFee,
        ];
        $document = 'collect_invoice_' . $student_id . $id . '.pdf';
        $pdf = PDF::loadView('payments.collectFee.invoicePDF', $data);
        return $pdf->stream($document);
    }


    //get student payment
    public function getStudentPaymentByStudentIdAndDate(Request $request)
    {
        $data = [
            'pageTitle' => 'Student Payment',
            'sessions' => $this->sessionService->listByStatus(),
            'courses' => $this->courseService->lists(),
        ];

        $studentId = null;

        if ($request->student_user_id) {
            $user = User::where('user_id', $request->student_user_id)->first();
            $studentId = $user && $this->service->findBy(['user_id' => $user->id])
                ? $this->service->findBy(['user_id' => $user->id])->id
                : null;
        } elseif ($request->student_id) {
            $studentId = $request->student_id;
        }

        if ($studentId) {
            $data['studentPayments'] = $this->studentFeeService->getStudentPaymentsByStudentIdInvoice($studentId, $request->payment_date_start, $request->payment_date_end);
        }

        return view(self::moduleDirectory . 'studentPayment.index', $data);
    }

    //student payment view
    public function studentPaymentView($id)
    {
        $data = [
            'pageTitle' => 'Details of Student Payment',
            'studentPaymentInfo' => $this->studentFeeService->showIndividualStudentPayment($id),
        ];
        return view(self::moduleDirectory . 'studentPayment.view', $data);
    }

    //student payment edit
    public function studentPaymentEdit($invoiceNo)
    {
        $data = [
            'pageTitle' => 'Edit Student Payment',
            'sessions' => $this->sessionService->listByStatus(),
            'courses' => $this->courseService->lists(),
            'paymentTypes' => $this->paymentTypeService->lists(),
            'paymentMethods' => $this->paymentMethodService->lists(),
            'banks' => $this->bankService->listByStatus()->unique(),
            'studentPayment' => $this->studentFeeService->getStdPaymentById($invoiceNo),
            // 'studentPayment' => $this->studentFeeService->getStudentPaymentById($paymentId),
        ];
        return view(self::moduleDirectory . 'studentPayment.edit', $data);
    }

    //student payment update
    public function studentPaymentUpdate(Request $request, $id)
    {
        $studentPayment = $this->studentFeeService->updateStudentPayment($request, $id);
        if ($studentPayment) {
            $request->session()->flash('success', setMessage('update', 'Student Payment'));
            return redirect()->route('student.payment.list', ['session_id' => $studentPayment->student->session->id, 'course_id' => $studentPayment->student->course->id, 'student_id' => $studentPayment->student_id]);
        }

        $request->session()->flash('error', setMessage('update.error', 'Student Payment'));
        return redirect()->route('student.payment.list', [
            'session_id' => $studentPayment->student->session->id, 'course_id' => $studentPayment->student->course->id,
            'student_id' => $studentPayment->student_id
        ]);
    }

    //get generate student fee list
    public function generateStudentFee(Request $request)
    {
        $data = [
            'pageTitle' => 'Generate Student Fee',
            'sessions' => $this->sessionService->listByStatus(),
            'courses' => $this->courseService->lists(),
            'paymentTypes' => $this->paymentTypeService->lists(),
        ];

        if (!empty($request->payment_type_id)) {
            $studentId = null;

            if ($request->student_user_id) {
                $user = User::where('user_id', $request->student_user_id)->first();
                $studentId = $user && $this->service->findBy(['user_id' => $user->id])
                    ? $this->service->findBy(['user_id' => $user->id])->id
                    : null;
            } elseif ($request->student_id) {
                $studentId = $request->student_id;
            }

            if ($studentId) {
                $data['studentFees'] = $this->service->getStudentFeeByStudentAndPaymentTypeId($studentId, $request->payment_type_id);
            }
        }
        return view(self::moduleDirectory . 'payment_generate.index', $data);
    }

    // show student fee info in generate
    public function showSingleStudentFee($id)
    {
        $data = [
            'pageTitle' => 'Student Fee Info',
            'studentFeeInfo' => $this->studentFeeService->showIndividualStudentFee($id)->load('feeDetails.paymentType'),
        ];
        return view(self::moduleDirectory . 'payment_generate.view', $data);
    }

    // edit student fee info in generate
    public function editSingleStudentFee($id)
    {
        $data = [
            'pageTitle' => 'Edit Student Fee Info',
            'studentFeeInfo' => $this->studentFeeService->showIndividualStudentFee($id),
        ];
        return view(self::moduleDirectory . 'payment_generate.edit', $data);
    }

    // update student fee info in generate
    public function updateSingleStudentFee(Request $request, $id)
    {
        $studentFeeInfo = $this->studentFeeService->updateStudentFeeAndFeeDetail($request, $id);

        if ($studentFeeInfo) {
            $request->session()->flash('success', setMessage('update', 'Student Fee'));
            if (!empty($studentFeeInfo->feeDetails)) {
                return redirect()->route('generate.student.fee.list', ['session_id' => $studentFeeInfo->student->session_id, 'course_id' => $studentFeeInfo->student->course_id, 'student_id' => $studentFeeInfo->student_id, 'payment_type_id' => $studentFeeInfo->feeDetails->first()->payment_type_id]);
            }

            return redirect()->route('generate.student.fee.list', [
                'session_id' => $studentFeeInfo->student->session_id,
                'course_id' => $studentFeeInfo->student->course_id, 'student_id' => $studentFeeInfo->student_id
            ]);
        }

        $request->session()->flash('error', setMessage('update.error', 'Student Fee'));
        if (!empty($studentFeeInfo->feeDetails)) {
            return redirect()->route('generate.student.fee.list', ['session_id' => $studentFeeInfo->student->session_id, 'course_id' => $studentFeeInfo->student->course_id, 'student_id' => $studentFeeInfo->student_id, 'payment_type_id' => $studentFeeInfo->feeDetails->first()->payment_type_id]);
        }

        return redirect()->route('generate.student.fee.list', [
            'session_id' => $studentFeeInfo->student->session_id,
            'course_id' => $studentFeeInfo->student->course_id, 'student_id' => $studentFeeInfo->student_id
        ]);
    }

    //edit student development fee installment
    public function editSingleInstallmentOfDevelopmentFee($id)
    {
        $data = [
            'pageTitle' => 'Edit Installment Of Development Fee',
            'studentInstallmentFee' => $this->studentFeeService->getStudentSingleInstallmentFee($id),
        ];
        return view(self::moduleDirectory . 'payment_generate.installmentFeeEdit', $data);
    }

    //update student development fee installment
    public function updateSingleInstallmentOfDevelopmentFee(Request $request, $id)
    {
        $studentInstallmentFee = $this->studentFeeService->updateStudentSingleInstallmentFee($request, $id);
        if ($studentInstallmentFee) {
            $request->session()->flash('success', setMessage('update', 'Student Development Fee'));
            return redirect()->route('generate.student.fee.view', ['id' => $studentInstallmentFee->fee->id]);
        }

        $request->session()->flash('error', setMessage('update.error', 'Student Development Fee'));
        return redirect()->route('generate.student.fee.view', ['id' => $studentInstallmentFee->fee->id]);
    }

    //student tuition fee list
    public function studentTuitionFeeList(Request $request)
    {
        $data = [
            'pageTitle' => 'Student Tuition Fee List',
            'sessions' => $this->sessionService->listByStatus(),
            'courses' => $this->courseService->lists(),
        ];

        $studentId = null;

        if ($request->student_user_id) {
            $user = User::where('user_id', $request->student_user_id)->first();
            $studentId = $user && $this->service->findBy(['user_id' => $user->id])
                ? $this->service->findBy(['user_id' => $user->id])->id
                : null;
        } elseif ($request->student_id) {
            $studentId = $request->student_id;
        }

        if ($studentId) {
            $data['studentFees'] = $this->service->getStudentFeeByStudentAndPaymentTypeId($studentId, 3);
            $data['sum_discount'] = \App\Models\StudentPayment::where(['student_id' => $studentId])->sum('discount_amount');
        }

        return view(self::moduleDirectory . 'tuitionFeeGenerate.index', $data);
    }

    // show single student tuition fee
    public function showSingleStudentTuitionFee($id)
    {
        $data = [
            'pageTitle' => 'Student Tuition Fee Details',
            'studentFeeInfo' => $this->studentFeeService->showIndividualStudentFee($id)->load('feeDetails.paymentType'),
        ];
        return view(self::moduleDirectory . 'tuitionFeeGenerate.view', $data);
    }

    // edit student tuition fee
    public function editSingleStudentTuitionFee($id)
    {
        $data = [
            'pageTitle' => 'Edit Student Tuition Fee Info',
            'studentFeeInfo' => $this->studentFeeService->showIndividualStudentFee($id),
        ];
        return view(self::moduleDirectory . 'tuitionFeeGenerate.edit', $data);
    }

    // update student tuition fee
    public function updateSingleStudentTuitionFee(Request $request, $id)
    {
        $studentFeeInfo = $this->studentFeeService->updateStudentFeeAndFeeDetail($request, $id);

        if ($studentFeeInfo) {
            $request->session()->flash('success', setMessage('update', 'Student Fee'));
            if (!empty($studentFeeInfo->feeDetails)) {
                return redirect()->route('student.tuition.fee.list', ['session_id' => $studentFeeInfo->student->session_id, 'course_id' => $studentFeeInfo->student->course_id, 'student_id' => $studentFeeInfo->student_id, 'payment_type_id' => $studentFeeInfo->feeDetails->first()->payment_type_id]);
            }

            return redirect()->route('student.tuition.fee.list', ['session_id' => $studentFeeInfo->student->session_id, 'course_id' => $studentFeeInfo->student->course_id, 'student_id' => $studentFeeInfo->student_id]);
        }

        $request->session()->flash('error', setMessage('update.error', 'Student Fee'));
        if (!empty($studentFeeInfo->feeDetails)) {
            return redirect()->route('student.tuition.fee.list', ['session_id' => $studentFeeInfo->student->session_id, 'course_id' => $studentFeeInfo->student->course_id, 'student_id' => $studentFeeInfo->student_id, 'payment_type_id' => $studentFeeInfo->feeDetails->first()->payment_type_id]);
        }

        return redirect()->route('student.tuition.fee.list', ['session_id' => $studentFeeInfo->student->session_id, 'course_id' => $studentFeeInfo->student->course_id, 'student_id' => $studentFeeInfo->student_id]);
    }

    public function adjustStudentTuitionFee($id)
    {
        $studentFeeInfo = $this->studentFeeService->showIndividualStudentFee($id);
        $paymentTypes = $studentFeeInfo->feeDetails
            ->where('status', '!=', 1)
            ->where('payment_type_id', '!=', 3)
            ->mapWithKeys(function ($feeDetail) {
                return [$feeDetail->paymentType->id => $feeDetail->paymentType->title];
            });

        $data = [
            'pageTitle' => 'Adjust Student Tuition Fee Info',
            'studentFeeInfo' => $studentFeeInfo,
            'paymentTypes' => $paymentTypes,
        ];
        return view(self::moduleDirectory . 'tuitionFeeGenerate.adjustTuitionFee', $data);
    }

    public function updateAdjustedTuitionFee(Request $request, $id)
    {
        try {
            $studentFeeInfo = $this->studentFeeService->adjustStudentFeeAndFeeDetail($request, $id);

            if ($studentFeeInfo) {
                // If fee adjustment is successful
                $request->session()->flash('success', setMessage('update', 'Student Fee'));

                if (!empty($studentFeeInfo->feeDetails)) {
                    // Redirect with payment type if fee details exist
                    return redirect()->route('student.tuition.fee.list', [
                        'session_id' => $studentFeeInfo->student->session_id,
                        'course_id' => $studentFeeInfo->student->course_id,
                        'student_id' => $studentFeeInfo->student_id,
                        'payment_type_id' => $studentFeeInfo->feeDetails->first()->payment_type_id
                    ]);
                }

                // Redirect without payment type if fee details do not exist
                return redirect()->route('student.tuition.fee.list', [
                    'session_id' => $studentFeeInfo->student->session_id,
                    'course_id' => $studentFeeInfo->student->course_id,
                    'student_id' => $studentFeeInfo->student_id
                ]);
            }

            // If student fee adjustment failed
            throw new Exception('Unable to adjust student fee details');
        } catch (Exception $e) {
            // Handle exception and display error message
            $request->session()->flash('error', setMessage('update.error', 'Student Fee'));

            // Redirect with payment type if fee details exist
            if (isset($studentFeeInfo) && !empty($studentFeeInfo->feeDetails)) {
                return redirect()->route('student.tuition.fee.list', [
                    'session_id' => $studentFeeInfo->student->session_id,
                    'course_id' => $studentFeeInfo->student->course_id,
                    'student_id' => $studentFeeInfo->student_id,
                    'payment_type_id' => $studentFeeInfo->feeDetails->first()->payment_type_id
                ]);
            }

            // Redirect without payment type if fee details do not exist
            return redirect()->route('student.tuition.fee.list', [
                'session_id' => $studentFeeInfo->student->session_id,
                'course_id' => $studentFeeInfo->student->course_id,
                'student_id' => $studentFeeInfo->student_id
            ]);
        }
    }



    //student tuition fee create
    public function generateStudentTuitionFee()
    {
        $data = [
            'pageTitle' => 'Generate Tuition Fee',
            'sessions' => $this->sessionService->listByStatus(),
            'courses' => $this->courseService->lists(),
        ];

        return view(self::moduleDirectory . 'tuitionFeeGenerate.create', $data);
    }

    //student tuition fee save
    public function saveStudentTuitionFee(Request $request)
    {
        $studentId = null;

        if ($request->student_user_id) {
            $user = User::where('user_id', $request->student_user_id)->first();
            $studentId = $user && $this->service->findBy(['user_id' => $user->id])
                ? $this->service->findBy(['user_id' => $user->id])->id
                : null;
        } elseif ($request->student_id) {
            $studentId = $request->student_id;
        }
        $request['student_id'] = $studentId;

        $studentTuitionFee = $this->studentFeeService->studentTuitionFeeInfo($request);
        if ($studentTuitionFee) {
            $request->session()->flash('success', setMessage('create', 'Tuition fee generated successfully'));
            return redirect()->route('student.tuition.fee.list');
        }

        $request->session()->flash('error', setMessage('create.error', 'Error in tuition fee generation'));
        return redirect()->route('student.tuition.fee.list');
    }

    public function getSingleStudentRollNumber(Request $request)
    {
        return $this->studentFeeService->studentRollNumber($request);

    }

    public function getSingleStudentAmount(Request $request)
    {
        $studentId = $request->studentId;
        return $this->service->getStudentAmountCheck($studentId);
    }

    public function getSingleStudentAmountByUserId(Request $request)
    {
        $studentUserId = $request->studentUserId;
        $user = User::where('user_id', $studentUserId)->first();
        $student = $this->service->findBy(['user_id' => $user->id]);

        return $this->service->getStudentAmountCheck($student->id);
    }

    public function collectFeeStudentDueCheck(Request $request)
    {
        return $this->service->getStudentFeeDueCheck($request->studentId, $request->paymentTypeId);
    }

    //check student tuition fee already generated for current date range or not
    public function checkStudentTuitionFeeGeneratedForBillMonthTo(Request $request)
    {
        $tuitionFee = $this->studentFeeService->checkStudentTuitionFeeGeneratedForMonthTo($request);
        if (empty($tuitionFee)) {
            return 'false';
        }

        return 'true';
    }

    //fees and payments for BD students
    public function getFeesWithPaymentByCourseAndPhase(Request $request)
    {
        $feeTypes = $this->paymentTypeService->getAllPaymentType();
        foreach ($feeTypes as $feeType) {
            //total payable amount (After discount)
            $totalAmount = $this->studentFeeService->getTotalFeeAmountBySessionIdCourseIdPhaseIdAndPaymentTypeId($request, $feeType->id);
            if ($totalAmount) {
                $totalPaidAmount = $this->studentFeeService->getTotalPaidAmountBySessionIdCourseIdPhaseIdAndPaymentTypeId($request, $feeType->id);
                $dueAmount = $totalAmount - $totalPaidAmount;
                if ($totalPaidAmount) {
                    $paidPercentAmount = ($totalPaidAmount * 100) / $totalAmount;
                } else {
                    $paidPercentAmount = 0;
                }
                $duePercentAmount = 100 - $paidPercentAmount;
                $feeType->chardData = collect([
                    ['name' => 'Due (Tk) :', 'y' => $duePercentAmount, 'color' => UtilityServices::$chartColors['red'], 'count' => number_format($dueAmount, 2)],
                    ['name' => 'Paid (Tk):', 'y' => $paidPercentAmount, 'color' => UtilityServices::$chartColors['green'], 'count' => number_format($totalPaidAmount, 2)],
                ]);
            } else {
                $feeType->chardData = collect([
                    /*['name' => 'Due(Tk) :', 'y' => 50, 'color' => UtilityServices::$chartColors['gray'], 'count' => 0],
                    ['name' => 'Paid(Tk) :', 'y' => 50, 'color' => UtilityServices::$chartColors['gray'], 'count' => 0],*/
                    ['name' => 'Fee not generated', 'y' => 100, 'color' => UtilityServices::$chartColors['gray'], 'count' => 0]
                ]);
            }


            $feeType->phaseId = $request->phase_id;
        }

        return response()->json([
            'status' => true, 'feeTypes' => $feeTypes
        ]);

    }

    //fees and payments for foreign students
    public function getForeignFeesWithPaymentByCourseAndPhase(Request $request)
    {
        $foreignFeeTypes = $this->paymentTypeService->getAllPaymentType();
        foreach ($foreignFeeTypes as $foreignFeeType) {
            //total payable amount (After discount)
            $totalAmount = $this->studentFeeService->getTotalForeignFeeAmountBySessionIdCourseIdPhaseIdAndPaymentTypeId($request, $foreignFeeType->id);
            if ($totalAmount) {
                $totalPaidAmount = $this->studentFeeService->getTotalPaidAmountBySessionIdCourseIdPhaseIdAndPaymentTypeIdForForeignStudents($request, $foreignFeeType->id);
                $dueAmount = $totalAmount - $totalPaidAmount;
                if ($totalPaidAmount) {
                    $paidPercentAmount = ($totalPaidAmount * 100) / $totalAmount;
                } else {
                    $paidPercentAmount = 0;
                }
                $duePercentAmount = 100 - $paidPercentAmount;
                $foreignFeeType->chardData = collect([
                    ['name' => 'Due($) :', 'y' => $duePercentAmount, 'color' => UtilityServices::$chartColors['red'], 'count' => number_format($dueAmount, 2)],
                    ['name' => 'Paid($) :', 'y' => $paidPercentAmount, 'color' => UtilityServices::$chartColors['green'], 'count' => number_format($totalPaidAmount, 2)],
                ]);
            } else {
                $foreignFeeType->chardData = collect([
                    /*['name' => 'Due Amount ($) :', 'y' => 0, 'color' => UtilityServices::$chartColors['red'], 'count' => 0 ],
                    ['name' => 'Paid Amount ($) :', 'y' => 0, 'color' => UtilityServices::$chartColors['green'], 'count' => 0 ],*/
                    ['name' => 'Fee not generated', 'y' => 100, 'color' => UtilityServices::$chartColors['gray'], 'count' => 0]
                ]);
            }


            $foreignFeeType->phaseId = $request->phase_id;
        }

        return response()->json([
            'status' => true, 'foreignFeeTypes' => $foreignFeeTypes
        ]);

    }

    // count total absent class number by student info
    public function getSingleStudentAbsentClassNumber(Request $request)
    {
        $totalAbsentClass = $this->service->countStudentAbsentClassNumber($request);
        return response()->json(['status' => true, 'data' => $totalAbsentClass]);
    }

    public function saveBulkPayment(Request $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'payment_file' => 'required|file|mimes:xlsx,xls|max:1024'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            $data = $this->studentFeeService->saveBulkPaymentData($request);

            if (!$data || !isset($data->info)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid response from import service',
                    'redirect' => route('admission.index')
                ]);
            }

            $status = $data->info['status'] ?? true;
            $message = $data->info['message'] ?? 'Payments excel imported successfully';
            $alertType = $status === false ? 'error' : 'success';

            return response()->json([
                'status' => $alertType,
                'message' => nl2br($message),
                'redirect' => route('get.student.development.fee')
            ]);
        } catch (ValidationException $e) {
            Log::error('Validation error while importing payments', [
                'errors' => $e->failures(),
                'exception' => $e
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid data in import file. Please check your file and try again.',
                'redirect' => route('get.student.development.fee')
            ]);
        } catch (Exception $e) {
            Log::error('Error importing payments: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong while importing payments.',
                'redirect' => route('get.student.development.fee')
            ]);
        }
    }
}
