@extends('layouts.admin')

@section('content')

<section class="booking-panel">

    <div class="panel-header">
        <div class="panel-title">
            <h3>Rating Pegawai</h3>
        </div>
    </div>

    <div class="table-wrap">

        <table>

            <thead>
                <tr>
                    <th>User</th>
                    <th>NIK</th>
                    <th>Petugas</th>
                    <th>Layanan</th>
                    <th>Rating</th>
                    <th>Tanggal</th>
                </tr>
            </thead>

            <tbody>

                @forelse($ratings as $r)

                    <tr>

                        <td>
                            {{ $r->nama }}
                        <td>
                            {{ $r->nik ?? '-' }}
                        </td>

                        <td>
                            {{ $r->petugas->nama ?? '-' }}
                        </td>

                        <td>
                            {{ $r->layanan->nama ?? '-' }}
                        </td>

                        <td>
                            ⭐ {{ number_format($r->rating, 2) }}
                        </td>

                        <td>
                            {{ $r->created_at->format('d M Y') }}
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6" style="text-align:center;">
                            Belum ada rating
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</section>

@endsection