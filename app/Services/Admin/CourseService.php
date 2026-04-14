<?php

namespace App\Services\Admin;

use App\Models\Course;
use App\Models\Designation;
use App\Services\BaseService;
use DataTables;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserService
 * @package App\Services\Admin
 */
class CourseService extends BaseService {

    /**
     * @var $model
     */
    protected $model;
    /**
     * @var string
     */
    protected $url = 'admin/course';


    public function __construct(Course $course)
    {
        $this->model = $course;
    }


    /**
     *
     * @return JsonResponse
     */
    public function getAllData($request)
    {
        $query = $this->model->select();

        return Datatables::of($query)
            ->addColumn('action', function ($row) {
                $actions = '';

                if (hasPermission('course/edit')) {
                    $actions.= '<a href="' . route('course.edit', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>';
                }

                if (hasPermission('course/view')) {
                   /* $actions.= '<a href="' . route('course.show', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View"><i class="flaticon-eye"></i></a>';*/
                }

                return $actions;
            })
            ->editColumn('status', function ($row) {
                return setStatus($row->status);
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }
    //get all course
    public function getAllCourse(){
        $query = $this->model->where('status', 1);
        if (Auth::guard('web')->check()){
            $user = Auth::guard('web')->user();
            if (!empty($user->teacher->course_id)){
                $query = $query->where('id', $user->teacher->course_id);
            }
        }elseif (Auth::guard('student_parent')->check()){
            $user = Auth::guard('student_parent')->user();
            //if login user is student
            if ($user->student){
                $query = $query->where('id', $user->student->course_id);
            }
            //if login user is parent
            elseif ($user->parent){
                $query = $query->where('id', $user->parent->students->first()->course_id);
            }
        }
        return $query->get();
    }

    public function lists()
    {
        $query = $this->model;

        if (Auth::guard('student_parent')->check()){
            $user = Auth::guard('student_parent')->user();
            if ($user->student){
                $query = $query->where('id', $user->student->course_id);
            }else{
                $query = $query->whereHas('students', function ($q) use($user){
                    $q->whereIn('id', getStudentsIdByParentId($user->parent->id));
                });
            }
        }

        if (Auth::guard('web')->check()){
            $user = Auth::guard('web')->user();
            if ($user->teacher){
                if (!empty($user->teacher->course_id)){
                    $query = $query->where('id', $user->teacher->course_id);
                }
            } else if (!empty($user->adminUser->course_id)) {
                $query = $query->where('id', $user->adminUser->course_id);
            }
        }

        return $query->orderBy('title', 'asc')->pluck('title', 'id');
    }

    public function listByStatus()
    {
        $query = $this->model;

        if (Auth::guard('student_parent')->check()){
            $user = Auth::guard('student_parent')->user();
            if ($user->student){
                $query = $query->where('id', $user->student->course_id);
            }else{
                $query = $query->whereHas('students', function ($q) use($user){
                    $q->whereIn('id', getStudentsIdByParentId($user->parent->id));
                });
            }
        }

        if (Auth::guard('web')->check()){
            $user = Auth::guard('web')->user();
            if ($user->teacher){
                if (!empty($user->teacher->course_id)){
                    $query = $query->where('id', $user->teacher->course_id);
                }
            } else if ($user->adminUser && !empty($user->adminUser->course_id)) {
                $query = $query->where('id', $user->adminUser->course_id);
            }
        }

        return $query->where('status', 1)->orderBy('title', 'asc')->pluck('title', 'id');
    }

    public function getAllCourseId(){
        return $this->model->pluck('id');
    }

}
