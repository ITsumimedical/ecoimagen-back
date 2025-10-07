<?php

namespace App\Http\Modules\ServiciosTH\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\ServiciosTH\Models\ServicioTh;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Http\Modules\ServiciosTH\Requests\CrearServicioThRequest;
use App\Http\Modules\ServiciosTH\Repositories\ServicioThRepository;
use App\Http\Modules\ServiciosTH\Requests\ActualizarServicioThRequest;

class ServicioThController extends Controller
{
    private $servicioThRepository;

    public function __construct(){
        $this->servicioThRepository = new ServicioThRepository;
    }

    /**
     * lista los servicios de talento humano
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request): JsonResponse
    {
        $servicioTh = $this->servicioThRepository->listar($request);
        try {
            return response()->json([
                'res' => true,
                'data' => $servicioTh
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los servicios de talento humano',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un servicio de talento humano
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearServicioThRequest $request):JsonResponse{
        try {
            $servicioTh = $this->servicioThRepository->crear($request->validated());
            return response()->json($servicioTh, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza un servicio de talento humano
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizar(ActualizarServicioThRequest $request, ServicioTh $id){
        try {
            $this->servicioThRepository->actualizar($id, $request->validated());
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
        return (new FastExcel(ServicioTh::all()))->download('file.xlsx');
    }
}
