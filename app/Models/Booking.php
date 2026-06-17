<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'kode_referensi',
        'nama',
        'email',
        'nomor_hp',
        'instansi',  
        'layanan_id',
        'petugas_id',
        'tanggal',
        'jam',
        'link_meet',
        'mulai',
        'selesai',
    ];

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    public function petugas()
    {
        return $this->belongsTo(Petugas::class);
    }
}