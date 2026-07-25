@extends('layouts.app')

@section('title', 'Nilai Perkuliahan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Nilai Perkuliahan</h1>
    <a class="btn btn-primary" href="{{ route('nilai-perkuliahan.create') }}">Tambah Nilai</a>
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
                    <th>Jumlah MK</th>
                    <th>Rata-rata Nilai</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($nilaiPerMahasiswa as $nim => $items)
                    @php
                        $m = $items->first()->transaksiKrs?->mahasiswa;
                        $rata = round($items->avg('nilai_akhir'), 2);
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $m?->nama ?? 'N/A' }}</td>
                        <td>{{ $nim }}</td>
                        <td>{{ $m?->fakultas ?? '-' }}</td>
                        <td>{{ $m?->prodi ?? '-' }}</td>
                        <td>{{ $items->count() }} MK</td>
                        <td>{{ $rata }}</td>
                        <td>
                            <a class="btn btn-info btn-sm" href="{{ route('nilai-perkuliahan.by-mahasiswa', $nim) }}">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">Belum ada nilai perkuliahan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
