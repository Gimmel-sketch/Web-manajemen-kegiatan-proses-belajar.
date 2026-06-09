# Permission System - Panduan Lengkap

## 📋 Ringkasan Perbaikan

Sistem permission telah diperbaiki dengan menambahkan **authorization checks** di 2 level:

### Level 1: Backend (Controller)
Setiap method di controller melakukan pengecekan permission sebelum eksekusi:
```php
public function create()
{
    $this->authorizeAction('peminjaman_buku', 'create', 'Pesan error');
    // ... rest of code
}
```

### Level 2: Frontend (Blade View)
Buttons dan forms hanya ditampilkan jika user punya permission:
```blade
@if(auth()->user()->hasPermission('peminjaman_buku.create'))
    <a class="btn btn-primary">Tambah</a>
@endif
```

---

## 🎯 Cara Permission Disimpan

Permission disimpan dalam **Format Key**: `resource.action`

### Contoh Permission Keys:
```
peminjaman_buku.view      → Lihat Peminjaman Buku
peminjaman_buku.create    → Tambah Peminjaman Buku
peminjaman_buku.update    → Edit Peminjaman Buku
peminjaman_buku.delete    → Hapus Peminjaman Buku

dosen.view                → Lihat Data Dosen
dosen.create              → Tambah Data Dosen
dosen.update              → Edit Data Dosen
dosen.delete              → Hapus Data Dosen
```

### Resource Names (Modul) yang Tersedia:
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

### Action Names:
- `view` - Lihat
- `create` - Tambah
- `update` - Edit
- `delete` - Hapus

---

## 📁 Files yang Dimodifikasi

### Controllers (11 files):
✅ `app/Http/Controllers/Controller.php` - Tambah method `authorizeAction()`
✅ `app/Http/Controllers/RoleController.php` - Add authorization checks
✅ `app/Http/Controllers/TransaksiPeminjamanBukuController.php` - Add authorization checks
✅ `app/Http/Controllers/DosenController.php` - Add authorization checks
✅ `app/Http/Controllers/BukuController.php` - Add authorization checks
✅ `app/Http/Controllers/MahasiswaController.php` - Add authorization checks
✅ `app/Http/Controllers/MataKuliahController.php` - Add authorization checks
✅ `app/Http/Controllers/RuanganController.php` - Add authorization checks
✅ `app/Http/Controllers/TransaksiKrsController.php` - Add authorization checks
✅ `app/Http/Controllers/TransaksiPresensiPerkuliahanController.php` - Add authorization checks
✅ `app/Http/Controllers/TransaksiNilaiPerkuliahanController.php` - Add authorization checks
✅ `app/Http/Controllers/TransaksiPembayaranUktController.php` - Add authorization checks
✅ `app/Http/Controllers/TransaksiJadwalPerkuliahanController.php` - Add authorization checks

### New Files:
✨ `app/Helpers/PermissionHelper.php` - Helper utilities
✨ `app/Providers/BladeServiceProvider.php` - Custom Blade directives
✨ `database/seeders/TestPermissionSeeder.php` - Test seeder

### Configuration:
📝 `bootstrap/providers.php` - Register BladeServiceProvider

---

## 🧪 Cara Testing

### Step 1: Setup Seeder (Optional)
Jalankan seeder untuk membuat test users:
```bash
php artisan db:seed --class=TestPermissionSeeder
```

**Test Accounts:**
- Email: `test-dosen@test.com` / Password: `password`
- Email: `test-admin@test.com` / Password: `password`

### Step 2: Setup Role Terbatas Melalui UI
1. Login sebagai **Admin**
2. Buka menu **Role dan Hak Akses**
3. Edit atau buat Role baru (misal: "Dosen Limited")
4. **Hanya checklist Permission Tertentu**
   - Contoh: Hanya checklist `peminjaman_buku.view`
   - Jangan checklist: `peminjaman_buku.create`, `peminjaman_buku.update`, `peminjaman_buku.delete`
5. **Simpan Role**

### Step 3: Assign Role ke User
1. Edit/buat User dengan Role yang terbatas
2. Simpan

### Step 4: Test dengan Login User yang Terbatas
1. Logout dari admin
2. Login dengan user yang punya role terbatas
3. Navigasi ke halaman data (misal: Peminjaman Buku)

### Expected Result

#### ✅ Yang BERHASIL Dilakukan:
- Halaman index/list bisa dibuka
- Melihat tabel data
- Melihat permission yang di-centang di halaman Role

#### ❌ Yang GAGAL (403 Forbidden):
- Button "Tambah" **TIDAK tampil**
- Button "Edit" **TIDAK tampil** di setiap row
- Button "Hapus" **TIDAK tampil** di setiap row
- Akses langsung URL `/create` → Error 403
- Akses langsung URL `/1/edit` → Error 403
- Akses langsung URL delete dengan POST → Error 403

---

## 🔍 Cara Kerja Sistem

### Flow Diagram:

```
User Request
    ↓
Route → Controller Method
    ↓
[Authorization Check] ← $this->authorizeAction()
    ↓
If NOT has permission → HTTP 403 Abort
If has permission → Continue to action
    ↓
View Render
    ↓
[Permission Check in Blade] ← @if(auth()->user()->hasPermission())
    ↓
Show/Hide Buttons berdasarkan permission
```

### Code Flow:

