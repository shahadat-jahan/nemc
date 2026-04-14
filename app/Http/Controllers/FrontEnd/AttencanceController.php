<?php

namespace App\Http\Controllers\FrontEnd;

use App\Attencance;
use App\Http\Controllers\Controller;
use App\Services\Admin\Admission\ClassRoutineService;
use App\Services\Admin\AttendanceService;
use App\Services\Admin\CourseService;
use App\Services\Admin\PhaseService;
use App\Services\Admin\SessionService;
use App\Services\Admin\StudentService;
use Illuminate\Http\Request;

class AttencanceController extends Controller
{
    /**
     *
     */
    const moduleName = 'Attendance';
    /**
     *
     */
    const redirectUrl = 'nemc/attendance';
    /**
     *
     */
    const moduleDirectory = 'frontend.attendance.';

    protected $service;
    protected $classRoutineService;
    protected $studentService;
    protected $sessionService;
    protected $courseService;
    protected $phaseService;


    public function __construct(
        AttendanceService $service, ClassRoutineService $classRoutineService, StudentService $studentService, SessionService $sessionService,
        CourseService $courseService, PhaseService $phaseService

    )
    {
        $this->service = $service;
        $this->classRoutineService = $classRoutineService;
        $this->studentService = $studentService;
        $this->sessionService = $sessionService;
        $this->courseService = $courseService;
        $this->phaseService = $phaseService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'pageTitle' => 'Student\'s Attendance',
            'tableHeads' => ['Student', 'Subject', 'Topic', 'Class Type', 'Teacher', 'Attendance', 'Class Date', 'Attendance Date', 'Action'],
            'dataUrl' => self::redirectUrl . '/get-data',
            'columns' => [
                ['data' => 'student_id', 'name' => 'student_id'],
                ['data' => 'subject_id', 'name' => 'subject_id'],
                ['data' => 'subject_topic', 'name' => 'subject_topic'],
                ['data' => 'class_type', 'name' => 'class_type'],
                ['data' => 'class_teacher', 'name' => 'class_teacher'],
                ['data' => 'attendance', 'name' => 'attendance'],
                ['data' => 'class_date', 'name' => 'class_date'],
                ['data' => 'created_at', 'name' => 'created_at'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
            'sessions' => $this->sessionService->listByStatus(),
            'courses' => $this->courseService->lists(),
            'phases' => $this->phaseService->lists(),
        ];

        return view(self::moduleDirectory . 'index', $data);
    }

    public function getData(Request $request)
    {
        return $this->service->getDataTable($request);
    }

    public function getAttendanceByRoutineId(Request $request, $id)
    {
        return $this->service->getAttendanceListByRoutineId($request, $id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
}
