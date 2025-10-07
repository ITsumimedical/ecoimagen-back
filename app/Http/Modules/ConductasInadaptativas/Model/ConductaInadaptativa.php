<?php

namespace App\Http\Modules\ConductasInadaptativas\Model;

use App\Http\Modules\Consultas\Models\Consulta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ConductaInadaptativa extends Model
{
    use HasFactory;

    protected $fillable = [
        'come_unas',
        'succiona_dedos',
        'muerde_labio',
        'sudan_manos',
        'tiemblan_manos',
        'agrege_sin_motivo',
        'se_caen_cosas',
        'trastornos_comportamiento',
        'trastornos_emocionales',
        'juega_solo',
        'juegos_prefiere',
        'prefiere_jugar_ninos',
        'distracciones_hijos',
        'conductas_juegos',
        'inicio_escolaridad',
        'cambio_colegio',
        'dificultad_aprendizaje',
        'repeticiones_escolares',
        'conducta_clase',
        'materias_mayor_nivel',
        'materias_menor_nivel',
        'consulta_id',
        'creado_por'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->creado_por = Auth::id();
            }
        });
    }


    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }
}
