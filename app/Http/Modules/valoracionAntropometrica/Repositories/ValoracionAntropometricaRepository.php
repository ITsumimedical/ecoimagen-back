<?php

namespace App\Http\Modules\valoracionAntropometrica\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\valoracionAntropometrica\Model\ValoracionAntropometrica;

class ValoracionAntropometricaRepository extends RepositoryBase {

    public function __construct(protected ValoracionAntropometrica $valoracionModel)
    {
        parent::__construct($this->valoracionModel);
    }

    public function obtenerDatosporAfiliado($afiliadoId)
    {
        return $this->valoracionModel->select(
            'peso_anterior',
            'fecha_registro_peso_anterior',
            'perimetro_braquial',
            'pliegue_grasa_tricipital',
            'pliegue_grasa_subescapular',
            'peso_talla',
            'longitud_talla',
        )
            ->whereHas('consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId);
            })
            ->latest()
            ->first();
    }
}
