<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriBooking extends Model
{
    protected $fillable = [
        'nama'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}