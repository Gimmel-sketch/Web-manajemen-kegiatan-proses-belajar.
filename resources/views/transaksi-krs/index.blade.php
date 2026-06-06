@extends('layouts.app')

@section('title', 'Data KRS')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Data KRS</h1>
    <a class="btn btn-primary" href="{{ route('transaksi-krs.create') }}">Tambah KRS</a>
</div>

<div class="card shadow-sm">
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Mahasiswa</th>
                    <th>Mata Kuliah</th>
                    <th>Dosen</th>
                    <th>Semester Tempuh</th>
                    <th>Tahun Akademik</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksiKrs as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->mahasiswa?->nama }}<br><small class="text-muted">{{ $item->nim }}</small></td>
                        <td>{{ $item->mataKuliah?->nama_mk }}<br><small class="text-muted">{{ $item->kode_mk }}</small></td>
                        <td>{{ $item->dosen?->nama ?? '-' }}<br><small class="text-muted">{{ $item->nidn }}</small></td>
                        <td>{{ $item->semester_tempuh }}</td>
                        <td>{{ $item->tahun_akademik }}</td>
                        <td>
                            @if($item->status_verifikasi === 'terverifikasi')
                                <span class="badge text-bg-success">Terverifikasi</span>
                                <div class="small text-muted mt-1">
                                    {{ $item->verified_at?->format('d/m/Y H:i') }}
                                    @if($item->verifier)
                                        <br>oleh {{ $item->verifier->name }}
                                    @endif
                                </div>
                            @else
                                <span class="badge text-bg-warning">Menunggu</span>
                            @endif
                        </td>
                        <td>
                            @if(auth()->user()->hasRole('admin'))
                                @if($item->status_verifikasi === 'terverifikasi')
                                    <form class="d-inline" action="{{ route('transaksi-krs.unverify', $item) }}" method="POST" onsubmit="return confirm('Batalkan verifikasi data KRS ini?')">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn btn-outline-secondary btn-sm" type="submit">Batalkan</button>
                                    </form>
                                @else
                                    <form class="d-inline" action="{{ route('transaksi-krs.verify', $item) }}" method="POST" onsubmit="return confirm('Verifikasi data KRS ini?')">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn btn-success btn-sm" type="submit">Verifikasi</button>
                                    </form>
                                @endif
                            @endif
                            <a class="btn btn-warning btn-sm" href="{{ route('transaksi-krs.edit', $item) }}">Edit</a>
                            <form class="d-inline" action="{{ route('transaksi-krs.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">Belum ada data KRS.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
