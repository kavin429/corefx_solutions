<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin; // Correct model

class AdminSeeder extends Seeder
{
    public function run()
    {
       
        $adminEmail='corefxsolutions@gmail.com';

        // Check if admin already exists
        if (!Admin::where('email', $adminEmail)->exists()) {
            Admin::create([
                'name' => 'Admin',
                'email' => $adminEmail,
                'password' => Hash::make('Admin@1234'), // password is hashed automatically
            ]);
        }
    }
}
