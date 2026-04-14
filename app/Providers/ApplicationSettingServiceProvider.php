<?php
/**
 * Created by PhpStorm.
 * User: office
 * Date: 3/14/19
 * Time: 3:08 PM
 */

namespace App\Providers;


use App\Services\Setting\Setting;
use Illuminate\Support\ServiceProvider;

class ApplicationSettingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('setting', Setting::class);
    }
}