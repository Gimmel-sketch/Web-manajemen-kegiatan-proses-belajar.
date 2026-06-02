<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
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
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h3 mb-0">Data Mahasiswa</h1>
            <a class="btn btn-primary" href="{{ route('Create-mahasiswa') }}">Tambah Data</a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th style="width: 1%;">#</th>
                                <th>Nama</th>
                                <th>NIM</th>
                                <th>Alamat</th>
                                <th>Tanggal Lahir</th>
                                <th>Tempat Lahir</th>
                                <th>Jenis Kelamin</th>
                                <th>Fakultas</th>
                                <th>Prodi</th>
                                <th>Angkatan</th>
                                <th>Semester</th>
                                <th>Email</th>
                                <th>No HP</th>
                                <th>Status</th>
                                <th>Agama</th>
                                <th>NIK</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mahasiswa as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->nim }}</td>
                                    <td>{{ $item->alamat }}</td>
                                    <td>{{ $item->tanggal_lahir }}</td>
                                    <td>{{ $item->tempat_lahir }}</td>
                                    <td>{{ $item->jenis_kelamin }}</td>
                                    <td>{{ $item->fakultas }}</td>
                                    <td>{{ $item->prodi }}</td>
                                    <td>{{ $item->angkatan }}</td>
                                    <td>{{ $item->semester }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->no_hp }}</td>
                                    <td><span class="badge text-bg-success">{{ $item->status }}</span></td>
                                    <td>{{ $item->agama }}</td>
                                    <td>{{ $item->nik }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a class="btn btn-warning btn-sm" href="{{ route('edit-mahasiswa', $item->nim) }}">Edit</a>

                                            <form action="{{ route('hapus-mahasiswa', $item->nim) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Yakin hapus?')">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="17" class="text-center text-muted py-4">Belum ada data mahasiswa.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
