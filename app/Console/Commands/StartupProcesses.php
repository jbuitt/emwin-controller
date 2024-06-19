<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Traits\AppConfigTrait;
use App\Traits\DaemonTrait;

class StartupProcesses extends Command
{
    use AppConfigTrait,
        DaemonTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emwin-controller:startup:processes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute startup processes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Loop through all enabled download clients, check for autostart
        foreach (explode(',', config('emwin-controller.download_clients_enabled')) as $client) {
            if ($client === 'npemwin') {
                if (config('emwin-controller.download_clients.npemwin.autostart')) {
                    // Make sure PID file is absent since npemwin won't start if it's present
                    // The file may exist if npemwin is not shut down properly
                    if (file_exists('/var/run/npemwin/npemwind.pid')) {
                        unlink('/var/run/npemwin/npemwind.pid');
                    }
                    // Execute command
                    print "Auto-starting client npemwin..\n";
                    print json_encode($this->executeArtisanCommand('start')) . "\n";
                } else {
                    print "Autostart is not enabled for client {$client}.\n";
                }
            } elseif (preg_match('/^(http|ftp)-/', $client, $matches)) {
                if (config('emwin-controller.download_clients.' . $matches[1] . '.autostart')) {
                    print "Auto-starting client $client..\n";
                    $this->setAppConfigValue('scheduledDownloadsFlag', 1);
                } else {
                    print "Autostart is not enabled for client $client.\n";
                }
            }
        }
        // Sleep for 60 seconds so supervisord doesn't think the process stopped too quickly
        print "Sleeping for 60 seconds..\n";
        sleep(60);
        // Done
        return 0;
    }

}
