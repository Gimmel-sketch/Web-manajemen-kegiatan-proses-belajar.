@extends('layouts.app')

@section('title', 'Tambah Jadwal Perkuliahan')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h1 class="h4 mb-0">Tambah Jadwal Perkuliahan</h1>
        <a class="btn btn-outline-secondary btn-sm" href="{{ route('jadwal-perkuliahan.index') }}">Kembali</a>
    </div>
    <div class="card-body">
        <form action="{{ route('jadwal-perkuliahan.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" for="kode_mk">Mata Kuliah</label>
                    <select class="form-select" id="kode_mk" name="kode_mk" required>
                        <option value="">Pilih mata kuliah</option>
                        @foreach($mataKuliah as $item)
                            <option value="{{ $item->kode_mk }}" @selected(old('kode_mk') == $item->kode_mk)>{{ $item->nama_mk }} - {{ $item->kode_mk }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="nidn">Dosen</label>
                    <select class="form-select" id="nidn" name="nidn" required>
                        <option value="">Pilih dosen</option>
                        @foreach($dosen as $item)
                            <option value="{{ $item->nidn }}" @selected(old('nidn') == $item->nidn)>{{ $item->nama }} - {{ $item->nidn }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="ruangan_id">Ruangan</label>
                    <select class="form-select" id="ruangan_id" name="ruangan_id" required>
                        <option value="">Pilih ruangan</option>
                        @foreach($ruangan as $item)
                            <option value="{{ $item->id }}" @selected(old('ruangan_id') == $item->id)>{{ $item->nama_ruangan }} - {{ $item->kapasitas }} kursi</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="kelas">Kelas</label>
                    <input class="form-control" id="kelas" name="kelas" value="{{ old('kelas') }}" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="hari">Hari</label>
                    <select class="form-select" id="hari" name="hari" required>
                        @foreach($hariList as $hari)
                            <option value="{{ $hari }}" @selected(old('hari') == $hari)>{{ $hari }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="jam_mulai">Jam Mulai</label>
                    <input class="form-control" type="time" id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai') }}" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="jam_selesai">Jam Selesai</label>
                    <input class="form-control" type="time" id="jam_selesai" name="jam_selesai" value="{{ old('jam_selesai') }}" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="semester">Semester</label>
                    <input class="form-control" type="number" min="1" id="semester" name="semester" value="{{ old('semester', 1) }}" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="tahun_akademik">Tahun Akademik</label>
                    <input class="form-control" id="tahun_akademik" name="tahun_akademik" value="{{ old('tahun_akademik') }}" placeholder="2025/2026" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="status">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        @foreach($statusList as $status)
                            <option value="{{ $status }}" @selected(old('status', 'Aktif') == $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a class="btn btn-outline-secondary" href="{{ route('jadwal-perkuliahan.index') }}">Batal</a>
                <button class="btn btn-primary" type="submit">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
