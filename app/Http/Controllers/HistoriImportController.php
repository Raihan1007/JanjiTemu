<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistoriLayanan;
use PhpOffice\PhpSpreadsheet\IOFactory;

class HistoriImportController extends Controller
{
    public function index()
    {
        return view('admin.import');
    }

  public function store(Request $request)
{
    $request->validate([
        'file' => 'required|file|mimes:xlsx,xls,csv',
    ]);

    $spreadsheet = IOFactory::load($request->file('file')->getRealPath());
    $rows = $spreadsheet->getActiveSheet()->toArray();


    unset($rows[0]);

    $data = [];

    foreach ($rows as $row) {
        $data[] = [
            'nama' => $row[9] ?? null,
            'nik' => str_replace("'", "", $row[8] ?? ''),
            'email' => $row[7] ?? null,
            'nomor_hp' => $row[6] ?? null,
            'layanan' => $row[17] ?? null,

            // sesuaikan index kolom Excel kamu
            'tanggal' => $row[2] ?? null,
            'jam_mulai' => $row[3] ?? null,
            'jam_selesai' => $row[4] ?? null,
            'survey' => $row[18] ?? null,

            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    HistoriLayanan::insert($data);

    return redirect()
        ->route('admin.histori')
        ->with('success', count($data) . ' data berhasil diimport');
}

    public function histori(Request $request)
    {
        $query = HistoriLayanan::query();

        // SEARCH
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('layanan', 'like', "%{$search}%");

            });
        }

        // FILTER LAYANAN
        if ($request->filled('layanan')) {

            $query->where(
                'layanan',
                $request->layanan
            );
        }

        // FILTER BULAN
        if ($request->filled('bulan')) {

            $query->whereMonth(
                'tanggal',
                $request->bulan
            );
        }

        // FILTER TAHUN
        if ($request->filled('tahun')) {

            $query->whereYear(
                'tanggal',
                $request->tahun
            );
        }

        // TOTAL HASIL FILTER
        $totalFiltered = $query->count();

        // PAGINATION
        $histori = $query
            ->orderBy('tanggal', 'desc')
            ->paginate(20)
            ->withQueryString();

        // DROPDOWN LAYANAN
        $daftarLayanan = HistoriLayanan::select('layanan')
            ->distinct()
            ->orderBy('layanan')
            ->pluck('layanan');

        // STATISTIK
        $totalLayanan = HistoriLayanan::count();

        $avgSurvey = HistoriLayanan::whereNotNull('survey')
            ->avg('survey');

        $totalJenisLayanan = HistoriLayanan::distinct('layanan')
            ->count('layanan');

        return view('admin.histori', compact(
            'histori',
            'totalLayanan',
            'avgSurvey',
            'totalJenisLayanan',
            'totalFiltered',
            'daftarLayanan'
        ));
    }
}