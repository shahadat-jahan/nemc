<?php

namespace App\Services\Admin;

use App\Models\ClassRoutine;
use App\Models\Teacher;
use App\Models\TeacherEvaluation;
use App\Models\User;
use App\Services\BaseService;
use App\Services\EmailService;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserService
 * @package App\Services\Admin
 */
class TeacherService extends BaseService
{

    /**
     * @var $model
     */
    protected $model;
    protected $userService;
    protected $subjectService;
    protected $classRoutine;
    protected $emailService;
    /**
     * @var string
     */
    protected $url = 'admin/term';

    public static $admissionStatus = [1 => 'Pending', 'Waiting List', 'Selected for admission'];

    public function __construct(Teacher      $teacher, UserService $userService, User $user, SubjectService $subjectService,
                                ClassRoutine $classRoutine, EmailService $emailService)
    {
        $this->model          = $teacher;
        $this->userModel      = $user;
        $this->userService    = $userService;
        $this->subjectService = $subjectService;
        $this->classRoutine   = $classRoutine;
        $this->emailService   = $emailService;
    }

    /**
     * @return JsonResponse
     */
    public function getAllData($request)
    {
        $query = $this->model->with(['department', 'designation', 'course', 'user.userGroup'])->select();

        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            if ($user->teacher) {
                if ($user->user_group_id == 12) {
                    //department head get all teacher of department
                    $teacherDepartmentId = $user->teacher->department->id;
                    $query               = $query->where('department_id', $teacherDepartmentId);
                } else {
                    $query = $query->where('id', $user->teacher->id);
                }
            }
        } elseif (Auth::guard('student_parent')->check()) {
            $user = Auth::guard('student_parent')->user();
            //if login user is student
            if ($user->student) {
                $query = $query->where('course_id', $user->student->course_id);
            } elseif ($user->parent) {
                //if login user is parent
                $query = $query->where('course_id', $user->parent->students->first()->course_id);
            }
        }

