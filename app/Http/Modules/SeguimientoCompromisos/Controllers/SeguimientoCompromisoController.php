<?php

namespace App\Http\Modules\SeguimientoCompromisos\Controllers;

use App\Http\Modules\SeguimientoCompromisos\Repositories\SeguimientoCompromisoRepository;
use App\Http\Modules\SeguimientoCompromisos\Services\SeguimientoCompromisoService;
use App\Http\Modules\SeguimientoCompromisos\Requests\CrearSeguimientoCompromisoRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SeguimientoCompromisoController extends Controller
{
    protected $repository;
    protected $service;

    public function __construct(){
        $this->repository = new SeguimientoCompromisoRepository;
        $this->service = new SeguimientoCompromisoService;
    }

    /**
     * lista Seguimientos de los compromisos
     * @param Request $request
     * @return Response
     * @author kobatime
     */
    public function listar($id): JsonResponse
    {
        $seguimiento = $this->repository->listarSeguimiento($id);
        try {
            return response()->json([
                'res' => true,
                'data' => $seguimiento
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los seguimiento',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un seguimiento
     * @param Request $request
     * @return Response
     * @author kobatime
     */
    public function crear(CrearSeguimientoCompromisoRequest $request,$id):JsonResponse{
        try {
            $seguimiento = $this->service->prepararData($request->validated(),$id);
            $nuevoSeguimiento = $this->repository->crear($seguimiento);
            return response()->json([
                'res' => true,
                'data' => $nuevoSeguimiento
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al guardar el seguimiento',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function finalizarSeguimiento($id){
        try {
            $seguimiento = $this->service->cambiarEstado($id);
            $actualizarSeguimiento = $this->repository->guardar($seguimiento);
            return response()->json([
                'res' => true,
                'data' => $seguimiento
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al actualizar el seguimiento',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

}
