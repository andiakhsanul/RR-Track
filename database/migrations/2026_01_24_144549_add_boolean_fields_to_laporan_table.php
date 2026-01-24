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
        Schema::table('laporan', function (Blueprint $table) {
            // Boolean fields for both Reject and Repeat reports
            $table->boolean('kesalahan_label')->default(false)->after('keterangan');
            $table->boolean('insiden_reaksi_obat_kontras')->default(false)->after('kesalahan_label');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan', function (Blueprint $table) {
            $table->dropColumn(['kesalahan_label', 'insiden_reaksi_obat_kontras']);
        });
    }
};
