<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentTypeRequest;
use App\Models\PaymentType;
use App\Services\Admin\PaymentTypeService;
use Illuminate\Http\Request;

class PaymentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $paymentTypeService;

    protected $redirectUrl;

    public function __construct(PaymentTypeService $paymentTypeService){
        $this->redirectUrl = 'admin/payment_type';
        $this->paymentTypeService = $paymentTypeService;
    }


    public function index(){

        $data = [
            'pageTitle' => 'Payment Type',
            'tableHeads' => ['Id', 'Title', 'Code', 'Status', 'Action'],
            'dataUrl' => $this->redirectUrl.'/get-data',
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'title', 'name' => 'title'],
                ['data' => 'code', 'name' => 'code'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
        ];

        return view('paymentType.index', $data);
    }

    public function getData(Request $request) {

        return $this->paymentTypeService->getAllData($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $data = [
            'pageTitle' => 'Payment Type Create',
        ];

        return view('paymentType.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaymentTypeRequest $request) {

        $paymentType = $this->paymentTypeService->create($request->all());

        if ($paymentType) {
            $request->session()->flash('success', setMessage('create', 'Payment Type'));
            return redirect()->route('payment_type.index');
        } else {
            $request->session()->flash('error', setMessage('create.error', 'Payment Type'));
            return redirect()->route('payment_type.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PaymentType  $paymentType
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = [
            'pageTitle' => 'Payment Type Detail',
            'paymentType' => $this->paymentTypeService->find($id),
        ];
        $data['paymentDetailData'] = $this->paymentTypeService->getPaymentDetailData($id);

        //get all student category
        $data['studentCategories'] = $this->studentCategoryService->getAllStudentCategory();
        //get all course
        $data['courses'] = $this->courseService->getAllCourse();
        return view('paymentType.view', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PaymentType  $paymentType
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $data = [
            'pageTitle' => 'Payment Type Edit',
            'paymentType' => $this->paymentTypeService->find($id),
        ];
        /*$data['paymentDetailData'] = $this->paymentTypeService->getPaymentDetailData($id);

        //get all student category
        $data['studentCategories'] = $this->studentCategoryService->getAllStudentCategory();
        //get all course
        $data['courses'] = $this->courseService->getAllCourse();*/

        return view('paymentType.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PaymentType  $paymentType
     * @return \Illuminate\Http\Response
     */
    public function update(PaymentTypeRequest $request, $id) {
        $paymentType = $this->paymentTypeService->update($request->all(), $id);

        if ($paymentType) {
            $request->session()->flash('success', setMessage('update', 'Payment Type'));
            return redirect()->route('payment_type.index');
        } else {
            $request->session()->flash('error', setMessage('update.error', 'Payment Type'));
            return redirect()->route('payment_type.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PaymentType  $paymentType
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentType $paymentType)
    {
        //
    }
}
