<?php

namespace App\Http\Modules\CierreMesContratosEmpleados\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CierreMesContratoEmpleado extends Model
{
    use HasFactory;

    protected $fillable = [
        'contrato_id', 'empleado_id', 'activo', 'fecha_cierre_mes'
    ];

}
