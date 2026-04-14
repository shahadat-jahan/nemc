<?php

namespace App\Services\Admin;

use App\Models\ExamSubType;
use App\Models\PaymentDetail;
use App\Models\PaymentType;
use App\Models\SubjectGroup;
use App\Services\BaseService;
use DataTables;

/**
 * Class UserService
 * @package App\Services\Admin
 */
class PaymentTypeService extends BaseService {

    /**
     * @var $model
     */
    protected $model;
    protected $paymentDetailModel;
    /**
     * @var string
     */
    protected $url = 'admin/payment_type';


    public function __construct(PaymentType $paymentType, PaymentDetail $paymentDetail)
    {
        $this->model = $paymentType;
        $this->paymentDetailModel = $paymentDetail;
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

                if (hasPermission('payment_type/edit')) {
                    $actions.= '<a href="' . route('payment_type.edit', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>';
                }

                return $actions;
            })
            ->editColumn('status', function ($row) {
                return setStatus($row->status);
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function getAllSubjectGroup(){

        return $this->model->where('status', 1)->get();
    }

    //get payment detail data related to payment Type by id
    public function getPaymentDetailData($id){

        return $this->paymentDetailModel->where('payment_type_id', $id)->get();
    }

    public function getPaymentDetailByTypeIdAndCourseId($paymentTypeId,$courseId){
        return $this->paymentDetailModel->where('course_id', $courseId)->where('payment_type_id', $paymentTypeId)->first();
    }

    public function getPaymentDetailByTypeIdAndCourseIdAndCategoryId($paymentTypeId,$courseId, $categoryId){
        return $this->paymentDetailModel->where('course_id', $courseId)->where('payment_type_id', $paymentTypeId)->where('student_category_id', $categoryId)->first();
    }

    //get all payment type
    public function getAllPaymentType() {
        return $this->model->where('status', 1)->get();
    }
}
