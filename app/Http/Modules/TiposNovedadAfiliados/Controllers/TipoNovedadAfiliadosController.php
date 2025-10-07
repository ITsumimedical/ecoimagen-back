<?php

namespace App\Http\Modules\TiposNovedadAfiliados\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\TiposNovedadAfiliados\Models\tipoNovedadAfiliados;
use App\Http\Modules\TiposNovedadAfiliados\Requests\CrearTipoNovedadAfiliadosRequest;
use App\Http\Modules\TiposNovedadAfiliados\Repositories\TipoNovedadAfiliadosRepository;
use App\Http\Modules\TiposNovedadAfiliados\Requests\ActualizarEstadoTipoNovedadAfiliadosRequest;
use App\Http\Modules\TiposNovedadAfiliados\Requests\ActualizarTipoNovedadAfiliadosRequest;

class TipoNovedadAfiliadosController extends Controller
{
    private $tipoNovedadespository;

    public function __construct(TipoNovedadAfiliadosRepository $tipoNovedadespository){
        $this->tipoNovedadespository = $tipoNovedadespository;
    }

    /**
     * lista los tipo novedades
     * @param Request $request
     * @return Response
     * @author kobatime
     */
    public function listar(Request $request)
    {
        try {
            $tipoAfiliacon = $this->tipoNovedadespository->listar($request);
            return response()->json([
                'res' => true,
                'data' => $tipoAfiliacon,
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar tipos de novedades',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un tipo Novedad
     * @param Request $request
     * @return Response
     * @author kobatime
     */
    public function crear(CrearTipoNovedadAfiliadosRequest $request): JsonResponse
    {
        try {
            $nuevoTipoNovedad = $this->tipoNovedadespository->crear($request->validated());
            return response()->json([
                'res' => true,
                'data' => $nuevoTipoNovedad,
                'mensaje' => 'Tipo novedad se ha creado con exito!',
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al crear tipo de novedad!',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizar(ActualizarTipoNovedadAfiliadosRequest $request, int $id): JsonResponse
    {
        try {
            $tipoNovedad = $this->tipoNovedadespository->buscar($id);
            $tipoNovedad->fill($request->all());

            $actualizartipoNovedad = $this->tipoNovedadespository->guardar($tipoNovedad);

            return response()->json([
                'res' => true,
                'data' => $actualizartipoNovedad,
                'mensaje' => 'Tipo novedad actualizada con exito!.'
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al actualizar el tipo de novedad'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizarEstado(ActualizarEstadoTipoNovedadAfiliadosRequest $request, int $id): JsonResponse
    {
        try {
            $tipoNovedad = $this->tipoNovedadespository->buscar($id);
            $tipoNovedad->fill($request->all());

            $actualizartipoNovedad = $this->tipoNovedadespository->guardar($tipoNovedad);

            return response()->json([
                'res' => true,
                'data' => $actualizartipoNovedad,
                'mensaje' => 'Tipo novedad actualizada con exito!.'
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al actualizar el tipo de novedad'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

}
