<?php

namespace App\Http\Modules\Pqrsf\CodigosPropios\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Pqrsf\CodigosPropios\Repositories\CodigoPropioPqrsfRepository;
use App\Http\Modules\Pqrsf\CodigosPropios\Requests\ActualizarCodigosPropiosPqrsfRequest;
use App\Http\Modules\Pqrsf\CodigosPropios\Services\CodigoPropioPqrsfService;
use App\Http\Modules\Pqrsf\CodigosPropios\Requests\CrearCodigoPropioPqrsfRequest;

class CodigoPropioPqrsfController extends Controller
{

    private $cpropioRepository;

    public function __construct(private CodigoPropioPqrsfService $cpropioPqrsfService)
    {
        $this->cpropioRepository = new CodigoPropioPqrsfRepository();
    }

    public function listar(Request $request)
    {
        try {
            $codigos = $this->cpropioRepository->listarCodigos($request);
            return response()->json($codigos, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'Mensaje' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
    public function crear(CrearCodigoPropioPqrsfRequest $request): JsonResponse
    {
        try {
            $area = $this->cpropioPqrsfService->crearServicio($request->validated());
            return response()->json($area, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function eliminar(Request $request)
    {
        try {
            $codigo = $this->cpropioRepository->eliminar($request);
            return response()->json($codigo, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al eliminar el código propio de PQRSF!',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza los codigos propios de un PQRSF
     * @param int $pqrsfId
     * @param ActualizarCodigosPropiosPqrsfRequest $request
     * @return JsonResponse
     * @author Thomas
     */
    public function actualizarCodigosPropios(int $pqrsfId, ActualizarCodigosPropiosPqrsfRequest $request): JsonResponse
    {
        try {
            $respuesta = $this->cpropioRepository->actualizarCodigosPropios($pqrsfId, $request->validated());
            return response()->json($respuesta, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al actualizar los codigos propios de PQRSF!',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Elimina un código propio de un PQRSF
     * @param int $pqrsfId
     * @param Request $request
     * @return JsonResponse
     * @author Thomas
     */
    public function removerCodigoPropio(int $pqrsfId, Request $request): JsonResponse
    {
        try {
            $respuesta = $this->cpropioRepository->removerCodigoPropio($pqrsfId, $request->all());
            return response()->json($respuesta, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al remover el código propio de PQRSF!',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
