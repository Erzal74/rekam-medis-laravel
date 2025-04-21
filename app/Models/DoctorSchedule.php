<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'date',
        'type',
        'description',
    ];

    protected $casts = [
        'date' => 'date', // Cast date column to Carbon instance
    ];

    // Relationship to the Doctor model
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
