# Sistem Permission Fix Guide

## Masalah yang Diperbaiki
Sistem permission tidak berfungsi karena:
1. **Tidak ada authorization check di controller** - semua orang bisa akses action
2. **Views tidak filter buttons berdasarkan permission** - semua button ditampilkan tanpa cek
3. **Hanya ada permission storage**, tanpa enforcement di aplikasi

## Solusi yang Diterapkan

### 1. Helper Method di Base Controller (`app/Http/Controllers/Controller.php`)
Tambahkan method `authorizeAction()` untuk memudahkan pengecekan permission:

```php
protected function authorizeAction(string $resource, string $action, string $errorMessage = ''): void
{
    $permission = $resource . '.' . $action;
    if (!auth()->user()->hasPermission($permission)) {
        $errorMessage = $errorMessage ?: "Anda tidak memiliki akses untuk melakukan action ini.";
        abort(403, $errorMessage);
    }
}
```

### 2. Blade Service Provider (`app/Providers/BladeServiceProvider.php`)
Membuat custom Blade directives untuk mempermudah pengecekan di view:
- `@canAccess('permission.name')` - untuk full permission string
- `@permission('resource', 'action')` - untuk format module.action

### 3. Permission Helper (`app/Helpers/PermissionHelper.php`)
Utility class untuk bekerja dengan permissions:
- `permissionKey()` - generate permission key
- `getAllPermissionKeys()` - get semua permission keys
- `getLabel()` - get label untuk permission

## Format Permission Keys
Permission disimpan dengan format: `resource.action`

Contoh:
- `peminjaman_buku.view` - Melihat data peminjaman buku
- `peminjaman_buku.create` - Menambah peminjaman buku
- `peminjaman_buku.update` - Mengedit peminjaman buku
- `peminjaman_buku.delete` - Menghapus peminjaman buku

## Cara Menerapkan pada Controller Lain

### Step 1: Update Controller
Tambahkan authorization check di setiap method:

```php
public function index()
{
    $this->authorizeAction('resource_name', 'view', 'Pesan error custom');
    // ... rest of code
}

public function create()
{
    $this->authorizeAction('resource_name', 'create', 'Pesan error custom');
    // ... rest of code
}

public function store(Request $request)
{
    $this->authorizeAction('resource_name', 'create', 'Pesan error custom');
    // ... rest of code
}

public function edit($id)
{
    $this->authorizeAction('resource_name', 'update', 'Pesan error custom');
    // ... rest of code
}

public function update(Request $request, $id)
{
    $this->authorizeAction('resource_name', 'update', 'Pesan error custom');
    // ... rest of code
}

public function destroy($id)
{
    $this->authorizeAction('resource_name', 'delete', 'Pesan error custom');
    // ... rest of code
}
```

### Step 2: Update View (Blade Template)
Tambahkan permission check sebelum menampilkan buttons:

```blade
<!-- Tombol Create/Tambah -->
@if(auth()->user()->hasPermission('resource_name.create'))
    <a class="btn btn-primary" href="{{ route('resource.create') }}">Tambah</a>
@endif

<!-- Tombol Edit -->
@if(auth()->user()->hasPermission('resource_name.update'))
    <a class="btn btn-warning btn-sm" href="{{ route('resource.edit', $item) }}">Edit</a>
@endif

<!-- Tombol Delete -->
@if(auth()->user()->hasPermission('resource_name.delete'))
    <form class="d-inline" action="{{ route('resource.destroy', $item) }}" method="POST">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
    </form>
@endif
```

Atau gunakan Blade directives yang baru:

```blade
@canAccess('resource_name.create')
    <a class="btn btn-primary" href="{{ route('resource.create') }}">Tambah</a>
@endcanAccess

@canAccess('resource_name.update')
    <a class="btn btn-warning btn-sm" href="{{ route('resource.edit', $item) }}">Edit</a>
@endcanAccess

@canAccess('resource_name.delete')
    <form class="d-inline" action="{{ route('resource.destroy', $item) }}" method="POST">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
    </form>
@endcanAccess
```

## Resource Names yang Tersedia
Lihat `config/permissions.php` untuk daftar lengkap resource yang didukung:
- `roles` - Role dan Hak Akses
- `mahasiswa` - Data Mahasiswa
- `mata_kuliah` - Mata Kuliah
- `dosen` - Dosen
- `ruangan` - Ruangan
- `buku` - Buku
- `krs` - Transaksi KRS
- `jadwal_perkuliahan` - Jadwal Perkuliahan
- `presensi_perkuliahan` - Presensi Perkuliahan
- `nilai_perkuliahan` - Nilai Perkuliahan
- `pembayaran_ukt` - Pembayaran UKT
- `peminjaman_buku` - Peminjaman Buku

## Testing Permission System

### 1. Setup Role dengan Permission Terbatas
Masuk sebagai admin, buka halaman Role dan Hak Akses:
- Buat atau edit role untuk Dosen
- Hanya pilih `peminjaman_buku.view` (tanpa create, update, delete)
- Simpan

### 2. Assign Role ke Dosen
- Pastikan user dosen memiliki role tersebut

### 3. Test Akses dengan Dosen
- Login sebagai dosen
- Buka halaman Peminjaman Buku
- Seharusnya:
  - ✅ Bisa melihat tabel (view permission ada)
  - ❌ Tombol "Tambah Peminjaman" tidak tampil
  - ❌ Tombol "Edit" tidak tampil
  - ❌ Tombol "Hapus" tidak tampil
  - ❌ Jika coba akses URL create/edit/delete langsung → error 403

## Controllers yang Sudah Diperbaiki
- ✅ TransaksiPeminjamanBukuController
- ✅ DosenController
- ✅ BukuController
- ✅ MahasiswaController
- ✅ MataKuliahController
- ✅ RuanganController

## Controllers yang Perlu Diperbaiki
- [ ] TransaksiPembayaranUktController
- [ ] TransaksiKrsController
- [ ] RoleController
- [ ] TransaksiPresensiPerkuliahanController
- [ ] TransaksiNilaiPerkuliahanController
- [ ] TransaksiJadwalPerkuliahanController

## Catatan Penting
1. Admin role otomatis memiliki semua permission
2. Permission check terjadi di 2 level:
   - **Backend (Controller)**: Mencegah akses API/route langsung
   - **Frontend (Blade View)**: Menyembunyikan tombol yang tidak bisa diakses
3. Both levels diperlukan untuk keamanan maksimal
