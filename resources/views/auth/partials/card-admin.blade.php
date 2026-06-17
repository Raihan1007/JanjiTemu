<div class="login-card">
   <form action="/admin/login" method="POST">
    @csrf

    <div class="form-group">
        <label>Email</label>
        <div class="input-wrapper">
            <i class='bx bx-user'></i>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email Anda" required>
        </div>
        @error('email')
            <p style="color:red; font-size:12px;">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label>Kata Sandi</label>
        <div class="input-wrapper">
            <i class='bx bx-lock'></i>
            <input type="password" name="password" placeholder="........" required>
        </div>
    </div>


    <div class="alert-warning">
        <i class='bx bx-error-circle'></i>
        <div class="alert-text">
            <strong>Akses Terbatas</strong>
            <p>Sistem ini hanya diperuntukkan bagi personel KPKNL Bogor yang berwenang. Segala bentuk akses tidak sah akan dipantau dan dilaporkan.</p>
        </div>
    </div>

        <button type="submit" class="btn-main">Masuk ke Dashboard</button>

    </form>
</div>