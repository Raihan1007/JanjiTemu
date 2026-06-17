<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Layanan Mandiri - KPKNL Bogor</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

<div class="auth-wrapper">
    @include('auth.partials.header')

    <main class="auth-content">
        <div class="main-icon">
            <div class="icon-circle"><i class='bx bx-check-shield'></i></div>
        </div>
        <h2>Portal Layanan Mandiri</h2>
        <p class="subtitle">Silakan lengkapi data diri Anda untuk melanjutkan proses penjadwalan janji temu.</p>

        @include('auth.partials.card-login')
        @include('auth.partials.help-box')
    </main>

    @include('auth.partials.footer')
</div>
<script src="{{ asset('js/auth-validation.js') }}"></script>

</body>
</html>