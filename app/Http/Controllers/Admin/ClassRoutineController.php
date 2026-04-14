<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoutine;
use App\Models\StudentGroup;
use App\Models\StudentGroupType;
use App\Models\Subject;
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
use App\Services\Admin\SubjectService;
use App\Services\Admin\TeacherService;
use App\Services\Admin\TermService;
use App\Services\Admin\TopicService;
use App\Services\UtilityServices;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use PDF;
use Validator;

class ClassRoutineController extends Controller
{
    /**
     *
     */
    const moduleName = 'Class Routine';
    /**
     *
     */
    const redirectUrl = 'admin/class_routine';
    /**
     *
     */
    const moduleDirectory = 'class_routine.';

    protected $model;
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
    protected $topicService;
    protected $termService;
    protected $subjectService;
    protected $holidayService;

    public function __construct(
        ClassRoutine      $model, ClassRoutineService $service, SessionService $sessionService,
        CourseService     $courseService, ClassTypeService $classTypeService,
        BatchTypeService  $batchTypeService, PhaseService $phaseService, HallService $hallService,
        AttendanceService $attendanceService, StudentGroupService $studentGroupService,
        TeacherService    $teacherService, TermService $termService, TopicService $topicService,
        SubjectService    $subjectService, HolidayService $holidayService
    )
    {
        $this->model               = $model;
        $this->service             = $service;
        $this->sessionService      = $sessionService;
        $this->courseService       = $courseService;
        $this->classTypeService    = $classTypeService;
        $this->batchTypeService    = $batchTypeService;
        $this->phaseService        = $phaseService;
        $this->hallService         = $hallService;
        $this->attendanceService   = $attendanceService;
        $this->studentGroupService = $studentGroupService;
        $this->teacherService      = $teacherService;
        $this->termService         = $termService;
        $this->topicService        = $topicService;
        $this->subjectService      = $subjectService;
        $this->holidayService      = $holidayService;
    }

