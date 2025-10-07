<?php

namespace App\Http\Modules\Georeferenciacion\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Georeferenciacion\Repositories\GeoreferenciaRepository;
use App\Http\Modules\Georeferenciacion\Requests\CrearGeorreferenciaRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GeoreferenciacionController extends Controller
{

    protected $georeferenciaRepository;

    public function __construct(GeoreferenciaRepository $georeferenciaRepository
    )
    {
        $this->georeferenciaRepository = $georeferenciaRepository;
    }

    /**
     * funcion para listar
     *
     * @param  mixed $request
     * @return JsonResponse
     * @author kobatime
     */
    public function listar(Request $request): JsonResponse
    {
        try {
            $georeferencia = $this->georeferenciaRepository->listarGeoreferencia($request);
            return response()->json($georeferencia, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al listar las georeferencias!.',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * funcion para crear
     *
     * @param  mixed $request
     * @return JsonResponse
     * @author kobatime
     */
    public function crear(CrearGeorreferenciaRequest $request): JsonResponse
    {
        try {
            $georeferencia = $this->georeferenciaRepository->crearGeoreferencia($request->validated());
            return response()->json($georeferencia, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al crear la georeferencia!.',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizar(Request $request)
    {

        try {
            $actualizar = $this->georeferenciaRepository->actualizarGeorreferenciacion($request->all());
            return response()->json($actualizar, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al Actualizar la Georreferenciacion.'
            ]);
        }
    }

}
