<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

trait DaemonTrait
{
    /**
    * Perform the process action
    *
    * @return array
    */
    public function executeArtisanCommand($command): array
    {
        //print "**DEBUG** \$command = $command\n";
        // Check to make sure that valid command was passed
        if (!in_array($command, ['status', 'start', 'stop'])) {
            return array(
                'statusCode' => 400,
                'message' => 'Bad Request',
                'details' => [
                    'status' => 'Error',
                    'result' => 'Invalid command ' . $command,
                    'pid' => -1,
                ],
            );
        }
        // Perform command on config and return value
        return $this->performDeamonCommand($command);
    }

   /**
    * Perform the daemon command
    *
    * @param string $command The command to perform
    * @return array The return data
    */
    public function performDeamonCommand($command): array
    {
        $pidFile = '/var/run/npemwin/npemwind.pid';
        $logFile = storage_path() . '/logs/npemwind-' . Carbon::now()->format('Y-m-d') . '.log';
        $running = FALSE;
        $pid = -1;
        switch($command) {
            case 'status':
                exec("ps -ef | grep '[n]pemwind -F'", $output);
                if (!empty($output) && file_exists($pidFile)) {
                    $pid = intval(file_get_contents($pidFile));
                    return array(
                        'statusCode' => 200,
                        'message' => 'OK',
                        'details' => array(
                            'status' => 'Running',
                            'result' => "PID = $pid",
                            'pid' => $pid,
                        ),
                    );
                } else {
                    return array(
                        'statusCode' => 200,
                        'message' => 'OK',
                        'details' => array(
                            'status' => 'Stopped',
                            'result' => "process not found or PID file does not exist",
                            'pid' => -1,
                        ),
                    );
                }
                break;

            case 'start':
                // Check to see if process is already running
                exec("ps -ef | grep '[n]pemwind -F'", $output);
                if (!empty($output) && file_exists($pidFile)) {
                    $pid = intval(file_get_contents($pidFile));
                    return array(
                        'statusCode' => 409,
                        'message' => 'Conflict',
                        'details' => array(
                            'status' => 'Error',
                            'result' => "The process is already running",
                            'pid' => $pid,
                        ),
                    );
                } else {
                    // Change directory to base_path
                    chdir(base_path());
                    // Start NWWS-OI ingester
                    exec('./artisan emwin-controller:run_ingester npemwin >' . $logFile . ' 2>&1 &', $output, $retval);
                    // Check return value
                    if ($retval !== 0) {
                        return array(
                            'statusCode' => 500,
                            'message' => 'Server Error',
                            'details' => array(
                                'status' => 'Error',
                                'result' => "The process failed to start: " . implode(', ', $output),
                                'pid' => -1,
                            ),
                        );
                    }
                    // Loop for 5 seconds or until process starts
                    for ($i=0; $i<5; $i++) {
                        exec("ps -ef | grep '[n]pemwind -F'", $output);
                        if (!empty($output) && file_exists($pidFile)) {
                            $pid = intval(file_get_contents($pidFile));
                            $running = TRUE;
                            break;
                        }
                        sleep(1);
                    }
                    // Return result
                    if ($running) {
                        return array(
                            'statusCode' => 200,
                            'message' => 'OK',
                            'details' => array(
                                'status' => 'Running',
                                'result' => "PID = $pid",
                                'pid' => $pid,
                            ),
                        );
                    } else {
                        return array(
                            'statusCode' => 500,
                            'message' => 'Server Error',
                            'details' => array(
                                'status' => 'Error',
                                'result' => "The process did not start after 5 seconds",
                                'pid' => -1,
                            ),
                        );
                    }
                }
                break;

            case 'stop':
                // Before attempting to stop, make sure process is running
                $running = TRUE;
                exec("ps -ef | grep '[n]pemwind'", $output);
                if (empty($output) || !file_exists($pidFile)) {
                    return array(
                        'statusCode' => 409,
                        'message' => 'Conflict',
                        'details' => array(
                            'status' => 'Error',
                            'result' => "Process is not running or PID file does not exist",
                            'pid' => -1,
                        ),
                    );
                }
                // Process is running and pid file exists, attempt to stop it
                $pid = file_get_contents($pidFile);
                exec('kill -TERM ' . $pid);
                // Wait until process stops and PID goes away
                for ($i=0; $i<5; $i++) {
                    // Sleep for 1 second
                    sleep(1);
                    // Check for running process
                    exec("ps -ef | grep '[n]pemwind -F'", $output);
                    if (empty($output) && !file_exists($pidFile)) {
                        $running = FALSE;
                        break;
                    }
                    unset($output);
                }
                // If npemwind and bbserver processes are still running, forcefully end them
                if ($running) {
                    exec('killall -9 npemwind bbserver');
                    // Manually remove PID file
                    unlink('/var/run/npemwin/npemwind.pid');
                    // Check one more time that npemwind is not running
                    exec("ps -ef | grep '[n]pemwind -F'", $output);
                    if (empty($output)) {
                        $running = FALSE;
                    }

                }
                // Return
                if (!$running) {
                    return array(
                        'statusCode' => 200,
                        'message' => 'OK',
                        'details' => array(
                            'status' => 'Stopped',
                            'result' => "",
                            'pid' => -1,
                        ),
                    );
                } else {
                    return array(
                        'statusCode' => 500,
                        'message' => 'Server Error',
                        'details' => array(
                            'status' => 'Error',
                            'result' => "The process did not stop after 5 seconds",
                            'pid' => -1,
                        ),
                    );
                }
                break;
        }
    }

    /**
     * Enable the scheduling of downloads (ftp and/or http)
     */
    public function enableScheduledDownloads(): void
    {
        Cache::put('scheduled_downloads_flag', 'true');
    }

    /**
     * Disable the scheduling of downloads (ftp and/or http)
     */
    public function disableScheduledDownloads(): void
    {
        Cache::put('scheduled_downloads_flag', 'false');
    }

}
