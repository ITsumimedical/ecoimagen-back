<?php

namespace App\Http\Modules\Telesalud\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Telesalud\Repositories\TipoEstrategiaTelesaludRepository;
use Error;
use Illuminate\Http\JsonResponse;

class TipoEstrategiaTelesaludController extends Controller
{
    public function __construct(
        private TipoEstrategiaTelesaludRepository $tipoEstrategiaTelesaludRepository
    ) {}


    /**
     * Obtiene todos los tipos de estrategias activos
     * @return JsonResponse TipoEstrategiaTelesalud[]
     * @throws \Throwable
     * @author Thomas
     */
    public function listarActivos(): JsonResponse
    {
        try {
            $respuesta = $this->tipoEstrategiaTelesaludRepository->listarActivos();
            return response()->json([
                'res' => true,
                'data' => $respuesta
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al obtener los tipos de estrategias'
            ], 400);
        }
    }
}
