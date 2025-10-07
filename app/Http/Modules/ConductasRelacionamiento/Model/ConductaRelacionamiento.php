<?php

namespace App\Http\Modules\ConductasRelacionamiento\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ConductaRelacionamiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'alimentacion',
        'higiene',
        'sueno',
        'independencia_personal',
        'actividad',
        'atencion',
        'impulsividad',
        'crisis_colericas',
        'adaptacion',
        'labilidad_emocional',
        'relaciones_familiares',
        'tiempo_libre',
        'ruidos_altos',
        'socializacion',
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
}
