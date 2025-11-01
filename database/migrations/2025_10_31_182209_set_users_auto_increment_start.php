<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Set auto-increment start value for existing users table
        DB::statement('ALTER TABLE users AUTO_INCREMENT = 80810;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Optionally reset auto-increment to 1 (or previous value)
        DB::statement('ALTER TABLE users AUTO_INCREMENT = 1;');
    }
};
