<?php

namespace App\Http\Modules\EvolucionSignosSintomas\Models;

use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class EvolucionSignosSintomas extends Model
{
	use HasFactory;

	protected $fillable = [
		'consulta_id',
		'fecha_inicio',
		'tiempo_inicio',
		'signos_sintomas',
		'estresores_importantes',
		'estado_actual',
		'profesional_consultado_antes',
		'creado_por',
	];

	public function consulta(): BelongsTo
	{
		return $this->belongsTo(Consulta::class, 'consulta_id');
	}

	public function creadoPor(): BelongsTo
	{
		return $this->belongsTo(User::class, 'creado_por');
	}

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
