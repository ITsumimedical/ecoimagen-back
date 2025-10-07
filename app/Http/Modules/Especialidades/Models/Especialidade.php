<?php

namespace App\Http\Modules\Especialidades\Models;

use App\Http\Modules\CategoriaHistorias\Models\CategoriaHistoria;
use App\Http\Modules\Citas\Models\Cita;
use App\Http\Modules\Cups\Models\Cup;
use App\Http\Modules\Grupos\Models\Grupo;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Especialidade extends Model
{
    use HasFactory;


    protected $fillable = ['nombre', 'estado', 'requiere_telesalud', 'cup_id'];


    public function medicos()
    {
        return $this->belongsToMany(User::class);
    }

    public function citas()
    {
        return $this->hasMany(Cita::class);
    }

    public function categorias()
    {
        return $this->belongsToMany(CategoriaHistoria::class);
    }

    /**
     * The usuario that belong to the Especialidade
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function usuarios()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function cups()
    {
        return $this->belongsTo(Cup::class, 'cup_id'); // Asegura que 'cup_id' sea el nombre correcto en la BD
    }

    public function grupos(): BelongsToMany
    {
        return $this->belongsToMany(Grupo::class, 'especialidad_grupos', 'especialidad_id', 'grupo_id');
    }

    public function scopeFiltrarEspecialidades($query, $especialidades)
    {
        if (!empty($especialidades)) {
            $query->whereHas('medicoOrdena.especialidades', function ($q) use ($especialidades) {
                $q->whereIn('especialidad_id', $especialidades);
            });
        }

        return $query;
    }

}
