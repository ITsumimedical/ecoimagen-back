<?php

namespace App\Http\Modules\Departamentos\Models;

use App\Http\Modules\Municipios\Models\Municipio;
use App\Http\Modules\Paises\Models\Pais;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;

    /**
     * Relación con el modelo Pais.
     * 
     * Un departamento pertenece a un país.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pais()
    {
        // Definimos la relación de pertenencia entre Departamento y Pais.
        // Un departamento pertenece a un país identificado por 'pais_id'.
        return $this->belongsTo(Pais::class, 'pais_id');
    }

    /**
     * Relación con el modelo Municipio.
     * 
     * Un departamento tiene muchos municipios.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function municipios()
    {
        // Definimos la relación de uno a muchos entre Departamento y Municipio.
        // Un departamento puede tener muchos municipios relacionados por 'departamento_id'.
        return $this->hasMany(Municipio::class, 'departamento_id');
    }
}