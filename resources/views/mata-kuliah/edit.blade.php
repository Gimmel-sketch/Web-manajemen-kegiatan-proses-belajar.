@extends('layouts.app')

@section('title', 'Edit Mata Kuliah')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h1 class="h4 mb-0">Edit Mata Kuliah</h1>
        <a class="btn btn-outline-secondary btn-sm" href="{{ route('mata-kuliah.index') }}">Kembali</a>
    </div>
    <div class="card-body">
        <form action="{{ route('mata-kuliah.update', $mataKuliah) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label" for="kode_mk">Kode MK</label>
                    <input class="form-control" id="kode_mk" value="{{ $mataKuliah->kode_mk }}" disabled>
                </div>
                <div class="col-md-5">
                    <label class="form-label" for="nama_mk">Nama Mata Kuliah</label>
                    <input class="form-control" id="nama_mk" name="nama_mk" value="{{ old('nama_mk', $mataKuliah->nama_mk) }}" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="sks">SKS</label>
                    <input class="form-control" type="number" min="1" id="sks" name="sks" value="{{ old('sks', $mataKuliah->sks) }}" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="semester">Semester</label>
                    <input class="form-control" type="number" min="1" id="semester" name="semester" value="{{ old('semester', $mataKuliah->semester) }}" required>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a class="btn btn-outline-secondary" href="{{ route('mata-kuliah.index') }}">Batal</a>
                <button class="btn btn-primary" type="submit">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
