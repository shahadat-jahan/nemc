<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubjectRequest;
use App\Services\Admin\DepartmentService;
use App\Services\Admin\ExamCategoryService;
use App\Services\Admin\ExamSubTypeService;
use App\Services\Admin\SubjectGroupService;
use App\Services\Admin\SubjectService;
use App\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $subjectService;
    protected $subjectGroupService;
    protected $examCategoryService;
    protected $examSubTypeService;
    protected $departmentService;

    protected $redirectUrl;

    public function __construct(SubjectService $subjectService,
         SubjectGroupService $subjectGroupService, ExamCategoryService $examCategoryService,
         ExamSubTypeService $examSubTypeService, DepartmentService $departmentService){
        $this->redirectUrl = 'admin/subject';
        $this->subjectService = $subjectService;
        $this->subjectGroupService = $subjectGroupService;
        $this->examCategoryService = $examCategoryService;
        $this->examSubTypeService = $examSubTypeService;
        $this->departmentService = $departmentService;
    }


    public function index(){
        $data = [
            'pageTitle' => 'Subject',
            'tableHeads' => ['Id', 'Subject Name', 'Course', 'Subject Group', 'Code', 'Status', 'Action'],
            'dataUrl' => $this->redirectUrl.'/get-data',
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'title', 'name' => 'title'],
                ['data' => 'course_id', 'name' => 'course_id'],
               /* ['data' => 'department_id', 'name' => 'department_id'],*/
                ['data' => 'subject_group_id', 'name' => 'subject_group_id'],
                ['data' => 'code', 'name' => 'code'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
        ];
        $data['subjectGroups'] = $this->subjectGroupService->getAllSubjectGroup();

        return view('subject.index', $data);
    }

    public function getData(Request $request) {

        return $this->subjectService->getAllData($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $data = [
            'pageTitle' => 'Subject Create',
        ];

        //get all department
        $data['departments'] = $this->departmentService->getAllDepartment();
        //get all subject group
        $data['subjectGroups'] = $this->subjectGroupService->getAllSubjectGroup();
        //get all exam category
        $data['examCategories'] = $this->examCategoryService->getAllExamCategory();
        //get all exam Sub Type
        $data['examSubTypes'] = $this->examSubTypeService->getAllExamSubType();
        return view('subject.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubjectRequest $request) {

        $subject = $this->subjectService->saveSubject($request);

        if ($subject) {
            $request->session()->flash('success', setMessage('create', 'Subject'));
            return redirect()->route('subject.index');
        } else {
            $request->session()->flash('error', setMessage('create.error', 'Subject'));
            return redirect()->route('subject.index');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $data = [
            'pageTitle' => 'Subject Detail',
            'subject' => $this->subjectService->find($id),
        ];

        //get all department
        $data['departments'] = $this->departmentService->getAllDepartment();
        //get all subject group
        $data['subjectGroups'] = $this->subjectGroupService->getAllSubjectGroup();
        //get all exam category
        $data['examCategories'] = $this->examCategoryService->getAllExamCategory();
        //get all exam Sub Type
        $data['examSubTypes'] = $this->examSubTypeService->getAllExamSubType();
        return view('subject.view', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $data = [
            'pageTitle' => 'Subject  Edit',
            'subject' => $this->subjectService->find($id),
        ];

        //get all department
        $data['departments'] = $this->departmentService->getAllDepartment();
        //get all subject group
        $data['subjectGroups'] = $this->subjectGroupService->getAllSubjectGroup();
        //get all exam category
        /*$data['examCategories'] = $this->examCategoryService->getAllExamCategory();*/
        //get all exam Sub Type
        $data['examSubTypes'] = $this->examSubTypeService->getAllExamSubType();

        return view('subject.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(SubjectRequest $request, $id) {

        $subject = $this->subjectService->updateSubject($request->all(), $id);

        if ($subject) {
            $request->session()->flash('success', setMessage('update', 'Subject'));
            return redirect()->route('subject.index');
        } else {
            $request->session()->flash('error', setMessage('update.error', 'Subject'));
            return redirect()->route('subject.index');
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

    public function getSubjectsBySessionCourseAndPhase(Request $request){
        $subjects = [];
        if (!empty($request->sessionId) && !empty($request->courseId) && !empty($request->phaseId)) {
            $subjects = $this->subjectService->getSubjectsBySessionIdCourseIdPhaseId($request->sessionId, $request->courseId, $request->phaseId);
        }

        return response()->json(['status' => true, 'data' => $subjects]);
    }

    public function getSubjectGroupsBySessionCourseAndPhase(Request $request){
        $subjectGroup = [];
        if (!empty($request->sessionId) && !empty($request->courseId) && !empty($request->phaseId)) {
            $subjectGroup = $this->subjectService->getCourseSubjectGroupsBySessionIdCourseIdPhaseId($request->sessionId, $request->courseId, $request->phaseId);
        }

        return response()->json(['status' => true, 'data' => $subjectGroup]);
    }

    public function getSubjectsByCourse(Request $request){
        $subjects = [];
        if (!empty($request->sessionId) && !empty($request->courseId)) {
            $subjects = $this->subjectService->getSubjectsByCourseId($request->sessionId, $request->courseId);
        }

        return response()->json(['status' => true, 'data' => $subjects]);
    }

    public function getSubjectsByGroupId(Request $request){
        $subjects = [];
        if (!empty($request->sessionId) && !empty($request->courseId) && !empty($request->subjectGroupId)) {
            $subjects = $this->subjectService->getSubjectsByGroupIdAndCourseId($request->sessionId, $request->courseId, $request->subjectGroupId,);
        }

        return response()->json(['status' => true, 'data' => $subjects]);
    }

    public function getSubjectGroupsBySessionAndCourse(Request $request){
        $subjectGroups = [];
        if (!empty($request->sessionId) && !empty($request->courseId)) {
            $subjectGroups = $this->subjectGroupService->getAllSubjectGroupBySessionIdCourseId($request->sessionId, $request->courseId);
        }

        return response()->json(['status' => true, 'data' => $subjectGroups]);

    }

    public function getSubjectsByCourseAndSubjectGroup(Request $request){
        $subjects = [];
        if (!empty($request->courseId) && !empty($request->subjectGroupId)) {
            $subjects = $this->subjectService->getAllSubjectByCourseIdAndSubjectGroupId($request->courseId, $request->subjectGroupId);
        }

        return response()->json(['status' => true, 'data' => $subjects]);

    }
}
