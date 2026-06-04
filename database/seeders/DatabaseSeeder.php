<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $allPermissions = array_keys(config('permissions'));

        $adminRole = Role::updateOrCreate(
            ['name' => 'admin'],
            [
                'display_name' => 'Dosen',
                'description' => 'Akses penuh ke semua fitur',
                'permissions' => $allPermissions,
            ]
        );

        Role::updateOrCreate(
            ['name' => 'editor'],
            [
                'display_name' => 'Staff Kampus',
                'description' => 'Akses pengelolaan semua halaman',
                'permissions' => $allPermissions,
            ]
        );

        Role::updateOrCreate(
            ['name' => 'user'],
            [
                'display_name' => 'Mahasiswa',
                'description' => 'Akses pengguna umum',
                'permissions' => [],
            ]
        );

        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => 'password',
                'role_id' => $adminRole->id,
            ]
        );
    }
}
