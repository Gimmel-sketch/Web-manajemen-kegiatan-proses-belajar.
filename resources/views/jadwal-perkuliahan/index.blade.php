@extends('layouts.app')

@section('title', 'Jadwal Perkuliahan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Jadwal Perkuliahan</h1>
    <a class="btn btn-primary" href="{{ route('jadwal-perkuliahan.create') }}">Tambah Jadwal</a>
</div>

<div class="card shadow-sm">
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Mata Kuliah</th>
                    <th>Kelas</th>
                    <th>Jadwal</th>
                    <th>Pengajar</th>
                    <th>Ketidakhadiran</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jadwalPerkuliahan as $item)
                    <tr>
                        <td>
                            <strong class="text-primary">{{ $item->mataKuliah?->nama_mk }}</strong>
                        </td>
                        <td>{{ $item->kelas }}</td>
                        <td>
                            {{ $item->hari }}, {{ substr($item->jam_mulai, 0, 5) }} - {{ substr($item->jam_selesai, 0, 5) }}<br>
                            <small class="text-muted">{{ $item->ruangan?->nama_ruangan ?? 'Ruangan tidak tersedia' }}</small>
                        </td>
                        <td>{{ $item->dosen?->nama }}</td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark">{{ $item->presensiPerkuliahan->filter(fn($p) => $p->status !== 'Hadir')->count() }}</span>
                        </td>
                        <td>
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('jadwal-perkuliahan.edit', $item) }}" title="Edit"><i class="bi bi-pencil"></i></a>
                            <form class="d-inline" action="{{ route('jadwal-perkuliahan.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" type="submit" title="Hapus"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Belum ada jadwal perkuliahan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

