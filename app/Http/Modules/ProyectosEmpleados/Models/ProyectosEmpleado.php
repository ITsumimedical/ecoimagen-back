<?php

namespace App\Http\Modules\ProyectosEmpleados\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProyectosEmpleado extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'estado'
    ];

    protected $casts = [
        'estado' => 'boolean'
    ];
}
