<?php

namespace App\Http\Modules\TipoConsultas\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\TipoConsultas\Repositories\TipoConsultaRepository;
use Illuminate\Http\Request;

class TipoConsultaController extends Controller
{
    private $tipoConsultaRepository;

    public function __construct()
    {

        $this->tipoConsultaRepository = new TipoConsultaRepository();
    }

    public function listar(Request $request)
    {
        try {
            $tipos_consulta = $this->tipoConsultaRepository->listar($request);
            return response()->json($tipos_consulta);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }
}
