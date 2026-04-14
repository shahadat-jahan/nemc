<?php

namespace App\Services\Admin;

use App\Models\Designation;
use App\Services\BaseService;
use DataTables;

/**
 * Class UserService
 * @package App\Services\Admin
 */
class DesignationService extends BaseService {

    /**
     * @var $model
     */
    protected $model;
    /**
     * @var string
     */
    protected $url = 'admin/designation';


    public function __construct(Designation $designation)
    {
        $this->model = $designation;
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

                if (hasPermission('designation/edit')) {
                    $actions.= '<a href="' . route('designation.edit', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>';
                }

                if (hasPermission('designation/view')) {
                    $actions.= '<a href="' . route('designation.show', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View"><i class="flaticon-eye"></i></a>';
                }

                return $actions;
            })
            ->editColumn('status', function ($row) {
                return setStatus($row->status);
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function getAllDesignation(){

        return $this->model->where('status', 1)->get();
       // return $this->model->whereIn('title', ['Head of Department', 'Professor', 'Assoc. Professor', 'Lecturer'])->get();
    }







}
