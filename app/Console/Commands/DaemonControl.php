<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Traits\DaemonTrait;

class DaemonControl extends Command
{
    use DaemonTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emwin-controller:daemon:control
                            { action : Daemon action (start or stop) }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perform a command on the EMWIN Controller daemon';

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
     * @return mixed
     */
    public function handle()
    {
        // Get arguments
        $action = $this->argument('action');
        // print "**DEBUG** \$action = $action\n";
        // Check to see if command was run by the www-data user
        $currentUser = rtrim(shell_exec('whoami'));
        if (config('app.env') === 'local') {
            if ($currentUser !== 'sail') {
                die("Error: Please run this command as the 'sail' user.\n");
            }
        } else {
            if ($currentUser !== 'www-data') {
                die("Error: Please run this command as the 'www-data' user.\n");
            }
        }
        // Execute command
        print json_encode($this->executeArtisanCommand($action)) . "\n";
        // Done!
        return 0;
   }

}
