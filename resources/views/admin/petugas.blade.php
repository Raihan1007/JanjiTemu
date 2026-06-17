@extends('layouts.admin')

@section('content')

<div class="booking-panel">

    {{-- HEADER --}}
    <div class="panel-header">
        <div class="panel-title">
            <span class="small-calendar"></span>
            <h3>Data Petugas</h3>
        </div>
    </div>

    {{-- FORM --}}
    <form action="{{ route('admin.petugas.store') }}" method="POST" class="form-petugas">
        @csrf

        <input type="text" name="nama" placeholder="Nama Petugas" required>

        <select name="layanan_id" required>
            <option value="">Pilih Layanan</option>
            @foreach($layanans as $layanan)
                <option value="{{ $layanan->id }}">{{ $layanan->nama }}</option>
            @endforeach
        </select>

        <button type="submit">Tambah</button>
    </form>

    {{-- TABLE --}}
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Nama Petugas</th>
                    <th>Layanan</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($petugas as $p)
                    <tr>
                        <td>{{ $p->nama }}</td>
                        <td>{{ $p->layanan->nama ?? '-' }}</td>
                        <td>
                            <div class="action-group">

                                <!-- EDIT -->
                                <button class="action-button btn-edit" data-id="{{ $p->id }}">
                                    <i class='bx bx-edit'></i>
                                </button>

                                <!-- DELETE -->
                                <form action="{{ url('/admin/petugas/'.$p->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="action-button btn-delete">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="empty-state">Belum ada petugas</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div id="modalEdit" class="modal">
    <div class="modal-content">
        <span id="closeEdit">&times;</span>

        <h3>Edit Petugas</h3>

        <form id="formEdit">
            @csrf
            @method('PUT')

            <input type="hidden" id="edit-id">

            <input type="text" id="edit-nama" placeholder="Nama">

            <select id="edit-layanan">
                @foreach($layanans as $l)
                    <option value="{{ $l->id }}">{{ $l->nama }}</option>
                @endforeach
            </select>

            <button type="submit" class="btn-success">Simpan</button>
        </form>
    </div>
</div>

</div>

@endsection