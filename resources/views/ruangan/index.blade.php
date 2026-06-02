@extends('layouts.app')

@section('title', 'Data Ruangan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Data Ruangan</h1>
    <a class="btn btn-primary" href="{{ route('ruangan.create') }}">Tambah Ruangan</a>
</div>

<div class="card shadow-sm">
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nama Ruangan</th>
                    <th>Kapasitas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ruangan as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama_ruangan }}</td>
                        <td>{{ $item->kapasitas }}</td>
                        <td>
                            <a class="btn btn-warning btn-sm" href="{{ route('ruangan.edit', $item) }}">Edit</a>
                            <form class="d-inline" action="{{ route('ruangan.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">Belum ada data ruangan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
