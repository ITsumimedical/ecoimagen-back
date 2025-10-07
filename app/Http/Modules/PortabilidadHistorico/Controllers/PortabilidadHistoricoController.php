<?php

namespace App\Http\Modules\PortabilidadHistorico\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\PortabilidadHistorico\Repositories\PortabilidadHistoricoRepository;

class PortabilidadHistoricoController extends Controller
{
    protected $historicoRepository;

    public function __construct(PortabilidadHistoricoRepository $historicoRepository)
    {
        $this->historicoRepository = $historicoRepository;
    }

    public function portabilidadHistorico(Request $request)
    {
        try {
            $historico = $this->historicoRepository->listarHistorico($request);
            return response()->json($historico, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al recuperar las portabilidades de entrada',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

}
