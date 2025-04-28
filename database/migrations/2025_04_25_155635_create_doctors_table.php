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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // Nama lengkap dokter
            $table->unsignedBigInteger('user_id')->nullable()->unique(); // Tambahkan kolom user_id, nullable dan unique
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Foreign key ke tabel users
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) { // Tambahkan ini
            $table->dropForeign(['user_id']); // Drop foreign key constraint
            $table->dropColumn('user_id');    // Hapus kolom user_id
        });
        Schema::dropIfExists('doctors');
    }
};
