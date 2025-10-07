<?php

namespace App\Http\Modules\TipoRespiratoriasCaracterizacion\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\TipoRespiratoriasCaracterizacion\Repositories\TipoRespiratoriasCaracterizacionRepository;
use Illuminate\Http\Response;

class TipoRespiratoriasCaracterizacionController extends Controller
{
    private $tipoRespiratoriasRepository;

    public function __construct()
    {
        $this->tipoRespiratoriasRepository = new TipoRespiratoriasCaracterizacionRepository();
    }

    public function listarTodas()
    {
        try {
            $tipoRespiratorias = $this->tipoRespiratoriasRepository->listarTodas();
            return response()->json($tipoRespiratorias, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}