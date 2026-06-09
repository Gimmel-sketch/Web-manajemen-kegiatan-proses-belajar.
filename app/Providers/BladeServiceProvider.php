<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Directive untuk cek permission: @canAccess('resource.action')
        Blade::if('canAccess', function (string $permission) {
            return auth()->user()?->hasPermission($permission) ?? false;
        });

        // Directive untuk cek permission dengan format module.action
        // Contoh: @permission('peminjaman_buku.create')
        Blade::if('permission', function (string $resource, string $action) {
            return auth()->user()?->hasPermission($resource . '.' . $action) ?? false;
        });
    }
}
