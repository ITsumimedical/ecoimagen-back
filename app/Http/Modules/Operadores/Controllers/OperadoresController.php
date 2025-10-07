<?php

namespace App\Http\Modules\Operadores\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Operadores\Repositories\OperadorRepository;
use App\Http\Modules\Operadores\Services\OperadorService;

class OperadoresController extends Controller
{
    public function __construct(private OperadorRepository $operadorRepository, private OperadorService $operadorService)
    {
    }

    public function listar(Request $request): JsonResponse
    {
        try {
            $operador = $this->operadorRepository->listar($request);
            return response()->json($operador, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar usuarios',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarActivos(Request $request): JsonResponse
    {
        try {
            $operador = $this->operadorRepository->listarActivos($request);
            return response()->json($operador, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar usuarios',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarFiltro(Request $request): JsonResponse
    {
        try {
            $operador = $this->operadorService->listarConFiltros($request);
            return response()->json($operador, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar usuarios',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Metodo para recuperar los operadores activos de Sumimedical
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function listarActivosSumi()
    {
        try {
            $operadores = $this->operadorRepository->listarActivosSumi();
            return response()->json($operadores, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar usuarios',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarFiltroOperadorUser(Request $request): JsonResponse
    {
        try {
            $operadorUser = $this->operadorRepository->listarFiltro($request);
            return response()->json($operadorUser, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar usuarios',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Se listan los medicos y los auxiliares 
     * @param Request $request 
     * @return JsonResponse
     * @throws \Throwable
     * @author jose vasquez   
     */
    public function listarMedicosYauxiliares(Request $request): JsonResponse
    {
        try {
            $personal = $this->operadorRepository->listarMedicosYauxiliares($request->all());
            return response()->json($personal, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                $th->getMessage(),
                'mensaje' => 'Ha ocurrido un error al listar los medicos y auxiliares'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
