<?php

namespace App\Http\Controllers\Admin;

use App\Events\NotifySuperAdminOnResultEditRequested;
use App\Events\NotifyUserOnEditPermissionGiven;
use App\Http\Controllers\Controller;
use App\Models\ExamSubject;
use App\Services\Admin\Admission\StudentGroupService;
use App\Services\Admin\CourseService;
use App\Services\Admin\ExamCategoryService;
use App\Services\Admin\ExamService;
use App\Services\Admin\ExamTypeService;
use App\Services\Admin\PhaseService;
use App\Services\Admin\SessionService;
use App\Services\Admin\StudentService;
use App\Services\Admin\SubjectService;
use App\Services\Admin\TeacherService;
use App\Services\Admin\TermService;
use App\Services\ResultService;
use App\Services\Admin\StatusService;
use App\Exports\ExamResultsExport;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class ResultController extends Controller
{

    /**
     *
     */
    const moduleName = 'Result Management';
    /**
     *
     */
    const redirectUrl = 'admin/result';
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
    protected $statusService;
    protected $studentService;
    protected $studentGroupService;

    public function __construct(
        ResultService $service, ExamService $examService, SessionService $sessionService, CourseService $courseService,
        PhaseService  $phaseService, TermService $termService, ExamCategoryService $examCategoryService, TeacherService $teacherService,
        SubjectService      $subjectService, ExamTypeService $examTypeService, StatusService $statusService, StudentService $studentService,
        StudentGroupService $studentGroupService
    )
    {
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
        $this->statusService = $statusService;
        $this->studentService = $studentService;
        $this->studentGroupService = $studentGroupService;
    }

    public function index(Request $request)
    {
        if (!empty($request->session_id) && !empty($request->course_id)) {
            $examList = $this->service->getExamSubjectsAndMarks($request);
        } else {
            $examList = $this->service->getAllExamResults();
        }

        $data = [
            'pageTitle' => 'Exam Result Management',
            'sessions' => $this->sessionService->listByStatus(),
            'courses' => $this->courseService->listByStatus(),
            'phases' => $this->phaseService->listByStatus(),
            'terms' => $this->termService->listByStatus(),
            'examCategories' => $this->examCategoryService->listByStatus(),
            'statuses' => $this->statusService->statusList(1),
            'tableHeads' => [
                'Sl.', 'Subject', 'Title', 'Exam Category', 'Session', 'Course', 'Phase', 'Term', 'Result Publish',
                'Result Publish Date', 'Action'
            ],
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
        return view('exam_result.index', $data);
    }

    public function getData(Request $request)
    {
        return $this->service->getDatatable($request);
    }

    public function create()
    {

        $examCategories = $this->examCategoryService->listByStatus();
//        unset($examCategories[1]);

        $data = [
            'pageTitle' => 'Submit Exam Result',
            'sessions' => $this->sessionService->listByStatus(),
            'courses' => $this->courseService->listByStatus(),
            'phases' => $this->phaseService->listByStatus(),
            'terms' => $this->termService->listByStatus(),
            'examCategories' => $examCategories,
            'teachers' => $this->teacherService->findBy(['status' => 1], 'list')->pluck('full_name', 'id'),
        ];

        return view('exam_result.add', $data);
    }

    public function store(Request $request)
    {
        try {
            $result = $this->service->saveStudentsResult($request);

            if (is_object($result) && isset($result->info)) {
                $status = $result->info['status'] ?? true;
                $message = $result->info['message'] ?? 'Exam results processed successfully';

                $flashType = $status === false ? 'error' : 'success';

                $request->session()->flash($flashType, $message);
            } else {
                $request->session()->flash('success', setMessage('create', 'Exam results'));
            }
        } catch (Exception $e) {
            Log::error('Error saving exam results: ' . $e->getMessage(), ['exception' => $e]);
            $request->session()->flash('error', 'Something went wrong while saving exam results.');
        }
        return redirect()->route('result.index');
    }

    public function editExamSubject($examId, $subjectId)
    {
        $data = [
            'pageTitle' => 'Edit Exam Result',
            'examInfo' => $this->examService->find($examId),
            'subject' => $this->subjectService->find($subjectId),
            'examTypeSubType' => $this->examTypeService->getExamTypesSubTypesWithMarkByExamIdAndSubjectId($examId, $subjectId),
            'examResult' => $this->service->getExamResultsByExamIdAndSubjectId($examId, $subjectId),
        ];

        return view('exam_result.edit', $data);
    }

    public function showExamSubjectResult($examId, $subjectId, $studentId = null)
    {

        $data = [
            'pageTitle' => 'Show Exam Result',
            'examInfo' => $this->examService->find($examId),
            'subject' => $this->subjectService->find($subjectId),
            'selectedStudentId' => $studentId,
            'examTypeSubType' => $this->examTypeService->getExamTypesSubTypesWithMarkByExamIdAndSubjectId($examId, $subjectId),
            'examResult' => $this->service->getExamResultsByExamIdAndSubjectId($examId, $subjectId),
        ];

        return view('exam_result.show_single_subject', $data);
    }

    public function updateExamSubjectResult(Request $request, $examId, $subjectId)
    {

        $exam = $this->examService->find($examId);
        $result = $this->service->updateExamResultBySubject($request, $examId, $subjectId);

        if ($result) {
            $request->session()->flash('success', setMessage('update', 'Exam results'));
        } else {
            $request->session()->flash('error', setMessage('update', 'Exam results'));
        }
        return redirect()->route('result.index', ['session_id' => $exam->session_id, 'course_id' => $exam->course_id]);
    }

    public function editStudentResult($examId, $subjectId, $studentId)
    {
        $data = [
            'pageTitle' => 'Show Exam Result',
            'examInfo' => $this->examService->find($examId),
            'subject' => $this->subjectService->find($subjectId),
            'examTypeSubType' => $this->examTypeService->getExamTypesSubTypesWithMarkByExamIdAndSubjectId($examId, $subjectId),
            'examResult' => $this->service->getExamResultsByExamIdSubjectIdAndStudentId($examId, $subjectId, $studentId),
        ];

        return view('exam_result.edit_student_result', $data);
    }

    public function updateStudentResult(Request $request, $examId, $subjectId, $studentId)
    {

        $result = $this->service->updateIndividualStudentResultBySubjectId($request);

        if ($result) {
            $request->session()->flash('success', setMessage('update', 'Exam results'));
            return response()->json([
                'status' => true, 'redirect_url' => route('exam.subject.result.show', [$examId, $subjectId])
            ]);
        }
        $request->session()->flash('error', setMessage('update', 'Exam results'));
        return response()->json([
            'status' => false, 'redirect_url' => route('exam.subject.result.show', [$examId, $subjectId])
        ]);
    }

    public function checkResultIsPublished(Request $request)
    {
        $check = $this->examService->checkResultIsPublishedByExamAndSubjectId($request->exam_id, $request->subject_id);

        if ($check > 0) {
            return 'false';
        }
        return 'true';
    }

    //publish an exam result by exam id and subject id by modal
    public function publishSingleExamResult(Request $request)
    {
        $resultPublish = $this->service->publishExamResultByExamIdAndSubjectId($request);

        if ($resultPublish) {
            $request->session()->flash('success', setMessage('update', 'Exam Result'));
            return redirect()->back();
        }
        $request->session()->flash('error', setMessage('update.error', 'Exam Result'));
        return redirect()->back();
    }

    public function editRequestsubmit(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'subject_id' => 'required|exists:subjects,id',
            'proof_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:300',
            'note' => 'nullable|string',
        ]);

        if ($request->file('proof_file')) {
            $attachment = $request->file('proof_file');
            $filePath = 'nemc_files/result-edit-permissions';
            $extension = $attachment->getClientOriginalExtension();
            $fileName = time() . '.' . $extension;
            $fullFilePath = $filePath . '/' . $fileName;

            if (!file_exists($filePath) && !mkdir($filePath, 755, true) && !is_dir($filePath)) {
                throw new RuntimeException(sprintf('Directory "%s" was not created', $filePath));
            }

            $attachment->move($filePath, $fileName);
        }

        $editRequestId = DB::table('result_edit_request')->insertGetId([
            'exam_id' => $request->exam_id,
            'subject_id' => $request->subject_id,
            'user_id' => auth()->id(),
            'file_path' => $fullFilePath ?? null,
            'note' => $request->note ?? null,
            'created_at' => now(),
        ]);

        $editRequestData = DB::table('result_edit_request')->where('id', $editRequestId)->first();

        // Now fire the event with actual data
        event(new NotifySuperAdminOnResultEditRequested($editRequestData));

        return response()->json(['message' => 'Permission request submitted.']);
    }

    public function toggleEditPermission(Request $request)
    {
        $request->validate([
            'examId' => 'required|integer|exists:exams,id',
            'subjectId' => 'required|integer|exists:subjects,id',
        ]);

        $user = Auth::guard('web')->user();
        $examSubject = ExamSubject::where('exam_id', $request->examId)
                                  ->where('subject_id', $request->subjectId)
                                  ->first();

        if (!$examSubject) {
            return response()->json([
                'success' => false,
                'message' => 'Exam or Subject not found.',
            ], 404);
        }

        // Log the change
        $this->logPermissionChange($examSubject, $user);

        // Toggle permission
        $examSubject->hod_edit_permission = !$examSubject->hod_edit_permission;
        $examSubject->save();

        $checkData = DB::table('result_edit_request')
                       ->where('exam_id', $examSubject->exam_id)
                       ->where('subject_id', $examSubject->subject_id)
                       ->orderByDesc('id')
                       ->first();

        if ($checkData) {
            event(new NotifyUserOnEditPermissionGiven($examSubject, $checkData->user_id));
        }

        return response()->json([
            'success' => true,
            'message' => $examSubject->hod_edit_permission
                ? 'Result edit permission given successfully.'
                : 'Result edit permission closed successfully.',
        ]);
    }

    protected function logPermissionChange($examSubject, $user)
    {
        Log::info('HOD Permission Toggle Changed', [
            'exam_id' => $examSubject->exam_id,
            'subject_id' => $examSubject->subject_id,
            'previous_value' => $examSubject->hod_edit_permission,
            'new_value' => !$examSubject->hod_edit_permission,
            'changed_by' => $user->id,
            'changed_at' => now(),
        ]);
    }

    public function exportExamResults(Request $request)
    {
        $validated = $request->validate([
            'sessionId' => 'required|integer',
            'courseId' => 'required|integer',
            'phaseId' => 'required|integer',
            'examId' => 'nullable|integer',
            'subjectId' => 'nullable|integer',
            'oldStudents' => 'nullable|boolean',
        ]);

        try {
            $exam = null;
            $examTitle = $this->examService->find($validated['examId'])->title;
            $subjectTitle = $this->subjectService->find($validated['subjectId'])->title;
            $examTypes = $this->examTypeService->getExamTypesSubTypesWithMarkByExamIdAndSubjectId(
                $validated['examId'] ?? null,
                $validated['subjectId'] ?? null
            );

            if (!empty($validated['examId'])) {
                $exam = $this->examService->find($request->examId);
            }

            if ($exam && $exam->exam_category_id == 5 && $exam->main_exam_id != null) {
                $students = $this->service->getFailedStudentsByExam($exam->main_exam_id, $request->subjectId);
            }else {
                $students = $this->studentService
                    ->findBy([
                        'followed_by_session_id' => $validated['sessionId'],
                        'course_id'              => $validated['courseId'],
                        'phase_id'               => $validated['phaseId'],
                        'batch_type_id'          => 1,
                        'status'                 => [1, 3],
                    ], 'list')
                    ->sortBy('roll_no');

                if ($request->boolean('oldStudents') || $request->filled('examId')) {
                    $oldStudents = $this->studentService->getCurrentSessionOldStudentsByPhaseTermCourse(
                        $validated['phaseId'],
                        null,
                        $validated['sessionId'],
                        $validated['courseId']
                    );
                    $students    = $students->merge($oldStudents);
                }

                if ($validated['examId']) {
                    $examSubjects = ExamSubject::where('exam_id', $validated['examId'])->get();
                    if ($examSubjects->isNotEmpty() && $examSubjects->whereIn('exam_type_id', [1, 3])->count() === 0) {
                        $examStudents = $examSubjects
                            ->flatMap->studentGroups
                            ->flatMap->students
                            ->unique('id');

                        if ($examStudents->isNotEmpty()) {
                            $students = $students->whereIn('id', $examStudents->pluck('id'));
                        }
                    }
                }
            }

            return Excel::download(new ExamResultsExport($examTypes, $students), $examTitle . ' - ' . $subjectTitle . ' Results.xlsx');
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while generating the exam results.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
