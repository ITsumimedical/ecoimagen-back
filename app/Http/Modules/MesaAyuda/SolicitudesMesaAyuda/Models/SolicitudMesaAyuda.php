<?php

namespace App\Http\Modules\MesaAyuda\SolicitudesMesaAyuda\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudMesaAyuda extends Model
{
    use HasFactory;

    protected $table ='categoria_mesa_ayuda_empleados';

    protected $fillable = [
        'categoria_mesa_ayuda_id',
        'empleado_id'
    ];
}
