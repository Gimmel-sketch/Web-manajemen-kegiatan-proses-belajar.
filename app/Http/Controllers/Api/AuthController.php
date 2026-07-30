<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password tidak sesuai.'],
            ]);
        }

        if (! $user->nim) {
            return response()->json([
                'message' => 'Akun ini tidak terdaftar sebagai mahasiswa.',
            ], 403);
        }

        $token = $user->createToken('simahasiswa', ['mahasiswa'])->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'nim' => $user->nim,
            ],
        ]);
    }

    public function register(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'nim' => ['required', 'string', 'unique:mahasiswa,nim'],
        ]);

        $roleId = Role::firstOrCreate(
            ['name' => 'user'],
            ['display_name' => 'User', 'description' => 'Akses pengguna umum']
        )->id;

        $now = now();
        $thn = date('Y');
        $mahasiswa = Mahasiswa::create([
            'nim' => $data['nim'],
            'nama' => $data['name'],
            'email' => $data['email'],
            'alamat' => '',
            'tempat_lahir' => '-',
            'tanggal_lahir' => $now,
            'jenis_kelamin' => 'L',
            'fakultas' => '-',
            'prodi' => '-',
            'angkatan' => $thn,
            'semester' => 1,
            'no_hp' => '-',
            'status' => 'Aktif',
            'agama' => '-',
            'nik' => $data['nim'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role_id' => $roleId,
            'nim' => $mahasiswa->nim,
        ]);

        $token = $user->createToken('simahasiswa', ['mahasiswa'])->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'nim' => $user->nim,
            ],
        ], 201);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout berhasil.']);
    }
}
