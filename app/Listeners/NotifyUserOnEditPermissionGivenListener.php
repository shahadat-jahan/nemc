<?php

namespace App\Listeners;

use App\Events\NotifyUserOnEditPermissionGiven;
use App\Models\ExamResult;
use App\Services\Admin\UserService;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class NotifyUserOnEditPermissionGivenListener
{
    protected UserService $userService;
    protected NotificationService $notificationService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(UserService $userService, NotificationService $notificationService)
    {
        $this->userService = $userService;
        $this->notificationService = $notificationService;
    }

    /**
     * Handle the event.
     *
     * @param NotifyUserOnEditPermissionGiven $event
     * @return void
     */
    public function handle(NotifyUserOnEditPermissionGiven $event): void
    {
        $notificationData = $event->notificationData;
        $userId = $event->userId;
        $user = $this->userService->find($userId);
        $approvedUser = Auth::user();
        $fullName = $this->resolveFullName($approvedUser);
        $message = $notificationData->hod_edit_permission ?
            "<strong>$fullName</strong> has given you result editing permission." :
            "<strong>$fullName</strong> has off your result editing permission.";

        if ($user) {
            $this->notificationService->create([
                'notification_type' => 'result/show/' . $notificationData->exam_id,
                'user_id' => $user->id,
                'resource_id' => $notificationData->subject_id,
                'resource_type' => ExamResult::class,
                'message' => $message
            ]);
        }
    }

    private function resolveFullName($user): string
    {
        if ($user->adminUser) {
            return $user->adminUser->full_name;
        }

        if ($user->teacher) {
            return $user->teacher->full_name;
        }

        return 'Super Admin';
    }
}
