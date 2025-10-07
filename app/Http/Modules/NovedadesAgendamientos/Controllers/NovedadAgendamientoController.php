<?php

namespace App\Http\Modules\NovedadesAgendamientos\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\NovedadesAgendamientos\Models\NovedadAgendamiento;
use App\Http\Modules\NovedadesAgendamientos\Repositories\NovedadAgendamientoRepository;
use App\Http\Modules\NovedadesAgendamientos\Requests\CrearNovedadAgendamientoRequest;
use App\Http\Modules\NovedadesAgendamientos\Requests\ActualizarNovedadAgendamientoRequest;

class NovedadAgendamientoController extends Controller
{
    private $novedadAgendamientoRepository;

    public function __construct(){
        $this->novedadAgendamientoRepository = new NovedadAgendamientoRepository;
    }

    /**
     * lista las novedades de agendamiento
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request)
    {
        try {
            return response()->json([
                $novedadAgendamiento = $this->novedadAgendamientoRepository->listar($request),
                'res' => true,
                'data' => $novedadAgendamiento
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar las novedades de agendamiento',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda una novedad de agendamiento
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearNovedadAgendamientoRequest $request):JsonResponse
    {
        try {
            $nuevaNovedadAgendamiento = new NovedadAgendamiento($request->all());
            $novedadAgendamiento = $this->novedadAgendamientoRepository->guardar($nuevaNovedadAgendamiento);
            return response()->json([
                'res' => true,
                'data' => $novedadAgendamiento,
                'mensaje' => 'Novedad de agendamiento creado con exito!.',
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al crear la novedad de agendamiento',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza una novedad de agendamiento
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizar(ActualizarNovedadAgendamientoRequest $request, int $id): JsonResponse
    {
        try {
            $novedadAgendamiento = $this->novedadAgendamientoRepository->buscar($id);
            $novedadAgendamiento->fill($request->all());

            $actualizarNovedadAgendamiento = $this->novedadAgendamientoRepository->guardar($novedadAgendamiento);

            return response()->json([
                'res' => true,
                'data' => $actualizarNovedadAgendamiento,
                'mensaje' => 'Novedad agendamiento actualizado con exito!.'
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al actualizar la novedad agendamiento'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
