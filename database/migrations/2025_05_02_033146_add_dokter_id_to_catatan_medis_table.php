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
        Schema::table('catatan_medis', function (Blueprint $table) {
            $table->foreignId('dokter_id')->nullable()->constrained('users')->onDelete('set null'); // Asumsi tabel users menyimpan info dokter
            $table->index('dokter_id'); // Opsional: untuk meningkatkan performa query
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('catatan_medis', function (Blueprint $table) {
            $table->dropForeign(['dokter_id']);
            $table->dropColumn('dokter_id');
        });
    }
};
