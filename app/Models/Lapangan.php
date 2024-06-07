<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lapangan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'lapangan_id',
        'nama',
        'keterangan',
        'harga_siang',
        'harga_malam',
        'foto1',
        'foto2',
        'foto3',
    ];
}
