@extends('layouts.app')

@section('title', 'Tambah Pembayaran UKT')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h1 class="h4 mb-0">Tambah Pembayaran UKT</h1>
        <a class="btn btn-outline-secondary btn-sm" href="{{ route('pembayaran-ukt.index') }}">Kembali</a>
    </div>
    <div class="card-body">
        <form action="{{ route('pembayaran-ukt.store') }}" method="POST">
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
                <div class="col-md-2">
                    <label class="form-label" for="tanggal_bayar">Tanggal Bayar</label>
                    <input class="form-control" type="datetime-local" id="tanggal_bayar" name="tanggal_bayar" value="{{ old('tanggal_bayar') }}" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="jumlah_bayar">Jumlah Bayar</label>
                    <input class="form-control" type="number" min="0" id="jumlah_bayar" name="jumlah_bayar" value="{{ old('jumlah_bayar') }}" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="semester_dibayar">Semester</label>
                    <input class="form-control" type="number" min="1" id="semester_dibayar" name="semester_dibayar" value="{{ old('semester_dibayar', 1) }}" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="metode_pembayaran">Metode</label>
                    <select class="form-select" id="metode_pembayaran" name="metode_pembayaran" required>
                        @foreach($metodePembayaran as $metode)
                            <option value="{{ $metode }}" @selected(old('metode_pembayaran') == $metode)>{{ $metode }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="status_pembayaran">Status</label>
                    <select class="form-select" id="status_pembayaran" name="status_pembayaran" required>
                        @foreach($statusPembayaran as $status)
                            <option value="{{ $status }}" @selected(old('status_pembayaran', 'Pending') == $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a class="btn btn-outline-secondary" href="{{ route('pembayaran-ukt.index') }}">Batal</a>
                <button class="btn btn-primary" type="submit">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
