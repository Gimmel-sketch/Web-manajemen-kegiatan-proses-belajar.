@extends('layouts.app')

@section('title', 'Edit Ruangan')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h1 class="h4 mb-0">Edit Ruangan</h1>
        <a class="btn btn-outline-secondary btn-sm" href="{{ route('ruangan.index') }}">Kembali</a>
    </div>
    <div class="card-body">
        <form action="{{ route('ruangan.update', $ruangan) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label" for="nama_ruangan">Nama Ruangan</label>
                    <input class="form-control" id="nama_ruangan" name="nama_ruangan" value="{{ old('nama_ruangan', $ruangan->nama_ruangan) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="kapasitas">Kapasitas</label>
                    <input class="form-control" type="number" min="1" id="kapasitas" name="kapasitas" value="{{ old('kapasitas', $ruangan->kapasitas) }}" required>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a class="btn btn-outline-secondary" href="{{ route('ruangan.index') }}">Batal</a>
                <button class="btn btn-primary" type="submit">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
