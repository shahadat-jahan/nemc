<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentMethodRequest;
use App\Services\Admin\PaymentMethodService;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $paymentMethodService;

    protected $redirectUrl;

    public function __construct(PaymentMethodService $paymentMethodService){
        $this->redirectUrl = 'admin/payment_method';
        $this->paymentMethodService = $paymentMethodService;
    }


    public function index(){
        $data = [
            'pageTitle' => 'Payment Method',
            'tableHeads' => ['Id', 'Title', 'Status', 'Action'],
            'dataUrl' => $this->redirectUrl.'/get-data',
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'title', 'name' => 'title'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
        ];

        return view('paymentMethod.index', $data);
    }

    public function getData(Request $request){

        return $this->paymentMethodService->getAllData($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $data = [
            'pageTitle' => 'Payment Method Create',
        ];
        return view('paymentMethod.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaymentMethodRequest $request){
        $paymentMethod = $this->paymentMethodService->create($request->all());

        if ($paymentMethod) {
            $request->session()->flash('success', setMessage('create', 'Payment Method'));
            return redirect()->route('payment_method.index');
        } else {
            $request->session()->flash('error', setMessage('create.error', 'Payment Method'));
            return redirect()->route('payment_method.index');
        }
    }


    public function edit($id){
        $data = [
            'pageTitle' => 'Edit Payment Method',
            'paymentMethod' => $this->paymentMethodService->find($id),
        ];
        return view('paymentMethod.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function update(PaymentMethodRequest $request, $id){
        $paymentMethod = $this->paymentMethodService->update($request->all(), $id);

        if ($paymentMethod) {
            $request->session()->flash('success', setMessage('update', 'Payment Method'));
            return redirect()->route('payment_method.index');
        } else {
            $request->session()->flash('error', setMessage('update.error', 'Payment Method'));
            return redirect()->route('payment_method.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        //
    }
}
