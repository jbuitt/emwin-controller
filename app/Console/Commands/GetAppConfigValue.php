<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Traits\AppConfigTrait;

class GetAppConfigValue extends Command
{
    use AppConfigTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emwin-controller:get_app_config_value {variable}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the value of a variable in the App Config table';

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
     */
    public function handle(): int
    {
        $variable = $this->argument('variable');
        // Get the value
        print $this->getAppConfigValue($variable) . "\n";
        // Done
        return 0;
    }
}
