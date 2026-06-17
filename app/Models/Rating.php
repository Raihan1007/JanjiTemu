<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = [
    'nama',
    'nik',
    'petugas_id',
    'layanan_id',
    'rating'
    ];

    public function petugas()
    {
        return $this->belongsTo(Petugas::class);
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }
}
