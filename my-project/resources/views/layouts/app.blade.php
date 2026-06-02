<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi Kampus')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="/">Mahasiswa</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="/dashboard">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('Data-mahasiswa') }}">Data Mahasiswa</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('mata-kuliah.index') }}">Mata Kuliah</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('buku.index') }}">Buku</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('transaksi-krs.index') }}">KRS</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('pembayaran-ukt.index') }}">UKT</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('peminjaman-buku.index') }}">Peminjaman</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('roles.index') }}">Roles</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container-fluid px-4 pb-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Data belum bisa disimpan.</strong>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
