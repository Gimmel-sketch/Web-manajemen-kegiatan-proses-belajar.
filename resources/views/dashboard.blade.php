@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
@php
    $user = auth()->user();
    $roleName = $user->role?->display_name ?? 'Belum ada role';
    $cards = [
        ['label' => 'Mahasiswa', 'value' => $totalMahasiswa, 'route' => route('Data-mahasiswa'), 'button' => 'Lihat data', 'permission' => 'manage_mahasiswa'],
        ['label' => 'Mata Kuliah', 'value' => $totalMataKuliah, 'route' => route('mata-kuliah.index'), 'button' => 'Kelola', 'permission' => 'manage_mata_kuliah'],
        ['label' => 'Dosen', 'value' => $totalDosen, 'route' => route('dosen.index'), 'button' => 'Kelola', 'permission' => 'manage_dosen'],
        ['label' => 'Ruangan', 'value' => $totalRuangan, 'route' => route('ruangan.index'), 'button' => 'Kelola', 'permission' => 'manage_ruangan'],
        ['label' => 'Buku', 'value' => $totalBuku, 'route' => route('buku.index'), 'button' => 'Kelola', 'permission' => 'manage_buku'],
        ['label' => 'Transaksi KRS', 'value' => $totalKrs, 'route' => route('transaksi-krs.index'), 'button' => 'Lihat transaksi', 'permission' => 'manage_krs'],
        ['label' => 'Jadwal Perkuliahan', 'value' => $totalJadwalPerkuliahan, 'route' => route('jadwal-perkuliahan.index'), 'button' => 'Kelola', 'permission' => 'manage_jadwal_perkuliahan'],
        ['label' => 'Presensi', 'value' => $totalPresensiPerkuliahan, 'route' => route('presensi-perkuliahan.index'), 'button' => 'Kelola', 'permission' => 'manage_presensi_perkuliahan'],
        ['label' => 'Nilai', 'value' => $totalNilaiPerkuliahan, 'route' => route('nilai-perkuliahan.index'), 'button' => 'Kelola', 'permission' => 'manage_nilai_perkuliahan'],
        ['label' => 'Pembayaran UKT', 'value' => $totalPembayaranUkt, 'route' => route('pembayaran-ukt.index'), 'button' => 'Lihat transaksi', 'permission' => 'manage_pembayaran_ukt'],
        ['label' => 'Peminjaman Buku', 'value' => $totalPeminjamanBuku, 'route' => route('peminjaman-buku.index'), 'button' => 'Lihat transaksi', 'permission' => 'manage_peminjaman_buku'],
    ];

    $cards = array_values(array_filter($cards, fn ($card) => $user->hasPermission($card['permission'])));

    if ($user->hasRole(['admin', 'editor']) && $user->hasPermission('manage_roles')) {
        $cards[] = ['label' => 'Roles', 'value' => $totalRoles, 'route' => route('roles.index'), 'button' => 'Atur akses', 'permission' => 'manage_roles'];
    }
@endphp

<div class="row align-items-stretch g-4 mb-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <span class="badge text-bg-primary mb-3">Dashboard</span>
                <h1 class="h3 mb-2">Selamat datang, {{ $user->name }}</h1>
                <p class="text-muted mb-0">
                    Anda login sebagai <strong>{{ $roleName }}</strong>. Gunakan halaman ini sebagai pintu awal untuk mengakses data akademik, transaksi, dan pengaturan hak akses.
                </p>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <h2 class="h5 mb-3">Akun Login</h2>
                <div class="mb-2">
                    <div class="text-muted small">Nama</div>
                    <div class="fw-semibold">{{ $user->name }}</div>
                </div>
                <div class="mb-2">
                    <div class="text-muted small">Email</div>
                    <div class="fw-semibold">{{ $user->email }}</div>
                </div>
                <div>
                    <div class="text-muted small">Role</div>
                    <span class="badge text-bg-secondary">{{ $roleName }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    @foreach($cards as $card)
        <div class="col-sm-6 col-xl-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small mb-2">{{ $card['label'] }}</div>
                    <div class="display-6 fw-semibold mb-3">{{ $card['value'] }}</div>
                    <a class="btn btn-outline-primary btn-sm" href="{{ $card['route'] }}">
                        {{ $card['button'] }}
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
