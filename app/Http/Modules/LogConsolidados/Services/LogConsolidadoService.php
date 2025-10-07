<?php

namespace App\Http\Modules\LogConsolidados\Services;

use App\Http\Modules\LogConsolidados\Models\LogConsolidado;

class LogConsolidadoService
{
    /**
     * @param array $data
     * @return LogConsolidado
     */
    public function crear(array $data): LogConsolidado
    {
        return LogConsolidado::create($data);
    }
}