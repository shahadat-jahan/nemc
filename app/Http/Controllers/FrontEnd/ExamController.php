<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Services\Admin\Admission\StudentGroupService;
use App\Services\Admin\BatchTypeService;
use App\Services\Admin\CardService;
use App\Services\Admin\CourseService;
use App\Services\Admin\ExamCategoryService;
use App\Services\Admin\ExamService;
use App\Services\Admin\ExamSubTypeService;
use App\Services\Admin\ExamTypeService;
use App\Services\Admin\PhaseService;
use App\Services\Admin\SessionService;
use App\Services\Admin\SubjectGroupService;
use App\Services\Admin\SubjectService;
use App\Services\Admin\TermService;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $examCategoryService;

    protected $redirectUrl;

    protected $sessionService;
    protected $courseService;
    protected $batchTypeService;
    protected $phaseService;
    protected $termService;
    protected $examTypeService;
    protected $examSubTypeService;
    protected $service;
    protected $studentGroupService;
    protected $subjectGroupService;
    protected $subjectService;
    protected $cardService;

    public function __construct(
        ExamCategoryService $examCategoryService, SessionService $sessionService, CourseService $courseService, BatchTypeService $batchTypeService,
        PhaseService $phaseService, TermService $termService, ExamTypeService $examTypeService, ExamSubTypeService $examSubTypeService, ExamService $service,
        StudentGroupService $studentGroupService, SubjectGroupService $subjectGroupService, SubjectService $subjectService, CardService $cardService
    ){
        $this->redirectUrl = 'admin/exam_category';
        $this->examCategoryService = $examCategoryService;
        $this->sessionService = $sessionService;
        $this->courseService = $courseService;
        $this->batchTypeService = $batchTypeService;
        $this->phaseService = $phaseService;
        $this->termService = $termService;
        $this->examTypeService = $examTypeService;
        $this->examSubTypeService = $examSubTypeService;
        $this->service = $service;
        $this->studentGroupService = $studentGroupService;
        $this->subjectGroupService = $subjectGroupService;
        $this->subjectService = $subjectService;
        $this->cardService = $cardService;
    }


    /**
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getExams(){
        $data = [
            'pageTitle' => 'Exam Setup',
            'tableHeads' => ['Title', 'Course' ,'Phase', 'Term', 'Exam Category', 'Year' ,'Action'],
            'dataUrl' => 'nemc/exams/get-data',
            'columns' => [
                ['data' => 'title', 'name' => 'title'],
                ['data' => 'course_id', 'name' => 'course_id'],
                ['data' => 'phase_id', 'name' => 'phase_id'],
                ['data' => 'term_id', 'name' => 'term_id'],
                ['data' => 'exam_category_id', 'name' => 'exam_category_id'],
                ['data' => 'year', 'name' => 'year'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
            'sessions' => $this->sessionService->listByStatus(),
            'courses' => $this->courseService->listByStatus(),
            'phases' => $this->phaseService->listByStatus(),
            'terms' => $this->termService->listByStatus(),
        ];

        return view('frontend.exams.index', $data);

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getExamsDatatable(Request $request){
        return $this->service->getExamsDatatable($request);
    }


    public function getExamDetail($id){
        $data = [
            'pageTitle' => 'Exam Detail',
            'examInfo' => $this->service->find($id),
            'writtenExams' => $this->service->getWrittenExamsByExamId($id),
            'practicalExams' => $this->service->getPracticalExamsByExamId($id)
        ];

        return view('frontend.exams.view', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getExamSubTypes(Request $request){
        $examSubTypes = [];
        if (!empty($request->subjectId) && !empty($request->examTypeId)) {
            $request->examTypeId = ($request->examTypeId == 5) ? 4 : $request->examTypeId;

            $examSubTypes = $this->service->getExamSubTypesBySubjectIdAndExamTypeId($request->subjectId, $request->examTypeId);
        }

        return response()->json(['status' => true, 'data' => $examSubTypes]);
    }

    /**
     * @param $id
     */
    public function setupExamMarks($id){
        $examInfo = $this->service->find($id);
        $examSubjects = $examInfo->examSubjects->where('exam_type_id', 3)->groupBy('subject_id');

        $examSubTypes = [];
        foreach ($examSubjects as $subject) {
            $subType = $this->examSubTypeService->getExamTypesSubTypesBySubjectId($subject[0]->subject_id);
            $examSubTypes[$subject[0]->subject_id] = $subType;
        }

        $data = [
            'pageTitle' => 'Setup Exam marks - '.$examInfo->title,
            'examInfo' => $examInfo,
            'examSubjects' => $examSubjects,
            'examSubTypes' => $examSubTypes,
        ];

        return view('exams.mark_setup', $data);
    }

    public function saveExamMarks(Request $request, $id){
        $examMarks = $this->service->saveExamMarks($request, $id);

        if ($examMarks) {
            $request->session()->flash('success', setMessage('create', 'Exam Marks'));
        } else {
            $request->session()->flash('error', setMessage('create.error', 'Exam Marks'));
        }
        return redirect()->route('exams.list');
    }

    public function getExamsBySessionCoursePhaseTermType(Request $request){
        // Prepare the query parameters
        $queryParams = array_filter([
            'session_id' => $request->sessionId,
            'course_id' => $request->courseId,
            'phase_id' => $request->phaseId,
            'term_id' => $request->termId,
            'exam_category_id' => $request->examCategoryId,
            'status' => 1,
        ]);

        try {
            $query = Exam::where($queryParams)->when($request->type === 'supply_exam', function ($q) use ($request) {
                $q->whereDoesntHave('supplementaryExam');
                $q->whereHas('examSubjects', function ($q1) use ($request) {
                    $q1->where('result_published', 1);
                });
            })->when($request->type === 'result', function ($q) use ($request) {
                $q->whereHas('examSubjects', function ($q1) use ($request) {
                    $q1->where('result_published', 0);
                });
            });

            $exams = $query->get();

            return response()->json([
                'status' => true,
                'exams' => $exams,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false, 'error' => $e->getMessage()
            ]);
        }
    }

    public function getExamsSubjects(Request $request){
        $examSubjects = [];
        if (!empty($request->examId)){
            $exam = $this->service->find($request->examId);
            $subjects =  $exam->examSubjects->where('exam_type_id', 3)->groupBy('subject_id');
            foreach ($subjects as $key => $subject){
                $examSubjects[$key] = $subject[0]->subject;
            }

        }
        return response()->json(['status' => true, 'subjects' => $examSubjects]);
    }

    public function getExamsTypesSubtypes(Request $request){
        $examTypes = [];
        if (!empty($request->examId) && !empty($request->subjectId)){
            $examTypes = $this->examTypeService->getExamTypesSubTypesWithMarkByExamIdAndSubjectId($request->examId, $request->subjectId);
        }

        return response()->json(['status' => true, 'data' => $examTypes]);
    }

    public function getExamsBySessionCoursePhaseTermSubject(Request $request)
    {
        $exams = [];
        if (!empty($request->sessionId) && !empty($request->courseId) && !empty($request->phaseId) && !empty($request->termId) && !empty($request->subjectId) && !empty($request->examCategoryId)) {
            $exams = Exam::where('session_id', $request->sessionId)
                ->where('course_id', $request->courseId)
                ->where('phase_id', $request->phaseId)
                ->where('term_id', $request->termId)
                ->where('exam_category_id', $request->examCategoryId)
                ->whereHas('examSubjects', function ($query) use ($request) {
                    $query->where('subject_id', $request->subjectId);
                })
                ->where('status', 1)
                ->get();
        }
        return response()->json(['status' => true, 'exams' => $exams]);
    }
}
