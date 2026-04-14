<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentDetailRequest;
use App\Http\Requests\PaymentTypeRequest;
use App\Models\PaymentDetail;
use App\Models\Session;
use App\PaymentType;
use App\Services\Admin\CourseService;
use App\Services\Admin\PaymentDetailService;
use App\Services\Admin\PaymentTypeService;
use App\Services\Admin\SessionService;
use App\Services\Admin\StudentCategoryService;
use Illuminate\Http\Request;

class PaymentDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $paymentDetailService;
    protected $paymentTypeService;
    protected $studentCategoryService;
    protected $courseService;
    protected $sessionService;

    protected $redirectUrl;

    public function __construct(PaymentDetailService   $paymentDetailService, PaymentTypeService $paymentTypeService,
                                StudentCategoryService $studentCategoryService, CourseService $courseService, SessionService $sessionService)
    {
        $this->redirectUrl = 'admin/payment_detail';
        $this->paymentDetailService = $paymentDetailService;
        $this->paymentTypeService = $paymentTypeService;
        $this->studentCategoryService = $studentCategoryService;
        $this->courseService = $courseService;
        $this->sessionService = $sessionService;
    }


    public function index()
    {

        $data = [
            'pageTitle' => 'Payment Detail',
            'tableHeads' => ['Id', 'Payment Type', 'Student Category', 'Course', 'Amount', 'Currency', 'Status', 'Action'],
            'dataUrl' => $this->redirectUrl . '/get-data',
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'payment_type_id', 'name' => 'payment_type_id'],
                ['data' => 'student_category_id', 'name' => 'student_category_id'],
//                ['data' => 'session_id', 'name' => 'session_id'],
                ['data' => 'course_id', 'name' => 'course_id'],
                ['data' => 'amount', 'name' => 'amount'],
                ['data' => 'currency_code', 'name' => 'currency_code'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
        ];

        //get all payment type
        $data['paymentTypes'] = $this->paymentTypeService->listByStatus();
        //get all student category
        $data['studentCategories'] = $this->studentCategoryService->listByStatus();
        //get all session
        $data['sessions'] = $this->sessionService->listByStatus();
        //get all course
        $data['courses'] = $this->courseService->listByStatus();


        return view('paymentDetail.index', $data);
    }

    public function getData(Request $request)
    {

        return $this->paymentDetailService->getAllData($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'pageTitle' => 'Payment Detail Create',
        ];

        //get all payment type
        $data['paymentTypes'] = $this->paymentTypeService->getAllPaymentType();
        //get all student category
        $data['studentCategories'] = $this->studentCategoryService->getAllStudentCategory();
        //get all session
        $data['sessions'] = $this->sessionService->getAllSession();
        //get all course
        $data['courses'] = $this->courseService->getAllCourse();

        return view('paymentDetail.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaymentDetailRequest $request)
    {
        $paymentType = $this->paymentDetailService->create($request->all());
        if ($paymentType) {
            $request->session()->flash('success', setMessage('create', 'Payment Detail'));
            return redirect()->route('payment_detail.index');
        } else {
            $request->session()->flash('error', setMessage('create.error', 'Payment Detail'));
            return redirect()->route('payment_detail.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\PaymentType $paymentType
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = [
            'pageTitle' => 'Payment Detail Detail',
            'paymentDetail' => $this->paymentDetailService->find($id),
        ];

        return view('paymentDetail.view', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\PaymentType $paymentType
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [
            'pageTitle' => 'Payment Detail Edit',
            'paymentDetail' => $this->paymentDetailService->find($id),
        ];
        //get all payment type
        $data['paymentTypes'] = $this->paymentTypeService->getAllPaymentType();
        //get all student category
        $data['studentCategories'] = $this->studentCategoryService->getAllStudentCategory();
        //get all session
        $data['sessions'] = $this->sessionService->getAllSession();
        //get all course
        $data['courses'] = $this->courseService->getAllCourse();

        return view('paymentDetail.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\PaymentType $paymentType
     * @return \Illuminate\Http\Response
     */
    public function update(PaymentDetailRequest $request, $id)
    {

        $paymentType = $this->paymentDetailService->update($request->all(), $id);

        if ($paymentType) {
            $request->session()->flash('success', setMessage('update', 'Payment Detail'));
            return redirect()->route('payment_detail.index');
        } else {
            $request->session()->flash('error', setMessage('update.error', 'Payment Detail'));
            return redirect()->route('payment_detail.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\PaymentType $paymentType
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentType $paymentType)
    {
        //
    }
}
