<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExamCategoryRequest;
use App\Http\Requests\ExamRequest;
use App\Models\Exam;
use App\Models\ExamSubject;
use App\Models\ExamSubjectMark;
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
use Auth;
use DB;
use Exception;
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
    )
    {
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
    public function index()
    {
        $data = [
            'pageTitle' => 'Exam Category',
            'tableHeads' => ['Id', 'Title', 'Status', 'Action'],
            'dataUrl' => $this->redirectUrl . '/get-data',
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'title', 'name' => 'title'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
        ];

        return view('examCategory.index', $data);
    }

    /**
     * @param Request $request
     * @return \App\Services\Admin\JsonResponse
     */
    public function getData(Request $request)
    {

        return $this->examCategoryService->getAllData($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'pageTitle' => 'Exam Category Create',
        ];
        return view('examCategory.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExamCategoryRequest $request)
    {

        $examCategory = $this->examCategoryService->create($request->all());
        if ($examCategory) {
            $request->session()->flash('success', setMessage('create', 'Exam Category'));
            return redirect()->route('exam_category.index');
        }

        $request->session()->flash('error', setMessage('create.error', 'Exam Category'));
        return redirect()->route('exam_category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Exam $exam
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = [
            'pageTitle' => 'Exam Category Details',
            'examCategory' => $this->examCategoryService->find($id)
        ];

        if ($data['examCategory']) {
            return view('examCategory.view', $data);
        }

        return redirect($this->redirectUrl)->with('message', setMessage('error', 'Exam Category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Exam $exam
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [
            'pageTitle' => 'Edit Exam Category',
            'examCategory' => $this->examCategoryService->find($id),
        ];
        return view('examCategory.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Exam $exam
     * @return \Illuminate\Http\Response
     */
    public function update(ExamCategoryRequest $request, $id)
    {

        $examCategory = $this->examCategoryService->update($request->all(), $id);

        if ($examCategory) {
            $request->session()->flash('success', setMessage('update', 'Exam Category'));
            return redirect()->route('exam_category.index');
        }

        $request->session()->flash('error', setMessage('update.error', 'Exam Category'));
        return redirect()->route('exam_category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Exam $exam
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exam $exam)
    {
        //
    }

    /**
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getExams()
    {
        $examCategories = $this->examCategoryService->listByStatus();
//        unset($examCategories[1]);

        $data = [
            'pageTitle' => 'Exam Setup',
            'tableHeads' => ['ID', 'Title', 'Exam Category', 'Session', 'Course', 'Phase', 'Term', 'Status', 'Action'],
            'dataUrl' => 'admin/exams/get-data',
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'title', 'name' => 'title'],
                ['data' => 'exam_category_id', 'name' => 'exam_category_id'],
                ['data' => 'session_id', 'name' => 'session_id'],
                ['data' => 'course_id', 'name' => 'course_id'],
                ['data' => 'phase_id', 'name' => 'phase_id'],
                ['data' => 'term_id', 'name' => 'term_id'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
            'sessions' => $this->sessionService->listByStatus(),
            'courses' => $this->courseService->listByStatus(),
            'phases' => $this->phaseService->listByStatus(),
            'terms' => $this->termService->listByStatus(),
            'examCategories' => $examCategories,
            'subjects' => $this->subjectService->listByStatus(),
        ];

        return view('exams.index', $data);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getExamsDatatable(Request $request)
    {
        return $this->service->getExamsDatatable($request);
    }

    /**
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createExam()
    {
        $examCategories = $this->examCategoryService->listByStatus();
        unset($examCategories[1]);

        $data = [
            'pageTitle' => 'Create Exam',
            'sessions' => $this->sessionService->listByStatus(),
            'courses' => $this->courseService->listByStatus(),
            'phases' => $this->phaseService->listByStatus(),
            'terms' => $this->termService->listByStatus(),
            'examCategories' => $examCategories,
            'batches' => $this->batchTypeService->listByStatus(),
            'examType' => $this->examTypeService->listByStatus(),
        ];
        return view('exams.add', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveExam(ExamRequest $request)
    {
        $exam = $this->service->saveExam($request);

        if ($exam === 403) {
            $request->session()->flash('error', 'Exam sub-type & date are required');
            return redirect()->route('exams.list');
        }

        if ($exam) {
            $request->session()->flash('success', setMessage('create', 'Exam - ' . $exam->id));
        } else {
            $request->session()->flash('error', setMessage('create.error', 'Exam'));
        }
        return redirect()->route('exams.list');
    }

    /**
     * @param $id
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getExamDetail($id)
    {
        $data = [
            'pageTitle' => 'Exam Detail',
            'examInfo' => $this->service->find($id),
            'writtenExams' => $this->service->getWrittenExamsByExamId($id),
            'practicalExams' => $this->service->getPracticalExamsByExamId($id)
        ];

        return view('exams.view', $data);
    }

    /**
     * @param $id
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editExam($id)
    {
        $examCategories = $this->examCategoryService->listByStatus();
        unset($examCategories[5]); //remove supply exam category

        $examInfo = $this->service->findWith($id, ['examSubjects.studentGroups', 'examSubjects.examSubTypes']);
        $subjectGroups = $this->subjectGroupService->getSubjectGroupsBySessionIdCourseId($examInfo->session_id, $examInfo->course_id, $examInfo->phase_id)->pluck('title', 'id');

        $subjects = [];
        if (!empty($subjectGroups)) {
            foreach ($subjectGroups as $key => $groups) {
                $subject = $this->subjectService->findBy(['subject_group_id' => $key], 'list');
                $subjects[$key] = $subject;
            }
        }

        $subjectCards = [];
        if (isset($examInfo->examSubjects->last()->card_id)) {
            $subjectCards = $this->cardService->findBy([
                'subject_id' => $examInfo->examSubjects->last()->subject_id, 'status' => 1
            ], 'list')->pluck('title', 'id');
        }
        if (!empty($examInfo->examSubjects)) {
            foreach ($examInfo->examSubjects as $examSubject) {
                $departmentIds[$examSubject->subject_id] = $examSubject->subject->department->id;
            }
        }

        $data = [
            'pageTitle' => 'Edit Exam - ' . $examInfo->title,
            'sessions' => $this->sessionService->listByStatus(),
            'courses' => $this->courseService->listByStatus(),
            'phases' => $this->phaseService->listByStatus(),
            'terms' => $this->termService->listByStatus(),
            'examCategories' => $examCategories,
            'batches' => $this->batchTypeService->listByStatus(),
            //            'studentGroups' => $this->studentGroupService->findBy(['status' => 1, 'type' => 1, 'session_id' => $examInfo->session_id, 'course_id' => $examInfo->course_id], 'list'),
            'studentGroups' => $this->studentGroupService->getStudentGroupsBySessionCourseAndGroupTypeId($examInfo->session_id, $examInfo->course_id, $examInfo->phase_id, null, $departmentIds),
            'subjectGroups' => $subjectGroups,
            'subjectLists' => $subjects,
            'cards' => $subjectCards,
            'examType' => $this->examTypeService->listByStatus(),
            'examInfo' => $examInfo,
        ];

        return view('exams.edit', $data);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateExam(ExamRequest $request, $id)
    {
        $exam = $this->service->updateExam($request, $id);

        if ($exam === 403) {
            $request->session()->flash('error', 'Exam sub-type & date are required');
            return redirect()->route('exams.list');
        }

        if ($exam) {
            $request->session()->flash('success', setMessage('update', 'Exam ID ' . $exam->id));
        } else {
            $request->session()->flash('error', setMessage('update.error', 'Exam'));
        }
        return redirect()->route('exams.list');
    }

    public function deleteExam($id)
    {
        try {
            DB::beginTransaction();

            // Find the exam first to avoid errors
            $exam = $this->service->find($id);

            if (!$exam) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Exam not found.'
                ], 404);
            }

            // Check if any exam subjects have results published
            if ($exam->examSubjects->where('result_published', 1)->isNotEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Exam cannot be deleted as results have already been published.'
                ], 403);
            }

            if (!empty($exam->examMarks->first()) && (!empty($exam->examMarks->first()->toArray()) || $exam->examMarks->first()->toArray()->isNotEmpty())) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Exam cannot be deleted as marks have already been given.'
                ], 403);
            }

            // Delete related exam record
            $exam->examSubjects->each(function ($examSubject) {
                $examSubject->delete();
            });

            DB::table('exam_subject_marks')->where('exam_id', $exam->id)->delete();

            $exam->delete();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Exam deleted successfully.'
            ]);

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete exam. ' . $e->getMessage()
            ], 500);
        }
    }

    public function toggleStatus(Request $request)
    {
        $exam = Exam::findOrFail($request->id);
        $exam->status = !$exam->status;
        $exam->save();

        return response()->json([
            'success' => true,
            'message' => $exam->status ? 'Exam activated successfully.' : 'Exam deactivated successfully.',
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getExamSubTypes(Request $request)
    {
        $examSubTypes = [];
        if (!empty($request->subjectId) && !empty($request->examTypeId)) {
            $examSubTypes = $this->service->getExamSubTypesBySubjectIdAndExamTypeId($request->subjectId, $request->examTypeId);
        }

        return response()->json(['status' => true, 'data' => $examSubTypes]);
    }

    /**
     * @param $id
     */
    public function setupExamMarks($id)
    {
        $is_marks_entered = $this->service->check_marks_is_entered($id);
        $examInfo = $this->service->findWith($id, ['examSubjects.subject', 'examSubjects.examSubTypes', 'examMarks']);
        $examType = $examInfo->examSubjects->pluck('exam_type_id');
        $examSubjects = $examInfo->examSubjects->groupBy('subject_id');
        $examSubTypes = [];

        foreach ($examSubjects as $subjectId => $subject) {
            foreach ($subject as $examSub) {
                foreach ($examSub->examSubTypes as $examSubType) {
                    $examSubTypes[$subjectId][$examSubType->id] = $examSubType;
                }
            }
        }

        $data = [
            'pageTitle' => 'Setup Exam marks - ' . $examInfo->title,
            'examInfo' => $examInfo,
            'examSubjects' => $examSubjects,
            'examSubTypes' => $examSubTypes,
            'is_marks_entered' => $is_marks_entered,
        ];

        return view('exams.mark_setup', $data);
    }

    public function saveExamMarks(Request $request, $id)
    {
        $examMarks = $this->service->saveExamMarks($request, $id);

        if ($examMarks) {
            $request->session()->flash('success', setMessage('create', 'Exam Marks'));
        } else {
            $request->session()->flash('error', setMessage('create.error', 'Exam Marks'));
        }
        return redirect()->route('exams.list');
    }

    public function getExamsBySessionCoursePhaseTermType(Request $request)
    {
        $teacher = Auth::guard('web')->user()->teacher ?? null;

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
            $query = Exam::where($queryParams)->when($request->type === 'main_exam', function ($q) use ($request) {
                $q->whereDoesntHave('supplementaryExam', function ($q1) {
                    $q1->where('status', 1);
                })
                  ->whereHas('examSubjects', function ($q1) use ($request) {
                    $q1->where('result_published', 1);
                  })
                    //check for all student are not pass
                  ->whereHas('examMarks.result', function ($q2) {
                        $q2->whereIn('pass_status', [2, 3, 4]);
                    });
            })->when($request->type === 'result', function ($q) use ($request) {
                $q->whereHas('examSubjects', function ($q1) use ($request) {
                    $q1->where('result_published', 0);
                });
            });

            if ($teacher) {
                $query->whereHas('examSubjects.subject', function ($subQuery) use ($teacher) {
                    $subQuery->where('department_id', $teacher->department_id);
                });
            }

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

    public function getExamsSubjects(Request $request)
    {
        $examSubjects = [];
        if (!empty($request->examId)) {
            $exam = $this->service->find($request->examId);
            $subjects = $exam->examSubjects->whereNotNull('result_publish_date')->groupBy('subject_id');
            foreach ($subjects as $key => $subject) {
                $examSubjects[$key] = $subject[0]->subject;
            }
        }
        return response()->json(['status' => true, 'subjects' => $examSubjects]);
    }

    public function getExamsTypesSubtypes(Request $request)
    {
        $examTypes = [];
        if (!empty($request->examId) && !empty($request->subjectId)) {
            $examTypes = $this->examTypeService->getExamTypesSubTypesWithMarkByExamIdAndSubjectId($request->examId, $request->subjectId);
        }

        return response()->json(['status' => true, 'data' => $examTypes]);
    }

    public function checkExamExist(Request $request)
    {
        $check = $this->service->checkExamBySessionCoursePhaseTermCategorySubject($request);

        if ($check) {
            return response()->json(['status' => false, 'data' => $check]);
        }
        return response()->json(['status' => true]);
    }
}
