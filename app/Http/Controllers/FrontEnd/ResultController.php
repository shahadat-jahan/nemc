<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Services\Admin\CourseService;
use App\Services\Admin\ExamCategoryService;
use App\Services\Admin\ExamService;
use App\Services\Admin\ExamTypeService;
use App\Services\Admin\PhaseService;
use App\Services\Admin\SessionService;
use App\Services\Admin\SubjectService;
use App\Services\Admin\TeacherService;
use App\Services\Admin\TermService;
use App\Services\ResultService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{

    /**
     *
     */
    const moduleName = 'Result Management';
    /**
     *
     */
    const redirectUrl = 'nemc/result';
    /**
     *
     */
    const moduleDirectory = 'exam_result.';

    protected $service;
    protected $examService;
    protected $sessionService;
    protected $courseService;
    protected $phaseService;
    protected $termService;
    protected $examCategoryService;
    protected $teacherService;
    protected $subjectService;
    protected $examTypeService;

    public function __construct(
        ResultService $service, ExamService $examService, SessionService $sessionService, CourseService $courseService,
        PhaseService $phaseService, TermService $termService, ExamCategoryService $examCategoryService, TeacherService $teacherService,
        SubjectService $subjectService, ExamTypeService $examTypeService
    ){
        $this->service = $service;
        $this->examService = $examService;
        $this->sessionService = $sessionService;
        $this->courseService = $courseService;
        $this->phaseService = $phaseService;
        $this->termService = $termService;
        $this->examCategoryService = $examCategoryService;
        $this->teacherService = $teacherService;
        $this->subjectService = $subjectService;
        $this->examTypeService = $examTypeService;
    }


    public function index(Request $request){
//        if (!empty($request->session_id) && !empty($request->course_id)){
//            $examList = $this->service->getExamSubjectsAndMarks($request);
//        }else{
//            $examList = $this->service->getAllExamResults();
//        }
        $data = [
            'pageTitle' => 'Exam Result Management',
            'sessions' => $this->sessionService->listByStatus(),
            'courses' => $this->courseService->listByStatus(),
            'phases' => $this->phaseService->listByStatus(),
            'terms' => $this->termService->listByStatus(),
            'examCategories' => $this->examCategoryService->listByStatus(),
//            'exams' => $examList->where('result_published', 1)
            'tableHeads' => ['Sl.', 'Subject', 'Title', 'Exam Category', 'Session', 'Course', 'Phase', 'Term', 'Result Publish', 'Result Publish Date', 'Action'],
            'dataUrl' => self::redirectUrl . '/get-data',
            'columns' => [
                ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
                ['data' => 'subject_id', 'name' => 'subject_id'],
                ['data' => 'title', 'name' => 'title'],
                ['data' => 'exam_category_id', 'name' => 'exam_category_id'],
                ['data' => 'session_id', 'name' => 'session_id'],
                ['data' => 'course_id', 'name' => 'course_id'],
                ['data' => 'phase_id', 'name' => 'phase_id'],
                ['data' => 'term_id', 'name' => 'term_id'],
                ['data' => 'result_publish', 'name' => 'result_publish'],
                ['data' => 'publish_date', 'name' => 'publish_date'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
        ];

        return view('frontend.exam_result.index', $data);
    }

    public function getData(Request $request)
    {
        return $this->service->getDatatable($request);
    }



    public function show($id){

    }

    public function showExamSubjectResult($examId, $subjectId){

        $studentId = '';
        if (Auth::guard('student_parent')->check()){
            $user = Auth::guard('student_parent')->user();
            if ($user->user_group_id == 5){
                $studentId = $user->student->id;
            }else{
                $studentId = getStudentsIdByParentId($user->parent->id);
            }
        }


        $data = [
            'pageTitle' => 'Show Exam Result',
            'examInfo' => $this->examService->find($examId),
            'subject' => $this->subjectService->find($subjectId),
            'examTypeSubType' => $this->examTypeService->getExamTypesSubTypesWithMarkByExamIdAndSubjectId($examId, $subjectId),
            'examResult' => $this->service->getExamResultsByExamIdSubjectIdAndStudentId($examId, $subjectId, $studentId),
        ];

        return view('frontend.exam_result.show_single_subject', $data);

    }
}
