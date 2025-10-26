<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin; 

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Check if admin already exists to avoid duplicates
        $adminEmail = 'admin@gmail.com';

        if (!User::where('email', $adminEmail)->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => $adminEmail,
                'password' => Hash::make('Admin@123'), // plain password hashed
            ]);
        }
    }
}
