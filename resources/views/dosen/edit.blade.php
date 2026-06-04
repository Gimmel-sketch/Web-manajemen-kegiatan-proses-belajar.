@extends('layouts.app')

@section('title', 'Edit Dosen')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h1 class="h4 mb-0">Edit Dosen</h1>
        <a class="btn btn-outline-secondary btn-sm" href="{{ route('dosen.index') }}">Kembali</a>
    </div>
    <div class="card-body">
        <form action="{{ route('dosen.update', $dosen) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label" for="nidn">NIDN</label>
                    <input class="form-control" id="nidn" name="nidn" value="{{ old('nidn', $dosen->nidn) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="nama">Nama</label>
                    <input class="form-control" id="nama" name="nama" value="{{ old('nama', $dosen->nama) }}" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="gelar">Gelar</label>
                    <input class="form-control" id="gelar" name="gelar" value="{{ old('gelar', $dosen->gelar) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="spesialisasi">Spesialisasi</label>
                    <input class="form-control" id="spesialisasi" name="spesialisasi" value="{{ old('spesialisasi', $dosen->spesialisasi) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="kode_mk">Mata Kuliah yang Diajar</label>
                    <select class="form-select" id="kode_mk" name="kode_mk" required>
                        <option value="">Pilih mata kuliah</option>
                        @foreach($mataKuliah as $item)
                            <option value="{{ $item->kode_mk }}" @selected(old('kode_mk', $dosen->kode_mk) == $item->kode_mk)>
                                {{ $item->nama_mk }} - {{ $item->kode_mk }}
                            </option>
                        @endforeach
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
