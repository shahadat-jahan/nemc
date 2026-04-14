<?php
/**
 * Created by PhpStorm.
 * User: office
 * Date: 4/26/19
 * Time: 4:48 PM
 */

namespace App\Services;

use App\Models\CronLog;

class CronLogService extends BaseService
{

    public function __construct(CronLog $cronLog)
    {
        $this->model = $cronLog;
    }
}