<?php

namespace App\Http\Modules\Historia\Odontograma\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Odontograma extends Model
{
    use HasFactory;

    protected $fillable = [
        'cara',
        'consulta_id',
        'odontograma_parametrizacion_id'
    ];

    public function parametrizacion()
	{
		return $this->belongsTo(OdontogramaParametrizacion::class, 'odontograma_parametrizacion_id');
	}
}
