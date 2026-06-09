<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class SetupDosenRoleSeeder extends Seeder
{
    /**
     * Seeder untuk mengatur Role Dosen sesuai dengan tabel permission yang dicentang
     * 
     * Jalankan: php artisan db:seed --class=SetupDosenRoleSeeder
     * 
     * Permission berdasarkan tabel:
     * - Role dan Hak Akses: ✅ Lihat (view only)
     * - Data Mahasiswa: ✅ Lihat, Tambah, Edit, Hapus (all)
     * - Mata Kuliah: ✅ Lihat, Tambah, Edit, Hapus (all)
     * - Dosen: ✅ Lihat, Tambah, Edit, Hapus (all)
     * - Ruangan: ✅ Lihat (view only)
     * - Buku: ✅ Lihat (view only)
     * - Transaksi KRS: ✅ Lihat, Tambah, Edit, Hapus (all)
     * - Jadwal Perkuliahan: ✅ Lihat (view only)
     * - Presensi Perkuliahan: ✅ Lihat, Tambah, Edit, Hapus (all)
     * - Nilai Perkuliahan: ✅ Lihat, Tambah, Edit, Hapus (all)
     * - Pembayaran UKT: ✅ Lihat (view only)
     * - Peminjaman Buku: ✅ Lihat, Tambah, Edit, Hapus (all)
     */
    public function run(): void
    {
        $permissions = [
            // Hanya bisa melihat halaman:
            // - Buku
            'buku.view',

            // - Pembayaran UKT (ukt)
            'pembayaran_ukt.view',

            // - Ruangan
            'ruangan.view',

            // - Roles
            'roles.view',
        ];

        // Update or Create role "admin" (usernamenya dosen) dengan permission view-only sesuai kebutuhan
        Role::updateOrCreate(
            ['name' => 'admin'],
            [
                'display_name' => 'Dosen',
                'description' => 'Akses view-only: buku, pembayaran_ukt, ruangan, roles',
                'permissions' => $permissions,
            ]
        );



        $this->command->info('✅ Role Dosen berhasil diatur dengan permission sesuai tabel!');
    }
}
