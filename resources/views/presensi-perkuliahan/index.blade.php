@extends('layouts.app')

@section('title', 'Presensi Perkuliahan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Presensi Perkuliahan</h1>
    <a class="btn btn-primary" href="{{ route('presensi-perkuliahan.create') }}">Tambah Presensi</a>
</div>

<div class="card shadow-sm">
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Jadwal</th>
                    <th>Mahasiswa</th>
                    <th>Tanggal</th>
                    <th>Pertemuan</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($presensiPerkuliahan as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->jadwalPerkuliahan?->mataKuliah?->nama_mk }}<br><small class="text-muted">{{ $item->jadwalPerkuliahan?->kelas }} - {{ $item->jadwalPerkuliahan?->hari }}</small></td>
                        <td>{{ $item->mahasiswa?->nama }}<br><small class="text-muted">{{ $item->nim }}</small></td>
                        <td>{{ $item->tanggal }}</td>
                        <td>{{ $item->pertemuan_ke }}</td>
                        <td>{{ $item->status }}</td>
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
                    <tr><td colspan="8" class="text-center text-muted py-4">Belum ada presensi perkuliahan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
