<?php

namespace App\Services\Admin;

use App\Models\BatchType;
use App\Services\BaseService;
use DataTables;

/**
 * Class UserService
 * @package App\Services\Admin
 */
class BatchTypeService extends BaseService {

    /**
     * @var $model
     */
    protected $model;
    /**
     * @var string
     */
    //protected $url = 'admin/topic';


    public function __construct(BatchType $batchType)
    {
        $this->model = $batchType;
    }


    /**
     *
     * @return JsonResponse
     */

    //get all batch type
    public function getAllBatchType() {

        return $this->model->where('status', 1)->get();
    }

}
