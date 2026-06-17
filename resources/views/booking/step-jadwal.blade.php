<div class="form-card">
    <div class="card-title">
        <i class='bx bx-calendar-event'></i>
        <div>
            <h3>Pilih Tanggal & Waktu</h3>
            <p>Tentukan jadwal kedatangan Anda</p>
        </div>
    </div>

    <div class="date-time-wrapper">
        <div class="calendar-dummy">
            <label for="tanggalInput">Pilih Tanggal</label>
            <input type="date" name="tanggal" id="tanggalInput" class="custom-date-picker" required>
            <p class="info-text">
                <i class='bx bx-info-circle'></i> Sabtu dan Minggu kantor tutup.
            </p>
        </div>

        <div class="time-picker">
            <label>Pilih Jam Kunjungan</label>
            <div class="time-grid" id="time-grid">
                <button type="button" class="time-slot" data-time="08:00">08:00</button>
                <button type="button" class="time-slot" data-time="09:00">09:00</button>
                <button type="button" class="time-slot" data-time="10:00">10:00</button>
                <button type="button" class="time-slot" data-time="11:00">11:00</button>
                <button type="button" class="time-slot" data-time="13:00">13:00</button>
                <button type="button" class="time-slot" data-time="14:00">14:00</button>
                <button type="button" class="time-slot" data-time="15:00">15:00</button>
            </div>

            <!-- 🔥 INI YANG PENTING -->
            <input type="hidden" name="jam" id="hidden-time" required>
        </div>
    </div>
</div>