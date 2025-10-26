<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pricing_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Plan name (Micro, Classic, Premium, etc.)
            $table->decimal('price', 12, 2); // Plan price in USD
            $table->string('leverage'); // Example: 1:500
            $table->string('min_lot_size'); // Example: 0.01
            $table->string('starting_pips'); // Example: 0.5 pips
            $table->string('swap'); // Example: Available/Unavailable
            $table->string('commission'); // Example: 10%
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_plans');
    }
};
