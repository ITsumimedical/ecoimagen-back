<?php

namespace App\Http\Modules\OrientacionesSexuales\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Http\Modules\OrientacionesSexuales\Models\OrientacionSexual;
use App\Http\Modules\OrientacionesSexuales\Requests\CrearOrientacionSexualRequest;
use App\Http\Modules\OrientacionesSexuales\Repositories\OrientacionSexualRepository;
use App\Http\Modules\OrientacionesSexuales\Requests\ActualizarOrientacionSexualRequest;

class OrientacionSexualController extends Controller
{
    private $orientacionSexualRepository;

    public function __construct(){
        $this->orientacionSexualRepository = new OrientacionSexualRepository;
    }

    /**
     * lista las orientaciones sexuales
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request): JsonResponse
    {
        try {
            $orientacion = $this->orientacionSexualRepository->listar($request);
            return response()->json([
                'res' => true,
                'data' => $orientacion
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar las orientacionse sexuales',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda una orientación sexual
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearOrientacionSexualRequest $request):JsonResponse{
        try {
            $orientacion = $this->orientacionSexualRepository->crear($request->validated());
            return response()->json($orientacion, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza una orientación sexual
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizar(ActualizarOrientacionSexualRequest $request, OrientacionSexual $id){
        try {
            $this->orientacionSexualRepository->actualizar($id, $request->validated());
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
        return (new FastExcel(OrientacionSexual::all()))->download('file.xlsx');
    }
}
