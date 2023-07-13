<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Events\NewProductArrived;
use App\Models\Product;
use Carbon\Carbon;
use PhpZip\ZipFile;
use PhpZip\Exception\ZipException;

class ProcessEmwinZipFileJob implements ShouldQueue
{
    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;

    private $client = '';
    private $timeStamp = '';

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($client, $timeStamp)
    {
        $this->client = $client;
        $this->timeStamp = $timeStamp;
    }

    /**
     * Execute the job.
     */
    public function handle(): int
    {
        $startTime = Carbon::now();
        $fileType = '';
        // Determine file type
        if (preg_match('/^(ftp|http)-(text|graphics)/', $this->client, $matches)) {
            $client = $matches[1];
            $fileType = $matches[2];
            $logChannel = 'emwin' . $fileType . 'log';
        } else {
            return 1;
        }
        // Get desired zip file name
        if ($fileType === 'text') {
            $zipFile = config(
                'emwin-controller.download_clients.' . $client . '.text_products_file'
            );
        } elseif ($fileType === 'graphics') {
            $zipFile = config(
                'emwin-controller.download_clients.' . $client . '.graphic_products_file'
            );
        }
        // Get config values
        $archiveDirectory = config(
            'emwin-controller.archive_directory'
        );
        $fileSaveRegex = config(
            'emwin-controller.file_save_regex'
        );
        $tempDirectory = config(
            'emwin-controller.download_clients.' . $client . '.temp_directory'
        );
        $serverHostname = config(
            'emwin-controller.download_clients.' . $client . '.server_hostname'
        );
        $serverProtocol = config(
            'emwin-controller.download_clients.' . $client . '.server_protocol'
        );
        $serverPassiveMode = config(
            'emwin-controller.download_clients.' . $client . '.server_passive_mode'
        );
        $serverUsername = config(
            'emwin-controller.download_clients.' . $client . '.server_username'
        );
        $serverPassword = config(
            'emwin-controller.download_clients.' . $client . '.server_password'
        );
        $serverProductsPath = config(
            'emwin-controller.download_clients.' . $client . '.server_products_path'
        );
        Log::channel($logChannel)->info('Processing new ' . $fileType . ' file..');
        // Check job timestamp
        Log::channel($logChannel)->info('Checking job timestamp..');
        $diffSeconds = time() - $this->timeStamp;
        if ((time() - $this->timeStamp) > 10) {
            Log::channel($logChannel)->info('Job is older than 10 seconds, (' . $diffSeconds . ') skipping.');
            return 0;
        } else {
            Log::channel($logChannel)->info('Job timestamp is newer than 10 seconds, (' . $diffSeconds . ') continuing..');
        }
        // Check for temp directory
        if (!file_exists(storage_path($tempDirectory) . '/' . $fileType)) {
            Log::channel($logChannel)->info('Creating temp directory ' . storage_path($tempDirectory) . '/' . $fileType . '/..');
            mkdir(storage_path($tempDirectory . '/' . $fileType), 0755, true);
            Log::channel($logChannel)->info('Created.');
        } else {
            Log::channel($logChannel)->info('Found temporary directory ' . storage_path($tempDirectory) . ' making sure it is empty..');
            // Remove all existing temp files
            $tempFiles = glob(storage_path($tempDirectory) . '/' . $fileType . '/*.*');
            for($i=0; $i<count($tempFiles); $i++) {
                unlink($tempFiles[$i]);
            }
        }
        // Check for products directory
        if (!file_exists(storage_path($archiveDirectory))) {
            Log::channel($logChannel)->info('Creating products directory ' . $archiveDirectory . '..');
            mkdir(storage_path($archiveDirectory), 0755, true);
            Log::channel($logChannel)->info('Created.');
        }
        Log::channel($logChannel)->info('Connecting to ' . $serverHostname . ' via ' . $serverProtocol . '..');
        // Connect to EMWIN server
        if (preg_match('/^ftp/', $this->client)) {
            $connId = ftp_connect($serverHostname);
            if (!$connId) {
                Log::channel($logChannel)->error('Could not connect to server, exiting.');
                return 1;
            }
            Log::channel($logChannel)->info('Connected.');
            Log::channel($logChannel)->info('Logging into server..');
            if (!@ftp_login($connId, $serverUsername, $serverPassword)) {
                Log::channel($logChannel)->error('Could not login to server, exiting.');
                return 1;
            }
            Log::channel($logChannel)->info('Logged in.');
            // Turn passive mode on?
            if ($serverPassiveMode) {
                Log::channel($logChannel)->info('Setting passive mode..');
                if (!ftp_pasv($connId, true)) {
                    Log::channel($logChannel)->error('Could not set passive mode, exiting.');
                    return 1;
                }
                Log::channel($logChannel)->info('Passive mode set.');
            }
            // Try to download $server_file and save to $local_file
            Log::channel($logChannel)->info('Downloading zip file via FTP..');
            if (ftp_get($connId, storage_path($tempDirectory) . '/' . $fileType . '/' . $zipFile, $serverProductsPath . '/' . $zipFile, FTP_BINARY)) {
                Log::channel($logChannel)->info('File downloaded.');
            } else {
                Log::channel($logChannel)->error('Could not download remote file, exiting');
                return 1;
            }
            // Close the connection
            ftp_close($connId);
            Log::channel($logChannel)->info('Disconnected.');
        } elseif (preg_match('/^http/', $this->client)) {
            Log::channel($logChannel)->info('Connected.');
            Log::channel($logChannel)->info('Downloading zip file http://' . $serverHostname . '/' . $serverProductsPath . '/' . $zipFile . '..');
            $zipFileFullPath = storage_path($tempDirectory) . '/' . $fileType . '/' . $zipFile;
            exec('/usr/bin/curl -s -L -o ' . $zipFileFullPath . ' http://' . $serverHostname . '/' . $serverProductsPath . '/' . $zipFile);
            if (file_exists($zipFileFullPath) && filesize($zipFileFullPath) > 0) {
                Log::channel($logChannel)->info('Products file saved to ' . $zipFileFullPath);
            } else {
                Log::channel($logChannel)->error('Could not download remote file or file was empty.');
                return 1;
            }
        } else {
            Log::channel($logChannel)->error('Invalid protocol ' . $serverProtocol);
            return 1;
        }
        // Loop through extracted files and unzip any ZIP files found, and keep doing this until there aren't any ZIP files left
        // TODO: Add checking for endless loop
        Log::channel($logChannel)->info('Starting to extract files..');
        while(true) {
            // Get list of ZIP files in the temp directory
            $zipFiles = glob(storage_path($tempDirectory) . '/' . $fileType . '/*.{zip,ZIP}', GLOB_BRACE);
            Log::channel($logChannel)->info('Found ' . count($zipFiles) . ' files..');
            // Unzip and delete each ZIP file found
            for ($i=0; $i<count($zipFiles); $i++) {
                // Attempt to extract file
                Log::channel($logChannel)->info('Extracting file ' . basename($zipFiles[$i]) . ' to ' . storage_path($tempDirectory) . '/' . $fileType . '/..');
                // Check for empty files
                if (filesize($zipFiles[$i]) === 0) {
                    Log::channel($logChannel)->warning('The file ' . $zipFiles[$i] . ' is empty, deleting and skipping.');
                    unlink($zipFiles[$i]);
                    continue;
                }
                // Attempt to open the zip file and extract its contents
                $zipFile = new ZipFile();
                try {
			        $zipFile->openFile($zipFiles[$i]);
                    $zipFile->extractTo(storage_path($tempDirectory) . '/' . $fileType);
                    $zipFile->close();
                } catch (ZipException $e) {
                    Log::channel($logChannel)->error('Failed to open or extract file, deleting (' . $e->getMessage() . ')');
                    unlink($zipFiles[$i]);
                    continue;
                }
                Log::channel($logChannel)->info('Deleting file ' . basename($zipFiles[$i]) . ' ..');
                unlink($zipFiles[$i]);
            }
            // If there aren't any more ZIP files, break out of loop
            if (count($zipFiles) === 0) {
                Log::channel($logChannel)->info('No more zip files found, continuing..');
                break;
            }
        }
        // Get list of all extracted files (both text and/or images)
        $tempFiles = glob(storage_path($tempDirectory) . '/' . $fileType . '/*.*');
        Log::channel($logChannel)->info('Found ' . count($tempFiles) . ' products..');
        $productsInventoried = 0;
        for ($i=0; $i<count($tempFiles); $i++) {
            $c = $i + 1;
            $productFile = basename($tempFiles[$i]);
            //           1         2         3         4         5         6
            // 01234567890123456789012345678901234567890123456789012345678901
            // A_SAUS70KWBC090100_C_KWIN_20200309011402_211479-2-SAHOURLY.TXT
            // Z_EINA00KWBC090115_C_KWIN_20200409131530_530706-4-G16CIRUS.JPG
            $wfo = strtolower(substr($productFile, 8, 4));
            if (!file_exists(storage_path($archiveDirectory) . '/' . $wfo)) {
                mkdir(storage_path($archiveDirectory) . '/' . $wfo, 0755, true);
            }
            // Check for existing file in filesystem
            if (file_exists(storage_path($archiveDirectory) . '/' . $wfo . '/' . $productFile)) {
                Log::channel($logChannel)->notice('Destination file ' . $productFile . ' already exists, skipping..');
                continue;
            } else {
                // If product is a text file, run dos2unix on it to change \r\n to \n
                if (preg_match('/\.TXT$/', $productFile)) {
                    Log::channel($logChannel)->info('Running dos2unix to remove carriage returns..');
                    exec('/usr/bin/dos2unix ' . $tempFiles[$i] . ' >/dev/null 2>&1');
                }
                // Check to make sure the file matches the file save regex
                if (preg_match('/' . $fileSaveRegex . '/', $productFile)) {
                    // Existing file does not exist, attempt to rename (move) it to the product's directory
                    if (!rename($tempFiles[$i], storage_path($archiveDirectory) . '/' . $wfo . '/' . $productFile)) {
                        Log::channel($logChannel)->error('Could not move product file ' . $tempFiles[$i] . ', deleting and continuing..');
                        unlink($tempFiles[$i]);
                        continue;
                    }
                    // Inventory the new product
                    Log::channel($logChannel)->info('Inventorying file ' . $productFile . ' (' . $c . ' of ' . count($tempFiles) . ')..');
                    try {
                        $product = Product::where('name', '=', $productFile)->firstOrFail();
                        // Product already exists in database, don't process again
                        Log::channel($logChannel)->notice('Product already exists in database, skipping.');
                    } catch (ModelNotFoundException $e) {
                        // Product doesn't exist, inventory product in database
                        $product = Product::create([
                            'name' => $productFile,
                        ]);
                        $productsInventoried++;
                    }
                    // Send product to all enabled PAN plugins
                    if (!is_null(config('emwin-controller.enabled_pan_plugins')) && !empty(config('emwin-controller.enabled_pan_plugins'))) {
                        foreach (explode(',', config('emwin-controller.enabled_pan_plugins')) as $panPlugin) {
                            $exitCode = Artisan::call($panPlugin, [
                                'productFile' => storage_path($archiveDirectory) . '/' . $wfo . '/' . $productFile,
                                'client' => preg_match('/ftp/', $this->client) ? 'php-ftp' : 'curl',
                            ]);
                            if ($exitCode !== 0) {
                                Log::error('panrunlog')->info("There was an error calling $panPlugin.");
                            }
                        }
                    }
                } else {
                    Log::channel($logChannel)->info('Product file ' . basename($productFile) . ' does not match file save regex, deleting file.');
                    unlink($tempFiles[$i]);
                }
                Log::channel($logChannel)->info('Done.');
            }
        }
        // If there was more than 0 products inventoried, broadcast the NewProductArrived event
        if ($productsInventoried > 0) {
            broadcast(new NewProductArrived($product))->via('pusher');
        }
        $endTime = Carbon::now();
        $diffSeconds = $startTime->diffInSeconds($endTime);
        Log::channel($logChannel)->info('Job is complete. Job took ' . $diffSeconds . ' seconds to complete.');
        // Done!
        return 0;
    }
}
