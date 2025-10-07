<?php

namespace App\Http\Modules\AreasTalentoHumano\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\AreasTalentoHumano\Models\AreaTh;
use App\Http\Modules\AreasTalentoHumano\Requests\CrearAreaThRequest;
use App\Http\Modules\AreasTalentoHumano\Repositories\AreaThRepository;
use App\Http\Modules\AreasTalentoHumano\Requests\ActualizaAreaThRequest;
use Rap2hpoutre\FastExcel\FastExcel;

class AreaThController extends Controller
{
    private $areaThRepository;

    public function __construct(){
        $this->areaThRepository = new AreaThRepository;
    }

    /**
     * lista las áreas de talento humano
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request)
    {
        try {
            return response()->json([
                $areasTh = $this->areaThRepository->listar($request),
                'res' => true,
                'data' => $areasTh
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar las áreas de talento humano',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un áreas
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearAreaThRequest $request):JsonResponse{
        try {
            $area = $this->areaThRepository->crear($request->validated());
            return response()->json($area, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizar(ActualizaAreaThRequest $request, AreaTh $id){
        try {
            $this->areaThRepository->actualizar($id, $request->validated());
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
    public function exportar()
    {
        return (new FastExcel(AreaTh::all()))->download('file.xlsx');
    }

    /**
     * Consultar las categorias de un area
     *
     * @param  mixed $areaTh_id
     * @return void
     * @author Calvarez
     */
    public function categoriasAreaTh(int $areaTh_id)
    {
        try {
            $categorias = $this->areaThRepository->areaCategoria($areaTh_id);
            return response()->json($categorias, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'error al consultar categorias asociadas al area!'
            ]);
        }
    }

    /**
     * Consultar los empleados de un area
     *
     * @param  mixed $areaTh_id
     * @return void
     * @author Calvarez
     */
    public function empleadosArea(int $areaTh_id)
    {
        try {
            $empleadosArea = $this->areaThRepository->empleadosArea($areaTh_id);
            return response()->json($empleadosArea, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'error al consultar los empleados del area!',
                'error'   => $th->getMessage()
            ]);
        }
    }
}
