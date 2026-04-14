<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClassRoutineSetup;
use App\Models\StudentGroup;
use App\Services\Admin\Admission\ClassRoutineService;
use App\Services\Admin\Admission\StudentGroupService;
use App\Services\Admin\AttendanceService;
use App\Services\Admin\BatchTypeService;
use App\Services\Admin\ClassTypeService;
use App\Services\Admin\CourseService;
use App\Services\Admin\HallService;
use App\Services\Admin\HolidayService;
use App\Services\Admin\PhaseService;
use App\Services\Admin\SessionService;
use App\Services\Admin\TeacherService;
use App\Services\Admin\TermService;
use App\Services\UtilityServices;
use Illuminate\Http\Request;
use PDF;

class ClassRoutineController extends Controller
{
    /**
     *
     */
    const moduleName = 'Class Routine';
    /**
     *
     */
    const redirectUrl = 'nemc/class_routine';
    /**
     *
     */
    const moduleDirectory = 'frontend.class_routine.';

    protected $service;
    protected $sessionService;
    protected $courseService;
    protected $classTypeService;
    protected $batchTypeService;
    protected $phaseService;
    protected $hallService;
    protected $attendanceService;
    protected $studentGroupService;
    protected $teacherService;
    protected $termService;
    protected $holidayService;

