<?php

namespace App\Http\Modules\IntegrantesJuntaGirs\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\IntegrantesJuntaGirs\Repositories\IntegrantesJuntaGirsRepository;

class IntegrantesJuntaGirsController extends Controller
{
    private $integrantesJuntasGirsRepository;

    public function __construct(IntegrantesJuntaGirsRepository $integrantesJuntasGirsRepository) {
        $this->integrantesJuntasGirsRepository = $integrantesJuntasGirsRepository;
    }

    /**
     * Guarda los integrantes
     * @param Request $request
     * @return Response $teleapoyo
     * @author JDSS
     */
    public function crear(Request $request, $teleapoyo): JsonResponse
    {
        try {
            $teleapoyo = $this->integrantesJuntasGirsRepository->guardarIntegrantes($request->all(),$teleapoyo);
            return response()->json($teleapoyo, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['mensaje' => 'Error al crear ', $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

}
