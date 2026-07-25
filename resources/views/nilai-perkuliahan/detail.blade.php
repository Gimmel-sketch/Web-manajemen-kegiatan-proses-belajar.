@extends('layouts.app')

@section('title', 'Detail Nilai - ' . $mahasiswa->nama)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Detail Nilai</h1>
    <a class="btn btn-outline-secondary" href="{{ route('nilai-perkuliahan.index') }}">Kembali</a>
</div>

<div class="card shadow-sm mb-3">
    <div class="card-body">
        <div class="row">
            <div class="col-md-3"><strong>Nama</strong></div>
            <div class="col-md-3">{{ $mahasiswa->nama }}</div>
            <div class="col-md-3"><strong>NIM</strong></div>
            <div class="col-md-3">{{ $mahasiswa->nim }}</div>
        </div>
        <div class="row mt-2">
            <div class="col-md-3"><strong>Fakultas</strong></div>
            <div class="col-md-3">{{ $mahasiswa->fakultas }}</div>
            <div class="col-md-3"><strong>Prodi</strong></div>
            <div class="col-md-3">{{ $mahasiswa->prodi }}</div>
        </div>
        <div class="row mt-2">
            <div class="col-md-3"><strong>Semester</strong></div>
            <div class="col-md-3">{{ $mahasiswa->semester }}</div>
            <div class="col-md-3"><strong>Angkatan</strong></div>
            <div class="col-md-3">{{ $mahasiswa->angkatan }}</div>
        </div>
        <div class="row mt-2">
            <div class="col-md-3"><strong>Rata-rata Nilai</strong></div>
            <div class="col-md-3">{{ round($nilaiPerkuliahan->avg('nilai_akhir'), 2) }}</div>
            <div class="col-md-3"><strong>Total MK</strong></div>
            <div class="col-md-3">{{ $nilaiPerkuliahan->count() }} MK</div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white">
        <strong>Daftar Nilai</strong>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 1%;">No</th>
                        <th>Kode MK</th>
                        <th>Mata Kuliah</th>
                        <th>SKS</th>
                        <th>Tugas</th>
                        <th>UTS</th>
                        <th>UAS</th>
                        <th>Akhir</th>
                        <th>Huruf</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($nilaiPerkuliahan as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->transaksiKrs?->mataKuliah?->kode_mk }}</td>
                            <td>{{ $item->transaksiKrs?->mataKuliah?->nama_mk }}</td>
                            <td>{{ $item->transaksiKrs?->mataKuliah?->sks ?? '-' }}</td>
                            <td>{{ $item->nilai_tugas ?? '-' }}</td>
                            <td>{{ $item->nilai_uts ?? '-' }}</td>
                            <td>{{ $item->nilai_uas ?? '-' }}</td>
                            <td>{{ $item->nilai_akhir ?? '-' }}</td>
                            <td>{{ $item->nilai_huruf ?? '-' }}</td>
                            <td>
                                <a class="btn btn-warning btn-sm" href="{{ route('nilai-perkuliahan.edit', $item) }}">Edit</a>
                                <form class="d-inline" action="{{ route('nilai-perkuliahan.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                                </form>
                                <a class="btn btn-outline-info btn-sm" href="{{ route('nilai-perkuliahan.fuzzy-detail', $item) }}" title="Lihat detail fuzzy">
                                    Fuzzy
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="10" class="text-center text-muted py-4">Belum ada nilai untuk mahasiswa ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
