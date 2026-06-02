@extends('layouts.app')

@section('title', 'Edit Pembayaran UKT')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h1 class="h4 mb-0">Edit Pembayaran UKT</h1>
        <a class="btn btn-outline-secondary btn-sm" href="{{ route('pembayaran-ukt.index') }}">Kembali</a>
    </div>
    <div class="card-body">
        <form action="{{ route('pembayaran-ukt.update', $pembayaranUkt) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" for="nim">Mahasiswa</label>
                    <select class="form-select" id="nim" name="nim" required>
                        @foreach($mahasiswa as $item)
                            <option value="{{ $item->nim }}" @selected(old('nim', $pembayaranUkt->nim) == $item->nim)>{{ $item->nama }} - {{ $item->nim }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="tanggal_bayar">Tanggal Bayar</label>
                    <input class="form-control" type="datetime-local" id="tanggal_bayar" name="tanggal_bayar" value="{{ old('tanggal_bayar', $pembayaranUkt->tanggal_bayar?->format('Y-m-d\TH:i')) }}" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="jumlah_bayar">Jumlah Bayar</label>
                    <input class="form-control" type="number" min="0" id="jumlah_bayar" name="jumlah_bayar" value="{{ old('jumlah_bayar', $pembayaranUkt->jumlah_bayar) }}" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="semester_dibayar">Semester</label>
                    <input class="form-control" type="number" min="1" id="semester_dibayar" name="semester_dibayar" value="{{ old('semester_dibayar', $pembayaranUkt->semester_dibayar) }}" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="metode_pembayaran">Metode</label>
                    <select class="form-select" id="metode_pembayaran" name="metode_pembayaran" required>
                        @foreach($metodePembayaran as $metode)
                            <option value="{{ $metode }}" @selected(old('metode_pembayaran', $pembayaranUkt->metode_pembayaran) == $metode)>{{ $metode }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="status_pembayaran">Status</label>
                    <select class="form-select" id="status_pembayaran" name="status_pembayaran" required>
                        @foreach($statusPembayaran as $status)
                            <option value="{{ $status }}" @selected(old('status_pembayaran', $pembayaranUkt->status_pembayaran) == $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a class="btn btn-outline-secondary" href="{{ route('pembayaran-ukt.index') }}">Batal</a>
                <button class="btn btn-primary" type="submit">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
