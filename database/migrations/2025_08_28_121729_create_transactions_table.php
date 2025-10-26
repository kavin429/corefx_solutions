<?php

// database/migrations/2025_01_01_000003_create_transactions_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            // Relationships
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('account_id')->nullable()->constrained()->cascadeOnDelete();

            // Basic transaction info
            $table->enum('type', ['deposit', 'withdraw']); 
            $table->decimal('amount', 18, 2);

            // Payment method
            $table->enum('method', ['bank', 'binance', 'xynder', 'crypto', 'card'])->nullable();

            // Status
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending');

            // Universal beneficiary
            $table->string('beneficiary_name')->nullable();

            // 🔹 Bank-specific fields
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('ifsc')->nullable();         // or swift/bic for international
            $table->string('bank_address')->nullable();

            // 🔹 Xynder-specific
            $table->string('xynder_id')->nullable();

            // 🔹 Binance-specific
            $table->string('binance_id')->nullable();
            $table->string('network_id')->nullable();

            // Extra info
            $table->text('note')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('transactions');
    }
};
