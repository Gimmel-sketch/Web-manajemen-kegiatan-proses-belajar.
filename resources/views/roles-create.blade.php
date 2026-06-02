<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Role</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
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

    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h3>Tambah Role Baru</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('roles.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Role (System Name)</label>
                        <input type="text" name="name" class="form-control" placeholder="contoh: admin" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama User</label>
                        <input type="text" name="display_name" class="form-control" placeholder="contoh: Administrator" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('roles.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan Role</button>
                    </div>
                </form>
            </div>
        </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
