@extends('layouts.admin')

@section('content')

<div class="booking-panel">

    {{-- HEADER --}}
    <div class="panel-header">
        <div class="panel-title">
            <span class="small-calendar"></span>
            <h3>Data Pengguna</h3>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIK</th>
                    <th>Tanggal Lahir</th>
                    <th>Tanggal Daftar</th>
                </tr>
            </thead>

            <tbody>
                @forelse($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->nama }}</td>
                        <td>{{ $user->nik ?? '-' }}</td>
                        <td>{{ $user->tanggal_lahir->format('d-m-Y') }}</td>
                        <td>{{ $user->created_at->format('d-m-Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-state">Belum ada pengguna</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection