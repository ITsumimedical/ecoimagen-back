<?php

namespace App\Http\Modules\ComponentesHistoriaClinica\Model;

use App\Http\Modules\TipoHistorias\Models\TipoHistoria;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComponentesHistoriaClinica extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'ruta',
        'modelo',
        'ruta_pdf',
        'escala',
        'sexo',
        'edad_inicial',
        'edad_final',
    ];
}
