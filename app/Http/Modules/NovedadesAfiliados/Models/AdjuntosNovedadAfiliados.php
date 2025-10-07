<?php

namespace App\Http\Modules\NovedadesAfiliados\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdjuntosNovedadAfiliados extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'ruta', 'novedad_afiliado_id'];
}
