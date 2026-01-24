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
        Schema::create('laporan', function (Blueprint $table) {
            $table->id('id_laporan');
            $table->unsignedTinyInteger('id_jenis_laporan');
            $table->date('tanggal_pemeriksaan');
            $table->unsignedBigInteger('id_pasien');
            $table->unsignedInteger('id_jenis_pemeriksaan');
            $table->unsignedInteger('id_modalitas');
            $table->unsignedInteger('id_petugas');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('tanggal_pemeriksaan', 'idx_laporan_tanggal');
            $table->index('id_jenis_laporan', 'idx_laporan_jenis');
            $table->index('id_pasien', 'idx_laporan_pasien');
            $table->index('id_petugas', 'idx_laporan_petugas');
            $table->index('id_modalitas', 'idx_laporan_modalitas');
            $table->index('id_jenis_pemeriksaan', 'idx_laporan_jenis_pemeriksaan');

            // Foreign Keys
            $table->foreign('id_jenis_laporan')
                  ->references('id_jenis_laporan')
                  ->on('jenis_laporan')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');

            $table->foreign('id_pasien')
                  ->references('id_pasien')
                  ->on('pasien')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');

            $table->foreign('id_jenis_pemeriksaan')
                  ->references('id_jenis_pemeriksaan')
                  ->on('jenis_pemeriksaan')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');

            $table->foreign('id_modalitas')
                  ->references('id_modalitas')
                  ->on('modalitas')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');

            $table->foreign('id_petugas')
                  ->references('id_petugas')
                  ->on('petugas')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};
