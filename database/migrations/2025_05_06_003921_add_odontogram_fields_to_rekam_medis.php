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
        Schema::table('rekam_medis', function (Blueprint $table) {
            $table->date('tanggal_pemeriksaan_gigi')->nullable();
            $table->string('nomor_gigi')->nullable();
            $table->string('kondisi_gigi')->nullable();
            $table->string('occlusi')->nullable();
            $table->string('torus_palatinus')->nullable();
            $table->string('torus_mandibularis')->nullable();
            $table->string('palatum')->nullable();
            $table->string('diastema')->nullable();
            $table->string('gigi_anomali')->nullable();
            $table->text('lain_lain')->nullable();
            $table->integer('jumlah_foto_rontgen')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rekam_medis', function (Blueprint $table) {
            $table->dropColumn([
                'tanggal_pemeriksaan_gigi',
                'nomor_gigi',
                'kondisi_gigi',
                'occlusi',
                'torus_palatinus',
                'torus_mandibularis',
                'palatum',
                'diastema',
                'gigi_anomali',
                'lain_lain',
                'jumlah_foto_rontgen',
            ]);
        });
    }
};
