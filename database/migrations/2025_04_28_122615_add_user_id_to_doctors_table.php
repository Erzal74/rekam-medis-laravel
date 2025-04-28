<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
{
    Schema::table('doctors', function (Blueprint $table) {
        $table->unsignedBigInteger('user_id')->nullable()->unique(); // Tambahkan kolom user_id
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Foreign key ke tabel users
    });
}

public function down(): void
{
    Schema::table('doctors', function (Blueprint $table) {
        $table->dropForeign(['user_id']);
        $table->dropColumn('user_id');
    });
}
};
