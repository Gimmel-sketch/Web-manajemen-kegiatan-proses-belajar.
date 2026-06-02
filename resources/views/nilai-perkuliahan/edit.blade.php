@extends('layouts.app')

@section('title', 'Edit Nilai Perkuliahan')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h1 class="h4 mb-0">Edit Nilai Perkuliahan</h1>
        <a class="btn btn-outline-secondary btn-sm" href="{{ route('nilai-perkuliahan.index') }}">Kembali</a>
    </div>
    <div class="card-body">
        <form action="{{ route('nilai-perkuliahan.update', $nilaiPerkuliahan) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label" for="transaksi_krs_id">KRS</label>
                    <select class="form-select" id="transaksi_krs_id" name="transaksi_krs_id" required>
                        @foreach($transaksiKrs as $item)
                            <option value="{{ $item->id }}" @selected(old('transaksi_krs_id', $nilaiPerkuliahan->transaksi_krs_id) == $item->id)>{{ $item->mahasiswa?->nama }} - {{ $item->mataKuliah?->nama_mk }} - {{ $item->tahun_akademik }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="nilai_tugas">Tugas</label>
                    <input class="form-control" type="number" min="0" max="100" step="0.01" id="nilai_tugas" name="nilai_tugas" value="{{ old('nilai_tugas', $nilaiPerkuliahan->nilai_tugas) }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="nilai_uts">UTS</label>
                    <input class="form-control" type="number" min="0" max="100" step="0.01" id="nilai_uts" name="nilai_uts" value="{{ old('nilai_uts', $nilaiPerkuliahan->nilai_uts) }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="nilai_uas">UAS</label>
                    <input class="form-control" type="number" min="0" max="100" step="0.01" id="nilai_uas" name="nilai_uas" value="{{ old('nilai_uas', $nilaiPerkuliahan->nilai_uas) }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="nilai_akhir">Akhir</label>
                    <input class="form-control" type="number" min="0" max="100" step="0.01" id="nilai_akhir" name="nilai_akhir" value="{{ old('nilai_akhir', $nilaiPerkuliahan->nilai_akhir) }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="nilai_huruf">Huruf</label>
                    <input class="form-control" id="nilai_huruf" name="nilai_huruf" value="{{ old('nilai_huruf', $nilaiPerkuliahan->nilai_huruf) }}">
                </div>
                <div class="col-md-8">
                    <label class="form-label" for="keterangan">Keterangan</label>
                    <input class="form-control" id="keterangan" name="keterangan" value="{{ old('keterangan', $nilaiPerkuliahan->keterangan) }}">
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a class="btn btn-outline-secondary" href="{{ route('nilai-perkuliahan.index') }}">Batal</a>
                <button class="btn btn-primary" type="submit">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
