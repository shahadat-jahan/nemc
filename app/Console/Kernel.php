<?php

namespace App\Console;

use App\Console\Commands\GenerateMonthlyLateFee;
use App\Console\Commands\GenerateMonthlyTuitionFee;
use App\Console\Commands\PaymentByStudentCredit;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        GenerateMonthlyTuitionFee::class,
        GenerateMonthlyLateFee::class,
        PaymentByStudentCredit::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('nemc:monthly-tuition-fee')->monthlyOn(1, '1:00')->withoutOverlapping();
        $schedule->command('nemc:monthly-late-fee')->monthlyOn(1, '3:00')->withoutOverlapping();
        $schedule->command('nemc:student-advanced-payment')->monthlyOn(1, '5:00')->withoutOverlapping();

        // Run backup
        $schedule->command('backup:run')->twiceDaily(01, 14);
        // Clean up old backups
        $schedule->command('backup:clean')->daily()->at('03:00');
        // Empty Google Drive trash
        $schedule->command('google:empty-trash')->dailyAt('03:30');

        //$schedule->command('nemc:send-sms')->days(1, '22:00')->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
