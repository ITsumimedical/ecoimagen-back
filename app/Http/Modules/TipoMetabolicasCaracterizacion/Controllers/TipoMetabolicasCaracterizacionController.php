<?php

namespace App\Http\Modules\TipoMetabolicasCaracterizacion\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\TipoMetabolicasCaracterizacion\Repositories\TipoMetabolicasCaracterizacionRepository;

class TipoMetabolicasCaracterizacionController extends Controller
{
    private $tipoMetabolicasCaracterizacionRepository;

    public function __construct()
    {
        $this->tipoMetabolicasCaracterizacionRepository = new TipoMetabolicasCaracterizacionRepository();
    }

    public function listarTodas()
    {
        return $this->tipoMetabolicasCaracterizacionRepository->listarTodas();
    }
}