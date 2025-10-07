<?php

namespace App\Http\Modules\TurnosTH\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Http\Modules\TurnosTH\Models\TurnoTh;
use App\Http\Modules\TurnosTH\Requests\CrearTurnoThRequest;
use App\Http\Modules\TurnosTH\Repositories\TurnoThRepository;
use App\Http\Modules\TurnosTH\Requests\ActualizarTurnoThRequest;

class TurnoThController extends Controller
{
    private $turnoThRepository;

    public function __construct(){
        $this->turnoThRepository = new TurnoThRepository;
    }

    /**
     * lista los turnos de talento humano
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request): JsonResponse
    {
        $turnoTh = $this->turnoThRepository->listar($request);
        try {
            return response()->json([
                'res' => true,
                'data' => $turnoTh
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los turnos de talento humano',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un turno de talento humano
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearTurnoThRequest $request):JsonResponse{
        try {
            $turnoTh = $this->turnoThRepository->crear($request->validated());
            return response()->json($turnoTh, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza un turno talento humano
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizar(ActualizarTurnoThRequest $request, TurnoTh $id){
        try {
            $this->turnoThRepository->actualizar($id, $request->validated());
            return response()->json([]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(),400);
        }
    }

    /**
     * exportar - exporta excel con los datos del modelo
     *
     * @return void
     */
    public function exportar(){
        return (new FastExcel(TurnoTh::all()))->download('file.xlsx');
    }
}
