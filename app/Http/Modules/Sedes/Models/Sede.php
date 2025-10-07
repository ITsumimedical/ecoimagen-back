<?php

namespace App\Http\Modules\Sedes\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sede extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'hora_inicio',
        'hora_fin',
        'propia',
        'activo',
        'rep_id'
    ];

    protected $casts = [
        'rep_id' => 'integer',
        'propia' => 'boolean',
    ];

}
