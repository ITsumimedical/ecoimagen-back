<?php

namespace App\Http\Modules\EtiquetasTH\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\EtiquetasTH\Models\EtiquetaTh;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Http\Modules\EtiquetasTH\Requests\CrearEtiquetaThRequest;
use App\Http\Modules\EtiquetasTH\Repositories\EtiquetaThRepository;
use App\Http\Modules\EtiquetasTH\Requests\ActualizarEtiquetaThRequest;

class EtiquetaThController extends Controller
{
    private $etiquetaThRepository;

    public function __construct(){
        $this->etiquetaThRepository = new EtiquetaThRepository;
    }

    /**
     * lista las etiquetas de talento humano
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request): JsonResponse
    {
        $etiquetaTh = $this->etiquetaThRepository->listar($request);
        try {
            return response()->json([
                'res' => true,
                'data' => $etiquetaTh
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar las etiquetas de talento humano',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda una etiqueta de talento humano
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearEtiquetaThRequest $request):JsonResponse{
        try {
            $etiquetaTh = $this->etiquetaThRepository->crear($request->validated());
            return response()->json($etiquetaTh, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza una etiqueta humano
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizar(ActualizarEtiquetaThRequest $request, EtiquetaTh $id){
        try {
            $this->etiquetaThRepository->actualizar($id, $request->validated());
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
        return (new FastExcel(EtiquetaTh::all()))->download('file.xlsx');
    }
}
