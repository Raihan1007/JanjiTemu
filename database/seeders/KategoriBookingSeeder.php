<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriBooking;

class KategoriBookingSeeder extends Seeder
{
    public function run(): void
    {
        $data = [

            ['nama' => 'Konsultasi'],
            ['nama' => 'Permohonan'],
            ['nama' => 'Informasi'],
            ['nama' => 'Pengaduan'],

        ];

        foreach ($data as $d) {

            KategoriBooking::updateOrCreate(
                ['nama' => $d['nama']],
                $d
            );

        }
    }
}