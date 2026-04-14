<?php

namespace App\Services\Admin;

use App\Models\Page;
use App\Services\BaseService;
use DB;
use DataTables;

class PageService extends BaseService {

    /**
     * @var $model
     */
    protected $model;

    /**
     * CityService constructor.
     *
     * @param Page $page
     */
    public function __construct(Page $page)
    {
        $this->model = $page;
    }

    /**
     * Get list
     *
     * @return dataObject
     */
    public function getData()
    {
        return $this->model->get();
    }

    /*
     * city lists
     *
     * @return array
     */
    public function lists()
    {
        return $this->model->pluck('title', 'id');
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getAllData($request)
    {
        $query = DB::table('pages as p')
            ->select('p.id', 'p.title', 'p.slug', 'p.meta_description', 'p.meta_keyword', 'p.status');

        return Datatables::of($query)
            ->addColumn('action', function ($row) {
                $actions = '';
                $actions .= '<a href="" data-url="'.url('/'.$row->slug).'" id="page-preview" class="btn btn-xs btn-view" data-toggle="modal" data-target="#page-modal"><i class="text-green icon-eye fa-lg"></i></a>';
                $actions.= '<a href="' . route('pages.edit', [$row->id]) . '" class="btn btn-xs btn-edit" data-toggle="tooltip" title="Edit"><i class="text-orange fa fa-pencil-square-o fa-lg"></i></a>';

                return $actions;
            })
            ->editColumn('status', function ($row) {
                if ($row->status == 0) {
                    $status = '<span class="badge badge-danger">Draft</span>';
                } else if($row->status == 1) {
                    $status = '<span class="badge badge-success">Published</span>';
                } else {
                    $status = '';
                }
                return $status;
            })
            ->filter(function ($query) use ($request) {
                if ($request->get('title') !='') {
                    $query->where('p.title', $request->get('title'));
                }
                if ($request->get('meta_description') !='') {
                    $query->where('p.meta_description', $request->get('meta_description'));
                }
                if ($request->get('meta_keyword') !='') {
                    $query->where('p.meta_keyword', $request->get('meta_keyword'));
                }
                if ($request->get('status') !='') {
                    $query->where('p.status', $request->get('status'));
                }
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }


}
