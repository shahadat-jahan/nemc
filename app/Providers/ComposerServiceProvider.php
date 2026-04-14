<?php

namespace App\Providers;

use App\ViewComposers\ContactMessageComposer;
use App\ViewComposers\NotificationComposer;
use Illuminate\Support\ServiceProvider;
use View;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            'common.topbar', NotificationComposer::class
        );

        View::composer(
            'frontend.common.topbar', NotificationComposer::class
        );
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
