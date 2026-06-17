@extends('layouts.admin')

@section('content')

{{-- STATISTIK --}}
<section class="stats-grid">

    <article class="stat-card">
        <div class="stat-body">
            <p>Total Histori</p>
            <strong>{{ number_format($totalLayanan) }}</strong>
        </div>
    </article>

    <article class="stat-card">
        <div class="stat-body">
            <p>Rata-rata Survey</p>
            <strong>{{ number_format($avgSurvey, 1) }}</strong>
        </div>
    </article>

    <article class="stat-card">
        <div class="stat-body">
            <p>Jenis Layanan</p>
            <strong>{{ $totalJenisLayanan }}</strong>
        </div>
    </article>

</section>

<form method="GET" class="filter-form">

    <input
        type="text"
        name="search"
        placeholder="Cari nama, NIK, layanan..."
        value="{{ request('search') }}"
    >

    <select name="bulan">

        <option value="">Semua Bulan</option>

        @for($i = 1; $i <= 12; $i++)
            <option value="{{ $i }}"
                {{ request('bulan') == $i ? 'selected' : '' }}>
                {{ date('F', mktime(0,0,0,$i,1)) }}
            </option>
        @endfor

    </select>

    <select name="tahun">

        <option value="">Semua Tahun</option>

        @for($y = 2025; $y <= now()->year; $y++)
            <option value="{{ $y }}"
                {{ request('tahun') == $y ? 'selected' : '' }}>
                {{ $y }}
            </option>
        @endfor

    </select>

    <select name="layanan">
        <option value="">Semua Layanan</option>

        @foreach($daftarLayanan as $layanan)
            <option
                value="{{ $layanan }}"
                {{ request('layanan') == $layanan ? 'selected' : '' }}>
                {{ $layanan }}
            </option>
        @endforeach
    </select>

    <button type="submit" style="margin-left: 10px; padding: 8px 16px; background-color: #007BFF; color: white; border: none; border-radius: 4px;">
        Filter
    </button>

<div class="result-count" style=" font-size: 14px; color: #555;">
    Menampilkan {{ number_format($totalFiltered) }} hasil
</div>

</form>

{{-- TABEL --}}
<section class="booking-panel">

    <div class="panel-header">
        <div class="panel-title">
            <h3>Data Histori Layanan</h3>
        </div>
    </div>

    <div class="table-wrap">

        <table>

            <thead>
                <tr>
                    <th>Nama</th>
                    <th>NIK</th>
                    <th>Layanan</th>
                    <th>Tanggal</th>
                    <th>Mulai</th>
                    <th>Selesai</th>
                    <th>Survey</th>
                </tr>
            </thead>

            <tbody>

                @forelse($histori as $item)

                    <tr>

                        <td class="col-nama">{{ $item->nama }}</td>

                        <td class="col-nik">
                            {{ str_replace("'", "", $item->nik) }}
                        </td>

                        <td class="col-layanan">
                            {{ $item->layanan }}
                        </td>

                        <td>{{ $item->tanggal }}</td>

                        <td>{{ $item->jam_mulai }}</td>

                        <td>{{ $item->jam_selesai }}</td>

                        <td>
                            ⭐ {{ $item->survey ?? '-' }}
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7" style="text-align:center">
                            Belum ada data histori
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div class="pagination-wrapper">
       {!! $histori->links('pagination::bootstrap-5')->toHtml() !!}
    </div>

</section>

@endsection