<?php

namespace App\Http\Controllers\Admin;

/*use App\ExamType;*/
use App\Http\Controllers\Controller;
use App\Http\Requests\ExamTypeRequest;
use App\Services\Admin\ExamTypeService;
use Illuminate\Http\Request;

class ExamTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $examTypeService;

    protected $redirectUrl;

    public function __construct(ExamTypeService $examTypeService){
        $this->redirectUrl = 'admin/exam_type';
        $this->examTypeService = $examTypeService;
    }


    public function index(){
        $data = [
            'pageTitle' => 'Exam Type',
            'tableHeads' => ['Id', 'Title', 'Status', 'Action'],
            'dataUrl' => $this->redirectUrl.'/get-data',
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'title', 'name' => 'title'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
        ];

        return view('examType.index', $data);
    }

    public function getData(Request $request){

        return $this->examTypeService->getAllData($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $data = [
            'pageTitle' => 'Exam Type Create',
        ];
        return view('examType.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExamTypeRequest $request) {

        $examType = $this->examTypeService->create($request->all());
        if ($examType) {
            $request->session()->flash('success', setMessage('create', 'Exam Type'));
            return redirect()->route('exam_type.index');
        } else {
            $request->session()->flash('error', setMessage('create.error', 'Exam Type'));
            return redirect()->route('exam_type.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ExamSubType  $examSubType
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $data = [
            'pageTitle' => 'Exam Type Details',
            'examType' => $this->examTypeService->find($id)
        ];

        if ($data['examType']) {

            return view('examType.view', $data);
        }

        return redirect()->route('exam_type.index')->with('message', setMessage('error', 'Exam Type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ExamSubType  $examSubType
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $data = [
            'pageTitle' => 'Edit Exam Type',
            'examType' => $this->examTypeService->find($id),
        ];
        return view('examType.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ExamSubType  $examSubType
     * @return \Illuminate\Http\Response
     */
    public function update(ExamTypeRequest $request, $id) {

        $examType = $this->examTypeService->update($request->all(), $id);

        if ($examType) {
            $request->session()->flash('success', setMessage('update', 'Exam Type'));
            return redirect()->route('exam_type.index');
        } else {
            $request->session()->flash('error', setMessage('update.error', 'Exam Type'));
            return redirect()->route('exam_type.index');
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
