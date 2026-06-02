@extends('layouts.app')

@section('title', 'Tambah KRS')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h1 class="h4 mb-0">Tambah KRS</h1>
        <a class="btn btn-outline-secondary btn-sm" href="{{ route('transaksi-krs.index') }}">Kembali</a>
    </div>
    <div class="card-body">
        <form action="{{ route('transaksi-krs.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" for="nim">Mahasiswa</label>
                    <select class="form-select" id="nim" name="nim" required>
                        <option value="">Pilih mahasiswa</option>
                        @foreach($mahasiswa as $item)
                            <option value="{{ $item->nim }}" @selected(old('nim') == $item->nim)>{{ $item->nama }} - {{ $item->nim }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="kode_mk">Mata Kuliah</label>
                    <select class="form-select" id="kode_mk" name="kode_mk" required>
                        <option value="">Pilih mata kuliah</option>
                        @foreach($mataKuliah as $item)
                            <option value="{{ $item->kode_mk }}" @selected(old('kode_mk') == $item->kode_mk)>{{ $item->nama_mk }} - {{ $item->kode_mk }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="semester_tempuh">Semester</label>
                    <input class="form-control" type="number" min="1" id="semester_tempuh" name="semester_tempuh" value="{{ old('semester_tempuh', 1) }}" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="tahun_akademik">Tahun Akademik</label>
                    <input class="form-control" id="tahun_akademik" name="tahun_akademik" value="{{ old('tahun_akademik') }}" placeholder="2025/2026" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="nilai_akhir">Nilai Akhir</label>
                    <input class="form-control" id="nilai_akhir" name="nilai_akhir" value="{{ old('nilai_akhir') }}">
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a class="btn btn-outline-secondary" href="{{ route('transaksi-krs.index') }}">Batal</a>
                <button class="btn btn-primary" type="submit">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
