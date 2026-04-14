<?php

namespace App\Services\Admin;

use App\Models\StudentCategory;
use App\Services\BaseService;
use DataTables;

/**
 * Class UserService
 * @package App\Services\Admin
 */
class StudentCategoryService extends BaseService {

    /**
     * @var $model
     */
    protected $model;
    /**
     * @var string
     */
    protected $url = 'admin/student_category';


    public function __construct(StudentCategory $studentCategory)
    {
        $this->model = $studentCategory;
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
                if (hasPermission('student_category/edit')) {
                    $actions.= '<a href="' . route('student_category.edit', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>';
                }
                return $actions;
            })
            ->editColumn('status', function ($row) {
                return setStatus($row->status);
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }
    //get all student category
    public function getAllStudentCategory(){
        return $this->model->where('status', 1)->get();
    }







}
