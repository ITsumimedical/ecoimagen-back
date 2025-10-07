<?php

namespace App\Http\Modules\Facturacion;

use Illuminate\Database\Eloquent\Model;

class FacturaDetalleItem extends Model
{
    protected $table = 'registrofacturasumimedicals';
    protected $guarded = [];

    public function scopeWhereDocumento($query, string $documento)
    {
        if (empty($documento)) {
            return $query;
        }
        return $query->where('afiliados.numero_documento', $documento);
    }

    public function scopeWhereCup($query, string $cup)
    {
        if (empty($cup)) {
            return $query;
        }
        return $query->where('registrofacturasumimedicals.codigo_cup', $cup);
    }

    public function scopeWhereFechaInicio($query, string $fechaInicio)
    {
        if (empty($fechaInicio)) {
            return $query;
        }
        return $query->whereDate('registrofacturasumimedicals.fecha_ingreso', '>=', $fechaInicio);
    }

    public function scopeWhereFechaFin($query, string $fechaFin)
    {
        if (empty($fechaFin)) {
            return $query;
        }
        return $query->whereDate('registrofacturasumimedicals.fecha_ingreso', '<=', $fechaFin);
    }

    public function scopeWhereEstado($query, bool|null $estado)
    {
        if (is_null($estado)) {
            return $query;
        }
        return $query->where('registrofacturasumimedicals.estado', $estado);
    }

}