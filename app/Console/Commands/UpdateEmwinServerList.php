<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use App\Models\Config;
use GuzzleHttp\Exception\ConnectException;

class UpdateEmwinServerList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emwin-controller:update_emwin_server_list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates a EMWIN-Controller with the current server list';

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
     * @return int
     */
    public function handle(): int
    {
        // Get current EMWIN ByteBlaster server list from Weather Message website
        $serverList = $this->getCurrentEmwinServerList();
        //var_dump($serverList);
        if (!empty($serverList)) {
            $servers = implode(',', $serverList);
            // Update config
            print "Updating servers to '$servers'..\n";
            // Rewrite the servers.conf file
            $outfile = fopen('/usr/local/etc/npemwin/servers.conf', 'w');
            foreach ($servers as $hostAndPort) {
                list($host, $port) = explode(':', $hostAndPort);
                fwrite($outfile, "$host\t$port\n");
            }
            fclose($outfile);
            // Replace server list in the .env file and reload cache
            file_put_contents(
                app()->environmentFilePath(), 
                str_replace(
                    'NPEMWIN_CLIENT_SERVERLIST=' . config('emwin-controller.download_clients.npemwin.servers'), 
                    'NPEMWIN_CLIENT_SERVERLIST=' . $serverList, 
                    file_get_contents(app()->environmentFilePath())
                )
            );
            Artisan::call('config:cache');
        }
        // Done!
        return 0;
   }


    /**
     * Gets the list of current EMWIN ByteBlaster servers.
     */
    private function getCurrentEmwinServerList(): array
    {
        $url = 'https://www.weathermessage.com/Support/EMWINInternetStatus.aspx';
        try {
            $response = Http::timeout(10)->retry(3, 1000)->get($url);
        } catch (ConnectException $e) {
            $errorType = 'connect';
            Log::error('Connect exception performing GET ' . $uri . ' : ' . $e->getMessage());
        } catch (RequestException $e) {
            $errorType = 'request';
            Log::error('Request exception performing GET ' . $uri . ' : ' . $e->getMessage());
        }
        $serverList = [];
        $htmlLines = explode("\n", $response->body());
        for ($i=0; $i<count($htmlLines); $i++) {
            //print "**DEBUG** \$htmlLines[$i] = $htmlLines[$i]\n";
            if (preg_match('/<td width="25%"><font color="Blue">([0-9.]+)<\/font><\/td><td width="35%"><font color="Blue">(.*)<\/font><\/td><td align="center" width="15%"><font color="Blue">(\d+)<\/font><\/td>/', $htmlLines[$i], $matches)) {
                if ($matches[1] !== '0.0.0.0') {
                    array_push($serverList, $matches[1] . ':' . $matches[3]);
                }
            }
        }
        return $serverList;
   }

}
