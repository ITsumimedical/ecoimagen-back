<?php

namespace App\Http\Modules\CuestionarioGad2\Services;

use App\Http\Modules\CuestionarioGad2\Model\cuestionarioGAD_2;

class CuestionarioGad2Service
{

    public function __construct(
        protected cuestionarioGAD_2 $cuestionarioGad2model,
    ) {}

    public function updateOrCreate(array $conditions, array $data)
    {
        return $this->cuestionarioGad2model::updateOrCreate($conditions, $data);
    }
}
