<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pasien extends Model
{
    protected $fillable = [
        'nama',
        'tanggal_lahir',
        'alamat',
    ];

    public function kunjungans(): HasMany
    {
        return $this->hasMany(Kunjungan::class);
    }
}
