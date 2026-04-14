<?php

namespace App\Services\Admin;

use App\Models\PaymentMethod;
use App\Models\Term;
use App\Services\BaseService;
use DataTables;

/**
 * Class UserService
 * @package App\Services\Admin
 */
class PaymentMethodService extends BaseService {

    /**
     * @var $model
     */
    protected $model;
    /**
     * @var string
     */
    protected $url = 'admin/term';


    public function __construct(PaymentMethod $paymentMethod){
        $this->model = $paymentMethod;
    }


    /**
     *
     * @return JsonResponse
     */
    public function getAllData($request){
        $query = $this->model->select();

        return Datatables::of($query)
            ->addColumn('action', function ($row) {
                $actions = '';

                if (hasPermission('payment_method/edit')) {
                    $actions.= '<a href="' . route('payment_method.edit', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>';
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
