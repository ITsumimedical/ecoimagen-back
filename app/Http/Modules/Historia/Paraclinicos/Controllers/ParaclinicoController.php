<?php

namespace App\Http\Modules\Historia\Paraclinicos\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\Historia\Paraclinicos\Requests\CrearParaclinicoRequest;
use App\Http\Modules\Historia\Paraclinicos\Repositories\ParaclinicoRepository;
use App\Http\Modules\Historia\Paraclinicos\Services\ParaclinicoService;

class ParaclinicoController extends Controller
{

    public function __construct(protected ParaclinicoRepository $paraclinicoRepository,
                                protected ParaclinicoService $paraclinicoService) {
}

    public function guardar(Request $request) {
        try {
            $this->paraclinicoService->guardarParaclinico($request->all());
            return response()->json([
                'mensaje' => 'Los paraclínicos fueron guardados con exito.'
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listar(Request $request) {
        try {
            $paraclinico =  $this->paraclinicoRepository->listarParaclinico($request);
            return response()->json($paraclinico);
        } catch (\Throwable $th) {
            return response()->json([
                'err' => $th->getMessage(),
                'mensaje' => 'error al consultar los paraclínicos'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
