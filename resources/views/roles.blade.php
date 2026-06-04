<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Role</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .sidebar {
            width: 250px;
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #212529;
            padding: 20px 15px;
        }

        .sidebar .brand {
            color: #fff;
            font-size: 22px;
            font-weight: 600;
            text-decoration: none;
            display: block;
            margin-bottom: 30px;
        }

        .sidebar .nav-link {
            color: #adb5bd;
            border-radius: 6px;
            margin-bottom: 6px;
            padding: 10px 12px;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background-color: #0d6efd;
        }

        .main-content {
            margin-left: 250px;
            padding: 30px;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                min-height: auto;
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <a class="brand" href="/">Mahasiswa</a>

        <nav class="nav flex-column">
            <a class="nav-link" href="/dashboard">Dashboard</a>
            <a class="nav-link" href="{{ route('Data-mahasiswa') }}">Data Mahasiswa</a>
            <a class="nav-link" href="{{ route('mata-kuliah.index') }}">Mata Kuliah</a>
            <a class="nav-link" href="{{ route('buku.index') }}">Buku</a>
            <a class="nav-link" href="{{ route('transaksi-krs.index') }}">KRS</a>
            <a class="nav-link" href="{{ route('pembayaran-ukt.index') }}">UKT</a>
            <a class="nav-link" href="{{ route('peminjaman-buku.index') }}">Peminjaman</a>
            <a class="nav-link active" href="{{ route('roles.index') }}">Roles</a>
        </nav>
    </aside>

    <main class="main-content">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Daftar Hak Akses / Role</h3>
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
                            <th>Hak Akses</th>
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
                                    @forelse (($role->permissions ?? []) as $permission)
                                        <span class="badge bg-secondary mb-1">{{ $permissions[$permission] ?? $permission }}</span>
                                    @empty
                                        <span class="text-muted">Belum ada akses</span>
                                    @endforelse
                                </td>
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
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
