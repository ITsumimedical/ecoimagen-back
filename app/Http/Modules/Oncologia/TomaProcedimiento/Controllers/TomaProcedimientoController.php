<?php

namespace App\Http\Modules\Oncologia\TomaProcedimiento\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Oncologia\TomaProcedimiento\Models\TomaProcedimiento;
use App\Http\Modules\Oncologia\TomaProcedimiento\Services\TomaMuestraService;
use App\Http\Modules\Oncologia\TomaProcedimiento\Request\TomaProcedimientoRequest;
use App\Http\Modules\Oncologia\TomaProcedimiento\Repositories\TomaProcedimientoRepository;


class TomaProcedimientoController extends Controller
{
    public function __construct(protected TomaProcedimientoRepository $TomaProcedimientoRepository,
                                protected TomaMuestraService $tomaMuestraService) {
    }
    public function listar()
    {
        try {
            $procedimientosPendientes = $this->TomaProcedimientoRepository->listarTomaProcedimientosPendientes();
            return response()->json([
                'listarTomaProcedimientosPendientes' => $procedimientosPendientes
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al consultar la toma de procedimientos',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);

        }
    }

    public function crear(TomaProcedimientoRequest $request):JsonResponse
    {
        try {
            $Toma_Procedimiento = $this->tomaMuestraService->registrar($request->validated());
            return response()->json([
                'oe' => $Toma_Procedimiento,
                'mensaje' => 'Se registro toma de procedimiento con exito.'
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al crear la toma de procedimientos',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizar(TomaProcedimientoRequest $request, TomaProcedimiento $id){
        try {
            $this->TomaProcedimientoRepository->actualizar($id, $request->validated());
            return response()->json([
                'mensaje' => 'Toma de procedimientos actualizada con exito'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                $th->getMessage(),
                'mensaje' => 'Error al actualizar la toma de procedimientos'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function contador() {
        try {
            $contadorPediente = $this->TomaProcedimientoRepository->contadorPendientes();
            $contadorPendienteOrdenamiento = $this->TomaProcedimientoRepository->contadorPendienteOrdenamiento();
            $contadorSeguimiento = $this->TomaProcedimientoRepository->contadorSeguimiento();
            $contadorTomaMuestra = $this->TomaProcedimientoRepository->contadorTomaMuestra();
            return response()->json([
                'contadorPendientes' => $contadorPediente,
                'contadorPendienteOrdenamiento' => $contadorPendienteOrdenamiento,
                'contadorSeguimiento' => $contadorSeguimiento,
                'contadorTomaMuestra' => $contadorTomaMuestra
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al contantar los pendiente.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarPendientesPorCita()
    {
        try {
            $procedimientosPendientes = $this->TomaProcedimientoRepository->listarTomaProcedimientosPendientesCita();
            return response()->json([
                'listarTomaProcedimientosPendientes' => $procedimientosPendientes
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al consultar la toma de procedimientos',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);

        }
    }

    public function actualizarEstado(Request $request){
        try {
            $toma = $this->TomaProcedimientoRepository->actualizarEstado($request->toma_id);
            return response()->json($toma, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al actualizar la toma de procedimientos',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);

        }
    }

    public function eliminar(TomaProcedimiento $id)
    {
        try {
            $this->TomaProcedimientoRepository->eliminar($id);
            return response()->json([
                'mensaje' => 'Toma de procedimientos eliminada con exito'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                $th->getMessage(),
                'mensaje' => 'Error al eliminar la toma de procedimientos'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarTomaMuestra()
    {
        try{
           $tomaProcedimientos = $this->TomaProcedimientoRepository->listarTomaMuestrasRealizadas();
           return response()->json($tomaProcedimientos);
        }catch (\Throwable $th) {
            return response()->json([
                $th->getMessage(),
                'mensaje' => 'Error al listar la toma de procedimientos'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

}
