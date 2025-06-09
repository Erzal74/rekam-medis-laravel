<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RekamMedis extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_rm',
        'pasien_id',
        'tanggal_pembuatan',
        'status',
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
    ];

    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class);
    }

    public function catatanMedis(): HasMany
    {
        return $this->hasMany(CatatanMedis::class);
    }

    public function odontograms(): HasMany
    {
        return $this->hasMany(Odontogram::class, 'pasien_id', 'pasien_id');
    }
}
