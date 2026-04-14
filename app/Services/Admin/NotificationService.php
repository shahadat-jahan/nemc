<?php

/**
 * Created by PhpStorm.
 * User: office
 * Date: 11/20/18
 * Time: 12:06 PM
 */

namespace App\Services\Admin;

use App\Models\NoticeBoard;
use App\Models\Notification;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;

//use Auth;

/**
 * Class NotificationService
 * @package App\Services\Admin
 */
class NotificationService extends BaseService
{

    /**
     * NotificationService constructor.
     * @param Notification $notification
     */
    public function __construct(Notification $notification)
    {
        $this->model = $notification;
    }

    /**
     * @return mixed
     */
    public function getUnseenNotifications($limit = null)
    {
        return $this->model->where('user_id', $this->_getUserId())->where('is_seen', 0)->limit($limit)->get();
    }

    public function getTotalUnseenNotifications()
    {
        return $this->model->where('user_id', $this->_getUserId())->where('is_seen', 0)->count();
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function getAllNotifications($limit = null)
    {
        return $this->model
            ->where('user_id', $this->_getUserId())
            ->where(function ($query) {
                // For NoticeBoard notifications, only include if status = 1
                $query->where(function ($q) {
                    $q->where('resource_type', \App\Models\NoticeBoard::class)
                      ->whereHasMorph(
                          'resource',
                          [\App\Models\NoticeBoard::class],
                          function ($subQuery) {
                              $subQuery->where('status', 1);
                          }
                      );
                })
                // For all other notifications, include as usual
                ->orWhere(function ($q) {
                    $q->where('resource_type', '!=', \App\Models\NoticeBoard::class)
                      ->orWhereNull('resource_type');
                });
            })
            ->limit($limit)
            ->latest()
            ->get();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getNotificationById($id)
    {
        return $this->model->find($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function markNotificationAsSeen($id)
    {
        return $this->model->where('id', $id)->update(['is_seen' => 1]);
    }

    /**
     * @param $limit
     * @return mixed
     */
    public function getLatestNotifications($limit)
    {
        return $this->model->where('user_id', $this->_getUserId())
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * @param $resourceId
     * @return mixed
     */
    public function setNotificationAsSeen($id)
    {
        return $this->model->where('id', $id)->update(['is_seen' => 1]);
    }

    protected function _getUserId()
    {
        if (Auth::guard('student_parent')->check()) {
            $userId = Auth::guard('student_parent')->check() ? Auth::guard('student_parent')->user()->id : '';
        } else {
            $userId = Auth::guard('web')->check() ? Auth::user()->id : '';
        }

        return $userId;
    }

    public function updateSeenStatus($userId)
    {
        return $this->model->where('user_id', $userId)->where('is_seen', 0)->update(['is_seen' => 1]);
    }
}
