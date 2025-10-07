<?php

namespace App\Http\Modules\AsistenciaEducativa\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Http\Modules\AsistenciaEducativa\Models\AsistenciaEducativa;
use App\Http\Modules\AsistenciaEducativa\Services\AsistenciaEducativaService;
use App\Http\Modules\AsistenciaEducativa\Requests\CrearAsistenciaEducativaRequest;
use App\Http\Modules\AsistenciaEducativa\Repositories\AsistenciaEducativaRepository;
use Illuminate\Http\Client\Request as ClientRequest;

class asistenciaEducativaController extends Controller

{

    public function __construct(
        private AsistenciaEducativaRepository $asistenciaEducativaRepository,
        private AsistenciaEducativaService $asistenciaEducativaService
    ) {
    }

    /**
     * listar las asistencias educativas
     *
     * @param  mixed $request
     * @author Serna
     */
    public function listar(Request $request)
    {
        try {
            $asistencia = $this->asistenciaEducativaRepository->listarAsistencia($request);
            return response()->json($asistencia, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para crear una asistencia educativa
     *
     * @param  mixed $request
     * @return JsonResponse
     * @author Serna
     */
    public function crear(Request $request): JsonResponse
    {
        try {
            $this->asistenciaEducativaService->crearAsistencia($request->all());
            return response()->json([
                'message' => 'Se ha registrado la asistencia educativa correctamente.',
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error al crear la asistencia educativa'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion que valida si hay datos para descargar
     *
     * @param  mixed $request
     * @return void
     */
    public function verificarDatos(Request $request)
    {
        $fechaInicial = Carbon::parse($request->input('fechaInicial'));
        $fechaFinal = Carbon::parse($request->input('fechaFinal'));
        try {
            $datos = AsistenciaEducativa::whereBetween('fecha', [$fechaInicial, $fechaFinal])->get();
            if ($datos->isEmpty()) {
                return response()->json([
                    "mensaje" => "No hay registros de asistencia en el rango de fechas ingresado",
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
     * Funcion que descarga el reporte
     *
     * @param  mixed $request
     * @return void
     */
    public function reporteAsistencia(Request $request)
    {
        $asistencia = Collect(DB::select('exec dbo.SP_AsistenciasEducativas ?,?', [$request->fechaInicial, $request->fechaFinal]));
        $array = json_decode($asistencia, true);
        return (new FastExcel($array))->download('ReporteAsistencias.xls');
    }
}
