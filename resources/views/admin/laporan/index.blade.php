@extends('layouts.admin')

@section('content')

<div class="booking-panel">

    {{-- HEADER --}}
    <div class="panel-header">
        <div class="panel-title">
            <span class="small-calendar"></span>
            <h3>Laporan Booking</h3>
        </div>

        <a href="{{ route('admin.dashboard.export', request()->all()) }}" class="primary-button">
            Download Excel
        </a>
    </div>

    {{-- 🔍 FILTER --}}
    <form method="GET" action="{{ route('admin.dashboard') }}" class="form-petugas">
        <button name="filter" value="today">Hari Ini</button>
        <button name="filter" value="week">Minggu Ini</button>
        <button name="filter" value="month">Bulan Ini</button>

        {{-- OPSIONAL manual --}}
        <input type="date" name="from">
        <input type="date" name="to">

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

        <button type="submit">Filter</button>
    </form>

    <div class="stats-grid">

        <div class="stat-card">
            <p>Total Booking</p>
            <strong>{{ $total }}</strong>
        </div>

        <div class="stat-card">
            <p>Hari Ini</p>
            <strong>{{ $today }}</strong>
        </div>

        <div class="stat-card">
            <p>Bulan Ini</p>
            <strong>{{ $month }}</strong>
        </div>

    </div>

    <div style="margin:15px 0;">
        <button onclick="changeChart('weekly')">Mingguan</button>
        <button onclick="changeChart('monthly')">Bulanan</button>
        <button onclick="changeChart('all')">Semua</button>
    </div>

    <div>
        <canvas id="chartBooking" height="100"></canvas>
    </div>

    {{-- TABLE --}}
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>No HP</th>
                    <th>Layanan</th>
                    <th>Petugas</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Mulai</th>
                    <th>Selesai</th>
                    <th>Durasi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($bookings as $b)
                    <tr>
                        <td>{{ $b->nama }}</td>
                        <td>{{ $b->nomor_hp }}</td>
                        <td>{{ $b->layanan->nama ?? '-' }}</td>
                        <td>{{ $b->petugas->nama ?? '-' }}</td>
                        <td>{{ $b->tanggal }}</td>
                        <td>{{ $b->jam }}</td>
                        <td>
                            {{ $b->mulai ? \Carbon\Carbon::parse($b->mulai)->format('H:i') : '-' }}
                        </td>

                        <td>
                            {{ $b->selesai ? \Carbon\Carbon::parse($b->selesai)->format('H:i') : '-' }}
                        </td>
                        <td>
                            @if($b->mulai && $b->selesai)

                                @php

                                    $mulai = \Carbon\Carbon::parse($b->mulai);
                                    $selesai = \Carbon\Carbon::parse($b->selesai);

                                    $durasi = $mulai->diff($selesai);

                                @endphp

                                {{ $durasi->h }} jam
                                {{ $durasi->i }} menit

                            @else

                                -

                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="empty-state">Belum ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const weekly = @json($chartWeekly);
const monthly = @json($chartMonthly);
const allData = @json($chartAll);

let chart;

// 🔥 INIT DEFAULT (weekly)
function initChart(dataSet) {
    const labels = dataSet.map(i => i.label);
    const data = dataSet.map(i => i.total);

    const ctx = document.getElementById('chartBooking');

    if (chart) {
        chart.destroy();
    }

    chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Booking',
                data: data,
                tension: 0.3
            }]
        },
        options: {
            scales: {
                y: {
                    ticks: {
                        callback: function(value) {
                            return Number.isInteger(value) ? value : null;
                        }
                    }
                }
            }
        }
    });
}

// 🔥 SWITCH
function changeChart(type) {
    if (type === 'weekly') initChart(weekly);
    if (type === 'monthly') initChart(monthly);
    if (type === 'all') initChart(allData);
}

// 🔥 LOAD AWAL
initChart(weekly);
</script>
@endsection