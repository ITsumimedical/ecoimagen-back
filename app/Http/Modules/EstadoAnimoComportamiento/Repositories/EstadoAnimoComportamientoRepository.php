<?php

namespace App\Http\Modules\EstadoAnimoComportamiento\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\EstadoAnimoComportamiento\Model\EstadoAnimoComportamiento;

class EstadoAnimoComportamientoRepository extends RepositoryBase
{

    public function __construct(protected EstadoAnimoComportamiento $estadoAnimoComportamiento)
    {
        parent::__construct($this->estadoAnimoComportamiento);
    }

    public function crearEstado(array $data)
    {
        return $this->estadoAnimoComportamiento->updateOrCreate(
            ['consulta_id' => $data['consulta_id']],
            $data
        );
    }

    public function obtenerDatosporAfiliado($afiliadoId)
    {
        return $this->estadoAnimoComportamiento->select(
            'estado_animo',
            'comportamiento',
            'actividades_basicas',
        )
            ->whereHas('consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId);
            })
            ->latest()
            ->first();
    }
}
