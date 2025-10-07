<?php

namespace App\Http\Modules\TipoAfiliados\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\TipoAfiliados\Models\TipoAfiliado;
use App\Http\Modules\TipoAfiliados\Requests\CrearTipoAfiliadoRequest;
use App\Http\Modules\TipoAfiliados\Repositories\TipoAfiliadoRepository;
use App\Http\Modules\TipoAfiliados\Requests\ActualizarTipoAfiliadoRequest;
use App\Http\Modules\TipoAfiliados\Services\TipoAfiliadoService;

class TipoAfiliadoController extends Controller
{
    protected $tipoAfiliadoRepository;
    protected $tipoAfiliadoService;

    public function __construct() {
        $this->tipoAfiliadoRepository = new TipoAfiliadoRepository();
        $this->tipoAfiliadoService = new TipoAfiliadoService();
    }

    /**
     * lista los tipos de afiliados
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request)
    {
        try {
            return response()->json([
                $tipoAfiliado = $this->tipoAfiliadoRepository->listar($request),
                'res' => true,
                'data' => $tipoAfiliado
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar los tipos de afiliados',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Crear un tipo de afiliado
     * @param Request $request
     * @return Response
     * @author kobatime
     */
    public function crear(CrearTipoAfiliadoRequest $request): JsonResponse
    {
        try {
            // se usa servicio para añadir el usuario quien crear el tipo de afiliado
            $nuevoTipoAfiliado = $this->tipoAfiliadoService->prepararData($request->validated());
            //se envia la data a repository
            $tipoAfiliado = $this->tipoAfiliadoRepository->crear($nuevoTipoAfiliado);
            return response()->json([
                'res' => true,
                $tipoAfiliado,
                'mensaje' => 'Tipo de afiliado creada con exito!.',
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al crear el tipo de afiliado',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualizar un tipo de afiliado
     * @param Request $request
     * @return Response
     * @author kobatime
     */
    public function actualizar(CrearTipoAfiliadoRequest $request, int $id): JsonResponse
    {
        try {
            // se busca el tipo de afliado
            $tipoAfiliado = $this->tipoAfiliadoRepository->buscar($id);
            // se realiza una comparacion de los datos
            $tipoAfiliado->fill($request->all());
            // se envia los datos al repositorio
            $actualizartipoAfiliado = $this->tipoAfiliadoRepository->guardar($tipoAfiliado);

            return response()->json([
                'res' => true,
                $actualizartipoAfiliado,
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
     * Actualizar el estado del tipo de afiliado
     * @param Request $request
     * @return Response
     * @author kobatime
     */
    public function actualizarEstado(ActualizarTipoAfiliadoRequest $request, int $id): JsonResponse
    {
        try {
            // se busca el tipo de afliado
            $tipoAfiliado = $this->tipoAfiliadoRepository->buscar($id);
            // se realiza una comparacion de los datos
            $tipoAfiliado->fill($request->all());
            // se envia los datos al repositorio
            $actualizartipoAfiliado = $this->tipoAfiliadoRepository->guardar($tipoAfiliado);

            return response()->json([
                'res' => true,
                $actualizartipoAfiliado,
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
