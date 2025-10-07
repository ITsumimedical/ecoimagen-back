<?php

namespace App\Http\Modules\GestionOrdenPrestador\Controllers;

use App\Http\Modules\GestionOrdenPrestador\Repositories\GestionOrdenPrestadorRepository;
use App\Http\Modules\GestionOrdenPrestador\Requests\ReporteOrdenesRequest;
use App\Http\Modules\Reps\Models\ParametrizacionCupPrestador;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;

class GestionOrdenPrestadorController extends Controller
{


    public function __construct(private GestionOrdenPrestadorRepository $gestionOrdenPrestadorRepository)
    {
    }

    public function enviarDetalle(Request $request)
    {
        try {
            $this->gestionOrdenPrestadorRepository->enviarDetalle($request->all());
            return response()->json([
                'message' => 'Orden gestionada correctamente',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'error' => $th
            ], 400);
        }
    }

    public function listarGestionPrestador(Request $request)
    {
        try {
            $gestion = $this->gestionOrdenPrestadorRepository->listarGestionPrestador($request->all());
            return response()->json($gestion);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function reporteGestionPrestador(ReporteOrdenesRequest $request)
    {
        try {
            $reporte = $this->gestionOrdenPrestadorRepository->reporteOrdenesPrestadores($request->validated());
            return (new FastExcel($reporte))->download('ReporteAsistencias.xls');
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }
}
