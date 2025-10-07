<?php

namespace App\Http\Modules\Beneficios\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beneficio extends Model
{
    use HasFactory;

    protected $casts = [
        'permitir_duplicidad' => 'boolean',
    ];

    protected $guarded = [];
}
