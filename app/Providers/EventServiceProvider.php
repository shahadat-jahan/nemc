<?php

namespace App\Providers;

use App\Events\NotifyParentsWhenExamResultAnnounced;
use App\Events\NotifySuperAdminOnResultEditRequested;
use App\Events\NotifyUserOnEditPermissionGiven;
use App\Events\NotifyUserOnHolidayAnnounced;
use App\Events\NotifyUserWhenExamResultAnnounced;
use App\Events\NotifyUserWhenNoticePublished;
use App\Events\UpdateStudentCredit;
use App\Listeners\NotifyParentsWhenExamResultAnnouncedListener;
use App\Listeners\NotifySuperAdminOnResultEditRequestedListener;
use App\Listeners\NotifyUserOnEditPermissionGivenListener;
use App\Listeners\NotifyUserOnHolidayAnnouncedListener;
use App\Listeners\NotifyUserWhenExamResultAnnouncedListener;
use App\Listeners\NotifyUserWhenNoticePublishedListener;
use App\Listeners\UpdateStudentCreditListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        NotifyUserWhenNoticePublished::class => [
            NotifyUserWhenNoticePublishedListener::class
        ],
        NotifyUserOnHolidayAnnounced::class => [
            NotifyUserOnHolidayAnnouncedListener::class
        ],
        NotifyUserWhenExamResultAnnounced::class => [
            NotifyUserWhenExamResultAnnouncedListener::class
        ],
        NotifyParentsWhenExamResultAnnounced::class => [
            NotifyParentsWhenExamResultAnnouncedListener::class
        ],
        UpdateStudentCredit::class => [
            UpdateStudentCreditListener::class
        ],
        'Illuminate\Auth\Events\Login' => [
            'App\Listeners\LogSuccessfulLogin',
        ],
        'Illuminate\Auth\Events\Logout' => [
            'App\Listeners\LogSuccessfulLogout',
        ],
        NotifySuperAdminOnResultEditRequested::class => [
            NotifySuperAdminOnResultEditRequestedListener::class
        ],
        NotifyUserOnEditPermissionGiven::class => [
            NotifyUserOnEditPermissionGivenListener::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        //
    }
}
