<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Libraries\AwipsProduct;

class TestAwipsProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emwin-controller:test-awips-product {productFile}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tests the parsing of a product coming from AWIPS (EMWIN)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the product filename
        $productFile = $this->argument('productFile');
        // Make sure product file exists
        if (!file_exists($productFile)) {
            print "Error: Product file does not exist!\n";
            return 1;
        }
        // Attempt to parse product
        $awipsProduct = (new AwipsProduct($productFile))->toArray();
        var_dump($awipsProduct);
    }
}
