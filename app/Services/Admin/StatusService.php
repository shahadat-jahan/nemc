<?php

namespace App\Services\Admin;

use App\Models\Status;
use App\Services\BaseService;
use DataTables;

/**
 * Class UserService
 * @package App\Services\Admin
 */
class StatusService extends BaseService {

    /**
     * @var $model
     */
    protected $model;
    /**
     * @var string
     */
    protected $url = 'admin/status';


    public function __construct(Status $status)
    {
        $this->model = $status;
    }
    public  function statusList($status_group_id){
        return $this->model->where('status_group_id', $status_group_id)->orderBy('id', 'asc')->pluck('status_name', 'id');
    }
}
