<?php

namespace App\Http\Modules\Historia\Odontograma\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OdontogramaIndicadores extends Model
{
    use HasFactory;

    protected $fillable = [
        'consulta_id',
        'cop_c',
        'cop_o',
        'cop_p',
        'ceo_c',
        'ceo_e',
        'ceo_o',
        'sano',
        'caries_no_cavitacional',
        'caries_cavitacional',
        'obturado_por_caries',
        'perdido_por_caries',
        'resultado_informe',
    ];
}
