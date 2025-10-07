<?php

namespace App\Http\Modules\Historia\Paraclinicos\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paraclinico extends Model
{

    protected $fillable = [
        'resultadoCreatinina',
        'ultimaCreatinina',
        'resultaGlicosidada',
        'fechaGlicosidada',
        'resultadoAlbuminuria',
        'fechaAlbuminuria',
        'resultadoColesterol',
        'fechaColesterol',
        'resultadoHdl',
        'fechaHdl',
        'resultadoLdl',
        'fechaLdl',
        'resultadoTrigliceridos',
        'fechaTrigliceridos',
        'resultadoGlicemia',
        'fechaGlicemia',
        'resultadoPht',
        'fechaPht',
        'resultadoHemoglobina',
        'albumina',
        'fechaAlbumina',
        'fosforo',
        'fechaFosforo',
        'resultadoEkg',
        'fechaEkg',
        'glomerular',
        'fechaGlomerular',
        'usuario_id',
        'afiliado_id',
        'consulta_id',
        'nombreParaclinico',
        'resultadoParaclinico',
        'checkboxParaclinicos',
        'fechaParaclinico',
    ];

    use HasFactory;
}
