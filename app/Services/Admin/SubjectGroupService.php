<?php

namespace App\Services\Admin;

use App\Models\ExamSubType;
use App\Models\SubjectGroup;
use App\Services\BaseService;
use DataTables;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserService
 * @package App\Services\Admin
 */
class SubjectGroupService extends BaseService {

    /**
     * @var $model
     */
    protected $model;
    /**
     * @var string
     */
    protected $url = 'admin/subject_group';


    public function __construct(SubjectGroup $subjectGroup){
        $this->model = $subjectGroup;
    }

    /**
     *
     * @return JsonResponse
     */
    public function getAllData($request){
        $query = $this->model->with('course')->select();

        if (Auth::guard('web')->check()){
            $user = Auth::guard('web')->user();
            if ($user->teacher){
                $query = $query->whereHas('subjects', function ($q) use($user){
                    $q->whereIn('id', getSubjectsIdByTeacherId($user->teacher->id, $user->teacher->course_id));
                });
            }
        } elseif (Auth::guard('student_parent')->check()){
            $user = Auth::guard('student_parent')->user();
            //if login user is student
            if ($user->student){
                $query->where('course_id', $user->student->course_id);
            }
            //if login user is parent
            elseif ($user->parent){
                $query->where('course_id', $user->parent->students->first()->course_id);
            }
        }

        return Datatables::of($query)
            ->addColumn('action', function ($row) {
                $actions = '';

                if (hasPermission('subject_group/edit')) {
                    $actions.= '<a href="' . route('subject_group.edit', [$row->id]) .'" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>';
                }
                return $actions;
            })

            ->editColumn('course_id', function ($row) {
                return $row->course->title;
                return isset($row->course) ? $row->course->title : '';
            })

            ->editColumn('status', function ($row) {
                return setStatus($row->status);
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function getAllSubjectGroup(){
        $query =  $this->model->where('status', 1);
        if (Auth::guard('web')->check()){
            $user = Auth::guard('web')->user();
            if ($user->user_group_id == 4 or $user->user_group_id == 11 or $user->user_group_id == 12){
                $query = $query->whereHas('subjects', function ($q) use($user){
                    $q->whereIn('id', getSubjectsIdByTeacherId($user->teacher->id, $user->teacher->course_id));
                });
            }
        } elseif (Auth::guard('student_parent')->check()){
            $user = Auth::guard('student_parent')->user();
            //if login user is student
            if ($user->student){
                //get subject id by student course id
                $query = $query->where('course_id', $user->student->course_id);
            }
            //if login user is parent
            elseif ($user->parent){
                $query = $query->where('course_id', $user->parent->students->first()->course_id);
            }
        }

        return $query->get();
    }


    public function getSubjectGroupsBySessionIdCourseId($sessionId, $courseId, $phaseId){
        $query = $this->model->where('course_id', $courseId)
            ->whereHas('subjects.sessionPhase.sessionDetail', function ($q) use($sessionId){
                $q->where('session_id', $sessionId);
            })
            ->whereHas('subjects.sessionPhase', function ($q) use($phaseId){
                $q->where('phase_id', $phaseId);
            });

        //if login user is teacher then get subject group related to teacher department
        if (Auth::guard('web')->check()){
            $user = Auth::user();
            if ($user->teacher){
                $teacherDepartmentId = $user->teacher->department_id;
                $query->whereHas('subjects', function ($q) use ($teacherDepartmentId) {
                    $q->where('department_id', $teacherDepartmentId);
                });
            }
        }
        return $query->get();

    }

    public function getAllSubjectGroupBySessionIdCourseId($sessionId, $courseId){
        return $this->model->where('course_id', $courseId)
            ->whereHas('subjects.sessionPhase.sessionDetail', function ($q) use($sessionId){
                $q->where('session_id', $sessionId);
            })->get();

    }

    public function getAllSubjectGroupBySessionIdCourseIdPhaseId($sessionId, $courseId, $phaseId){
        $query = $this->model->where('course_id', $courseId)
            ->whereHas('subjects.sessionPhase.sessionDetail', function ($q) use($sessionId){
                $q->where('session_id', $sessionId);
            })
            ->whereHas('subjects.sessionPhase.phase', function ($q) use($phaseId){
                $q->where('id', $phaseId);
            });


        //if login user is teacher then get subject group related to teacher department
        if (Auth::guard('web')->check()){
            $user = Auth::user();
            if ($user->user_group_id == 4 or $user->user_group_id == 11 or $user->user_group_id == 12){
                $teacherDepartmentId = $user->teacher->department_id;
                $query->whereHas('subjects', function ($q) use ($teacherDepartmentId) {
                    $q->where('department_id', $teacherDepartmentId);
                });
            }
        }
        return $query->get();

    }
    //get subject group by courseId
    public function getAllSubjectGroupByCourseId( $courseId){
        $query = $this->model->where('status', 1)
            ->whereHas('course.subjectGroups', function ($q) use($courseId){
                $q->where('course_id', $courseId);
            });
        //if login user is teacher then get subject group related to teacher department
        if (Auth::guard('web')->check()){
            $user = Auth::user();
            if ($user->teacher){
                $teacherDepartmentId = $user->teacher->department_id;
                $query->whereHas('subjects', function ($q) use ($teacherDepartmentId) {
                    $q->where('department_id', $teacherDepartmentId);
                });

            }
        }

        return $query->get();

    }

}
