<?php

namespace App\Http\Modules\TipoRCVCaracterizacion\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\TipoRCVCaracterizacion\Repositories\TipoRCVCaracterizacionRepository;
use Illuminate\Http\Response;

class TipoRCVCaracterizacionController extends Controller
{
    private $tipoRCVCaracterizacionRepository;

    public function __construct()
    {
        $this->tipoRCVCaracterizacionRepository = new TipoRCVCaracterizacionRepository();
    }

    public function listarTodas()
    {
        try {
            $tipoRCVCaracterizacion = $this->tipoRCVCaracterizacionRepository->listarTodas();
            return response()->json($tipoRCVCaracterizacion, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
