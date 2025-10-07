<?php

namespace App\Http\Modules\FiguraHumana\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\FiguraHumana\Model\FiguraHumana;

class FiguraHumanaRepository extends RepositoryBase
{

    public function __construct(protected FiguraHumana $figuraHumana)
    {
        parent::__construct($this->figuraHumana);
    }

    public function crearFiguraHumana(array $data)
    {
        return $this->figuraHumana->updateOrCreate(
            ['consulta_id' => $data['consulta_id']],
            $data
        );
    }

    public function obtenerDatosporAfiliado($afiliadoId)
    {
        return $this->figuraHumana->select(
            'general',
            'tronco',
            'brazos_piernas',
            'cuello',
            'cara',
            'cabello',
            'ropas',
            'dedos',
            'articulaciones',
            'proporciones',
            'coordinacion_motora',
            'orejas',
            'ojos',
            'menton',
            'perfil'
        )
            ->whereHas('consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId);
            })
            ->latest()
            ->first();
    }
}
