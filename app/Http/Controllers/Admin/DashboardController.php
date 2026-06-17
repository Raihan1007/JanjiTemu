<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        /*
         * Ganti data contoh ini dengan query model ketika backend booking sudah siap.
         *
         * Contoh:
         * $totalBooking = Booking::count();
         * $onlineBooking = Booking::where('status', 'Online')->count();
         * $offlineBooking = Booking::where('status', 'Offline')->count();
         * $bookings = Booking::with(['service', 'officer', 'customer'])->latest()->take(5)->get();
         */
        $stats = [
            [
                'label' => 'Total Booking',
                'value' => 124,
                'change' => '+8',
                'icon' => 'calendar-icon',
            ],
            [
                'label' => 'Online (Jumat)',
                'value' => 56,
                'change' => '+5',
                'icon' => 'monitor-icon',
            ],
            [
                'label' => 'Offline',
                'value' => 68,
                'change' => '+3',
                'icon' => 'office-icon',
            ],
        ];

        $bookings = new Collection([
            (object) [
                'id' => 1,
                'customer_name' => 'Andi Saputra',
                'service_name' => 'Konsultasi',
                'officer_name' => 'Budi Santoso',
                'booking_date' => '21 April 2025',
                'booking_time' => '10:00 - 11:00',
                'status' => 'Online',
            ],
            (object) [
                'id' => 2,
                'customer_name' => 'Siti Aisyah',
                'service_name' => 'Perizinan',
                'officer_name' => 'Dewi Lestari',
                'booking_date' => '21 April 2025',
                'booking_time' => '11:00 - 12:00',
                'status' => 'Offline',
            ],
            (object) [
                'id' => 3,
                'customer_name' => 'Muhammad Rizki',
                'service_name' => 'Konsultasi',
                'officer_name' => 'Budi Santoso',
                'booking_date' => '21 April 2025',
                'booking_time' => '13:00 - 14:00',
                'status' => 'Online',
            ],
            (object) [
                'id' => 4,
                'customer_name' => 'Rina Kartika',
                'service_name' => 'Pengaduan',
                'officer_name' => 'Dewi Lestari',
                'booking_date' => '21 April 2025',
                'booking_time' => '14:00 - 15:00',
                'status' => 'Offline',
            ],
            (object) [
                'id' => 5,
                'customer_name' => 'Fajar Nugroho',
                'service_name' => 'Perizinan',
                'officer_name' => 'Budi Santoso',
                'booking_date' => '21 April 2025',
                'booking_time' => '15:00 - 16:00',
                'status' => 'Online',
            ],
        ]);

        return view('admin.dashboard', [
            'appName' => 'JAMU BOBA',
            'panelName' => 'Admin Panel',
            'adminName' => $user->name ?? 'Admin',
            'adminEmail' => $user->email ?? 'admin@perusahaan.com',
            'stats' => $stats,
            'bookings' => $bookings,
        ]);
    }
}