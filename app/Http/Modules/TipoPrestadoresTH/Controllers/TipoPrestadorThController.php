<?php

namespace App\Http\Modules\TipoPrestadoresTH\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\TipoPrestadoresTH\Repositories\TipoPrestadorThRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TipoPrestadorThController extends Controller
{
    private $tipoPrestadorThRepository;

    public function __construct(){
        $this->tipoPrestadorThRepository = new TipoPrestadorThRepository();
    }

    /**
     * lista los tipos de prestadores de talento humano
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request)
    {
        $tipoPrestador = $this->tipoPrestadorThRepository->listar($request);
        
        try {
            return response()->json([
                'res' => true,
                'data' => $tipoPrestador
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar los tipos de prestadores de talento humano',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
