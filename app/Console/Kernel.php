<?php

namespace App\Console;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('get:insights')->cron('28 13 * * *');
        $schedule->command('get:campaigns')->cron('25 20 * * *');
        $schedule->command('get:adsposts')->cron('28 07 * * *');
        $schedule->command('get:adsets')->cron('00 22 * * *');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
