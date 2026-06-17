<div class="login-card">
    <h3>Verifikasi Identitas</h3>
    <p class="card-info">Data Anda akan diverifikasi secara sistematis melalui basis data kependudukan.</p>

    <form id="loginUserForm" action="{{ route('login.user.submit') }}" method="POST">
    @csrf
    
    <div class="form-group">
        <label>Nama Lengkap</label>
        <div class="input-wrapper">
            <i class='bx bx-user'></i>
            <input type="text" name="nama" id="nama" placeholder="Contoh: Budi Setiawan" value="{{ old('nama') }}">
        </div>
        <span id="namaError" class="error-msg" style="color: red; font-size: 12px;">Isi nama lengkap</span>
        @error('nama') <span class="error-msg" style="color: red; font-size: 12px;">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label>Tanggal Lahir</label>
        <div class="input-wrapper">
            <i class='bx bx-calendar'></i>
            <input type="date" name="tanggal_lahir" id="tgl_lahir" value="{{ old('tanggal_lahir') }}">
        </div>
        <span id="tglError" class="error-msg" style="color: red; font-size: 12px;">Pilih tanggal lahir</span>
        @error('tanggal_lahir') <span class="error-msg" style="color: red; font-size: 12px;">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label>NIK (Nomor Induk Kependudukan)</label>
        <div class="input-wrapper">
            <i class='bx bx-fingerprint'></i>
            <input type="text" name="nik" id="nik" maxlength="16" placeholder="16 Digit NIK sesuai KTP" value="{{ old('nik') }}">
        </div>
       <span id="nikError" class="error-msg" style="color: red; font-size: 12px;">NIK harus 16 digit</span>
       @error('nik') 
        <span class="error-msg" style="color: red; font-size: 12px;">
            {{ $message }}
        </span> 
        @enderror
        <small class="privacy-note">
            <i class='bx bx-info-circle'></i> Kerahasiaan data Anda dijamin sesuai UU No. 27 Tahun 2022 (PDP).
        </small>
    </div>

        <button type="submit" class="btn-main" id="btnSubmit">
            Masuk / Lanjutkan <i class='bx bx-right-arrow-alt'></i>
        </button>
        
        <div class="divider"><span>ATAU</span></div>

        <a href="/" class="btn-outline">
            <i class='bx bx-calendar-event'></i> Lihat Jadwal & Prosedur Booking
        </a>
    </form>
</div>