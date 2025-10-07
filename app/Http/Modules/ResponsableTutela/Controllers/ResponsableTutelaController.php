<?php

namespace App\Http\Modules\ResponsableTutela\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\ResponsableTutela\Repositories\ResponsableTutelaRespository;
use App\Http\Modules\ResponsableTutela\Requests\ActualizarResponsableTutelaRequest;
use App\Http\Modules\ResponsableTutela\Requests\GuardarResponsableTutelaRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class ResponsableTutelaController extends Controller
{
    private $ResponsableRepository;

    public function __construct(ResponsableTutelaRespository $ResponsableRepository) {
        $this->ResponsableRepository = $ResponsableRepository;
    }


    /**
     * listar los responsables
     * @param Request $request
     * @return Response $responsable
     * @author kobatime
     */
    public function listar(Request $request)
    {
        try {
            $responsable = $this->ResponsableRepository->listarReponsable($request);
            return response()->json($responsable, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                $th->getMessage(),
                'mensaje' => 'Error al recuperar los responsables',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * guardar el responsable
     * @param Request $request
     * @return Response $responsable
     * @author kobatime
     */
    public function guardar(GuardarResponsableTutelaRequest $request): JsonResponse
    {
        try {
            $responsable = $this->ResponsableRepository->crear($request->validated());
            return response()->json([
                'res' => true,
                'data' => $responsable
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al guardar el responsable',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualizar el responsable
     * @param Request $request
     * @return Response $responsableUpdate
     * @author kobatime
     */
    public function actualizar(ActualizarResponsableTutelaRequest $request, int $id)
    {
        try {
            $responsableTutelas = $this->ResponsableRepository->buscar($id);
            $responsableTutelas->fill($request->all());
            $responsableUpdate = $this->ResponsableRepository->guardar($responsableTutelas);
            return response()->json([
                'res' => true,
                'mensaje' => 'Actualizado con exito!.'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al actualizar el responsable',
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Actualiza el estado
     * @param Request $request
     * @param int $id
     * @return Response
     * @author kobatime
     */
    public function actualizarEstado(ActualizarResponsableTutelaRequest $request, int $id): JsonResponse
    {
        try {
            $responsableTutelas = $this->ResponsableRepository->buscar($id);
            $responsableTutelas->fill($request->all());
            $actualizarResponsable = $this->ResponsableRepository->guardar($responsableTutelas);
            return response()->json([
                'res' => true,
                'data' => $actualizarResponsable,
                'mensaje' => 'El responsable fue actualizada con exito!'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al intentar actualizar el responsable!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
