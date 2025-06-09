<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CatatanMedis extends Model
{
    use HasFactory;

    protected $fillable = [
        'pasien_id',
        'tanggal_pemeriksaan',
        'keluhan_utama',
        'diagnosa',
        'tindakan',
        'resep',
        'catatan_tambahan',
        'dokter_id', // Tambahkan ini
    ];

    protected $casts = [
        'tanggal_pemeriksaan' => 'datetime',
    ];

    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class, 'pasien_id');
    }

    public function dokter(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
