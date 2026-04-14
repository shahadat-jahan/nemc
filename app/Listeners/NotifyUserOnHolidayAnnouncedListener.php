<?php

namespace App\Listeners;

use App\Events\NotifyUserOnHolidayAnnounced;
use App\Services\Admin\StudentService;
use App\Services\Admin\UserService;
use App\Services\NotificationService;
use App\Services\UtilityServices;

class NotifyUserOnHolidayAnnouncedListener
{

    protected $userService;
    protected $notificationService;
    protected $studentService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct( UserService $userService, StudentService $studentService, NotificationService $notificationService)
    {
        $this->userService = $userService;
        $this->notificationService = $notificationService;
        $this->studentService = $studentService;
    }

    /**
     * Handle the event.
     *
     * @param  NotifyUserOnHolidayAnnounced  $event
     * @return void
     */
    public function handle(NotifyUserOnHolidayAnnounced $event)
    {
        $users = [];
        if (!empty($event->holidayNotificationData->session_id) && !empty($event->holidayNotificationData->batch_type_id)){
            //get student with session id and batch type id
            $batchTypeStudents = $this->studentService->getStudentBySessionAndBatchTypeId($event->holidayNotificationData->session_id, $event->holidayNotificationData->batch_type_id);
            $users = collect($batchTypeStudents)->map(function ($item){
                return $item->user;
            });

        } elseif (!empty($event->holidayNotificationData->session_id)){
            //get student with session id
            $students = $this->studentService->getAllStudentBySessionId($event->holidayNotificationData->session_id);
            $users = collect($students)->map(function ($item){
                return $item->user;
            });
        } else{
            //get all user
            $users = $this->userService->getAllActiveUser();
        }
        //check current holiday  notification exist on notification table
        $check = $this->notificationService->checkHolidayNotificationExist($event->holidayNotificationData->id, $notification_type = 'holiday');
        if ($check <= 0){
            $message = "Holiday has been announced on <span class='font-weight-bold'>".$event->holidayNotificationData->from_date."</span> for <span class='font-weight-bold'>" . $event->holidayNotificationData->title . "</span>";
        }else{
            $message = "Event: <span class='font-weight-bold'>" . $event->holidayNotificationData->title . "</span> has been updated";

        }

        if (!empty($users)) {
            foreach ($users as $user) {
                $this->notificationService->create([
                    'notification_type' => 'holiday',
                    'user_id' => $user->id,
                    'resource_id' => $event->holidayNotificationData->id,
                    'resource_type' => UtilityServices::$notificationModels[2],
                    'message' => $message
                ]);

            }
        }
    }
}
