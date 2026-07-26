@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
@php
    $user = auth()->user();
    $roleName = $user->role?->display_name ?? 'Belum ada role';

    $iconColors = ['primary', 'success', 'warning', 'danger', 'info', 'secondary', 'dark'];

    $cards = [
        ['label' => 'Mahasiswa', 'value' => $totalMahasiswa, 'route' => route('Data-mahasiswa'), 'button' => 'Lihat data', 'permission' => 'mahasiswa.view', 'icon' => '👥', 'color' => 'primary'],
        ['label' => 'Mata Kuliah', 'value' => $totalMataKuliah, 'route' => route('mata-kuliah.index'), 'button' => 'Kelola', 'permission' => 'mata_kuliah.view', 'icon' => '📚', 'color' => 'success'],
        ['label' => 'Dosen', 'value' => $totalDosen, 'route' => route('dosen.index'), 'button' => 'Kelola', 'permission' => 'dosen.view', 'icon' => '👨‍🏫', 'color' => 'warning'],
        ['label' => 'Ruangan', 'value' => $totalRuangan, 'route' => route('ruangan.index'), 'button' => 'Kelola', 'permission' => 'ruangan.view', 'icon' => '🏛️', 'color' => 'danger'],
        ['label' => 'Buku', 'value' => $totalBuku, 'route' => route('buku.index'), 'button' => 'Kelola', 'permission' => 'buku.view', 'icon' => '📖', 'color' => 'info'],
        ['label' => 'Transaksi KRS', 'value' => $totalKrs, 'route' => route('transaksi-krs.index'), 'button' => 'Lihat transaksi', 'permission' => 'krs.view', 'icon' => '📋', 'color' => 'secondary'],
        ['label' => 'Jadwal Perkuliahan', 'value' => $totalJadwalPerkuliahan, 'route' => route('jadwal-perkuliahan.index'), 'button' => 'Kelola', 'permission' => 'jadwal_perkuliahan.view', 'icon' => '📅', 'color' => 'primary'],
        ['label' => 'Presensi', 'value' => $totalPresensiPerkuliahan, 'route' => route('presensi-perkuliahan.index'), 'button' => 'Kelola', 'permission' => 'presensi_perkuliahan.view', 'icon' => '✅', 'color' => 'success'],
        ['label' => 'Nilai', 'value' => $totalNilaiPerkuliahan, 'route' => route('nilai-perkuliahan.index'), 'button' => 'Kelola', 'permission' => 'nilai_perkuliahan.view', 'icon' => '🎯', 'color' => 'warning'],
        ['label' => 'Pembayaran UKT', 'value' => $totalPembayaranUkt, 'route' => route('pembayaran-ukt.index'), 'button' => 'Lihat transaksi', 'permission' => 'pembayaran_ukt.view', 'icon' => '💰', 'color' => 'danger'],
        ['label' => 'Peminjaman Buku', 'value' => $totalPeminjamanBuku, 'route' => route('peminjaman-buku.index'), 'button' => 'Lihat transaksi', 'permission' => 'peminjaman_buku.view', 'icon' => '📕', 'color' => 'info'],
    ];

    $cards = array_values(array_filter($cards, fn ($card) => $user->hasPermission($card['permission'])));

    if ($user->hasRole(['admin', 'editor']) && $user->hasPermission('roles.view')) {
        $cards[] = ['label' => 'Roles', 'value' => $totalRoles, 'route' => route('roles.index'), 'button' => 'Atur akses', 'permission' => 'roles.view', 'icon' => '🔐', 'color' => 'dark'];
    }
@endphp

<div class="row align-items-stretch g-4 mb-4">
    <div class="col-lg-8">
        <div class="card welcome-card border-0 shadow-sm h-100">
            <div class="card-body p-4 text-white">
                <span class="badge bg-white text-primary mb-3 fw-semibold">
                    <span class="me-1">📊</span> Dashboard
                </span>
                <h1 class="h3 mb-2 fw-bold">Selamat datang, {{ $user->name }}</h1>
                <p class="text-white-90 mb-0" style="color: rgba(255,255,255,.75)">
                    Anda login sebagai <strong class="text-white">{{ $roleName }}</strong>. Gunakan halaman ini sebagai pintu awal untuk mengakses data akademik, transaksi, dan pengaturan hak akses.
                </p>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card profile-card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white fw-bold" style="width: 48px; height: 48px; font-size: 1.1rem;">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div>
                        <h2 class="h6 mb-0 fw-bold">{{ $user->name }}</h2>
                        <span class="small text-muted">{{ $user->email }}</span>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                    <div>
                        <span class="text-muted small d-block">Role</span>
                        <span class="badge bg-primary bg-opacity-10 text-primary fw-semibold">{{ $roleName }}</span>
                    </div>
                    <span class="badge bg-success bg-opacity-10 text-success small">Aktif</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    @foreach($cards as $card)
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card shadow-sm h-100 border-0">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="text-muted small fw-semibold text-uppercase tracking-wide">{{ $card['label'] }}</span>
                        <div class="stat-icon bg-{{ $card['color'] }} bg-opacity-10 text-{{ $card['color'] }} d-inline-flex align-items-center justify-content-center rounded-3" style="width: 44px; height: 44px; font-size: 1.25rem;">
                            {{ $card['icon'] }}
                        </div>
                    </div>
                    <div class="display-6 fw-bold mb-3 mt-auto" style="line-height: 1; letter-spacing: -.02em;">{{ $card['value'] }}</div>
                    <a class="btn btn-primary btn-sm w-100 fw-semibold" href="{{ $card['route'] }}">
                        {{ $card['button'] }}
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
