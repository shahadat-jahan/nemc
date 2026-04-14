<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
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

    public function __construct(SubjectGroupService $subjectGroupService){
        $this->redirectUrl = 'nemc/subject_group';
        $this->subjectGroupService = $subjectGroupService;
    }

    public function index(){
        $data = [
            'pageTitle' => 'Subject Group',
            'tableHeads' => ['Id', 'Title', 'Course',  'Status'],
            'dataUrl' => $this->redirectUrl.'/get-data',
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'title', 'name' => 'title'],
                ['data' => 'course_id', 'name' => 'course_id'],
                ['data' => 'status', 'name' => 'status'],
            ],
        ];

        return view('frontend.subjectGroup.index', $data);
    }

    public function getData(Request $request) {

        return $this->subjectGroupService->getAllData($request);
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
