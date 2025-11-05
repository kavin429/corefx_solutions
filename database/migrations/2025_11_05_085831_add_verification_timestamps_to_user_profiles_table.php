<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            // ✅ Add the new timestamp columns
            $table->timestamp('identity_verified_at')->nullable()->after('identity_status');
            $table->timestamp('address_verified_at')->nullable()->after('address_status');
        });
    }

    public function down(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropColumn(['identity_verified_at', 'address_verified_at']);
        });
    }
};
