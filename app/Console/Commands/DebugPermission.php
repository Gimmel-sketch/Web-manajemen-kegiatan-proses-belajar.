<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;

class DebugPermission extends Command
{
    protected $signature = 'debug:permission {user_id : ID user untuk debug} {--role : Show role info}';

    protected $description = 'Debug permission untuk user tertentu';

    public function handle()
    {
        $userId = $this->argument('user_id');
        $user = User::find($userId);

        if (!$user) {
            $this->error("User dengan ID $userId tidak ditemukan");
            return;
        }

        $this->info("=== DEBUG PERMISSION ===\n");
        $this->info("User: {$user->name} ({$user->email})");

        if (!$user->role) {
            $this->warn("User tidak memiliki role");
            return;
        }

        $this->info("Role: {$user->role->display_name} ({$user->role->name})");
        $this->info("Permissions: " . count($user->role->permissions ?? []) . " total");

        if ($this->option('role')) {
            $this->printRoleInfo($user->role);
        }

        $this->printUserPermissions($user);
    }

    private function printRoleInfo(Role $role)
    {
        $this->info("\n=== ROLE INFO ===");
        $this->line("Name: {$role->name}");
        $this->line("Display: {$role->display_name}");
        $this->line("Description: {$role->description}");
        $this->line("\nPermissions:");

        if (empty($role->permissions)) {
            $this->warn("  - Tidak ada permission");
            return;
        }

        foreach ($role->permissions as $perm) {
            $this->line("  ✓ {$perm}");
        }
    }

    private function printUserPermissions(User $user)
    {
        $this->info("\n=== USER PERMISSION TESTS ===");

        $testPermissions = [
            'peminjaman_buku.view',
            'peminjaman_buku.create',
            'peminjaman_buku.update',
            'peminjaman_buku.delete',
            'dosen.view',
            'dosen.create',
            'roles.view',
            'roles.create',
        ];

        foreach ($testPermissions as $perm) {
            $has = $user->hasPermission($perm);
            $status = $has ? '✓ YES' : '✗ NO';
            $this->line("  {$status}: {$perm}");
        }

        if ($user->hasRole('admin')) {
            $this->info("\n✓ User adalah ADMIN - punya akses ke semua permission");
        }
    }
}
