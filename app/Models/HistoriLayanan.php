<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoriLayanan extends Model
{
    protected $fillable = [
        'nama',
        'nik',
        'email',
        'nomor_hp',
        'layanan',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'durasi',
        'survey',
    ];
}
