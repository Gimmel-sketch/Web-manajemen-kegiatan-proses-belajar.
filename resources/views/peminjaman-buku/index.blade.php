@extends('layouts.app')

@section('title', 'Peminjaman Buku')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Peminjaman Buku</h1>
    <a class="btn btn-primary" href="{{ route('peminjaman-buku.create') }}">Tambah Peminjaman</a>
</div>

<div class="card shadow-sm">
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Mahasiswa</th>
                    <th>Buku</th>
                    <th>Pinjam</th>
                    <th>Tenggat</th>
                    <th>Kembali</th>
                    <th>Status</th>
                    <th>Denda</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjamanBuku as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->mahasiswa?->nama }}<br><small class="text-muted">{{ $item->nim }}</small></td>
                        <td>{{ $item->buku?->judul_buku }}<br><small class="text-muted">{{ $item->kode_buku }}</small></td>
                        <td>{{ $item->tanggal_pinjam?->format('d/m/Y') }}</td>
                        <td>{{ $item->tanggal_tenggat?->format('d/m/Y') }}</td>
                        <td>{{ $item->tanggal_kembali?->format('d/m/Y') ?? '-' }}</td>
                        <td><span class="badge text-bg-secondary">{{ $item->status_pinjam }}</span></td>
                        <td>Rp {{ number_format($item->denda ?? 0, 0, ',', '.') }}</td>
                        <td>
                            <a class="btn btn-warning btn-sm" href="{{ route('peminjaman-buku.edit', $item) }}">Edit</a>
                            <form class="d-inline" action="{{ route('peminjaman-buku.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="text-center text-muted py-4">Belum ada data peminjaman buku.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
