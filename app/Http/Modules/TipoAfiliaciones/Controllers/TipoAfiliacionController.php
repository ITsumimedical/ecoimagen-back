<?php

namespace App\Http\Modules\TipoAfiliaciones\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\TipoAfiliaciones\Models\TipoAfiliacion;
use App\Http\Modules\TipoAfiliaciones\Repositories\TipoAfiliacionRepository;
use App\Http\Modules\TipoAfiliaciones\Requests\ActualizarTipoAfiliacionRequest;
use App\Http\Modules\TipoAfiliaciones\Requests\CrearTipoAfiliacionRequest;
use App\Http\Modules\TipoAfiliaciones\Services\TipoAfiliacionService;


class TipoAfiliacionController extends Controller
{
    protected $tipoAfiliacionRepository;
    protected $tipoAfiliacionService;

    public function __construct() {
        $this->tipoAfiliacionRepository = new TipoAfiliacionRepository();
        $this->tipoAfiliacionService = new TipoAfiliacionService();
    }

    /**
     * lista los tipos de afiliaciones
     * @param Request $request
     * @return Response
     * @author kobatime
     */
    public function listar(Request $request)
    {
        try {
            return response()->json([
                $tipoAfiliacion = $this->tipoAfiliacionRepository->listar($request),
                'res' => true,
                'data' => $tipoAfiliacion
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al recuperar los tipos de afilicion',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Crear un tipo de Afiliacion
     * @param Request $request
     * @return Response
     * @author kobatime
     */
    public function crear(CrearTipoAfiliacionRequest $request): JsonResponse
    {
        try {
            // se usa servicio para añadir el usuario quien crear el tipo de afiliado
            $nuevoTipoAfiliacion = $this->tipoAfiliacionService->prepararData($request->validated());
            //se envia la data a repository
            $tipoAfiliacion = $this->tipoAfiliacionRepository->crear($nuevoTipoAfiliacion);
            return response()->json([
                'res' => true,
                $tipoAfiliacion,
                'mensaje' => 'Tipo de afiliacion creadao con exito!.',
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al crear el tipo de afiliacion',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un tipo de Afiliacion
     * @param Request $request
     * @param Int $id
     * @return Response
     * @author kobatime
     */
    public function actualizar(CrearTipoAfiliacionRequest $request, int $id): JsonResponse
    {
        try {
            // se busca el tipo de afliado
            $tipoAfiliacion = $this->tipoAfiliacionRepository->buscar($id);
            // se realiza una comparacion de los datos
            $tipoAfiliacion->fill($request->all());
            // se envia los datos al repositorio
            $actualizartipoAfiliacion = $this->tipoAfiliacionRepository->guardar($tipoAfiliacion);
            return response()->json([
                'res' => true,
                $actualizartipoAfiliacion,
                'mensaje' => 'Tipo afiliado actualizado con exito!.'
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al actualizar el tipo de afiliado'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualizar estado un tipo de Afiliacion
     * @param Request $request
     * @param Int $id
     * @return Response
     * @author kobatime
     */
    public function actualizarEstado(ActualizarTipoAfiliacionRequest $request, int $id): JsonResponse
    {
        try {
            // se busca el tipo de afliado
            $tipoAfiliacion = $this->tipoAfiliacionRepository->buscar($id);
            // se realiza una comparacion de los datos
            $tipoAfiliacion->fill($request->all());
            // se envia los datos al repositorio
            $actualizartipoAfiliacion = $this->tipoAfiliacionRepository->guardar($tipoAfiliacion);
            return response()->json([
                'res' => true,
                $actualizartipoAfiliacion,
                'mensaje' => 'Tipo afiliado actualizado con exito!.'
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al actualizar el tipo de afiliado'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
