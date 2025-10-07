<?php

namespace App\Http\Modules\SolicitudBodegas\Models;

use App\Http\Modules\Bodegas\Models\Bodega;
use App\Http\Modules\DetalleSolicitudBodegas\Models\DetalleSolicitudBodega;
use App\Http\Modules\Estados\Models\Estado;
use App\Http\Modules\Proveedores\Models\Proveedor;
use App\Http\Modules\Reps\Models\Rep;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SolicitudBodega extends Model
{
    use SoftDeletes;

    protected function serializeDate($date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    protected $casts = [
        'created_at'=> 'date:Y-m-d',
        ];

    protected $guarded = [];


    /** Relaciones */
    public function usuarioSolicita(){
        return $this->hasOne(User::class, 'id','usuario_solicita_id');
    }

    public function detallesSolicitud(){
        return $this->hasMany(DetalleSolicitudBodega::class);
    }

    public function proveedor(){
        return $this->belongsTo(Proveedor::class);
    }


   public function bodegaOrigen(){
       return $this->belongsTo(Bodega::class,'bodega_origen_id');
   }
//
    public function bodegaDestino()
    {
    return $this->belongsTo(Bodega::class,'bodega_destino_id');
    }

    public function rep(){
        return $this->belongsTo(Rep::class);
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }

    /** Scopes */

    /** Sets y Gets */

}
