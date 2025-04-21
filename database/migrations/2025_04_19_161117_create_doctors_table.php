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
            $table->id(); // Kolom ID utama (auto-incrementing integer)
            $table->string('name'); // Nama dokter
            $table->string('specialization')->nullable(); // Spesialisasi dokter (misalnya, 'Umum', 'Anak', 'Jantung')
            $table->string('phone_number')->nullable(); // Nomor telepon dokter
            $table->string('email')->nullable(); // Alamat email dokter
            $table->text('address')->nullable(); // Alamat praktik dokter
            $table->timestamps(); // Kolom untuk created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
