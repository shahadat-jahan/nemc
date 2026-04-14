<?php

namespace App\Http\Controllers\Admin;

use App\Course;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Services\Admin\CourseService;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $course;

    protected $redirectUrl;

    protected $courseService;



    public function __construct(CourseService $courseService){
        $this->redirectUrl = 'admin/course';
        $this->courseService = $courseService;
    }




    public function index(){
        $data = [
            'pageTitle' => 'Course',
            'tableHeads' => ['Id', 'Title', 'Status', 'Action'],
            'dataUrl' => $this->redirectUrl.'/get-data',
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'title', 'name' => 'title'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
        ];

        return view('course.index', $data);
    }

    public function getData(Request $request){

        return $this->courseService->getAllData($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $data = [
            'pageTitle' => 'Course Create',
        ];
        return view('course.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseRequest $request)
    {

        $this->courseService->create($request->all());

        return redirect()->route('course.index')->with('message', setMessage('create', 'Course'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $data = [
            'pageTitle' => 'Course Details',
            'course' => $this->courseService->find($id)
        ];

        if ($data['course']) {
            return view('course.view', $data);
        }

        redirect()->route('course.index')->with('message', setMessage('error', 'Course Not Fpund'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $data = [
            'pageTitle' => 'Course Edit',
            'course' => $this->courseService->find($id),
        ];
        return view('course.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(CourseRequest $request,$id) {

        $course = $this->courseService->update($request->all(), $id);
        if ($course) {
            $request->session()->flash('success', setMessage('update', 'Course'));
            return redirect()->route('course.index');
        } else {
            $request->session()->flash('error', setMessage('update.error', 'Course'));
            return redirect()->route('course.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        //
    }
}
