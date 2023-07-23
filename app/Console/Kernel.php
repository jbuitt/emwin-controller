<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\ProcessEmwinZipFileJob;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Snapshot data for Horizon
        $schedule
            ->command('horizon:snapshot')
            ->everyFiveMinutes();

        // Prune telescope entries
        if ($this->app->environment('local')) {
            $schedule
                ->command('telescope:prune')
                ->daily();
        }

        // Check to see if either of the text download clients are enabled
        if (preg_match('/(ftp|http)-text/', config('emwin-controller.download_clients_enabled'), $matches)) {
            $schedule
                ->command('emwin-controller:run_ingester ' . $matches[1] . '-text')
                ->everyTwoMinutes();
        }

        // Check to see if either of the graphics download clients are enabled
        if (preg_match('/(ftp|http)-graphics/', config('emwin-controller.download_clients_enabled'), $matches)) {
            $schedule
                ->command('emwin-controller:run_ingester ' . $matches[1] . '-graphics')
                ->everyFifteenMinutes();
        }

        // Purge old log files
        $schedule
            ->command('emwin-controller:purge_old_logs ' . config('emwin-controller.keep_logs_days'))
            ->daily();

        // Purge old products
        $schedule
            ->command('emwin-controller:purge_old_products ' . config('emwin-controller.keep_products_days'))
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
