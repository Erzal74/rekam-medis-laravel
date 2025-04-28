<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'user_id', // Tambahkan user_id ke sini
        // Tambahkan atribut lain yang bisa diisi
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
