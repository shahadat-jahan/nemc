<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PhaseRequest;
use App\Phase;
use App\Services\Admin\PhaseService;
use Illuminate\Http\Request;

class PhaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $phaseService;

    protected $redirectUrl;

    public function __construct(PhaseService $phaseService){
        $this->redirectUrl = 'admin/phase';
        $this->phaseService = $phaseService;
    }


    public function index(){
        $data = [
            'pageTitle' => 'Phase',
            'tableHeads' => ['Id', 'Title', 'Status', 'Action'],
            'dataUrl' => $this->redirectUrl.'/get-data',
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'title', 'name' => 'title'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
        ];

        return view('phase.index', $data);
    }

    public function getData(Request $request){

        return $this->phaseService->getAllData($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $data = [
            'pageTitle' => 'Phase Create',
        ];
        return view('phase.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PhaseRequest $request) {

        $phase = $this->phaseService->create($request->all());

        if ($phase) {
            $request->session()->flash('success', setMessage('create', 'Phase'));
            return redirect()->route('phase.index');
        } else {
            $request->session()->flash('error', setMessage('create.error', 'Phase'));
            return redirect()->route('phase.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Phase  $phase
     * @return \Illuminate\Http\Response
     */
    public function show(Phase $phase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Phase  $phase
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $data = [
            'pageTitle' => 'Edit Phase',
            'phase' => $this->phaseService->find($id),
        ];
        return view('phase.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Phase  $phase
     * @return \Illuminate\Http\Response
     */
    public function update(PhaseRequest $request, $id) {

        $phase = $this->phaseService->update($request->all(), $id);

        if ($phase) {
            $request->session()->flash('success', setMessage('update', 'Phase'));
            return redirect()->route('phase.index');
        } else {
            $request->session()->flash('error', setMessage('update.error', 'Phase'));
            return redirect()->route('phase.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Phase  $phase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Phase $phase)
    {
        //
    }
}
