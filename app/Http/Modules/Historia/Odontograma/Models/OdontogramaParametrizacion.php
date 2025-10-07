<?php

namespace App\Http\Modules\Historia\Odontograma\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class OdontogramaParametrizacion extends Model
{
    use HasFactory;


    protected $table = 'odontograma_parametrizaciones';
    protected $fillable = [
        'tipo',
        'categoria',
        'color',
        'descripcion',
        'identificador',
        'caracter',
        'posicion',
        'estado',
		'clasificacion_cop_ceo',
		'informe_202'
    ];

	//Ponerle estado true siempre
	protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->estado = true;
        });
    }
}
