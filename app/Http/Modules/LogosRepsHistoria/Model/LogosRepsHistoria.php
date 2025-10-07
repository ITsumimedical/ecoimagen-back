<?php

namespace App\Http\Modules\LogosRepsHistoria\Model;

use App\Http\Modules\Reps\Models\Rep;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogosRepsHistoria extends Model
{
    use HasFactory;

    protected $fillable = [
		'nombre_logo',
		'ruta',
		'rep_id'
	];

	public function rep()
	{
		return $this->belongsTo(Rep::class, 'rep_id');
	}
}
