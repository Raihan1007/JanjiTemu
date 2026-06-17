<div class="ticket-card">

    <div class="ticket-header">
        <div class="ref-group">
            <span>KODE REFERENSI JANJI</span>
            <h3 id="ref-code">{{ $booking->kode_referensi }}</h3>
        </div>
    </div>

    <div class="ticket-body">
        <h4>Ringkasan Janji Temu</h4>

        <div class="info-grid">
            <div class="info-item">
                <span class="label">Nama</span>
                <span class="value" id="c-nama">{{ $booking->nama }}</span>
            </div>

            <div class="info-item">
                <span class="label">Instansi</span>
                <span class="value" id="c-instansi">{{ $booking->instansi }}</span>
            </div>

            <div class="info-item">
                <span class="label">Layanan</span>
                <span class="value" id="c-layanan">{{ $booking->layanan->nama }}</span>
            </div>

            <div class="info-item">
                <span class="label">Tanggal</span>
                <span class="value" id="c-tanggal">{{ $booking->tanggal }}</span>
            </div>

            <div class="info-item">
                <span class="label">Jam</span>
                <span class="value" id="c-jam">{{ $booking->jam }}</span>
            </div>

            @php
                $isJumat = \Carbon\Carbon::parse($booking->tanggal)->isFriday();
            @endphp

            @if($isJumat)
                <div class="online-info">
                    <strong>📢 Informasi Pertemuan Online</strong>

                    <p>
                        Pertemuan akan dilaksanakan secara online karena WFH pada hari Jumat.
                        Link Google Meet akan dikirimkan oleh admin melalui WhatsApp setelah booking dikonfirmasi.
                    </p>
                </div>
            @endif
        </div>
    </div>

    {{-- 🔥 FORM TETAP DI SINI --}}
    <form id="formBooking" action="{{ route('booking.store') }}" method="POST">
        @csrf

        <input type="hidden" name="nama" id="f-nama">
        <input type="hidden" name="email" id="f-email">
        <input type="hidden" name="nomor_hp" id="f-hp">
        <input type="hidden" name="instansi" id="f-instansi">
        <input type="hidden" name="layanan_id" id="f-layanan">
        <input type="hidden" name="petugas_id" id="f-petugas">
        <input type="hidden" name="tanggal" id="f-tanggal">
        <input type="hidden" name="jam" id="f-jam">

    </form>

</div>

{{-- INSTRUKSI --}}
@include('confirm-section.confirm-instruction')