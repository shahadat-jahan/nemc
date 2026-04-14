<?php
/**
 * Created by PhpStorm.
 * User: lokmanhosen
 * Date: 2/26/19
 * Time: 2:54 PM
 */

namespace App\Services;


use App\Models\Notification;

class NotificationService extends BaseService
{

    public function __construct(Notification $notification)
    {
        $this->model = $notification;
    }

    //check holiday exist in notification table
    public function checkHolidayNotificationExist($resource_id, $notification_type){
        return $this->model->where([
            ['resource_id', $resource_id],
            ['notification_type','like', $notification_type],
        ])->count();
    }

    //check notice exist in notification table
    public function checkNoticeNotificationExist($resource_id, $notification_type){
        return $this->model->where([
            ['resource_id', $resource_id],
            ['notification_type','like', $notification_type],
        ])->count();
    }
}
