<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    protected $table = 'petugas'; // penting (karena bukan plural default)

    protected $fillable = ['nama', 'layanan_id'];

    protected $casts = [
    'layanan_id' => 'integer'
    ];

    public function layanan()
    {
        return $this->belongsTo(Layanan::class)->withDefault([
        'nama' => 'Tidak ada layanan'
        ]);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}