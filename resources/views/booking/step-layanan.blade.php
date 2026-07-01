<div class="form-card">
    <div class="card-title">
        <i class='bx bx-briefcase'></i>
        <div>
            <h3>Pilih Layanan & Kategori</h3>
            <p>Pilih jenis layanan yang Anda butuhkan</p>
        </div>
    </div>

    <div class="input-row">

        {{-- LAYANAN --}}
        <div class="form-group">
            <label>Jenis Layanan</label>

            <select
                name="layanan_id"
                id="pilihanLayanan"
                class="form-control"
                required
            >
                <option value="">Pilih Layanan</option>

                @foreach($layanans as $layanan)
                    <option value="{{ $layanan->id }}">
                        {{ $layanan->nama }}
                    </option>
                @endforeach

            </select>
        </div>

        {{-- KATEGORI --}}
        <div class="form-group">
            <label>Kategori</label>

            <select
                name="kategori_booking_id"
                id="pilihanKategori"
                class="form-control"
                required
            >
                <option value="">Pilih Kategori</option>

                @foreach($kategoriBookings as $kategori)
                    <option value="{{ $kategori->id }}">
                        {{ $kategori->nama }}
                    </option>
                @endforeach

            </select>
        </div>

    </div>
</div>