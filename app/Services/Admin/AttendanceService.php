<?php
/**
 * Created by PhpStorm.
 * User: office
 * Date: 3/4/19
 * Time: 10:52 AM
 */

namespace App\Services\Admin;


use App\Models\Attencance;
use App\Models\ClassRoutine;
use App\Models\Student;
use App\Services\BaseService;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AttendanceService extends BaseService
{

    protected $classRoutine;

    public function __construct(Attencance $attencance, ClassRoutine $classRoutine)
    {
        $this->model        = $attencance;
        $this->classRoutine = $classRoutine;
    }

    public function addAttendance($request, $students, $oldStudents, $routine)
    {
        // Merge students and old students into arrays of IDs
        $students    = $students ? $students->pluck('id')->toArray() : [];
        $oldStudents = $oldStudents ? $oldStudents->pluck('id')->toArray() : [];

        // Merge students and old students into a single array
        $targetStudents = array_merge($students, $oldStudents);

        // Determine attendance students based on request data
        $attendStudents = $request->students ?: [];
        if ($request->old_students) {
            $attendStudents = array_merge($attendStudents, $request->old_students);
        }

        // Create attendance records for all target students
        $attendanceRecords = [];
        foreach ($targetStudents as $studentId) {
            $attendance          = in_array($studentId, $attendStudents);
            $attendanceRecords[] = [
                'student_id'       => $studentId,
                'class_routine_id' => $request->class_routine_id,
                'attendance'       => $attendance,
            ];
        }

        // Create attendance records
        $routine->attendances()->createMany($attendanceRecords);

        // Update remarks if comment is provided
        if ($request->comment) {
            $routine->remarks = $request->comment;
            $routine->save();
        }
        return true;
    }


    public function getDataTable($request)
    {
        $query = $this->model->with([
            'student', 'classRoutine', 'classRoutine.topic', 'classRoutine.subject', 'classRoutine.teacher',
            'classRoutine.classType'
        ]);

        if (Auth::guard('student_parent')->check()) {
            $user = Auth::guard('student_parent')->user();
            if ($user->student) {
                $query = $query->whereHas('student', function ($q) use ($user) {
                    $q->where('id', $user->student->id);
                });
            } else {
                $query = $query->whereHas('student', function ($q) use ($user) {
                    $q->whereIn('id', getStudentsIdByParentId($user->parent->id));
                });
            }
        } else if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();

            if ($user->teacher) {
                if ($user->user_group_id == 12) {
                    //department head get all teacher of department
                    $query = $query->whereHas('classRoutine.teacher', function ($q) use ($user) {
                        $q->where('department_id', $user->teacher->department_id);
                    });
                } else {
                    $query = $query->whereHas('classRoutine.teacher', function ($q) use ($user) {
                        $q->where([
                            ['id', $user->teacher->id],
                            ['department_id', $user->teacher->department_id],
                        ]);
                    });
                }
            }
        }
        $query = $query->latest();

        return Datatables::of($query)
                         ->addColumn('student_roll', function ($row) {
                             if (isset($row->student)) {
                                 return $row->student->roll_no;
                             }
                         })
                         ->editColumn('student_id', function ($row) {
                             if (isset($row->student)) {
                                 return '<a href="' . route(customRoute('students.show'), [$row->student_id]) . '">' . $row->student->full_name_en . '</a>';
                             }
                         })
                         ->addColumn('subject_id', function ($row) {
                             if (isset($row->classRoutine)) {
                                 return '<a href="' . route(customRoute('subject.show'), [$row->classRoutine->subject_id]) . '">' . $row->classRoutine->subject->title . '</a>';
                             }
                         })
                         ->editColumn('subject_topic', function ($row) {
                             if (isset($row->classRoutine)) {
                                 if (isset($row->classRoutine->topic)) {
                                     if (Auth::guard('student_parent')->check()) {
                                         $user = Auth::guard('student_parent')->user();
                                         return $row->classRoutine->topic->title;
                                         /*if($user->user_group_id == 5 or $user->user_group_id == 6){
                                             return $row->classRoutine->topic->title;
                                         }*/
                                     }

                                     return '<a target="_blank" href="' . route('topic.show', [$row->classRoutine->topic_id]) . '">' . Str::limit($row->classRoutine->topic->title, 25) . '</a>';
                                 }

                                 return '--';
                             }
                         })
                         ->addColumn('class_type', function ($row) {
                             if (isset($row->classRoutine)) {
                                 return $row->classRoutine->classType->title;
                             }
                         })
                         ->addColumn('class_teacher', function ($row) {
                             if (isset($row->classRoutine)) {
                                 if ($row->classRoutine->teacher) {
                                     return '<a href="' . route(customRoute('teacher.show'), [$row->classRoutine->teacher_id]) . '">' . $row->classRoutine->teacher->first_name . '</a>';
                                     //return $row->classRoutine->teacher->first_name;
                                 }

                                 return '--';
                             }
                         })
                         ->editColumn('attendance', function ($row) {
                             return $row->attendance_status;
                         })
                         ->editColumn('created_at', function ($row) {
                             return Carbon::parse($row->created_at)->format('d/m/Y');
                         })
                         ->addColumn('class_date', function ($row) {
                             if (isset($row->classRoutine)) {
                                 $classDate = $classDate = Carbon::createFromFormat('Y-m-d', $row->classRoutine->class_date)->format('d/m/Y');
                                 return $classDate;
                             }

                             return '--';
                         })
                         ->addColumn('action', function ($row) {
                             $actions       = '';
                             $user          = Auth::guard('web')->user();
                             $authorizeUser = isset($user->adminUser) && $user->adminUser->designation_id === 32;

                             if (hasPermission('attendance/edit') && $authorizeUser) {
                                 $actions .= '<a href="#"
                        class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill edit-attendance"
                        data-attendance-id="' . $row->id . '" data-routine-id="' . $row->class_routine_id . '"
                        data-attendance-status="' . (!empty($row->attendance) ? $row->attendance : 0) . '"
                        title="Edit"><i class="flaticon-edit"></i></a>';
                             } else {
                                 $actions = '--';
                             }

                             return $actions;
                         })
                         ->rawColumns([
                             'student_id', 'subject_topic', 'subject_id', 'class_teacher', 'attendance', 'action'
                         ])
                         ->filter(function ($query) use ($request) {
                             if (!empty($request->get('session_id'))) {
                                 $query->whereHas('classRoutine', function ($q) use ($request) {
                                     return $q->where('session_id', $request->get('session_id'));
                                 });
                             }
                             if (!empty($request->get('course_id'))) {
                                 $query->whereHas('classRoutine', function ($q) use ($request) {
                                     return $q->where('course_id', $request->get('course_id'));
                                 });
                             }
                             if (!empty($request->get('phase_id'))) {
                                 $query->whereHas('classRoutine', function ($q) use ($request) {
                                     return $q->where('phase_id', $request->get('phase_id'));
                                 });
                             }

                             if (!empty($request->get('term_id'))) {
                                 $query->whereHas('classRoutine', function ($q) use ($request) {
                                     return $q->where('term_id', $request->get('term_id'));
                                 });
                             }

                             if (!empty($request->get('subject_id'))) {
                                 $query->whereHas('classRoutine', function ($q) use ($request) {
                                     return $q->where('subject_id', $request->get('subject_id'));
                                 });
                             }

                             if (!empty($request->get('teacher_id'))) {
                                 $query->whereHas('classRoutine', function ($q) use ($request) {
                                     return $q->where('teacher_id', $request->get('teacher_id'));
                                 });
                             }

                             if (!empty($request->get('class_type_id'))) {
                                 $query->whereHas('classRoutine', function ($q) use ($request) {
                                     return $q->where('class_type_id', $request->get('class_type_id'));
                                 });
                             }
                             if (!empty($request->get('class_date'))) {
                                 $query->whereHas('classRoutine', function ($q) use ($request) {
                                     $classDate = Carbon::createFromFormat('d/m/Y', $request->get('class_date'))->format('Y-m-d');
                                     return $q->whereDate('class_date', $classDate);
                                 });
                             }

                             if (!empty($request->get('roll_no'))) {
                                 $query->whereHas('student', function ($q) use ($request) {
                                     return $q->where('roll_no', $request->get('roll_no'));
                                 });
                             }
                             if (!empty($request->get('full_name_en'))) {
                                 $query->whereHas('student', function ($q) use ($request) {
                                     return $q->where('full_name_en', 'like', '%' . $request->get('full_name_en') . '%');
                                 });
                             }

                             if (!empty($request->get('attendance'))) {
                                 $attendanceStatus = $request->get('attendance');
                                 if ($attendanceStatus == 'present') {
                                     $query->where('attendance', 1);
                                 } else {
                                     $query->where('attendance', 0);
                                 }
                             }
                         })
                         ->make(true);
    }

    public function getAttendanceDataByRoutineId($classRoutineId)
    {
        $classRoutine = $this->classRoutine->find($classRoutineId);
        if (Auth::guard('web')->check()) {
            $query = $this->model->with('student')->where('class_routine_id', $classRoutineId)->get();
        } elseif (Auth::guard('student_parent')->check()) {
            $user = Auth::guard('student_parent')->user();
            if ($user->user_group_id == 5) {
                $query = $this->model->with('student')->where('class_routine_id', $classRoutineId)
                                     ->whereHas('student', function ($q) use ($user) {
                                         $q->where('id', $user->student->id);
                                     })->get();
            } else {
                $query = $this->model->with('student')->where('class_routine_id', $classRoutineId)
                                     ->whereHas('student', function ($q) use ($user) {
                                         $q->whereIn('id', getStudentsIdByParentId($user->parent->id));
                                     })->get();
            }
        }

        //get students id those student group are assigned to current login teacher
        // practical Class
        if ($classRoutine->class_type_id != 1 && $classRoutine->class_type_id != 9 && $classRoutine->class_type_id != 17) {
            $authUser   = Auth::guard('web')->user();
            $studentIds = [];

            if (!empty($authUser->teacher)) {
                $loginTeacherId = $authUser->teacher->id;
                $query          = $this->model->with('student', 'classRoutine.subject', 'classRoutine.studentGroup')->where('class_routine_id', $classRoutineId);

                if ($query->count() != 0) {
                    $attendanceStudentGroups = $query->first()->classRoutine->studentGroup;
                    foreach ($attendanceStudentGroups as $attendanceStudentGroup) {
                        if ($attendanceStudentGroup->pivot->teacher_id == $loginTeacherId) {
                            $students = $attendanceStudentGroup->students;
                            foreach ($students as $student) {
                                $studentIds[] = $student->id;
                            }
                        }
                    }
                }
            }

            //get all student by roll range
            if (isset($studentIds) && !empty($studentIds) && $authUser->teacher) {
                $query = $this->model->where('class_routine_id', $classRoutineId)->whereIn('student_id', $studentIds);
            }
        }

        return $query;
    }

    public function getAttendanceListByRoutineId($request, $id)
    {
        $classRoutine = $this->classRoutine->find($id);
        if (Auth::guard('web')->check()) {
            $query = $this->model->with('student', 'classRoutine.subject')->where('class_routine_id', $id)->get();
        } elseif (Auth::guard('student_parent')->check()) {
            $user = Auth::guard('student_parent')->user();
            if ($user->user_group_id == 5) {
                $query = $this->model->with('student', 'classRoutine.subject')->where('class_routine_id', $id)
                                     ->whereHas('student', function ($q) use ($user) {
                                         $q->where('id', $user->student->id);
                                     })->get();
            } else {
                $query = $this->model->with('student', 'classRoutine.subject')->where('class_routine_id', $id)
                                     ->whereHas('student', function ($q) use ($user) {
                                         $q->whereIn('id', getStudentsIdByParentId($user->parent->id));
                                     })->get();
            }
        }

        //get students id those student group are assigned to current login teacher
        // practical Class
        if ($classRoutine->class_type_id != 1 && $classRoutine->class_type_id != 9 && $classRoutine->class_type_id != 17) {
            $authUser   = Auth::guard('web')->user();
            $studentIds = array();

            if (!empty($authUser->teacher)) {
                $loginTeacherId = $authUser->teacher->id;
                $query          = $this->model->with('student', 'classRoutine.subject', 'classRoutine.studentGroup')->where('class_routine_id', $id);
                if ($query->count() != 0) {
                    $attendanceStudentGroups = $query->first()->classRoutine->studentGroup;
                    foreach ($attendanceStudentGroups as $attendanceStudentGroup) {
                        if ($attendanceStudentGroup->pivot->teacher_id == $loginTeacherId) {
                            $students = $attendanceStudentGroup->students;
                            foreach ($students as $student) {
                                $studentIds[] = $student->id;
                            }
                        }
                    }
                }
            }

            //get all student by roll range
            if (isset($studentIds) && !empty($studentIds) && $authUser->teacher) {
                $query = $this->model->where('class_routine_id', $id)->whereIn('student_id', $studentIds);
            }
        }

        return Datatables::of($query)
                         ->escapeColumns([])
                         ->addColumn('check', function ($row) {
                             $userGroupId = Auth::guard('web')->user()->user_group_id;

                             if ($row->attendance == false && ($userGroupId == 1 || $userGroupId == 2 || $userGroupId == 11 || $userGroupId == 12)) {
                                 return sprintf('<input type="checkbox" data-attendance-id="' . $row->id . '" data-routine-id="' . $row->class_routine_id . '"
                        data-attendance-status="' . (!empty($row->attendance) ? $row->attendance : 0) . '" class="bulk_record" id="checkbox_%s" name="check[]" value="%s">', $row->id, $row->id);
                             }

                             return '';
                         })
                         ->editColumn('student_id', function ($row) {
                             return '<a href="' . route(customRoute('students.show'), [$row->student_id]) . '">' . $row->student->full_name_en . '</a>';
                         })
                         ->editColumn('subject_id', function ($row) {
                             return '<a href="' . route(customRoute('subject.show'), [$row->classRoutine->subject_id]) . '">' . $row->classRoutine->subject->title . '</a>';
                         })
                         ->editColumn('attendance', function ($row) {
                             return $row->attendance_status;
                         })
                         ->addColumn('roll_no', function ($row) {
                             return $row->student->roll_no;
                         })
                         ->addColumn('send_sms', function ($row) {
                             return ($row->send_sms) ? '<span class="m-badge m-badge--success">Yes</span>' : '<span class="m-badge m-badge--danger">No</span>';
                         })
                         ->addColumn('action', function ($row) use ($classRoutine) {
                             $actions          = '';
                             $user             = Auth::guard('web')->user();
                             $userGroupId      = Auth::guard('web')->user()->user_group_id;
                             $authorizeUser    = isset($user->adminUser) && $user->adminUser->designation_id === 32;
                             $authorizeTeacher = isset($user->teacher) && $user->teacher->id == $classRoutine->teacher_id;

                             if (hasPermission('attendance/edit') && ($authorizeUser || $authorizeTeacher || $userGroupId == 1 || $userGroupId == 12)) {
                                 $actions .= '<a href="#"
                        class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill edit-attendance"
                        data-attendance-id="' . $row->id . '" data-routine-id="' . $row->class_routine_id . '"
                        data-attendance-status="' . (!empty($row->attendance) ? $row->attendance : 0) . '"
                        title="Edit"><i class="flaticon-edit"></i></a>';
                             }
                             if ($row->attendance == false && ($userGroupId == 1 || $userGroupId == 2 || $userGroupId == 11 || $userGroupId == 12)) {
                                 //get authenticate user
                                 $actions .= '<a href="#"
                        class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill send-attendance-sms"
                        data-attendance-id="' . $row->id . '" data-routine-id="' . $row->class_routine_id . '"
                        data-attendance-status="' . (!empty($row->attendance) ? $row->attendance : 0) . '"
                        title="SMS / Email"><i class="fa fa-envelope"></i></a>';
                             } else {
                                 $actions .= '';
                             }
                             return $actions;
                         })
                         ->rawColumns(['check', 'student_id', 'roll_no', 'subject_id', 'attendance', 'action'])
                         ->make(true);
    }

    public function getTotalClass($sessionId, $courseId, $phaseId, $termId, $subjectId, array $classTypeId, $notIn = false)
    {
        $query = $this->classRoutine->has('attendances')->where('session_id', $sessionId)->where('course_id', $courseId);

        if (!empty($phaseId)) {
            $query = $query->where('phase_id', $phaseId);
        }
        if (!empty($termId)) {
            $query = $query->where('term_id', $termId);
        }
        if (!empty($subjectId)) {
            $query = $query->where('subject_id', $subjectId);
        }
        if (!empty($classTypeId)) {
            if ($notIn == true) {
                $query = $query->whereNotIn('class_type_id', $classTypeId);
            } else {
                $query = $query->whereIn('class_type_id', $classTypeId);
            }
        }

        return $query->count();
    }

    public function getTotalTutorialClassBySubjectGroupId($sessionId, $courseId, $phaseId, $termId, $subjectGroupId, array $classTypeId, $notIn = false, $start_date = null, $end_date = null, $studentId)
    {
        $query = $this->model->where('student_id', $studentId)
                             ->whereHas('classRoutine', function ($q) use ($sessionId, $courseId, $phaseId, $termId, $subjectGroupId, $classTypeId, $notIn, $start_date, $end_date) {
                                 $q->where('session_id', $sessionId)
                                   ->where('course_id', $courseId);
                                 if (!empty($phaseId)) {
                                     $q = $q->where('phase_id', $phaseId);
                                 }
                                 if (!empty($termId)) {
                                     $q = $q->where('term_id', $termId);
                                 }
                                 if (!empty($subjectGroupId)) {
                                     $q = $q->whereHas('subject', function ($s) use ($subjectGroupId) {
                                         $s->where('subject_group_id', $subjectGroupId);
                                     });
                                 }
                                 if ($start_date) {
                                     $start_date = Carbon::createFromFormat('d/m/Y', $start_date)->format('Y-m-d');
                                     $q          = $q->where('class_date', '>=', $start_date);
                                 }
                                 if ($end_date) {
                                     $end_date = Carbon::createFromFormat('d/m/Y', $end_date)->format('Y-m-d');
                                     $q        = $q->where('class_date', '<=', $end_date);
                                 }
                                 if (!empty($classTypeId)) {
                                     if ($notIn == true) {
                                         $q = $q->whereIn('class_type_id', $classTypeId);
                                     } else {
                                         $q = $q->whereNotIn('class_type_id', $classTypeId);
                                     }
                                 }
                             })
                             ->count();
        return $query;
    }

    public function getTotalClassBySubjectGroupId($sessionId, $courseId, $phaseId, $termId, $subjectGroupId, array $classTypeId, $notIn = false, $start_date = null, $end_date = null, $student_group_id = null)
    {
        $query = $this->classRoutine->where('status', 1)->whereHas('attendances', function ($q) use ($student_group_id) {
            if ($student_group_id) {
                $q->whereIn('student_id', function ($s) use ($student_group_id) {
                    $s->select('student_id')
                      ->from('student_group_students')
                      ->where('student_group_id', $student_group_id);
                });
            }
        })
                                    ->where('session_id', $sessionId)->where('course_id', $courseId);
        if (!empty($phaseId)) {
            $query = $query->where('phase_id', $phaseId);
        }
        if (!empty($termId)) {
            $query = $query->where('term_id', $termId);
        }
        if (!empty($subjectGroupId)) {
            $query = $query->whereHas('subject', function ($q) use ($subjectGroupId) {
                $q->where('subject_group_id', $subjectGroupId);
            });
        }
        if ($start_date) {
            $start_date = Carbon::createFromFormat('d/m/Y', $start_date)->format('Y-m-d');
            $query      = $query->where('class_date', '>=', $start_date);
        }
        if ($end_date) {
            $end_date = Carbon::createFromFormat('d/m/Y', $end_date)->format('Y-m-d');
            $query    = $query->where('class_date', '<=', $end_date);
        }
        if (!empty($classTypeId)) {
            if ($notIn == true) {
                $query = $query->whereIn('class_type_id', $classTypeId);
            } else {
                $query = $query->whereNotIn('class_type_id', $classTypeId);
            }
        }
        return $query->count();
    }

    public function getTotalClassBySubjectClassType($studentId, $sessionId, $courseId, $phaseId, $termId, $subjectId, $start_date = null, $end_date = null, $classTypeIds = [])
    {
        $query = $this->classRoutine->whereHas('attendances', function ($q) use ($studentId) {
            if ($studentId) {
                $q->where('student_id', $studentId);
            }
        })->where('session_id', $sessionId)->where('course_id', $courseId)->where('status', 1);

        if (!empty($phaseId)) {
            $query = $query->where('phase_id', $phaseId);
        }

        if (!empty($termId)) {
            $query = $query->where('term_id', $termId);
        }

        if (!empty($subjectId)) {
            $query = $query->where('subject_id', $subjectId);
        }

        if ($start_date) {
            $start_date = Carbon::createFromFormat('d/m/Y', $start_date)->format('Y-m-d');
            $query      = $query->where('class_date', '>=', $start_date);
        }

        if ($end_date) {
            $end_date = Carbon::createFromFormat('d/m/Y', $end_date)->format('Y-m-d');
            $query    = $query->where('class_date', '<=', $end_date);
        }

        if (!empty($classTypeIds) && is_array($classTypeIds)) {
            $query = $query->whereIn('class_type_id', $classTypeIds);
        }

        return $query->count();
    }

    public function getAttendanceReport($request)
    {
        $date_query = '';
        if ($request->start_date) {
            $start_date = Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d');
            $date_query .= " and class_date >='$start_date'";
        }
        if ($request->end_date) {
            $end_date   = Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d');
            $date_query .= " and class_date <='$end_date'";
        }

        $total_exam_held = "SELECT
                    count(*)
                    FROM
                        `class_routines`
                    WHERE
                        EXISTS (
                            SELECT
					*
				FROM
					`attencance` `at`
				WHERE
					`class_routines`.`id` = `at`.`class_routine_id`
				AND  `at`.`student_id` = `attencance`.student_id
                        )
                    AND `session_id` = $request->session_id
                    AND `course_id` = $request->course_id
                    AND `phase_id` = $request->phase_id
                    AND `term_id` = $request->term_id
                    AND `status` = 1
                    AND EXISTS (
                        SELECT
                            *
                        FROM
                            `subjects`
                        WHERE
                            `class_routines`.`subject_id` = `subjects`.`id`
                        AND `subject_group_id` = $request->subject_group_id
                    )
                    AND `class_type_id` NOT IN (1, 9)
                    AND `class_routines`.`deleted_at` IS NULL $date_query";
        $subQuery        = '
SELECT count(*) FROM `attencance` a INNER JOIN `class_routines` ON `class_routines`.`id` = `a`.`class_routine_id`
          INNER JOIN `subjects` ON `class_routines`.`subject_id` = `subjects`.`id`';
        if (!empty($request->session_id)) {
            $subQuery .= ' AND class_routines.session_id = ' . $request->session_id;
        }
        if (!empty($request->course_id)) {
            $subQuery .= ' AND class_routines.course_id = ' . $request->course_id;
        }
        if (!empty($request->phase_id)) {
            $subQuery .= ' AND class_routines.phase_id = ' . $request->phase_id;
        }
        if (!empty($request->term_id)) {
            $subQuery .= ' AND class_routines.term_id = ' . $request->term_id;
        }
        if (!empty($request->subject_id)) {
            $subQuery .= ' AND class_routines.subject_id = ' . $request->subject_id;
        }

        if (!empty($request->subject_group_id)) {
            $subQuery .= ' AND subjects.subject_group_id = ' . $request->subject_group_id;
        }
        $subQuery .= ' AND class_routines.status = 1';

        $query = $this->model->select([
            '*',
            \DB::raw('(' . $subQuery . '  WHERE  `class_routines`.`deleted_at` IS NULL AND `a`.`student_id` = `attencance`.`student_id` and class_routines.class_type_id IN (1,9,17) and `a`.`attendance` = 1 ' . $date_query . ') AS `lecture_present`'),
            \DB::raw('(' . $subQuery . '  WHERE  `class_routines`.`deleted_at` IS NULL AND `a`.`student_id` = `attencance`.`student_id` and class_routines.class_type_id NOT IN (1,9,17) and `a`.`attendance` = 1 ' . $date_query . ') AS `practical_present`'),
            \DB::raw('(' . $total_exam_held . ') as total_exam_held_exclude_lec')
        ]);

        if (!empty($request->session_id)) {
            $query = $query->whereHas('classRoutine', function ($q) use ($request) {
                $q->where('session_id', $request->session_id);
            });
        }
        if (!empty($request->course_id)) {
            $query = $query->whereHas('classRoutine', function ($q) use ($request) {
                $q->where('course_id', $request->course_id);
            });
        }
        if (!empty($request->phase_id)) {
            $query = $query->whereHas('classRoutine', function ($q) use ($request) {
                $q->where('phase_id', $request->phase_id);
            });
        }
        if (!empty($request->term_id)) {
            $query = $query->whereHas('classRoutine', function ($q) use ($request) {
                $q->where('term_id', $request->term_id);
            });
        }
        if (!empty($request->subject_id)) {
            $query = $query->whereHas('classRoutine', function ($q) use ($request) {
                $q->where('subject_id', $request->subject_id);
            });
        }
        if (!empty($request->subject_group_id)) {
            $query = $query->whereHas('classRoutine.subject', function ($q) use ($request) {
                $q->where('subject_group_id', $request->subject_group_id);
            });
        }

        if ($request->start_date) {
            $query = $query->whereHas('classRoutine', function ($q) use ($request) {
                $start_date = Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d');
                $q->where('class_date', '>=', $start_date);
            });
        }
        if ($request->end_date) {
            $query = $query->whereHas('classRoutine', function ($q) use ($request) {
                $end_date = Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d');
                $q->where('class_date', '<=', $end_date);
            });
        }

        $query = $query->with('student')->groupBy('student_id')->get()
                       ->sortBy(function ($value, $key) {
                           return $value->student->roll_no;
                       });

        return $query;
    }

    public function getAttendanceReportByClassType($request, $classTypeIds = [])
    {
        if (empty($classTypeIds)) {
            return collect([]);
        }
        // Formatting dates if provided
        $start_date = $request->start_date ? Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d') : null;
        $end_date   = $request->end_date ? Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d') : null;

        // Build WHERE conditions for class_routines
        $routineConditions = function ($query) use ($request, $start_date, $end_date) {
            $query->where('class_routines.status', 1)
                  ->whereNull('class_routines.deleted_at')
                  ->when($request->session_id, fn($q) => $q->where('class_routines.session_id', $request->session_id))
                  ->when($request->course_id, fn($q) => $q->where('class_routines.course_id', $request->course_id))
                  ->when($request->phase_id, fn($q) => $q->where('class_routines.phase_id', $request->phase_id))
                  ->when($request->subject_id, fn($q) => $q->where('class_routines.subject_id', $request->subject_id))
                  ->when($start_date, fn($q) => $q->where('class_routines.class_date', '>=', $start_date))
                  ->when($end_date, fn($q) => $q->where('class_routines.class_date', '<=', $end_date));
        };

        // QUERY 1: Get all attendance data grouped by student and class type
        $attendanceQuery = Attencance::select([
            'attencance.student_id',
            'class_routines.class_type_id',
            DB::raw('COUNT(*) as total_count'),
            DB::raw('SUM(CASE WHEN attencance.attendance = 1 THEN 1 ELSE 0 END) as present_count')
        ])
                                     ->join('class_routines', 'attencance.class_routine_id', '=', 'class_routines.id');

        // Handle subject group join if needed
        if ($request->subject_group_id) {
            $attendanceQuery->join('subjects', 'class_routines.subject_id', '=', 'subjects.id')
                            ->where('subjects.subject_group_id', $request->subject_group_id);
        }

        // Apply routine conditions
        $routineConditions($attendanceQuery);

        // Filter by class types - this is the KEY part
        // We want students who have attendance in ANY of these class types
        $attendanceQuery->whereIn('class_routines.class_type_id', $classTypeIds);

        $attendanceResults = $attendanceQuery
            ->groupBy('attencance.student_id', 'class_routines.class_type_id')
            ->get();

        // If no attendance data, return empty
        if ($attendanceResults->isEmpty()) {
            return collect([]);
        }
        // Get unique student IDs
        $studentIds = $attendanceResults->pluck('student_id')->unique()->toArray();

        // QUERY 2: Get student details
        $students = Student::select(['id', 'roll_no', 'full_name_en'])
                           ->whereIn('id', $studentIds)
                           ->orderBy('roll_no')
                           ->get()
                           ->keyBy('id');

        // Group attendance data by student_id
        $attendanceByStudent = $attendanceResults->groupBy('student_id');

        // Map attendance data to students
        foreach ($students as $student) {
            $classTypeData = [];

            // Initialize ALL class types with 0 (even if student has no data for that type)
            foreach ($classTypeIds as $classTypeId) {
                $classTypeData[$classTypeId] = [
                    'present_count' => 0,
                    'total_count'   => 0,
                ];
            }

            // Fill in actual data for class types where student has attendance
            if ($attendanceByStudent->has($student->id)) {
                foreach ($attendanceByStudent[$student->id] as $record) {
                    $classTypeData[$record->class_type_id] = [
                        'present_count' => (int)$record->present_count,
                        'total_count'   => (int)$record->total_count,
                    ];
                }
            }

            $student->classTypeData = $classTypeData;
        }

        return $students->values();
    }

    private function getPresentCount($studentId, $request, $start_date, $end_date)
    {
        return DB::table('attencance as a')
                 ->join('class_routines', 'class_routines.id', '=', 'a.class_routine_id')
                 ->join('subjects', 'class_routines.subject_id', '=', 'subjects.id')
                 ->where('a.student_id', $studentId)
                 ->where('a.attendance', 1)
                 ->whereNull('class_routines.deleted_at')
                 ->when($request->class_type_id, function ($query) use ($request) {
                     $query->where('class_routines.class_type_id', $request->class_type_id);
                 })
                 ->when($request->session_id, function ($query) use ($request) {
                     $query->where('class_routines.session_id', $request->session_id);
                 })
                 ->when($request->course_id, function ($query) use ($request) {
                     $query->where('class_routines.course_id', $request->course_id);
                 })
                 ->when($request->phase_id, function ($query) use ($request) {
                     $query->where('class_routines.phase_id', $request->phase_id);
                 })
                 ->when($request->subject_id, function ($query) use ($request) {
                     $query->where('class_routines.subject_id', $request->subject_id);
                 })
                 ->when($request->subject_group_id, function ($query) use ($request) {
                     $query->where('subjects.subject_group_id', $request->subject_group_id);
                 })
                 ->when($start_date, function ($query) use ($start_date) {
                     $query->where('class_routines.class_date', '>=', $start_date);
                 })
                 ->when($end_date, function ($query) use ($end_date) {
                     $query->where('class_routines.class_date', '<=', $end_date);
                 })
                 ->count();
    }

    private function getTotalCount($studentId, $request, $start_date, $end_date)
    {
        return DB::table('class_routines')
                 ->whereExists(function ($query) use ($studentId) {
                     $query->select(DB::raw(1))
                           ->from('attencance as at')
                           ->whereColumn('class_routines.id', 'at.class_routine_id')
                           ->where('at.student_id', $studentId);
                 })
                 ->where('session_id', $request->session_id)
                 ->where('course_id', $request->course_id)
                 ->where('phase_id', $request->phase_id)
                 ->whereExists(function ($query) use ($request) {
                     $query->select(DB::raw(1))
                           ->from('subjects')
                           ->whereColumn('class_routines.subject_id', 'subjects.id')
                           ->where('subjects.id', $request->subject_id);
                 })
                 ->whereNull('class_routines.deleted_at')
                 ->when($request->class_type_id, function ($query) use ($request) {
                     $query->where('class_type_id', $request->class_type_id);
                 })
                 ->when($start_date, function ($query) use ($start_date) {
                     $query->where('class_date', '>=', $start_date);
                 })
                 ->when($end_date, function ($query) use ($end_date) {
                     $query->where('class_date', '<=', $end_date);
                 })
                 ->count();
    }

    public function getLectureClassBySearchCriteria($sessionId, $courseId, $phaseId, $termId, $studentGroupId, $classTypeId)
    {
        return $this->classRoutine->where([
            ['session_id', $sessionId],
            ['course_id', $courseId],
            ['phase_id', $phaseId],
            ['term_id', $termId],
            ['class_type_id', $classTypeId],
        ])
                                  ->whereHas('subject.subjectGroup', function ($query) use ($studentGroupId) {
                                      $query->where('id', $studentGroupId);
                                  })->count();
    }

    public function getStudentsAttendanceBySessionCourseAndPhase($sessionId, $courseId, $phaseId, $start_date = null, $end_date = null)
    {
        // Date formatting
        if (!empty($start_date)) {
            $start_date = Carbon::createFromFormat('d/m/Y', $start_date)->format('Y-m-d');
        }
        if (!empty($end_date)) {
            $end_date = Carbon::createFromFormat('d/m/Y', $end_date)->format('Y-m-d');
        }

        $attendanceQuery = DB::table('attencance as at')
                             ->join('class_routines as cr', 'cr.id', '=', 'at.class_routine_id')
                             ->join('students as s', 's.id', '=', 'at.student_id')
                             ->select(
                                 'at.student_id as student_id',
                                 'cr.subject_id as subject_id',
                                 DB::raw('COUNT(*) as total_class'),
                                 DB::raw('SUM(CASE WHEN at.attendance = 1 THEN 1 ELSE 0 END) as class_present'),
                                 DB::raw('SUM(CASE WHEN cr.class_type_id IN (1, 9, 17) THEN 1 ELSE 0 END) as total_lecture_class'),
                                 DB::raw('SUM(CASE WHEN cr.class_type_id IN (1, 9, 17) AND at.attendance = 1 THEN 1 ELSE 0 END) as lecture_class_present'),
                                 DB::raw('SUM(CASE WHEN cr.class_type_id NOT IN (1, 9, 17) THEN 1 ELSE 0 END) as total_tutorial_class'),
                                 DB::raw('SUM(CASE WHEN cr.class_type_id NOT IN (1, 9, 17) AND at.attendance = 1 THEN 1 ELSE 0 END) as tutorial_class_present'),
                                 's.full_name_en as full_name',
                                 's.roll_no as roll_no',
                             )
            ->where('cr.status', 1)
                             ->where('cr.session_id', $sessionId)
                             ->where('cr.course_id', $courseId)
                             ->where('cr.phase_id', $phaseId)
                             ->whereNull('cr.deleted_at')
                             ->when($start_date, function ($query) use ($start_date) {
                                 $query->where('cr.class_date', '>=', $start_date);
                             })
                             ->when($end_date, function ($query) use ($end_date) {
                                 $query->where('cr.class_date', '<=', $end_date);
                             })
                             ->groupBy('at.student_id', 'cr.subject_id', 's.full_name_en', 's.roll_no')
                             ->orderBy('s.roll_no', 'asc')
                             ->orderBy('cr.subject_id', 'asc')
                             ->get();

        return $attendanceQuery->map(function ($row) {
            $totalClass = (int)$row->total_class;
            $classPresent = (int)$row->class_present;
            $totalLecture = (int)$row->total_lecture_class;
            $lecturePresent = (int)$row->lecture_class_present;
            $totalTutorial = (int)$row->total_tutorial_class;
            $tutorialPresent = (int)$row->tutorial_class_present;

            return [
                'student_id'             => $row->student_id,
                'subject_id'             => $row->subject_id,
                'total_class'            => $totalClass,
                'class_present'          => $classPresent,
                'total_lecture_class'    => $totalLecture,
                'lecture_class_present'  => $lecturePresent,
                'total_tutorial_class'   => $totalTutorial,
                'tutorial_class_present' => $tutorialPresent,
                'attendance_percentage'  => $totalClass > 0 ? (int)round(($classPresent * 100) / $totalClass) : null,
                'lecture_percentage'     => $totalLecture > 0 ? (int)round(($lecturePresent * 100) / $totalLecture) : null,
                'tutorial_percentage'    => $totalTutorial > 0 ? (int)round(($tutorialPresent * 100) / $totalTutorial) : null,
                'full_name'              => $row->full_name,
                'roll_no'                => $row->roll_no,
            ];
        })->all();
    }

    public function getStudentsAttendanceBySessionCourseAndPhaseExcel($sessionId, $courseId, $phaseId, $start_date = null, $end_date = null)
    {
        $subQueryForPresent = '(SELECT count(*) FROM `attencance` WHERE `student_id` = at.student_id AND `attendance` = 1 AND `class_routine_id` IN (SELECT id FROM `class_routines` WHERE `session_id` = ' . (int)$sessionId . ' AND `course_id` = ' . (int)$courseId . ' AND `phase_id` = ' . (int)$phaseId . ' AND `subject_id` = `cr`.`subject_id`';
        $query              = $this->model->select(
            'at.student_id', 'cr.subject_id', 'cr.class_type_id',
            DB::raw('(SELECT count(*) FROM `class_routines` WHERE `session_id` = ' . (int)$sessionId . ' AND `course_id` = ' . (int)$courseId . ' AND `phase_id` = ' . (int)$phaseId . ' AND `subject_id` = `cr`.`subject_id` ) AS `total_class1`'),
            DB::raw('(SELECT count(*) FROM `attencance` WHERE `student_id` = at.student_id  AND `class_routine_id` IN (SELECT id FROM `class_routines` WHERE deleted_at is null and  `session_id` = ' . (int)$sessionId . ' AND `course_id` = ' . (int)$courseId . ' AND `phase_id` = ' . (int)$phaseId . ' AND `subject_id` = `cr`.`subject_id`)) AS `total_class`'),
            DB::raw('(SELECT count(*) FROM `attencance` WHERE `student_id` = at.student_id AND `attendance` = 1 AND `class_routine_id` IN (SELECT id FROM `class_routines` WHERE deleted_at is null and `session_id` = ' . (int)$sessionId . ' AND `course_id` = ' . (int)$courseId . ' AND `phase_id` = ' . (int)$phaseId . ' AND `subject_id` = `cr`.`subject_id`)) AS `class_present`')
        )
                                          ->from('attencance as at')
                                          ->join('class_routines as cr', 'cr.id', '=', 'at.class_routine_id')
                                          ->where('cr.session_id', $sessionId)
                                          ->where('cr.course_id', $courseId)
                                          ->where('cr.phase_id', $phaseId)
                                          ->where('cr.deleted_at', null)
                                          ->groupBy('at.student_id', 'cr.subject_id')
                                          ->orderBy('at.student_id', 'ASC')
                                          ->orderBy('cr.subject_id', 'ASC')
                                          ->with('student')
                                          ->get()
                                          ->sortBy(function ($value, $key) {
                                              return $value->student->roll_no;
                                          });

        return $query;
    }

    public function getLectureAttendanceByStudentId($sessionId, $courseId, $phaseId, $termId, $subjectGroupId, $studentId, $start_date = null, $end_date = null, array $classTypeIds)
    {
        return $this->model->where('student_id', $studentId)->where('attendance', 1)
                           ->whereHas('classRoutine', function ($query) use ($sessionId, $courseId, $phaseId, $termId, $start_date, $end_date, $classTypeIds) {
                               $where               = array();
                               $where['session_id'] = $sessionId;
                               $where['course_id']  = $courseId;
                               $where['phase_id']   = $phaseId;
                               if ($termId) {
                                   $where['term_id'] = $termId;
                               }
                               $query->where($where)
                                     ->whereIn('class_type_id', $classTypeIds)
                                     ->whereNull('deleted_at');
                               if ($start_date) {
                                   $start_date = Carbon::createFromFormat('d/m/Y', $start_date)->format('Y-m-d');
                                   $query->where('class_date', '>=', $start_date);
                               }
                               if ($end_date) {
                                   $end_date = Carbon::createFromFormat('d/m/Y', $end_date)->format('Y-m-d');
                                   $query->where('class_date', '<=', $end_date);
                               }
                           })
                           ->whereHas('classRoutine.subject', function ($query) use ($subjectGroupId) {
                               $query->where('subject_group_id', $subjectGroupId);
                           })->count();
    }

    public function getAttendanceBySubjectClassTypeStudentId($sessionId, $courseId, $phaseId, $termId, $subjectId, $studentId, $start_date = null, $end_date = null, $classTypeIds = [])
    {
        return $this->model->where('student_id', $studentId)->where('attendance', 1)
                           ->whereHas('classRoutine', function ($query) use (
                               $sessionId, $courseId, $phaseId,
                               $termId, $subjectId, $start_date, $end_date, $classTypeIds
                           ) {
                               $where               = array();
                               $where['session_id'] = $sessionId;
                               $where['course_id']  = $courseId;
                               $where['phase_id']   = $phaseId;
                               $where['subject_id'] = $subjectId;
                               $where['status']     = 1;

                               if ($termId) {
                                   $where['term_id'] = $termId;
                               }

                               $query->where($where)
                                     ->whereNull('deleted_at');

                               if (!empty($classTypeIds) && is_array($classTypeIds)) {
                                   $query->whereIn('class_type_id', $classTypeIds);
                               }

                               if ($start_date) {
                                   $start_date = Carbon::createFromFormat('d/m/Y', $start_date)->format('Y-m-d');
                                   $query->where('class_date', '>=', $start_date);
                               }
                               if ($end_date) {
                                   $end_date = Carbon::createFromFormat('d/m/Y', $end_date)->format('Y-m-d');
                                   $query->where('class_date', '<=', $end_date);
                               }
                           })->count();
    }

    public function getTutorialAttendanceByStudentId($sessionId, $courseId, $phaseId, $termId, $subjectGroupId, $studentId, $start_date = null, $end_date = null, $classTypeIds = [])
    {
        $attendance = $this->model->where('student_id', $studentId)->where('attendance', 1)
                                  ->whereHas('classRoutine', function ($query) use ($sessionId, $courseId, $phaseId, $termId, $start_date, $end_date, $classTypeIds) {
                                      $where               = array();
                                      $where['session_id'] = $sessionId;
                                      $where['course_id']  = $courseId;
                                      $where['phase_id']   = $phaseId;
                                      if ($termId) {
                                          $where['term_id'] = $termId;
                                      }
                                      $query->where($where)
                                            ->whereNotIn('class_type_id', $classTypeIds)
                                            ->whereNull('deleted_at');
                                      if ($start_date) {
                                          $start_date = Carbon::createFromFormat('d/m/Y', $start_date)->format('Y-m-d');
                                          $query->where('class_date', '>=', $start_date);
                                      }
                                      if ($end_date) {
                                          $end_date = Carbon::createFromFormat('d/m/Y', $end_date)->format('Y-m-d');
                                          $query->where('class_date', '<=', $end_date);
                                      }
                                  })
                                  ->whereHas('classRoutine.subject', function ($query) use ($subjectGroupId) {
                                      $query->where('subject_group_id', $subjectGroupId);
                                  })->count();
        return $attendance;
    }

    public function getAttendanceBySessionCoursePhaseTermSubjectClassTypeAndStudentId($sessionId, $courseId, $phaseId, $termId, $subjectId, $studentId, $start_date = null, $end_date = null, $classTypeIds = [])
    {
        return $this->model->with([
            'classRoutine', 'classRoutine.subject', 'classRoutine.classType'
        ])->where('student_id', $studentId)
                           ->whereHas('classRoutine', function ($query) use (
                               $sessionId, $courseId, $phaseId,
                               $termId, $subjectId, $classTypeIds, $start_date, $end_date
                           ) {
                               $where               = array();
                               $where['session_id'] = $sessionId;
                               $where['course_id']  = $courseId;
                               $where['phase_id']   = $phaseId;
                               $where['subject_id'] = $subjectId;
                               $where['status']     = 1;

                               if ($termId) {
                                   $where['term_id'] = $termId;
                               }

                               $query->where($where)->whereNull('deleted_at');

                               if (!empty($classTypeIds) && is_array($classTypeIds)) {
                                   $query->whereIn('class_type_id', $classTypeIds);
                               }

                               if ($start_date) {
                                   $start_date = Carbon::createFromFormat('d/m/Y', $start_date)->format('Y-m-d');
                                   $query->where('class_date', '>=', $start_date);
                               }
                               if ($end_date) {
                                   $end_date = Carbon::createFromFormat('d/m/Y', $end_date)->format('Y-m-d');
                                   $query->where('class_date', '<=', $end_date);
                               }
                           })->get();
    }

    public function getTotalClassBySubjectId($studentId, $sessionId, $courseId, $phaseId, $subjectId, array $classTypeId, $notIn = false)
    {
        return $this->model->where('student_id', $studentId)->where('attendance', '!=', null)
                           ->whereHas('classRoutine', function ($q) use ($sessionId, $courseId, $phaseId, $classTypeId, $subjectId, $notIn) {
                               $q = $q->where([
                                   ['session_id', $sessionId],
                                   ['course_id', $courseId],
                                   ['phase_id', $phaseId],
                                   ['subject_id', $subjectId],
                                   ['status', 1],
                               ]);
                               if ($notIn == true) {
                                   $q = $q->whereIn('class_type_id', $classTypeId);
                               } else {
                                   $q = $q->whereNotIn('class_type_id', $classTypeId);
                               }
                           })->count();
    }

    public function getTotalAttendanceBySessionCoursePhaseSubjectAndStudentId($sessionId, $courseId, $phaseId, $subjectId, $studentId, array $classTypeId, $notIn = false)
    {
        return $this->model->where('student_id', $studentId)->where('attendance', 1)
                           ->whereHas('classRoutine', function ($q) use ($sessionId, $courseId, $phaseId, $classTypeId, $subjectId, $notIn) {
                               $q = $q->where([
                                   ['session_id', $sessionId],
                                   ['course_id', $courseId],
                                   ['phase_id', $phaseId],
                                   ['subject_id', $subjectId],
                                   ['status', 1],
                               ]);
                               if ($notIn == true) {
                                   $q = $q->whereIn('class_type_id', $classTypeId);
                               } else {
                                   $q = $q->whereNotIn('class_type_id', $classTypeId);
                               }
                           })->count();
    }

    public function getBySubjectIdAndDate($subjectId, $date)
    {
        return $this->model->where('attendance', 1)
                           ->whereHas('classRoutine', function ($q) use ($subjectId, $date) {
                               $q->where('subject_id', $subjectId)->where('class_type_id', 1)->whereDate('class_date', $date);
                           })->count();
    }

    public function getTotalAbsentBySubjectIdAndDate($subjectId, $date)
    {
        return $this->model->where('attendance', 0)
                           ->whereHas('classRoutine', function ($q) use ($subjectId, $date) {
                               $q->where('subject_id', $subjectId)->where('class_type_id', 1)->whereDate('class_date', $date);
                           })->count();
    }

    public function getTotalAttendanceBySubject($subjectId, $studentId, $courseId, $phaseId)
    {
        return $this->model->where('attendance', 1)->where('student_id', $studentId)
                           ->whereHas('classRoutine', function ($q) use ($subjectId, $courseId, $phaseId) {
                               $q->where([
                                   ['subject_id', $subjectId],
                                   ['course_id', $courseId],
                                   ['phase_id', $phaseId],
                               ]);
                           })->count();
    }

    public function getStudentsWhoseAttendanceAlreadyProvided($classRoutineId)
    {
        $authUser      = Auth::guard('web')->user();
        $attendance    = 0;
        $allAttendance = $this->model->where('class_routine_id', $classRoutineId)->first();
        if (!empty($allAttendance->classRoutine) && ($authUser->teacher)) {
            // Get studentId from each student group & filter students collection by teacherId
            $studentIds = $allAttendance->classRoutine->studentGroup
                ->filter(function ($studentGroup) use ($authUser) {
                    return $studentGroup->pivot->teacher_id == $authUser->teacher->id;
                })
                ->flatMap->students->pluck('id')->toArray();
            $attendance = $this->model->where('class_routine_id', $classRoutineId)->whereHas('student', function ($query) use ($studentIds, $classRoutineId) {
                $query->whereIn('id', $studentIds);
            })->count();
        }
        return $attendance;
    }

    public function checkStudentExistOfStudentGroupByRoutineId($classRoutineId)
    {
        $query = $this->model->where('class_routine_id', $classRoutineId)->get();

        $students = $query->map(function ($item) {
            return $item->student;
        });

        return $students;
    }

    public function checkAttendanceByClassRoutineId($classRoutineId)
    {
        $now = Carbon::now()->format('Y-m-d');
        return $this->model->where('class_routine_id', $classRoutineId)->whereDate('created_at', $now)->first();
    }

    public function checkAttendanceByClassInfo($studentId, $classRoutineId)
    {
        return $this->model->where('student_id', $studentId)->where('class_routine_id', $classRoutineId)->first();
    }

    public function getTotalPresentByClassRoutineId($classRoutineId)
    {
        return $this->model->where([
            ['class_routine_id', $classRoutineId],
            ['attendance', 1]
        ])->count();
    }

    public function getTotalAbsentByClassRoutineId($classRoutineId)
    {
        return $this->model->where([
            ['class_routine_id', $classRoutineId],
            ['attendance', 0]
        ])->count();
    }

    public function getTotalClassPresentAbsentByStudentInfoAndClassInfo($studentId, $sessionId, $courseId, $phaseId, $batchTypeId, $subjectId, $classTypeId, $attendance)
    {
        return $this->model->where('student_id', $studentId)->where('attendance', $attendance)
                           ->whereHas('classRoutine', function ($q) use ($sessionId, $courseId, $phaseId, $batchTypeId, $subjectId, $classTypeId) {
                               $q->where([
                                   ['session_id', $sessionId],
                                   ['course_id', $courseId],
                                   ['phase_id', $phaseId],
                                   ['batch_type_id', $batchTypeId],
                                   ['subject_id', $subjectId],
                                   ['class_type_id', $classTypeId],
                               ]);
                           })->count();
    }

    public function getComparativeAttendanceReport(Request $request)
    {
        if (!$request->filled('start_date') || !$request->filled('end_date')) {
            return ['periods' => [], 'students' => []];
        }

        $startDate = Carbon::createFromFormat('d/m/Y', $request->start_date);
        $endDate   = Carbon::createFromFormat('d/m/Y', $request->end_date);

        $periods         = [];
        $periodStartDate = clone $startDate;

        while ($periodStartDate <= $endDate) {
            // Add 1 month, then subtract 1 day to get the end of the period
            $periodEndDate = (clone $periodStartDate)->addMonth()->subDay();
            // If the calculated end is after the requested end date, cap it
            if ($periodEndDate > $endDate) {
                $periodEndDate = clone $endDate;
            }
            $periods[] = $periodStartDate->format('d/m/Y') . ' to ' . $periodEndDate->format('d/m/Y');
            // Move to the next period
            $periodStartDate = (clone $periodEndDate)->addDay();
        }

        $query = DB::table('students as s')
                   ->join('attencance as a', 's.id', '=', 'a.student_id')
                   ->join('class_routines as cr', 'a.class_routine_id', '=', 'cr.id')
                   ->select(
                       's.id as student_id',
                       's.roll_no',
                       's.full_name_en',
                       DB::raw("FLOOR(DATEDIFF(cr.class_date, '" . $startDate->format('Y-m-d') . "') / 30) as period_index"),
                       DB::raw('SUM(CASE WHEN cr.class_type_id IN (1, 9, 17) THEN 1 ELSE 0 END) as lecture_held'),
                       DB::raw('SUM(CASE WHEN cr.class_type_id IN (1, 9, 17) AND a.attendance = 1 THEN 1 ELSE 0 END) as lecture_attended'),
                       DB::raw('SUM(CASE WHEN cr.class_type_id NOT IN (1, 9, 17) THEN 1 ELSE 0 END) as tutorial_held'),
                       DB::raw('SUM(CASE WHEN cr.class_type_id NOT IN (1, 9, 17) AND a.attendance = 1 THEN 1 ELSE 0 END) as tutorial_attended')
                   )
                   ->where('s.session_id', $request->session_id)
                   ->where('s.course_id', $request->course_id)
                   ->where('s.phase_id', $request->phase_id)
                   ->where('cr.subject_id', $request->subject_id)
                   ->where('cr.status', 1)
                   ->whereNull('s.deleted_at')
                   ->whereNull('a.deleted_at')
                   ->whereNull('cr.deleted_at')
                   ->groupBy('s.id', 's.roll_no', 's.full_name_en', 'period_index')
                   ->orderBy('s.roll_no');

        if ($request->filled('student_category_id')) {
            $query->where('s.student_category_id', $request->student_category_id);
        }

        $query->whereBetween('cr.class_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')]);

        $results      = $query->get();
        $studentsData = [];

        foreach ($results as $row) {
            $studentId = $row->student_id;
            if (!isset($studentsData[$studentId])) {
                $studentsData[$studentId] = [
                    'id'           => $row->student_id,
                    'roll_no'      => $row->roll_no,
                    'student_name' => $row->full_name_en,
                    'monthly_data' => [],
                    'total'        => [
                        'lecture_held'  => 0, 'lecture_attended' => 0,
                        'tutorial_held' => 0, 'tutorial_attended' => 0,
                    ]
                ];
            }

            $pIndex                                            = (int)$row->period_index;
            $studentsData[$studentId]['monthly_data'][$pIndex] = [
                'lecture_held'        => (int)$row->lecture_held,
                'lecture_attended'    => (int)$row->lecture_attended,
                'lecture_percentage'  => $row->lecture_held > 0 ? round(((int)$row->lecture_attended / (int)$row->lecture_held) * 100) : 0,
                'tutorial_held'       => (int)$row->tutorial_held,
                'tutorial_attended'   => (int)$row->tutorial_attended,
                'tutorial_percentage' => $row->tutorial_held > 0 ? round(((int)$row->tutorial_attended / (int)$row->tutorial_held) * 100) : 0,
            ];
            // Add to total
            $studentsData[$studentId]['total']['lecture_held']      += (int)$row->lecture_held;
            $studentsData[$studentId]['total']['lecture_attended']  += (int)$row->lecture_attended;
            $studentsData[$studentId]['total']['tutorial_held']     += (int)$row->tutorial_held;
            $studentsData[$studentId]['total']['tutorial_attended'] += (int)$row->tutorial_attended;
        }

        // Calculate total percentages
        foreach ($studentsData as $studentId => &$student) {
            $student['total']['lecture_percentage']  = $student['total']['lecture_held'] > 0 ? round(($student['total']['lecture_attended'] / $student['total']['lecture_held']) * 100) : 0;
            $student['total']['tutorial_percentage'] = $student['total']['tutorial_held'] > 0 ? round(($student['total']['tutorial_attended'] / $student['total']['tutorial_held']) * 100) : 0;

            $totalHeld                              = $student['total']['lecture_held'] + $student['total']['tutorial_held'];
            $totalAttended                          = $student['total']['lecture_attended'] + $student['total']['tutorial_attended'];
            $student['total']['average_percentage'] = $totalHeld > 0 ? round(($totalAttended / $totalHeld) * 100) : 0;
        }

        return [
            'periods'  => $periods,
            'students' => $studentsData,
        ];
    }
}
