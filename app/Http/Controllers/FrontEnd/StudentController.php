<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Services\Admin\AttendanceService;
use App\Services\Admin\CardService;
use App\Services\Admin\CourseService;
use App\Services\Admin\ExamCategoryService;
use App\Services\Admin\PhaseService;
use App\Services\Admin\SessionService;
use App\Services\Admin\StudentCategoryService;
use App\Services\Admin\StudentService;
use App\Services\Admin\SubjectService;
use App\Services\AttachmentService;
use App\Services\ResultService;
use App\Services\Setting\Facades\Setting;
use App\Services\UtilityServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    /**
     *
     */
    const moduleName = 'Student Management';
    /**
     *
     */
    const redirectUrl = 'nemc/students';
    /**
     *
     */
    const moduleDirectory = 'frontend.students.';

    protected $service;
    protected $sessionService;
    protected $courseService;
    protected $studentCategoryService;
    protected $phaseService;
    protected $attachmentService;
    protected $subjectService;
    protected $attendanceService;
    protected $cardService;
    protected $resultService;
    protected $examCategoryService;

    public function __construct(
        StudentService $service, SessionService $sessionService, CourseService $courseService, StudentCategoryService $studentCategoryService,
        PhaseService $phaseService, AttachmentService $attachmentService, SubjectService $subjectService, AttendanceService $attendanceService,
        CardService  $cardService, ResultService $resultService, ExamCategoryService $examCategoryService
    )
    {
        $this->service             = $service;
        $this->sessionService      = $sessionService;
        $this->courseService       = $courseService;
        $this->studentCategoryService = $studentCategoryService;
        $this->phaseService        = $phaseService;
        $this->attachmentService   = $attachmentService;
        $this->subjectService      = $subjectService;
        $this->attendanceService   = $attendanceService;
        $this->cardService         = $cardService;
        $this->resultService       = $resultService;
        $this->examCategoryService = $examCategoryService;
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'pageTitle'  => 'Student List',
            'tableHeads' => [
                'Image', 'Name', 'Roll No', 'Session', 'Course', 'Category', 'Phase', 'Installments', 'Status', 'Action'
            ],
            'dataUrl'    => self::redirectUrl . '/get-data',
            'columns'    => [
                ['data' => 'photo', 'name' => 'photo'],
                ['data' => 'full_name_en', 'name' => 'full_name_en'],
                ['data' => 'roll_no', 'name' => 'roll_no'],
                ['data' => 'session_id', 'name' => 'session_id'],
                ['data' => 'course_id', 'name' => 'course_id'],
                ['data' => 'student_category_id', 'name' => 'student_category_id'],
                ['data' => 'phase_id', 'name' => 'phase_id'],
                ['data' => 'clear_installment', 'name' => 'clear_installment'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
            'sessions'   => $this->sessionService->listByStatus(),
            'courses'    => $this->courseService->lists(),
            'studentCategories' => $this->studentCategoryService->lists(),
            'phases'     => $this->phaseService->lists()
        ];

        return view(self::moduleDirectory . 'index', $data);
    }

    public function getData(Request $request)
    {
        return $this->service->getDataTable($request);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Student $student
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = [
            'pageTitle'     => self::moduleName,
            'student'       => $this->service->find($id),
            'educationLevel' => UtilityServices::$certificates,
            'studentStatus' => UtilityServices::$studentStatus
        ];

        return view(self::moduleDirectory . 'view', $data);
    }

    /**
     * @param $id
     *
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAttachmentsList($id)
    {
        $student = $this->service->find($id);
        $data = [
            'pageTitle' => 'Attachments of ' . $student->full_name_en,
            'tableHeads' => ['Id', 'Attachment Type', 'Document Type', 'Remarks', 'Upload Time', 'Action'],
            'dataUrl'   => self::redirectUrl . '/' . $student->id . '/attachment/data-table',
            'columns'   => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'attachment_type_id', 'name' => 'attachment_type_id'],
                ['data' => 'type', 'name' => 'type'],
                ['data' => 'remarks', 'name' => 'remarks'],
                ['data' => 'created_at', 'name' => 'created_at'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
            'student'   => $student,
        ];

        return view(self::moduleDirectory . 'attachments.index', $data);
    }

    /**
     * @param Request $request
     * @param         $id
     *
     * @return mixed
     */
    public function attachmentsListDataTable(Request $request, $id)
    {
        return $this->attachmentService->getAttachmentsDataTableByStudentId($request, $id);
    }

    public function getListsBySessionIdAndCourseId(Request $request)
    {
        $sessionId = $request->input('sessionId');
        $courseId = $request->input('courseId');

        if (Auth::guard('student_parent')->check()) {
            $user = Auth::guard('student_parent')->user();

            if ($user->user_group_id == 5) {
                $students = $this->service->findBy([
                    'session_id' => $sessionId, 'course_id' => $courseId, 'status' => 1, 'id' => $user->student->id
                ], 'list');
            } else {
                $students = $this->service->findBy([
                    'session_id' => $sessionId, 'course_id' => $courseId, 'status' => 1,
                    'parent_id'  => $user->parent->id
                ], 'list');
            }
        }

        return $students;
    }

    public function getAttendanceByStudent($id)
    {
        $student = $this->service->find($id);
        $subjects = $this->subjectService->getSubjectsBySessionIdCourseIdPhaseId($student->session_id, $student->course_id, $student->phase_id);

        foreach ($subjects as $subject) {
            $totalLectureClass[$subject->id]        = $this->attendanceService->getTotalClassBySubjectId($student->id, $student->session_id, $student->course_id, $student->phase_id, $subject->id, [1], true);
            $totalTutorialClass[$subject->id]       = $this->attendanceService->getTotalClassBySubjectId($student->id, $student->session_id, $student->course_id, $student->phase_id, $subject->id, [
                1, 6, 7, 9
            ]);
            $totalLectureClassAttend[$subject->id]  = $this->attendanceService->getTotalAttendanceBySessionCoursePhaseSubjectAndStudentId($student->session_id, $student->course_id, $student->phase_id, $subject->id, $id, [1], true);
            $totalTutorialClassAttend[$subject->id] = $this->attendanceService->getTotalAttendanceBySessionCoursePhaseSubjectAndStudentId($student->session_id, $student->course_id, $student->phase_id, $subject->id, $id, [
                1, 6, 7, 9
            ]);
        }
        unset($subject);

        $data = [
            'pageTitle'               => 'Student Attendance',
            'student'                 => $student,
            'sessionPhases'           => $this->sessionService->getSessionPhaseDetailBySessionIdAndCourseId($student->session_id, $student->course_id),
            'subjects'                => $subjects,
            'totalLectureClass'       => $totalLectureClass,
            'totalTutorialClass'      => $totalTutorialClass,
            'totalLectureClassAttend' => $totalLectureClassAttend,
            'totalTutorialClassAttend' => $totalTutorialClassAttend,
            'studentStatus'           => UtilityServices::$studentStatus,
        ];

        return view(self::moduleDirectory . 'attendance.index', $data);
    }

    public function getAttendanceByStudentAndPhase(Request $request, $id)
    {
        $student = $this->service->find($id);
        $subjects = $this->subjectService->getSubjectsBySessionIdCourseIdPhaseId($student->session_id, $student->course_id, $request->phaseId);

        $totalLecturePercent = 0;
        $totalTutorialPercent = 0;
        foreach ($subjects as $subject) {
            $percentLecture = 0;
            $percentTutorial = 0;
            $percentTotal   = 0;

            $totalLectureClass        = $this->attendanceService->getTotalClassBySubjectId($student->session_id, $student->course_id, $request->phaseId, $subject->id, [1], true);
            $totalLectureClassAttend  = $this->attendanceService->getTotalAttendanceBySessionCoursePhaseSubjectAndStudentId($student->session_id, $student->course_id, $request->phaseId, $subject->id, $id, [1], true);
            $totalTutorialClass       = $this->attendanceService->getTotalClassBySubjectId($student->session_id, $student->course_id, $request->phaseId, $subject->id, [
                1, 6, 7, 9
            ]);
            $totalTutorialClassAttend = $this->attendanceService->getTotalAttendanceBySessionCoursePhaseSubjectAndStudentId($student->session_id, $student->course_id, $request->phaseId, $subject->id, $id, [
                1, 6, 7, 9
            ]);
            if (!empty($totalLectureClass[$subject->id])) {
                $totalLecturePercent = round((($totalLectureClassAttend[$subject->id] * 100) / $totalLectureClass[$subject->id]), 2);
            }
            if (!empty($totalTutorialClass[$subject->id])) {
                $totalTutorialPercent = round((($totalTutorialClassAttend[$subject->id] * 100) / $totalTutorialClass[$subject->id]), 2);
            }
            if (!empty($totalLectureClass[$subject->id]) || !empty($totalTutorialClass[$subject->id])) {
                $percentTtotal = round(((($totalTutorialClassAttend[$subject->id] + $totalLectureClassAttend[$subject->id]) * 100) / ($totalLectureClass[$subject->id] + $totalTutorialClass[$subject->id])), 2);
            }

            $subject->totalLectureClass       = $totalLectureClass;
            $subject->totalLectureClassAttend = $totalLectureClassAttend;
            $subject->totalTutorialClass      = $totalTutorialClass;
            $subject->totalTutorialClassAttend = $totalTutorialClassAttend;
            $subject->totalLecturePercent     = $totalLecturePercent;
            $subject->totalTutorialPercent    = $totalTutorialPercent;
            $subject->totalClass              = $totalLectureClass + $totalTutorialClass;
            $subject->totalAttend             = $totalLectureClassAttend + $totalTutorialClassAttend;
            $subject->percentTotal            = $percentTotal;
        }
        unset($subject);

        return response()->json([
            'status' => true, 'subjects' => $subjects
        ]);
    }

    public function getCardItemsByStudent($id)
    {
        $student = $this->service->find($id);
        $subjects = $this->subjectService->getSubjectsBySessionIdCourseIdPhaseId($student->session_id, $student->course_id, $student->phase_id);

        foreach ($subjects as $subject) {
            $cardItems[$subject->id] = $this->cardService->getCardsItemsAndStudentResultBySubjectStudentAndPhaseId($subject->id, $id, $student->phase_id);
        }
        unset($subject);

        $data = [
            'pageTitle' => 'Items & Cards',
            'student'   => $student,
            'sessionPhases' => $this->sessionService->getSessionPhaseDetailBySessionIdAndCourseId($student->session_id, $student->course_id),
            'subjects'  => $subjects,
            'cardItems' => $cardItems,
            'studentStatus' => UtilityServices::$studentStatus,
        ];

        return view(self::moduleDirectory . 'card_items.index', $data);
    }

    public function getCardItemDetailByStudent($id, $cardId)
    {
        $student = $this->service->find($id);

        $data = [
            'pageTitle' => 'Card Items',
            'cardItems' => $this->cardService->getCardItemsByCardId($cardId),
            'student' => $student,
        ];

        return view(self::moduleDirectory . 'card_items.card_items', $data);
    }

    public function getExamResultByStudent(Request $request, $id)
    {
        $student = $this->service->find($id);
        $subjects = $this->subjectService->getSubjectsBySessionIdCourseIdPhaseId($student->followed_by_session_id, $student->course_id, $student->phase_id);

        $categoryId = $request->has('cat_id') ? $request->cat_id : 3;

        foreach ($subjects as $subject) {
            $examSubjects[$subject->id] = $this->resultService->getStudentResultBySubjectExamCategoryStudentAndPhaseId($subject->id, $categoryId, $id, $student->phase_id);
        }

        $data = [
            'pageTitle'     => 'Exam Results',
            'student'       => $student,
            'sessionPhases' => $this->sessionService->getSessionPhaseDetailBySessionIdAndCourseId($student->session_id, $student->course_id),
            'subjects'      => $subjects,
            'examSubjects'  => $examSubjects,
            'examCategories' => $this->examCategoryService->listByStatus(),
            'passStatus'    => UtilityServices::$passStatus,
            'studentStatus' => UtilityServices::$studentStatus,
        ];

        return view(self::moduleDirectory . 'exam_results.index', $data);
    }

    public function getExamResultByStudentAndPhase(Request $request, $id)
    {
        try {
            $student = $this->service->find($id);
            if (!$student) {
                return response()->json([
                    'status' => false,
                    'message' => 'Student not found'
                ], 404);
            }

            $subjects = $this->subjectService->getSubjectsBySessionIdCourseIdPhaseId(
                $student->followed_by_session_id,
                $student->course_id,
                $request->phaseId
            );

            foreach ($subjects as $subject) {
                $examSubjects = $this->resultService->getStudentResultBySubjectExamCategoryStudentAndPhaseId(
                    $subject->id,
                    $request->cat_id,
                    $id,
                    $request->phaseId
                );
                $resultArr = [];
                $total = 0;
                foreach ($examSubjects as $key => $examSubject) {
                    if (!empty($examSubject->exam->examMarks->toArray())) {
                        $examTotalMarks = $examSubject->exam->examMarks->sum('total_marks');
                        if (!empty($examSubject->exam->examMarks->first()->result->toArray())) {
                            $examTypeMarksArr = [];
                            $totalMarksByExamType = [];

                            foreach ($examSubject->exam->examMarks as $examMark) {
                                $examTypeId = $examMark->examSubType->examType->id ?? null;
                                if ($examTypeId && !isset($totalMarksByExamType[$examTypeId])) {
                                    $totalMarksByExamType[$examTypeId] = 0;
                                }
                                foreach ($examMark->result as $result) {
                                    $marks = $result->marks + $result->grace_marks;
                                    $total += $marks;
                                    if ($examTypeId) {
                                        $totalMarksByExamType[$examTypeId] += $marks;
                                    }
                                }

                                if ($examTypeId) {
                                    $examTypeMarksArr[$examTypeId] = isset($examTypeMarksArr[$examTypeId])
                                        ? $examTypeMarksArr[$examTypeId] + $examMark->total_marks
                                        : $examMark->total_marks;
                                }
                            }
                        }
                        $examTotalMarks = $total;
                        $total = 0;
                    }
                    // Initialize variables
                    $examMarksTotal = 0;
                    $total = 0;
                    $passPercentage = Setting::getSiteSetting()->pass_mark;
                    $resultStatus = '';
                    $textColor = '';
                    $remark = '';

                    // Get exam marks if available
                    $examMarks = $examSubject->exam->examMarks;
                    if ($examMarks->isNotEmpty()) {
                        $examMarksTotal = $examMarks->sum('total_marks');
                        // Calculate total marks from results
                        $firstResult = $examMarks->first()->result;
                        $special = $examMarks->first()->result->whereNotNull('special_status')->count();
                        $absent = $examMarks->first()->result->where('pass_status', 4)->count();
                        $grace = $examMarks->first()->result->whereNotNull('grace_marks')->count();
                        $totalGrace = $examMarks->first()->result->sum('grace_marks');
                        $failCount = 0;

                        // Handle special cases first
                        if ($special > 0) {
                            $isSpecialPass = $examMarks->first()->result->where('special_status', 1)->count() > 0;
                            $resultStatus = $isSpecialPass ? 'Pass(SC)' : 'Fail(SC)';
                            $textColor = $isSpecialPass ? 'text-info' : 'text-danger';
                        } else {
                            // Calculate pass/fail based on percentages - only needed if not special case
                            foreach ($examTypeMarksArr as $key => $totalPossibleMarks) {
                                if ($totalPossibleMarks > 0) {
                                    $actualMarks = $totalMarksByExamType[$key] ?? 0;
                                    $percentage = ($actualMarks * 100) / $totalPossibleMarks;

                                    if ($passPercentage > $percentage) {
                                        $failCount++;
                                        break;
                                    }
                                }
                            }
                            // Determine final status
                            if ($absent > 0) {
                                $resultStatus = 'Absent';
                                $textColor = 'text-warning';
                            } elseif ($failCount > 0) {
                                $resultStatus = 'Fail';
                                $textColor = 'text-danger';
                            } elseif ($grace > 0) {
                                $resultStatus = "Pass(Grace - $totalGrace)";
                                $textColor = 'text-info';
                            } else {
                                $resultStatus = 'Pass';
                                $textColor = 'text-success';
                            }
                        }
                    }

                    if (!empty($examSubject->exam->examMarks->first()->result->toArray())) {
                        $remark = $examSubject->exam->examMarks->first()->result->first()->remarks;
                    }

                    // Build a result array
                    $resultArr[$key] = [
                        'result_url' => route('exam.subject.result.show', [
                            'examId' => $examSubject->exam->id,
                            'subjectId' => $examSubject->subject_id,
                            'studentId' => $id
                        ]),
                        'title' => $examSubject->exam->title,
                        'term' => $examSubject->exam->term->title,
                        'total_marks' => $examMarksTotal . '/' . $examTotalMarks,
                        'resultStatus' => $resultStatus,
                        'textColor' => $textColor,
                        'remark' => $remark,
                        'action' => ''
                    ];
                }

                $subject->phase_id = $request->phaseId;
                $subject->examSubjects = $resultArr;
            }

            return response()->json([
                'status' => true,
                'subjects' => $subjects
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in getExamResultByStudentAndPhase: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while fetching exam results'
            ], 500);
        }
    }

    //change student password form
    public function changePasswordForm($id)
    {
        if (Auth::guard('student_parent')->check()) {
            $user = Auth::guard('student_parent')->user();
            if ($user->user_group_id == 5) {
                if ($user->student->id != $id) {
                    return redirect()->route('frontend.students.index');
                }
            }
        } else {
            return redirect()->route('frontend.students.index');
        }

        $data = [
            'pageTitle' => 'Student',
            'studentId' => $id,
        ];

        return view(self::moduleDirectory . 'change_password', $data);
    }

    //change student password
    public function changePassword(Request $request, $id)
    {
        $changePassword = $this->service->changePassword($request, $id);

        if ($changePassword) {
            $request->session()->flash('success', setMessage('update', 'Password'));
            return redirect()->route('frontend.students.index');
        } else {
            $request->session()->flash('error', setMessage('update.error', 'Password'));
            return redirect()->route('frontend.students.index');
        }
    }

    public function getStudentsBySessionCoursePhase(Request $request)
    {
        $sessionId = $request->input('sessionId');
        $courseId = $request->input('courseId');
        $phaseId = $request->input('phaseId');
        return $students = $this->service->getAllStudentsBySessionCoursePhase($sessionId, $courseId, $phaseId);
    }
}
