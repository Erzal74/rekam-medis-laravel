<?php // Kunjungan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    use HasFactory;

    protected $table = 'kunjungans'; // Nama tabel di database

    protected $fillable = [
        'pasien_id', // Foreign key ke tabel pasien
        'waktu_kunjungan',
        // Kolom lain yang relevan dengan kunjungan
    ];

    // Definisikan relasi dengan model Pasien
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'pasien_id');
    }
}

