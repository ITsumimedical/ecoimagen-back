<?php

namespace App\Http\Modules\Eventos\Analisis\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Eventos\Analisis\Repositories\MotivoAnulacionEventoRepository;

class MotivoAnulacionEventoController extends Controller
{

    private $motivoAnulacionRepository;

    public function __construct(){
        $this->motivoAnulacionRepository = new MotivoAnulacionEventoRepository;
    }


    /**
     * lista los motivos de anulación de un evento adverso
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request): JsonResponse
    {
        $eventoAdverso = $this->motivoAnulacionRepository->listar($request);
        try {
            return response()->json([
                'res' => true,
                'data' => $eventoAdverso
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los motivos de anulación eventos adversos',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
