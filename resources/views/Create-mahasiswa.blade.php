@extends('layouts.app')

@section('title', 'Tambah Data Mahasiswa')

@section('content')
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h1 class="h4 mb-0">Tambah Data Mahasiswa</h1>
                <a class="btn btn-outline-secondary btn-sm" href="{{ route('Data-mahasiswa') }}">Data Mahasiswa</a>
            </div>
            <div class="card-body">
                <form action="{{ route('simpan-mahasiswa') }}" method="POST">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="nama">Nama</label>
                            <input class="form-control" type="text" id="nama" name="nama" placeholder="Nama mahasiswa" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="nim">NIM</label>
                            <input class="form-control" type="text" id="nim" name="nim" placeholder="NIM mahasiswa" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="alamat">Alamat</label>
                            <input class="form-control" type="text" id="alamat" name="alamat" placeholder="Alamat mahasiswa" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="tanggal_lahir">Tanggal Lahir</label>
                            <input class="form-control" type="date" id="tanggal_lahir" name="tanggal_lahir" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="tempat_lahir">Tempat Lahir</label>
                            <input class="form-control" type="text" id="tempat_lahir" name="tempat_lahir" placeholder="Tempat lahir" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="jenis_kelamin">Jenis Kelamin</label>
                            <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="fakultas">Fakultas</label>
                            <input class="form-control" type="text" id="fakultas" name="fakultas" placeholder="Fakultas" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="prodi">Prodi</label>
                            <input class="form-control" type="text" id="prodi" name="prodi" placeholder="Prodi" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="angkatan">Angkatan</label>
                            <input class="form-control" type="number" id="angkatan" name="angkatan" min="1900" max="2100" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="semester">Semester</label>
                            <input class="form-control" type="number" id="semester" name="semester" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="email">Email</label>
                            <input class="form-control" type="email" id="email" name="email" placeholder="email@example.com" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="no_hp">No HP</label>
                            <input class="form-control" type="text" id="no_hp" name="no_hp" placeholder="Nomor HP" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="status">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="Aktif">Aktif</option>
                                <option value="Cuti">Cuti</option>
                                <option value="Lulus">Lulus</option>
                                <option value="DO">DO</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="agama">Agama</label>
                            <input class="form-control" type="text" id="agama" name="agama" placeholder="Agama" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="nik">NIK (16 digit)</label>
                            <input class="form-control" type="text" id="nik" name="nik" maxlength="16" placeholder="NIK" required>
                        </div>
                    </div>

                    <div class="d-flex gap-2 justify-content-end mt-4">
                        <a href="{{ route('Data-mahasiswa') }}" class="btn btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
@endsection
