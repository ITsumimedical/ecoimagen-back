<?php

namespace App\Http\Modules\DemandaInsatisfecha\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\DemandaInsatisfecha\Repositories\DemandaInsatisfechaRepository;
use App\Http\Modules\DemandaInsatisfecha\Requests\DemandaInsatisfechaRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class DemandaInsatisfechaController extends Controller
{
    public function __construct(private DemandaInsatisfechaRepository $repository)
    {
    }

    public function crear(DemandaInsatisfechaRequest $request)
    {
        try {
            $consulta = $this->repository->crearInsatisfecha($request->validated());
            $this->repository->crear($consulta);
            return response()->json([
                'mensaje' => 'Se creo correctamente'],
                Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al crear',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listar($afiliado_id)
    {
        try {
            $consulta = $this->repository->listarDemandaInsatisfecha($afiliado_id);
            return response()->json(
                $consulta,
                Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al crear',
            ], Response::HTTP_BAD_REQUEST);
        }
    }


}
