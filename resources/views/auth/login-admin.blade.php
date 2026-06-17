<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - KPKNL Bogor</title>
    <link rel="stylesheet" href="{{ asset('css/auth-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

<div class="auth-wrapper">
    @include('auth.partials.header')

    <main class="auth-content">
        <div class="portal-label">
            <span class="line"></span>
            <span class="label-text">PORTAL ADMIN</span>
            <span class="line"></span>
        </div>

        <div class="main-icon">
            <div class="icon-circle admin-icon"><i class='bx bx-lock-alt'></i></div>
        </div>

        <h2>Login Admin</h2>
        <p class="subtitle">Masuk ke dashboard manajemen janji temu internal KPKNL Bogor</p>

        @include('auth.partials.card-admin')

        <p class="switch-auth">Bukan staf admin? <a href="{{ route('login.user') }}">Kembali ke Portal Klien</a></p>
    </main>

    @include('auth.partials.footer')
</div>

</body>
</html>