    /**
     * Display a listing of the resource.
     * @return View
     */
    public function index()
    {
        $data = [
            'pageTitle'  => self::moduleName,
            'tableHeads' => ['Subject', 'Class Type', 'Teacher', 'Session', 'Term', 'Time', 'Status', 'Action'],
            'dataUrl'    => self::redirectUrl . '/get-data',
            'columns'    => [
                ['data' => 'subject_id', 'name' => 'subject_id'],
                ['data' => 'class_type_id', 'name' => 'class_type_id'],
                ['data' => 'teacher_id', 'name' => 'teacher_id'],
                ['data' => 'session_id', 'name' => 'session_id'],
                ['data' => 'term_id', 'name' => 'term_id'],
                ['data' => 'class_time', 'name' => 'class_time'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
            'sessions'   => $this->sessionService->listByStatus(),
            'courses'    => $this->courseService->listByStatus(),
            'phases'     => $this->phaseService->listByStatus(),
            'terms'      => $this->termService->listByStatus(),
            'classTypes' => $this->classTypeService->listByStatus(),
            'years'      => UtilityServices::getYears(),
        ];
        return view(self::moduleDirectory . 'index', $data);
    }

    public function getData(Request $request)
    {
        return $this->service->getDatatable($request);
    }

    /**
     * Show the form for creating a new resource.
     * @return View
     */
    public function create()
    {
        $data = [
            'pageTitle'     => self::moduleName,
            'sessions'      => $this->sessionService->listByStatus(),
            'courses'       => $this->courseService->listByStatus(),
            'classTypes'    => $this->classTypeService->listByStatus(),
            'batchTypes'    => $this->batchTypeService->listByStatus(),
            'classRooms'    => $this->hallService->listByStatus(),
            'classDays'     => UtilityServices::$ClassDays,
            'studentGroups' => $this->studentGroupService->getData(),
            'subjects'      => $this->subjectService->getAllSubject(),
        ];

        return view(self::moduleDirectory . 'create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        // Lock key based on user IP
        $lockKey  = 'store_class_routine_' . $request->ip();
        $lockTime = 5;

        if (Cache::has($lockKey)) {
            $request->session()->flash('error', 'Please wait before submitting again.');
            return redirect()->route('class_routine.create');
        }

        Cache::put($lockKey, true, $lockTime);

        try {
            $validator = Validator::make($request->all(), [
                'start_date' => 'required|date_format:d/m/Y',
                'end_date'   => 'required|date_format:d/m/Y',
                'start_time' => 'required|date_format:H:i',
                'end_time'   => 'required|date_format:H:i',
            ])->after(function ($validator) use ($request) {
                $startDate = Carbon::createFromFormat('d/m/Y', $request->start_date);
                $endDate   = Carbon::createFromFormat('d/m/Y', $request->end_date);
                $startTime = Carbon::createFromFormat('H:i', $request->start_time);
                $endTime   = Carbon::createFromFormat('H:i', $request->end_time);

                if ($endDate->lessThan($startDate)) {
                    $validator->errors()->add('end_date', 'The end date must be after or equal to the start date.');
                }

                if ($startDate->diffInDays($endDate) > 60) {
                    $validator->errors()->add('end_date', 'The end date must not be more than 60 days after the start date.');
                }

                if ($endTime->lessThan($startTime)) {
                    $validator->errors()->add('end_time', 'The end time must be after the start time.');
                }
            });

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $classRoutine = $this->service->addClassRoutine($request);
            if ($classRoutine) {
                $request->session()->flash('success', setMessage('create', self::moduleName));
            } else {
                $request->session()->flash('error', setMessage('create.error', self::moduleName));
            }
        } finally {
            Cache::forget($lockKey);
        }

        return redirect()->route('class_routine.index');
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @param $specificRoutineFlag
     *
     * @return View
     */
    public function show($id, $specificRoutineFlag = 'false')
    {
        $classRoutine = $this->service->find($id);
        $classDateArr = ClassRoutine::where('session_id', $classRoutine->session_id)
                                    ->where('batch_type_id', $classRoutine->batch_type_id)
                                    ->where('phase_id', $classRoutine->phase_id)
                                    ->where('term_id', $classRoutine->term_id)
                                    ->where('subject_id', $classRoutine->subject_id)
                                    ->where('class_type_id', $classRoutine->class_type_id)
                                    ->where('teacher_id', $classRoutine->teacher_id)
                                    ->pluck('class_date')->toArray();
        $data           = [
            'pageTitle'    => self::moduleName,
            'classRoutine' => $classRoutine,
            'classDates'   => $classDateArr,
            'min_max_date' => $this->service->getMinMaxDateBySessionBatchPhaseTermSubjectClassType($classRoutine->session_id, $classRoutine->batch_type_id, $classRoutine->phase_id,
                $classRoutine->term_id, $classRoutine->subject_id, $classRoutine->class_type_id, $classRoutine->teacher_id, $classRoutine->class_date),
            'classDays'    => UtilityServices::$ClassDays,
            'tableHeads'   => ['ID', 'Date', 'Teacher', 'Topic', 'Time', 'Class Room', 'Status', 'Action'],
            'dataUrl'      => self::redirectUrl . '/getClasses/' . $id . '/' . $specificRoutineFlag,
            'columns'      => [
                ['data' => 'id', 'name' => 'id', 'width' => '5%'],
                ['data' => 'class_date', 'name' => 'class_date', 'width' => '10%'],
                ['data' => 'teacher_id', 'name' => 'teacher_id', 'width' => '20%'],
                ['data' => 'topic_id', 'name' => 'topic_id', 'width' => '30%'],
                ['data' => 'class_time', 'name' => 'class_time', 'width' => '10%'],
                ['data' => 'hall_id', 'name' => 'hall_id', 'width' => '10%'],
                ['data' => 'status', 'name' => 'status', 'width' => '5%'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'width' => '10%']
            ],
        ];
        return view(self::moduleDirectory . 'view', $data);
    }

    public function getClasses(Request $request, $id, $isSpecificRoutine = 'false')
    {
        return $this->service->getClassesById($request, $id, $isSpecificRoutine);
    }

    public function getIndividualClassDetail($id)
    {
        $classRoutine                   = $this->service->find($id);
        $data                           = [
            'pageTitle'       => self::moduleName,
            'classRoutine'    => $classRoutine,
            'checkAttendance' => $this->attendanceService->findBy(['class_routine_id' => $id]),
        ];
        $data['attendanceStudentExist'] = $this->attendanceService->getStudentsWhoseAttendanceAlreadyProvided($id);

        return view(self::moduleDirectory . 'class_detail_view', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param         $id
     *
     * @return View
     */
    public function edit(Request $request, $id)
    {
        $classRoutine = $this->service->find($id);

        if (!$classRoutine) {
            $request->session()->flash('error', 'Class routine not found.');
            return redirect()->back();
        }

        // Safe attendance check
        if ($classRoutine->attendances && $classRoutine->attendances->isNotEmpty()) {
            $request->session()->flash('error', 'You cannot edit this class routine because attendance has already been taken for this class.');
            return redirect()->back();
        }

        $classDateArr = ClassRoutine::where('session_id', $classRoutine->session_id)
                                    ->where('batch_type_id', $classRoutine->batch_type_id)
                                    ->where('phase_id', $classRoutine->phase_id)
                                    ->where('term_id', $classRoutine->term_id)
                                    ->where('subject_id', $classRoutine->subject_id)
                                    ->where('class_type_id', $classRoutine->class_type_id)
                                    ->where('teacher_id', $classRoutine->teacher_id)
                                    ->pluck('class_date')
                                    ->toArray();

        // Safe phase detail retrieval with null checks
        $phaseDetail = null;
        if ($classRoutine->subject && $classRoutine->subject->sessionPhase) {
            $phaseDetail = $classRoutine->subject->sessionPhase
                ->filter(function ($item) use ($classRoutine) {
                    return $item->sessionDetail &&
                           $item->sessionDetail->session_id == $classRoutine->session_id;
                })
                ->first();
        }

        // Get the current group type (dynamically based on class_type_id)
        $groupType = StudentGroupType::whereHas('classTypes', function ($query) use ($classRoutine) {
            $query->where('class_type_id', $classRoutine->class_type_id);
        })->first();

        // Fallback if not found
        $type = $groupType ? $groupType->id : null;

        $data = [
            'pageTitle'     => self::moduleName,
            'classRoutine'  => $classRoutine,
            'classDates'    => $classDateArr,
            'phaseDetail'   => $phaseDetail,
            'sessions'      => $this->sessionService->listByStatus(),
            'min_max_date'  => $this->service->getMinMaxDateBySessionBatchPhaseTermSubjectClassType($classRoutine->session_id, $classRoutine->batch_type_id, $classRoutine->phase_id,
                $classRoutine->term_id, $classRoutine->subject_id, $classRoutine->class_type_id, $classRoutine->teacher_id, $classRoutine->class_date),
            'courses'       => $this->courseService->listByStatus(),
            'classTypes'    => $this->classTypeService->listByStatus(),
            'batchTypes'    => $this->batchTypeService->listByStatus(),
            'classRooms'    => $this->hallService->listByStatus(),
            'classDays'     => UtilityServices::$ClassDays,
            'studentGroups' => $this->studentGroupService->getStudentGroupsBySessionCourseAndGroupTypeId(
                $classRoutine->session_id,
                $classRoutine->course_id,
                $classRoutine->phase_id,
                $type,
                $classRoutine->subject->department_id
            ),
            'teachersList'  => $this->teacherService->getTeachersBySubjectId($classRoutine->subject_id),
        ];

        return view(self::moduleDirectory . 'edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request           $request
     * @param \App\ClassRoutine $classRoutine
     *
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Lock key based on user IP
        $lockKey  = 'store_class_routine_' . $request->ip();
        $lockTime = 5;

        if (Cache::has($lockKey)) {
            $request->session()->flash('error', 'Please wait before submitting again.');
            return redirect()->back();
        }

        Cache::put($lockKey, true, $lockTime);

        $attendances = $this->attendanceService->findBy(['class_routine_id' => $id]);

        if (!empty($attendances)) {
            $request->session()->flash('error', 'You cannot edit this class routine because attendance has already been taken for this class.');
            return redirect()->route('class_routine.info.single', [$id]);
        }

        try {
            $validator = Validator::make($request->all(), [
                'start_date' => 'required|date_format:d/m/Y',
                'end_date'   => 'required|date_format:d/m/Y',
                'start_time' => 'required|date_format:H:i',
                'end_time'   => 'required|date_format:H:i',
            ])->after(function ($validator) use ($request) {
                $startDate = Carbon::createFromFormat('d/m/Y', $request->start_date);
                $endDate   = Carbon::createFromFormat('d/m/Y', $request->end_date);
                $startTime = Carbon::createFromFormat('H:i', $request->start_time);
                $endTime   = Carbon::createFromFormat('H:i', $request->end_time);

                if ($endDate->lessThan($startDate)) {
                    $validator->errors()->add('end_date', 'The end date must be after or equal to the start date.');
                }

                if ($startDate->diffInDays($endDate) > 60) {
                    $validator->errors()->add('end_date', 'The end date must not be more than 60 days after the start date.');
                }

                if ($endTime->lessThan($startTime)) {
                    $validator->errors()->add('end_time', 'The end time must be after the start time.');
                }
            });

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $classRoutine = $this->service->editClassRoutine($request, $id);

            if ($classRoutine) {
                $request->session()->flash('success', setMessage('update', self::moduleName));
            } else {
                $request->session()->flash('error', setMessage('update.error', self::moduleName));
            }
        } finally {
            Cache::forget($lockKey);
        }
        return redirect()->route('class_routine.index');
    }

    public function editIndividualClassRoutine(Request $request, $id)
    {
        $classRoutine = $this->service->find($id);

        if (!$classRoutine) {
            $request->session()->flash('error', 'Class routine not found.');
            return redirect()->back();
        }

        // Safe attendance check
        if ($classRoutine->attendances && $classRoutine->attendances->isNotEmpty()) {
            $request->session()->flash('error', 'You cannot edit this class routine because attendance has already been taken for this class.');
            return redirect()->back();
        }

        // Get the current group type (dynamically based on class_type_id)
        $groupType = StudentGroupType::whereHas('classTypes', function ($query) use ($classRoutine) {
            $query->where('class_type_id', $classRoutine->class_type_id);
        })->first();

        // Fallback if not found
        $type = $groupType->id ?? null;

        // Filter the phaseDetail
        $phaseDetail = $classRoutine->subject->sessionPhase->filter(function ($item) use ($classRoutine) {
            return $item->sessionDetail->session_id == $classRoutine->session_id;
        })->first();

        $data = [
            'pageTitle'     => self::moduleName,
            'classRoutine'  => $classRoutine,
            'phaseDetail'   => $phaseDetail,
            'sessions'      => $this->sessionService->listByStatus(),
            'min_max_date'  => $this->service->getMinMaxDateBySessionBatchPhaseTermSubject(
                $classRoutine->session_id,
                $classRoutine->batch_type_id,
                $classRoutine->phase_id,
                $classRoutine->term_id,
                $classRoutine->subject_id
            ),
            'courses'       => $this->courseService->listByStatus(),
            'classTypes'    => $this->classTypeService->listByStatus(),
            'batchTypes'    => $this->batchTypeService->listByStatus(),
            'classRooms'    => $this->hallService->listByStatus(),
            'studentGroups' => $this->studentGroupService->getStudentGroupsBySessionCourseAndGroupTypeId(
                $classRoutine->session_id,
                $classRoutine->course_id,
                $classRoutine->phase_id,
                $type,
                $classRoutine->subject->department_id
            ),
            'teachersList'  => $this->teacherService->getTeachersBySubjectId($classRoutine->subject_id),
            'classDays'     => UtilityServices::$ClassDays,
            'topics'        => $this->topicService->getAllTopicsBySubjectIdAndDepartmentId(
                $classRoutine->subject_id,
                $classRoutine->subject->department_id
            ),
        ];

        return view(self::moduleDirectory . 'individual_edit', $data);
    }

    public function updateIndividualClassRoutine(Request $request, $id)
    {
        // Lock key based on user IP
        $lockKey  = 'store_class_routine_' . $request->ip();
        $lockTime = 5;

        if (Cache::has($lockKey)) {
            $request->session()->flash('error', 'Please wait before submitting again.');
            return redirect()->route('class_routine.edit.single', [$id]);
        }

        Cache::put($lockKey, true, $lockTime);

        $attendances = $this->attendanceService->findBy(['class_routine_id' => $id]);

        // if attendance exists return with error
        if (!empty($attendances)) {
            $request->session()->flash('error', 'You cannot edit this class routine because attendance has already been taken for this class.');
            return redirect()->back();
        }

        $validator = Validator::make($request->all(), [
            'start_time' => 'required|date_format:H:i',
            'end_time'   => 'required|date_format:H:i',
            'remarks' => 'required_unless:status,1|max:500'
        ],
            [
                'remarks.required_unless' => 'Remarks are required when marking class as Inactive or Suspended.',
                'remarks.max'             => 'Remarks must not exceed 500 characters.'
            ])->after(function ($validator) use ($request) {
            $startTime = Carbon::createFromFormat('H:i', $request->start_time);
            $endTime   = Carbon::createFromFormat('H:i', $request->end_time);

            if ($endTime->lessThan($startTime)) {
                $validator->errors()->add('end_time', 'The end time must be after the start time.');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $classRoutine = $this->service->editIndividualClassRoutine($request, $id);

            if ($classRoutine) {
                $request->session()->flash('success', setMessage('update', self::moduleName));
            } else {
                $request->session()->flash('error', setMessage('update.error', self::moduleName));
            }
        } finally {
            Cache::forget($lockKey);
        }
        return redirect()->route('class_routine.show', [$id]);
    }

    public function toggleStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'      => 'required|exists:class_routines,id',
            'status'  => 'nullable|in:0,1,2',
            'remarks' => 'required_unless:status,1|max:500'
        ], [
            'id.required'             => 'Class ID is required.',
            'id.exists'               => 'Class not found.',
            'remarks.required_unless' => 'Remarks are required when marking class as Inactive or Suspended.',
            'remarks.max'             => 'Remarks must not exceed 500 characters.',
            'status.in'               => 'Invalid status provided.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            $classId = $request->id;
            $class   = ClassRoutine::findOrFail($classId);
            $hasAttendance = $class->attendances && $class->attendances->isNotEmpty();

            // Determine new status
            $newStatus = $request->filled('status') ? (int)$request->status : (int)!$class->status;
            $isSuspend = $newStatus == 2;

            // Check permissions for suspend operation
            if ($isSuspend) {
                // Attendance check
                if ($hasAttendance) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Cannot suspend class with attendance records.'
                    ], 403);
                }

                // Authorization check
                if (!canUserEditClass($class)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You do not have permission to suspend this class.'
                    ], 403);
                }
            }

            // Build update data
            $updateData = [
                'status'  => $newStatus,
                'remarks' => null,
            ];

            if ($newStatus == 0 || $newStatus == 2) {
                $updateData['remarks'] = $request->remarks;
            }
            $class->update($updateData);

            // Prepare response message
            if ($isSuspend) {
                $message = 'Class routine - ' . $classId . ' suspended successfully with remarks.';
            } else {
                $message = $newStatus ? 'Class routine - ' . $classId . ' activated successfully.'
                    : 'Class routine - ' . $classId . ' deactivated successfully with remarks.';
            }

            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating class status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getCalendar(Request $request)
    {
        $classes   = $this->service->getClasses($request);
        $holidays  = $this->holidayService->getTwoOldMonthAndNextMonthHolidays();
        $eventData = $this->service->buildCalendarEvents($classes, $holidays);

        $data = [
            'pageTitle' => self::moduleName,
            'eventData' => $eventData,
            'sessions'  => $this->sessionService->listByStatus(),
            'courses'   => $this->courseService->lists(),
            'phases'    => $this->phaseService->lists(),
            'terms'     => $this->termService->lists(),
            'years'     => UtilityServices::getYears(),
        ];

        return view(self::moduleDirectory . 'calendar', $data);
    }

    public function fetchByMonth(Request $request): JsonResponse
    {
        $start = Carbon::parse($request->start);
        $end   = Carbon::parse($request->end);

        $classes = $this->model->with(['teacher', 'hall', 'subject', 'classType'])
                               ->where('status', 1)
                               ->whereBetween('class_date', [$start->startOfMonth(), $end->endOfMonth()])
                               ->get();

        $events = [];
        foreach ($classes as $cl) {
            $teacher = $cl->teacher->full_name ?? '';
            $hall    = $cl->hall->title ?? '';

            $events[] = [
                'start'    => $cl->class_date,
                'title'    => e($cl->subject->title) . ' <br> ' . e($teacher) .
                    parseClassTimeInTwelveHours($cl->start_from) . ' - ' . parseClassTimeInTwelveHours($cl->end_at) . '<br>' . e($hall) .
                    '<a href="' . route(customRoute('class_routine.info.single'), $cl->id) . '" target="_blank" class="badge badge-info p-1" title="View Class">Go to class</a>',
                'event_id' => $cl->id,
            ];
        }

        return response()->json(['count' => $classes->count(), 'events' => $events]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\ClassRoutine $classRoutine
     *
     * @return Response
     */
    public function destroy(ClassRoutine $classRoutine)
    {
        //
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getPhaseAndTerm(Request $request)
    {
        $response = [];
        if (!empty($request->sessionId) && !empty($request->courseId)) {
            $sessionDetail = $this->sessionService->getSessionDetailBySessionIdAndCourseId($request->sessionId, $request->courseId);
            foreach ($sessionDetail->sessionPhaseDetails as $key => $detail) {
                $response[$key] = [
                    'phase'       => $detail->phase,
                    'total_terms' => $detail->total_terms
                ];
            }
        }

        return response()->json(['status' => true, 'data' => $response]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function checkScheduleExist(Request $request)
    {
        $response = ['status' => true];

            if (!isset($request->start_date) && !isset($request->end_date)) {
                $request->merge([
                    'start_date' => $request->class_date,
                    'end_date'   => $request->class_date
                ]);
            }

            $exist = $this->service->checkClassRoutineExistNew($request);

            if (!empty($exist)) {
                if (!empty($exist['teacher'])) {
                    $response = [
                        'status' => false,
                        'type' => 'teacher',
                        'message' => 'Teacher already assigned in this day & time'
                    ];
                } elseif (!empty($exist['students'])) {
                    $response = [
                        'status' => false,
                        'type' => 'students',
                        'message' => 'Student already has a class in this day & time'
                    ];
                }
            }

        return response()->json($response);
    }

    public function printClassRoutine(Request $request)
    {
        $data = [
            'pageTitle'   => self::moduleName,
            'sessions'    => $this->sessionService->listByStatus(),
            'sessionData' => $this->sessionService->getAllSession(),
            'courses'     => $this->courseService->lists(),
            'allTimes'    => $this->service->getClassTimes(),
            'classDays'   => UtilityServices::$ClassDays,
            'allClasses'  => $this->service->getWeeklyClasses($request),
        ];

        return view(self::moduleDirectory . 'print_routine', $data);
    }

    public function printClassRoutineFile(Request $request)
    {
        $data = [
            'pageTitle'   => self::moduleName,
            'sessions'    => $this->sessionService->listByStatus(),
            'sessionData' => $this->sessionService->getAllSession(),
            'courses'     => $this->courseService->lists(),
            'allTimes'    => $this->service->getClassTimes(),
            'classDays'   => UtilityServices::$ClassDays,
            'allClasses'  => $this->service->getWeeklyClasses($request),
        ];

        return view(self::moduleDirectory . 'print_routine_file', $data);
    }

    public function routineList(Request $request)
    {
        $data = [
            'pageTitle'  => self::moduleName,
            'sessions'   => $this->sessionService->listByStatus(),
            'courses'    => $this->courseService->lists(),
            'phases'     => $this->phaseService->lists(),
            'terms'      => $this->termService->lists(),
            'classTypes' => $this->classTypeService->lists(),
            'years'      => UtilityServices::getYears(),
        ];

        if ($request->filled(['session_id', 'course_id', 'phase_id'])) {
            $data['routines'] = $this->service->getClasses($request);
        }
        return view(self::moduleDirectory . 'routine_list', $data);
    }

    public function routineListPdf(Request $request)
    {
        $sessionInfo = $this->sessionService->find($request->session_id)->title;
        $course      = $this->courseService->find($request->course_id)->title;
        $phase       = $this->phaseService->find($request->phase_id)->title;
        $year        = $request->year;

        $data = [
            'sessionInfo' => $sessionInfo,
            'course'      => $course,
            'phase'       => $phase,
            'year'        => $year,
            'routines'    => $this->service->getClasses($request),
        ];

        $document = $sessionInfo . '-' . $course . '-' . $phase . '_routine_list_' . $year . '.pdf';
        $pdf      = PDF::loadView('class_routine.pdf.routine_list', $data);
        return $pdf->stream($document);
    }

    //get class number for a term from class start and end date
    public function getAllClassDaysExceptHolidays(Request $request)
    {
        $totalTermClass = $this->service->getAllClassDaysWithoutHoliday($request);
        return response()->json($totalTermClass);
    }

    /**
     * @param $phaseId
     * @param $courseId
     * @param $sessionId
     * @param $subjectId
     *
     * @return JsonResponse
     */
    public function getStudentGroupList($phaseId, $courseId, $sessionId, $subjectId, $classTypeId = null)
    {
        $departmentId = Subject::where('id', $subjectId)->value('department_id');

        $query = StudentGroup::where([
            ['phase_id', '=', $phaseId],
            ['course_id', '=', $courseId],
            ['session_id', '=', $sessionId],
            ['department_id', '=', $departmentId],
            ['status', '=', 1],
        ])->with('department');

        if ($classTypeId) {
            //Check if any group type exists with this classTypeId
            $hasMatchedGroupTypes = StudentGroupType::whereHas('classTypes', function ($q) use ($classTypeId) {
                $q->where('class_type_id', $classTypeId);
            })->exists();

            if ($hasMatchedGroupTypes) {
                // Only fetch those groupTypes which are explicitly mapped to the classTypeId
                $query->whereHas('studentGroupType.classTypes', function ($q) use ($classTypeId) {
                    $q->where('class_type_id', $classTypeId);
                });
            } else {
                // No mapping found — allow global groupTypes (no classTypes)
                $query->whereHas('studentGroupType', function ($q) {
                    $q->whereDoesntHave('classTypes');
                });
            }
        }

        return response()->json($query->get());
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function getClassById(Request $request)
    {
        $id = $request->class_id;
        return redirect()->route('class_routine.info.single', $id);
    }
}
