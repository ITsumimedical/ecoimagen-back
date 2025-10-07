<?php

namespace App\Http\Modules\SucesionEvolutiva\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\SucesionEvolutiva\Model\SucesionEvolutiva;

class SucesionEvolutivaRepository extends RepositoryBase {

    public function __construct(protected SucesionEvolutiva $sucesionEvolutiva)
    {
        parent::__construct($this->sucesionEvolutiva);
    }

    public function crearSucesion(array $data)
    {
        return $this->sucesionEvolutiva->updateOrCreate(
            ['consulta_id' => $data['consulta_id']],
            $data
        );
    }

    public function obtenerDatosSucesionEvolutivaPorAfiliado($afiliadoId)
    {
        return $this->sucesionEvolutiva->select(
            'sucesion_evolutiva_conducta',
            'sucesion_evolutiva_lenguaje',
            'sucesion_evolutiva_area',
            'sucesion_evolutiva_conducta_personal',
        )
            ->whereHas('consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId);
            })
            ->latest()
            ->first();
    }
}
