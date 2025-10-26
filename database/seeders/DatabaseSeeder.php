<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call AdminSeeder to create admin account
        $this->call([
            AdminSeeder::class,
        ]);

        // Optional: you can keep factories if you want to seed test users
        // User::factory(10)->create();
    }
}
