<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pending_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->date('birth_date');
            $table->string('country');
            $table->string('phone'); // E.164-like (+9412345678)
            $table->string('password_hash'); // hashed password
            $table->string('promo_code')->nullable();
            $table->boolean('wants_biometrics')->default(false);

            $table->string('otp_hash');
            $table->timestamp('otp_expires_at');
            $table->unsignedTinyInteger('otp_attempts')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('pending_registrations');
    }
};
