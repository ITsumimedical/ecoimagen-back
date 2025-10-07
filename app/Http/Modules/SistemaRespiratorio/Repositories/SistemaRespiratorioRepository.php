<?php

namespace App\Http\Modules\SistemaRespiratorio\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\SistemaRespiratorio\Models\SistemasRespiratorios;

class SistemaRespiratorioRepository extends RepositoryBase
{
    protected $sistemaRespiratorio;

    public function __construct()
    {
        $this->sistemaRespiratorio = new SistemasRespiratorios();
        parent::__construct($this->sistemaRespiratorio);
    }

    public function obtenerDatosporAfiliado($afiliadoId)
    {
        return $this->sistemaRespiratorio->select(
            'creado_por',
            'escala_disnea_mrc',
            'indice_bode',
            'bodex'
        )
            ->whereHas('consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId);
            })
            ->latest()
            ->first();
    }
}
