<?php

namespace App\Http\Modules\Historia\RegistroLaboratorios\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class registroLaboratorios extends Model
{
    protected $fillable = [
        'afiliado_id',
        'cup_id',
        'identificacion',
        'codigo_cup',
        'orden',
        'grupo',
        'cama',
        'seccion',
        'codigoexamen',
        'nombrexamen',
        'parametro',
        'resultado',
        'val_ref_1',
        'val_ref_2',
        'unidades',
        'fecha_registro',
        'fecha_validacion',
        'servicio',
        'codigo_centro',
        'nombre_centro',
        'codigomedico',
        'nombre_medico',
        'codigo_sede',
        'nombre_sede',
        'fecha_inicial',
        'fecha_final',
        'ips',
        'primaria',
        'ut',
        'adjunto',
    ];

    use HasFactory;
}
