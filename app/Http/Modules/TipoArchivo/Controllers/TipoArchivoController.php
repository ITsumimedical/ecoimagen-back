<?php

namespace App\Http\Modules\TipoArchivo\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\TipoArchivo\Repositories\TipoArchivoRepository;

class TipoArchivoController extends Controller
{
    public function __construct(protected TipoArchivoRepository $tipoArchivoRepository) {

    }

    public function listar(Request $request)
    {
        try {
            $tipo = $this->tipoArchivoRepository->listar($request);
            return response()->json($tipo, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     *
     * @param Request $request
     * @return Response
     * @author Jdss
     */
    public function crear(Request $request):JsonResponse{

        try {
            $tipo = $this->tipoArchivoRepository->crear($request->all());
            return response()->json($tipo, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage(), Response::HTTP_BAD_REQUEST]);
        }
    }
}
