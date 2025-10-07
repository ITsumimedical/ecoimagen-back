<?php

namespace App\Http\Modules\AntecedentesParto\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\AntecedentesParto\Repositories\AntecedentePartoRepository;
use Illuminate\Http\Request;

class AntecedentePartoController extends Controller
{
    public function __construct(
        protected AntecedentePartoRepository $antecedentePartoRepository,
    ) {}

    public function crear(Request $request)
    {
        try {
            $parto = $this->antecedentePartoRepository->crearParto($request->all());
            return response()->json($parto);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function listarHistorico($afiliado_id)
    {
        try {
            $historico = $this->antecedentePartoRepository->ListarHistorico($afiliado_id);
            return response()->json($historico);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }
}
