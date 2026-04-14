<?php

namespace App\Listeners;

use App\Models\User;
use Auth;
use Carbon\Carbon;
use Config;
use Browser;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Session;
use Spatie\Activitylog\Models\Activity;

class LogSuccessfulLogin
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
     * @param Login $event
     * @return void
     */
    public function handle(Login $event)
    {
        $loginInfo = [
            'login_at' => Carbon::now()->toDateTimeString(),
            'ip' => request()->getClientIp(),
            'browser' => Browser::browserName(),
            'platform' => Browser::platformName(),
        ];
        activity()
            ->causedBy(Auth::guard('web')->user()->id ?? Auth::guard('student_parent')->user()->id)
            ->performedOn( $this->model)
            ->withProperties($loginInfo)
            ->log('login');
    }
}
