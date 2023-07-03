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
        // Prune telescope entries
        $schedule
            ->command('telescope:prune')
            ->daily();

        // Purge old log files
        $schedule
            ->command('emwin-controller:purge_old_logs ' . config('emwin-controller.emwin.keep_logs_days'))
            ->daily();

        // Purge old products
        $schedule
            ->command('emwin-controller:purge_old_products ' . config('emwin-controller.emwin.keep_products_days'))
            ->daily();
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
