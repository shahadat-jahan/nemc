<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BankRequest;
use App\Services\Admin\BankService;
use Illuminate\Http\Request;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $bankService;

    protected $redirectUrl;

    public function __construct(BankService $bankService){
        $this->redirectUrl = 'admin/bank';
        $this->bankService = $bankService;
    }


    public function index(){
        $data = [
            'pageTitle' => 'Bank',
            'tableHeads' => ['Id', 'Title', 'Status', 'Action'],
            'dataUrl' => $this->redirectUrl.'/get-data',
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'title', 'name' => 'title'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
        ];

        return view('bank.index', $data);
    }

    public function getData(Request $request){

        return $this->bankService->getAllData($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $data = [
            'pageTitle' => 'Bank Create',
        ];
        return view('bank.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BankRequest $request){
        $bank = $this->bankService->create($request->all());

        if ($bank) {
            $request->session()->flash('success', setMessage('create', 'Bank'));
            return redirect()->route('bank.index');
        } else {
            $request->session()->flash('error', setMessage('create.error', 'Bank'));
            return redirect()->route('bank.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $data = [
            'pageTitle' => 'Edit Bank',
            'bank' => $this->bankService->find($id),
        ];
        return view('bank.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function update(BankRequest $request, $id){
        $bank = $this->bankService->update($request->all(), $id);

        if ($bank) {
            $request->session()->flash('success', setMessage('update', 'Bank'));
            return redirect()->route('bank.index');
        } else {
            $request->session()->flash('error', setMessage('update.error', 'Bank'));
            return redirect()->route('bank.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bank $bank)
    {
        //
    }
}
