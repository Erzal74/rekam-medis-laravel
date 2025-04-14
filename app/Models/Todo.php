<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Todo extends Model
{
    protected $fillable = [
        'dokter_id',
        'deskripsi',
        'selesai',
    ];

    public function dokter(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
