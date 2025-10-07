<?php

namespace App\Http\Modules\Interoperabilidad\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroRecepcionOrdenesInteroperabilidad extends Model
{
    use HasFactory;

    protected $table = 'registro_recepcion_ordenes_interoperabilidad';

    protected $fillable = [
        'orden_interoperabilidad_id',
        'orden_articulo_interoperabilidad_id',
        'orden_procedimiento_interoperabilidad_id',
        'estado',
        'mensaje_error',
        'payload',
    ];

    protected $casts = [
        'payload' => 'array',
    ];

    /**
     * Scope para filtrar por estado
     * @param Builder $query
     * @param mixed $estado
     * @return Builder
     * @author Thomas
     */
    public function scopeWhereEstado(Builder $query, mixed $estado): Builder
    {
        if (!is_null($estado)) {
            return $query->where('estado', filter_var($estado, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE));
        }

        return $query;
    }

    /**
     * Scope para filtrar por id de la orden de interoperabilidad
     * @param Builder $query
     * @param int|null $id
     * @return Builder
     */
    public function scopeWhereOrdenInteroperabilidadId(Builder $query, ?int $id): Builder
    {
        if (!is_null($id)) {
            return $query->where('orden_interoperabilidad_id', $id);
        }

        return $query;
    }
}
