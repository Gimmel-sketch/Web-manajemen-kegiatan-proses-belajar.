@extends('layouts.app')

@section('title', 'Edit Role')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Edit Role</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('roles.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Nama Role (System Name)</label>
                    <input type="text" name="name" class="form-control" value="{{ $role->name }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama User</label>
                    <input type="text" name="display_name" class="form-control" value="{{ $role->display_name }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3">{{ $role->description }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Hak Akses</label>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th>Modul</th>
                                    <th class="text-center">Lihat</th>
                                    <th class="text-center">Tambah</th>
                                    <th class="text-center">Edit</th>
                                    <th class="text-center">Hapus</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $moduleKey => $module)
                                    <tr>
                                        <td class="fw-semibold">{{ $module['label'] }}</td>
                                        @foreach ($module['actions'] as $actionKey => $actionLabel)
                                            @php($permissionKey = $moduleKey . '.' . $actionKey)
                                            <td class="text-center">
                                                <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    name="permissions[]"
                                                    value="{{ $permissionKey }}"
                                                    id="permission_{{ $moduleKey }}_{{ $actionKey }}"
                                                    title="{{ $actionLabel }} {{ $module['label'] }}"
                                                    @checked(in_array($permissionKey, old('permissions', $role->permissions ?? []), true))
                                                >
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-success">Perbarui Role</button>
                </div>
            </form>
        </div>
    </div>
@endsection
