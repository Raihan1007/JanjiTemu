<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Layanan;
use App\Models\Rating;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function layanan()
    {
        // Ambil data terbaru
       $bookings = \App\Models\Booking::with(['layanan','petugas'])->latest()->get();

       $now = Carbon::now();

       //minggu ini
       $thisweek = Booking::whereBetween('created_at', [
        $now->copy()->startOfWeek(),
        $now->copy()->endOfWeek()
       ])->count();

       //minggu lalu
       $lastweek = Booking::whereBetween('created_at', [
        $now->copy()->subWeek()->startOfWeek(),
        $now->copy()->subWeek()->endOfWeek()
       ])->count();

       $calcPercent = function ($current, $previous) {
        if ($previous == 0) return $current > 0 ? 100 : 0;
        return round((($current - $previous) / $previous) * 100);
       };

    $stats = [
        [
            'label' => 'Total Booking',
            'value' => Booking::count(),
            'change' => $calcPercent($thisweek, $lastweek) . '%',
            'icon' => 'bx-bar-chart-alt-2'
        ],
        [
            'label' => 'Hari Ini',
            'value' => Booking::whereDate('tanggal', now())->count(),
            'change' => $calcPercent(
                Booking::whereDate('tanggal', $now)->count(),
                Booking::whereDate('tanggal', $now->copy()->subDay())->count()
                ) . '%',
            'icon' => 'bx-calendar-check'
        ],
        [
            'label' => 'Bulan Ini',
            'value' => Booking::whereMonth('tanggal', now()->month)->count(),
            'change' => $calcPercent(
                Booking::whereMonth('tanggal', $now->month)->count(),
                Booking::whereMonth('tanggal', $now->copy()->subMonth()->month)->count()
                ) . '%',
            'icon' => 'bx-calendar'
        ],
    ];

    return view('admin.layanan', compact('bookings', 'stats'));
    }

    //RATING
    public function ratings()
    {
        $ratings = Rating::with(['petugas', 'layanan'])
        ->latest()
        ->get();

        return view('admin.ratings', compact('ratings'));
    }

    //User
    public function users()
    {
        $users =User::latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function dashboard(Request $request)
    {
    $query = Booking::with(['petugas','layanan'])->latest();

    if ($request->filter) {

        if ($request->filter == 'today') {
            $query->whereDate('tanggal', Carbon::today());
        }

        if ($request->filter == 'week') {
            $query->whereBetween('tanggal', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ]);
        }

        if ($request->filter == 'month') {
            $query->whereMonth('tanggal', Carbon::now()->month);
        }
    }

    if ($request->from && $request->to) {
        $query->whereBetween('tanggal', [$request->from, $request->to]);
    }

    $bookings = $query->get();

    $daftarLayanan = Layanan::orderBy('nama')
        ->pluck('nama');

    // 🔥 STATISTIK
    $total = Booking::count();
    $today = Booking::whereDate('tanggal', Carbon::today())->count();
    $month = Booking::whereMonth('tanggal', Carbon::now()->month)->count();

    // 🔥 WEEKLY (7 hari terakhir)
    $chartWeekly = Booking::selectRaw('DATE(tanggal) as label, COUNT(*) as total')
        ->where('tanggal', '>=', Carbon::now()->subDays(7))
        ->groupBy('label')
        ->orderBy('label')
        ->get();

    // 🔥 MONTHLY (per hari dalam bulan ini)
    $chartMonthly = Booking::selectRaw('DATE(tanggal) as label, COUNT(*) as total')
        ->whereMonth('tanggal', Carbon::now()->month)
        ->groupBy('label')
        ->orderBy('label')
        ->get();

    // 🔥 ALL (semua data)
    $chartAll = Booking::selectRaw('DATE(tanggal) as label, COUNT(*) as total')
        ->groupBy('label')
        ->orderBy('label')
        ->get();

    return view('admin.laporan.index', compact(
        'bookings',
        'total',
        'today',
        'month',
        'chartWeekly',
        'chartMonthly',
        'chartAll',
        'daftarLayanan'
    ));

}


public function export(Request $request)
{
    $query = Booking::with(['petugas','layanan']);

    if ($request->filter) {

        if ($request->filter == 'today') {
            $query->whereDate('tanggal', Carbon::today());
        }

        if ($request->filter == 'week') {
            $query->whereBetween('tanggal', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ]);
        }

        if ($request->filter == 'month') {
            $query->whereMonth('tanggal', Carbon::now()->month);
        }
    }

    if ($request->from && $request->to) {
        $query->whereBetween('tanggal', [$request->from, $request->to]);
    }

    $bookings = $query->get();

    return response()->streamDownload(function () use ($bookings) {

        $handle = fopen('php://output', 'w');

        fputcsv($handle, ['Nama','No HP','Layanan','Petugas','Tanggal','Jam']);

        foreach ($bookings as $b) {
            fputcsv($handle, [
                $b->nama,
                $b->nomor_hp,
                $b->layanan->nama ?? '-',
                $b->petugas->nama ?? '-',
                $b->tanggal,
                $b->jam
            ]);
        }

        fclose($handle);

    }, 'laporan.csv');
}
}

