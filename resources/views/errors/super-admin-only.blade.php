<!DOCTYPE html>
<html>
<head>
    <title>Akses Ditolak</title>

    <style>

        body{
            margin:0;
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            background:#f5f7fa;
            font-family:Arial,sans-serif;
        }

        .card{
            background:white;
            padding:40px;
            border-radius:15px;
            text-align:center;
            box-shadow:0 10px 30px rgba(0,0,0,.1);
        }

        h1{
            color:#dc3545;
            margin-bottom:10px;
        }

        p{
            color:#666;
            margin-bottom:20px;
        }

        a{
            text-decoration:none;
            background:#0d6efd;
            color:white;
            padding:10px 20px;
            border-radius:8px;
        }

    </style>
</head>
<body>

<div class="card">

    <h1>🚫 Akses Ditolak</h1>

    <p>
        Halaman ini hanya dapat diakses oleh Super Admin.
    </p>

    <a href="{{ route('admin.layanan') }}">
        Kembali
    </a>

</div>

</body>
</html>