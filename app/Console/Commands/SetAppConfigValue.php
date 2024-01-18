<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Traits\AppConfigTrait;

class SetAppConfigValue extends Command
{
    use AppConfigTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emwin-controller:set_app_config_value {variable} {value}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets the value of a variable in the App Config table to supplied value';

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
        $value = $this->argument('value');
        // Set the variable to value
        $this->setAppConfigValue($variable, $value);
        // Done
        return 0;
    }
}
