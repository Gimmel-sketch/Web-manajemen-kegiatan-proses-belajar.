@extends('layouts.app')

@section('title', 'Pembayaran UKT')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Pembayaran UKT</h1>
    <a class="btn btn-primary" href="{{ route('pembayaran-ukt.create') }}">Tambah Pembayaran</a>
</div>

<div class="card shadow-sm">
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Mahasiswa</th>
                    <th>Tanggal Bayar</th>
                    <th>Jumlah</th>
                    <th>Semester</th>
                    <th>Metode</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pembayaranUkt as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->mahasiswa?->nama }}<br><small class="text-muted">{{ $item->nim }}</small></td>
                        <td>{{ $item->tanggal_bayar?->format('d/m/Y H:i') }}</td>
                        <td>Rp {{ number_format($item->jumlah_bayar, 0, ',', '.') }}</td>
                        <td>{{ $item->semester_dibayar }}</td>
                        <td>{{ $item->metode_pembayaran }}</td>
                        <td><span class="badge text-bg-{{ $item->status_pembayaran === 'Lunas' ? 'success' : 'warning' }}">{{ $item->status_pembayaran }}</span></td>
                        <td>
                            <a class="btn btn-warning btn-sm" href="{{ route('pembayaran-ukt.edit', $item) }}">Edit</a>
                            <form class="d-inline" action="{{ route('pembayaran-ukt.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">Belum ada data pembayaran UKT.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
