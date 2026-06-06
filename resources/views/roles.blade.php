@extends('layouts.app')

@section('title', 'Daftar Hak Akses / Role')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Daftar Hak Akses / Role</h3>
            <a href="{{ route('roles.create') }}" class="btn btn-success btn-sm">Tambah Role</a>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Role</th>
                        <th>Nama User</th>
                        <th>Deskripsi</th>
                        <th>Hak Akses</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <td>{{ $role->id }}</td>
                            <td><span class="badge bg-primary">{{ $role->name }}</span></td>
                            <td>{{ $role->display_name }}</td>
                            <td>{{ $role->description }}</td>
                            <td>
                                @php($rolePermissions = $role->permissions ?? [])
                                @php($hasAnyPermission = false)
                                @foreach ($permissions as $moduleKey => $module)
                                    @php($enabledActions = array_filter($module['actions'], fn ($label, $actionKey) => in_array($moduleKey . '.' . $actionKey, $rolePermissions, true), ARRAY_FILTER_USE_BOTH))
                                    @if($enabledActions)
                                        @php($hasAnyPermission = true)
                                        <div class="mb-1">
                                            <span class="fw-semibold">{{ $module['label'] }}:</span>
                                            @foreach($enabledActions as $actionLabel)
                                                <span class="badge bg-secondary">{{ $actionLabel }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                @endforeach

                                @unless($hasAnyPermission)
                                    <span class="text-muted">Belum ada akses</span>
                                @endunless
                            </td>
                            <td>
                                <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning btn-sm">Edit</a>

                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
