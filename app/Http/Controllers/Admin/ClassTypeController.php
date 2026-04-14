<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClassTypeRequest;
use App\Services\Admin\ClassTypeService;
use Illuminate\Http\Request;

class ClassTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $classTypeService;

    protected $redirectUrl;

    public function __construct(ClassTypeService $classTypeService){
        $this->redirectUrl = 'admin/class_type';
        $this->classTypeService = $classTypeService;
    }


    public function index(){
        $data = [
            'pageTitle' => 'Class Type',
            'tableHeads' => ['Id', 'Title', 'Status', 'Action'],
            'dataUrl' => $this->redirectUrl.'/get-data',
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'title', 'name' => 'title'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
        ];

        return view('classType.index', $data);
    }

    public function getData(Request $request){

        return $this->classTypeService->getAllData($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $data = [
            'pageTitle' => 'Class Type Create',
        ];
        return view('classType.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClassTypeRequest $request) {

        $classType = $this->classTypeService->create($request->all());
        if ($classType){
            $request->session()->flash('success', setMessage('create', 'Class Type'));
            return redirect()->route('class_type.index');
        }

        $request->session()->flash('error', setMessage('create.error', 'Class Type'));
        return redirect()->route('class_type.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ClassType  $classType
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $data = [
            'pageTitle' => 'Class Type Details',
            'classType' => $this->classTypeService->find($id)
        ];

        if ($data['classType']) {
            return view('classType.view', $data);
        }

        return redirect($this->redirectUrl)->with('message', setMessage('error', 'Class Type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ClassType  $classType
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $data = [
            'pageTitle' => 'Edit Class Type',
            'classType' => $this->classTypeService->find($id),
        ];
        return view('classType.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ClassType  $classType
     * @return \Illuminate\Http\Response
     */
    public function update(ClassTypeRequest $request, $id) {

        $classType = $this->classTypeService->update($request->all(), $id);

        if ($classType){
            $request->session()->flash('success', setMessage('update', 'Class Type'));
            return redirect()->route('class_type.index');
        }

        $request->session()->flash('error', setMessage('update.error', 'Class Type'));
        return redirect()->route('class_type.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ClassType  $classType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClassType $classType)
    {
        //
    }
}
