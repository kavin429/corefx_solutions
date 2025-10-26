<?php

// database/migrations/2025_01_01_000001_create_user_profiles_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->date('birth_date')->nullable(); // 👈 added here
            $table->string('country')->nullable();
            $table->string('phone_code', 10)->nullable();
            $table->string('phone_number', 32)->nullable();
            $table->string('avatar_path')->nullable();
            $table->boolean('is_verified_identity')->default(false);
            $table->boolean('is_verified_address')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('user_profiles');
    }
};
