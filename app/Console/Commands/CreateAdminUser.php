<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emwin-controller:create_admin_user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $name = $this->ask('Admin name');
        $email = $this->ask('Admin Email');
        while (true) {
            $password1 = $this->secret('Admin password');
            $password2 = $this->secret('Admin password (again)');
            if ($password1 !== $password2) {
                print "Error: passwords do not match. Please try again.\n";
            } else {
                break;
            }
        }
        // Create the user
        try {
            User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password1),
            ]);
            print "User created.\n";
        } catch (\Exception $e) {
            print 'Error: Could not create admin user: (' . $e->getMessage() . ")\n";
            return 1;
        }
        // Done!
        return 0;
    }
}
