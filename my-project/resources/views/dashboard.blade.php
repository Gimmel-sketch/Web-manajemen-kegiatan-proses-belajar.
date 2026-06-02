<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Biodata - Cool</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<style>
    body {
        margin: 0;  
        padding: 0;
        /* Background dingin dengan gradien linear */
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        font-family: 'Segoe UI', Arial, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }

    .container {
        width: 1000px;
        height: 600px;
        position: relative;
        /* Warna container yang lebih terang dari body tapi tetap dingin */
        background: #1e293b;
        border-radius: 20px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* Semua garis sudut */
    .corner {
        position: absolute;
        width: 250px;
        height: 150px;
    }

    .line {
        position: absolute;
        /* Warna garis diubah menjadi warna dingin (Cyan) agar kontras */
        border: 3px solid #38bdf8; 
        width: 180px;
        height: 100px;
        filter: drop-shadow(0 0 5px rgba(56, 189, 248, 0.5));
    }

    /* Kiri atas */
    .top-left .line:nth-child(1) {
        top: 0; left: 0;
        border-right: none; border-bottom: none;
    }
    .top-left .line:nth-child(2) {
        top: 20px; left: 20px;
        border-right: none; border-bottom: none;
        opacity: 0.6;
    }
    .top-left .line:nth-child(3) {
        top: 40px; left: 40px;
        border-right: none; border-bottom: none;
        opacity: 0.3;
    }

    /* Kanan atas */
    .top-right { top: 0; right: 0; }
    .top-right .line:nth-child(1) {
        top: 0; right: 0;
        border-left: none; border-bottom: none;
    }
    .top-right .line:nth-child(2) {
        top: 20px; right: 20px;
        border-left: none; border-bottom: none;
        opacity: 0.6;
    }
    .top-right .line:nth-child(3) {
        top: 40px; right: 40px;
        border-left: none; border-bottom: none;
        opacity: 0.3;
    }

    /* Kiri bawah */
    .bottom-left { bottom: 0; left: 0; }
    .bottom-left .line:nth-child(1) {
        bottom: 0; left: 0;
        border-right: none; border-top: none;
    }
    .bottom-left .line:nth-child(2) {
        bottom: 20px; left: 20px;
        border-right: none; border-top: none;
        opacity: 0.6;
    }
    .bottom-left .line:nth-child(3) {
        bottom: 40px; left: 40px;
        border-right: none; border-top: none;
        opacity: 0.3;
    }

    /* Kanan bawah */
    .bottom-right { bottom: 0; right: 0; }
    .bottom-right .line:nth-child(1) {
        bottom: 0; right: 0;
        border-left: none; border-top: none;
    }
    .bottom-right .line:nth-child(2) {
        bottom: 20px; right: 20px;
        border-left: none; border-top: none;
        opacity: 0.6;
    }
    .bottom-right .line:nth-child(3) {
        bottom: 40px; right: 40px;
        border-left: none; border-top: none;
        opacity: 0.3;
    }

    /* Teks */
    .text-box {
        position: absolute;
        top: 80px;
        left: 100px;
        color: #f1f5f9; /* Putih agak abu agar tidak terlalu tajam */
        font-size: 22px;
        line-height: 1.8;
    }

    h1 {
        color: #38bdf8;
        font-size: 45px;
        margin-bottom: 20px;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    ul {
        list-style: none;
        padding: 0;
    }

    li {
        margin-bottom: 10px;
        padding-left: 15px;
        border-left: 2px solid #38bdf8;
    }
</style>
</head>
<body>

<div class="container">
    <div class="corner top-left">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
    </div>

    <div class="corner top-right">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
    </div>

    <div class="corner bottom-left">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
    </div>

    <div class="corner bottom-right">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
    </div>

    <div class="text-box">
        <h1>Bio Data Diri</h1>
        <ul>
            <li><strong>Nama :</strong> Muhammad Fajar Aulia</li>
            <li><strong>NIM :</strong> 2455201110010</li>
            <li><strong>TTL :</strong> Marabahan, 12-07-2006</li>
            <li><strong>Alamat :</strong> Marabahan</li>
            <li><strong>Mobil Favorit :</strong> Dodge Viper SRT</li>
        </ul>
        <a class="btn btn-outline-info btn-sm" href="{{ route('Data-mahasiswa') }}">Data Mahasiswa</a>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
