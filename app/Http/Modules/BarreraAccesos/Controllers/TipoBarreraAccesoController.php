<?php

namespace App\Http\Modules\BarreraAccesos\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\BarreraAccesos\Repositories\TipoBarrearAccesoRepository;
use App\Http\Modules\BarreraAccesos\Requests\TipoBarrearAccesoRequest;
use App\Http\Modules\BarreraAccesos\Services\TipoBarreraAccesoService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TipoBarreraAccesoController extends Controller
{
    public function __construct(protected TipoBarreraAccesoService $tipoBarreraAccesoService, protected TipoBarrearAccesoRepository $tipoBarrearAccesoRepository) {}

    /**
     * Listar todos los tipos de barreras acceso
     * @param Request $request
     * @return Response
     * @author Sofia O
     */
    public function listarTiposBarrerasAcceso(Request $request)
    {
        try {
            $tipos = $this->tipoBarreraAccesoService->listar($request->all());
            return response()->json($tipos, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Hubo un error al listar los tipos de barreras acceso'
            ] . Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Listar los tipos de barreras activos
     * @return Response
     * @author Sofia O
     */
    public function listarTiposBarrerasAccesoActivos()
    {
        try {
            $tipos = $this->tipoBarrearAccesoRepository->listarActivos();
            return response()->json($tipos, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Hubo un error al listar los tipos de barreras acceso'
            ] . Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Crear tipo de barrera
     * @param TipoBarrearAccesoRequest $request
     * @return Response
     * @author Sofia O
     */
    public function crearTiposBarrerasAcceso(TipoBarrearAccesoRequest $request)
    {
        try {
            $crear = $this->tipoBarrearAccesoRepository->crearTipo($request->validated());
            return response()->json($crear . Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Hubo un error al crear el tipo'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualizar tipo de barrera
     * @param TipoBarrearAccesoRequest $request
     * @return Response
     * @author Sofia O
     */
    public function actualizarTiposBarrerasAcceso(TipoBarrearAccesoRequest $request, $id)
    {
        try {
            $actualizar = $this->tipoBarreraAccesoService->actualizar($request->validated(), $id);
            return response()->json($actualizar, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Hubo un error al actualizar el tipo de barrera acceso'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Cambiar estado tipo de barrera
     * @param $id
     * @return Response
     * @author Sofia O
     */
    public function cambiarEstadoTiposBarrerasAcceso($id)
    {
        try {
            $cambiarEstado = $this->tipoBarreraAccesoService->cambiarEstado($id);
            return response()->json($cambiarEstado, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Hubo un error al cambiar el estado'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
