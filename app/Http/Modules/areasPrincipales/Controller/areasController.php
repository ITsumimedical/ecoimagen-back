<?php

namespace App\Http\Modules\areasPrincipales\Controller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Modules\areasPrincipales\Requests\areasRequets;
use App\Http\Modules\areasPrincipales\Repositories\areasRepository;
use App\Http\Modules\areasPrincipales\Requests\ActualizarAreaRequest;

class areasController extends Controller
{
    private $areas;

    public function __construct()
    {
        $this->areas = new areasRepository();
    }

    public function crear(areasRequets $request): JsonResponse
    {
        try {
            $terapeuticos = $this->areas->crear($request->validated());
            return response()->json($terapeuticos, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function listar(Request $request): JsonResponse
    {
        try {
            $terapeuticos = $this->areas->listarArea($request);
            return response()->json($terapeuticos, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    public function listarTodos(Request $request): JsonResponse
    {
        try {
            $terapeuticos = $this->areas->listarTodos($request);
            return response()->json($terapeuticos, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizar(ActualizarAreaRequest $request, $id)
    {
        try {
            $this->areas->actualizarArea($id, $request->validated());
            return response()->json([], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function cambiarEstado($id): JsonResponse
    {
        try {
            $canal = $this->areas->CambiarEstado($id);
            if ($canal) {
                return response()->json($canal, Response::HTTP_OK);
            } else {
                return response()->json([
                    'res' => false,
                    'mensaje' => 'Canal no encontrado',
                ], Response::HTTP_NOT_FOUND);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al cambiar el estado del canal',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Metodo para buscar por nombre del area
     * @param string $request
     * @return JsonResponse
     * @author Thomas
     */
    public function buscarPorNombre($request): JsonResponse
    {
        try {
            $areas = $this->areas->buscarPorNombre($request);
            return response()->json($areas, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
