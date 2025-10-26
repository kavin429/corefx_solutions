<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Add upi_id column
            if (!Schema::hasColumn('transactions', 'upi_id')) {
                $table->string('upi_id')->nullable()->after('method');
            }

            // Modify enum to include 'upi'
            $table->enum('method', ['bank', 'binance', 'xynder', 'crypto', 'card', 'upi'])
                  ->nullable()
                  ->change();
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Remove upi_id column
            if (Schema::hasColumn('transactions', 'upi_id')) {
                $table->dropColumn('upi_id');
            }

            // Revert enum back to original
            $table->enum('method', ['bank', 'binance', 'xynder', 'crypto', 'card'])
                  ->nullable()
                  ->change();
        });
    }
};
