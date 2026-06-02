<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mahasiswa</title>
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

    <main class="container py-4">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h1 class="h4 mb-0">Edit Data Mahasiswa</h1>
                <a class="btn btn-outline-secondary btn-sm" href="{{ route('Data-mahasiswa') }}">Kembali</a>
            </div>
            <div class="card-body">
                <form action="{{ route('update-mahasiswa', $mahasiswa->nim) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="nama">Nama</label>
                            <input class="form-control" type="text" id="nama" name="nama" value="{{ $mahasiswa->nama }}" placeholder="Nama mahasiswa" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="nim">NIM</label>
                            <input class="form-control" type="text" id="nim" name="nim" value="{{ $mahasiswa->nim }}" placeholder="NIM mahasiswa" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="alamat">Alamat</label>
                            <input class="form-control" type="text" id="alamat" name="alamat" value="{{ $mahasiswa->alamat }}" placeholder="Alamat mahasiswa" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="tanggal_lahir">Tanggal Lahir</label>
                            <input class="form-control" type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ $mahasiswa->tanggal_lahir }}" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="tempat_lahir">Tempat Lahir</label>
                            <input class="form-control" type="text" id="tempat_lahir" name="tempat_lahir" value="{{ $mahasiswa->tempat_lahir }}" placeholder="Tempat lahir" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="jenis_kelamin">Jenis Kelamin</label>
                            <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                <option value="L" {{ $mahasiswa->jenis_kelamin === 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ $mahasiswa->jenis_kelamin === 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="fakultas">Fakultas</label>
                            <input class="form-control" type="text" id="fakultas" name="fakultas" value="{{ $mahasiswa->fakultas }}" placeholder="Fakultas" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="prodi">Prodi</label>
                            <input class="form-control" type="text" id="prodi" name="prodi" value="{{ $mahasiswa->prodi }}" placeholder="Prodi" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="angkatan">Angkatan</label>
                            <input class="form-control" type="number" id="angkatan" name="angkatan" value="{{ $mahasiswa->angkatan }}" min="1900" max="2100" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="semester">Semester</label>
                            <input class="form-control" type="number" id="semester" name="semester" value="{{ $mahasiswa->semester }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="email">Email</label>
                            <input class="form-control" type="email" id="email" name="email" value="{{ $mahasiswa->email }}" placeholder="email@example.com" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="no_hp">No HP</label>
                            <input class="form-control" type="text" id="no_hp" name="no_hp" value="{{ $mahasiswa->no_hp }}" placeholder="Nomor HP" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="status">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="Aktif" {{ $mahasiswa->status === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Cuti" {{ $mahasiswa->status === 'Cuti' ? 'selected' : '' }}>Cuti</option>
                                <option value="Lulus" {{ $mahasiswa->status === 'Lulus' ? 'selected' : '' }}>Lulus</option>
                                <option value="DO" {{ $mahasiswa->status === 'DO' ? 'selected' : '' }}>DO</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="agama">Agama</label>
                            <input class="form-control" type="text" id="agama" name="agama" value="{{ $mahasiswa->agama }}" placeholder="Agama" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="nik">NIK (16 digit)</label>
                            <input class="form-control" type="text" id="nik" name="nik" value="{{ $mahasiswa->nik }}" maxlength="16" placeholder="NIK" required>
                        </div>
                    </div>

                    <div class="d-flex gap-2 justify-content-end mt-4">
                        <a href="{{ route('Data-mahasiswa') }}" class="btn btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
