<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ExamplePlugin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emwin-controller:pan-plugin:example-plugin {productFile}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Example PAN Plugin';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the product filename
        $productFile = $this->argument('productFile');

        // Log that we're here
        Log::info('In example PAN plugin..');

        // Do something with product...

        // Done
        return 0;
    }
}
