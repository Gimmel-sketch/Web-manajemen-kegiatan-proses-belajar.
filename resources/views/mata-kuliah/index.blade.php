@extends('layouts.app')

@section('title', 'Data Mata Kuliah')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Data Mata Kuliah</h1>
    <a class="btn btn-primary" href="{{ route('mata-kuliah.create') }}">Tambah Mata Kuliah</a>
</div>

<div class="card shadow-sm">
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Kode MK</th>
                    <th>Nama Mata Kuliah</th>
                    <th>SKS</th>
                    <th>Semester</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mataKuliah as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->kode_mk }}</td>
                        <td>{{ $item->nama_mk }}</td>
                        <td>{{ $item->sks }}</td>
                        <td>{{ $item->semester }}</td>
                        <td>
                            <a class="btn btn-warning btn-sm" href="{{ route('mata-kuliah.edit', $item) }}">Edit</a>
                            <form class="d-inline" action="{{ route('mata-kuliah.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Belum ada data mata kuliah.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
