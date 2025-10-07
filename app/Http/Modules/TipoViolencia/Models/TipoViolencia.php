<?php

namespace App\Http\Modules\TipoViolencia\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoViolencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'activo',
    ];
}
