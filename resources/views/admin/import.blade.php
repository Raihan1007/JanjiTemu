@extends('layouts.admin')

@section('content')

<div class="booking-panel">

    <div class="panel-header">
        <div class="panel-title">
            <h3>Import Data Historis</h3>
        </div>
    </div>

    @if(session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.import.store') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        <input type="file"
               name="file"
               accept=".xlsx,.xls,.csv"
               required>

        <button type="submit"
                class="primary-button">
            Import Excel
        </button>

    </form>

    <div class="import-mode">

        <label>
            <input type="radio"
                name="mode"
                value="append"
                checked>

            Tambah Data
        </label>

        <label>
            <input type="radio"
                name="mode"
                value="replace">

            Ganti Semua Data
        </label>

    </div>

</div>

@endsection