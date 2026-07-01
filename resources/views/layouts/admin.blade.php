<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">
    <title>JAMU BOBA Admin</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="admin-shell">
        <aside class="sidebar" id="sidebar">
            <div class="brand">
                <img src="{{ asset('image/logo2.jpeg') }}" alt="">
                <h1>JAMU BOBA</h1>
                <p>Admin Panel</p>
            </div>

            <nav class="nav-menu">
                <a class="nav-item {{ request()->is('admin/layanan') ? 'active' : '' }}" href="/admin/layanan">
                    <span class="nav-icon">&#8962;</span>
                    Layanan
                </a>
                <a class="nav-item {{ request()->is('admin/petugas') ? 'active' : '' }}" href="/admin/petugas">
                    <span class="nav-icon">&#9817;</span>
                    Petugas
                </a>
                <a class="nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }}" href="/admin/dashboard">
                    <span class="nav-icon">&#9635;</span>
                    Dashboard
                </a>
                @if(auth('admin')->user()->role === 'super_admin')

                <a class="nav-item {{ request()->is('admin/import-histori') ? 'active' : '' }}"
                href="/admin/import-histori">

                    <span class="nav-icon">★</span>
                    Import Laporan

                </a>

                <a class="nav-item {{ request()->is('admin/histori') ? 'active' : '' }}"
                    href="{{ route('admin.histori') }}">
                        <span class="nav-icon">&#128196;</span>
                        Histori Layanan
                </a>

                <a class="nav-item {{ request()->is('admin/ratings') ? 'active' : '' }}"
                href="/admin/ratings">

                    <span class="nav-icon">★</span>
                    Rating Pegawai

                </a>

                @endif
                <a class="nav-item {{ request()->is('admin/users') ? 'active' : '' }}  " href="/admin/users">
                    <span class="nav-icon">&#9818;</span>
                    Pengguna
                </a>

            <form class="logout-form" action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button class="logout" type="submit">
                    <span class="nav-icon">&#8618;</span>
                    Logout
                </button>
            </form>
        </aside>

        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <main class="main-content">
            <header class="topbar">
                <button class="menu-button" id="menuButton" type="button">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <div class="welcome">
                    <h2>Selamat datang, {{ auth('admin')->user()->nama ?? 'Admin' }}</h2>
                    <p>Kelola janji temu dengan mudah dan efisien.</p>
                </div>

                <div class="topbar-actions">
                    <button class="notification" type="button">
                        <span class="bell">&#9826;</span>
                        <span class="notification-dot"></span>
                    </button>

                    @php
                        $admin = auth('admin')->user();
                    @endphp

                    <div class="profile">
                        <div class="profile-avatar">
                            {{ strtoupper(substr($admin->nama ?? 'A', 0, 1)) }}
                        </div>

                        <div>
                            <strong>{{ $admin->nama ?? 'Admin' }}</strong>
                            <span>{{ $admin->email ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </header>

            @yield('content')
            @yield('scripts')
        </main>
    </div>
</body>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const $ = (s) => document.querySelector(s);

    const modal = $('#modalEdit');
    const closeBtn = $('#closeEdit');
    const formEdit = $('#formEdit');

    function openModal() {
        modal.style.display = 'flex';
    }

    function closeModal() {
        modal.style.display = 'none';
    }

    // =========================
    // CLICK EDIT
    // =========================
    document.addEventListener('click', function(e) {

        const editBtn = e.target.closest('.btn-edit');
        if (editBtn) {
            const id = editBtn.dataset.id;

            fetch(`/admin/petugas/${id}`)
                .then(res => res.json())
                .then(data => {
                    $('#edit-id').value = data.id;
                    $('#edit-nama').value = data.nama;
                    $('#edit-layanan').value = data.layanan_id;

                    openModal();
                });
        }

        // klik luar modal
        if (e.target === modal) {
            closeModal();
        }
    });

    // =========================
    // CLOSE BUTTON
    // =========================
    if (closeBtn) {
        closeBtn.onclick = closeModal;
    }

    // ESC close
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeModal();
    });

    // =========================
    // SUBMIT EDIT
    // =========================
    if (formEdit) {
        formEdit.addEventListener('submit', function(e) {
            e.preventDefault();

            const id = $('#edit-id').value;

            fetch(`/admin/petugas/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    nama: $('#edit-nama').value,
                    layanan_id: $('#edit-layanan').value
                })
            })
            .then(res => res.json())
            .then(() => {
                location.reload(); // paling aman dulu
            })
            .catch(() => {
                alert('Gagal update!');
            });
        });
    }

    // =========================
    // DETAIL BOOKING
    // =========================
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.btn-detail');

        if (btn) {
            const id = btn.dataset.id;

            fetch(`/admin/bookings/${id}`)
                .then(res => res.json())
                .then(data => {
                    $('#d-nama').innerText = data.nama;
                    $('#d-email').innerText = data.email;
                    $('#d-hp').innerText = data.nomor_hp;
                    $('#d-layanan').innerText = data.layanan.nama;
                    $('#d-petugas').innerText = data.petugas.nama;
                    $('#d-tanggal').innerText = data.tanggal;
                    $('#d-jam').innerText = data.jam;

                    $('#modalDetail').style.display = 'flex';
                });
        }
    });

    // =========================
    // SIDEBAR MOBILE
    // =========================
    const menuButton = document.getElementById("menuButton");
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("sidebarOverlay");

    if(menuButton){

        menuButton.addEventListener("click", function(){

            sidebar.classList.toggle("active");
            overlay.classList.toggle("active");

        });

    }

    if(overlay){

        overlay.addEventListener("click", function(){

            sidebar.classList.remove("active");
            overlay.classList.remove("active");

        });

    }

    document.querySelectorAll(".nav-item").forEach(item => {

        item.addEventListener("click", function(){

            if(window.innerWidth <= 860){

                sidebar.classList.remove("active");
                overlay.classList.remove("active");

            }

        });

    });

});
</script>
</html>
