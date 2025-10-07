<?php

namespace App\Http\Modules\Interoperabilidad\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Interoperabilidad\Repositories\RegistroRecepcionOrdenesInteroperabilidadRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RegistroRecepcionOrdenesInteroperabilidadController extends Controller
{
    public function __construct(
        private readonly RegistroRecepcionOrdenesInteroperabilidadRepository $registroRecepcionOrdenesInteroperabilidadRepository
    ) {
    }

    /**
     * Lista los registros de recepcion de ordenes de interoperabilidad
     * @param Request $request
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function listarSeguimiento(Request $request): JsonResponse
    {
        try {
            $response = $this->registroRecepcionOrdenesInteroperabilidadRepository->listarSeguimiento($request->all());
            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}