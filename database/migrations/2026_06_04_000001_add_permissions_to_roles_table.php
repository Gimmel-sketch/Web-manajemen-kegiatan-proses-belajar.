<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            if (! Schema::hasColumn('roles', 'permissions')) {
                $table->json('permissions')->nullable()->after('description');
            }
        });

        $allPermissions = json_encode(array_keys(config('permissions')));

        DB::table('roles')
            ->whereIn('name', ['admin', 'editor'])
            ->update(['permissions' => $allPermissions]);

        DB::table('roles')
            ->whereNull('permissions')
            ->update(['permissions' => json_encode([])]);
    }

    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            if (Schema::hasColumn('roles', 'permissions')) {
                $table->dropColumn('permissions');
            }
        });
    }
};
