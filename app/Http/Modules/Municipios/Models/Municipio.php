<?php

namespace App\Http\Modules\Municipios\Models;

use App\Http\Modules\Reps\Models\Rep;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Modules\Tutelas\Models\Tutela;
use App\Http\Modules\Colegios\Models\Colegio;
use App\Http\Modules\Subregion\Models\Subregiones;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Modules\Departamentos\Models\Departamento;

class Municipio extends Model
{
    use HasFactory;

    // Protege los campos que no pueden ser asignados en masa
    protected $fillable = [
        'nombre',
        'codigo_dane',
        'departamento_id'
    ];

    /**
     * Relación con el modelo Departamento.
     * Un municipio pertenece a un departamento.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'departamento_id', 'id');
    }

    /**
     * Relación con el modelo Tutela.
     * Un municipio puede tener una tutela.
     *
     */
    public function tutela()
    {
        return $this->hasOne(Tutela::class, 'municipio_id');
    }

    /**
     * Relación con el modelo Rep.
     * Un municipio puede tener múltiples reps.
     *
     */
    public function reps()
    {
        return $this->hasMany(Rep::class);
    }

    /**
     * Relación con el modelo Colegio.
     * Un municipio puede tener múltiples colegios.
     * @author kobatime
     * @since 13 agosto 2024
     */
    public function colegio()
    {
        return $this->hasMany(Colegio::class);
    }

    public function scopeWhereDepartamento(Builder $query, ?int $departamentoId): Builder
    {
        if (!is_null($departamentoId)) {
            return $query->where('departamento_id', $departamentoId);
        }

        return $query;
    }
}
