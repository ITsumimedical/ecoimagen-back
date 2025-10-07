<?php

namespace App\Http\Modules\TipoInmunodeficienciasCaracterizacion\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\TipoInmunodeficienciasCaracterizacion\Repositories\TipoInmunodeficienciasCaracterizacionRepository;
use Illuminate\Http\Response;

class TipoInmunodeficienciasCaracterizacionController extends Controller
{
    private $tipoInmunodeficienciasCaracterizacionRepository;

    public function __construct(){
        $this->tipoInmunodeficienciasCaracterizacionRepository = new TipoInmunodeficienciasCaracterizacionRepository();
    }

    public function listarTodas(){
        try {
            $tipos = $this->tipoInmunodeficienciasCaracterizacionRepository->listarTodas();
            return response()->json($tipos, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}