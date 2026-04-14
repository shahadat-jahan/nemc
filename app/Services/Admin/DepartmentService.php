<?php

namespace App\Services\Admin;

use App\Models\Department;
use App\Models\Teacher;
use App\Services\BaseService;
use DataTables;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserService
 * @package App\Services\Admin
 */
class DepartmentService extends BaseService {

    /**
     * @var $model
     */
    protected $model;
    protected $teacherModel;
    /**
     * @var string
     */
    protected $url = 'admin/department';


    public function __construct(Department $department, Teacher $teacher)
    {
        $this->model = $department;
        $this->teacherModel = $teacher;
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

                if (hasPermission('department/edit')) {
                    $actions.= '<a href="' . route('department.edit', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>';
                }

                return $actions;
            })
            ->editColumn('status', function ($row) {
                return setStatus($row->status);
            })

            ->editColumn('department_lead_id', function ($row) {
                if(isset($row->teacher)){
                    //get teacher name from teacher table by department lead id
                    $departmentLeadName = $row->teacher->first_name;
                    return $departmentLeadName;
                } else{
                    return '--';
                }
            })


            ->rawColumns(['status', 'action'])

            ->filter(function ($query) use ($request) {

                if ($request->get('title')) {
                    $query->where('title', 'like', '%'.$request->get('title').'%');
                }

                if (!empty($request->get('department_lead_id'))) {
                    $query->where('department_lead_id', $request->get('department_lead_id'));
                }

            })
            ->make(true);
    }

    public function getAllDepartment(){
        $query = $this->model->where('status', 1);

        if (Auth::guard('web')->check()){
            $user = Auth::guard('web')->user();
            if ($user->teacher){
                $query = $query->whereHas('teachers', function ($q) use($user){
                    $q->where('id', $user->teacher->id);
                });
            }
        }elseif (Auth::guard('student_parent')->check()){
            $user = Auth::guard('student_parent')->user();
            //if login user is student
            if ($user->student){
                $query = $query->whereHas('subjects.subjectGroup', function ($q) use($user){
                    $q->where('course_id',$user->student->course_id);
                });
            }
            //if login user is parent
            elseif ($user->parent){
                $query = $query->whereHas('subjects.subjectGroup', function ($q) use($user){
                    $q->where('course_id',$user->parent->students->first()->course_id);
                });
            }
        }

        return $query->orderBy('title')->get();
    }

    public function getDepartmentBySubjectGroupId($subjectGroupId){
        return $this->model->whereHas('subjects', function ($q) use($subjectGroupId){
            $q->where('subject_group_id', $subjectGroupId);
        })->first();
    }

    public function getDepartmentBySubjects($subjectId){
        return $this->model->whereHas('subjects', function ($q) use($subjectId){
            $q->where('id', $subjectId);
        })->first();
    }
}
