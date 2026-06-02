<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // Mengizinkan pengisian massal untuk kolom-kolom ini
    protected $fillable = ['name', 'display_name', 'description'];
}