@extends('layouts.app')

@section('title', 'Detail KRS - ' . $mahasiswa->nama)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Detail KRS</h1>
    <a class="btn btn-outline-secondary" href="{{ route('transaksi-krs.index') }}">Kembali</a>
</div>

<div class="card shadow-sm mb-3">
    <div class="card-body">
        <div class="row">
            <div class="col-md-3"><strong>Nama</strong></div>
            <div class="col-md-3">{{ $mahasiswa->nama }}</div>
            <div class="col-md-3"><strong>NIM</strong></div>
            <div class="col-md-3">{{ $mahasiswa->nim }}</div>
        </div>
        <div class="row mt-2">
            <div class="col-md-3"><strong>Fakultas</strong></div>
            <div class="col-md-3">{{ $mahasiswa->fakultas }}</div>
            <div class="col-md-3"><strong>Prodi</strong></div>
            <div class="col-md-3">{{ $mahasiswa->prodi }}</div>
        </div>
        <div class="row mt-2">
            <div class="col-md-3"><strong>Semester</strong></div>
            <div class="col-md-3">{{ $mahasiswa->semester }}</div>
            <div class="col-md-3"><strong>Angkatan</strong></div>
            <div class="col-md-3">{{ $mahasiswa->angkatan }}</div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <span><strong>Mata Kuliah yang Diambil</strong></span>
        <span class="text-muted">{{ $transaksiKrs->count() }} MK ({{ $transaksiKrs->sum(fn($i) => $i->mataKuliah?->sks ?? 0) }} SKS)</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 1%;">No</th>
                        <th>Kode MK</th>
                        <th>Mata Kuliah</th>
                        <th>SKS</th>
                        <th>Semester Tempuh</th>
                        <th>Tahun Akademik</th>
                        <th>Status</th>
                        <th>Fuzzy</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksiKrs as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->mataKuliah?->kode_mk }}</td>
                            <td>{{ $item->mataKuliah?->nama_mk }}</td>
                            <td>{{ $item->mataKuliah?->sks ?? '-' }}</td>
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
                                @if(isset($item->fuzzy_kelayakan))
                                    @php $f = $item->fuzzy_kelayakan; @endphp
                                    <span class="badge {{ $f['label'] === 'SangatLayak' ? 'text-bg-success' : ($f['label'] === 'Layak' ? 'text-bg-primary' : ($f['label'] === 'KurangLayak' ? 'text-bg-warning' : 'text-bg-danger')) }}">
                                        {{ str_replace(['TidakLayak', 'KurangLayak', 'SangatLayak'], ['Tidak Layak', 'Kurang Layak', 'Sangat Layak'], $f['label']) }}
                                    </span>
                                    <small class="d-block text-muted">Skor: {{ $f['skor'] }}</small>
                                @else
                                    <span class="text-muted">-</span>
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
                        <tr><td colspan="9" class="text-center text-muted py-4">Belum ada data KRS untuk mahasiswa ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
