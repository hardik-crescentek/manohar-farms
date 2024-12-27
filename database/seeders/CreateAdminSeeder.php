<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create an admin user
        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@super.com',
            'password' => Hash::make('superadmin'), // Hash the password
        ]);

        $user->assignRole([1]);
    }
}
