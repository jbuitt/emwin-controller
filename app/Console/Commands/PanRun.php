<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use App\Events\NewProductArrived;
use App\Models\Product;
use App\Libraries\AwipsProduct;

class PanRun extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emwin-controller:pan-run {productFile}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Product Arrival Notification (PAN) command to handle new products ingested from EMWIN client';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $productFile = $this->argument('productFile');
        Log::info('PAN RUN Script Start');
        // Check if file is zipped
        if (preg_match('/\.zip$/', $productFile)) {
            $tempDir = '/tmp/npemwin.' . bin2hex(random_bytes(10));
            Log::info('Creating temporary directory ' . $tempDir . ' ..');
            mkdir($tempDir);
            Log::info('Unzipping ' . $productFile . ' into ' . $tempDir . ' ..');
            exec('/usr/bin/unzip -q -d ' . $tempDir . ' ' . $productFile, $output, $exitCode);
            if ($exitCode !== 0) {
                Log::error('Unzip failed, skipping..');
            } else {
                $productFiles = glob($tempDir . '/*');
                for ($i=0; $i<count($productFiles); $i++) {
                    if (!preg_match('/\.TXT$/', $productFiles[$i])) {
                        Log::info('Product is not a text file, skipping.');
                    } else {
                        $this->copyProductToWebDir($productFiles[$i]);
                    }
                }
            }
            exec('rm -rf ' . $tempDir);
        } elseif (preg_match('/\.txt$/', $productFile)) {
            $this->copyProductToWebDir($productFile);
        } elseif (preg_match('/\.(gif|jpg|png)$/', $productFile)) {
            Log::info('Product is an image, skipping.');
        }
        // Done!
        Log::info('PAN RUN Script Complete');
        Log::info('------------------------------------------------------------------');
        return 0;
    }

    /**
     * Copy product to web directory
     *
     * @param string $product The full path to the product
     */
    public function copyProductToWebDir($product)
    {
        // Get 4-char WFO from WMO header and convert to lower-case to use as sub-directory
        $productContents = file($product);
        $wmoHeader = explode(' ', $productContents[0]);
        $wfoDir = strtolower($wmoHeader[1]);
        // If file was extracted from a zip, (capital .TXT extension) copy it to the npmemwin data directory
        if (preg_match('/\.TXT$/i', $product)) {
            // Check for destination directory & create if it doesn't exist
            if (!file_exists('/var/npemwin/data/latest/txt/all/' . $wfoDir)) {
                mkdir('/var/npemwin/data/latest/txt/all/' . $wfoDir, 0755, TRUE);
            }
            $dataFile = preg_replace('/\.([a-f0-9]+\.)txt/', '.txt', strtolower(basename($product)));
            // Copy product to npemwin data directory
            Log::info('Copying ' . $product . ' to /var/npemwin/data/latest/txt/all/' . $wfoDir . '/' . $dataFile . ' ..');
            copy($product, '/var/npemwin/data/latest/txt/all/' . $wfoDir . '/' . $dataFile);
        }
        // Parse product info
        Log::info('Attempting to parse product contents of ' . $product . ' ..');
        $awipsProduct = (new AwipsProduct($product))->toArray();
        // Check to see if file was parsed correctly by checking for AWIPS ID
        if (!isset($awipsProduct['awipsId'])) {
            Log::error('Could not parse product, skipping.');
            return;
        }
        Log::info('Successfully retrieved parsed product contents.');
        // Get EMWIN file name and WFO directory
        $emwinFileName = $awipsProduct['generatedFileNames']['emwin'];
        if (is_null($emwinFileName) || $emwinFileName === '') {
            Log::info('EMWIN file name is blank, skipping.');
            return;
        }
        // Check product file name to see if it matches file save regex
        if (preg_match('/' . config('emwin-controller.emwin.file_save_regex') . '/', $emwinFileName)) {
            Log::info('Generated EMWIN product file name matched file_save_regex.');
            // Check for WFO directory in EMWIN products directory
            if (!file_exists(storage_path('app/public/products/emwin/') . $wfoDir)) {
                Log::info('Directory ' . storage_path('app/public/products/emwin/') . $wfoDir . ' does not exist, creating..');
                mkdir(storage_path('app/public/products/emwin/') . $wfoDir, 0755, TRUE);
            }
            // Copy to products directory
            $webProduct = storage_path('app/public/products/emwin/') . $wfoDir . '/' . $emwinFileName;
            Log::info('Copying ' . $product . ' to ' . $webProduct . ' ..');
            copy($product, $webProduct);
            // Inventory product
            try {
                $dbProduct = Product::create([
                    'name' => basename($webProduct),
                ]);
                // Broadcast new product arrived event
                broadcast(new NewProductArrived($dbProduct))->via('pusher');
            } catch (QueryException $e) {
                print "Error: Could not inventory product: " . $e->getMessage() . "\n";
                return 1;
            }
            // Send product to all enabled PAN plugins
            if (!is_null(config('emwin-controller.enabled-pan-plugins')) && !empty(config('emwin-controller.enabled-pan-plugins'))) {
                foreach (explode(',', config('emwin-controller.enabled-pan-plugins')) as $panPlugin) {
                    $exitCode = Artisan::call($panPlugin, [
                        'productFile' => $webProduct,
                    ]);
                    if ($exitCode !== 0) {
                        print "There was an error calling $panPlugin.\n";
                    }
                }
            }
        } else {
            Log::info('Product file name does not match file save regex, skipping.');
        }
    }
}
