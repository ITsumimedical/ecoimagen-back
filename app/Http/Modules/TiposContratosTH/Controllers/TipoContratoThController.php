<?php

namespace App\Http\Modules\TiposContratosTH\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\TiposContratosTH\Repositories\TipoContratoThRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TipoContratoThController extends Controller
{
    private $tipoContratoRepository;

    public function __construct(){
        $this->tipoContratoRepository = new TipoContratoThRepository();
    }

    /**
     * lista los tipos de contrato de talento humano
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request)
    {
        try {
            return response()->json([
                $tipoContrato = $this->tipoContratoRepository->listar($request),
                'res' => true,
                'data' => $tipoContrato
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar los tipos de contrato de talento humano',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

}
