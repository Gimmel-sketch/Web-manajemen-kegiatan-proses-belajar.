@extends('layouts.app')

@section('title', 'Detail Fuzzy - Nilai Perkuliahan')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h1 class="h4 mb-0">Detail Fuzzy Logic</h1>
        <a class="btn btn-outline-secondary btn-sm" href="{{ route('nilai-perkuliahan.index') }}">Kembali</a>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th>Mahasiswa</th>
                        <td>{{ $nilaiPerkuliahan->transaksiKrs?->mahasiswa?->nama }} ({{ $nilaiPerkuliahan->transaksiKrs?->nim }})</td>
                    </tr>
                    <tr>
                        <th>Mata Kuliah</th>
                        <td>{{ $nilaiPerkuliahan->transaksiKrs?->mataKuliah?->nama_mk }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th>Tugas</th>
                        <td>{{ $nilaiPerkuliahan->nilai_tugas ?? 0 }}</td>
                    </tr>
                    <tr>
                        <th>UTS</th>
                        <td>{{ $nilaiPerkuliahan->nilai_uts ?? 0 }}</td>
                    </tr>
                    <tr>
                        <th>UAS</th>
                        <td>{{ $nilaiPerkuliahan->nilai_uas ?? 0 }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-info">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Hasil Fuzzy</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-4">
                                <div class="display-6 fw-bold text-primary">{{ $fuzzyResult['nilai_akhir'] }}</div>
                                <div class="text-muted">Nilai Akhir</div>
                            </div>
                            <div class="col-md-4">
                                <div class="display-6 fw-bold text-success">{{ $fuzzyResult['nilai_huruf'] }}</div>
                                <div class="text-muted">Nilai Huruf</div>
                            </div>
                            <div class="col-md-4">
                                <div class="display-6 fw-bold text-info">{{ $fuzzyResult['fuzzy_detail']['input']['tugas'] }} / {{ $fuzzyResult['fuzzy_detail']['input']['uts'] }} / {{ $fuzzyResult['fuzzy_detail']['input']['uas'] }}</div>
                                <div class="text-muted">Input (Tugas/UTS/UAS)</div>
                            </div>
                        </div>
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
                            $inputLabels = ['tugas' => 'Tugas', 'uts' => 'UTS', 'uas' => 'UAS'];
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
                        @php
                            $outputLabels = ['Rendah' => 'Rendah', 'Sedang' => 'Sedang', 'Tinggi' => 'Tinggi'];
                        @endphp
                        @foreach($fuzzyResult['fuzzy_detail']['aggregated']['nilai_akhir'] ?? [] as $label => $strength)
                            <h6>{{ $outputLabels[$label] ?? $label }}</h6>
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

        <a class="btn btn-outline-secondary" href="{{ route('nilai-perkuliahan.index') }}">Kembali</a>
    </div>
</div>
@endsection
