<?php

namespace App\Http\Modules\sindromesGeriatricos\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SindromesGeriatricos extends Model
{
    use HasFactory;

    protected $fillable = [
        'deterioro_cognoscitivo',
        'inmovilidad',
        'inestabilidad_caidas',
        'fragilidad',
        'incontinencia_esfinteres',
        'depresion',
        'iatrogenia_medicamentosa',
        'consulta_id'
    ];
}
