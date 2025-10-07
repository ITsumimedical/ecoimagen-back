<?php

namespace App\Http\Modules\ContratosMedicamentos\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\ContratosMedicamentos\Repositories\NovedadesContratosMedicamentosRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class NovedadesContratosMedicamentosController extends Controller
{
    public function __construct(
        private readonly NovedadesContratosMedicamentosRepository $novedadesContratosMedicamentosRepository
    )
    {
    }

    /**
     * Lista las novedades de un contrato
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     * @author Thomas
     */
    public function listarNovedadesContrato(Request $request): JsonResponse
    {
        try {
            $novedades = $this->novedadesContratosMedicamentosRepository->listarNovedadesContrato($request->all());
            return response()->json($novedades, Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al listar las novedades del contrato!',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function listarAdjuntosNovedad(int $novedadId): JsonResponse
    {
        try {
            $adjuntos = $this->novedadesContratosMedicamentosRepository->listarAdjuntosNovedad($novedadId);
            return response()->json($adjuntos, Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al listar los adjuntos de la novedad!',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
