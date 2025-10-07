<?php

namespace App\Http\Modules\TipoViolencia\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Modules\TipoViolencia\Repositories\TipoViolenciaRepository;
use Illuminate\Http\Response;

class TipoViolenciaController extends Controller
{
    private $tipoViolenciaRepository;

    public function __construct()
    {
        $this->tipoViolenciaRepository = new TipoViolenciaRepository();
    }

    public function listarTodas(){
        try {
            $tipoViolencias = $this->tipoViolenciaRepository->listarTodas();
            return response()->json($tipoViolencias, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}