@extends('layouts.app')

@section('title', 'Edit Peminjaman Buku')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h1 class="h4 mb-0">Edit Peminjaman Buku</h1>
        <a class="btn btn-outline-secondary btn-sm" href="{{ route('peminjaman-buku.index') }}">Kembali</a>
    </div>
    <div class="card-body">
        <form action="{{ route('peminjaman-buku.update', $peminjamanBuku) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" for="nim">Mahasiswa</label>
                    <select class="form-select" id="nim" name="nim" required>
                        @foreach($mahasiswa as $item)
                            <option value="{{ $item->nim }}" @selected(old('nim', $peminjamanBuku->nim) == $item->nim)>{{ $item->nama }} - {{ $item->nim }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="kode_buku">Buku</label>
                    <select class="form-select" id="kode_buku" name="kode_buku" required>
                        @foreach($buku as $item)
                            <option value="{{ $item->kode_buku }}" @selected(old('kode_buku', $peminjamanBuku->kode_buku) == $item->kode_buku)>{{ $item->judul_buku }} - {{ $item->kode_buku }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="tanggal_pinjam">Tanggal Pinjam</label>
                    <input class="form-control" type="date" id="tanggal_pinjam" name="tanggal_pinjam" value="{{ old('tanggal_pinjam', $peminjamanBuku->tanggal_pinjam?->format('Y-m-d')) }}" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="tanggal_tenggat">Tanggal Tenggat</label>
                    <input class="form-control" type="date" id="tanggal_tenggat" name="tanggal_tenggat" value="{{ old('tanggal_tenggat', $peminjamanBuku->tanggal_tenggat?->format('Y-m-d')) }}" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="tanggal_kembali">Tanggal Kembali</label>
                    <input class="form-control" type="date" id="tanggal_kembali" name="tanggal_kembali" value="{{ old('tanggal_kembali', $peminjamanBuku->tanggal_kembali?->format('Y-m-d')) }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="status_pinjam">Status</label>
                    <select class="form-select" id="status_pinjam" name="status_pinjam" required>
                        @foreach($statusPinjam as $status)
                            <option value="{{ $status }}" @selected(old('status_pinjam', $peminjamanBuku->status_pinjam) == $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="denda">Denda</label>
                    <input class="form-control" type="number" min="0" id="denda" name="denda" value="{{ old('denda', $peminjamanBuku->denda ?? 0) }}">
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a class="btn btn-outline-secondary" href="{{ route('peminjaman-buku.index') }}">Batal</a>
                <button class="btn btn-primary" type="submit">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
