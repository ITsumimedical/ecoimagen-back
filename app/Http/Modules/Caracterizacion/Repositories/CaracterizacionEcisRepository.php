<?php

namespace App\Http\Modules\Caracterizacion\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Caracterizacion\Models\CaracterizacionEcis;

class CaracterizacionEcisRepository extends RepositoryBase
{

    protected CaracterizacionEcis $caracterizacionEcisModel;

    public function __construct()
    {
        parent::__construct($this->caracterizacionEcisModel = new CaracterizacionEcis());
    }

    /**
     * Funcion que valida la caracterizacion ECIS de un afiliado
     * @param int $afiliadoId
     * @return bool
     * @author Thomas
     */
    public function validarCaracterizacionEcis(int $afiliadoId): bool
    {
        return $this->caracterizacionEcisModel->where('afiliado_id', $afiliadoId)->exists();
    }


}