<?php

namespace App\Services\Admin;

use App\Models\Bank;
use App\Services\BaseService;
use DataTables;

/**
 * Class UserService
 * @package App\Services\Admin
 */
class BankService extends BaseService {

    /**
     * @var $model
     */
    protected $model;
    /**
     * @var string
     */
    protected $url = 'admin/bank';


    public function __construct(Bank $bank)
    {
        $this->model = $bank;
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

                if (hasPermission('bank/edit')) {
                    $actions.= '<a href="' . route('bank.edit', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>';
                }
                return $actions;
            })
            ->editColumn('status', function ($row) {
                return setStatus($row->status);
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }







}
