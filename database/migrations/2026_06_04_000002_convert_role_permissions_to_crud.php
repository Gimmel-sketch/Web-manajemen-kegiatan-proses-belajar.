<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $crudPermissions = [];

        foreach (config('permissions') as $moduleKey => $module) {
            foreach (array_keys($module['actions']) as $actionKey) {
                $crudPermissions[] = $moduleKey . '.' . $actionKey;
            }
        }

        $legacyMap = [
            'manage_roles' => 'roles',
            'manage_mahasiswa' => 'mahasiswa',
            'manage_mata_kuliah' => 'mata_kuliah',
            'manage_dosen' => 'dosen',
            'manage_ruangan' => 'ruangan',
            'manage_buku' => 'buku',
            'manage_krs' => 'krs',
            'manage_jadwal_perkuliahan' => 'jadwal_perkuliahan',
            'manage_presensi_perkuliahan' => 'presensi_perkuliahan',
            'manage_nilai_perkuliahan' => 'nilai_perkuliahan',
            'manage_pembayaran_ukt' => 'pembayaran_ukt',
            'manage_peminjaman_buku' => 'peminjaman_buku',
        ];

        DB::table('roles')->orderBy('id')->each(function ($role) use ($crudPermissions, $legacyMap) {
            $permissions = json_decode($role->permissions ?? '[]', true) ?: [];

            if (in_array($role->name, ['admin', 'editor'], true)) {
                DB::table('roles')->where('id', $role->id)->update([
                    'permissions' => json_encode($crudPermissions),
                ]);

                return;
            }

            $converted = [];

            foreach ($permissions as $permission) {
                if (str_contains($permission, '.')) {
                    $converted[] = $permission;
                    continue;
                }

                if (! isset($legacyMap[$permission])) {
                    continue;
                }

                foreach (['view', 'create', 'update', 'delete'] as $action) {
                    $converted[] = $legacyMap[$permission] . '.' . $action;
                }
            }

            DB::table('roles')->where('id', $role->id)->update([
                'permissions' => json_encode(array_values(array_unique($converted))),
            ]);
        });
    }

    public function down(): void
    {
        //
    }
};
