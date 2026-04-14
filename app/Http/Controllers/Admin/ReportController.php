<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AdmissionReportsByStudentCategory;
use App\Exports\AllStudentPaymentsExport;
use App\Exports\AllTeacherWiseClassExport;
use App\Exports\AttendanceByPhaseExport;
use App\Exports\AttendanceByStudentExport;
use App\Exports\AttendanceByTermExport;
use App\Exports\AttendanceExport;
use App\Exports\ComparativeAttendanceExport;
use App\Exports\DueBySessionExport;
use App\Exports\parentList;
use App\Exports\StudentAdmissionReportsByStudentCategory;
use App\Exports\StudentListExport;
use App\Exports\StudentPaymentsExport;
use App\Exports\TeachersListExport;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Admin\Admission\AdmissionService;
use App\Services\Admin\Admission\ClassRoutineService;
use App\Services\Admin\AttendanceService;
use App\Services\Admin\CampaignService;
use App\Services\Admin\ClassTypeService;
use App\Services\Admin\CourseService;
use App\Services\Admin\DepartmentService;
use App\Services\Admin\GuardianService;
use App\Services\Admin\PaymentTypeService;
use App\Services\Admin\PhaseService;
use App\Services\Admin\SessionService;
use App\Services\Admin\SmsService;
use App\Services\Admin\StudentCategoryService;
use App\Services\Admin\StudentService;
use App\Services\Admin\SubjectService;
use App\Services\Admin\TeacherService;
use App\Services\Admin\TermService;
use App\Services\StudentFeeService;
use App\Services\UtilityServices;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class ReportController extends Controller
{

    /**
     *
     */
    const moduleName = 'Reports';
    /**
     *
     */
    const moduleDirectory = 'reports.';

    protected $admissionService;
    protected $sessionService;
    protected $courseService;
    protected $studentCategoryService;
    protected $phaseService;
    protected $termService;
    protected $subjectService;
    protected $attendanceService;
    protected $classRoutineService;
    protected $departmentService;
    protected $studentFeeService;
    protected $studentService;
    protected $teacherService;
    protected $guardianService;
    protected $paymentTypeService;
    protected $smsService;
    protected $classTypeService;
    protected $campaignService;

    public function __construct(
        AdmissionService       $admissionService,
        SessionService         $sessionService,
        CourseService          $courseService,
        StudentCategoryService $studentCategoryService,
        PhaseService           $phaseService,
        TermService            $termService,
        SubjectService         $subjectService,
        AttendanceService      $attendanceService,
        ClassRoutineService    $classRoutineService,
        DepartmentService      $departmentService,
        StudentFeeService      $studentFeeService,
        StudentService         $studentService,
        TeacherService         $teacherService,
        GuardianService        $guardianService,
        PaymentTypeService     $paymentTypeService,
        SmsService             $smsService,
        ClassTypeService       $classTypeService,
        CampaignService        $campaignService
    )
    {
        $this->admissionService       = $admissionService;
        $this->sessionService         = $sessionService;
        $this->courseService          = $courseService;
        $this->studentCategoryService = $studentCategoryService;
        $this->phaseService           = $phaseService;
        $this->termService            = $termService;
        $this->subjectService         = $subjectService;
        $this->attendanceService      = $attendanceService;
        $this->classRoutineService    = $classRoutineService;
        $this->departmentService      = $departmentService;
        $this->studentFeeService      = $studentFeeService;
        $this->studentService         = $studentService;
        $this->teacherService         = $teacherService;
        $this->guardianService        = $guardianService;
        $this->paymentTypeService     = $paymentTypeService;
        $this->smsService             = $smsService;
        $this->classTypeService       = $classTypeService;
        $this->campaignService        = $campaignService;
    }

    public function admissionReport()
    {
        $data = [
            'pageTitle' => self::moduleName . ' - Admission',
        ];

        return view(self::moduleDirectory . 'admission.index', $data);
    }

    public function admissionReportByType(Request $request, $type)
    {
        $common = [
            'sessions' => $this->sessionService->listByStatus(),
            'courses'  => $this->courseService->lists(),
        ];

        $sessionId = $request->has('session_id') ? $request->session_id : '';
        $courseId  = $request->has('course_id') ? $request->course_id : '';

        $common['sessionId'] = $sessionId;
        $common['courseId']  = $courseId;

        if (!empty($sessionId) || !empty($courseId)) {
            $common['searchResult'] = $this->admissionService->searchStudentsByTypeSessionIdCourseId(
                $type,
                $sessionId,
                $courseId,
            );
        }

        if ($type == 2) {
            $pageSpecific = [
                'pageTitle' => self::moduleName . ' - Admission - Foreign Students',
            ];
            $data         = array_reduce([$common, $pageSpecific], 'array_merge', []);

            return view(self::moduleDirectory . 'admission.foreign', $data);
        }

        if ($type == 3) {
            $pageSpecific = [
                'pageTitle' => self::moduleName . ' - Admission - Insolvent & Meritorioue Quota',
            ];
            $data         = array_reduce([$common, $pageSpecific], 'array_merge', []);

            return view(self::moduleDirectory . 'admission.poor_fund', $data);
        }

        if ($type == 'all') {
            $pageSpecific = [
                'pageTitle' => self::moduleName . ' - Student Admission - All',
            ];
            $data         = array_reduce([$common, $pageSpecific], 'array_merge', []);

            return view(self::moduleDirectory . 'admission.allStudent', $data);
        }

        $pageSpecific = [
            'pageTitle' => self::moduleName . ' - Admission - Normal Students',
        ];
        $data         = array_reduce([$common, $pageSpecific], 'array_merge', []);

        return view(self::moduleDirectory . 'admission.normal', $data);
    }

    public function exportAdmissionReportByType(Request $request, $type)
    {
        $sessions     = $this->sessionService->listByStatus();
        $courses      = $this->courseService->lists();
        $sessionId    = $request->has('session_id') ? $request->session_id : '';
        $courseId     = $request->has('course_id') ? $request->course_id : '';
        $searchResult = [];

        if (!empty($sessionId) || !empty($courseId)) {
            $searchResult = $this->admissionService->searchStudentsByTypeSessionIdCourseId(
                $type,
                $sessionId,
                $courseId,
            );
        }

        return Excel::download(
            new AdmissionReportsByStudentCategory($sessionId, $courseId, $type, $searchResult, $sessions, $courses),
            ' Admission Result (Session: ' . $sessions[$sessionId] . ').xlsx',
        );
    }

    public function printAdmissionReportByType(Request $request, $type)
    {
        $data = [
            'sessions' => $this->sessionService->listByStatus(),
            'courses'  => $this->courseService->lists(),
        ];

        $sessionId         = $request->has('session_id') ? $request->session_id : '';
        $courseId          = $request->has('course_id') ? $request->course_id : '';
        $data['sessionId'] = $sessionId;
        $data['courseId']  = $courseId;

        if (!empty($sessionId) || !empty($courseId)) {
            $data['searchResult'] = $this->admissionService->searchStudentsByTypeSessionIdCourseId(
                $type,
                $sessionId,
                $courseId,
            );
        }

        if ($type == 2) {
            $data['pageTitle'] = self::moduleName . ' - Admission - Foreign Students';

            return view(self::moduleDirectory . 'admission.print_foreign', $data);
        }

        if ($type == 3) {
            $data['pageTitle'] = self::moduleName . ' - Admission - Insolvent & Meritorious Quota';

            return view(self::moduleDirectory . 'admission.print_poor_fund', $data);
        }

        if ($type == 'all') {
            $data['pageTitle'] = self::moduleName . ' - Admission - All';

            return view(self::moduleDirectory . 'admission.print_allStudent', $data);
        }
        $data['pageTitle'] = self::moduleName . ' - Admission - Normal Students';

        return view(self::moduleDirectory . 'admission.print_normal', $data);
    }

    //single applicant details
    public function applicantSingleReport($id)
    {
        $data = [
            'pageTitle'     => 'Applicant Detail',
            'student'       => $this->admissionService->find($id),
            'studentStatus' => UtilityServices::$studentStatus,
        ];

        return view(self::moduleDirectory . 'admission.applicantDetail', $data);
    }

    //single applicant details print
    public function applicantSingleDetailPrint($id)
    {
        $data = [
            'pageTitle'     => 'Applicant Detail',
            'student'       => $this->admissionService->find($id),
            'studentStatus' => UtilityServices::$studentStatus,
        ];

        return view(self::moduleDirectory . 'admission.applicantSinglePrint', $data);
    }

    //student admission info report
    public function studentAdmissionReport()
    {
        $data = [
            'pageTitle' => self::moduleName . ' - Student Admission',
        ];

        return view(self::moduleDirectory . 'student.admission.student_admission', $data);
    }

    public function studentAdmissionReportByType(Request $request, $type)
    {
        $common = [
            'sessions' => $this->sessionService->listByStatus(),
            'courses'  => $this->courseService->lists(),
        ];

        $sessionId = $request->has('session_id') ? $request->session_id : '';
        $courseId  = $request->has('course_id') ? $request->course_id : '';

        $common['sessionId'] = $sessionId;
        $common['courseId']  = $courseId;

        if (!empty($sessionId) || !empty($courseId)) {
            $common['searchResult'] = $this->studentService->searchStudentsByTypeSessionIdCourseId(
                $type,
                $sessionId,
                $courseId,
            );
        }

        if ($type == 2) {
            $pageSpecific = [
                'pageTitle' => self::moduleName . ' - Student Admission - Foreign Students',
            ];

            $data = array_reduce([$common, $pageSpecific], 'array_merge', []);

            return view(self::moduleDirectory . 'student.admission.foreign', $data);
            //            return view(self::moduleDirectory . 'student.admission.allStudent', $data);
        }

        if ($type == 3) {
            $pageSpecific = [
                'pageTitle' => self::moduleName . ' - Student Admission - Insolvent & Meritorious Quota',
            ];

            $data = array_reduce([$common, $pageSpecific], 'array_merge', []);

            return view(self::moduleDirectory . 'student.admission.poor_fund', $data);
            //            return view(self::moduleDirectory . 'student.admission.allStudent', $data);
        }

        if ($type == 'all') {
            $pageSpecific = [
                'pageTitle' => self::moduleName . ' - Student Admission - All',
            ];
            $data         = array_reduce([$common, $pageSpecific], 'array_merge', []);

            return view(self::moduleDirectory . 'student.admission.allStudent', $data);
        }

        $pageSpecific = [
            'pageTitle' => self::moduleName . ' - Student Admission - Normal Students',
        ];

        $data = array_reduce([$common, $pageSpecific], 'array_merge', []);

        return view(self::moduleDirectory . 'student.admission.student_admission_normal', $data);
        //        return view(self::moduleDirectory . 'student.admission.allStudent', $data);
    }

    //student admission info report in excel
    public function exportStudentAdmissionReportByType(Request $request, $type)
    {
        $sessions     = $this->sessionService->listByStatus();
        $courses      = $this->courseService->lists();
        $sessionId    = $request->has('session_id') ? $request->session_id : '';
        $courseId     = $request->has('course_id') ? $request->course_id : '';
        $searchResult = [];

        if (!empty($sessionId) || !empty($courseId)) {
            $searchResult = $this->studentService->searchStudentsByTypeSessionIdCourseId($type, $sessionId, $courseId);
        }

        return Excel::download(
            new StudentAdmissionReportsByStudentCategory(
                $sessionId,
                $courseId,
                $type,
                $searchResult,
                $sessions,
                $courses,
            ),
            ' Admission Result (Session: ' . $sessions[$sessionId] . ').xlsx',
        );
    }

    //student admission info report print
    public function printStudentAdmissionReportByType(Request $request, $type)
    {
        $data = [
            'sessions' => $this->sessionService->listByStatus(),
            'courses'  => $this->courseService->lists(),
        ];

        $sessionId         = $request->has('session_id') ? $request->session_id : '';
        $courseId          = $request->has('course_id') ? $request->course_id : '';
        $data['sessionId'] = $sessionId;
        $data['courseId']  = $courseId;
        $pageLayout        = $request->page_layout ?? 'A4-landscape';

        if (!empty($sessionId) || !empty($courseId)) {
            $data['searchResult'] = $this->studentService->searchStudentsByTypeSessionIdCourseId(
                $type,
                $sessionId,
                $courseId,
            );
        }

        $viewName = '';
        $fileName = '';

        if ($type == 2) {
            $data['pageTitle'] = self::moduleName . ' - Student Admission - Foreign Students';
            $viewName          = self::moduleDirectory . 'student.admission.pdf.print_foreign';
            $fileName          = 'foreign_students_admission_report_' . date('Y-m-d_H-i-s') . '.pdf';
        } elseif ($type == 3) {
            $data['pageTitle'] = self::moduleName . ' - Student Admission - Insolvent & Meritorious Quota';
            $viewName          = self::moduleDirectory . 'student.admission.pdf.print_poor_fund';
            $fileName          = 'poor_fund_students_admission_report_' . date('Y-m-d_H-i-s') . '.pdf';
        } elseif ($type == 'all') {
            $data['pageTitle'] = self::moduleName . ' - Admission - All';
            $viewName          = self::moduleDirectory . 'student.admission.pdf.print_all_category_student';
            $fileName          = 'all_students_admission_report_' . date('Y-m-d_H-i-s') . '.pdf';
        } else {
            $data['pageTitle'] = self::moduleName . ' - Admission - Normal Students';
            $viewName          = self::moduleDirectory . 'student.admission.pdf.print_normal_student';
            $fileName          = 'normal_students_admission_report_' . date('Y-m-d_H-i-s') . '.pdf';
        }

        $pdf = PDF::loadView($viewName, $data, [], ['format' => $pageLayout]);

        return $pdf->stream($fileName);
    }

    //single student basic info details
    public function admissionSingleStudentReport($id)
    {
        $data = [
            'pageTitle'     => 'Student Detail',
            'student'       => $this->studentService->find($id),
            'studentStatus' => UtilityServices::$studentStatus,
        ];
        return view(self::moduleDirectory . 'student.admission.applicantStudentDetail', $data);
    }

    //single applicant details print
    public function admissionSingleStudentDetailPrint($id)
    {
        $data = [
            'pageTitle'     => 'Student Detail',
            'student'       => $this->studentService->find($id),
            'studentStatus' => UtilityServices::$studentStatus,
        ];
        return view(self::moduleDirectory . 'student.admission.applicantStudentDetailPrint', $data);
    }

    public function attendanceReport(Request $request)
    {
        $data = [
            'pageTitle'          => self::moduleName . ' - Attendance',
            'sessions'           => $this->sessionService->listByStatus(),
            'courses'            => $this->courseService->listByStatus(),
            'phases'             => $this->phaseService->listByStatus(),
            'classTypes'         => $this->classTypeService->listByStatus(),
            'selectedClassTypes' => collect([]),
            'attendanceReport'   => collect([]),
            'showAllClassTypes'  => false,
        ];

        if ($request->has(['session_id', 'course_id', 'phase_id', 'subject_id'])) {
            // Get selected class types
            $selectedClassTypeIds = $request->class_type_ids ?? [];

            if (!empty($selectedClassTypeIds) && is_array($selectedClassTypeIds)) {
                // Specific class types selected - show separate columns
                $data['selectedClassTypes'] = $this->classTypeService->findMultiple($selectedClassTypeIds);
                $data['showAllClassTypes']  = false;
            } else {
                // No class types selected - show combined column
                $allClassTypes              = $this->classTypeService->listByStatus();
                $selectedClassTypeIds       = $allClassTypes->keys()->toArray();
                $data['selectedClassTypes'] = $allClassTypes;
                $data['showAllClassTypes']  = true;
            }

            // Get attendance report
            $data['attendanceReport'] = $this->attendanceService->getAttendanceReportByClassType($request, $selectedClassTypeIds);
        }

        return view(self::moduleDirectory . 'attendance.index', $data);
    }

    public function attendanceReportInExcel(Request $request)
    {
        $subjectInfo        = $this->subjectService->find($request->subject_id);
        $sessionInfo        = $this->sessionService->find($request->session_id);
        $courseInfo         = $this->courseService->find($request->course_id);
        $phaseInfo          = $this->phaseService->find($request->phase_id);
        $selectedClassTypes = collect([]);
        $attendance         = collect([]);
        $showAllClassTypes  = false;

        if (!empty($sessionInfo) && !empty($courseInfo) && !empty($phaseInfo) && !empty($request->subject_id)) {
            // Get selected class types
            $selectedClassTypeIds = $request->class_type_ids ?? [];

            if (!empty($selectedClassTypeIds) && is_array($selectedClassTypeIds)) {
                // Specific class types selected - show separate columns
                $selectedClassTypes = $this->classTypeService->findMultiple($selectedClassTypeIds);
            } else {
                // No class types selected - show combined column
                $allClassTypes        = $this->classTypeService->listByStatus();
                $selectedClassTypeIds = $allClassTypes->keys()->toArray();
                $selectedClassTypes   = $allClassTypes;
                $showAllClassTypes    = true;
            }

            // Get attendance report
            $attendance = $this->attendanceService->getAttendanceReportByClassType($request, $selectedClassTypeIds);
        }

        return Excel::download(
            new AttendanceExport(
                $attendance,
                $subjectInfo,
                $sessionInfo,
                $courseInfo,
                $phaseInfo,
                $showAllClassTypes,
                $selectedClassTypes,
                $request->start_date,
                $request->end_date,
            ),
            $sessionInfo->title . '_' . $courseInfo->title . '_' . $phaseInfo->title . '_attendance.xlsx',
        );
    }

    //attendance report in PDF
    public function attendanceReportInPdf(Request $request)
    {
        $session            = $this->sessionService->find($request->session_id)->title;
        $course             = $this->courseService->find($request->course_id)->title;
        $phase              = $this->phaseService->find($request->phase_id)->title;
        $department         = $this->departmentService->getDepartmentBySubjects($request->subject_id)->title;
        $selectedClassTypes = collect([]);
        $attendanceReport   = collect([]);
        $showAllClassTypes  = false;

        if (!empty($session) && !empty($course) && !empty($phase) && !empty($request->subject_id)) {
            // Get selected class types
            $selectedClassTypeIds = $request->class_type_ids ?? [];

            if (!empty($selectedClassTypeIds) && is_array($selectedClassTypeIds)) {
                // Specific class types selected - show separate columns
                $selectedClassTypes = $this->classTypeService->findMultiple($selectedClassTypeIds);
            } else {
                // No class types selected - show combined column
                $allClassTypes        = $this->classTypeService->listByStatus();
                $selectedClassTypeIds = $allClassTypes->keys()->toArray();
                $selectedClassTypes   = $allClassTypes;
                $showAllClassTypes    = true;
            }

            // Get attendance report
            $attendanceReport = $this->attendanceService->getAttendanceReportByClassType($request, $selectedClassTypeIds);
        }

        $data = [
            'session'            => $session,
            'course'             => $course,
            'phase'              => $phase,
            'department'         => $department,
            'attendanceReport'   => $attendanceReport,
            'start_date'         => $request->start_date,
            'end_date'           => $request->end_date,
            'showAllClassTypes'  => $showAllClassTypes,
            'selectedClassTypes' => $selectedClassTypes,
        ];

        $document = $session . '-' . $course . '-' . $phase . '_attendance.pdf';

        return PDF::loadView('reports.attendance.pdf.attendance', $data)
                  ->stream($document);
    }

    //attendance report by term
    public function attendanceByTermReport(Request $request)
    {
        $data = [
            'pageTitle' => self::moduleName . ' - Attendance By Term',
            'sessions'  => $this->sessionService->listByStatus(),
            'courses'   => $this->courseService->listByStatus(),
            'phases'    => $this->phaseService->listByStatus(),
            'terms'     => $this->termService->listByStatus(),
        ];
        if ($request->has(['session_id', 'course_id', 'phase_id', 'term_id', 'subject_group_id'])) {
            $data['totalLectureClass']   = $this->attendanceService->getTotalClassBySubjectGroupId(
                $request->session_id,
                $request->course_id,
                $request->phase_id,
                $request->term_id,
                $request->subject_group_id,
                [
                    1,
                    9,
                    17,
                ],
                true,
                $request->start_date,
                $request->end_date,
                $request->student_groupid,
            );
            $data['totalPracticalClass'] = $this->attendanceService->getTotalClassBySubjectGroupId(
                $request->session_id,
                $request->course_id,
                $request->phase_id,
                $request->term_id,
                $request->subject_group_id,
                [
                    1,
                    9,
                    17,
                ],
                false,
                $request->start_date,
                $request->end_date,
                $request->student_groupid,
            );
            $data['attendanceReport']    = $this->attendanceService->getAttendanceReport($request);
        }

        return view(self::moduleDirectory . 'attendance.attendanceByTerm', $data);
    }

    //attendance report by term in excel
    public function attendanceByTermReportInExcel(Request $request)
    {
        $sessionInfo = $this->sessionService->find($request->session_id)->title;
        $course      = $this->courseService->find($request->course_id)->title;
        $phase       = $this->phaseService->find($request->phase_id)->title;
        $term        = $this->termService->find($request->term_id);
        $term_name   = '';
        if ($term) {
            $term_name = $term->title;
        }
        $department        = $this->departmentService->getDepartmentBySubjectGroupId($request->subject_group_id);
        $totalLectureClass = $this->attendanceService->getTotalClassBySubjectGroupId(
            $request->session_id,
            $request->course_id,
            $request->phase_id,
            $request->term_id,
            $request->subject_group_id,
            [
                1,
                9,
                17,
            ],
            true,
            $request->start_date,
            $request->end_date,
            $request->student_groupid,
        );

        $totalPracticalClass = $this->attendanceService->getTotalClassBySubjectGroupId(
            $request->session_id,
            $request->course_id,
            $request->phase_id,
            $request->term_id,
            $request->subject_group_id,
            [
                1,
                9,
                17,
            ],
            false,
            $request->start_date,
            $request->end_date,
            $request->student_groupid,
        );
        $attendanceReport    = $this->attendanceService->getAttendanceReport($request);

        return Excel::download(
            new AttendanceByTermExport(
                $sessionInfo,
                $course,
                $phase,
                $term_name,
                $department,
                $totalLectureClass,
                $totalPracticalClass,
                $attendanceReport,
            ),
            'session_' . $sessionInfo . '_attendance_by_term.xlsx',
        );
    }

    //attendance report by term in pdf
    public function attendanceByTermReportInPdf(Request $request)
    {
        $sessionInfo = $this->sessionService->find($request->session_id)->title;
        $course      = $this->courseService->find($request->course_id)->title;
        $phase       = $this->phaseService->find($request->phase_id)->title;
        $term        = $this->termService->find($request->term_id)->title;

        $department          = $this->departmentService->getDepartmentBySubjectGroupId(
            $request->subject_group_id,
        )->title;
        $totalLectureClass   = $this->attendanceService->getTotalClassBySubjectGroupId(
            $request->session_id,
            $request->course_id,
            $request->phase_id,
            $request->term_id,
            $request->subject_group_id,
            [
                1,
                9,
                17,
            ],
            true,
            $request->start_date,
            $request->end_date,
            $request->student_groupid,
        );
        $totalPracticalClass = $this->attendanceService->getTotalClassBySubjectGroupId(
            $request->session_id,
            $request->course_id,
            $request->phase_id,
            $request->term_id,
            $request->subject_group_id,
            [
                1,
                9,
                17,
            ],
            false,
            $request->start_date,
            $request->end_date,
            $request->student_groupid,
        );
        $attendanceReport    = $this->attendanceService->getAttendanceReport($request);

        $data     = [
            'sessionInfo'         => $sessionInfo,
            'course'              => $course,
            'phase'               => $phase,
            'term'                => $term,
            'department'          => $department,
            'totalLectureClass'   => $totalLectureClass,
            'totalPracticalClass' => $totalPracticalClass,
            'attendanceReport'    => $attendanceReport,
            'start_date'          => $request->start_date,
            'end_date'            => $request->end_date,
        ];
        $document = $sessionInfo . '-' . $course . '-' . $phase . '_attendance_of_' . $term . '.pdf';
        return PDF::loadView('reports.attendance.pdf.attendanceByTerm', $data)->stream($document);
    }

    //attendance report by phase
    public function attendanceByPhaseReport(Request $request)
    {
        $data = [
            'pageTitle' => self::moduleName . ' - Attendance By Phase',
            'sessions'  => $this->sessionService->listByStatus(),
            'courses'   => $this->courseService->listByStatus(),
            'phases'    => $this->phaseService->listByStatus(),
        ];

        if ($request->has(['session_id', 'course_id', 'phase_id'])) {
            $data['subjects'] = $this->subjectService->getSubjectsBySessionIdCourseIdPhaseId(
                $request->session_id,
                $request->course_id,
                $request->phase_id,
            );

            $data['attendanceData'] = $this->attendanceService->getStudentsAttendanceBySessionCourseAndPhase(
                $request->session_id,
                $request->course_id,
                $request->phase_id,
                $request->start_date,
                $request->end_date,
            );

            // Group attendance data by student and then by subject for easier display in the view
            $data['attendanceByStudent'] = collect($data['attendanceData'])
                ->groupBy('roll_no')
                ->sortKeys()
                ->map(function ($studentData) {
                    $firstRecord = $studentData->first();

                    return [
                        'student_name' => $firstRecord['full_name'] ?? '',
                        'subjects'     => $studentData->keyBy('subject_id'),
                    ];
                });

            $estimatedCells = $data['attendanceByStudent']->count() * $data['subjects']->count();
            // If the estimated number of cells in the report is large, increase time and memory limits
            if ($estimatedCells >= 2000) {
                set_time_limit(500);
                ini_set('memory_limit', '512M');
            }
        }

        return view(self::moduleDirectory . 'attendance.attendanceByPhase', $data);
    }

    //attendance report by phase in Excel
    public function attendanceByPhaseReportInExcel(Request $request)
    {
        $sessionInfo    = $this->sessionService->find($request->session_id)->title;
        $course         = $this->courseService->find($request->course_id)->title;
        $phase          = $this->phaseService->find($request->phase_id)->title;
        $subjects       = $this->subjectService->getSubjectsBySessionIdCourseIdPhaseId(
            $request->session_id,
            $request->course_id,
            $request->phase_id,
        );
        $attendanceData = $this->attendanceService->getStudentsAttendanceBySessionCourseAndPhase(
            $request->session_id,
            $request->course_id,
            $request->phase_id,
            $request->start_date,
            $request->end_date,
        );
        // Group attendance data by student and then by subject for easier display in the view
        $attendanceByStudent = collect($attendanceData)
            ->groupBy('roll_no')
            ->sortKeys()
            ->map(function ($studentData) {
                $firstRecord = $studentData->first();

                return [
                    'student_name' => $firstRecord['full_name'] ?? '',
                    'subjects'     => $studentData->keyBy('subject_id'),
                ];
            });

        $estimatedCells = $attendanceByStudent->count() * $subjects->count();
        // If the estimated number of cells in the report is large, increase time and memory limits
        if ($estimatedCells >= 2000) {
            set_time_limit(500);
            ini_set('memory_limit', '512M');
        }

        return Excel::download(
            new AttendanceByPhaseExport($sessionInfo, $course, $phase, $subjects, $attendanceByStudent),
            'session_' . $sessionInfo . '_course_' . $course . '_attendance_by_phase.xlsx',
        );
    }

    //attendance report by phase in PDF
    public function attendanceByPhaseReportInPdf(Request $request)
    {
        $sessionInfo = $this->sessionService->find($request->session_id)->title;
        $course      = $this->courseService->find($request->course_id)->title;
        $phase       = $this->phaseService->find($request->phase_id)->title;
        $pageLayout  = $request->page_layout ?? 'A4-landscape';

        $subjects       = $this->subjectService->getSubjectsBySessionIdCourseIdPhaseId(
            $request->session_id,
            $request->course_id,
            $request->phase_id,
        );
        $attendanceData = $this->attendanceService->getStudentsAttendanceBySessionCourseAndPhase(
            $request->session_id,
            $request->course_id,
            $request->phase_id,
            $request->start_date,
            $request->end_date,
        );
        // Group attendance data by student and then by subject for easier display in the view
        $attendanceByStudent = collect($attendanceData)
            ->groupBy('roll_no')
            ->sortKeys()
            ->map(function ($studentData) {
                $firstRecord = $studentData->first();

                return [
                    'student_name' => $firstRecord['full_name'] ?? '',
                    'subjects'     => $studentData->keyBy('subject_id'),
                ];
            });

        $estimatedCells = $attendanceByStudent->count() * $subjects->count();
        // If the estimated number of cells in the report is large, increase time and memory limits
        if ($estimatedCells >= 2000) {
            set_time_limit(500);
            ini_set('memory_limit', '512M');
        }

        $data     = [
            'sessionInfo'    => $sessionInfo,
            'course'         => $course,
            'phase'          => $phase,
            'subjects'       => $subjects,
            'attendanceByStudent' => $attendanceByStudent,
            'start_date'     => $request->start_date ?? '',
            'end_date'       => $request->end_date ?? '',
        ];
        $document = $sessionInfo . '-' . $course . '_attendance_of_' . $phase . '.pdf';
        $pdf      = PDF::loadView('reports.attendance.pdf.attendanceByPhase', $data, [], ['format' => $pageLayout]);

        return $pdf->stream($document);
    }

    //attendance report by student
    public function attendanceByStudentReport(Request $request)
    {
        $data = [
            'pageTitle'          => self::moduleName . ' - Attendance By Student',
            'sessions'           => $this->sessionService->listByStatus(),
            'courses'            => $this->courseService->listByStatus(),
            'phases'             => $this->phaseService->listByStatus(),
            'classTypes'         => $this->classTypeService->listByStatus(),
            'selectedClassTypes' => collect([]),
            'showAllClassTypes'  => false,
        ];

        if ($request->has(['session_id', 'course_id', 'phase_id', 'subject_id', 'student_id'])) {
            // Get selected class types
            $selectedClassTypeIds = $request->class_type_ids ?? [];

            if (!empty($selectedClassTypeIds) && is_array($selectedClassTypeIds)) {
                // Specific class types selected - show separate columns
                $data['selectedClassTypes'] = $this->classTypeService->findMultiple($selectedClassTypeIds);
                $data['showAllClassTypes']  = false;
            } else {
                // No class types selected - show combined column
                $allClassTypes              = $this->classTypeService->listByStatus();
                $selectedClassTypeIds       = $allClassTypes->keys()->toArray();
                $data['selectedClassTypes'] = $allClassTypes;
                $data['showAllClassTypes']  = true;
            }

            $student                 = $this->studentService->find($request->student_id);
            $data['student']         = $student;
            $data['totalClass']      = $this->attendanceService->getTotalClassBySubjectClassType(
                $student->id,
                $request->session_id,
                $request->course_id,
                $request->phase_id,
                null,
                $request->subject_id,
                $request->start_date,
                $request->end_date,
                $request->class_type_ids,
            );
            $data['totalAttendance'] = $this->attendanceService->getAttendanceBySubjectClassTypeStudentId(
                $request->session_id,
                $request->course_id,
                $request->phase_id,
                null,
                $request->subject_id,
                $request->student_id,
                $request->start_date,
                $request->end_date,
                $request->class_type_ids,
            );
            $data['attendanceData']  = $this->attendanceService->getAttendanceBySessionCoursePhaseTermSubjectClassTypeAndStudentId(
                $request->session_id,
                $request->course_id,
                $request->phase_id,
                null,
                $request->subject_id,
                $request->student_id,
                $request->start_date,
                $request->end_date,
                $request->class_type_ids,
            );
        }

        return view(self::moduleDirectory . 'attendance.attendanceByStudent', $data);
    }

    //attendance report by student in excel
    public function attendanceByStudentReportInExcel(Request $request)
    {
        $student            = $this->studentService->find($request->student_id);
        $sessionInfo        = $this->sessionService->find($request->session_id)->title;
        $course             = $this->courseService->find($request->course_id)->title;
        $phase              = $this->phaseService->find($request->phase_id)->title;
        $selectedClassTypes = collect([]);
        $showAllClassTypes  = false;
        // Get selected class types
        $selectedClassTypeIds = $request->class_type_ids ?? [];

        if (!empty($selectedClassTypeIds) && is_array($selectedClassTypeIds)) {
            // Specific class types selected - show separate columns
            $selectedClassTypes = $this->classTypeService->findMultiple($selectedClassTypeIds);
        } else {
            // No class types selected - show combined column
            $allClassTypes        = $this->classTypeService->listByStatus();
            $selectedClassTypeIds = $allClassTypes->keys()->toArray();
            $selectedClassTypes   = $allClassTypes;
            $showAllClassTypes    = true;
        }

        $department      = $this->departmentService->getDepartmentBySubjectGroupId($request->subject_group_id)->title;
        $totalClass      = $this->attendanceService->getTotalClassBySubjectClassType(
            $student->id,
            $request->session_id,
            $request->course_id,
            $request->phase_id,
            null,
            $request->subject_id,
            $request->start_date,
            $request->end_date,
            $request->class_type_ids,
        );
        $totalAttendance = $this->attendanceService->getAttendanceBySubjectClassTypeStudentId(
            $request->session_id,
            $request->course_id,
            $request->phase_id,
            null,
            $request->subject_id,
            $request->student_id,
            $request->start_date,
            $request->end_date,
            $request->class_type_ids,
        );
        $attendanceData  = $this->attendanceService->getAttendanceBySessionCoursePhaseTermSubjectClassTypeAndStudentId(
            $request->session_id,
            $request->course_id,
            $request->phase_id,
            null,
            $request->subject_id,
            $request->student_id,
            $request->start_date,
            $request->end_date,
            $request->class_type_ids,
        );

        return Excel::download(
            new AttendanceByStudentExport(
                $student,
                $sessionInfo,
                $course,
                $phase,
                $selectedClassTypes,
                $showAllClassTypes,
                $department,
                $totalClass,
                $totalAttendance,
                $attendanceData,
                $request->start_date,
                $request->end_date,
            ),
            'session_' . $sessionInfo . '_attendance_by_student.xlsx',
        );
    }

    //attendance report by student in pdf
    public function attendanceByStudentReportInPdf(Request $request)
    {
        $student            = $this->studentService->find($request->student_id);
        $sessionInfo        = $this->sessionService->find($request->session_id)->title;
        $course             = $this->courseService->find($request->course_id)->title;
        $phase              = $this->phaseService->find($request->phase_id)->title;
        $selectedClassTypes = collect([]);
        $showAllClassTypes  = false;

        // Get selected class types
        $selectedClassTypeIds = $request->class_type_ids ?? [];

        if (!empty($selectedClassTypeIds) && is_array($selectedClassTypeIds)) {
            // Specific class types selected - show separate columns
            $selectedClassTypes = $this->classTypeService->findMultiple($selectedClassTypeIds);
        } else {
            // No class types selected - show combined column
            $allClassTypes        = $this->classTypeService->listByStatus();
            $selectedClassTypeIds = $allClassTypes->keys()->toArray();
            $selectedClassTypes   = $allClassTypes;
            $showAllClassTypes    = true;
        }

        $department      = $this->departmentService->getDepartmentBySubjectGroupId($request->subject_group_id)->title;
        $totalClass      = $this->attendanceService->getTotalClassBySubjectClassType(
            $student->id,
            $request->session_id,
            $request->course_id,
            $request->phase_id,
            null,
            $request->subject_id,
            $request->start_date,
            $request->end_date,
            $request->class_type_ids,
        );
        $totalAttendance = $this->attendanceService->getAttendanceBySubjectClassTypeStudentId(
            $request->session_id,
            $request->course_id,
            $request->phase_id,
            null,
            $request->subject_id,
            $request->student_id,
            $request->start_date,
            $request->end_date,
            $request->class_type_ids,
        );
        $attendanceData  = $this->attendanceService->getAttendanceBySessionCoursePhaseTermSubjectClassTypeAndStudentId(
            $request->session_id,
            $request->course_id,
            $request->phase_id,
            null,
            $request->subject_id,
            $request->student_id,
            $request->start_date,
            $request->end_date,
            $request->class_type_ids,
        );

        $data     = [
            'student'            => $student,
            'sessionInfo'        => $sessionInfo,
            'course'             => $course,
            'phase'              => $phase,
            'department'         => $department,
            'totalClass'         => $totalClass,
            'totalAttendance'    => $totalAttendance,
            'attendanceData'     => $attendanceData,
            'start_date'         => $request->start_date,
            'end_date'           => $request->end_date,
            'showAllClassTypes'  => $showAllClassTypes,
            'selectedClassTypes' => $selectedClassTypes,
        ];
        $document = $sessionInfo . '_' . $course . '_attendance_of_' . $student->full_name_en . '.pdf';

        return PDF::loadView('reports.attendance.pdf.attendanceByStudent', $data)->stream($document);
    }

    //single student payment report
    public function studentPaymentReport(Request $request)
    {
        $data = [
            'pageTitle'           => self::moduleName . ' - Student Payment',
            'sessions'            => $this->sessionService->listByStatus(),
            'courses'             => $this->courseService->listByStatus(),
            'studentInstallments' => new Collection(),
            'studentPayments'     => new Collection(),
        ];

        $studentId = null;

        if ($request->student_user_id) {
            $user      = User::where('user_id', $request->student_user_id)->first();
            $studentId = $user && $this->studentService->findBy(['user_id' => $user->id])
                ? $this->studentService->findBy(['user_id' => $user->id])->id
                : null;
        } elseif ($request->student_id) {
            $studentId = $request->student_id;
        }

        $request['student_id'] = $studentId;

        if ($request->has(['student_id', 'from_date'])) {
            $installments                    = $this->studentFeeService->getStudentInstallmentDetailsByStudentIdAndDate(
                $request->student_id,
                $request->from_date,
                $request->to_date,
            );
            $totalDevelopmentAvailableAmount = $installments
                ->flatMap(fn($payment) => $payment->studentPaymentDetails)
                ->pluck('studentPayment')
                ->unique('id')
                ->sum('available_amount');

            $payments                    = $this->studentFeeService->getStudentPaymentDetailsByStudentIdAndDate(
                $request->student_id,
                $request->from_date,
                $request->to_date,
            );
            $totalTuitionAvailableAmount = $payments
                ->flatMap(fn($payment) => $payment->studentPaymentDetails)
                ->pluck('studentPayment')
                ->unique('id')
                ->sum('available_amount');

            $data['studentInstallments']             = $installments;
            $data['totalDevelopmentAvailableAmount'] = $totalDevelopmentAvailableAmount;
            $data['studentPayments']                 = $payments;
            $data['totalTuitionAvailableAmount']     = $totalTuitionAvailableAmount;
        }

        return view(self::moduleDirectory . 'payment.studentPayment', $data);
    }

    //single student payment report in pdf
    public function studentPaymentReportPdf(Request $request)
    {
        $studentId = null;

        if ($request->student_user_id) {
            $user      = User::where('user_id', $request->student_user_id)->first();
            $studentId = $user && $this->studentService->findBy(['user_id' => $user->id])
                ? $this->studentService->findBy(['user_id' => $user->id])->id
                : null;
        } elseif ($request->student_id) {
            $studentId = $request->student_id;
        }

        $request['student_id'] = $studentId;

        if ($request->has(['student_id', 'from_date'])) {
            $installments                    = $this->studentFeeService->getStudentInstallmentDetailsByStudentIdAndDate(
                $request->student_id,
                $request->from_date,
                $request->to_date,
            );
            $totalDevelopmentAvailableAmount = $installments
                ->flatMap(fn($payment) => $payment->studentPaymentDetails)
                ->pluck('studentPayment')
                ->unique('id')
                ->sum('available_amount');

            $payments                    = $this->studentFeeService->getStudentPaymentDetailsByStudentIdAndDate(
                $request->student_id,
                $request->from_date,
                $request->to_date,
            );
            $totalTuitionAvailableAmount = $payments
                ->flatMap(fn($payment) => $payment->studentPaymentDetails)
                ->pluck('studentPayment')
                ->unique('id')
                ->sum('available_amount');

            $data['studentInstallments']             = $installments;
            $data['totalDevelopmentAvailableAmount'] = $totalDevelopmentAvailableAmount;
            $data['studentPayments']                 = $payments;
            $data['totalTuitionAvailableAmount']     = $totalTuitionAvailableAmount;
            $data['student']                         = $this->studentService->find($request->student_id);
        }

        $document = $data['student']->full_name_en . '_payments.pdf';
        $pdf      = PDF::loadView('reports.payment.pdf.studentPayment', $data);

        return $pdf->stream($document);
    }

    //single student payment report in excel
    public function exportStudentPaymentReport(Request $request)
    {
        $studentId = null;

        if ($request->student_user_id) {
            $user      = User::where('user_id', $request->student_user_id)->first();
            $studentId = $user && $this->studentService->findBy(['user_id' => $user->id])
                ? $this->studentService->findBy(['user_id' => $user->id])->id0
                : null;
        } elseif ($request->student_id) {
            $studentId = $request->student_id;
        }
        $request['student_id'] = $studentId;

        if ($request->has(['student_id', 'from_date'])) {
            $studentInstallments             = $this->studentFeeService->getStudentInstallmentDetailsByStudentIdAndDate(
                $request->student_id,
                $request->from_date,
                $request->to_date,
            );
            $totalDevelopmentAvailableAmount = $studentInstallments
                ->flatMap(fn($payment) => $payment->studentPaymentDetails)
                ->pluck('studentPayment')
                ->unique('id')
                ->sum('available_amount');

            $studentPayments             = $this->studentFeeService->getStudentPaymentDetailsByStudentIdAndDate(
                $request->student_id,
                $request->from_date,
                $request->to_date,
            );
            $totalTuitionAvailableAmount = $studentPayments
                ->flatMap(fn($payment) => $payment->studentPaymentDetails)
                ->pluck('studentPayment')
                ->unique('id')
                ->sum('available_amount');
            $student                     = $this->studentService->find($request->student_id);
            $fromDate                    = $request->from_date;
            $toDate                      = $request->to_date;
        }

        return Excel::download(
            new StudentPaymentsExport(
                $studentInstallments,
                $totalDevelopmentAvailableAmount,
                $studentPayments,
                $totalTuitionAvailableAmount,
                $student,
                $fromDate,
                $toDate,
            ),
            $student->full_name_en . '_payments.xlsx',
        );
    }

    //all student payment report
    public function allStudentPaymentReport(Request $request)
    {
        $paymentTypeArr = [];
        if (!empty($this->paymentTypeService->getAllPaymentType())) {
            foreach ($this->paymentTypeService->getAllPaymentType() as $paymentType) {
                $paymentTypeArr[$paymentType['id']] = $paymentType['title'];
            }
        }
        $data = [
            'pageTitle'           => self::moduleName . ' - All Students Payment',
            'sessions'            => $this->sessionService->listByStatus(),
            'courses'             => $this->courseService->listByStatus(),
            'paymentType'         => $paymentTypeArr,
            'studentInstallments' => [],
            'studentFeeDetails'   => [],
        ];

        if ($request->has(['session_id', 'course_id', 'paymentType_id', 'from_date'])) {
            if ($request->paymentType_id == 1) {
                $data['studentInstallments'] = $this->studentFeeService->getAllStudentInstallmentDetailsByStudentIdsAndDate(
                    $request
                );
            } elseif ($request->paymentType_id <> 1) {
                $studentFeeDetails = $this->studentFeeService->getALlStudentPaymentDetailsByStudentIdsPaymentTypeAndDate(
                    $request->session_id,
                    $request->course_id,
                    $request->paymentType_id,
                    $request->from_date,
                    $request->to_date,
                );

                //Student Payment Details Push into Main Array
                $details = [];
                foreach ($studentFeeDetails as $key => $value) {
                    $paymentDetails                        = DB::table('student_payment_details as payment_details')
                                                               ->where(
                                                                   'payment_details.student_fee_detail_id',
                                                                   $value->fee_detail_id,
                                                               )
                                                               ->leftJoin(
                                                                   'student_payments as payment',
                                                                   'payment_details.student_payment_id',
                                                                   '=',
                                                                   'payment.id',
                                                               )
                                                               ->leftJoin(
                                                                   'users',
                                                                   'users.id',
                                                                   '=',
                                                                   'payment.created_by',
                                                               )
                                                               ->select(
                                                                   DB::raw(
                                                                       '(CASE
                WHEN payment.payment_method_id = 1 THEN "Cash on NEMC"
                WHEN payment.payment_method_id = 2 THEN "Cash on Bank"
                WHEN payment.payment_method_id = 3 THEN "Cheque"
                END) AS payment_method',
                                                                   ),
                                                                   'payment.payment_date as payment_date',
                                                                   'payment_details.amount as payment_amount',
                                                                   "payment.created_at",
                                                                   'users.first_name as user_name',
                                                               )->get()->toArray();
                    $details[$key]['student_id']           = $value->student_id;
                    $details[$key]['name']                 = $value->name;
                    $details[$key]['roll']                 = $value->roll;
                    $details[$key]['fee_detail_id']        = $value->fee_detail_id;
                    $details[$key]['fee_payment_type']     = $value->fee_payment_type;
                    $details[$key]['fee_payment_type_id']  = $value->fee_payment_type_id;
                    $details[$key]['payable_amount']       = $value->payable_amount;
                    $details[$key]['discount_amount']      = $value->discount_amount;
                    $details[$key]['last_date_of_payment'] = $value->last_date_of_payment;
                    $details[$key]['bill_month']           = $value->bill_month;
                    $details[$key]['bill_year']            = $value->bill_year;
                    $details[$key]['payments']             = count($paymentDetails) > 0 ? $paymentDetails : [];
                }
                $data['studentFeeDetails'] = $details;
            }
        }

        return view(self::moduleDirectory . 'payment.allStudentPayment', $data);
    }

    //all student payment report in excel
    public function exportAllStudentPaymentReport(Request $request)
    {
        $studentInstallments = $studentPayments = '';
        $paymentTypeArr      = [];
        if (!empty($this->paymentTypeService->getAllPaymentType())) {
            foreach ($this->paymentTypeService->getAllPaymentType() as $paymentType) {
                $paymentTypeArr[$paymentType['id']] = $paymentType['title'];
            }
        }
        if ($request->has(['session_id', 'course_id', 'paymentType_id', 'from_date'])) {
            $session = $this->sessionService->find($request->session_id)->title;
            $course  = $this->courseService->find($request->course_id)->title;
            if ($request->paymentType_id == 1) {
                $studentInstallments = $this->studentFeeService->getAllStudentInstallmentDetailsByStudentIdsAndDate(
                    $request,
                );
            } elseif ($request->paymentType_id <> 1) {
                $studentFeeDetails = $this->studentFeeService->getALlStudentPaymentDetailsByStudentIdsPaymentTypeAndDate(
                    $request->session_id,
                    $request->course_id,
                    $request->paymentType_id,
                    $request->from_date,
                    $request->to_date,
                );

                //Student Payment Details Push into Main Array
                $details = [];
                foreach ($studentFeeDetails as $key => $value) {
                    $paymentDetails                        = DB::table('student_payment_details as payment_details')
                                                               ->where(
                                                                   'payment_details.student_fee_detail_id',
                                                                   $value->fee_detail_id,
                                                               )
                                                               ->leftJoin(
                                                                   'student_payments as payment',
                                                                   'payment_details.student_payment_id',
                                                                   '=',
                                                                   'payment.id',
                                                               )
                                                               ->leftJoin(
                                                                   'users',
                                                                   'users.id',
                                                                   '=',
                                                                   'payment.created_by',
                                                               )
                                                               ->select(
                                                                   DB::raw(
                                                                       '(CASE
                WHEN payment.payment_method_id = 1 THEN "Cash on NEMC"
                WHEN payment.payment_method_id = 2 THEN "Cash on Bank"
                WHEN payment.payment_method_id = 3 THEN "Cheque"
                END) AS payment_method',
                                                                   ),
                                                                   'payment.payment_date as payment_date',
                                                                   'payment_details.amount as payment_amount',
                                                                   "payment.created_at",
                                                                   'users.first_name as user_name',
                                                               )->get()->toArray();
                    $details[$key]['student_id']           = $value->student_id;
                    $details[$key]['name']                 = $value->name;
                    $details[$key]['roll']                 = $value->roll;
                    $details[$key]['fee_detail_id']        = $value->fee_detail_id;
                    $details[$key]['fee_payment_type']     = $value->fee_payment_type;
                    $details[$key]['fee_payment_type_id']  = $value->fee_payment_type_id;
                    $details[$key]['payable_amount']       = $value->payable_amount;
                    $details[$key]['discount_amount']      = $value->discount_amount;
                    $details[$key]['last_date_of_payment'] = $value->last_date_of_payment;
                    $details[$key]['bill_month']           = $value->bill_month;
                    $details[$key]['bill_year']            = $value->bill_year;
                    $details[$key]['payments']             = count($paymentDetails) > 0 ? $paymentDetails : [];
                }
                $studentPayments = $details;
            }
        }

        return Excel::download(
            new AllStudentPaymentsExport(
                $studentInstallments,
                $studentPayments,
                $session,
                $course,
                $paymentTypeArr[$request->paymentType_id],
                $request->from_date,
                $request->to_date,
            ),
            $session . '_' . $course . '_' . $paymentTypeArr[$request->paymentType_id] . '_all_student_payment.xlsx',
        );
    }

    //all student payment report in pdf
    public function allStudentPaymentReportPdf(Request $request)
    {
        $session          = $this->sessionService->find($request->session_id)->title;
        $course           = $this->courseService->find($request->course_id)->title;
        $paymentTypeTitle = $this->paymentTypeService->find($request->paymentType_id)->title;
        $pageLayout       = $request->page_layout ?? 'A4-landscape';

        $studentInstallments = new Collection();
        $studentFeeDetails   = new Collection();

        if ($request->has(['session_id', 'course_id', 'paymentType_id', 'from_date'])) {
            if ($request->paymentType_id == 1) {
                $studentInstallments = $this->studentFeeService->getAllStudentInstallmentDetailsByStudentIdsAndDate(
                    $request,
                );
            } elseif ($request->paymentType_id <> 1) {
                $studentFeeDetails = $this->studentFeeService->getALlStudentPaymentDetailsByStudentIdsPaymentTypeAndDate(
                    $request->session_id,
                    $request->course_id,
                    $request->paymentType_id,
                    $request->from_date,
                    $request->to_date,
                );

                //Student Payment Details Push into Main Array
                $details = [];
                foreach ($studentFeeDetails as $key => $value) {
                    $paymentDetails                        = DB::table('student_payment_details as payment_details')
                                                               ->where(
                                                                   'payment_details.student_fee_detail_id',
                                                                   $value->fee_detail_id,
                                                               )
                                                               ->leftJoin(
                                                                   'student_payments as payment',
                                                                   'payment_details.student_payment_id',
                                                                   '=',
                                                                   'payment.id',
                                                               )
                                                               ->leftJoin(
                                                                   'users',
                                                                   'users.id',
                                                                   '=',
                                                                   'payment.created_by',
                                                               )
                                                               ->select(
                                                                   DB::raw(
                                                                       '(CASE
                WHEN payment.payment_method_id = 1 THEN "Cash on NEMC"
                WHEN payment.payment_method_id = 2 THEN "Cash on Bank"
                WHEN payment.payment_method_id = 3 THEN "Cheque"
                END) AS payment_method',
                                                                   ),
                                                                   'payment.payment_date as payment_date',
                                                                   'payment_details.amount as payment_amount',
                                                                   "payment.created_at",
                                                                   'users.first_name as user_name',
                                                               )->get()->toArray();
                    $details[$key]['student_id']           = $value->student_id;
                    $details[$key]['name']                 = $value->name;
                    $details[$key]['roll']                 = $value->roll;
                    $details[$key]['fee_detail_id']        = $value->fee_detail_id;
                    $details[$key]['fee_payment_type']     = $value->fee_payment_type;
                    $details[$key]['fee_payment_type_id']  = $value->fee_payment_type_id;
                    $details[$key]['payable_amount']       = $value->payable_amount;
                    $details[$key]['discount_amount']      = $value->discount_amount;
                    $details[$key]['last_date_of_payment'] = $value->last_date_of_payment;
                    $details[$key]['bill_month']           = $value->bill_month;
                    $details[$key]['bill_year']            = $value->bill_year;
                    $details[$key]['payments']             = count($paymentDetails) > 0 ? $paymentDetails : [];
                }
                $studentFeeDetails = $details;
            }
        }

        $data = [
            'session'             => $session,
            'course'              => $course,
            'paymentTypeTitle'    => $paymentTypeTitle,
            'studentInstallments' => $studentInstallments,
            'studentFeeDetails'   => $studentFeeDetails,
            'from_date'           => $request->from_date,
            'to_date'             => $request->to_date,
        ];

        $document = $session . '_' . $course . '_' . $paymentTypeTitle . '_all_student_payment.pdf';
        $pdf      = PDF::loadView('reports.payment.pdf.allStudentPayment', $data, [], ['format' => $pageLayout]);

        return $pdf->stream($document);
    }

    //get student list
    public function studentListReport(Request $request)
    {
        $data = [
            'pageTitle'         => self::moduleName . ' - Student List',
            'sessions'          => $this->sessionService->listByStatus(),
            'courses'           => $this->courseService->listByStatus(),
            'phases'            => $this->phaseService->listByStatus(),
            'studentCategories' => $this->studentCategoryService->listByStatus(),
            'studentStatus'     => UtilityServices::$studentStatus,
        ];
        if (!empty($request->session_id) and !empty($request->course_id)) {
            $data['students'] = $this->studentService->getStudentListWithStatus($request);
        }

        return view(self::moduleDirectory . 'student.index', $data);
    }

    //print student list
    public function studentListPrint(Request $request)
    {
        if (!empty($request->session_id) && !empty($request->course_id)) {
            $data['students']      = $this->studentService->getStudentListWithStatus($request);
            $data['studentStatus'] = UtilityServices::$studentStatus;

            return view(self::moduleDirectory . 'student.studentListPrint', $data);
        }
    }

    public function exportStudentListReport(Request $request)
    {
        if (!empty($request->session_id) && !empty($request->course_id)) {
            $students      = $this->studentService->getStudentListWithStatus($request);
            $studentStatus = UtilityServices::$studentStatus;
            $session       = $this->sessionService->find($request->session_id)->title;
            $course        = $this->courseService->find($request->course_id)->title;

            return Excel::download(
                new StudentListExport($students, $studentStatus, $session, $course),
                'session_' . $session . '_course_' . $course . '_studentList.xlsx',
            );
        }
    }

    //get single student details
    public function studentSingleReport($id)
    {
        $data = [
            'pageTitle'      => 'Student Detail',
            'student'        => $this->studentService->find($id),
            'studentStatus'  => UtilityServices::$studentStatus,
            'educationLevel' => UtilityServices::$certificates,
        ];

        return view(self::moduleDirectory . 'student.studentDetail', $data);
    }

    //single student print
    public function studentSinglePrint($id)
    {
        $data = [
            'pageTitle'      => 'Student Detail',
            'student'        => $this->studentService->find($id),
            'studentStatus'  => UtilityServices::$studentStatus,
            'educationLevel' => UtilityServices::$certificates,
        ];

        return view(self::moduleDirectory . 'student.studentSinglePrint', $data);
    }

    //get teacher list
    public function teacherListReport(Request $request)
    {
        $data = [
            'pageTitle'   => self::moduleName . ' - Teacher List',
            'courses'     => $this->courseService->listByStatus(),
            'departments' => $this->departmentService->listByStatus(),
        ];
        if (!empty($request->course_id) && !empty($request->department_id)) {
            $data['teachers'] = $this->teacherService->getTeacherListWithStatus($request);
        }

        return view(self::moduleDirectory . 'teacher.index', $data);
    }

    //teacher list print
    public function teacherListPrint(Request $request)
    {
        $data = [
            'pageTitle'   => self::moduleName . ' - Teacher List',
            'courses'     => $this->courseService->listByStatus(),
            'departments' => $this->departmentService->listByStatus(),
        ];
        if (!empty($request->course_id) and !empty($request->department_id)) {
            $data['teachers'] = $this->teacherService->getTeacherListWithStatus($request);
        }

        return view(self::moduleDirectory . 'teacher.teacherListPrint', $data);
    }

    //Teacher list PDF
    public function teacherListPdf(Request $request)
    {
        $departments = $this->departmentService->listByStatus();
        $courses     = $this->courseService->listByStatus();
        if (!empty($request->course_id)) {
            $course = $courses[$request->course_id];
        }
        $department = $departments[$request->department_id];
        $data       = [
            'course'     => $course ?? '',
            'department' => $department,
            'teachers'   => $this->teacherService->getTeacherListWithStatus($request),
        ];
        $document   = 'teachers_list_' . $department . '.pdf';
        $pdf        = PDF::loadView('reports.teacher.pdf.teacherListByDepartment', $data);

        return $pdf->stream($document);
    }

    public function teacherListExport(Request $request)
    {
        $departments = $this->departmentService->listByStatus();
        $courses     = $this->courseService->listByStatus();
        if (!empty($request->course_id)) {
            $course = $courses[$request->course_id];
        }
        $department = $departments[$request->department_id];
        $course     = $course ?? '';
        $teachers   = $this->teacherService->getTeacherListWithStatus($request);

        return Excel::download(
            new TeachersListExport($course, $department, $teachers),
            'teachers_list_' . $department . '.xlsx',
        );
    }

    //get teacher student details
    public function teacherSingleReport($id)
    {
        $data = [
            'pageTitle' => 'Teacher Detail',
            'teacher'   => $this->teacherService->find($id),
        ];
        return view(self::moduleDirectory . 'teacher.view', $data);
    }

    //get teacher student details
    public function teacherSinglePrint($id)
    {
        $data = [
            'pageTitle' => 'Teacher Detail',
            'teacher'   => $this->teacherService->find($id),
        ];
        return view(self::moduleDirectory . 'teacher.teacherSinglePrint', $data);
    }

    //all teacher Wise Class report
    public function teacherWiseClass_old(Request $request)
    {
        $data = [
            'pageTitle' => self::moduleName . ' - Teacher Wise Class',
            'sessions'  => $this->sessionService->listByStatus(),
            'subjects'  => $this->subjectService->listByStatus(),
            'courses'   => $this->courseService->listByStatus(),
            'phases'    => $this->phaseService->listByStatus(),
            'terms'     => $this->termService->listByStatus(),
        ];

        $groupId = Auth::user()->user_group_id;
        //$authUser = Auth::user();
        $authUser = Auth::guard('web')->user();

        if ($groupId == 11 || $groupId == 4) {
            $data['nossainClass']     = [];
            $data['teacherWiseClass'] = $this->teacherService->getTotalTeacherWiseClass(
                $authUser->teacher->id,
                $request->session_id,
                $request->phase_id,
                $request->term_id,
                $request->subject_id,
                $request->from_date,
                $request->to_date,
            );
        } else {
            $data['nossainClass']     = $this->teacherService->getNossainClass();
            $data['teacherWiseClass'] = $this->teacherService->getTotalTeacherWiseClass(
                '',
                $request->session_id,
                $request->phase_id,
                $request->term_id,
                $request->subject_id,
                $request->from_date,
                $request->to_date,
            );
        }
        return view(self::moduleDirectory . 'teacher.teacherWiseClass', $data);
    }

    //all teacher Wise Class report
    public function teacherWiseClass(Request $request)
    {
        $data = [
            'pageTitle'  => self::moduleName . ' - Teacher Wise Class',
            'sessions'   => $this->sessionService->listByStatus(),
            'subjects'   => $this->subjectService->listByStatus(),
            'courses'    => $this->courseService->listByStatus(),
            'phases'     => $this->phaseService->listByStatus(),
            'terms'      => $this->termService->listByStatus(),
            'classTypes' => $this->classTypeService->listByStatus(),
        ];

        $groupId  = Auth::user()->user_group_id;
        $authUser = Auth::guard('web')->user();

        $from_date = !empty($request->from_date) ? $request->from_date : '';
        if (!empty($from_date)) {
            $fromDate = Carbon::createFromFormat('d/m/Y', $from_date)->format('Y-m-d');
        } else {
            $fromDate = '';
        }

        $to_date = !empty($request->to_date) ? $request->to_date : null;
        if (!empty($to_date)) {
            $toDate = Carbon::createFromFormat('d/m/Y', $to_date)->format('Y-m-d');
        } else {
            $toDate = '';
        }

        if ($groupId == 11 || $groupId == 4) {
            $data['teacherWiseClass'] = $this->teacherService->getTotalTeacherWiseClass(
                $authUser->teacher->id,
                $request->session_id,
                $request->phase_id,
                $request->term_id,
                $request->subject_id,
                $fromDate,
                $toDate,
                $request->course_id,
                $request->class_type_id,
            );
        } else {
            $data['teacherWiseClass'] = $this->teacherService->getTotalTeacherWiseClass(
                false,
                $request->session_id,
                $request->phase_id,
                $request->term_id,
                $request->subject_id,
                $fromDate,
                $toDate,
                $request->course_id,
                $request->class_type_id,
            );
        }

        return view(self::moduleDirectory . 'teacher.teacherWiseClass', $data);
    }

    public function exportTeacherWiseClassReport(Request $request)
    {
        $groupId  = Auth::user()->user_group_id;
        $authUser = Auth::guard('web')->user();

        $from_date = !empty($request->from_date) ? $request->from_date : '';
        if (!empty($from_date)) {
            $fromDate = Carbon::createFromFormat('d/m/Y', $from_date)->format('Y-m-d');
        } else {
            $fromDate = '';
        }

        $to_date = !empty($request->to_date) ? $request->to_date : null;
        if (!empty($to_date)) {
            $toDate = Carbon::createFromFormat('d/m/Y', $to_date)->format('Y-m-d');
        } else {
            $toDate = '';
        }

        if ($groupId == 11 || $groupId == 4) {
            $teacherWiseClass = $this->teacherService->getTotalTeacherWiseClass(
                $authUser->teacher->id,
                $request->session_id,
                $request->phase_id,
                $request->term_id,
                $request->subject_id,
                $fromDate,
                $toDate,
                $request->course_id,
                $request->class_type_id,
            );
        } else {
            $teacherWiseClass = $this->teacherService->getTotalTeacherWiseClass(
                false,
                $request->session_id,
                $request->phase_id,
                $request->term_id,
                $request->subject_id,
                $fromDate,
                $toDate,
                $request->course_id,
                $request->class_type_id,
            );
        }

        $subject = !empty($request->subject_id) ? $request->subject_id : 'all';
        if (!empty($request->session_id)) {
            $session = $this->sessionService->find($request->session_id)->title;
        } else {
            $session = "All Session";
        }

        return Excel::download(
            new AllTeacherWiseClassExport($teacherWiseClass, $session, $subject),
            'session_' . $session . '_subject_' . $subject . '_totalclass.xlsx',
        );
    }

    //get parent list
    public function parentListReport(Request $request)
    {
        $data = [
            'pageTitle'         => self::moduleName . ' - Parent List',
            'sessions'          => $this->sessionService->listByStatus(),
            'courses'           => $this->courseService->listByStatus(),
            'phases'            => $this->phaseService->listByStatus(),
            'studentCategories' => $this->studentCategoryService->listByStatus(),
            'studentStatus'     => UtilityServices::$studentStatus,
        ];
        if (!empty($request->session_id) and !empty($request->course_id)) {
            $data['parents'] = $this->guardianService->getParentList($request);
        }

        return view(self::moduleDirectory . 'parent.index', $data);
    }

    //print parent list
    public function parentListPdf(Request $request)
    {
        $session    = $this->sessionService->find($request->session_id)->title ?? '';
        $course     = $this->courseService->find($request->course_id)->title ?? '';
        $pageLayout = $request->page_layout ?? 'A4-landscape';

        if (!empty($request->session_id) and !empty($request->course_id)) {
            $data['parents'] = $this->guardianService->getParentList($request);
        }
        $document = 'parents_list_' . $session . '_' . $course . '.pdf';
        return PDF::loadView('reports.parent.pdf.parentList', $data, [], ['format' => $pageLayout])->stream($document);
    }

    //Parent list report in excel
    public function exportParentReport(Request $request)
    {
        if (!empty($request->session_id) and !empty($request->course_id)) {
            $session = $this->sessionService->find($request->session_id)->title;
            $course  = $this->courseService->find($request->course_id)->title;
            $parents = $this->guardianService->getParentList($request);
        }

        return Excel::download(
            new parentList($parents, $session, $course),
            'session_' . $session . '_course_' . $course . '_parentList.xlsx',
        );
    }

    public function SMSEmailReport(Request $request)
    {
        $userArray = $this->smsService->getAllSender();
        $data      = [
            'pageTitle'      => self::moduleName . ' - SMS Email',
            'users'          => $userArray,
            'tableHeads'     => [
                'Sl.',
                'Receiver',
                'Type & Purpose',
                'Message',
                'Email',
                'Phone',
                'Response',
                'Sender',
                'Send At',
            ],
            'dataUrl'        => 'admin/sms_email_history/get-data',
            'columns'        => [
                ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
                ['data' => 'user_id', 'name' => 'user_id'],
                ['data' => 'type_purpose', 'name' => 'type_purpose'],
                ['data' => 'message', 'name' => 'message'],
                ['data' => 'email', 'name' => 'email'],
                ['data' => 'phone', 'name' => 'phone'],
                ['data' => 'response', 'name' => 'response'],
                ['data' => 'created_by', 'name' => 'created_by'],
                ['data' => 'created_at', 'name' => 'created_at'],
            ],
            'purposeOptions' => UtilityServices::$smsEmailPurposes,
        ];
        return view(self::moduleDirectory . 'sms_email.index', $data);
    }

    public function getData(Request $request)
    {
        return $this->smsService->getDataTable($request);
    }

    public function campaignReport(Request $request)
    {
        $senderArray       = $this->campaignService->getAllSender();
        $receiverTypeArray = $this->campaignService->getAllReceiverType();
        $campaignPurposes  = $this->campaignService->getPurposes();
        $data              = [
            'pageTitle'      => self::moduleName . ' - Campaign',
            'senders'        => $senderArray,
            'receiverTypes'  => $receiverTypeArray,
            'purposeOptions' => $campaignPurposes,
            'tableHeads'     => [
                'Sl.',
                'Type',
                'Purpose',
                'Receiver',
                'Message',
                'Email',
                'Mobile',
                'Status',
                'Response',
                'Sender',
                'Send At',
            ],
            'dataUrl'        => 'admin/campaign_logs/get-data',
            'columns'        => [
                ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
                ['data' => 'campaign_type', 'name' => 'campaign_type'],
                ['data' => 'purpose', 'name' => 'purpose'],
                ['data' => 'receiver', 'name' => 'receiver'],
                ['data' => 'message', 'name' => 'message'],
                ['data' => 'email', 'name' => 'email'],
                ['data' => 'mobile_number', 'name' => 'mobile_number'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'response', 'name' => 'response'],
                ['data' => 'created_by', 'name' => 'created_by'],
                ['data' => 'created_at', 'name' => 'created_at'],
            ],
        ];

        return view(self::moduleDirectory . 'campaign.index', $data);
    }

    public function campaignGetData(Request $request)
    {
        return $this->campaignService->getDataTable($request);
    }

    public function dueBySession(Request $request)
    {
        $data      = [
            'pageTitle' => self::moduleName . ' - Students due by session',
            'sessions'  => $this->sessionService->listByStatus(),
            'courses'   => $this->courseService->listByStatus(),
        ];
        $sessionId = $request->input('session_id');
        $courseId  = $request->input('course_id') ?: (Auth::user()->adminUser->course_id ?? null) ?: (Auth::user()->teacher->course_id ?? null);

        if ($request->filled('session_id')) {
            $students = $this->studentService->getStudentsBySessionCourseWith($sessionId, $courseId, ['user', 'fee']);

            $data['studentsDue'] = $students->map(function ($student) {
                $fees = $student->fee->whereNull('deleted_at');

                $totalPayable  = $fees->sum('payable_amount');
                $totalPaid     = $fees->sum('paid_amount');
                $totalDue      = $fees->sum('due_amount');
                $totalDiscount = $fees->sum('discount_amount');

                if ($totalPayable > 0 || $totalPaid > 0 || $totalDue > 0) {
                    return [
                        'student_id'     => $student->user->user_id ?? '',
                        'full_name'      => $student->full_name_en,
                        'currency'       => $student->student_category_id == 2 ? '$' : '৳',
                        'total_payable'  => $totalPayable,
                        'total_paid'     => $totalPaid,
                        'total_due'      => $totalDue,
                        'total_discount' => $totalDiscount,
                    ];
                }
            })->filter()->values()->toArray();
        }

        return view(self::moduleDirectory . 'due.due_by_session', $data);
    }

    public function dueBySessionPdf(Request $request)
    {
        $sessionId = $request->input('session_id');
        $courseId  = $request->input('course_id') ?: (Auth::user()->adminUser->course_id ?? null) ?: (Auth::user()->teacher->course_id ?? null);

        $sessionInfo = $this->sessionService->find($sessionId);
        $courseInfo  = $this->courseService->find($courseId);
        $pageLayout  = $request->page_layout ?? 'A4-landscape';

        $data = [
            'sessionInfo' => $sessionInfo,
            'courseInfo'  => $courseInfo,
        ];

        if ($request->filled('session_id')) {
            $students = $this->studentService->getStudentsBySessionCourseWith($sessionId, $courseId, ['user', 'fee']);

            $data['studentsDue'] = $students->map(function ($student) {
                $totalPayable  = $student->fee->sum('payable_amount');
                $totalPaid     = $student->fee->sum('paid_amount');
                $totalDue      = $student->fee->sum('due_amount');
                $totalDiscount = $student->fee->sum('discount_amount');

                if ($totalPayable > 0 || $totalPaid > 0 || $totalDue > 0) {
                    return [
                        'student_id'     => $student->user->user_id ?? '',
                        'full_name'      => $student->full_name_en,
                        'currency'       => $student->student_category_id == 2 ? 'USD' : 'BDT',
                        'total_payable'  => $totalPayable,
                        'total_paid'     => $totalPaid,
                        'total_due'      => $totalDue,
                        'total_discount' => $totalDiscount,
                    ];
                }
            })->filter()->values()->toArray();
        }

        $document = 'Students Due by Session_' . $sessionInfo->title . ($courseInfo !== null ? '_Course_' . $courseInfo->title : '') . '.pdf';

        return PDF::loadView('reports.due.pdf.due_by_session', $data, [], ['format' => $pageLayout])->stream($document);
    }

    public function dueBySessionExcel(Request $request)
    {
        $sessionId = $request->input('session_id');
        $courseId  = $request->input('course_id') ?: (Auth::user()->adminUser->course_id ?? null) ?: (Auth::user()->teacher->course_id ?? null);

        $sessionInfo = $this->sessionService->find($sessionId);
        $courseInfo  = $this->courseService->find($courseId);

        if ($request->filled('session_id')) {
            $students = $this->studentService->getStudentsBySessionCourseWith($sessionId, $courseId, ['user', 'fee']);

            $studentsDue = $students->map(function ($student) {
                $totalPayable  = $student->fee->sum('payable_amount');
                $totalPaid     = $student->fee->sum('paid_amount');
                $totalDue      = $student->fee->sum('due_amount');
                $totalDiscount = $student->fee->sum('discount_amount');

                if ($totalPayable > 0 || $totalPaid > 0 || $totalDue > 0) {
                    return [
                        'student_id'     => $student->user->user_id ?? '',
                        'full_name'      => $student->full_name_en,
                        'currency'       => $student->student_category_id == 2 ? 'USD' : 'BDT',
                        'total_payable'  => $totalPayable,
                        'total_paid'     => $totalPaid,
                        'total_due'      => $totalDue,
                        'total_discount' => $totalDiscount,
                    ];
                }
            })->filter()->values()->toArray();
        }

        return Excel::download(
            new DueBySessionExport($sessionInfo, $courseInfo, $studentsDue),
            'students_due_by_session_' . $sessionInfo->title . ($courseInfo !== null ? '_course_' . $courseInfo->title : '') . '.xlsx',
        );
    }

    // Comparative Attendance Report
    public function comparativeAttendanceReport(Request $request)
    {
        $data = [
            'pageTitle'         => self::moduleName . ' - Comparative Attendance',
            'sessions'          => $this->sessionService->listByStatus(),
            'courses'           => $this->courseService->listByStatus(),
            'phases'            => $this->phaseService->listByStatus(),
            'studentCategories' => $this->studentCategoryService->listByStatus(),
            'percentage_filter' => $request->percentage_filter,
            'percentage_type'   => $request->percentage_type,
        ];

        $reportData = [];
        if ($request->has(['session_id', 'course_id', 'phase_id', 'subject_id', 'start_date', 'end_date'])) {
            $reportData = $this->attendanceService->getComparativeAttendanceReport($request);
        }

        $data['reportData'] = $reportData;

        return view(self::moduleDirectory . 'attendance.comparativeAttendance', $data);
    }

    public function comparativeAttendanceReportPdf(Request $request)
    {
        $session    = $this->sessionService->find($request->session_id);
        $phase      = $this->phaseService->find($request->phase_id);
        $reportData = $this->attendanceService->getComparativeAttendanceReport($request);
        $subject    = $this->subjectService->find($request->subject_id);
        $pageLayout = $request->page_layout ?? 'A4-landscape';
        $data       = [
            'reportData'        => $reportData,
            'session'           => $session,
            'phase'             => $phase,
            'start_date'        => $request->start_date,
            'end_date'          => $request->end_date,
            'subject'           => $subject,
            'percentage_filter' => $request->percentage_filter,
            'percentage_type'   => $request->percentage_type,
        ];

        $document = 'comparative_attendance_report_of_' . $subject->title . '.pdf';
        $pdf      = PDF::loadView('reports.attendance.pdf.comparativeAttendance', $data, [], ['format' => $pageLayout]);

        return $pdf->stream($document);
    }

    public function comparativeAttendanceReportExcel(Request $request)
    {
        $reportData = $this->attendanceService->getComparativeAttendanceReport($request);
        $session    = $this->sessionService->find($request->session_id);
        $phase      = $this->phaseService->find($request->phase_id);
        $subject    = $this->subjectService->find($request->subject_id);

        return Excel::download(
            new ComparativeAttendanceExport(
                $reportData,
                $session,
                $phase,
                $request->start_date,
                $request->end_date,
                $subject,
                $request->percentage_filter,
                $request->percentage_type,
            ),
            'comparative_attendance_report_of_' . $subject->title . '.xlsx',
        );
    }
}
