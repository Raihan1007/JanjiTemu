<nav class="ss-nav logo-nav">
  <img src="{{ asset('image/logo2.jpeg') }}" alt="Logo">
	<div class="links">
		<a href="#beranda">Beranda</a>
		<a href="#tentang">Tentang</a>
		<a href="#layanan">Layanan</a>
		<a href="#cara-kerja">Cara Kerja</a>
	</div>
	<div class="auth-links">

    @guest
        {{-- BELUM LOGIN --}}
        <a href="{{ route('admin.login') }}" class="btn-primary">Masuk Admin</a>
        <a href="{{ route('login.user') }}" class="btn-primary">Login</a>
    @endguest

    @auth
        {{-- SUDAH LOGIN --}}
        <span>Halo, {{ auth()->user()->nama }}</span>

        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn-logout">Logout</button>
        </form>
    @endauth

    {{-- TOMBOL BOOKING (SELALU ADA) --}}
    <a href="{{ route('booking.index') }}" class="btn-secondary">Buat Janji</a>

</div>
</nav>