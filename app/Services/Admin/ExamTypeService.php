<?php

namespace App\Services\Admin;

use App\Models\ExamType;
use App\Services\BaseService;
use DataTables;

/**
 * Class UserService
 * @package App\Services\Admin
 */
class ExamTypeService extends BaseService {

    /**
     * @var $model
     */
    protected $model;
    /**
     * @var string
     */
    protected $url = 'admin/exam_type';


    public function __construct(ExamType $examType)
    {
        $this->model = $examType;
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

                if (hasPermission('exam_type/edit')) {
                    $actions.= '<a href="' . route('exam_type.edit', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>';
                }
                return $actions;
            })
            ->editColumn('status', function ($row) {
                return setStatus($row->status);
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function allExamType() {

        return $this->model->where('status', 1)->get();
    }

    public function getExamTypesSubTypesWithMarkByExamIdAndSubjectId($examId, $subjectId){
        return $this->model->whereHas('examSubTypes', function($q) use($examId, $subjectId){
            $q->whereHas('examSubjectMark', function($q1) use($examId, $subjectId){
                $q1->where('exam_id', $examId)->where('subject_id', $subjectId);
            });
        })->with([
            'examSubTypes' => function($q)use($examId, $subjectId){
                $q->whereHas('examSubjectMark', function($q1)use($examId, $subjectId){
                    $q1->where('exam_id', $examId)->where('subject_id', $subjectId);
                });
            },
            'examSubTypes.examSubjectMark' => function($q) use($examId, $subjectId){
                $q->where('exam_id', $examId)->where('subject_id', $subjectId);
            }
        ])
            ->get();
    }

    public function getExamTypesSubTypesWithMarkByExamIdAndSubjectGroupId($examId, $subjectGroupId){
        return $this->model->whereHas('examSubTypes.examSubjectMark', function($q) use($examId, $subjectGroupId){
            $q->where('exam_id', $examId)->whereHas('subject', function($q1) use($subjectGroupId){
                $q1->where('subject_group_id', $subjectGroupId);
            });
        })->with([
            'examSubTypes' => function($q)use($examId, $subjectGroupId){
                $q->whereHas('examSubjectMark', function($q1)use($examId, $subjectGroupId){
                    $q1->where('exam_id', $examId)->whereHas('subject', function($q1) use($subjectGroupId){
                        $q1->where('subject_group_id', $subjectGroupId);
                    });
                })
                ->with(['examSubjectMark' => function($q) use($examId, $subjectGroupId){
                    $q->where('exam_id', $examId)->whereHas('subject', function($q1) use($subjectGroupId){
                        $q1->where('subject_group_id', $subjectGroupId);
                    });
                }]);
            }
        ])
            ->get();
    }
}
