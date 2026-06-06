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
                    <label class="form-label" for="kontak">Kontak</label>
                    <input class="form-control" id="kontak" name="kontak" type="tel" value="{{ old('kontak') }}" placeholder="+62...">
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="status">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="aktif" @selected(old('status') === 'aktif')>Aktif</option>
                        <option value="non-aktif" @selected(old('status') === 'non-aktif')>Non-Aktif</option>
                    </select>
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
