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
    protected $signature = 'emwin-controller:pan-plugin:example_plugin {productFile} {client}';

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
        // Get the product filename and the client
        $productFile = $this->argument('productFile');
        $client = $this->argument('client');

        // Log that we're here
        Log::info('In example PAN plugin..');

        // Do something with product...

        // Done
        return 0;
    }
}
