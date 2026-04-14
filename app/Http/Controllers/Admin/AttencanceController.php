<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ClassAbsentJob;
use App\Jobs\LowAttendanceNotifyJob;
use App\Models\Attencance;
use App\Models\ClassRoutine;
use App\Services\Admin\Admission\ClassRoutineService;
use App\Services\Admin\AttendanceService;
use App\Services\Admin\BatchTypeService;
use App\Services\Admin\ClassTypeService;
use App\Services\Admin\CourseService;
use App\Services\Admin\PhaseService;
use App\Services\Admin\SessionService;
use App\Services\Admin\StudentService;
use App\Services\Admin\SubjectService;
use App\Services\Admin\TermService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDF;

/**
 *
 */
class AttencanceController extends Controller
{
    /**
     *
     */
    const moduleName = 'Attendance';
    /**
     *
     */
    const redirectUrl = 'admin/attendance';
    /**
     *
     */
    const moduleDirectory = 'attendance.';

    protected $service;
    protected $classRoutineService;
    protected $studentService;
    protected $sessionService;
    protected $courseService;
    protected $phaseService;
    protected $classTypeService;
    protected $termService;
    protected $subjectService;
    protected $batchTypeService;

    public function __construct(
        AttendanceService   $service,
        ClassRoutineService $classRoutineService,
        StudentService      $studentService,
        SessionService      $sessionService,
        CourseService       $courseService,
        PhaseService        $phaseService,
        ClassTypeService    $classTypeService,
        TermService         $termService,
        SubjectService      $subjectService,
        BatchTypeService    $batchTypeService

    ) {
        $this->service             = $service;
        $this->classRoutineService = $classRoutineService;
        $this->studentService      = $studentService;
        $this->sessionService      = $sessionService;
        $this->courseService       = $courseService;
        $this->phaseService        = $phaseService;
        $this->classTypeService    = $classTypeService;
        $this->termService         = $termService;
        $this->subjectService      = $subjectService;
        $this->batchTypeService      = $batchTypeService;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data = [
            'pageTitle'  => 'Student\'s Attendance',
            'tableHeads' => [
                'Roll No.',
                'Student',
                'Subject',
                'Topic',
                'Class Type',
                'Teacher',
                'Attendance',
                'Class Date',
                'Attendance Date',
                'Action'
            ],
            'dataUrl'    => self::redirectUrl . '/get-data',
            'columns'    => [
                ['data' => 'student_roll', 'name' => 'student_roll'],
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
            'sessions'   => $this->sessionService->listByStatus(),
            'courses'    => $this->courseService->lists(),
            'phases'     => $this->phaseService->lists(),
            'terms'      => $this->termService->lists(),
            'classTypes' => $this->classTypeService->lists(),
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
     * @return Response
     */
    public function create(Request $request)
    {
        $routine     = $this->classRoutineService->find($request->class_id);
        $user        = Auth::guard('web')->user();
        $students    = $this->studentService->getStudents($routine, $user);
        $oldStudents = $this->studentService->getOldStudents($routine, $user);

        $data = [
            'pageTitle'    => self::moduleName,
            'classRoutine' => $routine,
            'students'     => $students,
            'oldStudents'  => $oldStudents,
            'courseName'   => $routine->course->title,
            'mode'         => 'routine',
        ];

        //        if ($routine->class_type_id != 1 and $routine->class_type_id != 9) {
        //            $data['students'] = $this->service->checkStudentExistOfStudentGroupByRoutineId($request->class_id);
        //        }
        return view(self::moduleDirectory . 'add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $routine     = $this->classRoutineService->find($request->class_routine_id);
        $user        = Auth::guard('web')->user();
        $students    = $this->studentService->getStudents($routine, $user);
        $oldStudents = $this->studentService->getOldStudents($routine, $user);

        if (!empty($students) || !empty($oldStudents)) {
            $attendance = $this->service->addAttendance($request, $students, $oldStudents, $routine);
            if ($attendance) {
                $request->session()->flash('success', setMessage('create', self::moduleName));
            } else {
                $request->session()->flash('error', setMessage('create.error', self::moduleName));
            }
        } else {
            $request->session()->flash('error', 'This class does not have any students');
        }

        $redirectRoute = $request->mode == 'routine' ?
            route('class_routine.info.single', [$request->class_routine_id, 'mode' => $request->mode]) :
            route('attendance.index');

        return redirect()->to($redirectRoute);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Attencance $attencance
     *
     * @return Response
     */
    public function show(Attencance $attencance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Attencance $attencance
     *
     * @return Response
     */
    public function edit(Attencance $attencance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request         $request
     * @param \App\Attencance $attencance
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $attendance             = $this->service->find($id);
        $attendance->attendance = $request->attendance;
        $attendance->save();

        return response()->json(['status' => true, 'data' => $attendance]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Attencance $attencance
     *
     * @return Response
     */
    public function destroy(Attencance $attencance)
    {
        //
    }

    public function queueSMSDetails(Request $request)
    {
        $routine        = $this->classRoutineService->find($request->classRoutineId);
        $attendanceData = Attencance::where('id', $request->attendanceId)->first();
        $student        = $this->studentService->getParentByStudentId($attendanceData->student_id);
        $message        = sprintf(
            "Dear Parents, One of our students, named <b>%s</b>, was recently found absent in a scheduled class of <b>%s</b> (%s), dated <b>%s</b>.<br><br>If you are unaware of this absence, please contact the office at +8802996635181.",
            $student->full_name_en,
            $routine->subject->title,
            $routine->classType->title ?? '',
            Carbon::parse($routine->class_date)->format('F j, Y')
        );

        return response()->json($message);
    }

    public function queueSMS(Request $request)
    {
        $routine        = $this->classRoutineService->find($request->classRoutineId);
        $attendanceData = Attencance::where('id', $request->attendanceId)->first();
        $student        = $this->studentService->getParentByStudentId($attendanceData->student_id);
        $message = sprintf(
            "Dear Parents, One of our students, named %s, was recently found absent in a scheduled class of %s (%s), dated %s.\n\nIf you are unaware of this absence, please contact the office at +8802996635181.",
            $student->full_name_en,
            $routine->subject->title,
            $routine->classType->title ?? '',
            Carbon::parse($routine->class_date)->format('F j, Y')
        );

        $queuedData = DB::table('sms_email_log')->insertGetId(
            array(
                'attendance_id'    => $request->attendanceId,
                'class_routine_id' => $request->classRoutineId,
                'student_id'       => $student->id,
                'message'          => $message,
                'class_date'       => $routine->class_date,
                'subject'          => $routine->subject->title,
                'status'           => 0,
                'created_by'       => Auth::user()->id,
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now(),
            )
        );
        $getData    = DB::table('sms_email_log')->where('id', $queuedData)->first();
        ClassAbsentJob::dispatch($getData);
        return response()->json($student->parent->father_phone);
    }

    public function queueBulkSMS(Request $request)
    {
        foreach ($request->data as $data) {
            $routine        = $this->classRoutineService->find($data['classRoutineId']);
            $attendanceData = Attencance::where('id', $data['attendanceId'])->first();
            $student        = $this->studentService->getParentByStudentId($attendanceData->student_id);
            $message = sprintf(
                'Dear Parents, One of our students, named %s, was recently found absent in a scheduled class of %s (%s), dated %s.\n\nIf you are unaware of this absence, please contact the office at +8802996635181.',
                $student->full_name_en,
                $routine->subject->title,
                $routine->classType->title ?? '',
                Carbon::parse($routine->class_date)->format('F j, Y')
            );

            $queuedData = DB::table('sms_email_log')->insertGetId(
                array(
                    'attendance_id'    => $data['attendanceId'],
                    'class_routine_id' => $data['classRoutineId'],
                    'student_id'       => $student->id,
                    'message'          => $message,
                    'class_date'       => $routine->class_date,
                    'subject'          => $routine->subject->title,
                    'status'           => 0,
                    'created_by'       => Auth::user()->id,
                    'created_at'       => Carbon::now(),
                    'updated_at'       => Carbon::now(),
                )
            );
            $getData    = DB::table('sms_email_log')->where('id', $queuedData)->first();
            ClassAbsentJob::dispatch($getData);
        }
        return response()->json($request);
    }

    public function sendNotificationsToParents(Request $request)
    {
        try {
            $subjectId        = $request->input('subject_id');
            $percentageType   = $request->input('percentage_type', 'average');
            $percentageFilter = $request->input('percentage_filter', 75);
            $selectedStudents = $request->input('selected_students', []);
            $period           = fullDateFormat($request->input('start_date')) . ' to ' . fullDateFormat($request->input('end_date'));

            if (empty($selectedStudents)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No students selected for notification'
                ]);
            }

            $subject = $this->subjectService->find($subjectId);
            if (!$subject) {
                return response()->json([
                    'success' => false,
                    'message' => 'Subject not found'
                ]);
            }

            $emailCount = 0;
            $smsCount   = 0;
            $errors     = [];

            foreach ($selectedStudents as $studentData) {
                $student = $this->studentService->find($studentData['id']);
                if (!$student) {
                    $errors[] = "Student not found: ID {$studentData['id']}";
                    continue;
                }

                $message = "Dear Guardian,\n" .
                    "This is to inform you that one of our students, {$student->full_name_en}, Class Roll: {$student->roll_no}, has recently had less than {$percentageFilter}% attendance in this {$period} {$percentageType} class on {$subject->title}.\n\n" .
                    "In this situation, you, as the legal guardian of the student, are hereby informed and requested to kindly contact the Head of the Concerned Department {$subject->department->title} or the honorable College Principal immediately regarding this matter.\n\n" .
                    "Thank you for your attention and cooperation";

                // Count and dispatch
                if ($student->student_category_id == 2 && $student->parent->father_email) {
                    $emailCount++;
                } elseif ($student->student_category_id != 2 && $student->parent->father_phone) {
                    $smsCount++;
                }

                LowAttendanceNotifyJob::dispatch(
                    $student->id,
                    $subject->title,
                    $message,
                    $percentageType,
                    $percentageFilter,
                    $period,
                    Auth::id()
                );
            }

            $message = "Successfully sent {$emailCount} emails to foreign students' parents and {$smsCount} SMS for local students' parents.";

            return response()->json([
                'success' => true,
                'message' => $message,
                'errors'  => $errors
            ]);
        } catch (Exception $e) {
            Log::error('Attendance notification error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error sending notifications: ' . $e->getMessage()
            ], 500);
        }
    }

    public function pdf($classRoutineId)
    {
        $classRoutine = $this->classRoutineService->find($classRoutineId);
        $totalPresent = $classRoutine->attendances()
                         ->where('attendance', 1)
                         ->count();
        $totalAbsent = $classRoutine->attendances()
                        ->where('attendance', 0)
                        ->count();
        $session      = $classRoutine->session->title ?? 'N/A';
        $course       = $classRoutine->course->title ?? 'N/A';
        $phase        = $classRoutine->phase->title ?? 'N/A';
        $batch        = $classRoutine->batchType->title ?? 'All';
        $department   = $classRoutine->subject->department->title ?? 'N/A';
        $classType    = $classRoutine->classType->title ?? 'N/A';
        $teacherName  = $classRoutine->teacher->full_name ?? 'N/A';
        $topicInfo       = $classRoutine->topic;
        $attendanceData = $this->service->getAttendanceDataByRoutineId($classRoutineId);

        $data = [
            'classRoutine'   => $classRoutine,
            'totalPresent'   => $totalPresent,
            'totalAbsent'   => $totalAbsent,
            'session'        => $session,
            'course'         => $course,
            'phase'          => $phase,
            'batch'          => $batch,
            'department'     => $department,
            'classType'      => $classType,
            'teacherName'    => $teacherName,
            'topicInfo'      => $topicInfo,
            'attendanceData' => $attendanceData,
        ];

        $document =  'class_attendance_'.$classRoutineId.'.pdf';

        return PDF::loadView('class_routine.pdf.class_attendance', $data)
                  ->stream($document);
    }
}
