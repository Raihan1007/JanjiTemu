<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Janji Berhasil - Portal KPKNL Bogor</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/confirmation.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body style="background-color: #f8f9fa;">

<div class="booking-container" style="padding-top: 60px; padding-bottom: 60px;">

    {{-- HEADER --}}
    <div class="confirmation-header">
        <div class="check-icon">
            <i class='bx bx-check'></i>
        </div>
        <h1>Janji Berhasil Dibuat</h1>
        <p>Terima kasih telah menjadwalkan kunjungan Anda.</p>
    </div>

    <div class="confirmation-content" style="max-width: 750px; margin: 0 auto;">

        {{-- 🔥 ISI DARI FILE KEDUA --}}
        @include('booking.confirmation')
        <div class="action-buttons">
            <button onclick="window.print()" class="btn-print">
                <i class='bx bx-printer'></i> Cetak PDF / Simpan
            </button>

            <a href="{{ route('booking.index') }}" class="btn-new">
                <i class='bx bx-plus-circle'></i> Buat Janji Baru
            </a>

            <a href="/" class="btn-home">Kembali ke Beranda</a>
        </div>

    </div>

    <footer style="text-align: center; margin-top: 50px; color: #999; font-size: 0.85rem;">
        &copy; 2026 Janji Temu KPKNL Bogor
    </footer>

</div>

<script src="{{ asset('js/display-confirmation.js') }}"></script>

</body>
</html>