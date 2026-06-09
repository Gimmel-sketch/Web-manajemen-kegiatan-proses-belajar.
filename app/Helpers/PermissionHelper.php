<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Config;

class PermissionHelper
{
    /**
     * Generate permission key dari module dan action
     * Contoh: permissionKey('peminjaman_buku', 'create') => 'peminjaman_buku.create'
     */
    public static function permissionKey(string $module, string $action): string
    {
        return $module . '.' . $action;
    }

    /**
     * Dapatkan semua permission keys
     */
    public static function getAllPermissionKeys(): array
    {
        $keys = [];
        $permissions = Config::get('permissions', []);

        foreach ($permissions as $moduleKey => $module) {
            foreach (array_keys($module['actions'] ?? []) as $actionKey) {
                $keys[] = self::permissionKey($moduleKey, $actionKey);
            }
        }

        return $keys;
    }

    /**
     * Dapatkan permission label
     */
    public static function getLabel(string $module, string $action): string
    {
        $permissions = Config::get('permissions', []);
        
        if (!isset($permissions[$module])) {
            return '';
        }

        $moduleData = $permissions[$module];
        return $moduleData['label'] . ' - ' . ($moduleData['actions'][$action] ?? '');
    }
}
