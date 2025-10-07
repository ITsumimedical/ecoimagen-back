<?php

namespace App\Http\Modules\Solicitudes\TipoSolicitudEmpleado\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoSolicitudEmpleado extends Model
{
    use HasFactory;

    protected $fillable = ['activo','tipo_solicitud_red_vital_id','empleado_id'];
}
