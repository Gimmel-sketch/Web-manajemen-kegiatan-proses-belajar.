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
                    <th>#</th>
                    <th>Mata Kuliah</th>
                    <th>Dosen</th>
                    <th>Ruangan</th>
                    <th>Kelas</th>
                    <th>Hari/Jam</th>
                    <th>Semester</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jadwalPerkuliahan as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->mataKuliah?->nama_mk }}<br><small class="text-muted">{{ $item->kode_mk }}</small></td>
                        <td>{{ $item->dosen?->nama }}<br><small class="text-muted">{{ $item->nidn }}</small></td>
                        <td>{{ $item->ruangan?->nama_ruangan }}</td>
                        <td>{{ $item->kelas }}</td>
                        <td>{{ $item->hari }}<br><small class="text-muted">{{ substr($item->jam_mulai, 0, 5) }} - {{ substr($item->jam_selesai, 0, 5) }}</small></td>
                        <td>{{ $item->semester }}<br><small class="text-muted">{{ $item->tahun_akademik }}</small></td>
                        <td><span class="badge text-bg-{{ $item->status === 'Aktif' ? 'success' : 'secondary' }}">{{ $item->status }}</span></td>
                        <td>
                            <a class="btn btn-warning btn-sm" href="{{ route('jadwal-perkuliahan.edit', $item) }}">Edit</a>
                            <form class="d-inline" action="{{ route('jadwal-perkuliahan.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="text-center text-muted py-4">Belum ada jadwal perkuliahan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
