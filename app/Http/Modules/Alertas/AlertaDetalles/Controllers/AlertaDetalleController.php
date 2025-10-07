<?php

namespace App\Http\Modules\Alertas\AlertaDetalles\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Alertas\AlertaDetalles\Repositories\AlertaDetalleRepository;
use App\Http\Modules\Alertas\AlertaDetalles\Request\ActualizarAlertaDetalleRequest;
use App\Http\Modules\Alertas\AlertaDetalles\Request\CrearAlertaDetalleRequest;
use Illuminate\Http\Request;

class AlertaDetalleController extends Controller
{
    public function __construct(
        private AlertaDetalleRepository $alertasRepository,
    ) {
    }

    public function crearAlertaDetalle(CrearAlertaDetalleRequest $request)
    {
        try {
            $this->alertasRepository->crear($request->validated());
            return response()->json([
                'mensaje' => 'Alerta de medicamento creada con éxito'
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function historialAlerta($idAlerta)
    {
        try {
            $historial = $this->alertasRepository->historial($idAlerta);
            return response()->json($historial);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function cambiarEstado(Request $request, $id)
    {
        try {
            $alerta = $this->alertasRepository->cambiarEstado($id);
            return response()->json(['message' => 'Estado de la alerta cambiado exitosamente', $alerta], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function actualizar(ActualizarAlertaDetalleRequest $request, $id)
    {

        try {
            $alertaDetalles = $this->alertasRepository->actualizar($request->validated(), $id);
            return response()->json(['message' => 'Alerta actualizada con éxito', $alertaDetalles], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
