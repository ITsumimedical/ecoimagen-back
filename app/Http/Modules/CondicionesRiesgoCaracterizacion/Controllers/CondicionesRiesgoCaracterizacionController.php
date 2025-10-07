<?php

namespace App\Http\Modules\CondicionesRiesgoCaracterizacion\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\CondicionesRiesgoCaracterizacion\Repositories\CondicionesRiesgoCaracterizacionRepository;
use Illuminate\Http\Response;

class CondicionesRiesgoCaracterizacionController extends Controller
{
    private $condicionesRiesgoCaracterizacionRepository;

    public function __construct()
    {
        $this->condicionesRiesgoCaracterizacionRepository = new CondicionesRiesgoCaracterizacionRepository();
    }

    public function listarTodas(){
        try {
            $condicionesRiesgoCaracterizacion = $this->condicionesRiesgoCaracterizacionRepository->listarTodas();
            return response()->json($condicionesRiesgoCaracterizacion, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
 
}