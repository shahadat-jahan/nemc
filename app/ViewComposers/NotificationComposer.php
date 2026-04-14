<?php
/**
 * Created by PhpStorm.
 * User: sharif
 * Date: 11/21/18
 * Time: 12:26 PM
 */

namespace App\ViewComposers;

use Illuminate\View\View;
use App\Services\Admin\NotificationService;

class NotificationComposer
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function compose(View $view) {
        return $view->with([
            'notifications'=> $this->notificationService->getAllNotifications(15),
            'unseenNotifications'=> $this->notificationService->getTotalUnseenNotifications(),
        ]);
    }
}
