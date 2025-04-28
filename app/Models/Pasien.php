<?php // Pasien.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasiens';

    protected $fillable = [
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'tanggal_berkunjung',
        'alamat',
        'no_hp',
        'jenis_kelamin',
        'status',
    ];
}
