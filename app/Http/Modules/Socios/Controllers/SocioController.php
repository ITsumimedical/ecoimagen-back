<?php

namespace App\Http\Modules\Socios\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Socios\Repositories\SocioRepository;

class SocioController extends Controller
{
    public function __construct(protected SocioRepository $socioRepository) {

    }

    public function listar(Request $request)
    {
        try {
            $socio = $this->socioRepository->listarSocios($request);
            return response()->json( $socio, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar las sedes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un socio
     * @param Request $request
     * @return Response
     * @author Jdss
     */
    public function crear(Request $request):JsonResponse{

        try {
            $socio = $this->socioRepository->crear($request->all());
            return response()->json($socio, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage(), Response::HTTP_BAD_REQUEST]);
        }
    }

    public function inactivar(Request $request):JsonResponse{

        try {
            $socio = $this->socioRepository->inactivar($request);
            return response()->json($socio, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage(), Response::HTTP_BAD_REQUEST]);
        }
    }
}