        return Datatables::of($query)
                         ->addColumn('action', function ($row) {
                             $actions = '';

                             if (hasPermission('teacher/password')) {
                                 $actions .= '<a href="' . route('teacher.password-change.form', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Change Password"><i class="fa fa-key"></i></a>';
                             }
                             /* if (getAppPrefix() == 'admin'){
                                  $actions.= '<a href="' . route('teacher.password-change.form', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Change Password"><i class="fa fa-key"></i></a>';
                              }*/

                             if (hasPermission('teacher/edit')) {
                                 $actions .= '<a href="' . route('teacher.edit', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>';
                             }
                             if (hasPermission('teacher/view')) {
                                 $actions .= '<a href="' . route(customRoute('teacher.show'), [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View"><i class="flaticon-eye"></i></a>';
                             }
                             if (hasPermission('user_groups/permission')) {
                                 $actions .= '<a href="' . route(customRoute('teacher.group.permission'), [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View"><i class="flaticon-cogwheel-1"></i></a>';
                                 if (Auth::guard('web')->check()) {
                                     $user = Auth::guard('web')->user();
                                     if ($user->teacher) {
                                         if ($user->teacher->id == $row->id) {
                                             $actions .= '';
                                         }
                                     }
                                 }
                             } else {
                                 $actions .= '<a href="javascript:void(0)" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill send-message-user" data-message-to-user-id="' . $row->user->id . '" title="Send message to teacher"><i class="fas fa-envelope"></i></a>';
                             }

                             return $actions;
                         })
                         ->editColumn('photo', function ($row) {
                             $imageSrc = !empty($row->photo) ? $row->photo : getAvatar($row->gender);
                             return '<img src="' . asset($imageSrc) . '" width="70%"/>';
                         })
                         ->editColumn('name', function ($row) {
                             return $row->full_name;
                         })
                         ->editColumn('department_id', function ($row) {
                             return isset($row->department) ? $row->department->title : '';
                         })
                         ->editColumn('designation_id', function ($row) {
                             return isset($row->designation) ? $row->designation->title : '';
                         })
                         ->editColumn('course_id', function ($row) {
                             return isset($row->course) ? $row->course->title : '';
                         })
                         ->editColumn('user_id', function ($row) {
                             return isset($row->user) ? $row->user->user_id : '';
                         })
                         ->addColumn('user_group', function ($row) {
                             return isset($row->user) ? $row->user->userGroup->group_name : '';
                         })
                         ->editColumn('status', function ($row) {
                             return setStatus($row->status);
                         })
                         ->rawColumns(['photo', 'status', 'action'])
                         ->filter(function ($query) use ($request) {
                             /* if ($request->get('first_name')) {
                                  $query->where('first_name', 'like', '%'.$request->get('first_name').'%');
                              }*/

                             if ($request->get('name') != '') {
                                 $query->where('first_name', 'like', '%' . $request->get('name') . '%');
                                 $query->orWhere('last_name', 'like', '%' . $request->get('name') . '%');
                             }

                             if (!empty($request->get('phone'))) {
                                 $query->where('phone', $request->get('phone'));
                             }

                             if (!empty($request->get('email'))) {
                                 $query->where('email', $request->get('email'));
                             }

                             if (!empty($request->get('department_id'))) {
                                 $query->where('department_id', $request->get('department_id'));
                             }

                             if (!empty($request->get('course_id'))) {
                                 $query->where('course_id', $request->get('course_id'));
                             }
                             $status = $request->get('status');
                             if (isset($status)) {
                                 $query->where('status', (int)$request->get('status'));
                             }
                         })
                         ->make(true);
    }

    public function saveTeacher($request)
    {
        DB::beginTransaction();
        // save data for user
        $user = $this->userService->create([
            'user_group_id' => 4,
            'email'         => $request->email,
            'user_id'       => $request->user_id,
            'password'      => $request->password
        ]);

        // save data for teacher
        $teacher = $user->teacher()->create([
            'first_name'     => $request->first_name,
            'last_name'      => $request->last_name,
            'department_id'  => $request->department_id,
            'designation_id' => $request->designation_id,
            'course_id'      => $request->course_id,
            'dob'            => $request->dob,
            'gender'         => $request->gender,
            'phone'          => $request->phone,
            'share_phone'    => isset($request->share_phone) ? $request->share_phone : 0,
            'email'          => $request->email,
            'share_email'    => isset($request->share_email) ? $request->share_email : 0,
            'address'        => checkEmpty($request->address),
            /*'status' => $request->status,*/
            'photo'          => checkEmpty($request->photo),
        ]);

        DB::commit();

        // send mail to teacher
        if ($teacher && !empty($request->email)) {
            $teacherMailBody = '
                    <table>
                        <tr>
                            <td>Dear ' . $request->first_name . ' ' . $request->last_name . ',</td>
                        </tr>
                        <tr>
                            <td>Welcome to NEMC teacher portal. Your account has been generated. To log on, please use this information: </td>
                        </tr>
                        <tr>
                            <td>URL: ' . url('/') . ' </td>
                        </tr>
                        <tr>
                            <td>User ID: ' . $request->user_id . ' </td>
                        </tr>
                        <tr>
                            <td>Password: ' . $request->password . ' </td>
                        </tr>
                    <table>';

            $this->emailService->mailSend($request->email, '', 'NEMC: Teacher ID has been generated', 'new_account', $teacherMailBody, '', $user);
        }
        return $teacher;
    }

    public function updateTeacher($request, $id)
    {
        $teacher = $this->find($id);

        //keep previous photo if no new photo select during edit
        if (empty($request->photo)) {
            $request->photo = $teacher->photo;
        }

        DB::commit();

        $teacher->update([
            'first_name'     => $request->first_name,
            'last_name'      => $request->last_name,
            'department_id'  => $request->department_id,
            'designation_id' => $request->designation_id,
            'course_id'      => $request->course_id,
            'dob'            => $request->dob,
            'gender'         => $request->gender,
            'phone'          => $request->phone,
            'share_phone'    => $request->share_phone,
            'email'          => $request->email,
            'share_email'    => $request->share_email,
            'address'        => checkEmpty($request->address),
            'status'         => $request->status,
            'photo'          => checkEmpty($request->photo),
        ]);

        //update username for teacher in user table
        if ($request->has('user_group_id')) {
            $teacher->user->update([
                'user_id'       => $request->user_id,
                'user_group_id' => $request->user_group_id,
                'email'         => $request->email,
            ]);
        } else {
            $teacher->user->update([
                'user_id' => $request->user_id,
                'email'   => $request->email,
            ]);
        }

        DB::commit();

        return $teacher;
    }

    // Teacher Change Password
    public function changePassword($request, $id)
    {
        $teacher = $this->find($id);

        $teacher->user->update([
            'password' => Hash::make($request->new_password)
        ]);

        $user            = User::where('id', $teacher->user_id)->first();
        $teacherMailBody = '
                    <table>
                        <tr>
                            <td>Dear ' . $teacher->first_name . ' ' . $teacher->last_name . ',</td>
                        </tr>
                        <tr>
                            <td>Your Password has been reset </td>
                        </tr>
                        <tr>
                            <td>URL: ' . url('/') . ' </td>
                        </tr>
                        <tr>
                            <td>User ID: ' . $user->user_id . ' </td>
                        </tr>
                        <tr>
                            <td>Password: ' . $request->new_password . ' </td>
                        </tr>
                    <table>';
        $this->emailService->mailSend($teacher->email, '', 'NEMC: Teacher Password', 'password_reset', $teacherMailBody, '', $user);

        return $teacher;
    }

    public function getTeachersBySubjectId($subjectId)
    {
        $departmentId = $this->subjectService->find($subjectId)->department_id;
        // Login teacher's department related teacher list
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            if ($user->teacher) {
                $departmentId = $user->teacher->department_id;
            }
        }
        return $this->model->where('status', 1)->where('department_id', $departmentId)->get();
    }

    public function getTeachersByDepartmentIds($departmentIds)
    {
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            if ($user->teacher) {
                return $this->model
                    ->where('status', 1)
                    ->where('department_id', $user->teacher->department_id)
                    ->get();
            }
        }

        return $this->model
            ->where('status', 1)
            ->whereIn('department_id', (array)$departmentIds)
            ->get();
    }

    public function getTotalTeachersByCourseId($courseId)
    {
        //return $this->model->where('course_id', $courseId)->orWhereNull('course_id')->count();
        return $this->model->where('course_id', $courseId)->orWhere('course_id', 3)->count();
    }

    public function getTotalTeacherWiseClass($usrId = null, $sessionId = '', $phaseId = '', $termId = '', $subjectId = '', $fromDate, $toDate = '', $courseId = '', $classTypeId = '')
    {
        $query2 = DB::table('class_routines')
                    ->leftJoin('teachers', 'class_routines.teacher_id', '=', 'teachers.id')
                    ->whereIn('class_routines.status', [1,2])
                    ->where('teachers.status', 1);

        if (!empty($usrId)) {
            $query2 = $query2->where('class_routines.teacher_id', $usrId);
        }
        if (!empty($sessionId)) {
            $query2 = $query2->where('class_routines.session_id', $sessionId);
        }
        if (!empty($courseId)) {
            $query2 = $query2->where('class_routines.course_id', $courseId);
        }
        if (!empty($phaseId)) {
            $query2 = $query2->where('class_routines.phase_id', $phaseId);
        }
        if (!empty($termId)) {
            $query2 = $query2->where('class_routines.term_id', $termId);
        }
        if (!empty($subjectId)) {
            $query2 = $query2->where('class_routines.subject_id', $subjectId);
        }
        if (!empty($fromDate) && !empty($toDate)) {
            $query2 = $query2->whereBetween('class_routines.class_date', [$fromDate, $toDate]);
        } elseif (!empty($fromDate)) {
            $query2 = $query2->whereDate('class_routines.class_date', '=', $fromDate);
        } elseif (!empty($toDate)) {
            $query2 = $query2->whereDate('class_routines.class_date', '=', $toDate);
        }

        $query2 = $query2->select('class_routines.teacher_id')
                         ->distinct()
                         ->get();

        $activeTeachers = $query2->pluck('teacher_id')->toArray();

        // Fetch data for active teachers only
        $assignedClasses = [];
        foreach ($activeTeachers as $teacherId) {
            $assignedClasses[$teacherId] = DB::table('class_routines')
                                             ->where('teacher_id', $teacherId)
                                             ->whereIn('status', [1,2])
                                             ->when(!empty($classTypeId), function ($q) use ($classTypeId) {
                                                 return $q->where('class_routines.class_type_id', $classTypeId);
                                             })
                                             ->count();
        }
        return [
            'assign' => $assignedClasses,
        ];
    }

    public function teacherDetailClass($id)
    {
        // Direct class routines (teacher_id directly in class_routines)
        $directClassRoutines = ClassRoutine::with(['session', 'term', 'phase', 'subject', 'attendances'])
                                           ->where('teacher_id', $id)
                                           ->whereIn('status', [1,2])
                                           ->orderByDesc('class_date')
                                           ->get();

        $data = $directClassRoutines->map(function ($routine) {
            return [
                'session'          => optional($routine->session)->title,
                'term'             => optional($routine->term)->title,
                'phase'            => optional($routine->phase)->title,
                'subject'          => optional($routine->subject)->title,
                'class_date'       => $routine->class_date,
                'attendance_date'  => $routine->attendances->isNotEmpty() ? formatDate($routine->attendances->first()->created_at) : '<span style="color: red;">Not Taken</span>',
                'start_from'       => $routine->start_from,
                'end_at'           => $routine->end_at,
                'class_routine_id' => $routine->id,
                'class_status'     => $routine->status,
            ];
        })->values()->toArray();

        return $data;
    }

    public function getNotAssignClass()
    {
        return $results = DB::select(DB::raw("select t1.* from teachers t1 where not exists ( select 1 from class_routines t2 where t1.id=t2.teacher_id )"));
    }

    public function getTotalTeachersByDepartmentId($departmentId)
    {
        return $this->model->where('department_id', $departmentId)->count();
    }

    public function checkTeacherUserNameIsUnique($request)
    {
        if ($request->has('id')) {
            $teacherUserId = $this->model->find($request->id)->user_id;
            return $this->userModel->where('id', '<>', $teacherUserId)->where('user_id', $request->user_id)->count();
        }

        return $this->userModel->where('user_id', $request->user_id)->count();
    }

    public function checkTeacherEmailIsUnique($request)
    {
        if ($request->has('id')) {
            return $this->model->where('id', '<>', $request->id)->where('email', $request->email)->count();
        }

        return $this->model->where('email', $request->email)->count();
    }

    public function checkTeacherPhoneIsUnique($request)
    {
        if ($request->has('id')) {
            return $this->model->where('id', '<>', $request->id)->where('phone', $request->phone)->count();
        }

        return $this->model->where('phone', $request->phone)->count();
    }

    public function getTeacherListWithStatus($request)
    {
        $teachers = $this->model->with('department', 'designation', 'course', 'user')->where([
            ['course_id', $request->course_id],
            ['department_id', $request->department_id]
        ])->orderBy('designation_id');

        if (!empty($request->name)) {
            $teachers = $teachers->where('first_name', 'like', $request->name . '%')
                                 ->orWhere('last_name', 'like', $request->name . '%');
        }

        if (!empty($request->email)) {
            $teachers = $teachers->where('email', $request->email);
        }
        if (!empty($request->phone)) {
            $teachers = $teachers->where('phone', $request->phone);
        }
        if ($request->status != 2) {
            $teachers = $teachers->where('status', $request->status);
        }

        return $teachers->get();
    }

    public function getAllTeachers()
    {
        return $this->model->where('status', 1)->get();
    }

    /**
     * Get a single evaluation for a student/teacher pair
     */
    public function getEvaluationByStudentAndTeacher($student, $teacherId)
    {
        return TeacherEvaluation::where('student_id', $student->id)
            ->where('phase_id', $student->phase_id)
            ->where('teacher_id', $teacherId)
            ->first();
    }

    /**
     * Create a new teacher evaluation
     */
    public function createEvaluation(array $payload)
    {
        return TeacherEvaluation::create($payload);
    }

    /**
     * Update an existing teacher evaluation
     */
    public function updateEvaluation(array $conditions, array $payload)
    {
        return TeacherEvaluation::updateOrCreate($conditions, $payload);
    }

}


