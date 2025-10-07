<?php

namespace App\Http\Modules\NivelKaiser\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\NivelKaiser\Model\nivelKaiser;

class nivelKaiserRepository extends RepositoryBase {

    public function __construct(protected nivelKaiser $nivelKaiser){
        parent::__construct($this->nivelKaiser);
    }

    /**
     * Crea o actualiza un registro de NivelKaiser según el afiliado_id.
     *
     * @param array $data
     * @return nivelKaiser
     */
    public function crearKaiser(array $data)
    {
        return $this->nivelKaiser->updateOrCreate(
            ['afiliado_id' => $data['afiliado_id']],
            $data
        );
    }

    public function obtenerDatosporAfiliado($afiliadoId)
    {
        return $this->nivelKaiser->where('afiliado_id', $afiliadoId)->first();
    }
}
