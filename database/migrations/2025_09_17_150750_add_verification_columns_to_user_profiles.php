<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->string('identity_document_path')->nullable()->after('avatar_path');
            $table->string('address_document_path')->nullable()->after('identity_document_path');

            $table->enum('identity_status', ['pending', 'verified', 'rejected'])->default('pending')->after('identity_document_path');
            $table->enum('address_status', ['pending', 'verified', 'rejected'])->default('pending')->after('address_document_path');
        });
    }

    public function down(): void {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropColumn(['identity_document_path', 'address_document_path', 'identity_status', 'address_status']);
        });
    }
};
