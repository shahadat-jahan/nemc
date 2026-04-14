<?php

namespace App\Listeners;

use App\Models\User;
use Auth;
use Carbon\Carbon;
use Config;
use Browser;
use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Spatie\Activitylog\Models\Activity;

class LogSuccessfulLogout
{
    /**
     * @var User
     */
    protected $model;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * Handle the event.
     *
     * @param  Logout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        $logoutInfo = [
            'logout_at' => Carbon::now()->toDateTimeString(),
            'ip' => request()->getClientIp(),
            'browser' => Browser::browserName(),
            'platform' => Browser::platformName(),
        ];
        activity()
            ->causedBy(Auth::guard('web')->user()->id ?? Auth::guard('student_parent')->user()->id)
            ->performedOn( $this->model)
            ->withProperties($logoutInfo)
            ->log('logout');
    }
}
