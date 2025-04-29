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
        'doctor_id',
        'date',
        'type',
        'description',
    ];

    protected $casts = [
        'date' => 'date', // Cast date column to Carbon instance
    ];

    /**
     * Mendefinisikan relasi dengan model Doctor.
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
}
