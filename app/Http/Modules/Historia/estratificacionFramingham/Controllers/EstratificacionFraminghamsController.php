<?php

namespace App\Http\Modules\Historia\estratificacionFramingham\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\Historia\estratificacionFramingham\Services\EstratificacionFraminghamsService;
use App\Http\Modules\Historia\estratificacionFramingham\Requests\CrearEstratificacionFraminghamsRequest;
use App\Http\Modules\Historia\estratificacionFramingham\Repositories\EstratificacionFraminghamsRepository;

class EstratificacionFraminghamsController extends Controller
{
        public function __construct(protected EstratificacionFraminghamsRepository $estratificacionRepository,
                                    protected EstratificacionFraminghamsService $estratificacionService) {
    }

    public function guardar(CrearEstratificacionFraminghamsRequest $request) {
        try {
            $this->estratificacionService->guardarEstratificacionFramingham($request->all());
            return response()->json([
                'mensaje' => 'Estratificación de framingham guardada con éxito.'
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
            $this->estratificacionRepository->crearFramingham($request->all());
            return response()->json(['Creado con exito']);
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
