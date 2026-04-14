<?php

namespace App\Services\Admin;

use App\Models\Phase;
use App\Models\Term;
use App\Services\BaseService;
use DataTables;

/**
 * Class UserService
 * @package App\Services\Admin
 */
class PhaseService extends BaseService {

    /**
     * @var $model
     */
    protected $model;
    /**
     * @var string
     */
    protected $url = 'admin/phase';


    public function __construct(Phase $phase)
    {
        $this->model = $phase;
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

                if (hasPermission('phase/edit')) {
                    $actions.= '<a href="' . route('phase.edit', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>';
                }

                return $actions;
            })
            ->editColumn('status', function ($row) {
                return setStatus($row->status);
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function listBySubjectId(array $subjects){
        return $this->model->whereHas('sessionPhaseDetails.subjects', function ($q) use($subjects){
            $q->whereIn('id', $subjects);
        })
            ->where('status', 1)->orderBy('title', 'asc')->pluck('title', 'id');
    }
}
