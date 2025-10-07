<?php

namespace App\Http\Modules\BarreraAccesos\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\BarreraAccesos\Repositories\AreaResponsableRepository;
use App\Http\Modules\BarreraAccesos\Requests\AreaResponsableRequest;
use App\Http\Modules\BarreraAccesos\Services\AreaResponsableService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AreaResponsableController extends Controller
{
    public function __construct(protected AreaResponsableService $areaResponsableService, protected AreaResponsableRepository $areaResponsableRepository) {}

    /**
     * Listar todas las areas responsables
     * @param Request $request
     * @return Response
     * @author Sofia O
     */
    public function listarAreaResponsable(Request $request)
    {
        try {
            $Arearesponsables = $this->areaResponsableService->listar($request->all());
            return response()->json($Arearesponsables, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Hubo un error al listar las areas responsables'
            ] . Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Listar las areas responsables activas
     * @param Request $request
     * @return Response
     * @author Sofia O
     */
    public function listarAreaResponsableActivas(Request $request)
    {
        try {
            $Arearesponsables = $this->areaResponsableRepository->listarActivas($request->all());
            return response()->json($Arearesponsables, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Hubo un error al listar las areas responsables activas'
            ] . Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Crear area responsable
     * @param AreaResponsableRequest $request
     * @return Response
     * @author Sofia O
     */
    public function crearAreaResponsable(AreaResponsableRequest $request)
    {
        try {
            $crearResponsable = $this->areaResponsableService->crear($request->validated());
            return response()->json($crearResponsable, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Hubo un error al crear'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualizar area responsable
     * @param AreaResponsableRequest $request
     * @return Response
     * @author Sofia O
     */
    public function actualizarAreaResponsable(AreaResponsableRequest $request, $id)
    {
        try {
            $actualizar = $this->areaResponsableService->actualizar($request->validated(), $id);
            return response()->json($actualizar, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Hubo un error al actualizar'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Cambiar estado area responsable
     * @param $id
     * @return Response
     * @author Sofia O
     */
    public function cambiarEstadoAreaResponsable($id)
    {
        try {
            $cambiarEstado = $this->areaResponsableService->cambiarEstado($id);
            return response()->json($cambiarEstado, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Hubo un error al cambiar el estado'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
