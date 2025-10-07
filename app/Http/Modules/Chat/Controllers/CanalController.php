<?php

namespace App\Http\Modules\Chat\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Chat\Models\canal;
use App\Http\Modules\Chat\Repositories\CanalRepository;

class CanalController extends Controller
{
    protected $repository;
    protected $Service;

    public function __construct(CanalRepository $canalrepository){
        $this->repository = $canalrepository;
    }

    /**
     * listar chats
     * @param int $user_id
     * @return Response $categoriaHistoria
     * @author kobatime
     */
    public function listar(int $user_id): JsonResponse
    {
        try {
            $canales = $this->repository->listarCanalesEmpleados($user_id);
            return response()->json([
                'res' => true,
                'data' => $canales,
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los chats',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Guarda un canal
     * @param Request $request
     * @return Response $categoriaHistoria
     * @author kobatime
     */
    public function crear(Request $request): JsonResponse
    {
        try {
            $canal = $this->repository->guardarCanal($request->all());
            $this->repository->crear($canal);
            return response()->json([
                'res' => true,
                'mensaje' => 'Mensaje enviado con exito.',
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al enviar el mensaje',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
