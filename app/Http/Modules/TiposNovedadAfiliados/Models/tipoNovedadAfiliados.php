<?php

namespace App\Http\Modules\TiposNovedadAfiliados\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tipoNovedadAfiliados extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'descripcion',
        'estado'
    ];
}
