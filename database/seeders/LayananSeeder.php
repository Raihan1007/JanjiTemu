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
                'nama' => 'Lelang'
            ],

            [
                'nama' => 'Penilaian'
            ],

            [
                'nama' => 'Piutang Negara'
            ],

            [
                'nama' => 'Kekayaan Negara'
            ],

        ];

        foreach ($data as $d) {

            Layanan::updateOrCreate(
                [
                    'nama' => $d['nama']
                ],
                $d
            );

        }
    }
}