<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User_Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'booking_id',
        'user_id',
        'lapangan_id',
        'tanggal',
        'lama_mulai',
        'jam_mulai',
        'jam_habis',
        'jenis',
        'harga_lapangan',
        'total',
        'status',
    ];
}
