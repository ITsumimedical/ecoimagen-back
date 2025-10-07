<?php

namespace App\Http\Modules\PatologiaRespiratoria\Models;

use App\Http\Modules\Consultas\Models\Consulta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatologiaRespiratoria extends Model
{
    use HasFactory;

    protected $table = 'patologia_respiratorias';

    protected $fillable = [
        'consulta_id',
        'creado_por',
        'presenta_sindrome_apnea',
        'hipoapnea_obstructiva_sueno',
        'tipoApnea',
        'origen',
        'uso_cpap_bipap',
        'observacion_uso',
        'adherencia_cpap_bipap',
        'observacion_adherencia',
        'uso_oxigeno',
        'litro_oxigeno',
        'clasificacion_control_asma',
    ];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class , 'consulta_id');
    }
}
