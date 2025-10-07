<?php

namespace App\Http\Modules\RepresentanteLegal\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\RepresentanteLegal\Repositories\RepresentanteLegalRepository;

class RepresentanteLegalController extends Controller
{
    public function __construct(protected RepresentanteLegalRepository $representanteLegalRepository) {

    }

    /**
     * Guarda un reprentante legal
     * @param Request $request
     * @return Response
     * @author Jdss
     */
    public function crear(Request $request):JsonResponse{

        try {
            $representante = $this->representanteLegalRepository->crear($request->all());
            return response()->json($representante, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage(), Response::HTTP_BAD_REQUEST]);
        }
    }
}
