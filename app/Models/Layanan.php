<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $fillable = ['nama'];

    protected $table = 'layanans'; 

    public function petugas()
    {
        return $this->hasMany(Petugas::class);
    }
}