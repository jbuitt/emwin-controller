<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;
use App\Jobs\ProcessEmwinZipFileJob;

class RunIngester extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emwin-controller:run_ingester {client : Name of the download client to run}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the product ingester (npemwind, ftp-text, ftp-graphics, http-text, or http-graphics)';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        // Get the client that should be run
        $client = $this->argument('client');
        // Change directory to the base path
        chdir(base_path());
        //Log::debug(json_encode($procEnvVars));
        switch ($client) {
            case 'npemwin':
                // Set environment variables for npemwin client
                $procEnvVars = [
                    'EMWIN_PAN_RUN' => config('emwin-controller.pan_run'),
                    'EMWIN_BASE_DIR' => base_path(),
                ];
                // Rewrite servers.conf file with servers supplied in .env
                if (file_exists('/usr/local/etc/npemwin/servers.conf')) {
                    if (is_writable('/usr/local/etc/npemwin/servers.conf')) {
                        if (!is_null(config('emwin-controller.download_clients.npemwin.servers')) && !empty(config('emwin-controller.download_clients.npemwin.servers'))) {
                            $servers = explode(',', config('emwin-controller.download_clients.npemwin.servers'));
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
                if (config('emwin-controller.download_clients.npemwin.client_cmd') !== '') {
                    Log::info("Running command '" . config('emwin-controller.download_clients.npemwin.client_cmd') . "'..");
                    $process = Process::forever()
                        ->env($procEnvVars)
                        ->start(config('emwin-controller.download_clients.npemwin.client_cmd'));
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
                break;
            
            case 'ftp-text':
            case 'ftp-graphics':
            case 'http-text':
            case 'http-graphics':
                Log::info('The ' . $client . ' download client is being dispatched..');
                ProcessEmwinZipFileJob::dispatch($client, time());
                break;

            default:
                print 'Error: Invalid download client ' . $client . "\n";
                return 1;
        }
        // Done!
        return 0;
    }
}
