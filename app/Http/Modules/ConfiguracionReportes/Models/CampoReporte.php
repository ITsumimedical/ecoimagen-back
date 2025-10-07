<?php

namespace App\Http\Modules\ConfiguracionReportes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CampoReporte extends Model
{
    protected $table = 'campos_reporte';

    protected $fillable = [
        'configuracion_reporte_id',
        'nombre',
        'origen',
        'tipoCampo',
        'requerido',
        'valorDefault'
    ];
}
