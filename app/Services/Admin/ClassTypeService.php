<?php

namespace App\Services\Admin;

use App\Models\ClassType;
use App\Models\Designation;
use App\Services\BaseService;
use DataTables;

/**
 * Class UserService
 * @package App\Services\Admin
 */
class ClassTypeService extends BaseService {

    /**
     * @var $model
     */
    protected $model;
    /**
     * @var string
     */
    protected $url = 'admin/class_type';

    public function __construct(ClassType $classType)
    {
        $this->model = $classType;
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

                if (hasPermission('class_type/edit')) {
                    $actions.= '<a href="' . route('class_type.edit', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>';
                }

                return $actions;
            })
            ->editColumn('status', function ($row) {
                return setStatus($row->status);
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function findMultiple($ids)
    {
        return $this->model->whereIn('id', $ids)->orderBy('title')->get();
    }
}
