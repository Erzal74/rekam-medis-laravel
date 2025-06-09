<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DoctorSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'doctor_id', // Akan kita ganti menjadi 'user_id' jika sesuai
        'date',
        'type',
        'description',
    ];

    protected $casts = [
        'date' => 'date', // Cast date column to Carbon instance
    ];

    /**
     * Mendefinisikan relasi dengan model User (sebagai pengganti Doctor).
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
