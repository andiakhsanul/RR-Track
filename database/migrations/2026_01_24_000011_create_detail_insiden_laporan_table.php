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
        Schema::create('detail_insiden_laporan', function (Blueprint $table) {
            $table->unsignedBigInteger('id_laporan');
            $table->unsignedSmallInteger('id_insiden');

            $table->primary(['id_laporan', 'id_insiden']);
            $table->index('id_insiden', 'idx_detail_insiden_id_insiden');

            $table->foreign('id_laporan')
                  ->references('id_laporan')
                  ->on('laporan')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('id_insiden')
                  ->references('id_insiden')
                  ->on('jenis_insiden')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_insiden_laporan');
    }
};
