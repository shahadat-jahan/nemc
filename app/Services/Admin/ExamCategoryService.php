<?php

namespace App\Services\Admin;

use App\Models\ExamCategory;
use App\Services\BaseService;
use DataTables;

/**
 * Class UserService
 * @package App\Services\Admin
 */
class ExamCategoryService extends BaseService {

    /**
     * @var $model
     */
    protected $model;
    /**
     * @var string
     */
    protected $url = 'admin/exam_category';

    public function __construct(ExamCategory $examCategory)
    {
        $this->model = $examCategory;
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

                if (hasPermission('exam_category/edit')) {
                    $actions.= '<a href="' . route('exam_category.edit', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>';
                }
                return $actions;
            })
            ->editColumn('status', function ($row) {
                return setStatus($row->status);
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function getAllExamCategory(){
        return $this->model->where('status', 1)->get();
    }
}
