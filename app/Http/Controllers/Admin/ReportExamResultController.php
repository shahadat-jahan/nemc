<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ExamResultsExportByCategory;
use App\Exports\ExamResultsExportByPhase;
use App\Exports\ExportExamResultByStudent;
use App\Http\Controllers\Controller;
use App\Services\Admin\CourseService;
use App\Services\Admin\ExamCategoryService;
use App\Services\Admin\ExamService;
use App\Services\Admin\ExamTypeService;
use App\Services\Admin\PhaseService;
use App\Services\Admin\SessionService;
use App\Services\Admin\StudentService;
use App\Services\Admin\SubjectGroupService;
use App\Services\Admin\SubjectService;
use App\Services\Admin\TermService;
use App\Services\ResultService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class ReportExamResultController extends Controller
{

    /**
     *
     */
    const moduleName = 'Reports';
    /**
     *
     */
    const moduleDirectory = 'reports.exam_result.';

    protected $sessionService;
    protected $courseService;
    protected $phaseService;
    protected $termService;
    protected $examCategoryService;
    protected $examService;
    protected $examTypeService;
    protected $resultService;
    protected $subjectGroupService;
    protected $subjectService;
    protected $studentService;

    public function __construct(
        SessionService      $sessionService, CourseService $courseService, PhaseService $phaseService, TermService $termService,
        ExamCategoryService $examCategoryService, ExamService $examService, ExamTypeService $examTypeService, ResultService $resultService,
        SubjectGroupService $subjectGroupService, SubjectService $subjectService, StudentService $studentService
    )
    {
        $this->sessionService      = $sessionService;
        $this->courseService       = $courseService;
        $this->phaseService        = $phaseService;
        $this->termService         = $termService;
        $this->examCategoryService = $examCategoryService;
        $this->examService         = $examService;
        $this->examTypeService     = $examTypeService;
        $this->resultService       = $resultService;
        $this->subjectGroupService = $subjectGroupService;
        $this->subjectService      = $subjectService;
        $this->studentService      = $studentService;
    }

    public function index(Request $request)
    {
        $examCategories = $this->examCategoryService->listByStatus();
//        unset($examCategories[1]);

        $sessionId      = $request->has('session_id') ? $request->session_id : '';
        $courseId       = $request->has('course_id') ? $request->course_id : '';
        $phaseId        = $request->has('phase_id') ? $request->phase_id : '';
        $termId         = $request->has('term_id') ? $request->term_id : '';
        $examCategoryId = $request->has('exam_category_id') ? $request->exam_category_id : '';
        $subjectId      = $request->has('subject_id') ? $request->subject_id : '';

        $exam            = [];
        $subject         = [];
        $examTypeSubType = [];
        $examResult      = [];

        if (!empty($sessionId) || !empty($courseId) || !empty($phaseId) || !empty($termId) || !empty($examCategoryId) || !empty($subjectId)) {
            $exam            = $this->examService->find($request->exam_id);
            $examTypeSubType = $this->examTypeService->getExamTypesSubTypesWithMarkByExamIdAndSubjectId($exam->id, $subjectId);
            $examResult      = $this->resultService->getExamResultsByExamIdAndSubjectId($exam->id, $subjectId);
            $subject         = $this->subjectService->find($subjectId);
        }

        $data = [
            'pageTitle'       => self::moduleName . ' - Exam Result',
            'sessions'        => $this->sessionService->listByStatus(),
            'courses'         => $this->courseService->listByStatus(),
            'phases'          => $this->phaseService->listByStatus(),
            'terms'           => $this->termService->listByStatus(),
            'examCategories'  => $examCategories,
            'exam'            => $exam,
            'subject'         => $subject,
            'examTypeSubType' => $examTypeSubType,
            'examResult'      => $examResult
        ];

        return view(self::moduleDirectory . 'index', $data);
    }

    public function exportResultsByCategory(Request $request)
    {
        $sessionId      = $request->has('session_id') ? $request->session_id : '';
        $courseId       = $request->has('course_id') ? $request->course_id : '';
        $phaseId        = $request->has('phase_id') ? $request->phase_id : '';
        $termId         = $request->has('term_id') ? $request->term_id : '';
        $examCategoryId = $request->has('exam_category_id') ? $request->exam_category_id : '';
        $subjectId      = $request->has('subject_id') ? $request->subject_id : '';

        if (!empty($sessionId) || !empty($courseId) || !empty($phaseId) || !empty($termId) || !empty($examCategoryId) || !empty($subjectId)) {
            $exam            = $this->examService->find($request->exam_id);
            $examTypeSubType = $this->examTypeService->getExamTypesSubTypesWithMarkByExamIdAndSubjectId($exam->id, $subjectId);
            $examResult      = $this->resultService->getExamResultsByExamIdAndSubjectId($exam->id, $subjectId);
            $subject         = $this->subjectService->find($subjectId);

            return Excel::download(new ExamResultsExportByCategory($exam, $examTypeSubType, $examResult, $subject), $subject->title . '-' . $exam->title . ' result.xlsx');
        }
    }

    public function resultsByCategoryPdf(Request $request)
    {
        $sessionId      = $request->has('session_id') ? $request->session_id : '';
        $courseId       = $request->has('course_id') ? $request->course_id : '';
        $phaseId        = $request->has('phase_id') ? $request->phase_id : '';
        $termId         = $request->has('term_id') ? $request->term_id : '';
        $examCategoryId = $request->has('exam_category_id') ? $request->exam_category_id : '';
        $subjectId      = $request->has('subject_id') ? $request->subject_id : '';
        $pagLayout      = $pageLayout = $request->page_layout ?? 'A4-portrait';

        if (!empty($sessionId) || !empty($courseId) || !empty($phaseId) || !empty($termId) || !empty($examCategoryId) || !empty($subjectId)) {
            $exam            = $this->examService->find($request->exam_id);
            $examTypeSubType = $this->examTypeService->getExamTypesSubTypesWithMarkByExamIdAndSubjectId($exam->id, $subjectId);
            $examResult      = $this->resultService->getExamResultsByExamIdAndSubjectId($exam->id, $subjectId);
            $subject         = $this->subjectService->find($subjectId);

            $data     = [
                'exam'            => $exam,
                'examTypeSubType' => $examTypeSubType,
                'examResult'      => $examResult,
                'subject'         => $subject,
            ];
            $document = $subject->title . '-' . $exam->title . ' result.pdf';
            $pdf      = PDF::loadView('reports.exam_result.pdf.exam_results_by_category', $data, [], ['format' => $pagLayout]);
            return $pdf->stream($document);
        }
    }

    public function resultByPhase(Request $request)
    {
        $sessionId = $request->has('session_id') ? $request->session_id : '';
        $courseId  = $request->has('course_id') ? $request->course_id : '';
        $phaseId   = $request->has('phase_id') ? $request->phase_id : '';

        $examSubjects = [];
        $exams        = [];
        $examResults  = [];

        if (!empty($sessionId) || !empty($courseId) || !empty($phaseId)) {
            $examSubjects = $this->examService->getSubjectsBySessionCoursePhaseAndExamCategoryId($sessionId, $courseId, $phaseId, 3);
            $exams        = $this->examService->findBy([
                'session_id' => $sessionId, 'course_id' => $courseId, 'phase_id' => $phaseId, 'exam_category_id' => 3
            ], 'list');

            $examResults = $this->resultService->getExamResultTotalBySessionCoursePhaseAndCategoryId($sessionId, $courseId, $phaseId, 3);
        }

        $data = [
            'pageTitle'    => self::moduleName . ' - Exam Result - By Phase',
            'sessions'     => $this->sessionService->listByStatus(),
            'courses'      => $this->courseService->listByStatus(),
            'phases'       => $this->phaseService->listByStatus(),
            'examSubjects' => $examSubjects,
            'exams'        => $exams,
            'examResults'  => $examResults,
        ];

        return view(self::moduleDirectory . 'phase_result', $data);
    }

    public function exportResultsByPhase(Request $request)
    {
        $sessionId = $request->has('session_id') ? $request->session_id : '';
        $courseId  = $request->has('course_id') ? $request->course_id : '';
        $phaseId   = $request->has('phase_id') ? $request->phase_id : '';

        $sessionInfo = $this->sessionService->find($sessionId);
        $phaseInfo   = $this->phaseService->find($phaseId);

        if (!empty($sessionId) || !empty($courseId) || !empty($phaseId)) {
            $examSubjects = $this->examService->getSubjectsBySessionCoursePhaseAndExamCategoryId($sessionId, $courseId, $phaseId, 3);
            $exams        = $this->examService->findBy([
                'session_id' => $sessionId, 'course_id' => $courseId, 'phase_id' => $phaseId, 'exam_category_id' => 3
            ], 'list');

            $examResults = $this->resultService->getExamResultTotalBySessionCoursePhaseAndCategoryId($sessionId, $courseId, $phaseId, 3);

            $filename = $phaseInfo->title . ' result - (' . $sessionInfo->title . ')';

            return Excel::download(new ExamResultsExportByPhase($examSubjects, $exams, $examResults, $sessionInfo, $phaseInfo), $filename . '.xlsx');
        }
    }

    public function resultsByPhasePdf(Request $request)
    {
        $sessionId = $request->has('session_id') ? $request->session_id : '';
        $courseId  = $request->has('course_id') ? $request->course_id : '';
        $phaseId   = $request->has('phase_id') ? $request->phase_id : '';

        $sessionInfo = $this->sessionService->find($sessionId);
        $phaseInfo   = $this->phaseService->find($phaseId);

        if (!empty($sessionId) || !empty($courseId) || !empty($phaseId)) {
            $examSubjects = $this->examService->getSubjectsBySessionCoursePhaseAndExamCategoryId($sessionId, $courseId, $phaseId, 3);
            $exams        = $this->examService->findBy([
                'session_id' => $sessionId, 'course_id' => $courseId, 'phase_id' => $phaseId, 'exam_category_id' => 3
            ], 'list');

            $examResults = $this->resultService->getExamResultTotalBySessionCoursePhaseAndCategoryId($sessionId, $courseId, $phaseId, 3);

            $data     = [
                'examSubjects' => $examSubjects,
                'exams'        => $exams,
                'examResults'  => $examResults,
                'session'      => $sessionInfo,
                'phase'        => $phaseInfo,
            ];
            $document = $phaseInfo->title . ' result - (' . $sessionInfo->title . ').pdf';
            $pdf      = PDF::loadView('reports.exam_result.pdf.exam_results_by_phase', $data);
            return $pdf->stream($document);
        }
    }

    public function resultByStudent(Request $request)
    {
        $examCategories = $this->examCategoryService->listByStatus();
//        unset($examCategories[1]);

        $sessionId      = $request->has('session_id') ? $request->session_id : '';
        $courseId       = $request->has('course_id') ? $request->course_id : '';
        $phaseId        = $request->has('phase_id') ? $request->phase_id : '';
        $termId         = $request->has('term_id') ? $request->term_id : '';
        $examCategoryId = $request->has('exam_category_id') ? $request->exam_category_id : '';
        $subjectId      = $request->has('subject_id') ? $request->subject_id : '';
        $studentId      = $request->has('student_id') ? $request->student_id : '';

        $exam            = [];
        $subject         = [];
        $examTypeSubType = [];
        $examResult      = [];

        if (!empty($sessionId) && !empty($courseId) && !empty($phaseId) && !empty($termId) && !empty($examCategoryId) && !empty($subjectId) && !empty($studentId)) {
            $exam            = $this->examService->find($request->exam_id);
            $subject         = $this->subjectService->find($subjectId);
            $examTypeSubType = $this->examTypeService->getExamTypesSubTypesWithMarkByExamIdAndSubjectId($exam->id, $subjectId);
            $examResult      = $this->resultService->getExamResultsByExamIdSubjectIdAndStudentId($exam->id, $subjectId, $studentId)->sortBy('examSubjectMark.examSubType.exam_type_id')->groupBy('examSubjectMark.examSubType.exam_type_id');
        }

        $data = [
            'pageTitle'       => self::moduleName . ' - Exam Results - By Student',
            'sessions'        => $this->sessionService->listByStatus(),
            'courses'         => $this->courseService->listByStatus(),
            'phases'          => $this->phaseService->listByStatus(),
            'terms'           => $this->termService->listByStatus(),
            'examCategories'  => $examCategories,
            'exam'            => $exam,
            'subject'         => $subject,
            'examTypeSubType' => $examTypeSubType,
            'examResult'      => $examResult,
            'student'         => $this->studentService->find($studentId),
        ];

        return view(self::moduleDirectory . 'result_student', $data);
    }

    //Export result by student
    public function exportResultsByStudent(Request $request)
    {
        $sessionId      = $request->has('session_id') ? $request->session_id : '';
        $courseId       = $request->has('course_id') ? $request->course_id : '';
        $phaseId        = $request->has('phase_id') ? $request->phase_id : '';
        $termId         = $request->has('term_id') ? $request->term_id : '';
        $examCategoryId = $request->has('exam_category_id') ? $request->exam_category_id : '';
        $subjectId      = $request->has('subject_id') ? $request->subject_id : '';
        $studentId      = $request->has('student_id') ? $request->student_id : '';

        if (!empty($sessionId) && !empty($courseId) && !empty($phaseId) && !empty($termId) && !empty($examCategoryId) && !empty($subjectId) && !empty($studentId)) {
            $studentInfo     = $this->studentService->find($studentId);
            $exam            = $this->examService->find($request->exam_id);
            $subject         = $this->subjectService->find($subjectId);
            $examTypeSubType = $this->examTypeService->getExamTypesSubTypesWithMarkByExamIdAndSubjectId($exam->id, $subjectId);
            $examResult      = $this->resultService->getExamResultsByExamIdSubjectIdAndStudentId($exam->id, $subjectId, $studentId)->sortBy('examSubjectMark.examSubType.exam_type_id')->groupBy('examSubjectMark.examSubType.exam_type_id');

            $filename = $studentInfo->full_name_en . ' - ' . $exam->title;

            return Excel::download(new ExportExamResultByStudent($exam, $subject, $examTypeSubType, $examResult), $filename . '.xlsx');
        }
    }

    //Pdf result by student
    public function resultsByStudentPdf(Request $request)
    {
        $sessionId      = $request->has('session_id') ? $request->session_id : '';
        $courseId       = $request->has('course_id') ? $request->course_id : '';
        $phaseId        = $request->has('phase_id') ? $request->phase_id : '';
        $termId         = $request->has('term_id') ? $request->term_id : '';
        $examCategoryId = $request->has('exam_category_id') ? $request->exam_category_id : '';
        $subjectId      = $request->has('subject_id') ? $request->subject_id : '';
        $studentId      = $request->has('student_id') ? $request->student_id : '';

        if (!empty($sessionId) && !empty($courseId) && !empty($phaseId) && !empty($termId) && !empty($examCategoryId) && !empty($subjectId) && !empty($studentId)) {
            $studentInfo     = $this->studentService->find($studentId);
            $exam            = $this->examService->find($request->exam_id);
            $subject         = $this->subjectService->find($subjectId);
            $examTypeSubType = $this->examTypeService->getExamTypesSubTypesWithMarkByExamIdAndSubjectId($exam->id, $subjectId);
            $examResult      = $this->resultService->getExamResultsByExamIdSubjectIdAndStudentId($exam->id, $subjectId, $studentId)->sortBy('examSubjectMark.examSubType.exam_type_id')->groupBy('examSubjectMark.examSubType.exam_type_id');

            $filename = $studentInfo->full_name_en . ' - ' . $exam->title;
            $data     = [
                'exam'            => $exam,
                'subject'         => $subject,
                'examTypeSubType' => $examTypeSubType,
                'examResult'      => $examResult,
                'student'         => $studentInfo,
            ];
            $document = $filename . 'pdf';
            $pdf      = PDF::loadView('reports.exam_result.pdf.exam_results_by_student', $data);

            return $pdf->stream($document);
        }
    }
}
