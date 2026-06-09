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
                    <th>No</th>
                    <th>Mahasiswa</th>
                    <th>Mata Kuliah</th>
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
                        <td>{{ $item->transaksiKrs?->mahasiswa?->nama }}<br><small class="text-muted">{{ $item->transaksiKrs?->nim }}</small></td>
                        <td>{{ $item->transaksiKrs?->mataKuliah?->nama_mk }}<br><small class="text-muted">{{ $item->transaksiKrs?->kode_mk }}</small></td>
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
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="text-center text-muted py-4">Belum ada nilai perkuliahan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
