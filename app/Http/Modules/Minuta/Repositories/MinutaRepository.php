<?php

namespace App\Http\Modules\Minuta\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Minuta\Model\Minuta;

class MinutaRepository extends RepositoryBase
{

    public function __construct(protected Minuta $minuta)
    {
        parent::__construct($this->minuta);
    }

    public function crearMinuta(array $data)
    {
        return $this->minuta->updateOrCreate(
            ['consulta_id' => $data['consulta_id']],
            $data
        );
    }

    public function obtenerDatosporAfiliado($afiliadoId)
    {
        return $this->minuta->select(
            'hora_tragos',
            'desayuno',
            'media_manana',
            'almuerzo',
            'algo',
            'comida',
            'merienda',
            'tragos',
            'descripcion_tragos',
            'desayuna_sino',
            'observaciones_desayuno',
            'mm_sino',
            'mm_descripcion',
            'almuerzo_sino',
            'descripcion_almuerzo',
            'algo_sino',
            'descripcion_algo',
            'comida_descripcion',
            'merienda_sino',
            'descripcion_merienda',
        )
            ->whereHas('consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId);
            })
            ->latest()
            ->first();
    }
}
