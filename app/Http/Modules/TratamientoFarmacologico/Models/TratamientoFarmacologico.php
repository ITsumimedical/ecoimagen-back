<?php

namespace App\Http\Modules\TratamientoFarmacologico\Models;

use App\Http\Modules\Codesumis\viasAdministracion\Model\viasAdministracion;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TratamientoFarmacologico extends Model
{
	use HasFactory;
	use SoftDeletes;

	protected $fillable = [
		'consulta_id',
		'dosis',
		'horario',
		'via_administracion_id',
		'descripcion_tratamiento',
		'creado_por',
	];

	public function viaAdministracion(): BelongsTo
	{
		return $this->belongsTo(viasAdministracion::class, 'via_administracion_id');
	}

	public function consulta(): BelongsTo
	{
		return $this->belongsTo(Consulta::class, 'consulta_id');
	}

	public function creadoPor(): BelongsTo
	{
		return $this->belongsTo(User::class, 'creado_por');
	}
}
