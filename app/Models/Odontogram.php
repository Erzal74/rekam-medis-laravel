<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Odontogram extends Model
{
    use HasFactory;

    protected $fillable = [
        'dokter_id',
        'pasien_id',
        'tanggal_pemeriksaan',
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
    ];

    public function dokter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }

    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class, 'pasien_id');
    }
}
