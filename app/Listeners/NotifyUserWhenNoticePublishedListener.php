<?php

namespace App\Listeners;

use App\Events\NotifyUserWhenNoticePublished;
use App\Services\Admin\StudentService;
use App\Services\Admin\TeacherService;
use App\Services\Admin\UserService;
use App\Services\NotificationService;
use App\Services\UtilityServices;

class NotifyUserWhenNoticePublishedListener
{

    protected $userService;
    protected $notificationService;
    protected $studentService;
    protected $teacherService;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(UserService    $userService, NotificationService $notificationService,
                                StudentService $studentService, TeacherService $teacherService)
    {

        $this->userService = $userService;
        $this->notificationService = $notificationService;
        $this->studentService = $studentService;
        $this->teacherService = $teacherService;
    }

    /**
     * Handle the event.
     *
     * @param  NotifyUserWhenNoticePublished  $event
     * @return void
     */
    public function handle(NotifyUserWhenNoticePublished $event)
    {
        $notificationData = $event->notificationData;
        $users = collect();

        // Get users based on session and batch type
        if (!empty($notificationData->session_id) && !empty($notificationData->batch_type_id)) {
            $students = $this->studentService->getStudentBySessionAndBatchTypeId($notificationData->session_id, $notificationData->batch_type_id);
            $users = $this->getUsersByStudents($students);
            // Get users based on session, course, and phase
        } elseif (!empty($notificationData->session_id) && !empty($notificationData->course_id) && !empty($notificationData->phase_id)) {
            $students = $this->studentService->getAllStudentsBySessionCoursePhase(
                $notificationData->session_id,
                $notificationData->course_id,
                $notificationData->phase_id
            );
            $users = $this->getUsersByStudents($students);
            // Get users based on session and department IDs (students + teachers)
        } elseif (!empty($notificationData->session_id) && !empty($notificationData->department_ids)) {
            $students = $this->studentService->getAllStudentBySessionId($notificationData->session_id);
            $teachers = $this->teacherService->getTeachersByDepartmentIds($notificationData->department_ids);

            $users = $this->getUsersByStudents($students)
                          ->merge($this->getUsersByTeachers($teachers));
            // Get users based on session alone
        } elseif (!empty($notificationData->session_id)) {
            $students = $this->studentService->getAllStudentBySessionId($notificationData->session_id);
            $users = $this->getUsersByStudents($students);
            // Get users based on department alone (teachers)
        } elseif (!empty($notificationData->department_ids)) {
            $teachers = $this->teacherService->getTeachersByDepartmentIds($notificationData->department_ids);
            $users = $this->getUsersByTeachers($teachers);
            // Default case: Get all active users
        } else {
            $users = collect($this->userService->getAllActiveUser());
        }

        $message = $this->composeNotificationMessage($notificationData);

        if ($users->isNotEmpty()) {
            foreach ($users as $user) {
                $this->notificationService->create([
                    'notification_type' => 'notice_board',
                    'user_id' => $user->id,
                    'resource_id' => $notificationData->id,
                    'resource_type' => UtilityServices::$notificationModels[1],
                    'message' => $message
                ]);
            }
        }
    }

    private function getUsersByStudents($students)
    {
        return collect($students)->map(function ($student) {
            return $student->user;
        });
    }

    private function getUsersByTeachers($teachers)
    {
        return collect($teachers)->map(function ($teacher) {
            return $teacher->user;
        });
    }

    private function composeNotificationMessage($notificationData)
    {
        $exists = $this->notificationService->checkNoticeNotificationExist(
            $notificationData->id,
            'notice_board'
        );

        return $exists <= 0
            ? "Notice: <span class='font-weight-bold'>{$notificationData->title}</span> has been published"
            : "Notice: <span class='font-weight-bold'>{$notificationData->title}</span> has been updated";
    }

}
