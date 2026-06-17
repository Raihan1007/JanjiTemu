<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JAMUBOBA KPKNL BOGOR</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/nav-theme.css') }}">

    @stack('styles')
</head>
<body>

    @if(!Route::is('booking.index'))
        @include('footer.navbar')
    @endif

    <main>
        @yield('content')
    </main>

    @if(!Route::is('booking.index'))
        @include('footer.footerbooking')
    @endif

    @stack('scripts')
</body>
</html>