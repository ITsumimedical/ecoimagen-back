<?php

namespace App\Http\Modules\PatologiaRespiratoria\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\PatologiaRespiratoria\Models\PatologiaRespiratoria;

class PatologiaRespiratoriaRepository extends RepositoryBase
{
    protected $patologiaRespiratoria;
    public function __construct()
    {
        $this->patologiaRespiratoria = new PatologiaRespiratoria();
        parent::__construct($this->patologiaRespiratoria);
    }

    public function obtenerDatosporAfiliado($afiliadoId)
    {
        return $this->patologiaRespiratoria->select(
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
        )
            ->whereHas('consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId);
            })
            ->latest()
            ->first();
    }
}
