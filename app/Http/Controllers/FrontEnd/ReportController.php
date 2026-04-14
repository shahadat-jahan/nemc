<?php

namespace App\Http\Controllers\FrontEnd;

use App\Exports\AttendanceByPhaseExport;
use App\Exports\AttendanceByStudentExport;
use App\Exports\StudentPaymentsExport;
use App\Http\Controllers\Controller;
use App\Services\Admin\Admission\AdmissionService;
use App\Services\Admin\Admission\ClassRoutineService;
use App\Services\Admin\AttendanceService;
use App\Services\Admin\ClassTypeService;
use App\Services\Admin\CourseService;
use App\Services\Admin\DepartmentService;
use App\Services\Admin\PhaseService;
use App\Services\Admin\SessionService;
use App\Services\Admin\StudentCategoryService;
use App\Services\Admin\StudentService;
use App\Services\Admin\SubjectService;
use App\Services\Admin\TermService;
use App\Services\StudentFeeService;
use App\Services\UtilityServices;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
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
    const moduleDirectory = 'frontend/reports.';

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
    protected $classTypeService;

    public function __construct(
        AdmissionService  $admissionService, SessionService $sessionService, CourseService $courseService, StudentCategoryService $studentCategoryService,
        PhaseService      $phaseService, TermService $termService, SubjectService $subjectService, AttendanceService $attendanceService, ClassRoutineService $classRoutineService,
        DepartmentService $departmentService, StudentFeeService $studentFeeService, StudentService $studentService, ClassTypeService $classTypeService
    )
    {
        $this->admissionService = $admissionService;
        $this->sessionService = $sessionService;
        $this->courseService = $courseService;
        $this->studentCategoryService = $studentCategoryService;
        $this->phaseService = $phaseService;
        $this->termService = $termService;
        $this->subjectService = $subjectService;
        $this->attendanceService = $attendanceService;
        $this->classRoutineService = $classRoutineService;
        $this->departmentService = $departmentService;
        $this->studentFeeService = $studentFeeService;
        $this->studentService = $studentService;
        $this->classTypeService = $classTypeService;
    }

    //attendance report by student
    public function attendanceByStudentReport(Request $request)
    {
        $data = [
            'pageTitle'      => self::moduleName . ' - Attendance By Student',
            'sessions'       => $this->sessionService->listByStatus(),
            'courses'        => $this->courseService->listByStatus(),
            'phases'         => $this->phaseService->listByStatus(),
            'classTypes'     => $this->classTypeService->listByStatus(),
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

        return PDF::loadView('frontend.reports.attendance.pdf.attendanceByStudent', $data)->stream($document);
    }

    public function studentPaymentReport(Request $request)
    {

        $data = [
            'pageTitle' => self::moduleName . ' - Student Payment',
            'sessions' => $this->sessionService->listByStatus(),
            'courses' => $this->courseService->listByStatus(),
            'studentInstallments' => new Collection(),
            'studentPayments' => new Collection(),
        ];

        if ($request->has(['session_id', 'course_id', 'student_id', 'from_date'])) {
            $data['studentInstallments'] = $this->studentFeeService->getStudentInstallmentDetailsByStudentIdAndDate($request->student_id, $request->from_date, $request->to_date);
            $data['studentPayments'] = $this->studentFeeService->getStudentPaymentDetailsByStudentIdAndDate($request->student_id, $request->from_date, $request->to_date);
        }
        return view(self::moduleDirectory . 'payment.studentPayment', $data);
    }

    public function exportStudentPaymentReport(Request $request)
    {

        if ($request->has(['session_id', 'course_id', 'student_id', 'from_date'])) {

            $studentInstallments = $this->studentFeeService->getStudentInstallmentDetailsByStudentIdAndDate($request->student_id, $request->from_date, $request->to_date);
            $studentPayments = $this->studentFeeService->getStudentPaymentDetailsByStudentIdAndDate($request->student_id, $request->from_date, $request->to_date);
            $student = $this->studentService->find($request->student_id);
            $fromDate = $request->from_date;
            $toDate = $request->to_date;
        }

        return Excel::download(new StudentPaymentsExport($studentInstallments, $studentPayments, $student, $fromDate, $toDate), $student->full_name_en . '_payments.xlsx');
    }

}
