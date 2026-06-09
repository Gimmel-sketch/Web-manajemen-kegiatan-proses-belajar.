<?php

namespace App\Http\Controllers;

abstract class Controller
{
    /**
     * Authorize user untuk melakukan action pada resource
     * @param string $resource Nama resource (contoh: 'peminjaman_buku')
     * @param string $action Action yang akan dilakukan (view, create, update, delete)
     * @param string $errorMessage Pesan error jika tidak memiliki akses
     */
    protected function authorizeAction(string $resource, string $action, string $errorMessage = ''): void
    {
        $permission = $resource . '.' . $action;

        if (!auth()->user()->hasPermission($permission)) {
            $errorMessage = $errorMessage ?: "Anda tidak memiliki akses untuk melakukan action ini.";
            abort(403, $errorMessage);
        }
    }
}
