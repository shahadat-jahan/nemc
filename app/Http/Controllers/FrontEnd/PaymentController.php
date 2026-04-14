<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
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
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     *
     */
    const moduleName = 'Payment';
    /**
     *
     */
    const redirectUrl = 'nemc/payment_generate';
    /**
     *
     */
    const moduleDirectory = 'frontend.payments.';

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
        StudentService $service, SessionService $sessionService, CourseService $courseService, PaymentTypeService $paymentTypeService,
        StudentFeeService $studentFeeService, AttachmentService $attachmentService, PaymentMethodService $paymentMethodService, BankService $bankService,
        PhaseService $phaseService
    ){
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

    public function payment_generate_list(Request $request){
        $data = [
            'pageTitle' => 'Generate Class Absent Fee',
            'sessions' => $this->sessionService->listByStatus(),
            'courses' => $this->courseService->lists(),
            'paymentTypes' => $this->paymentTypeService->listByStatus()
        ];

        if (!empty($request->student_id)){
            $data['studentFees'] = $this->service->getStudentFeesByType($request->student_id, 4);
        }

        return view(self::moduleDirectory.'payment_generate.index', $data);
    }

    public function generate_payment(){
        $data = [
            'pageTitle' => 'Generate Class Absent Fee',
            'sessions' => $this->sessionService->listByStatus(),
            'courses' => $this->courseService->lists(),
            'phases' => $this->phaseService->listByStatus(),
//            'paymentTypes' => $this->paymentTypeService->listByStatus(),
        ];

        return view(self::moduleDirectory.'payment_generate.create', $data);
    }

    public function checkPayment(Request $request){
        $check = 'true';
        if ($request->has('student_id')){
            $payment = $this->service->checkPaymentExists($request);

            if (!empty($payment)){
                $lastBillDate = Carbon::create($payment->bill_year, $payment->bill_month, 1)->diffInMonths(now());
                if ($lastBillDate == 1){
                    $check = 'false';
                }
            }
        }

        echo $check;
    }

    public function getBillDetail($id){

        $data = [
            'pageTitle' => 'Payment Detail',
            'sessions' => $this->sessionService->listByStatus(),
            'courses' => $this->courseService->lists(),
        ];

        $data['studentFees'] = $this->service->getStudentFeesByFeeId($id);

        return view(self::moduleDirectory.'payment_generate.view', $data);
    }


    //get student fee list by student id
    public function getStudentFee(Request $request){
        $data['pageTitle'] = 'Payment Collect';
        $data['sessions'] = $this->sessionService->getAllSession();
        $data['courses'] = $this->courseService->getAllCourse();
        if ($request->has('student_id') && !empty($request->student_id)){
            $data['studentFees'] = $this->studentFeeService->getStudentFeeByStudentId($request->only('student_id'));
        }
        return view('payments.paymentCollect.index', $data);

    }
    //get student by details by student fee id
    public function getStudentFeeDetails($studentFeeId){
        $data['studentFeeId'] = $studentFeeId;
        $data['pageTitle'] = 'Student fee detail';
        $data['studentFeeDetails'] = $this->studentFeeService->studentFeeDetailsByStudentFeeId($studentFeeId);
        return view('payments.paymentCollect.paymentDetail', $data);
    }

    //collect fee form
    public function feeCollect($studentFeeId, $studentFeeDetailId = null){
        $data['studentFeeId'] = $studentFeeId;
        $data['studentFeeDetailId'] = $studentFeeDetailId;
        $data['pageTitle'] = 'Get Payment Fee';
        $studentFeeService = $this->studentFeeService->find($studentFeeId);
        //get student id
        $data['studentId'] = $studentFeeService->student_id;
        if (!empty($studentFeeDetailId)){
            //get amount to show in input field
            $data['payableAmount'] = $this->studentFeeService->getStudentFeeDetailByFeeDetailId($studentFeeDetailId)->payable_amount;
        }else{
            $data['payableAmount'] = $studentFeeService->payable_amount;
        }
        return view('payments.paymentCollect.create', $data);

    }
    //get attachment id if bank slip number is exist in attachment table
    public function findAndGetAttachmentId(Request $request){
        $bankSlipNumber = $request->input('bankSlipNumber');
        $student_id = $request->input('student_id');
        $attachment = $this->attachmentService->getAttachmentIdByStudentIdAndBankSlip($student_id, $bankSlipNumber);

        return response()->json($attachment);
    }

    //get student fee
    public function collectStudentFee(Request $request){

        $types = $this->paymentTypeService->lists();
        $data = [
            'pageTitle' => 'Collect Student Fee',
            'sessions' => $this->sessionService->listByStatus(),
            'courses' => $this->courseService->lists(),
            'paymentTypes' => $this->paymentTypeService->lists(),
        ];

        if ((!empty($request->student_id) || !empty($request->student_user_id)) && !empty($request->payment_type_id)) {
            if (!empty($request->student_user_id)) {
                $user = User::where('user_id', $request->student_user_id)->first();
                $student = $this->service->findBy(['user_id' => $user->id]);
                $studentId = $student->id;
            } else {
                $studentId = $request->student_id;
            }

            $data['studentFees'] = $this->service->getStudentFeeByStudentAndPaymentTypeId($studentId, $request->payment_type_id);
            $data['studentPayments'] = $this->studentFeeService->getStudentPaymentsByStudentId($studentId);
        }

        return view(self::moduleDirectory.'collectFee.index', $data);
    }

    //get single student fee details from collect fee page
    public function collectSingleStudentFeeDetails(Request $request){
        $data = [
            'pageTitle' => 'Single Student Fee details',
        ];

        if (!empty($request->student_id) and !empty($request->payment_type_id)){
            $data['studentFees'] = $this->service->getStudentFeeByStudentAndPaymentTypeId($request->student_id, $request->payment_type_id);
            $data['studentPayments'] = $this->studentFeeService->getStudentPaymentsByStudentId($request->student_id);
        }
        return view(self::moduleDirectory.'collectFee.singleStudentFeeDetails', $data);
    }


    // show student fee info
    public function showStudentFee($id){
        $data = [
            'pageTitle' => 'Student Fee Info',
            'studentFeeInfo' => $this->studentFeeService->showIndividualStudentFee($id),
        ];
        return view(self::moduleDirectory.'collectFee.view', $data);
    }

    //get student payment
    public function getStudentPaymentByStudentIdAndDate(Request $request){
        $data = [
            'pageTitle' => 'Student Payment',
            'sessions' => $this->sessionService->listByStatus(),
            'courses' => $this->courseService->lists(),
        ];

        if (!empty($request->student_id) || !empty($request->student_user_id)) {
            if (!empty($request->student_user_id)) {
                $user = User::where('user_id', $request->student_user_id)->first();
                $student = $this->service->findBy(['user_id' => $user->id]);
                $studentId = $student->id;
            } else {
                $studentId = $request->student_id;
            }
            $data['studentPayments'] = $this->studentFeeService->getStudentPaymentsByStudentIdInvoice($studentId, $request->payment_date_start, $request->payment_date_end);
        }

        return view(self::moduleDirectory.'studentPayment.index', $data);
    }

    //student payment view
    public function studentPaymentView($id){
        $data = [
            'pageTitle' => 'Details of Student Payment',
            'studentPaymentInfo' => $this->studentFeeService->showIndividualStudentPayment($id),
        ];
        return view(self::moduleDirectory.'studentPayment.view', $data);
    }

    //get generate student fee list
    public function generateStudentFee(Request $request){
        $data = [
            'pageTitle' => 'Generate Student Fee',
            'sessions' => $this->sessionService->listByStatus(),
            'courses' => $this->courseService->lists(),
            'paymentTypes' => $this->paymentTypeService->lists(),
        ];

        if (!empty($request->student_id) and !empty($request->payment_type_id)){
            $data['studentFees'] = $this->service->getStudentFeeByStudentAndPaymentTypeId($request->student_id, $request->payment_type_id);
        }
        return view(self::moduleDirectory.'payment_generate.index', $data);
    }

    // show student fee info in generate
    public function showSingleStudentFee($id){
        $data = [
            'pageTitle' => 'Student Fee Info',
            'studentFeeInfo' =>$this->studentFeeService->showIndividualStudentFee($id)->load('feeDetails.paymentType'),
        ];
        return view(self::moduleDirectory.'payment_generate.view', $data);
    }


    //student tuition fee list
    public function studentTuitionFeeList(Request $request){
        $data = [
            'pageTitle' => 'Student Tuition Fee List',
            'sessions' => $this->sessionService->listByStatus(),
            'courses' => $this->courseService->lists(),
        ];

        if (!empty($request->student_id)){
            $data['studentFees'] = $this->service->getStudentFeeByStudentAndPaymentTypeId($request->student_id, 3);
        }

        return view(self::moduleDirectory.'tuitionFeeGenerate.index', $data);
    }

    // show single student tuition fee
    public function showSingleStudentTuitionFee($id){
        $data = [
            'pageTitle' => 'Student Tuition Fee Details',
            'studentFeeInfo' =>$this->studentFeeService->showIndividualStudentFee($id)->load('feeDetails.paymentType'),
        ];
        return view(self::moduleDirectory.'tuitionFeeGenerate.view', $data);
    }



    //student tuition fee create
    public function generateStudentTuitionFee(){
        $data = [
            'pageTitle' => 'Generate Tuition Fee',
            'sessions' => $this->sessionService->listByStatus(),
            'courses' => $this->courseService->lists(),
        ];

        return view(self::moduleDirectory.'tuitionFeeGenerate.create', $data);
    }

    public function getSingleStudentRollNumber(Request $request){
        $studentRoll = $this->studentFeeService->studentRollNumber($request);
        return $studentRoll;

    }

    //fees and payments for BD students
    public function getFeesWithPaymentByCourseAndPhase(Request $request){
        $feeTypes = '';
        $feeTypes = $this->paymentTypeService->getAllPaymentType();
        foreach ($feeTypes as $feeType){
            //total payable amount (After discount)
            $totalAmount = $this->studentFeeService->getTotalFeeAmountBySessionIdCourseIdPhaseIdAndPaymentTypeId($request, $feeType->id);
            if ($totalAmount){
                $totalPaidAmount = $this->studentFeeService->getTotalPaidAmountBySessionIdCourseIdPhaseIdAndPaymentTypeId($request, $feeType->id);
                $dueAmount = $totalAmount - $totalPaidAmount;
                if ($totalPaidAmount){
                    $paidPercentAmount = ($totalPaidAmount * 100) / $totalAmount;
                }else{
                    $paidPercentAmount = 0;
                }
                $duePercentAmount = 100 - $paidPercentAmount;
                $feeType->chardData = collect([
                    ['name' => 'Due Amount (Tk) :', 'y' => $duePercentAmount, 'color' => UtilityServices::$chartColors['red'], 'count' => number_format($dueAmount, 2) ],
                    ['name' => 'Paid Amount (Tk):', 'y' => $paidPercentAmount, 'color' => UtilityServices::$chartColors['green'], 'count' => number_format($totalPaidAmount, 2)],
                ]);
            }else{
                $feeType->chardData = collect([
                    ['name' => 'Due Amount(Tk) :', 'y' => 0, 'color' => UtilityServices::$chartColors['red'], 'count' => 0],
                    ['name' => 'Paid Amount(Tk) :', 'y' => 0, 'color' => UtilityServices::$chartColors['green'], 'count' => 0],
                ]);
            }


            $feeType->phaseId = $request->phase_id;
        }

        return response()->json([
            'status' => true, 'feeTypes' => $feeTypes
        ]);

    }

    //fees and payments for foreign students
    public function getForeignFeesWithPaymentByCourseAndPhase(Request $request){
        $foreignFeeTypes = $this->paymentTypeService->getAllPaymentType();
        foreach ($foreignFeeTypes as $foreignFeeType){
            //total payable amount (After discount)
            $totalAmount = $this->studentFeeService->getTotalForeignFeeAmountBySessionIdCourseIdPhaseIdAndPaymentTypeId($request, $foreignFeeType->id);
            if ($totalAmount){
                $totalPaidAmount = $this->studentFeeService->getTotalPaidAmountBySessionIdCourseIdPhaseIdAndPaymentTypeIdForForeignStudents($request, $foreignFeeType->id);
                $dueAmount = $totalAmount - $totalPaidAmount;
                if ($totalPaidAmount){
                    $paidPercentAmount = ($totalPaidAmount * 100) / $totalAmount;
                }else{
                    $paidPercentAmount = 0;
                }
                $duePercentAmount = 100 - $paidPercentAmount;
                $foreignFeeType->chardData = collect([
                    ['name' => 'Due Amount ($) :', 'y' => $duePercentAmount, 'color' => UtilityServices::$chartColors['red'], 'count' => number_format($dueAmount, 2)],
                    ['name' => 'Paid Amount ($) :', 'y' => $paidPercentAmount, 'color' => UtilityServices::$chartColors['green'], 'count' => number_format($totalPaidAmount, 2)],
                ]);
            }else{
                $foreignFeeType->chardData = collect([
                    ['name' => 'Due Amount ($) :', 'y' => 0, 'color' => UtilityServices::$chartColors['red'], 'count' => 0 ],
                    ['name' => 'Paid Amount ($) :', 'y' => 0, 'color' => UtilityServices::$chartColors['green'], 'count' => 0 ],
                ]);
            }


            $foreignFeeType->phaseId = $request->phase_id;
        }

        return response()->json([
            'status' => true, 'foreignFeeTypes' => $foreignFeeTypes
        ]);

    }
}
