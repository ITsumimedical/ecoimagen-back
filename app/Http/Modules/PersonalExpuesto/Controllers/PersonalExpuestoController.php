<?php

namespace App\Http\Modules\PersonalExpuesto\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\PersonalExpuesto\Repositories\PersonalExpuestoRepository;

class PersonalExpuestoController extends Controller
{
    public function __construct(protected PersonalExpuestoRepository $personalExpuestoRepository) {

    }

    public function listar(Request $request)
    {
        try {
            $socio = $this->personalExpuestoRepository->listarPersonal($request);
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
            $socio = $this->personalExpuestoRepository->crear($request->all());
            return response()->json($socio, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage(), Response::HTTP_BAD_REQUEST]);
        }
    }

    public function inactivar(Request $request):JsonResponse{

        try {
            $socio = $this->personalExpuestoRepository->inactivar($request);
            return response()->json($socio, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage(), Response::HTTP_BAD_REQUEST]);
        }
    }
}
