<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        // Step 1: Remove duplicate account_numbers to avoid unique constraint errors
        $duplicates = DB::table('accounts')
            ->select('account_number')
            ->groupBy('account_number')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('account_number');

        foreach ($duplicates as $dup) {
            DB::table('accounts')
                ->where('account_number', $dup)
                ->skip(1) // keep first occurrence
                ->update(['account_number' => null]);
        }

        Schema::table('accounts', function (Blueprint $table) {
            // Step 2: Rename column
            $table->renameColumn('account_number', 'live_id');
        });

        Schema::table('accounts', function (Blueprint $table) {
            // Step 3: Make live_id nullable and unique
            $table->string('live_id')->nullable()->unique()->change();
        });
    }

    public function down(): void {
        Schema::table('accounts', function (Blueprint $table) {
            // Remove unique constraint
            $table->dropUnique(['live_id']);
            // Change back to non-unique, not nullable if you prefer
            $table->string('live_id')->nullable(false)->change();
            // Rename column back
            $table->renameColumn('live_id', 'account_number');
        });
    }
};
