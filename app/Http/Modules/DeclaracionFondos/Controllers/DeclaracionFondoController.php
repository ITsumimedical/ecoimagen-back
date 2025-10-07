<?php

namespace App\Http\Modules\DeclaracionFondos\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\DeclaracionFondos\Repositories\DeclaracionFondosRepository;

class DeclaracionFondoController extends Controller
{
    public function __construct(protected DeclaracionFondosRepository $declaracionFondosRepository) {

    }


    /**
     * Guarda un socio
     * @param Request $request
     * @return Response
     * @author Jdss
     */
    public function crear(Request $request):JsonResponse{

        try {
            $socio = $this->declaracionFondosRepository->crear($request->all());
            return response()->json($socio, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage(), Response::HTTP_BAD_REQUEST]);
        }
    }
}
