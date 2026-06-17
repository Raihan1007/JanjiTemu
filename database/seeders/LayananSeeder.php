<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Layanan;

class LayananSeeder extends Seeder
{
    public function run(): void
    {
        $data = [

            [
                'nama' => 'Layanan Pengelolaan Kekayaan Negara'
            ],

            [
                'nama' => 'Layanan Penilaian'
            ],

            [
                'nama' => 'Layanan Piutang Negara'
            ],

            [
                'nama' => 'Layanan Lelang'
            ]

        ];

        foreach ($data as $d) {

            Layanan::updateOrCreate(
                ['nama' => $d['nama']],
                $d
            );

        }
    }
}