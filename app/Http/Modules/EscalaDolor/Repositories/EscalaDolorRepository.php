<?php

namespace App\Http\Modules\EscalaDolor\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\EscalaDolor\Model\EscalaDolor;

class EscalaDolorRepository extends RepositoryBase {

    public function __construct(protected EscalaDolor $escalaDolor)
    {
        parent::__construct($this->escalaDolor);
    }

    public function crearEscala(array $data)
    {
        return $this->escalaDolor->updateOrCreate(
            ['consulta_id' => $data['consulta_id']],
            $data
        );
    }

    public function obtenerDatosporAfiliado($afiliadoId)
    {
        return $this->escalaDolor->select(
            'descripcion',
            'color_escala'
        )
            ->whereHas('consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId);
            })
            ->latest()
            ->first();
    }
}
