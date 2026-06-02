@extends('layouts.app')

@section('title', 'Edit Presensi Perkuliahan')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h1 class="h4 mb-0">Edit Presensi Perkuliahan</h1>
        <a class="btn btn-outline-secondary btn-sm" href="{{ route('presensi-perkuliahan.index') }}">Kembali</a>
    </div>
    <div class="card-body">
        <form action="{{ route('presensi-perkuliahan.update', $presensiPerkuliahan) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label" for="jadwal_perkuliahan_id">Jadwal</label>
                    <select class="form-select" id="jadwal_perkuliahan_id" name="jadwal_perkuliahan_id" required>
                        @foreach($jadwalPerkuliahan as $item)
                            <option value="{{ $item->id }}" @selected(old('jadwal_perkuliahan_id', $presensiPerkuliahan->jadwal_perkuliahan_id) == $item->id)>{{ $item->mataKuliah?->nama_mk }} - {{ $item->kelas }} - {{ $item->hari }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="nim">Mahasiswa</label>
                    <select class="form-select" id="nim" name="nim" required>
                        @foreach($mahasiswa as $item)
                            <option value="{{ $item->nim }}" @selected(old('nim', $presensiPerkuliahan->nim) == $item->nim)>{{ $item->nama }} - {{ $item->nim }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="tanggal">Tanggal</label>
                    <input class="form-control" type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', $presensiPerkuliahan->tanggal) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="pertemuan_ke">Pertemuan Ke</label>
                    <input class="form-control" type="number" min="1" id="pertemuan_ke" name="pertemuan_ke" value="{{ old('pertemuan_ke', $presensiPerkuliahan->pertemuan_ke) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="status">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        @foreach($statusList as $status)
                            <option value="{{ $status }}" @selected(old('status', $presensiPerkuliahan->status) == $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="keterangan">Keterangan</label>
                    <input class="form-control" id="keterangan" name="keterangan" value="{{ old('keterangan', $presensiPerkuliahan->keterangan) }}">
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a class="btn btn-outline-secondary" href="{{ route('presensi-perkuliahan.index') }}">Batal</a>
                <button class="btn btn-primary" type="submit">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
