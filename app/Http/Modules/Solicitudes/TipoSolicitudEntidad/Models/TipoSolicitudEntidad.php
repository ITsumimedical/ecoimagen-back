<?php

namespace App\Http\Modules\Solicitudes\TipoSolicitudEntidad\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoSolicitudEntidad extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo_solicitud_id','entidad_id'
    ];
}
