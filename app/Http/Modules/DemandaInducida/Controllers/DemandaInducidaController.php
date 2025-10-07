<?php

namespace App\Http\Modules\DemandaInducida\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\DemandaInducida\Models\DemandaInducida;
use App\Http\Modules\DemandaInducida\Repositories\DemandaInducidaRepository;
use App\Http\Modules\DemandaInducida\Requests\DemandaInducidaRequest;
use App\Http\Modules\DemandaInducida\Services\DemandaInducidaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;

class DemandaInducidaController extends Controller
{
    public function __construct(
        protected DemandaInducidaRepository $demandaInducidaRepository,
        protected DemandaInducidaService $demandaInducidaService
    ) {
    }

    /**
     * Crear una demanda inducida
     *
     * @param  mixed $request
     * @return JsonResponse
     * @author Edwing
     */
    public function crear(DemandaInducidaRequest $request): JsonResponse
    {
        try {
            $demanda = $this->demandaInducidaService->guardarDemandaInducida($request->validated());
            return response()->json($demanda);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al crear la demanda inducida.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Listar todas las demandas inducidas
     *
     * @return JsonResponse
     * @author Edwing
     */
    public function listar(Request $request)
    {
        try {
            $demandasInducidas = $this->demandaInducidaRepository->listarDemandaInducida($request->all());
            return response()->json($demandasInducidas, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'Mensaje' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Verificar datos de demandas inducidas por rango de fechas
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function verificarDatos(Request $request)
    {
        $fechaInicial = Carbon::parse($request->input('fechaInicial'));
        $fechaFinal = Carbon::parse($request->input('fechaFinal'));
        try {
            $datos = DemandaInducida::whereBetween('fecha_registro', [$fechaInicial, $fechaFinal])->get();
            if ($datos->isEmpty()) {
                return response()->json([
                    "mensaje" => "No hay registros de demanda inducida en el rango de fechas ingresado",
                ], Response::HTTP_NO_CONTENT);
            }

            return response()->json($datos, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                "mensaje" => "Ocurrio un error al buscar los datos"
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Descargar reporte de demandas inducidas
     *
     * @param  Request $request
     * @return void
     */
    public function reporteDemandaInducida(Request $request)
    {
        $demanda = Collect(DB::select('exec dbo.SP_DemandaInducidaCitas ?,?', [$request->fechaInicial, $request->fechaFinal]));
        $array = json_decode($demanda, true);
        return (new FastExcel($array))->download('ReporteDemandaInducida.xls');
    }

    /**
     * Asignar una cita a una demanda inducida
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function asignarCitaDemandaInducida(Request $request): JsonResponse
    {
        try {
            $this->demandaInducidaRepository->asignarCitaDemandaInducida($request->id, $request->consulta_id);
            return response()->json(['mensaje' => 'Cita Registrada!'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al asignar la cita a la demanda inducida.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function eliminarDemandaInducida(Request $request)
    {
        try {
            $complemento = $this->demandaInducidaRepository->eliminarDemandaInducida($request);
            return response()->json($complemento, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al eliminar la demanda inducida',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
