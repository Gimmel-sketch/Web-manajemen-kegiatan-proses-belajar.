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
                    <th style="width: 1%;">No</th>
                    <th>Nama</th>
                    <th>NIM</th>
                    <th>Fakultas</th>
                    <th>Prodi</th>
                    <th>Total Presensi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($presensiPerMahasiswa as $nim => $items)
                    @php $m = $items->first()->mahasiswa; @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $m?->nama ?? 'N/A' }}</td>
                        <td>{{ $nim }}</td>
                        <td>{{ $m?->fakultas ?? '-' }}</td>
                        <td>{{ $m?->prodi ?? '-' }}</td>
                        <td>{{ $items->count() }} kali</td>
                        <td>
                            <a class="btn btn-info btn-sm" href="{{ route('presensi-perkuliahan.by-mahasiswa', $nim) }}">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Belum ada data presensi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
