<?php

namespace App\Listeners;

use App\Events\NotifySuperAdminOnResultEditRequested;
use App\Services\Admin\UserService;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;
use App\Models\ExamResult;

class NotifySuperAdminOnResultEditRequestedListener
{

    protected UserService $userService;
    protected NotificationService $notificationService;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(UserService  $userService, NotificationService $notificationService)
    {
        $this->userService = $userService;
        $this->notificationService = $notificationService;
    }

    /**
     * Handle the event.
     *
     * @param  NotifySuperAdminOnResultEditRequested  $event
     * @return void
     */
    public function handle(NotifySuperAdminOnResultEditRequested $event): void
    {
        $notificationData = $event->notificationData;
        $superAdmins = $this->userService->findBy(['user_group_id' => 1], 'all');
        $requestingUser = Auth::user();
        $fullName = $this->resolveFullName($requestingUser);
        $message = "<strong>$fullName</strong> has submitted request for result editing permission.";

        if ($superAdmins->isNotEmpty()) {
            foreach ($superAdmins as $superAdmin) {
                $this->notificationService->create([
                    'notification_type' => 'result/show/' . $notificationData->exam_id,
                    'user_id' => $superAdmin->id,
                    'resource_id' => $notificationData->subject_id,
                    'resource_type' => ExamResult::class,
                    'message' => $message,
                ]);
            }
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

        return 'User';
    }
}
