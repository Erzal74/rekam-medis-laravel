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
        Schema::create('odontograms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dokter_id');
            $table->foreign('dokter_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreignId('pasien_id')->nullable()->constrained('pasiens')->onDelete('cascade');
            $table->date('tanggal_pemeriksaan');
            $table->text('nomor_gigi');
            $table->text('kondisi_gigi');
            $table->string('occlusi')->nullable();
            $table->string('torus_palatinus')->nullable();
            $table->string('torus_mandibularis')->nullable();
            $table->string('palatum')->nullable();
            $table->text('diastema')->nullable();
            $table->text('gigi_anomali')->nullable();
            $table->text('lain_lain')->nullable();
            $table->string('jumlah_foto_rontgen')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('odontograms');
    }
};
