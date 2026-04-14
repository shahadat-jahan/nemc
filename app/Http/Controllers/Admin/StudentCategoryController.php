<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentCategoryRequest;
use App\Services\Admin\StudentCategoryService;
use App\StudentCategory;
use Illuminate\Http\Request;

class StudentCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $studentCategoryService;

    protected $redirectUrl;

    public function __construct(StudentCategoryService $studentCategoryService){
        $this->redirectUrl = 'admin/student_category';
        $this->studentCategoryService = $studentCategoryService;
    }


    public function index(){
        $data = [
            'pageTitle' => 'Student Category',
            'tableHeads' => ['Id', 'Title', 'Status', 'Action'],
            'dataUrl' => $this->redirectUrl.'/get-data',
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'title', 'name' => 'title'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
        ];

        return view('studentCategory.index', $data);
    }

    public function getData(Request $request){

        return $this->studentCategoryService->getAllData($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $data = [
            'pageTitle' => 'Student Category Create',
        ];
        return view('studentCategory.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentCategoryRequest $request) {

        $studentCategory = $this->studentCategoryService->create($request->all());

        if ($studentCategory) {
            $request->session()->flash('success', setMessage('create', 'Student Category'));
            return redirect()->route('student_category.index');
        } else {
            $request->session()->flash('error', setMessage('create.error', 'Student Category'));
            return redirect()->route('student_category.index');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StudentCategory  $studentCategory
     * @return \Illuminate\Http\Response
     */
    public function show(StudentCategory $studentCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StudentCategory  $studentCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $data = [
            'pageTitle' => 'Edit Student Category',
            'studentCategory' => $this->studentCategoryService->find($id),
        ];
        return view('studentCategory.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StudentCategory  $studentCategory
     * @return \Illuminate\Http\Response
     */
    public function update(StudentCategoryRequest $request, $id) {

        $studentCategory = $this->studentCategoryService->update($request->all(), $id);

        if ($studentCategory) {
            $request->session()->flash('success', setMessage('update', 'Student Category'));
            return redirect()->route('student_category.index');
        } else {
            $request->session()->flash('error', setMessage('update.error', 'Student Category'));
            return redirect()->route('student_category.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StudentCategory  $studentCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentCategory $studentCategory)
    {
        //
    }
}
