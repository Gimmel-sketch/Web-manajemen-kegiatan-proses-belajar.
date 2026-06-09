@extends('layouts.app')

@section('title', 'Data Buku')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Data Buku</h1>
    <a class="btn btn-primary" href="{{ route('buku.create') }}">Tambah Buku</a>
</div>

<div class="card shadow-sm">
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($buku as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->kode_buku }}</td>
                        <td>{{ $item->judul_buku }}</td>
                        <td>{{ $item->penulis }}</td>
                        <td>{{ $item->stok }}</td>
                        <td>
                            <a class="btn btn-warning btn-sm" href="{{ route('buku.edit', $item) }}">Edit</a>
                            <form class="d-inline" action="{{ route('buku.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Belum ada data buku.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
