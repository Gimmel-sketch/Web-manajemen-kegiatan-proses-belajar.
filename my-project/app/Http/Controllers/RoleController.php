<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        // Mengambil semua data role menggunakan Eloquent Model
        $roles = Role::all();
        
        return view('roles', compact('roles'));
    }

    public function create()
    {
        return view('roles-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'display_name' => 'required',
        ]);

        Role::create($request->all());

        return redirect()->route('roles.index')->with('success', 'Role berhasil ditambahkan');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('roles-edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $id,
            'display_name' => 'required',
        ]);

        $role = Role::findOrFail($id);
        $role->update($request->all());

        return redirect()->route('roles.index')->with('success', 'Role berhasil diperbarui');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role berhasil dihapus');
    }
}