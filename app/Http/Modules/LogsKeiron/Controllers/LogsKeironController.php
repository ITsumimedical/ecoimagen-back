<?php

namespace App\Http\Modules\LogsKeiron\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\LogsKeiron\Requests\ActualizarKeironRequest;
use App\Http\Modules\LogsKeiron\Services\KeironService;
use App\Http\Modules\LogsKeiron\Services\LogsKeironService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LogsKeironController extends Controller
{
    public function __construct(protected KeironService $keironService)
    {
    }

    public function cambiarEstadoKeiron(ActualizarKeironRequest $request, int $transitionId, int $consultaId)
    {
        try {
            $cambiarKeiron = $this->keironService->cambiarEstadoApiKeiron($request->validated(), $transitionId, $consultaId);
            return response()->json($cambiarKeiron, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Ha ocurrido un error al cambiar el estado del Keiron'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizarConsulta($id, ActualizarKeironRequest $request)
    {
        try {
            return $this->keironService->cambiarEstadoHorus($id, $request->validated());
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Ha ocurrido un error al cambiar el estado',
                'error' => $th->getMessage(),
            ], $th->getCode() >= 100 && $th->getCode() < 600 ? $th->getCode() : 500);
        }
    }

    public function envioMasivoConsulta(Request $request)
    {
        try {
            return $this->keironService->masivoConsultas($request->all());
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Ha ocurrido un error al consultar las citas',
                'error' => $th->getMessage(),
            ], $th->getCode() >= 100 && $th->getCode() < 600 ? $th->getCode() : 500);
        }
    }

    public function envioMasivoCanceladas(): JsonResponse
    {
        try {
            $masivoCanceladas = $this->keironService->masivoCanceladasPendientes();
            return response()->json($masivoCanceladas, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Ha ocurrido un error al consultar las citas',
                'error' => $th->getMessage(),
            ], $th->getCode() >= 100 && $th->getCode() < 600 ? $th->getCode() : 500);
        }
    }
}