1. **User Akses Route:**
   ```
   GET /peminjaman-buku → TransaksiPeminjamanBukuController@index
   ```

2. **Controller Check Permission:**
   ```php
   public function index()
   {
       $this->authorizeAction('peminjaman_buku', 'view');
       // ...
   }
   ```

3. **Authorization Helper Bekerja:**
   ```php
   // app/Http/Controllers/Controller.php
   protected function authorizeAction(string $resource, string $action)
   {
       $permission = $resource . '.' . $action; // 'peminjaman_buku.view'
       
       if (!auth()->user()->hasPermission($permission)) {
           abort(403, 'Unauthorized');
       }
   }
   ```

4. **hasPermission() Check:**
   ```php
   // app/Models/User.php
   public function hasPermission(string $permission): bool
   {
       if ($this->hasRole('admin')) {
           return true; // Admin punya semua permission
       }
       
       return $this->role?->hasPermission($permission);
   }
   ```

5. **Role Check Permission:**
   ```php
   // app/Models/Role.php
   public function hasPermission(string $permission): bool
   {
       return in_array($permission, $this->permissions ?? []);
   }
   ```

6. **If Permission Exists → Show Buttons in View:**
   ```blade
   @if(auth()->user()->hasPermission('peminjaman_buku.create'))
       <a class="btn btn-primary">Tambah</a>
   @endif
   ```

---

## 📊 Mapping Permission ke Action

| Action | Controller Method | Permission Key | Description |
|--------|-----------------|-----------------|-------------|
| View List | `index()` | `resource.view` | Lihat data |
| Create (Form) | `create()` | `resource.create` | Tampilkan form tambah |
| Create (Save) | `store()` | `resource.create` | Simpan data baru |
| Edit (Form) | `edit()` | `resource.update` | Tampilkan form edit |
| Edit (Save) | `update()` | `resource.update` | Simpan perubahan data |
| Delete | `destroy()` | `resource.delete` | Hapus data |

---

## 🐛 Troubleshooting

### Masalah: Button masih tampil padahal permission tidak ada
**Solusi:**
1. Cek apakah View sudah punya permission check
2. Clear cache: `php artisan view:clear`
3. Refresh browser (Ctrl+F5)

### Masalah: Tidak bisa redirect ke create padahal permission ada
**Solusi:**
1. Cek apakah permission disimpan dengan format yang benar di database
2. Jalankan query: `SELECT permissions FROM roles WHERE id = ?`
3. Permission harus dalam format array JSON: `["peminjaman_buku.view", "peminjaman_buku.create"]`

### Masalah: Admin masih kena 403 error
**Solusi:**
1. Verifikasi user punya role 'admin' dengan exact match
2. Cek: `SELECT role_id FROM users WHERE id = ?`
3. Cek role name: `SELECT name FROM roles WHERE id = ?` (harus 'admin')

### Masalah: Permission system tidak berfungsi sama sekali
**Solusi:**
1. Clear semua cache:
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan view:clear
   php artisan route:clear
   ```
2. Verify BladeServiceProvider terdaftar di `bootstrap/providers.php`
3. Test dengan membuat script artisan command untuk debug

---

## 📝 Checklist Implementasi

- [x] Add authorization checks ke semua 11 controllers
- [x] Update 1 view (peminjaman-buku/index.blade.php)
- [x] Create PermissionHelper class
- [x] Create BladeServiceProvider dengan custom directives
- [x] Create TestPermissionSeeder
- [x] Update bootstrap/providers.php
- [ ] Update remaining views (13+ files) untuk permission checks
- [ ] Clear production cache setelah deploy

---

## 🎬 Next Steps

### Views yang Masih Perlu Diupdate:
Tambahkan permission checks pada buttons di views berikut:
- `resources/views/roles.blade.php`
- `resources/views/Data-mahasiswa.blade.php`
- `resources/views/mata-kuliah/index.blade.php`
- `resources/views/dosen/index.blade.php`
- `resources/views/ruangan/index.blade.php`
- `resources/views/buku/index.blade.php`
- `resources/views/transaksi-krs/index.blade.php`
- `resources/views/jadwal-perkuliahan/index.blade.php`
- `resources/views/presensi-perkuliahan/index.blade.php`
- `resources/views/nilai-perkuliahan/index.blade.php`
- `resources/views/pembayaran-ukt/index.blade.php`
- Dan files view lainnya...

**Pattern untuk Update View:**
```blade
<!-- Tambah Button -->
@if(auth()->user()->hasPermission('resource_name.create'))
    <a class="btn btn-primary" href="{{ route('resource.create') }}">Tambah</a>
@endif

<!-- Edit Button -->
@if(auth()->user()->hasPermission('resource_name.update'))
    <a class="btn btn-warning btn-sm" href="{{ route('resource.edit', $item) }}">Edit</a>
@endif

<!-- Delete Button -->
@if(auth()->user()->hasPermission('resource_name.delete'))
    <form class="d-inline" action="{{ route('resource.destroy', $item) }}" method="POST">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
    </form>
@endif
```

---

## 📞 Support

Jika ada pertanyaan atau masalah dengan permission system, cek:
1. Format permission key (harus `resource.action`)
2. Permission disimpan di database roles table sebagai JSON
3. User terbind dengan role yang memiliki permission
4. Cache sudah di-clear
