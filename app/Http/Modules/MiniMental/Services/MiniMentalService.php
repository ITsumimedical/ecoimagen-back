<?php

namespace App\Http\Modules\MiniMental\Services;

use App\Http\Modules\MiniMental\Model\miniMental;

class MiniMentalService
{

    public function __construct(
        protected miniMental $miniMentalModel,
    ) {}

    public function updateOrCreate(array $campos, array $data)
    {
        return $this->miniMentalModel::updateOrCreate($campos, $data);
    }
}
