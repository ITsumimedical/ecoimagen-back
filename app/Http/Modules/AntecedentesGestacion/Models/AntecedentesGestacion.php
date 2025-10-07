<?php

namespace App\Http\Modules\AntecedentesGestacion\Models;

use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class AntecedentesGestacion extends Model
{
	use HasFactory;
	use SoftDeletes;

	protected $fillable = [
		'consulta_id',
		'gestacion_numero',
		'controles',
		'amenazas_aborto',
		'infecciones_embarazo',
		'enfermedades_tratamiento',
		'descripcion_enfermedades_tratamiento',
		'alcoholismo',
		'drogadiccion',
		'edad_madre',
		'edad_padre',
		'consanguinidad',
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

    public function creadoPor()
    {
        return $this->belongsTo(User::class, 'creado_por');
    }
}
