@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/booking.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footers.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
@endpush

@section('content')
<div class="booking-container">
    <header class="booking-header">
        {{-- Tombol Kembali --}}
        <div class="back-nav">
            <a href="{{ url('/') }}" class="btn-back">
                <i class='bx bx-left-arrow-alt'></i> Kembali ke Beranda
            </a>
        </div>
        <h1>Buat Janji Temu Tatap Muka</h1>
        <p>Silakan lengkapi formulir di bawah ini untuk menjadwalkan kunjungan Anda.</p>
    </header>

    <form action="#" method="POST" class="booking-grid">
        @csrf
        <div class="booking-form-flow">
            @include('booking.step-layanan')
            @include('booking.step-jadwal')
            @include('booking.step-kontak')
        </div>

        @include('booking.summary')
    </form>
    {{-- Panggil Footer di Sini --}}
    @include('footer.footerbooking')

</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/booking-dynamic.js') }}"></script>
    <script src="{{ asset('js/booking.js') }}"></script>
@endpush