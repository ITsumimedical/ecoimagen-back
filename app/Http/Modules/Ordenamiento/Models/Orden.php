<?php

namespace App\Http\Modules\Ordenamiento\Models;

use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Estados\Models\Estado;
use App\Http\Modules\Movimientos\Models\Movimiento;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orden extends Model
{
    use SoftDeletes;

    protected $table = "ordenes";

    protected $guarded = [];

    public function articulos()
    {
        return $this->hasMany(OrdenArticulo::class);
    }

    public function articulosPendientes()
    {
        return $this->hasMany(OrdenArticulo::class)->whereIn('estado_id', [18]);
    }

    public function articulosActivos()
    {
        return $this->hasMany(OrdenArticulo::class)->whereIn('estado_id', [1, 4, 45]);
    }

    public function procedimientos()
    {
        return $this->hasMany(OrdenProcedimiento::class);
    }

    public function ordenesCodigoPropio()
    {
        return $this->hasMany(OrdenCodigoPropio::class);
    }

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }

    public function funcionario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function movimiento()
    {
        return $this->belongsTo(Movimiento::class);
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }

    public function medico()
    {
        return $this->belongsTo(User::class, 'medico_ordena,id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @method detalles define que tipo de orden es y apartir de eso retorna su procedimientos o sus medicamentos
     */
    public function detalles()
    {
        if ($this->tipo_orden === 1) {
            return $this->articulos();
        }

        if ($this->tipo_orden_id === 2) {
            return $this->procedimientos();
        }
    }

    public function articulosIntrahospitalarios(): HasMany
    {
        return $this->hasMany(OrdenArticuloIntrahospitalario::class);
    }

    /** Scopes */

    /** Sets y Gets */
}
