@extends('layouts.app')

@section('title', 'Edit Buku')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h1 class="h4 mb-0">Edit Buku</h1>
        <a class="btn btn-outline-secondary btn-sm" href="{{ route('buku.index') }}">Kembali</a>
    </div>
    <div class="card-body">
        <form action="{{ route('buku.update', $buku) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label" for="kode_buku">Kode Buku</label>
                    <input class="form-control" id="kode_buku" value="{{ $buku->kode_buku }}" disabled>
                </div>
                <div class="col-md-5">
                    <label class="form-label" for="judul_buku">Judul Buku</label>
                    <input class="form-control" id="judul_buku" name="judul_buku" value="{{ old('judul_buku', $buku->judul_buku) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="penulis">Penulis</label>
                    <input class="form-control" id="penulis" name="penulis" value="{{ old('penulis', $buku->penulis) }}" required>
                </div>
                <div class="col-md-1">
                    <label class="form-label" for="stok">Stok</label>
                    <input class="form-control" type="number" min="0" id="stok" name="stok" value="{{ old('stok', $buku->stok) }}" required>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a class="btn btn-outline-secondary" href="{{ route('buku.index') }}">Batal</a>
                <button class="btn btn-primary" type="submit">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
