@extends('layouts.app')

@section('title', 'Data KRS')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Data KRS</h1>
    <a class="btn btn-primary" href="{{ route('transaksi-krs.create') }}">Tambah KRS</a>
</div>

<div class="card shadow-sm">
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Mahasiswa</th>
                    <th>Mata Kuliah</th>
                    <th>Dosen</th>
                    <th>Semester Tempuh</th>
                    <th>Tahun Akademik</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksiKrs as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->mahasiswa?->nama }}<br><small class="text-muted">{{ $item->nim }}</small></td>
                        <td>{{ $item->mataKuliah?->nama_mk }}<br><small class="text-muted">{{ $item->kode_mk }}</small></td>
                        <td>{{ $item->dosen?->nama ?? '-' }}<br><small class="text-muted">{{ $item->nidn }}</small></td>
                        <td>{{ $item->semester_tempuh }}</td>
                        <td>{{ $item->tahun_akademik }}</td>
                        <td>
                            <a class="btn btn-warning btn-sm" href="{{ route('transaksi-krs.edit', $item) }}">Edit</a>
                            <form class="d-inline" action="{{ route('transaksi-krs.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Belum ada data KRS.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
