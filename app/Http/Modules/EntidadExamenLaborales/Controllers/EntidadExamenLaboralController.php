<?php

namespace App\Http\Modules\EntidadExamenLaborales\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Http\Modules\EntidadExamenLaborales\Models\EntidadExamenLaboral;
use App\Http\Modules\EntidadExamenLaborales\Requests\CrearEntidadExamenLaboralRequest;
use App\Http\Modules\EntidadExamenLaborales\Repositories\EntidadExamenLaboralRepository;
use App\Http\Modules\EntidadExamenLaborales\Requests\ActualizarEntidadExamenLaboralRequest;

class EntidadExamenLaboralController extends Controller
{
    private $entidadExamenLaboralRepository;

    public function __construct(){
        $this->entidadExamenLaboralRepository = new EntidadExamenLaboralRepository;
    }

    /**
     * lista las entidades de exámenes
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request): JsonResponse
    {
        $entidad = $this->entidadExamenLaboralRepository->listar($request);
        try {
            return response()->json([
                'res' => true,
                'data' => $entidad
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar las entidades de exámen laboral',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda una entidad exámen laboral
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearEntidadExamenLaboralRequest $request):JsonResponse{
        try {
            $entidadExamen = $this->entidadExamenLaboralRepository->crear($request->validated());
            return response()->json($entidadExamen, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza una entidad de exámen
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizar(ActualizarEntidadExamenLaboralRequest $request, EntidadExamenLaboral $id){
        try {
            $this->entidadExamenLaboralRepository->actualizar($id, $request->validated());
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
        return (new FastExcel(EntidadExamenLaboral::all()))->download('file.xlsx');
    }
}
