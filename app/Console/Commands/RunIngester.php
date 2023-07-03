<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;

class RunIngester extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emwin-controller:daemon:run-ingester';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the EMWIN controller ingester (NOAAPort npemwind)';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        // Change directory to the base path
        chdir(base_path());
        // Set environment variables for config
        $procEnvVars = [
            'EMWIN_PAN_RUN' => config('emwin-controller.emwin.pan_run'),
            'EMWIN_BASE_DIR' => base_path(),
        ];
        //Log::debug(json_encode($procEnvVars));
        // Rewrite servers.conf file with servers supplied in .env
        if (file_exists('/usr/local/etc/npemwin/servers.conf')) {
            if (is_writable('/usr/local/etc/npemwin/servers.conf')) {
                if (!is_null(config('emwin-controller.emwin.servers')) && !empty(config('emwin-controller.emwin.servers'))) {
                    $servers = explode(',', config('emwin-controller.emwin.servers'));
                    for ($i=0; $i<count($servers); $i++) {
                        $servers[$i] = str_replace(':', "\t", $servers[$i]);
                    }
                    file_put_contents('/usr/local/etc/npemwin/servers.conf', implode("\n", $servers));
                } else {
                    Log::info('Server list is empty, skipping update.');
                }
            } else {
                Log::warning('The file servers.conf is not writable. Skipping update.');
            }
        } else {
            Log::error('The file servers.conf does not exist!');
            return 1;
        }
        // Start process and append output to log
        if (config('emwin-controller.npemwind_cmd') !== '') {
            Log::info("Running command '" . config('emwin-controller.npemwind_cmd') . "'..");
            $process = Process::forever()
                ->env($procEnvVars)
                ->start(config('emwin-controller.npemwind_cmd'));
            // Perform tasks while process is running
            while ($process->running()) {
                //Log::info($process->latestOutput());
                //Log::error($process->latestErrorOutput());
                sleep(1);
            }
            // Wait for process to end (crash or receive TERM/KILL signal)
            $result = $process->wait();
            Log::info('EMWIN Ingester process stopped.');
        } else {
            Log::error('EMWIN Ingester client path is not defined, exiting.');
            return 1;
        }
        // Done!
        return 0;
    }
}
