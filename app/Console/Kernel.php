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
        // $schedule->command('inspire')->hourly();
        logStore("Cron Job Started");
        $schedule->command('app:staking-job')->everyTenMinutes();
        $schedule->command('app:coin-price-update-from-coin-cap-market')->everyMinute();
        // $schedule->command('app:currency-price-update-from-coin-cap-market')->everyMinute();
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
