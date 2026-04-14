<?php

namespace App\Http\Controllers\FrontEnd;

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
        $this->redirectUrl = 'nemc/subject';
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

        return view('frontend.subject.index', $data);
    }

    public function getData(Request $request) {

        return $this->subjectService->getAllData($request);
    }

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
        //dd( $data['examCategories']);
        return view('frontend.subject.view', $data);
    }

    public function getSubjectsBySessionCourseAndPhase(Request $request){
        $subjects = [];
        if (!empty($request->sessionId) && !empty($request->courseId) && !empty($request->phaseId)) {
            $subjects = $this->subjectService->getSubjectsBySessionIdCourseIdPhaseId($request->sessionId, $request->courseId, $request->phaseId);
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

    public function getSubjectsByGroupId(Request $request)
    {
        $subjects = [];
        if (!empty($request->sessionId) && !empty($request->courseId) && !empty($request->subjectGroupId)) {
            $subjects = $this->subjectService->getSubjectsByGroupIdAndCourseId($request->sessionId, $request->courseId, $request->subjectGroupId);
        }
        
        return response()->json(['status' => true, 'data' => $subjects]);
    }
}
