<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            // Polymorphic recipient: user, admin, etc.
            $table->morphs('notifiable'); // creates notifiable_id + notifiable_type

            // Who sent the notification (nullable for system)
            $table->unsignedBigInteger('sender_id')->nullable();
            $table->string('sender_type')->default('admin'); 
            // could be 'admin', 'system', 'user', etc.

            // Content
            $table->string('title');
            $table->text('message')->nullable();

            // Status
            $table->boolean('is_read')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('notifications');
    }
};
