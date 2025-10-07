<?php

namespace App\Http\Modules\DetalleSolicitudBodegas\Models;

use App\Http\Modules\Estados\Models\Estado;
use App\Http\Modules\Medicamentos\Models\Medicamento;
use App\Http\Modules\SolicitudBodegas\Models\NovedadSolicitudes;
use App\Http\Modules\SolicitudBodegas\Models\SolicitudBodega;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetalleSolicitudBodega extends Model
{
    use SoftDeletes;

    protected $fillable = [
            'solicitud_bodega_id',
            'medicamento_id',
            'cantidad_inicial',
            'cantidad_aprobada',
            'cantidad_entregada',
            'precio_unidad_aprobado',
            'precio_unidad_entrega',
            'descripcion',
            'lote',
            'estado_id',
            'bodega_medicamento_id',
            'codesumi_id',
            'fecha_vencimiento',
            'numero_factura',
            'observacion'
    ];

    /** Relaciones */
    public function medicamento()
    {
        return $this->hasOne(Medicamento::class, 'id','medicamento_id');
    }

    public function novedades(){
        return $this->hasMany(NovedadSolicitudes::class);
    }

    public function lotes(){
        return $this->hasMany(SolicitudDetalleBodegaLote::class);
    }

    public function solicitudBodega()
    {
        return $this->belongsTo(SolicitudBodega::class);
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }

        /** Scopes */

    /** Sets y Gets */

}
