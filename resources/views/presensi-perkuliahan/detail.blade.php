@extends('layouts.app')

@section('title', 'Detail Presensi - ' . $mahasiswa->nama)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Detail Presensi</h1>
    <a class="btn btn-outline-secondary" href="{{ route('presensi-perkuliahan.index') }}">Kembali</a>
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
            <div class="col-md-3"><strong>Total Presensi</strong></div>
            <div class="col-md-3">{{ $presensi->count() }} kali</div>
        </div>
        <div class="row mt-2">
            @php
                $hadir = $presensi->where('status', 'Hadir')->count();
                $izin = $presensi->where('status', 'Izin')->count();
                $sakit = $presensi->where('status', 'Sakit')->count();
                $alpa = $presensi->where('status', 'Alpa')->count();
            @endphp
            <div class="col-12">
                <span class="badge text-bg-success me-1">Hadir: {{ $hadir }}</span>
                <span class="badge text-bg-warning me-1">Izin: {{ $izin }}</span>
                <span class="badge text-bg-info me-1">Sakit: {{ $sakit }}</span>
                <span class="badge text-bg-danger">Alpa: {{ $alpa }}</span>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white">
        <strong>Riwayat Presensi</strong>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 1%;">No</th>
                        <th>Mata Kuliah</th>
                        <th>Dosen</th>
                        <th>Tanggal</th>
                        <th>Pertemuan</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($presensi as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->jadwalPerkuliahan?->mataKuliah?->nama_mk }}<br><small class="text-muted">{{ $item->jadwalPerkuliahan?->kelas }} - {{ $item->jadwalPerkuliahan?->hari }}</small></td>
                            <td>{{ $item->jadwalPerkuliahan?->dosen?->nama ?? '-' }}</td>
                            <td>{{ $item->tanggal }}</td>
                            <td>Pertemuan {{ $item->pertemuan_ke }}</td>
                            <td>
                                @php
                                    $badge = match($item->status) {
                                        'Hadir' => 'text-bg-success',
                                        'Izin' => 'text-bg-warning',
                                        'Sakit' => 'text-bg-info',
                                        'Alpa' => 'text-bg-danger',
                                        default => 'text-bg-secondary',
                                    };
                                @endphp
                                <span class="badge {{ $badge }}">{{ $item->status }}</span>
                            </td>
                            <td>{{ $item->keterangan ?? '-' }}</td>
                            <td>
                                <a class="btn btn-warning btn-sm" href="{{ route('presensi-perkuliahan.edit', $item) }}">Edit</a>
                                <form class="d-inline" action="{{ route('presensi-perkuliahan.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted py-4">Belum ada presensi untuk mahasiswa ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
