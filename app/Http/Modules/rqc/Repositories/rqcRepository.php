<?php

namespace App\Http\Modules\rqc\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\rqc\model\rqc;

class rqcRepository extends RepositoryBase
{

    public function __construct(protected rqc $rqc)
    {
        parent::__construct($this->rqc);
    }
    public function crearRqc(array $data)
    {
        return $this->rqc->updateOrCreate(
            ['consulta_id' => $data['consulta_id']],
            $data
        );
    }

    public function obtenerDatosporAfiliado($afiliadoId)
    {
        return $this->rqc->select(
            'lenguaje_normal',
            'duerme_mal',
            'tenido_convulsiones',
            'dolores_cabeza',
            'huido_casa',
            'robado_casa',
            'nervioso',
            'lento_responder',
            'no_juega_amigos',
            'orina_defeca',
            'interpretacion_resultado'
        )
            ->whereHas('consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId);
            })
            ->latest()
            ->first();
    }
}
