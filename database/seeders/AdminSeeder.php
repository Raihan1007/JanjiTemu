<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // SUPER ADMIN
        Admin::updateOrCreate(
            ['email' => 'superadmin@perusahaan.com'],
            [
                'nama' => 'Super Admin',
                'email' => 'superadmin@perusahaan.com',
                'password' => Hash::make('superadminKPKNL'),
                'role' => 'super_admin'
            ]
        );

        // ADMIN PEGAWAI 1
        Admin::updateOrCreate(
            ['email' => 'admin@perusahaan.com'],
            [
                'nama' => 'Admin Pegawai',
                'email' => 'admin@perusahaan.com',
                'password' => Hash::make('adminKPKNL'),
                'role' => 'admin'
            ]
        );
    }
}