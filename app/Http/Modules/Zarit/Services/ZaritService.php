<?php

namespace App\Http\Modules\Zarit\Services;

use App\Http\Modules\Zarit\Model\zarit;

class ZaritService
{

    public function __construct(
        protected zarit $cuestionarioWhooleyModel,
    ) {}

    public function updateOrCreate(array $consulta, array $data)
    {
        return Zarit::updateOrCreate($consulta, $data);
    }
}
