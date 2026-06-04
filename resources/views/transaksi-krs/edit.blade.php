@extends('layouts.app')

@section('title', 'Edit KRS')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h1 class="h4 mb-0">Edit KRS</h1>
        <a class="btn btn-outline-secondary btn-sm" href="{{ route('transaksi-krs.index') }}">Kembali</a>
    </div>
    <div class="card-body">
        <form action="{{ route('transaksi-krs.update', $transaksiKrs) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" for="nim">Mahasiswa</label>
                    <select class="form-select" id="nim" name="nim" required>
                        @foreach($mahasiswa as $item)
                            <option value="{{ $item->nim }}" @selected(old('nim', $transaksiKrs->nim) == $item->nim)>{{ $item->nama }} - {{ $item->nim }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="kode_mk">Mata Kuliah</label>
                    <select class="form-select" id="kode_mk" name="kode_mk" required>
                        @foreach($mataKuliah as $item)
                            <option value="{{ $item->kode_mk }}" @selected(old('kode_mk', $transaksiKrs->kode_mk) == $item->kode_mk)>{{ $item->nama_mk }} - {{ $item->kode_mk }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="semester_tempuh">Semester</label>
                    <input class="form-control" type="number" min="1" id="semester_tempuh" name="semester_tempuh" value="{{ old('semester_tempuh', $transaksiKrs->semester_tempuh) }}" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="tahun_akademik">Tahun Akademik</label>
                    <input class="form-control" id="tahun_akademik" name="tahun_akademik" value="{{ old('tahun_akademik', $transaksiKrs->tahun_akademik) }}" required>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a class="btn btn-outline-secondary" href="{{ route('transaksi-krs.index') }}">Batal</a>
                <button class="btn btn-primary" type="submit">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
