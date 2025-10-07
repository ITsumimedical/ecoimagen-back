<?php

namespace App\Http\Modules\ProyectoEmpleado\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProyectoEmpleado extends Model
{
    use HasFactory;

    protected $fillable = [
        'empleado_id', 'proyecto_empleado_id'
    ];

    protected $casts = [
        'proyecto_empleado_id' => 'integer'
    ];
}
