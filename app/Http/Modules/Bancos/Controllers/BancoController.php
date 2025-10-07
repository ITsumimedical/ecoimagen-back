<?php

namespace App\Http\Modules\Bancos\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Bancos\Models\Banco;
use App\Http\Modules\Bancos\Repositories\BancoRepository;
use App\Http\Modules\Bancos\Requests\ActualizarBancoRequest;
use App\Http\Modules\Bancos\Requests\CrearBancoRequest;

class BancoController extends Controller
{
    private $bancoRepository;

    public function __construct(){
        $this->bancoRepository = new BancoRepository;
    }

    /**
     * lista los bancos
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request): JsonResponse
    {
        $banco = $this->bancoRepository->listar($request);
        try {
            return response()->json([
                'res' => true,
                'data' => $banco
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los bancos',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un banco
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearBancoRequest $request):JsonResponse{
        try {
            $banco = $this->bancoRepository->crear($request->validated());
            return response()->json($banco, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza un banco
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizar(ActualizarBancoRequest $request, Banco $id){
        try {
            $this->bancoRepository->actualizar($id, $request->validated());
            return response()->json([]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(),400);
        }
    }
}
