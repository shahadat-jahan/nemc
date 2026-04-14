<?php
/**
 * Created by PhpStorm.
 * User: office
 * Date: 2/26/19
 * Time: 2:45 PM
 */

namespace App\Services\Admin\Admission;

use App\Models\ClassRoutine;
use App\Models\Teacher;
use App\Services\Admin\AttendanceService;
use App\Services\Admin\HolidayService;
use App\Services\BaseService;
use App\Services\dataObject;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClassRoutineService extends BaseService
{

    protected $holidayService;
    protected $teacher;
    protected $attendanceService;

    public function __construct(
        ClassRoutine      $classRoutine, HolidayService $holidayService, Teacher $teacher,
        AttendanceService $attendanceService
    )
    {
        $this->model             = $classRoutine;
        $this->holidayService    = $holidayService;
        $this->teacher           = $teacher;
        $this->attendanceService = $attendanceService;
    }

    /**
     * @param $request
     *
     * @return string
     */
    public function addClassRoutine($request)
    {
        $dates    = [];
        $schedule = '';
        // get topic
        $teacher = $this->teacher->find($request->teacher_id);
        //decrease 1 day
        $previousDay = Carbon::createFromFormat('d/m/Y', $request->start_date)->subDay(1)->format('d/m/Y');

        foreach ($request->days as $day) {
            $dates = array_reduce([
                $dates, generateDatesByDay($day, $previousDay, $request->end_date)
            ], 'array_merge', array());
        }

        //check topic already assign or not
        $alreadyAssignTopics = $this->model->where([
            ['subject_id', $request->subject_id],
            ['teacher_id', $request->teacher_id]
        ])->pluck('topic_id')->toArray();

        $totalAlreadyAssignTopics = count($alreadyAssignTopics);
        $TopicKey                 = 0;
        $isEveningClass           = isEvening($request->start_time);
        $classTypeId              = (int) $request->class_type_id;

        if($classTypeId === 14 && $isEveningClass){
            $classTypeId = 18; // Evening Ward
        }
        if ($classTypeId === 18 && !$isEveningClass) {
            $classTypeId = 14; // Morning Ward
        }

        foreach ($dates as $key => $date) {
            $check = $this->holidayService->getHolidayByDate($date);
            if (empty($check->toArray())) {
                if ($classTypeId === 1) {
                    $key = $TopicKey;
                    //if topic not assigned then filter teacher->topics by day->key(get single topic for single key)
                    if ($totalAlreadyAssignTopics == 0) {
                        $allTopics = $teacher->topics()->where('status', 1)->orderBy('serial_number', 'asc')->get();
                        $topicId   = isset($allTopics[$key]) ? $allTopics[$key]->id : '';
                    } else {
                        $allAssignTopic = $teacher->topics->where('status', 1); // if topic already assigned then get all topics of current teacher
                        $notAssignTopics    = $allAssignTopic->whereNotIn('id', $alreadyAssignTopics)->all(); //take topics that not assigned
                        $newNotAssignTopics = array();

                        foreach ($notAssignTopics as $notAssignTopic) {
                            $newNotAssignTopics[] = $notAssignTopic;
                        }
                        //again filter new topics by new day key
                        $newNotAssignTopics = collect($newNotAssignTopics)->sortBy('serial_number');
                        $topicId            = isset($newNotAssignTopics[$key]) ? $newNotAssignTopics[$key]->id : '';
                    }
                    $TopicKey++;
                } else {
                    $topicId = [];
                }

                DB::beginTransaction();

                $schedule = $this->create([
                    'session_id'    => $request->session_id,
                    'course_id'     => $request->course_id,
                    'batch_type_id' => $request->batch_type_id,
                    'phase_id'      => $request->phase_id,
                    'term_id'       => checkEmpty($request->term_id),
                    'subject_id'    => $request->subject_id,
                    'teacher_id'    => $request->teacher_id,
                    'class_type_id' => $classTypeId,
                    'hall_id'       => checkEmpty($request->hall_id),
                    'topic_id'      => checkEmpty($topicId),
                    'class_date'    => $date,
                    'start_from'    => $request->start_time,
                    'end_at'        => $request->end_time,
                    'old_students'  => isset($request->is_old_studnets) ? 1 : 0,
                ]);

                if ($request->has('student_group_id')) {
                    foreach ($request->student_group_id as $k => $group) {
                        $schedule->studentGroup()->attach($group, ['teacher_id' => $request->group_teachers[$k]]);
                    }
                }
                DB::commit();
            }
        }
        return $schedule;
    }

    /**
     * @param $request
     * @param $id
     *
     * @return string
     */
    public function editClassRoutine($request, $id)
    {
        $classInfo = $this->find($id);

        //get classes if class type is not  lecture or revised
        $classes = $this->model->where('session_id', $classInfo->session_id)->where('batch_type_id', $classInfo->batch_type_id)
                               ->where('phase_id', $classInfo->phase_id)->where('term_id', $classInfo->term_id)->where('subject_id', $classInfo->subject_id)
                               ->where('course_id', $classInfo->course_id)->where('class_type_id', $classInfo->class_type_id)->where('teacher_id', $classInfo->teacher_id);

        if ($classInfo->class_type_id != 1 || $classInfo->class_type_id != 9 || $classInfo->class_type_id != 17) {
            //filter classes by student group ID
            $classes->whereHas('studentGroup', function ($query) use ($request) {
                $studentGroupIds = [$request->student_group_id];
                $query->whereIn('student_group_id', $studentGroupIds);
            });
        }

        $classes = $classes->get();

        $classes->map(function ($item) use ($request) {
            if ($request->has('student_group_id')) {
                $item->studentGroup()->detach();
            }
            $item->delete();
        });
        return $this->addClassRoutine($request);
    }

    /**
     * @param $request
     * @param $id
     *
     * @return dataObject
     */
    public function editIndividualClassRoutine($request, $id)
    {
        $isEveningClass           = isEvening($request->start_time);
        $classTypeId              = (int) $request->class_type_id;

        if($classTypeId === 14 && $isEveningClass){
            $classTypeId = 18; // Evening Ward
        }
        if ($classTypeId === 18 && !$isEveningClass) {
            $classTypeId = 14; // Morning Ward
        }

        $this->update([
            'session_id'    => $request->session_id,
            'course_id'     => $request->course_id,
            'batch_type_id' => $request->batch_type_id,
            'phase_id'      => $request->phase_id,
            'term_id'       => checkEmpty($request->term_id),
            'subject_id'    => $request->subject_id,
            'teacher_id'    => $request->teacher_id,
            'class_type_id' => $classTypeId,
            'hall_id'       => $request->hall_id,
            'topic_id'      => checkEmpty($request->topic_id),
            'class_date'    => Carbon::createFromFormat('d/m/Y', $request->class_date)->format('Y-m-d'),
            'start_from'    => $request->start_time,
            'end_at'        => $request->end_time,
            'old_students'  => isset($request->is_old_studnets) ? 1 : 0,
            'status'        => $request->status,
            'remarks' => $request->status != 1 ? $request->remarks : null,
        ], $id);

        $class = $this->find($id);

        if ($request->has('student_group_id')) {
            $class->studentGroup()->detach();
            foreach ($request->student_group_id as $key => $group) {
                $class->studentGroup()->attach($group, ['teacher_id' => $request->group_teachers[$key]]);
            }
        }

        return $class;
    }

    /**
     * @param $request
     *
     * @return mixed
     */
    public function getDatatable($request)
    {
        if ($request->has('year')) {
            $year = $request->year;
        } else {
            $year = date('Y');
        }
        $table = $this->model->getTable();
        $activeCountSub = DB::table($table . ' as cr_active')
            ->selectRaw('COUNT(*)')
            ->whereColumn('cr_active.session_id', $table . '.session_id')
            ->whereColumn('cr_active.course_id', $table . '.course_id')
            ->whereColumn('cr_active.phase_id', $table . '.phase_id')
            ->whereColumn('cr_active.term_id', $table . '.term_id')
            ->whereColumn('cr_active.teacher_id', $table . '.teacher_id')
            ->whereColumn('cr_active.subject_id', $table . '.subject_id')
            ->whereColumn('cr_active.class_type_id', $table . '.class_type_id')
            ->where('cr_active.status', 1);

        $attendanceCountSub = DB::table('attencance as a')
            ->join($table . ' as cr_att', 'a.class_routine_id', '=', 'cr_att.id')
            ->selectRaw('COUNT(*)')
            ->whereColumn('cr_att.session_id', $table . '.session_id')
            ->whereColumn('cr_att.course_id', $table . '.course_id')
            ->whereColumn('cr_att.phase_id', $table . '.phase_id')
            ->whereColumn('cr_att.term_id', $table . '.term_id')
            ->whereColumn('cr_att.teacher_id', $table . '.teacher_id')
            ->whereColumn('cr_att.subject_id', $table . '.subject_id')
            ->whereColumn('cr_att.class_type_id', $table . '.class_type_id');

        $query = $this->model->newQuery()
                             ->select($table . '.*')
                             ->selectSub($activeCountSub, 'active_count')
                             ->selectSub($attendanceCountSub, 'attendance_count')
                             ->with('subject', 'classType', 'teacher', 'session', 'hall')
                             ->whereYear('class_date', $year)
                             ->groupBy('teacher_id', 'phase_id', 'term_id', 'class_type_id');

        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            if ($user->teacher) {
                $query = $query->whereIn('subject_id', getSubjectsIdByTeacherId($user->teacher->id, $user->teacher->course_id));
            }
        } elseif (Auth::guard('student_parent')->check()) {
            $authUser = Auth::guard('student_parent')->User();
            //if login user is student
            if ($authUser->student) {
                $student = $authUser->student;
            } //if login user is parent
            elseif ($authUser->parent) {
                $student = $authUser->parent->students->first();
            }
            $query = $query->where([
                ['session_id', $student->session_id],
                ['course_id', $student->course_id],
                ['batch_type_id', $student->batch_type_id],
                ['phase_id', $student->phase_id],
                ['term_id', $student->term_id],
            ]);
        }

        $query = $query->orderBy(DB::raw('DAYNAME(`class_date`)'), 'ASC')
                       ->orderBy('class_date', 'DESC');

        return Datatables::of($query)
                         ->editColumn('subject_id', function ($row) {
                             return $row->subject->title;
                         })
                         ->editColumn('class_type_id', function ($row) {
                             return $row->classType->title;
                         })
                         ->editColumn('teacher_id', function ($row) {
                             return isset($row->teacher) ? $row->teacher->full_name : '--';
                         })
                         ->editColumn('session_id', function ($row) {
                             return $row->session->title;
                         })
                         ->editColumn('term_id', function ($row) {
                             return isset($row->term) ? $row->term->title : '--';
                         })
                         ->addColumn('class_time', function ($row) {
                             return $row->class_time;
                         })
                         ->addColumn('hall_id', function ($row) {
                             return isset($row->hall) ? $row->hall->title : '';
                         })
                         ->editColumn('status', function ($row) {
                             return setStatus($row->active_count > 0 ? 1 : 0);
                         })
                         ->addColumn('action', function ($row) use ($request) {
                             $actions = '';
                             if (hasPermission('class_routine/edit')) {
                                 if (empty($row->attendance_count)) {
                                     $actions .= '<a href="' . route('class_routine.edit', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>';
                                 }
                             }
                             if (hasPermission('class_routine/view')) {
                                 $isSpecificRoutine = 'false';
                                 if (!empty($request->get('class_date'))) {
                                     $isSpecificRoutine = 'true';
                                 }
                                 $actions .= '<a href="' . route(customRoute('class_routine.show'), [$row->id . '/' . $isSpecificRoutine]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View"><i class="flaticon-eye"></i></a>';
                             }
                             return $actions;
                         })
                         ->rawColumns(['status', 'action'])
                         ->filter(function ($query) use ($request) {
                             if (!empty($request->get('session_id'))) {
                                 $query->where('session_id', $request->get('session_id'));
                             }
                             if (!empty($request->get('course_id'))) {
                                 $query->wherehas('subject.subjectGroup', function ($q) use ($request) {
                                     return $q->where('course_id', $request->get('course_id'));
                                 });
                             }

                             if (!empty($request->get('phase_id'))) {
                                 $query->where('phase_id', $request->get('phase_id'));
                             }
                             if (!empty($request->get('term_id'))) {
                                 $query->where('term_id', $request->get('term_id'));
                             }

                             if (!empty($request->get('subject_id'))) {
                                 $query->where('subject_id', $request->get('subject_id'));
                             }

                             if (!empty($request->get('teacher_id'))) {
                                 $query->where('teacher_id', $request->get('teacher_id'));
                             }

                             if (!empty($request->get('class_type_id'))) {
                                 $query->where('class_type_id', $request->get('class_type_id'));
                             }

                             if (!empty($request->get('class_date'))) {
                                 $classDate = $request->get('class_date');
                                 $classDate = Carbon::createFromFormat('d/m/Y', $classDate)->format('Y-m-d');
                                 $query->where('class_date', $classDate);
                             }
                         })
                         ->make(true);
    }

    /**
     * @param $request
     *
     * @return mixed
     */
    public function getClasses($request)
    {
        $isCalendarRoute = request()->routeIs('class_routine.calendar') || request()->routeIs('frontend.class_routine.calendar');

        $query = $this->model->newQuery()->where('status', '!=', 0);

        if ($isCalendarRoute) {
            $query->select([
                'id',
                'subject_id',
                'teacher_id',
                'class_type_id',
                'session_id',
                'class_date',
                'start_from',
                'end_at',
                'status',
            ])->with([
                'teacher:id,first_name,last_name',
                'subject:id,title',
                'session:id,title',
                'studentGroupTeacher:id,first_name,last_name',
                'studentGroup:id,group_name',
            ])->withCount('attendances');
        } else {
            $query->with(['teacher', 'hall', 'subject', 'classType'])
                  ->withCount('attendances');
        }

        if ($isCalendarRoute) {
            $query->whereBetween('class_date', [Carbon::now()->subMonths(2), Carbon::now()->addMonth()]);
        }
        // Handle logged-in users
        $this->applyUserFilters($query);
        // Apply filters from the request
        $this->applyRequestFilters($query, $request);

        if ($isCalendarRoute) {
            return $query->orderBy('class_date', 'ASC')->get();
        }

        return $query->orderBy('class_date', 'DESC')->get();
    }

    public function buildCalendarEvents($classes, $holidays): array
    {
        $events = [];

        if (!empty($classes)) {
            foreach ($classes as $cl) {
                if (isset($cl->teacher) && $cl->class_type_id == 1) {
                    $teacher = $cl->teacher->full_name . ' <br>';
                } else {
                    $teacher = '';
                    foreach ($cl->studentGroupTeacher as $key => $groupTeacher) {
                        $groupName = $cl->studentGroup[$key]->group_name ?? '';
                        $teacher   = $groupTeacher->full_name . ' <br>' . ($groupName ? $groupName . ' <br>' : '');
                    }
                }

                $sessionTitle = (isset($cl->session_id) && $cl->session) ? $cl->session->title . ' <br>' : '';
                $className = 'bg-light-gray'; // Scheduled class

                if ($cl->attendances_count > 0 && $cl->status == 1) {
                    $className = 'bg-light-green'; // Attended class
                } elseif ($cl->status == 2) {
                    $className = 'bg-light-yellow'; // Suspend class
                }

                $events[] = [
                    'start'     => $cl->class_date,
                    'title'     => $cl->subject->title . ' <br> ' . $teacher
                        . parseClassTimeInTwelveHours($cl->start_from) . ' - ' . parseClassTimeInTwelveHours($cl->end_at)
                        . '<br>' . $sessionTitle
                        . '<a href="' . route(customRoute('class_routine.info.single'), $cl->id) . '" target="_blank" class="badge badge-info p-1" title="View Class">Go to class</a>',
                    'event_id'  => $cl->id,
                    'className' => $className,
                ];
            }
        }

        if (!empty($holidays)) {
            foreach ($holidays as $holiday) {
                $event = [
                    'start'     => Carbon::createFromFormat('d/m/Y', $holiday->from_date)->format('Y-m-d'),
                    'title'     => $holiday->title,
                    'event_id'  => $holiday->id,
                    'className' => 'm-fc-event--info m-fc-event--solid-metal holiday-event p-1',
                ];

                if (!empty($holiday->to_date)) {
                    $event['end'] = Carbon::createFromFormat('d/m/Y', $holiday->to_date)->addDay()->format('Y-m-d');
                }

                $events[] = $event;
            }
        }

        return $events;
    }

    /**
     * @param $query
     *
     * @return void
     */
    protected function applyUserFilters(&$query)
    {
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();

            if (in_array($user->user_group_id, [4, 11])) {
                // Teacher
                $query->where('teacher_id', $user->teacher->id);
            } elseif ($user->user_group_id == 12) {
                // Department head
                $query->whereHas('subject', function ($q) use ($user) {
                    $q->where('department_id', $user->teacher->department_id);
                });
            }
        } elseif (Auth::guard('student_parent')->check()) {
            $authUser = Auth::guard('student_parent')->user();

            $student = $authUser->student ?? $authUser->parent->students->first();

            if ($student) {
                $query->where([
                    ['session_id', $student->session_id],
                    ['course_id', $student->course_id],
                    ['batch_type_id', $student->batch_type_id],
                ]);
            }
        }
    }

    /**
     * @param $query
     * @param $request
     *
     * @return void
     */
    protected function applyRequestFilters(&$query, $request)
    {
        if (!request()->routeIs('class_routine.calendar') && !request()->routeIs('frontend.class_routine.calendar')) {
            $query->when(
                $request->year ?? date('Y'),
                fn($q, $year) => $q->whereYear('class_date', $year)
            );
        }

        $filterables = [
            'session_id',
            'phase_id',
            'term_id',
            'subject_id',
            'class_type_id'
        ];

        foreach ($filterables as $filter) {
            $query->when(
                $request->has($filter) && !empty($request->$filter),
                fn($q) => $q->where($filter, $request->$filter)
            );
        }

        $query->when(
            $request->has('course_id') && !empty($request->course_id),
            fn($q) => $q->whereHas('subject.sessionPhase.sessionDetail', function ($subQuery) use ($request) {
                $subQuery->where('course_id', $request->course_id);
            })
        );

        $query->when(
            $request->has('teacher_id') && !empty($request->teacher_id),
            function ($q) use ($request) {
                $q->where(function ($subQuery) use ($request) {
                    $subQuery->whereIn('class_type_id', [1, 9])
                             ->where('teacher_id', $request->teacher_id)
                             ->orWhere(function ($nestedQuery) use ($request) {
                                 $nestedQuery->whereNotIn('class_type_id', [1, 9])
                                             ->whereHas('studentGroupTeacher', function ($q) use ($request) {
                                                 $q->where('teacher_id', $request->teacher_id);
                                             });
                             });
                });
            }
        );

        $this->applyDateFilters($query, $request);
    }

    /**
     * @param $query
     * @param $request
     *
     * @return void
     */
    protected function applyDateFilters(&$query, $request)
    {
        $startDate = $request->start_date
            ? Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d')
            : null;

        $endDate = $request->end_date
            ? Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d')
            : null;

        if ($startDate && $endDate) {
            $query->whereBetween('class_date', [$startDate, $endDate]);
        } elseif ($startDate) {
            $query->where('class_date', '>=', $startDate);
        } elseif ($endDate) {
            $query->where('class_date', '<=', $endDate);
        }
    }

    public function getClassesById($request, $id, $isSpecificRoutine = 'false')
    {
        $class = $this->find($id);
        //if class type is lecture or revised
        if ($class->class_type_id == 1 || $class->class_type_id == 9) {
            $query = $this->model->with('teacher', 'hall', 'attendances')
                                 ->withCount('attendances')
                                 ->where('session_id', $class->session_id)
                                 ->where('course_id', $class->course_id)
                                 ->where('phase_id', $class->phase_id)
                                 ->where('term_id', $class->term_id)
                                 ->where('subject_id', $class->subject_id)
                                 ->where('class_type_id', $class->class_type_id)
                                 ->where('teacher_id', $class->teacher_id)
                                 ->whereYear('class_date', getDayYear($class->class_date))
                                 ->orderBy('status', 'DESC')
                                 ->orderBy('attendances_count', 'ASC')
                                 ->orderBy('class_date', 'DESC');
            if ($isSpecificRoutine == 'true') {
                $query->where('id', $id);
            }

            // teacher, department head, teacher with extra role
            if (Auth::guard('web')->check()) {
                $user = Auth::guard('web')->user();
                if ($user->user_group_id == 4 || $user->user_group_id == 11) {
                    $query = $query->where('teacher_id', $user->teacher->id);
                } elseif ($user->user_group_id == 12) {
                    //department head
                    $query = $query->whereHas('subject', function ($q) use ($user) {
                        $q->where('department_id', $user->teacher->department_id);
                    });
                }
            }
        } else { //if class type is practical
            $query = $this->model->with('teacher', 'hall', 'attendances')
                                 ->withCount('attendances')
                                 ->where('session_id', $class->session_id)
                                 ->where('batch_type_id', $class->batch_type_id)
                                 ->where('phase_id', $class->phase_id)
                                 ->where('term_id', $class->term_id)
                                 ->where('subject_id', $class->subject_id)
                                 ->where('class_type_id', $class->class_type_id)
                                 ->whereYear('class_date', getDayYear($class->class_date))
                                 ->orderBy('status', 'DESC')
                                 ->orderBy('attendances_count', 'ASC')
                                 ->orderBy('class_date', 'ASC');
            if ($isSpecificRoutine == 'true') {
                $query->where('id', $id);
            }
            if (Auth::guard('web')->check()) {
                $user = Auth::guard('web')->user();
                if (in_array($user->user_group_id, [4, 11])) {
                    $query = $query->whereHas('studentGroupTeacher', function ($q) use ($user) {
                        $q->where('teacher_id', $user->teacher->id);
                    });
                } elseif ($user->user_group_id == 12) {
                    //department head
                    $query = $query->whereHas('subject', function ($q) use ($user) {
                        $q->where('department_id', $user->teacher->department_id);
                    });
                }
            }
        }

        return Datatables::of($query)
                         ->addColumn('id', function ($row) {
                             return $row->id;
                         })
                         ->editColumn('teacher_id', function ($row) {
                             $teachers = '';
                             if (isset($row->studentGroupTeacher) && $row->studentGroupTeacher->isNotEmpty()) {
                                 foreach ($row->studentGroupTeacher as $key => $teacher) {
                                     $teachers = $teacher->full_name . ' (' . $row->studentGroup[$key]->group_name . ')<br>';
                                 }
                             } else {
                                 $teachers = isset($row->teacher) ? $row->teacher->full_name : '--';
                             }

                             return $teachers;
                         })
                         ->editColumn('class_date', function ($row) {
                             return date('d M, Y', strtotime($row->class_date));
                         })
                         ->addColumn('class_time', function ($row) {
                             return $row->class_time;
                         })
                         ->addColumn('topic_id', function ($row) {
                             return isset($row->topic) ? $row->topic->title : '';
                         })
                         ->addColumn('hall_id', function ($row) {
                             return isset($row->hall) ? $row->hall->title : '';
                         })
                         ->editColumn('status', function ($row) {
                             return setStatus($row->status, 'class');
                         })
                         ->addColumn('action', function ($row) {
                             // Cache checks to avoid multiple evaluations
                             $hasAttendance = !empty($row->attendances->toArray());
                             $canEdit       = hasPermission('class_routine/edit');
                             $canView       = hasPermission('class_routine/view');
                             $canSuspend = !$hasAttendance && canUserEditClass($row);

                             $actions = '<button data-id="' . $row->id . '"
                                                     data-status="' . $row->status . '"
                                                     data-remarks="' . ($row->remarks ?? '') . '"
                                                     data-can-suspend="' . $canSuspend . '"
                                                     class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill change-status-btn"
                                                     title="Change Status">
                                                <i class="fa fa-cog"></i>
                                              </button>';

                             // Edit button (shown when has edit permission and no attendance records)
                             if ($canEdit && !$hasAttendance) {
                                 $actions .= '<a href="' . route('class_routine.edit.single', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>';
                             }

                             // View button (shown when has view permission and class is active)
                             if ($canView && $row->status == 1) {
                                 $actions .= '<a href="' . route(customRoute('class_routine.info.single'), [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View"><i class="flaticon-eye"></i></a>';
                             }

                             return $actions;
                         })
                         ->rawColumns(['teacher_id', 'status', 'action'])
                         ->filter(function ($query) use ($request) {
                             if (!empty($request->get('session_id'))) {
                                 $query->where('session_id', $request->get('session_id'));
                             }
                             if (!empty($request->get('course_id'))) {
                                 $query->wherehas('subject.subjectGroup', function ($q) use ($request) {
                                     return $q->where('course_id', $request->get('course_id'));
                                 });
                             }
                             if (!empty($request->get('year'))) {
                                 $query->whereYear('class_date', $request->get('year'));
                             }
                             if (!empty($request->get('phase_id'))) {
                                 $query->where('phase_id', $request->get('phase_id'));
                             }
                         })
                         ->make(true);
    }

    /**
     * @param $request
     *
     * @return int
     */
    public function checkClassRoutineExist($request)
    {
        $selectedDays = explode(',', $request->days);
        $total        = 0;

        if ($request->class_type_id != 9) {
            $days = [];
            foreach ($selectedDays as $day) {
                if ($day == 1) {
                    $selectedDay = Carbon::SATURDAY;
                } elseif ($day == 2) {
                    $selectedDay = Carbon::SUNDAY;
                } elseif ($day == 3) {
                    $selectedDay = Carbon::MONDAY;
                } elseif ($day == 4) {
                    $selectedDay = Carbon::TUESDAY;
                } elseif ($day == 5) {
                    $selectedDay = Carbon::WEDNESDAY;
                } elseif ($day == 6) {
                    $selectedDay = Carbon::THURSDAY;
                } else {
                    $selectedDay = Carbon::FRIDAY;
                }

                $startDate = Carbon::createFromFormat('d/m/Y', $request->start_date)->next($selectedDay)->format('Y-m-d');
                $endDate   = Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d');

                for ($date = Carbon::parse($startDate); $date->lte($endDate); $date->addWeek()) {
                    $days[] = $date->format('Y-m-d');
                }
            }

            $days = empty($days) ? [$request->start_date] : $days;
            $id   = isset($request->id) ? $request->id : '';
            if ($request->onEvent == 'add') {
                $query = $this->model->where('status', 1)->where('phase_id', $request->phase_id)->where('term_id', $request->term_id)->where('class_type_id', $request->class_type_id)
                                     ->where('subject_id', $request->subject_id)
                                     ->whereIn('class_date', $days)
                                     ->where(function ($q) use ($request) {
                                         $q->whereRaw('? BETWEEN start_from AND end_at', $request->start_time)
                                           ->orwhereRaw('? BETWEEN start_from AND end_at', $request->end_time);
                                     });
                //filter class routine by student group
                $query->whereHas('studentGroup', function ($query) use ($request) {
                    //convert student group to array
                    $studentGroupIds = [$request->student_groups];
                    $query->whereIn('student_group_id', $studentGroupIds);
                });
            } else {
                $query = $this->model->where('status', 1)->where('phase_id', $request->phase_id)->where('class_type_id', $request->class_type_id)
                                     ->where('subject_id', '<>', $request->subject_id)
                                     ->whereIn('class_date', $days)
                                     ->where(function ($q) use ($request) {
                                         $q->whereRaw('? BETWEEN start_from AND end_at', $request->start_time)
                                           ->orwhereRaw('? BETWEEN start_from AND end_at', $request->end_time);
                                     });
            }
            if (!empty($id)) {
                $query = $query->where('id', '<>', $id);
            }
            $query = $query->whereHas('session', function ($q) use ($request) {
                $q->where('session_id', $request->session_id);
            });
            $total = $query->count();
        }
        return $total;
    }

    /**
     * @param $request
     *
     * @return array
     */
    public function checkClassRoutineExistNew($request)
    {
        $conflicts = ['students' => false, 'teacher' => false];

        // Extract and validate selected days
        $selectedDays = $this->getSelectedDays($request);

        // Generate date range for selected days
        $days = $this->generateDateRange($request, $selectedDays);

        // Get group-related IDs if applicable
        [$groupStudentIds, $groupTeacherIds] = $this->getGroupRelatedIds($request);

        // Build and execute conflict detection query
        $query = $this->buildConflictQuery($request, $days, $groupStudentIds, $groupTeacherIds);

        // Check for conflicts
        return $this->detectConflicts($query, $request, $conflicts);
    }

    /**
     * Extract selected days based on event type
     */
    private function getSelectedDays($request): array
    {
        if (isset($request->onEvent) && $request->onEvent === 'individual-edit') {
            $isoDay = Carbon::createFromFormat('d/m/Y', $request->class_date)->dayOfWeekIso;
            // Map ISO day (1-7: Mon-Sun) to custom day (1-7: Sat-Fri)
            $map = [1 => 3, 2 => 4, 3 => 5, 4 => 6, 5 => 7, 6 => 1, 7 => 2];
            return [$map[$isoDay]];
        }

        return is_array($request->days) ? $request->days : explode(',', $request->days);
    }

    /**
     * Generate array of dates for selected days within date range
     */
    private function generateDateRange($request, array $selectedDays): array
    {
        $carbonDayMap = [
            1 => CarbonInterface::SATURDAY,
            2 => CarbonInterface::SUNDAY,
            3 => CarbonInterface::MONDAY,
            4 => CarbonInterface::TUESDAY,
            5 => CarbonInterface::WEDNESDAY,
            6 => CarbonInterface::THURSDAY,
            7 => CarbonInterface::FRIDAY,
        ];

        $startDate = Carbon::createFromFormat('d/m/Y', $request->start_date);
        $endDate = Carbon::createFromFormat('d/m/Y', $request->end_date);
        $days = [];

        foreach ($selectedDays as $day) {
            $selectedDay = $carbonDayMap[$day];
            $current = $startDate->copy();

            // Move to first occurrence of selected day
            if ($current->dayOfWeek !== $selectedDay) {
                $current->next($selectedDay);
            }

            // Collect all occurrences within range
            while ($current->lte($endDate)) {
                $days[] = $current->format('Y-m-d');
                $current->addWeek();
            }
        }

        return empty($days) ? [$request->start_date] : $days;
    }

    /**
     * Get student and teacher IDs from groups
     */
    private function getGroupRelatedIds($request): array
    {
        if (empty($request->student_groups)) {
            return [[], []];
        }

        $studentGroupIds = is_array($request->student_groups)
            ? $request->student_groups
            : [$request->student_groups];

        // Use single query with join for better performance
        $groupStudentIds = DB::table('student_group_students')
                             ->whereIn('student_group_id', $studentGroupIds)
                             ->distinct()
                             ->pluck('student_id')
                             ->toArray();

        $groupTeacherIds = DB::table('class_routine_student_groups')
                             ->whereIn('student_group_id', $studentGroupIds)
                             ->distinct()
                             ->pluck('teacher_id')
                             ->toArray();

        return [$groupStudentIds, $groupTeacherIds];
    }

    /**
     * Build the conflict detection query
     */
    private function buildConflictQuery($request, array $days, array $groupStudentIds, array $groupTeacherIds)
    {
        $id = $request->id ?? null;

        $query = $this->model
            ->where('status', 1)
            ->whereIn('class_date', $days)
            ->where(function ($q) use ($request) {
                // Check for time overlap: (start < other_end) AND (end > other_start)
                $q->where('start_from', '<', $request->end_time)
                  ->where('end_at', '>', $request->start_time);
            });

        // Exclude current record if editing
        if ($id) {
            $query->where('id', '!=', $id);
        }

        // Add filters based on available data
        if (!empty($request->session_id)) {
            $query->where('session_id', $request->session_id)
                  ->where('course_id', $request->course_id)
                  ->where('phase_id', $request->phase_id)
                  ->where('subject_id', $request->subject_id);
        }

        if (!empty($groupStudentIds)) {
            $query->whereHas('studentGroup.students', function ($q) use ($groupStudentIds) {
                $q->whereIn('students.id', $groupStudentIds);
            });
        }

        // Add teacher filters
        $teacherIds = array_filter([
            $request->teacher_id ?? null,
            ...$groupTeacherIds
        ]);

        if (!empty($teacherIds)) {
            $query->where(function ($q) use ($teacherIds, $request) {
                $q->whereIn('teacher_id', $teacherIds)
                  ->orWhereHas('studentGroupTeacher', function ($sq) use ($teacherIds) {
                      $sq->whereIn('teacher_id', $teacherIds);
                  });
            });
        }

        return $query;
    }

    /**
     * Detect and categorize conflicts
     */
    private function detectConflicts($query, $request, array $conflicts): array
    {
        $results = $query->get(['id', 'teacher_id']); // Only fetch needed columns

        if ($results->isEmpty()) {
            return $conflicts;
        }

        // Student conflicts exist if any records found
        $conflicts['students'] = true;

        // Check for teacher conflicts
        if (!empty($request->teacher_id)) {
            $conflicts['teacher'] = $results->contains('teacher_id', $request->teacher_id);
        }

        return $conflicts;
    }

    /**
     * @param $sessionId
     * @param $batchId
     * @param $phaseId
     * @param $termId
     * @param $subjectId
     *
     * @return mixed
     */
    public function getClassesBySessionBatchPhaseTermSubject($sessionId, $batchId, $phaseId, $termId, $subjectId)
    {
        return $this->model->where('session_id', $sessionId)->where('batch_type_id', $batchId)
                           ->where('phase_id', $phaseId)->where('term_id', $termId)->where('subject_id', $subjectId)
                           ->get();
    }

    /**
     * @param $sessionId
     * @param $batchId
     * @param $phaseId
     * @param $termId
     * @param $subjectId
     *
     * @return mixed
     */
    public function getMinMaxDateBySessionBatchPhaseTermSubject($sessionId, $batchId, $phaseId, $termId, $subjectId)
    {
        return $this->model->where('session_id', $sessionId)->where('batch_type_id', $batchId)
                           ->where('phase_id', $phaseId)->where('term_id', $termId)->where('subject_id', $subjectId)
                           ->select(DB::raw('MIN(class_date) min_date'), DB::raw('MAX(class_date) max_date'))
                           ->first();
    }

    public function getMinMaxDateBySessionCoursePhaseTerm($sessionId, $courseId, $phaseId, $termId, $subjectId)
    {
        return $this->model->where('session_id', $sessionId)->where('course_id', $courseId)
                           ->where('phase_id', $phaseId)->where('term_id', $termId)->where('subject_id', $subjectId)
                           ->select(DB::raw('MIN(class_date) min_date'), DB::raw('MAX(class_date) max_date'))
                           ->first();
    }

    /**
     * @param $sessionId
     * @param $batchId
     * @param $phaseId
     * @param $termId
     * @param $subjectId
     * @param $type
     *
     * @return mixed
     */
    public function getMinMaxDateBySessionBatchPhaseTermSubjectClassType($sessionId, $batchId, $phaseId, $termId, $subjectId, $type, $teacherId, $date)
    {
        return $this->model->where('session_id', $sessionId)
                           ->where('batch_type_id', $batchId)
                           ->where('phase_id', $phaseId)
                           ->where('term_id', $termId)
                           ->where('subject_id', $subjectId)
                           ->where('class_type_id', $type)
                           ->where('teacher_id', $teacherId)
                           ->select(DB::raw('MIN(class_date) min_date'), DB::raw('MAX(class_date) max_date'))
                           ->first();
    }

    /**
     * @return mixed
     */
    public function getClassTimes()
    {
        return $this->model->groupBy('start_from', 'end_at')->select('start_from', 'end_at')->orderBy('start_from', 'asc')->get();
    }

    public function getWeeklyClasses($request)
    {
        $query = $this->model;

        if ($request->has('session_id') && !empty($request->session_id)) {
            $query = $query->whereIn('session_id', $request->session_id);
        }

        if ($request->has('course_id') && !empty($request->course_id)) {
            $query = $query->where('course_id', $request->course_id);
        }

        $query = $query->groupBy(DB::raw('DAYNAME(`class_date`)'), 'start_from', 'subject_id')->orderBy(DB::raw("FIELD(DAYNAME(`class_date`), 'Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday')"), 'asc')->orderBy('start_from', 'asc');

        return $query->get();
    }

    public function getAllClassRoutine()
    {
        return $this->model->where('status', 1)->get();
    }

    public function getAllClassRoutineBySearchCriteria($sessionId, $courseId, $subjectGroupId, $startDate, $endDate)
    {
        return $this->model->whereHas('subject', function ($query) use ($subjectGroupId) {
            $query->where('subject_group_id', $subjectGroupId);
        })->where([
            ['session_id', $sessionId],
            ['course_id', $courseId],
            ['class_type_id', 1],
            ['status', 1],
        ])->whereBetween('class_date', [$startDate, $endDate])->orderBy('class_date', 'asc')->get();
    }

    public function routineExistBySubjectIdAndDate($subjectId, $date)
    {
        return $this->model->where('subject_id', $subjectId)->whereDate('class_date', $date)->count();
    }

    public function getClassRoutineSessionIdByCourseIdAndPhaseId($courseId, $phaseId)
    {
        return $this->model->where('course_id', $courseId)->where('phase_id', $phaseId)->latest()->first();
    }

    public function getClassesByCoursePhaseAndDate($sessionId, $courseId, $phaseId, $date)
    {
        $query = $this->model->where('course_id', $courseId)->where('session_id', $sessionId)->where('phase_id', $phaseId)
                             ->when($date, function ($q, $date) {
                                 $q->whereDate('class_date', $date);
                             })
                             ->with('subject', 'classType', 'teacher', 'attendances', 'session')
                             ->orderBy('start_from', 'asc');

        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            if ($user->teacher) {
                if ($user->user_group_id == 12) {
                    $query = $query->whereIn('subject_id', getSubjectsIdByDepartmentIdAndCourseId($user->teacher->department_id, $courseId));
                } else {
                    $query = $query->whereIn('subject_id', getSubjectsIdByTeacherId($user->teacher->id, $courseId));
                }
            }
        }

        return Datatables::of($query)
                         ->editColumn('subject_id', function ($row) {
                             return $row->subject->title;
                         })
                         ->editColumn('class_type_id', function ($row) {
                             return $row->classType->title;
                         })
                         ->editColumn('teacher_id', function ($row) {
                             return isset($row->teacher) ? $row->teacher->full_name : '--';
                         })
                         ->editColumn('session_id', function ($row) {
                             return isset($row->session) ? $row->session->title : '--';
                         })
                         ->addColumn('class_time', function ($row) {
                             return $row->class_time;
                         })
                         ->addColumn('action', function ($row) {
                             $actions = '';

                             if (hasPermission('class_routine/edit')) {
                                 if (empty($row->attendances->toArray())) {
                                     $actions .= '<a href="' . route('class_routine.edit.single', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>';
                                 }
                             }

                             if (hasPermission('class_routine/view')) {
                                 $actions .= '<a href="' . route(customRoute('class_routine.info.single'), [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View"><i class="flaticon-eye"></i></a>';
                             }

                             return $actions;
                         })
                         ->rawColumns(['status', 'action'])
                         ->make(true);
    }

    /**
     * @param $sessionId
     * @param $courseId
     * @param $phaseId
     * @param $date
     *
     * @return void
     */
    public function getClassesByCoursePhaseAndWeek($sessionId, $courseId, $phaseId, $date)
    {
        $today        = $date->format('Y-m-d');
        $lastWeekDate = $date->subDays(7)->format('Y-m-d');

        $query = $this->model->where('course_id', $courseId)->where('session_id', $sessionId)->where('phase_id', $phaseId)->whereBetween('class_date', [
            $lastWeekDate, $today
        ])
                             ->with('subject', 'classType', 'teacher', 'attendances')
            //->orderBy('start_from', 'asc')
                             ->orderBy('class_date', 'desc');

        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();

            //department head
            if ($user->teacher) {
                if ($user->user_group_id == 12) {
                    $query = $query->whereIn('subject_id', getSubjectsIdByDepartmentIdAndCourseId($user->teacher->department_id, $courseId));
                } else {
                    $query = $query->whereIn('subject_id', getSubjectsIdByTeacherId($user->teacher->id, $courseId));
                }
            }

            return Datatables::of($query)
                             ->editColumn('subject_id', function ($row) {
                                 return $row->subject->title;
                             })
                             ->editColumn('class_type_id', function ($row) {
                                 return $row->classType->title;
                             })
                             ->editColumn('teacher_id', function ($row) {
                                 return isset($row->teacher) ? $row->teacher->full_name : '--';
                             })
                             ->editColumn('session_id', function ($row) {
                                 return isset($row->session) ? $row->session->title : '--';
                             })
                             ->addColumn('class_time', function ($row) {
                                 return $row->class_time;
                             })
                             ->addColumn('action', function ($row) {
                                 $actions = '';

                                 if (hasPermission('class_routine/edit')) {
                                     if (empty($row->attendances->toArray())) {
                                         $actions .= '<a href="' . route('class_routine.edit.single', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>';
                                     }
                                 }

                                 if (hasPermission('class_routine/view')) {
                                     $actions .= '<a href="' . route(customRoute('class_routine.info.single'), [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View"><i class="flaticon-eye"></i></a>';
                                 }

                                 return $actions;
                             })
                             ->rawColumns(['status', 'action'])
                             ->make(true);
        }
    }

    /**
     * @param $sessionId
     * @param $courseId
     * @param $phaseId
     * @param $subjectId
     *
     * @return mixed
     */
    public function routineExistForSubject($sessionId, $courseId, $phaseId, $subjectId)
    {
        return $this->model->where([
            ['session_id', $sessionId],
            ['course_id', $courseId],
            ['phase_id', $phaseId],
            ['subject_id', $subjectId],
        ])->count();
    }

    public function getTodayClassesBySessionCoursePhaseAndDate($sessionId, $courseId, $phaseId, $date)
    {
        $query = $this->model->where('session_id', $sessionId)->where('course_id', $courseId)->where('phase_id', $phaseId)->whereDate('class_date', $date)
                             ->with('subject', 'classType', 'teacher', 'attendances')
                             ->orderBy('start_from', 'asc');

        return Datatables::of($query)
                         ->editColumn('subject_id', function ($row) {
                             return $row->subject->title;
                         })
                         ->editColumn('class_type_id', function ($row) {
                             return $row->classType->title;
                         })
                         ->editColumn('teacher_id', function ($row) {
                             return isset($row->teacher) ? $row->teacher->full_name : '';
                         })
                         ->editColumn('session_id', function ($row) {
                             return isset($row->session) ? $row->session->title : '';
                         })
                         ->addColumn('class_time', function ($row) {
                             return $row->class_time;
                         })
                         ->addColumn('action', function ($row) {
                             $actions = '';

                             if (hasPermission('class_routine/view')) {
                                 $actions .= '<a href="' . route(customRoute('class_routine.info.single'), [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View"><i class="flaticon-eye"></i></a>';
                             } else {
                                 $actions .= '--';
                             }

                             return $actions;
                         })
                         ->rawColumns(['status', 'action'])
                         ->make(true);
    }

    public function getClassesBySubjectIdAndDateRange($subjectId, $phaseId, $dateStart, $dateEnd)
    {
        return $this->model->where('subject_id', $subjectId)
                           ->where('phase_id', $phaseId)
                           ->whereBetween('class_date', [$dateStart, $dateEnd])
                           ->classAttendance()
                           ->has('attendances')->get();
    }

    /**
     * @param $request
     *
     * @return int
     */
    public function getAllClassDaysWithoutHoliday($request)
    {
        $dates       = [];
        $classDays   = [];
        $hasHolidays = false;

        //decrease 1 day
        $previousDay = Carbon::createFromFormat('d/m/Y', $request->classStartDate)->subDay(1)->format('d/m/Y');

        //all class days among date range
        foreach ($request->selectedClassDays as $day) {
            $dates = array_reduce([
                $dates, generateDatesByDay($day, $previousDay, $request->classEndDate)
            ], 'array_merge', array());
        }

        //all class days among date range excluding holiday
        foreach ($dates as $date) {
            $check = $this->holidayService->getHolidayByDate($date);
            if (empty($check->toArray())) {
                $classDays[] = $date;
            } else {
                $hasHolidays = true;
            }
        }

        return [
            'status' => !$hasHolidays,
            'count'  => count($classDays)
        ];
    }

    public function getAllClassTodayByCourseIdPhaseIdTeacherIdAndDate($sessionId, $courseId, $phaseId, $date)
    {
        $query = $this->model->with([
            'subject', 'classType'
        ])->where('session_id', $sessionId)->where('course_id', $courseId)->where('phase_id', $phaseId)->whereDate('class_date', $date);
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            //department head
            if ($user->teacher) {
                if ($user->user_group_id == 12) {
                    $query = $query->whereIn('subject_id', getSubjectsIdByDepartmentIdAndCourseId($user->teacher->department_id, $courseId));
                } else {
                    $query = $query->whereIn('subject_id', getSubjectsIdByTeacherId($user->teacher->id, $courseId));
                }
            }
        }
        return $query->orderBy('subject_id', 'asc')
            //->orderBy('subject_id', 'asc')
                     ->orderBy('class_type_id', 'asc')
                     ->get();
    }

    public function getAllClassBySessionIdCourseIdPhaseId($sessionId, $courseId, $phaseId, $batchTypeId)
    {
        return $this->model->with(['subject', 'classType'])
                           ->where([
                               ['session_id', $sessionId],
                               ['course_id', $courseId],
                               ['phase_id', $phaseId],
                               ['batch_type_id', $batchTypeId]
                           ])
                           ->groupBy('subject_id')
                           ->groupBy('class_type_id')
                           ->orderBy('subject_id', 'asc')
                           ->orderBy('class_type_id', 'asc')
                           ->get();
    }

    //get last 1 week class attendance
    public function getLastWeekTakenClassesBySessionCoursePhaseAndDateRange($studentId, $sessionId, $courseId, $phaseId, $date)
    {
        $today        = $date->format('Y-m-d');
        $lastWeekDate = $date->subDays(7)->format('Y-m-d');
        //dd($date->format('Y-m-d'));
        $query = $this->model->where('session_id', $sessionId)
                             ->where('course_id', $courseId)->where('phase_id', $phaseId)
                             ->whereBetween('class_date', [$lastWeekDate, $today])
                             ->with('subject', 'classType', 'teacher', 'attendances')
                             ->orderBy('start_from', 'asc');

        $query->whereHas('attendances', function ($q) use ($studentId) {
            $q->where('student_id', $studentId);
        });

        return Datatables::of($query)
                         ->editColumn('subject_id', function ($row) {
                             return $row->subject->title;
                         })
                         ->editColumn('class_type_id', function ($row) {
                             return $row->classType->title;
                         })
                         ->editColumn('class_date', function ($row) {
                             return $row->class_date;
                         })
                         ->addColumn('attendance', function ($row) {
                             if ($row->attendances) {
                                 $loginStudentId = Auth::guard('student_parent')->user()->student->id;
                                 $attendance     = $row->attendances->where('student_id', $loginStudentId)->first()->attendance;
                                 if ($attendance == true) {
                                     return 'Present';
                                 }

                                 return 'Absent';
                             }
                             return '--';
                         })
                         ->editColumn('teacher_id', function ($row) {
                             return isset($row->teacher) ? $row->teacher->full_name : '';
                         })
                         ->editColumn('session_id', function ($row) {
                             return isset($row->session) ? $row->session->title : '';
                         })
                         ->addColumn('class_time', function ($row) {
                             return $row->class_time;
                         })
                         ->addColumn('action', function ($row) {
                             $actions = '';

                             if (hasPermission('class_routine/view')) {
                                 $actions .= '<a href="' . route(customRoute('class_routine.info.single'), [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View"><i class="flaticon-eye"></i></a>';
                             } else {
                                 $actions .= '--';
                             }

                             return $actions;
                         })
                         ->rawColumns(['status', 'action'])
                         ->make(true);
    }

    public function getDailyClassNumberForCurrentMonth($teacherId, $courseId)
    {
        $classRoutine = array();
        if (Auth::guard('web')->check()) {
            $firstOfMonth = now()->firstOfMonth();
            $lastOfMonth  = now()->lastOfMonth();
            //get lecture class routine ids related to teacher id
            $classRoutineIdsOfLectureClass = $this->model->where([
                ['status', 1],
                ['course_id', $courseId],
                ['teacher_id', $teacherId],
            ])->pluck('id');
            //get practical class routine ids related to teacher id
            $classRoutineIdsOfPracticalTypeClass = DB::table('class_routine_student_groups')->where('teacher_id', $teacherId)->pluck('class_routine_id');
            //merge both class ids
            $classRoutineIds = $classRoutineIdsOfLectureClass->merge($classRoutineIdsOfPracticalTypeClass);
            // get classes by class routine ids
            $classes = $this->model->whereIn('id', $classRoutineIds)
                                   ->whereBetween('class_date', [$firstOfMonth, $lastOfMonth])
                                   ->orderBy('class_date', 'asc')->get();
        }
        // class dates
        $classDates = $classes->unique('class_date')->pluck('class_date');
        foreach ($classDates as $classDate) {
            $classRoutine[] = $classes->where('class_date', $classDate)->count();
        }

        return json_encode([
            'classDates'   => $classDates,
            'classRoutine' => $classRoutine
        ]);
    }

    /**
     * @param $teacherId
     * @param $courseId
     *
     * @return string
     */
    public function getTotalClassByTeacherIdAndCourseId($teacherId, $courseId)
    {
        $classRoutineCount = '';
        if (Auth::guard('web')->check()) {
            //get class count related to teacher id
            $classRoutineCount = $this->model->where([
                ['status', 1],
                ['course_id', $courseId],
                ['teacher_id', $teacherId],
            ])->count();
        }
        return $classRoutineCount;
    }
}
