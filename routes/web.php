<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\TransaksiKrsController;
use App\Http\Controllers\TransaksiJadwalPerkuliahanController;
use App\Http\Controllers\TransaksiNilaiPerkuliahanController;
use App\Http\Controllers\TransaksiPembayaranUktController;
use App\Http\Controllers\TransaksiPeminjamanBukuController;
use App\Http\Controllers\TransaksiPresensiPerkuliahanController;
use App\Models\Buku;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Role;
use App\Models\Ruangan;
use App\Models\TransaksiKrs;
use App\Models\TransaksiJadwalPerkuliahan;
use App\Models\TransaksiNilaiPerkuliahan;
use App\Models\TransaksiPembayaranUkt;
use App\Models\TransaksiPeminjamanBuku;
use App\Models\TransaksiPresensiPerkuliahan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect('/dashboard')
        : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard', [
            'totalMahasiswa' => Mahasiswa::count(),
            'totalMataKuliah' => MataKuliah::count(),
            'totalDosen' => Dosen::count(),
            'totalRuangan' => Ruangan::count(),
            'totalBuku' => Buku::count(),
            'totalKrs' => TransaksiKrs::count(),
            'totalJadwalPerkuliahan' => TransaksiJadwalPerkuliahan::count(),
            'totalPresensiPerkuliahan' => TransaksiPresensiPerkuliahan::count(),
            'totalNilaiPerkuliahan' => TransaksiNilaiPerkuliahan::count(),
            'totalPembayaranUkt' => TransaksiPembayaranUkt::count(),
            'totalPeminjamanBuku' => TransaksiPeminjamanBuku::count(),
            'totalRoles' => Role::count(),
        ]);
    })->name('dashboard');

    Route::middleware(['role:admin,editor', 'permission:manage_roles'])->group(function () {
        Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
        Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
        Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
        Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
        Route::put('/roles/{id}', [RoleController::class, 'update'])->name('roles.update');
        Route::delete('/roles/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
    });

    Route::middleware('permission:manage_mahasiswa')->group(function () {
        Route::get('Create-mahasiswa', [MahasiswaController::class, 'create'])
            ->name('Create-mahasiswa');

        Route::post('simpan-mahasiswa', [MahasiswaController::class, 'store'])
            ->name('simpan-mahasiswa');

        Route::get('Data-mahasiswa', [MahasiswaController::class, 'index'])
            ->name('Data-mahasiswa');

        Route::get('edit-mahasiswa/{id}', [MahasiswaController::class, 'edit'])
            ->name('edit-mahasiswa');

        Route::put('edit-mahasiswa/{id}', [MahasiswaController::class, 'update'])
            ->name('update-mahasiswa');

        Route::delete('hapus-mahasiswa/{id}', [MahasiswaController::class, 'destroy'])
            ->name('hapus-mahasiswa');
    });

    Route::resource('buku', BukuController::class)->except(['show'])->middleware('permission:manage_buku');
    Route::resource('dosen', DosenController::class)->except(['show'])->middleware('permission:manage_dosen');
    Route::resource('ruangan', RuanganController::class)->except(['show'])->middleware('permission:manage_ruangan');
    Route::resource('mata-kuliah', MataKuliahController::class)->except(['show'])->middleware('permission:manage_mata_kuliah');
    Route::resource('transaksi-krs', TransaksiKrsController::class)->except(['show'])->middleware('permission:manage_krs');
    Route::resource('jadwal-perkuliahan', TransaksiJadwalPerkuliahanController::class)
        ->parameters(['jadwal-perkuliahan' => 'jadwalPerkuliahan'])
        ->except(['show'])
        ->middleware('permission:manage_jadwal_perkuliahan');
    Route::resource('presensi-perkuliahan', TransaksiPresensiPerkuliahanController::class)
        ->parameters(['presensi-perkuliahan' => 'presensiPerkuliahan'])
        ->except(['show'])
        ->middleware('permission:manage_presensi_perkuliahan');
    Route::resource('nilai-perkuliahan', TransaksiNilaiPerkuliahanController::class)
        ->parameters(['nilai-perkuliahan' => 'nilaiPerkuliahan'])
        ->except(['show'])
        ->middleware('permission:manage_nilai_perkuliahan');
    Route::resource('pembayaran-ukt', TransaksiPembayaranUktController::class)->except(['show'])->middleware('permission:manage_pembayaran_ukt');
    Route::resource('peminjaman-buku', TransaksiPeminjamanBukuController::class)->except(['show'])->middleware('permission:manage_peminjaman_buku');
});
