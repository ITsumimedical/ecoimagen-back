<?php

namespace App\Http\Modules\Paises\Controllers;

use App\Http\Modules\Paises\Repositories\PaisRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;


class PaisController extends Controller
{
    private $paisRepository;

    public function __construct()
    {
        $this->paisRepository = new PaisRepository();
    }

    /**
     * listar
     * @param Request $request
     * @return Response
     * @author kobatime
     */
    public function listar(Request $request): JsonResponse
    {
        try {
            $pais = $this->paisRepository->listar($request);
            return response()->json(
                $pais
            , Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los paises',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
