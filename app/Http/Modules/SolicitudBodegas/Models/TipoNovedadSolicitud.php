<?php

namespace App\Http\Modules\SolicitudBodegas\Models;

use App\Http\Modules\Bodegas\Models\Bodega;
use App\Http\Modules\DetalleSolicitudBodegas\Models\DetalleSolicitudBodega;
use App\Http\Modules\Proveedores\Models\Proveedor;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoNovedadSolicitud extends Model
{
    protected $table = 'tipo_novedad_solicitudes';

    protected $guarded = [];
}


