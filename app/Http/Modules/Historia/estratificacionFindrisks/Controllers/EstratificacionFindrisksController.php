<?php

namespace App\Http\Modules\Historia\estratificacionFindrisks\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\Historia\estratificacionFindrisks\Models\EstratificacionFindrisks;
use App\Http\Modules\Historia\estratificacionFindrisks\Services\EstratificacionFindrisksService;
use App\Http\Modules\Historia\estratificacionFindrisks\Repositories\EstratificacionFindrisksRepository;

class EstratificacionFindrisksController extends Controller
{
        public function __construct(protected EstratificacionFindrisksRepository $estratificacionRepository,
                                    protected EstratificacionFindrisksService $estratificacionService) {
    }

    public function guardar(Request $request) {
        try {
            $this->estratificacionService->guardarEstratificacion($request->all());
            return response()->json([
                'mensaje' => 'Los antecedentes transfusionales guardados con exito.'
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function crear(Request $request)
    {
        try {
            $this->estratificacionRepository->crearFindrisc($request->all());
            return response()->json('Creado con éxito');
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarEstratificacion(Request $request) {
        try {
            $estratificacion =  $this->estratificacionRepository->listarEstratificacion($request);
            return response()->json($estratificacion);
        } catch (\Throwable $th) {
            return response()->json([
                'err' => $th->getMessage(),
                'mensaje' => 'error al consultar estratificación framingham'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
