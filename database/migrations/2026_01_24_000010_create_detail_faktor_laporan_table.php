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
        Schema::create('detail_faktor_laporan', function (Blueprint $table) {
            $table->unsignedBigInteger('id_laporan');
            $table->unsignedSmallInteger('id_faktor');

            $table->primary(['id_laporan', 'id_faktor']);
            $table->index('id_faktor', 'idx_detail_faktor_id_faktor');

            $table->foreign('id_laporan')
                  ->references('id_laporan')
                  ->on('laporan')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('id_faktor')
                  ->references('id_faktor')
                  ->on('faktor_penyebab')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_faktor_laporan');
    }
};
