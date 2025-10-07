<?php

namespace App\Http\Modules\SolicitudBodegas\Models;

use App\Http\Modules\Bodegas\Models\Bodega;
use App\Http\Modules\DetalleSolicitudBodegas\Models\DetalleSolicitudBodega;
use App\Http\Modules\Proveedores\Models\Proveedor;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NovedadSolicitudes extends Model
{
    protected $table = 'novedad_solicitudes';

    protected $guarded = [];

    public function tipo_novedad(){
        return $this->belongsTo(TipoNovedadSolicitud::class);
    }
}


