<?php
    require __DIR__.'/vendor/autoload.php';
    $app = require_once __DIR__.'/bootstrap/app.php';
    $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

    use App\Models\User;
    use App\Models\Mahasiswa;

    $emailToDelete = 'newuser@example.com';
    $user = User::where('email', $emailToDelete)->first();

    if ($user) {
        echo "Deleting User ID: {$user->id}, Name: {$user->name}, Email: {$user->email}, NIM: {$user->nim}\n";
        
        // Delete associated Mahasiswa record
        if ($user->nim) {
            $mahasiswa = Mahasiswa::where('nim', $user->nim)->first();
            if ($mahasiswa) {
                echo "Deleting Mahasiswa NIM: {$mahasiswa->nim}\n";
                $mahasiswa->delete();
            } else {
                echo "Mahasiswa record not found for NIM: {$user->nim}\n";
            }
        } else {
            echo "User has no NIM associated.\n";
        }

        // Delete personal access tokens
        $user->tokens()->delete();
        echo "Deleted personal access tokens for user.\n";

        // Delete the user
        $user->delete();
        echo "User and associated data deleted successfully.\n";
    } else {
        echo "User {$emailToDelete} not found.\n";
    }
?>