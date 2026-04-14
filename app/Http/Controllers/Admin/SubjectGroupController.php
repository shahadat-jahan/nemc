<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubjectGroupRequest;
use App\Services\Admin\CourseService;
use App\Services\Admin\SubjectGroupService;
use App\Subject;
use Illuminate\Http\Request;

class SubjectGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $subjectGroupService;
    protected $courseService;

    protected $redirectUrl;

    public function __construct(SubjectGroupService $subjectGroupService, CourseService $courseService){
        $this->redirectUrl = 'admin/subject_group';
        $this->subjectGroupService = $subjectGroupService;
        $this->courseService = $courseService;
    }


    public function index(){
        $data = [
            'pageTitle' => 'Subject Group',
            'tableHeads' => ['Id', 'Title', 'Course',  'Status', 'Action'],
            'dataUrl' => $this->redirectUrl.'/get-data',
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'title', 'name' => 'title'],
                ['data' => 'course_id', 'name' => 'course_id'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
        ];

        return view('subjectGroup.index', $data);
    }

    public function getData(Request $request) {

        return $this->subjectGroupService->getAllData($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $data = [
            'pageTitle' => 'Subject Group Create',
        ];

        //get all course
        $data['courses'] = $this->courseService->getAllCourse();
        return view('subjectGroup.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubjectGroupRequest $request) {

        $subjectGroup = $this->subjectGroupService->create($request->all());

        if ($subjectGroup) {
            $request->session()->flash('success', setMessage('create', 'Subject Group'));
            return redirect()->route('subject_group.index');
        } else {
            $request->session()->flash('error', setMessage('create.error', 'Subject Group'));
            return redirect()->route('subject_group.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $data = [
            'pageTitle' => 'Subject Group Edit',
            'subjectGroup' => $this->subjectGroupService->find($id),
        ];
        //get all course
        $data['courses'] = $this->courseService->getAllCourse();
        return view('subjectGroup.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(SubjectGroupRequest $request, $id) {

        $subjectGroup = $this->subjectGroupService->update($request->all(), $id);


        if ($subjectGroup) {
            $request->session()->flash('success', setMessage('update', 'Subject Group'));
            return redirect()->route('subject_group.index');
        } else {
            $request->session()->flash('error', setMessage('update.error', 'Subject Group'));
            return redirect()->route('subject_group.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        //
    }

    public function getSubjectGroupBySessionCoursePhase(Request $request){

        $subjectGroups = [];
        if (!empty($request->sessionId) && !empty($request->courseId) && !empty($request->phaseId)) {

            $subjectGroups = $this->subjectGroupService->getAllSubjectGroupBySessionIdCourseIdPhaseId($request->sessionId, $request->courseId, $request->phaseId);
        }

        return response()->json(['status' => true, 'data' => $subjectGroups]);
    }
    //get subject group by course
    public function getSubjectGroupByCourse(Request $request){
        $subjectGroups = [];
        if (!empty($request->courseId)) {
            $subjectGroups = $this->subjectGroupService->getAllSubjectGroupByCourseId($request->courseId);
        }
        return response()->json(['status' => true, 'data' => $subjectGroups]);
    }
}
