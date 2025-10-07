<?php

namespace App\Http\Modules\BarreraAccesos\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\BarreraAccesos\Repositories\ResponsableRepository;
use App\Http\Modules\BarreraAccesos\Requests\ResponsableRequest;
use App\Http\Modules\BarreraAccesos\Services\ResponsableService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ResponsableController extends Controller
{
    public function __construct(protected ResponsableService $responsableService, protected ResponsableRepository $responsableRepository) {}

    /**
     * Listar todas los responsables
     * @param Request $request
     * @return Response
     * @author Sofia O
     */
    public function listarResponsable(Request $request)
    {
        try {
            $responsables = $this->responsableService->listar($request->all());
            return response()->json($responsables, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Hubo un error al listar los responsables'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Listar los responsables activos
     * @param Request $request
     * @return Response
     * @author Sofia O
     */
    public function listarResponsableActivos(Request $request)
    {
        try {
            $responsables = $this->responsableRepository->listarActivos($request->all());
            return response()->json($responsables, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Hubo un error al listar los responsables activos'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Crear responsable
     * @param ResponsableRequest $request
     * @return Response
     * @author Sofia O
     */
    public function crearResponsable(ResponsableRequest $request)
    {
        try {
            $crear = $this->responsableRepository->crearResponsable($request->validated());
            return response()->json($crear . Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Hubo un error al crear'
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Actualizar responsable
     * @param ResponsableRequest $request
     * @return Response
     * @author Sofia O
     */
    public function actualizarResponsable(ResponsableRequest $request, $id)
    {
        try {
            $actualizar = $this->responsableService->actualizar($request->validated(), $id);
            return response()->json($actualizar, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Hubo un error al actualizar'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Cambiar del responsable
     * @param $id
     * @return Response
     * @author Sofia O
     */
    public function cambiarEstadoResponsable($id)
    {
        try {
            $cambiarEstado = $this->responsableService->cambiarEstado($id);
            return response()->json($cambiarEstado, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Hubo un error al cambiar el estado'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * listar los responsables por area a la cual pertenece
     * @param $id
     * @return Response
     * @author Sofia O
     */
    public function responsablesPorArea($id)
    {
        try {
            $responsablesArea = $this->responsableRepository->buscarResponsableArea($id);
            return response()->json($responsablesArea, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Hubo un error al listar los responsables por area'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
