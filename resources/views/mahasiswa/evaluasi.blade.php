@extends('layouts.app')

@section('title', 'Evaluasi Fuzzy - ' . $mahasiswa->nama)

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h1 class="h4 mb-0">Evaluasi Fuzzy Mahasiswa</h1>
        <a class="btn btn-outline-secondary btn-sm" href="{{ route('Data-mahasiswa') }}">Kembali</a>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr><th>NIM</th><td>{{ $mahasiswa->nim }}</td></tr>
                    <tr><th>Nama</th><td>{{ $mahasiswa->nama }}</td></tr>
                    <tr><th>Prodi</th><td>{{ $mahasiswa->prodi }}</td></tr>
                    <tr><th>Fakultas</th><td>{{ $mahasiswa->fakultas }}</td></tr>
                    <tr><th>Semester</th><td>{{ $mahasiswa->semester }}</td></tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr><th>Rata-rata Nilai</th><td>{{ $rataNilai }}</td></tr>
                    <tr><th>IPK</th><td>{{ $ipk }}</td></tr>
                    <tr><th>Total SKS Lulus</th><td>{{ $sksLulus }}</td></tr>
                </table>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-primary">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Hasil Fuzzy - Performa Akademik</h5>
                    </div>
                    <div class="card-body text-center py-4">
                        <div class="display-1 fw-bold {{ $fuzzyResult['label'] === 'Sangat Baik' ? 'text-success' : ($fuzzyResult['label'] === 'Baik' ? 'text-primary' : ($fuzzyResult['label'] === 'Cukup' ? 'text-warning' : 'text-danger')) }}">
                            {{ $fuzzyResult['skor'] }}
                        </div>
                        <div class="display-6 mb-3">Skor Performa</div>
                        <span class="badge fs-5 {{ $fuzzyResult['label'] === 'Sangat Baik' ? 'text-bg-success' : ($fuzzyResult['label'] === 'Baik' ? 'text-bg-primary' : ($fuzzyResult['label'] === 'Cukup' ? 'text-bg-warning' : 'text-bg-danger')) }} px-3 py-2">
                            {{ $fuzzyResult['label'] }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Membership Function - Input</div>
                    <div class="card-body">
                        @php
                            $inputLabels = ['rata_nilai' => 'Rata-rata Nilai', 'ipk' => 'IPK', 'sks_lulus' => 'SKS Lulus'];
                        @endphp
                        @foreach($fuzzyResult['fuzzy_detail']['membership'] as $var => $membership)
                            <h6>{{ $inputLabels[$var] ?? $var }}</h6>
                            <table class="table table-sm table-bordered mb-3">
                                @foreach($membership as $label => $degree)
                                    <tr>
                                        <td>{{ $label }}</td>
                                        <td>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar {{ $degree > 0.5 ? 'bg-success' : ($degree > 0.2 ? 'bg-warning' : 'bg-secondary') }}" style="width: {{ $degree * 100 }}%">
                                                    {{ number_format($degree, 4) }}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Aggregated Output - Rules Fired</div>
                    <div class="card-body">
                        @foreach($fuzzyResult['fuzzy_detail']['aggregated']['performa'] ?? [] as $label => $strength)
                            <h6>{{ $label }}</h6>
                            <div class="progress mb-3" style="height: 20px;">
                                <div class="progress-bar {{ $strength > 0.5 ? 'bg-success' : ($strength > 0.2 ? 'bg-warning' : 'bg-secondary') }}" style="width: {{ $strength * 100 }}%">
                                    {{ number_format($strength, 4) }}
                                </div>
                            </div>
                        @endforeach
                        <hr>
                        <p class="text-muted small mb-0">
                            Metode: Mamdani (Min-Max)<br>
                            Defuzzifikasi: Centroid
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Daftar Nilai Perkuliahan</div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Mata Kuliah</th>
                            <th>Tugas</th>
                            <th>UTS</th>
                            <th>UAS</th>
                            <th>Nilai Akhir</th>
                            <th>Nilai Huruf</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($nilaiDetail as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->transaksiKrs?->mataKuliah?->nama_mk }}</td>
                                <td>{{ $item->nilai_tugas ?? '-' }}</td>
                                <td>{{ $item->nilai_uts ?? '-' }}</td>
                                <td>{{ $item->nilai_uas ?? '-' }}</td>
                                <td>{{ $item->nilai_akhir ?? '-' }}</td>
                                <td>{{ $item->nilai_huruf ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-muted py-4">Belum ada nilai.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
