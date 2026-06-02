@extends('layouts.app')

@section('title', 'Tambah Dosen')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h1 class="h4 mb-0">Tambah Dosen</h1>
        <a class="btn btn-outline-secondary btn-sm" href="{{ route('dosen.index') }}">Kembali</a>
    </div>
    <div class="card-body">
        <form action="{{ route('dosen.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label" for="nidn">NIDN</label>
                    <input class="form-control" id="nidn" name="nidn" value="{{ old('nidn') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="nama">Nama</label>
                    <input class="form-control" id="nama" name="nama" value="{{ old('nama') }}" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="gelar">Gelar</label>
                    <input class="form-control" id="gelar" name="gelar" value="{{ old('gelar') }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="spesialisasi">Spesialisasi</label>
                    <input class="form-control" id="spesialisasi" name="spesialisasi" value="{{ old('spesialisasi') }}" required>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a class="btn btn-outline-secondary" href="{{ route('dosen.index') }}">Batal</a>
                <button class="btn btn-primary" type="submit">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
