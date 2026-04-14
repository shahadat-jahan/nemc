<?php

namespace App\Http\Controllers\Admin;

use App\ExamSubType;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExamSubTypeRequest;
use App\Services\Admin\ExamSubTypeService;
use App\Services\Admin\ExamTypeService;
use function GuzzleHttp\Promise\all;
use Illuminate\Http\Request;

class ExamSubTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $examSubTypeService;
    protected $examTypeService;

    protected $redirectUrl;

    public function __construct(ExamSubTypeService $examSubTypeService, ExamTypeService $examTypeService){
        $this->redirectUrl = 'admin/exam_sub_type';
        $this->examSubTypeService = $examSubTypeService;
        $this->examTypeService = $examTypeService;
    }


    public function index(){
        $data = [
            'pageTitle' => 'Exam Sub Type',
            'tableHeads' => ['Id',  'Title' , 'Exam Type', 'Status', 'Action'],
            'dataUrl' => $this->redirectUrl.'/get-data',
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'title', 'name' => 'title'],
                ['data' => 'exam_type_id', 'name' => 'exam_type_id'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
        ];
        $data['examTypes'] = $this->examTypeService->allExamType();

        return view('examSubType.index', $data);
    }

    public function getData(Request $request){

        return $this->examSubTypeService->getAllData($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'pageTitle' => 'Exam Type Create',
        ];
        //get all exam type
        $data['examTypes'] = $this->examTypeService->allExamType();
        return view('examSubType.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExamSubTypeRequest $request) {

        $examSubType = $this->examSubTypeService->create($request->all());

        if ($examSubType) {
            $request->session()->flash('success', setMessage('create', 'Exam Sub Type'));
            return redirect()->route('exam_sub_type.index');
        } else {
            $request->session()->flash('error', setMessage('create.error', 'Exam Sub Type'));
            return redirect()->route('exam_sub_type.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ExamSubType  $examSubType
     * @return \Illuminate\Http\Response
     */
    public function show(ExamSubType $examSubType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ExamSubType  $examSubType
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $data = [
            'pageTitle' => 'Exam Sub Type Edit',
            'examSubType' => $this->examSubTypeService->find($id),
        ];
        $data['examTypes'] = $this->examTypeService->allExamType();
        return view('examSubType.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ExamSubType  $examSubType
     * @return \Illuminate\Http\Response
     */
    public function update(ExamSubTypeRequest $request, $id) {

        $examSubType = $this->examSubTypeService->update($request->all(), $id);

        if ($examSubType) {
            $request->session()->flash('success', setMessage('update', 'Exam Sub Type'));
            return redirect()->route('exam_sub_type.index');
        } else {
            $request->session()->flash('error', setMessage('update.error', 'Exam Sub Type'));
            return redirect()->route('exam_sub_type.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ExamSubType  $examSubType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExamSubType $examSubType)
    {
        //
    }
}
