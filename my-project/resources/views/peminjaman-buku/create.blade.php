@extends('layouts.app')

@section('title', 'Tambah Peminjaman Buku')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h1 class="h4 mb-0">Tambah Peminjaman Buku</h1>
        <a class="btn btn-outline-secondary btn-sm" href="{{ route('peminjaman-buku.index') }}">Kembali</a>
    </div>
    <div class="card-body">
        <form action="{{ route('peminjaman-buku.store') }}" method="POST">
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
                    <label class="form-label" for="kode_buku">Buku</label>
                    <select class="form-select" id="kode_buku" name="kode_buku" required>
                        <option value="">Pilih buku</option>
                        @foreach($buku as $item)
                            <option value="{{ $item->kode_buku }}" @selected(old('kode_buku') == $item->kode_buku)>{{ $item->judul_buku }} - {{ $item->kode_buku }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="tanggal_pinjam">Tanggal Pinjam</label>
                    <input class="form-control" type="date" id="tanggal_pinjam" name="tanggal_pinjam" value="{{ old('tanggal_pinjam') }}" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="tanggal_tenggat">Tanggal Tenggat</label>
                    <input class="form-control" type="date" id="tanggal_tenggat" name="tanggal_tenggat" value="{{ old('tanggal_tenggat') }}" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="tanggal_kembali">Tanggal Kembali</label>
                    <input class="form-control" type="date" id="tanggal_kembali" name="tanggal_kembali" value="{{ old('tanggal_kembali') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="status_pinjam">Status</label>
                    <select class="form-select" id="status_pinjam" name="status_pinjam" required>
                        @foreach($statusPinjam as $status)
                            <option value="{{ $status }}" @selected(old('status_pinjam', 'Dipinjam') == $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="denda">Denda</label>
                    <input class="form-control" type="number" min="0" id="denda" name="denda" value="{{ old('denda', 0) }}">
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a class="btn btn-outline-secondary" href="{{ route('peminjaman-buku.index') }}">Batal</a>
                <button class="btn btn-primary" type="submit">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
