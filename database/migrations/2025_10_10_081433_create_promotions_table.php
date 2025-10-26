<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('description')->nullable();

            // Popup settings
            $table->boolean('popup_enabled')->default(false);
            $table->string('popup_image')->nullable();

            // Promotion page images (different sizes)
            $table->string('poster_large')->nullable();
            $table->string('poster_medium')->nullable();
            $table->string('poster_small')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
