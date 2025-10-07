<?php

namespace App\Http\Modules\Ordenamiento\Models;

use App\Http\Modules\Auditorias\Models\Auditoria;
use App\Http\Modules\CambiosOrdenes\Models\CambiosOrdene;
use App\Http\Modules\Estados\Models\Estado;
use App\Http\Modules\Medicamentos\Models\Codesumi;
use App\Http\Modules\Movimientos\Models\Movimiento;
use App\Http\Modules\Reps\Models\Rep;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrdenArticulo extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $appends = ['dosificacion', 'formula'];

    // Relación para obtener el último movimiento
    public function ultimoMovimiento()
    {
        return $this->hasOne(Movimiento::class)->latestOfMany();
    }
    /** Relaciones */
    public function orden()
    {
        return $this->belongsTo(Orden::class);
    }

    public function dispensado()
    {
        return $this->hasMany(DispensarPrestador::class, 'orden_articulo_id');
    }

    public function codesumi()
    {
        return $this->belongsTo(Codesumi::class);
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }

    public function auditorias()
    {
        return $this->hasMany(Auditoria::class);
    }

    public function cambioOrden()
    {
        return $this->hasMany(CambiosOrdene::class);
    }

    public function rep()
    {
        return $this->belongsTo(Rep::class);
    }

    public function movimientos()
    {
        return $this->hasMany(Movimiento::class, 'orden_articulo_id');
    }

    public function funcionarioSuspende()
    {
        return $this->belongsTo(User::class, 'funcionario_suspende');
    }

    public function repOrDefault()
    {
        return $this->belongsTo(Rep::class, 'rep_id')->withDefault(function () {
            return Rep::where('id', 77526)->first(); // este ID esta pensado para produccion, pertenece a FARMACIA RAMEDICAS CENTRO 
        });
    }

    public function scopeWhereEstado($query, $estado)
    {
        if ($estado === 'activo') {
            return $query->where('cantidad_entregada', null);
        }
        if ($estado === 'pendiente') {
            return $query->where('cantidad_entregada', '>', 0)
                ->where('cantidad_medico', '<', $this->cantidad_medico);
        }
        if ($estado === 'dispensado') {
            return $query->where('cantidad_medico', $this->cantidad_entregada);
        }
    }

    public function formaFarmaceutica()
    {
        return $this->belongsTo(FormaFarmaceutica::class, 'forma_farmaceutica_id');
    }

    /**
     * getDosificacionAttribute
     * dosificacion de formula
     *
     * @return void
     */

    public function getDosificacionAttribute()
    {
        if (
            is_null($this->dosis) || is_null($this->codesumi) || is_null($this->codesumi->unidad_presentacion) ||
            is_null($this->frecuencia) || is_null($this->unidad_tiempo) || is_null($this->duracion)
        ) {
            return null;
        }

        return "{$this->dosis} {$this->codesumi->unidad_presentacion} (s) cada {$this->frecuencia} {$this->unidad_tiempo} por {$this->duracion} dia(s)";
    }

    public function getFormulaAttribute()
    {
        $formaFarmaceuticaNombre = $this->codesumi->formaFarmaceutica->nombre ?? '';
        return " {$this->dosis} {$formaFarmaceuticaNombre}(s) cada {$this->frecuencia} {$this->unidad_tiempo} por {$this->duracion} dia(s)";
    }

    public function scopeWhereFechaDispensacion($query, string|null $fecha)
    {
        if ($fecha) {
            return $query->whereHas('ultimoMovimiento', function ($query) use ($fecha) {
                $query->whereDate('created_at', $fecha);
            });
        }
        return $query;
    }
}
