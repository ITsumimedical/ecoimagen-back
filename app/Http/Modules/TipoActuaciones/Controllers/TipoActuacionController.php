<?php

namespace App\Http\Modules\TipoActuaciones\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\TipoActuaciones\Repositories\TipoActuacionRepository;
use App\Http\Modules\TipoActuaciones\Requests\ActualizarTipoActuacionRequest;
use App\Http\Modules\TipoActuaciones\Requests\GuardarTipoActuacionRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TipoActuacionController extends Controller
{
    protected $tipoActuacionRepository;

    public function __construct(TipoActuacionRepository $tipoActuacionRepository)
    {
        $this->tipoActuacionRepository = $tipoActuacionRepository;
    }

     /**
     * listar los tipos de actuaciones
     * @param Request $request
     * @return Response $tipo actuación
     * @author Manuela
     */

    public function listar(Request $request): JsonResponse
    {
        try {
            $tipoActuacion = $this->tipoActuacionRepository->listar($request);
            return response()->json($tipoActuacion, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al listar las actuaciones.'
            ],Response::HTTP_BAD_REQUEST);
        }

    }

     /**
     * Crear un tipo de actuacion
     * @param Request $request
     * @return Response $tipoActuacion
     * @author Manuela
     */

    public function crear(GuardarTipoActuacionRequest $request): JsonResponse
    {
        try {
            $this->tipoActuacionRepository->crear($request->validated());
            return response()->json([
                'mensaje' => 'Se creo el tipo de actuación con exito!',
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => true,
                'mensaje' => 'Error al recuperar la información.'
            ], Response::HTTP_BAD_REQUEST);
        }

    }

    /**
     * actualiza un tipo actuacion
     * @param Request $request
     * @return Response $tipoRequerimiento
     * @author Manuela
     */

    public function actualizar(ActualizarTipoActuacionRequest $request, int $id): JsonResponse
    {
        try {
            $tipoActuacion = $this->tipoActuacionRepository->buscar($id);
            $tipoActuacion->fill($request->validated());
            $this->tipoActuacionRepository->guardar($tipoActuacion);
            return response()->json([
                'mensaje' => 'La actuación fue actualizada con exito!'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al actualizar la actuacion.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
