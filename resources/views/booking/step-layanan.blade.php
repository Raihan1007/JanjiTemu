<div class="form-card">
    <div class="card-title">
        <i class='bx bx-briefcase'></i>
        <div>
            <h3>Pilih Layanan & Petugas</h3>
            <p>Pilih jenis layanan yang Anda butuhkan</p>
        </div>
    </div>
    <div class="input-row">
        <div class="form-group">
            <label>Jenis Layanan</label>
            <select name="layanan_id" id="pilihanLayanan" class="form-control">
                <option value="">Pilih Layanan</option>

                @foreach($layanans as $l)
                    <option value="{{ $l->id }}">{{ $l->nama }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>