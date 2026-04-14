<?php

namespace App\Services\Admin;

use App\Models\Hall;
use App\Services\BaseService;
use App\Services\UtilityServices;
use DataTables;

/**
 * Class UserService
 * @package App\Services\Admin
 */
class HallService extends BaseService {

    /**
     * @var $model
     */
    protected $model;
    /**
     * @var string
     */
    protected $url = 'admin/hall';


    public function __construct(Hall $hall)
    {
        $this->model = $hall;
    }


    /**
     *
     * @return JsonResponse
     */
    public function getAllData($request)
    {
        $query = $this->model->select();

        return Datatables::of($query)
            ->editColumn('floor_number', function ($row){
//                $floors = UtilityServices::getFloors();
//                return $floors[$row->floor_number];
                return $row->floor_number;
            })
            ->addColumn('action', function ($row) {
                $actions = '';

                if (hasPermission('hall/edit')) {
                    $actions.= '<a href="' . route('hall.edit', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>';
                }
                return $actions;
            })
            ->editColumn('status', function ($row) {
                return setStatus($row->status);
            })
            ->rawColumns(['status', 'action'])
            ->filter(function ($query) use ($request) {

                if ($request->get('title')) {
                    $query->where('title', 'like', '%'.$request->get('title').'%');
                }
                if ($request->get('floor_number')) {
                    $query->where('floor_number', 'like', '%'.$request->get('floor_number').'%');
                }
                if (!empty($request->get('room_number'))) {
                    $query->where('room_number', $request->get('room_number'));
                }

            })
            ->make(true);
    }


}
