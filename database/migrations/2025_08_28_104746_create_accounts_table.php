<?php

// database/migrations/2025_01_01_000002_create_accounts_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key (internal use)

            // User relationship (one user → many accounts)
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Custom account ID (can store strings like 'ACC9022')
           $table->string('account_number')->unique(); // instead of unsignedBigInteger


            // User-friendly account name (Account 1, Account 2…)
            $table->string('account_name');

            // Account details
            $table->enum('type', ['live', 'demo'])->default('live');
            $table->string('currency', 10)->default('USD');
            $table->decimal('balance', 18, 2)->default(0);

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('accounts');
    }
};
