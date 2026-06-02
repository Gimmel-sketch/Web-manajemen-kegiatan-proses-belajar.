<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Role</title>
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
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3>Daftar Hak Akses / Role</h3>
                <a href="{{ route('roles.create') }}" class="btn btn-success btn-sm">Tambah Role</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Role</th>
                            <th>Nama User</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td><span class="badge bg-primary">{{ $role->name }}</span></td>
                                <td>{{ $role->display_name }}</td>
                                <td>{{ $role->description }}</td>
                                <td>
                                    <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
