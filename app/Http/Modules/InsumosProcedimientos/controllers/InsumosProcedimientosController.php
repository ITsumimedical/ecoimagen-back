<?php

namespace App\Http\Modules\InsumosProcedimientos\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\InsumosProcedimientos\Repositories\InsumosProcedimientosRepository;
use App\Http\Modules\InsumosProcedimientos\Request\CrearInsumoProcedimientosRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InsumosProcedimientosController extends Controller
{

    public function __construct(protected InsumosProcedimientosRepository $insumosRepository)
    {
    }

    public function crear(CrearInsumoProcedimientosRequest $request)
    {
        try {
            $this->insumosRepository->crear($request->validated());
            return response()->json([
                'mensaje' => 'El insumo fue registrado con exito.'
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al registrar el insumo de medicamento',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarInsumos($consulta_id)
    {
        try {
            $insumos  =  $this->insumosRepository->insumoProcedimiento($consulta_id);
            return response()->json($insumos, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al registrar el insumo de medicamento',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function eliminarInsumo($id)
    {
        try {
            $insumo = $this->insumosRepository->eliminarInsumo($id);
            return response()->json($insumo, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al registrar el insumo de medicamento',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizarProcedimiento(Request $request)
    {
        try {
            $procedimiento = $this->insumosRepository->actualizarProcedimiento($request);
            return response()->json($procedimiento, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al registrar el insumo de medicamento',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
