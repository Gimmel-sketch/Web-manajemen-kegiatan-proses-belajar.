<?php
require __DIR__.'/bootstrap/app.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Mahasiswa;

$user = User::where('email', 'newuser@example.com')->first();

if ($user) {
    echo "User found: ID={$user->id}, Name={$user->name}, Email={$user->email}, NIM={$user->nim}\n";
    $mahasiswa = $user->mahasiswa;
    if ($mahasiswa) {
        echo "Mahasiswa found: NIM={$mahasiswa->nim}, Nama={$mahasiswa->nama}, Email={$mahasiswa->email}\n";
    } else {
        echo "Mahasiswa not found for this user.\n";
    }
    
    $token = $user->tokens()->latest()->first();
    if ($token) {
        echo "Latest Token: ID={$token->id}, Name={$token->name}, Abilities=" . json_encode($token->abilities) . ", Created={$token->created_at}\n";
    } else {
        echo "No tokens found for this user.\n";
    }
} else {
    echo "User not found.\n";
}
