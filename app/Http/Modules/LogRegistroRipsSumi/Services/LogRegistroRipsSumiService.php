<?php

namespace App\Http\Modules\LogRegistroRipsSumi\Services;

use App\Http\Modules\LogRegistroRipsSumi\Models\LogRegistroRipsSumi;

class LogRegistroRipsSumiService
{

    /**
     * obtiene una ruta por su ID
     * @param array $log
     * @return LogRegistroRipsSumi
     * @author Jose vasquez
     */
    public function crear(array $log): LogRegistroRipsSumi
    {
        return LogRegistroRipsSumi::create($log);
    }
}
