<?php

namespace App\Http\Modules\Minuta\Model;

use App\Http\Modules\Consultas\Models\Consulta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Minuta extends Model
{
    use HasFactory;

    protected $fillable = [
        'hora_tragos',
        'desayuno',
        'media_manana',
        'almuerzo',
        'algo',
        'comida',
        'merienda',
        'tragos',
        'consulta_id',
        'descripcion_tragos',
        'desayuna_sino',
        'observaciones_desayuno',
        'mm_sino',
        'mm_descripcion',
        'almuerzo_sino',
        'descripcion_almuerzo',
        'algo_sino',
        'descripcion_algo',
        'comida_sino',
        'comida_descripcion',
        'merienda_sino',
        'descripcion_merienda',
    ];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }
}
