<?php

namespace App\Http\Modules\AdjuntoSarlaft\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\AdjuntoSarlaft\Services\AdjuntoSarlaftService;

class AdjuntoSarlaftController extends Controller
{
    public function __construct(protected AdjuntoSarlaftService $adjuntoSarlaftService) {

    }


    /**
     * Guarda un socio
     * @param Request $request
     * @return Response
     * @author Jdss
     */
    public function crear(Request $request,$id_sarlaft):JsonResponse{

        try {
            $socio = $this->adjuntoSarlaftService->guardarAdjunto($request->all(),$id_sarlaft);
            return response()->json($socio, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage(), Response::HTTP_BAD_REQUEST]);
        }
    }
}
