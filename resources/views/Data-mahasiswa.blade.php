@extends('layouts.app')

@section('title', 'Data Mahasiswa')

@section('content')
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
                                <th style="width: 1%;">No</th>
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
                                            <a class="btn btn-outline-info btn-sm" href="{{ route('mahasiswa.evaluasi', $item->nim) }}" title="Evaluasi Fuzzy">Fuzzy</a>
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
@endsection
