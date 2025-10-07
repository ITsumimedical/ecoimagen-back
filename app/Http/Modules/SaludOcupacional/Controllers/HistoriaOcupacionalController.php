<?php

namespace App\Http\Modules\SaludOcupacional\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\SaludOcupacional\Repositories\HistoriaOcupacionalRepository;
use Illuminate\Http\Response;

class HistoriaOcupacionalController extends Controller
{

    public function __construct(protected HistoriaOcupacionalRepository $historiaOcupacionalRepository)
    {

    }

    public function guardarMotivo(Request $request)
    {
        try {
            $this->historiaOcupacionalRepository->guardarHistoriaOcupacional($request);
            return response()->json([
                'mensaje' => 'Motivo de consulta guardado con exito.'
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al guardar el motivo de consulta.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function consultarMotivo(Request $request) {
        try {
            $motivoOcuoacional = $this->historiaOcupacionalRepository->consultarMotivoOcupacional($request->consulta_id);
            return response()->json($motivoOcuoacional, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar motivo de consulta ocupacional.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function guardarAntecedentesOcupacionales(Request $request) {
        return $request->all();
    }

    public function guardarHabitos(Request $request) {
        return $request->all();
    }

    public function guardarRevisionPorSistemas(Request $request) {
        return $request->all();
    }

    public function guardarCondicionesSalud(Request $request) {
        return $request->all();
    }

    public function guardarExamenFisico(Request $request) {
        return $request->all();
    }

    public function guardarConceptoOcupacional(Request $request) {
        return $request->all();
    }

    public function listar($solicitud,$estado,$bodega)
    {
    }
}
