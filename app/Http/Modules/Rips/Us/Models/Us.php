<?php

namespace App\Http\Modules\Rips\Us\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Us extends Model
{
    use HasFactory;

    protected $fillable = ['codigo_admin','tipo_usuario','edad','unidad_mediad','zona_residencia','numero_documento','tipo_documento',
    'primer_apellido','segundo_apellido','primer_nombre','segundo_nombre','sexo','codigo_departamento_residencia','codigo_municipio_residencia',
    'paquete_rip_id'];
}
