<?php

namespace App\Http\Modules\Facturacion;
use Illuminate\Database\Eloquent\Model;

class FacturaDetalle extends Model
{
    protected $table = 'factura_detalles';
    protected $guarded = [];

    public function factura()
    {
        return $this->belongsTo(Factura::class, 'factura_id');
    }

    public function items()
    {
        return $this->hasMany(FacturaDetalleItem::class, 'factura_detalle_id');
    }
}