document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginUserForm');

    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            let isPathValid = true;
            const nama = document.getElementById('nama');
            const tgl = document.getElementById('tgl_lahir');
            const nik = document.getElementById('nik');

            // Reset Pesan Error & Styling
            resetErrors();

            // 1. Validasi Nama
            if (!nama.value.trim()) {
                showError('nama', 'Nama lengkap wajib diisi');
                isPathValid = false;
            }

            // 2. Validasi Tanggal Lahir
            if (!tgl.value) {
                showError('tgl', 'Pilih tanggal lahir Anda');
                isPathValid = false;
            }

            // 3. Validasi NIK (Harus 16 angka)
            const nikRegex = /^\d{16}$/;
            if (!nikRegex.test(nik.value)) {
                showError('nik', 'NIK harus berupa 16 digit angka');
                isPathValid = false;
            }

            // Jika semua valid
            if (isPathValid) {
                handleLoadingState();

                loginForm.submit();
            }
        });
    }

    function showError(id, message) {
        const errorEl = document.getElementById(id + 'Error');
        const inputId = id === 'tgl' ? 'tgl_lahir' : id;
        const inputEl = document.getElementById(inputId);
        
        if (errorEl && inputEl) {
            errorEl.textContent = message;
            inputEl.classList.add('input-error');
            // Efek getar
            inputEl.style.animation = 'none';
            inputEl.offsetHeight; // trigger reflow
            inputEl.style.animation = 'shake 0.2s ease-in-out 0s 2';
        }
    }

    function resetErrors() {
        document.querySelectorAll('.error-msg').forEach(el => el.textContent = '');
        document.querySelectorAll('.input-wrapper input').forEach(el => {
            el.classList.remove('input-error');
        });
    }

    function handleLoadingState() {
        const btn = document.getElementById('btnSubmit');
        if (btn) {
            btn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Memverifikasi...';
            btn.style.opacity = '0.7';
            btn.style.pointerEvents = 'none';

            // Simulasi proses ke backend
            function handleLoadingState() {
                const btn = document.getElementById('btnSubmit');
                if (btn) {
                    btn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Memverifikasi...';
                    btn.style.opacity = '0.7';
                    btn.style.pointerEvents = 'none';
            }
        }
    }
}});