    public function __construct(
        ClassRoutineService $service, SessionService $sessionService, CourseService $courseService, ClassTypeService $classTypeService,
        BatchTypeService $batchTypeService, PhaseService $phaseService, HallService $hallService, AttendanceService $attendanceService,
        StudentGroupService $studentGroupService, TeacherService $teacherService,
        TermService $termService, HolidayService $holidayService
    )
    {
        $this->service = $service;
        $this->sessionService = $sessionService;
        $this->courseService = $courseService;
        $this->classTypeService = $classTypeService;
        $this->batchTypeService = $batchTypeService;
        $this->phaseService = $phaseService;
        $this->hallService = $hallService;
        $this->attendanceService = $attendanceService;
        $this->studentGroupService = $studentGroupService;
        $this->termService = $termService;
        $this->teacherService = $teacherService;
        $this->holidayService = $holidayService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'pageTitle' => self::moduleName,
            'tableHeads' => ['Subject', 'Class Type','Teacher', 'Session', 'Day', 'Time',  'Status', 'Action'],
            'dataUrl' => self::redirectUrl . '/get-data',
            'columns' => [
                ['data' => 'subject_id', 'name' => 'subject_id'],
                ['data' => 'class_type_id', 'name' => 'class_type_id'],
                ['data' => 'teacher_id', 'name' => 'teacher_id'],
                ['data' => 'session_id', 'name' => 'session_id'],
                ['data' => 'class_date', 'name' => 'class_date'],
                ['data' => 'class_time', 'name' => 'class_time'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
            'sessions' => $this->sessionService->listByStatus(),
            'courses' => $this->courseService->lists(),
            'phases' => $this->phaseService->lists(),
            'years' => UtilityServices::getYears(),
        ];

        return view(self::moduleDirectory . 'index', $data);
    }

    public function getData(Request $request){
        return $this->service->getDatatable($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'pageTitle' => self::moduleName,
            'sessions' => $this->sessionService->listByStatus(),
            'courses' => $this->courseService->lists(),
            'classTypes' => $this->classTypeService->listByStatus(),
            'batchTypes' => $this->batchTypeService->listByStatus(),
            'classRooms' => $this->hallService->listByStatus(),
            'classDays' => UtilityServices::$ClassDays,
            'studentGroups' => $this->studentGroupService->getData(),
        ];

        return view(self::moduleDirectory . 'create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $classRoutine = $this->service->addClassRoutine($request);

        if ($classRoutine){
            $request->session()->flash('success', setMessage('create', self::moduleName));
            return redirect()->route('class_routine.index');
        }
        $request->session()->flash('error', setMessage('create.error', self::moduleName));
        return redirect()->route('class_routine.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ClassRoutine $classRoutine
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $classRoutine = $this->service->find($id);
        $data = [
            'pageTitle' => self::moduleName,
            'classRoutine' =>  $classRoutine,
            'min_max_date' => $this->service->getMinMaxDateBySessionBatchPhaseTermSubjectClassType($classRoutine->session_id, $classRoutine->batch_type_id, $classRoutine->phase_id,
                $classRoutine->term_id, $classRoutine->subject_id, $classRoutine->class_type_id, $classRoutine->teacher_id, $classRoutine->class_date),
            'classDays' => UtilityServices::$ClassDays,
            'tableHeads' => ['Date', 'Teacher', 'Topic', 'Time', 'Class Room', 'Status', 'Action'],
            'dataUrl' => self::redirectUrl . '/getClasses/'.$id,
            'columns' => [
                ['data' => 'class_date', 'name' => 'class_date', 'width' => '10%'],
                ['data' => 'teacher_id', 'name' => 'teacher_id' , 'width' => '10%'],
                ['data' => 'topic_id', 'name' => 'topic_id', 'width' => '30%'],
                ['data' => 'class_time', 'name' => 'class_time', 'width' => '13%'],
                ['data' => 'hall_id', 'name' => 'hall_id', 'width' => '10%'],
                ['data' => 'status', 'name' => 'status', 'width' => '3%'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'width' => '14%']
            ],
        ];

        return view(self::moduleDirectory . 'view', $data);
    }

    public function getClasses(Request $request, $id){
        return $this->service->getClassesById($request, $id);
    }

    public function getIndividualClassDetail($id){
        $classRoutine = $this->service->find($id);
        $data = [
            'pageTitle' => self::moduleName,
            'classRoutine' =>  $classRoutine,
            'checkAttendance' =>  $this->attendanceService->findBy(['class_routine_id' => $id]),
        ];

        return view(self::moduleDirectory . 'class_detail_view', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ClassRoutine $classRoutine
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $classRoutine = $this->service->find($id);
        $phaseDetail = $classRoutine->subject->sessionPhase->filter(function($item)use($classRoutine){
            return $item->sessionDetail->session_id == $classRoutine->session_id;
        })->first();

        if ($classRoutine->class_type_id == 8){
            $findBy = ['type' => 3];
        }else if ($classRoutine->class_type_id == 6 || $classRoutine->class_type_id == 7){
            $findBy = ['type' => 3];
        }else{
            $findBy = ['type' => 1];
        }

        $data = [
            'pageTitle' => self::moduleName,
            'classRoutine' => $classRoutine,
            'phaseDetail' => $phaseDetail,
            'sessions' => $this->sessionService->listByStatus(),
            'min_max_date' => $this->service->getMinMaxDateBySessionBatchPhaseTermSubject($classRoutine->session_id, $classRoutine->batch_type_id, $classRoutine->phase_id,
            $classRoutine->term_id, $classRoutine->subject_id),
            'courses' => $this->courseService->lists(),
            'classTypes' => $this->classTypeService->listByStatus(),
            'batchTypes' => $this->batchTypeService->listByStatus(),
            'classRooms' => $this->hallService->listByStatus(),
            'classDays' => UtilityServices::$ClassDays,
            'studentGroups' => $this->studentGroupService->findBy($findBy, 'list'),
            'teachersList' => $this->teacherService->getTeachersBySubjectId($classRoutine->subject_id),
        ];

        return view(self::moduleDirectory . 'edit', $data);
    }

    public function editIndividualClassRoutine(Request $request, $id)
    {
        $classRoutine = $this->service->find($id);
        $phaseDetail = $classRoutine->subject->sessionPhase->filter(function($item)use($classRoutine){
            return $item->sessionDetail->session_id == $classRoutine->session_id;
        })->first();

        $data = [
            'pageTitle' => self::moduleName,
            'classRoutine' => $classRoutine,
            'phaseDetail' => $phaseDetail,
            'sessions' => $this->sessionService->listByStatus(),
            'min_max_date' => $this->service->getMinMaxDateBySessionBatchPhaseTermSubject($classRoutine->session_id, $classRoutine->batch_type_id, $classRoutine->phase_id,
            $classRoutine->term_id, $classRoutine->subject_id),
            'courses' => $this->courseService->lists(),
            'classTypes' => $this->classTypeService->listByStatus(),
            'batchTypes' => $this->batchTypeService->listByStatus(),
            'classRooms' => $this->hallService->listByStatus(),
            'classDays' => UtilityServices::$ClassDays,
        ];

        return view(self::moduleDirectory . 'individual_edit', $data);
    }

    public function updateIndividualClassRoutine(Request $request, $id)
    {
        $classRoutine = $this->service->editIndividualClassRoutine($request, $id);

        if ($classRoutine){
            $request->session()->flash('success', setMessage('update', self::moduleName));
            return redirect()->route('class_routine.show', [$id]);
        }

        $request->session()->flash('error', setMessage('update.error', self::moduleName));
        return redirect()->route('class_routine.show', [$id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\ClassRoutine $classRoutine
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $classRoutine = $this->service->editClassRoutine($request, $id);

        if ($classRoutine){
            $request->session()->flash('success', setMessage('update', self::moduleName));
            return redirect()->route('class_routine.index');
        }

        $request->session()->flash('error', setMessage('update.error', self::moduleName));
        return redirect()->route('class_routine.index');
    }

    public function getCalendar(Request $request){
        $classes   = $this->service->getClasses($request);
        $holidays  = $this->holidayService->getTwoOldMonthAndNextMonthHolidays();
        $eventData = $this->service->buildCalendarEvents($classes, $holidays);

        $data = [
            'pageTitle' => self::moduleName,
            'eventData' => $eventData,
            'sessions' => $this->sessionService->listByStatus(),
            'courses' => $this->courseService->lists(),
            'phases' => $this->phaseService->lists(),
            'terms' => $this->termService->lists(),
            'years' => UtilityServices::getYears(),
        ];


        return view(self::moduleDirectory . 'calendar', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ClassRoutine $classRoutine
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClassRoutine $classRoutine)
    {
        //
    }

    public function getPhaseAndTerm(Request $request)
    {
        $response = [];
        if (!empty($request->sessionId) && !empty($request->courseId)) {
            $sessionDetail = $this->sessionService->getSessionDetailBySessionIdAndCourseId($request->sessionId, $request->courseId);
            foreach ($sessionDetail->sessionPhaseDetails as $key => $detail) {
                $response[$key] = [
                    'phase' => $detail->phase,
                    'total_terms' => $detail->total_terms
                ];
            }
        }

        return response()->json(['status' => true, 'data' => $response]);
    }

    public function checkScheduleExist(Request $request){
        $check = 'true';


        if (
            !empty($request->session_id) && !empty($request->phase_id)
            && !empty($request->start_time) && !empty($request->end_time) && !empty($request->days) && !empty($request->class_type_id)
            && !empty($request->subject_id) && !empty($request->onEvent)
        ){

            if (!isset($request->start_date) && !isset($request->end_date)){
                $request->merge([
                    'start_date' => $request->class_date,
                    'end_date' => $request->class_date
                ]);
            }

            $exist = $this->service->checkClassRoutineExist($request);

            if (!empty($exist)){
                $check = 'false';
            }
        }

        echo $check;
    }

    public function printClassRoutine(Request $request){
        $data = [
            'pageTitle' => self::moduleName,
            'sessions' => $this->sessionService->listByStatus(),
            'sessionData' => $this->sessionService->getAllSession(),
            'courses' => $this->courseService->lists(),
            'allTimes' => $this->service->getClassTimes(),
            'classDays' => UtilityServices::$ClassDays,
            'allClasses' => $this->service->getWeeklyClasses($request),
        ];

        return view(self::moduleDirectory . 'print_routine', $data);
    }

    public function routineList(Request $request)
    {
        $data = [
            'pageTitle' => self::moduleName,
            'sessions' => $this->sessionService->listByStatus(),
            'courses' => $this->courseService->lists(),
            'phases' => $this->phaseService->lists(),
            'terms' => $this->termService->lists(),
            'classTypes' => $this->classTypeService->lists(),
            'years' => UtilityServices::getYears(),
        ];

        if ($request->filled(['session_id', 'course_id', 'phase_id'])) {
            $data['routines'] = $this->service->getClasses($request);
        }
        return view(self::moduleDirectory . 'routine_list', $data);
    }

    public function routineListPdf(Request $request)
    {
        $sessionInfo = $this->sessionService->find($request->session_id)->title;
        $course = $this->courseService->find($request->course_id)->title;
        $phase = $this->phaseService->find($request->phase_id)->title;
        $year = $request->year;

        $data = [
            'sessionInfo' => $sessionInfo,
            'course' => $course,
            'phase' => $phase,
            'year' => $year,
            'routines' => $this->service->getClasses($request),
        ];

        $document = $sessionInfo . '-' . $course . '-' . $phase . '_routine_list_'. $year .'.pdf';
        $pdf = PDF::loadView('class_routine.pdf.routine_list', $data);
        return $pdf->stream($document);
    }
}
