<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    private function permissionKeys(): array
    {
        $keys = [];

        foreach (config('permissions') as $moduleKey => $module) {
            foreach (array_keys($module['actions']) as $actionKey) {
                $keys[] = $moduleKey . '.' . $actionKey;
            }
        }

        return $keys;
    }

    public function index()
    {
        // Mengambil semua data role menggunakan Eloquent Model
        $roles = Role::orderBy('display_name')->get();
        $permissions = config('permissions');
        
        return view('roles', compact('roles', 'permissions'));
    }

    public function create()
    {
        $permissions = config('permissions');

        return view('roles-create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:roles,name',
            'display_name' => 'required',
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|in:' . implode(',', $this->permissionKeys()),
        ]);

        $data['permissions'] = $data['permissions'] ?? [];

        Role::create($data);

        return redirect()->route('roles.index')->with('success', 'Role berhasil ditambahkan');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = config('permissions');

        return view('roles-edit', compact('role', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|unique:roles,name,' . $id,
            'display_name' => 'required',
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|in:' . implode(',', $this->permissionKeys()),
        ]);

        $role = Role::findOrFail($id);
        $data['permissions'] = $data['permissions'] ?? [];
        $role->update($data);

        return redirect()->route('roles.index')->with('success', 'Role berhasil diperbarui');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role berhasil dihapus');
    }
}
