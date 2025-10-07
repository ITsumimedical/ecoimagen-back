<?php

namespace App\Http\Modules\MiniMental\Model;

use App\Http\Modules\Consultas\Models\Consulta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class miniMental extends Model
{
    use HasFactory;

    protected $fillable = [
        'anio',
        'mes',
        'fecha_hoy',
        'hora',
        'pais',
        'ciudad',
        'departamento',
        'sitio_lugar_esta',
        'piso_barrio_vereda_esta',
        'memoria_repeticiones',
        'atencion_calculo',
        'evocacion',
        'denominacion',
        'repite_frase',
        'obedece_orden',
        'obedece_dos_ordenes',
        'escribe_frase_tarjeta',
        'realiza_bien_diseño',
        'consulta_id',
        'resultado'
    ];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }
}
