<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Rating Pelayanan</title>

    <link rel="stylesheet" href="{{ asset('css/rating.css') }}">
</head>
<body>

<div class="rating-container">

    <div class="rating-icon">
        ⭐
    </div>

    <div class="rating-header">

        <h1>Rating Pelayanan</h1>

        <p>
            Berikan penilaian terhadap pelayanan pegawai.
        </p>

    </div>

    @if(session('success'))

        <div class="success-message">
            {{ session('success') }}
        </div>

    @endif

    <form action="{{ route('rating.store') }}" method="POST">

        @csrf

        <div class="form-group">

            <label>Nama</label>

            <input
                type="text"
                name="nama"
                placeholder="Masukkan nama"
                required
            >

        </div>

        <div class="form-group">

            <label>NIK</label>

            <input
                type="text"
                name="nik"
                placeholder="Masukkan NIK"
                required
            >

        </div>

        <div class="form-group">

            <label>Layanan</label>

            <select name="layanan_id" required>

                <option value="">
                    Pilih Layanan
                </option>

                @foreach($layanans as $l)

                    <option value="{{ $l->id }}">
                        {{ $l->nama }}
                    </option>

                @endforeach

            </select>

        </div>

        <div class="form-group">

            <label>Pegawai</label>

            <select name="petugas_id" required>

                <option value="">
                    Pilih Pegawai
                </option>

                @foreach($petugas as $p)

                    <option value="{{ $p->id }}">
                        {{ $p->nama }}
                    </option>

                @endforeach

            </select>

        </div>

        <div class="form-group">

            <label>Rating</label>

            <div class="rating-buttons">

                <button type="submit" name="rating" value="1">
                    ⭐
                </button>

                <button type="submit" name="rating" value="2">
                    ⭐⭐
                </button>

                <button type="submit" name="rating" value="3">
                    ⭐⭐⭐
                </button>

                <button type="submit" name="rating" value="4">
                    ⭐⭐⭐⭐
                </button>

                <button type="submit" name="rating" value="5">
                    ⭐⭐⭐⭐⭐
                </button>

            </div>

        </div>

    </form>

</div>

</body>
</html>