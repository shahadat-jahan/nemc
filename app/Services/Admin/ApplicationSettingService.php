<?php

namespace App\Services\Admin;

use App\Models\ApplicationSetting;
use App\Models\ExamSubType;
use App\Models\Topic;
use App\Models\TopicHead;
use App\Services\BaseService;
use DataTables;

/**
 * Class UserService
 * @package App\Services\Admin
 */
class ApplicationSettingService extends BaseService {

    /**
     * @var $model
     */
    protected $model;
    /**
     * @var string
     */
    protected $url = 'admin/application_setting';


    /**
     * TopicService constructor.
     * @param Topic $topic
     */
    public function __construct(ApplicationSetting $applicationSetting)
    {
        $this->model = $applicationSetting;
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
                if (hasPermission('application_setting/edit')) {
                    $actions.= '<a href="' . route('application_setting.edit', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>';
                }
                return $actions;
            })

            /*->editColumn('topic_head_id', function ($row) {
                return isset($row->topicHead) ?  $row->topicHead->title : '';
            })
            ->editColumn('assigned_to', function ($row) {
                return isset($row->teachers) ?  $row->teachers->first()['full_name'] : '';
            })*/
            ->editColumn('status', function ($row) {
                return setStatus($row->status);
            })
            ->rawColumns(['status', 'action', 'description'])


            ->make(true);
    }






}
