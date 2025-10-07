<?php

namespace App\Http\Modules\FiguraHumana\Model;

use App\Http\Modules\Consultas\Models\Consulta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FiguraHumana extends Model
{
    use HasFactory;

    protected $fillable = ['general', 'tronco', 'brazos_piernas', 'cuello','cara', 'cabello', 'ropas', 'dedos', 'articulaciones', 'proporciones','coordinacion_motora', 'orejas', 'ojos', 'menton', 'perfil', 'interpretacion_resultados',  'consulta_id'];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }
}
