<?php

namespace App\Services\Admin;

use App\Models\PaymentDetail;
use App\Services\BaseService;
use DataTables;

/**
 * Class UserService
 * @package App\Services\Admin
 */
class PaymentDetailService extends BaseService
{

    /**
     * @var $model
     */
    protected $model;


    public function __construct(PaymentDetail $paymentDetail)
    {
        $this->model = $paymentDetail;
    }


    /**
     *
     * @return JsonResponse
     */
    public function getAllData($request)
    {
        $query = $this->model->with(['paymentType', 'studentCategory', 'course']);

        return Datatables::of($query)
            ->addColumn('action', function ($row) {
                $actions = '';

                if (hasPermission('payment_detail/edit')) {
                    $actions .= '<a href="' . route('payment_detail.edit', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>';
                }

                return $actions;
            })
            ->editColumn('payment_type_id', function ($row) {
                return isset($row->paymentType) ? $row->paymentType->title : '';
            })
            ->editColumn('student_category_id', function ($row) {
                return isset($row->studentCategory) ? $row->studentCategory->title : '';
            })
//            ->editColumn('session_id', function ($row) {
//                return isset($row->session) ? $row->session->title : '';
//            })
            ->editColumn('course_id', function ($row) {
                return isset($row->course) ? $row->course->title : '';
            })
            ->editColumn('status', function ($row) {
                return setStatus($row->status);
            })
            ->rawColumns(['status', 'action'])
            //filter
            ->filter(function ($query) use ($request) {

                if ($request->get('currency_code')) {
                    $query->where('currency_code', 'like', '%' . $request->get('currency_code') . '%');
                }

                if (!empty($request->get('payment_type_id'))) {
                    $query->where('payment_type_id', $request->get('payment_type_id'));
                }
                if (!empty($request->get('student_category_id'))) {
                    $query->where('student_category_id', $request->get('student_category_id'));
                }
                if (!empty($request->get('course_id'))) {
                    $query->where('course_id', $request->get('course_id'));
                }
//                if (!empty($request->get('session_id'))) {
//                    $query->where('session_id', $request->get('session_id'));
//                }

            })
            ->make(true);
    }

    public function getAllSubjectGroup()
    {

        return $this->model->where('status', 1)->get();
    }

    //get payment detail data related to payment Type by id
    public function getPaymentDetailData($id)
    {
        return $this->paymentDetailModel->where('payment_type_id', $id)->get();
    }

    public function getPaymentsByStudentCategoryIdAndTypes($studentCategoryId, $sessionId, $courseId, $types)
    {
        if (in_array(3, $types)) {
            unset($types[array_search(3, $types)]);
        }

        //$this->model->where(['student_category_id', $studentCategoryId])->where('session_id', $sessionId)->where('course_id', $courseId)->whereIn('payment_type_id', $types)->get();

        return $this->model->where('student_category_id', $studentCategoryId)
            ->where('course_id', $courseId)
            ->whereIn('payment_type_id', $types)
            ->get();

    }

}
