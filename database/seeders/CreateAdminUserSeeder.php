<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Check for existing Admin user
        if (User::where('name', '=', 'EMWIN Controller Admin')->get()->isEmpty()) {
            $user = User::create([
                'name' => 'EMWIN Controller Admin',
                'email' => 'admin@localhost',
                'email_verified_at' => date('Y-m-d H:i:s'),
                'password' => bcrypt('admin'),
                'remember_token' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        } else {
            print "Admin user already exists, skipping.\n";
        }
    }
}
