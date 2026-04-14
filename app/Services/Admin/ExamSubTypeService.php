<?php

namespace App\Services\Admin;

use App\Models\ExamSubType;
use App\Services\BaseService;
use DataTables;

/**
 * Class UserService
 * @package App\Services\Admin
 */
class ExamSubTypeService extends BaseService {

    /**
     * @var $model
     */
    protected $model;
    /**
     * @var string
     */
    protected $url = 'admin/exam_sub_type';


    public function __construct(ExamSubType $examSubType)
    {
        $this->model = $examSubType;
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

                if (hasPermission('exam_sub_type/edit')) {
                    $actions.= '<a href="' . route('exam_sub_type.edit', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>';
                }
                return $actions;
            })

            ->editColumn('exam_type_id', function ($row) {
                return $row->examType->title;
                return isset($row->examType) ? $row->examType->title : '';
            })

            ->editColumn('status', function ($row) {
                return setStatus($row->status);
            })
            ->rawColumns(['status', 'action'])

            ->filter(function ($query) use ($request) {

                if ($request->get('title')) {
                    $query->where('title', 'like', '%'.$request->get('title').'%');
                }

                if (!empty($request->get('exam_type_id'))) {
                    $query->where('exam_type_id', $request->get('exam_type_id'));
                }


            })

            ->make(true);
    }

    public function getAllExamSubType(){

        return $this->model->where('status', 1)->get();
    }

    public function getExamTypesSubTypesBySubjectId($subjectId){

        return $this->model->with('examType')
            ->whereHas('subjects', function($q) use($subjectId){
                $q->where('id', $subjectId);
            })
            ->get();
    }
}
