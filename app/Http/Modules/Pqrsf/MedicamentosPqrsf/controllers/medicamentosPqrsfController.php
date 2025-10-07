<?php

namespace App\Http\Modules\Pqrsf\MedicamentosPqrsf\controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Pqrsf\MedicamentosPqrsf\Requests\CrearmedicamentosPqrsfsRequest;
use App\Http\Modules\Pqrsf\MedicamentosPqrsf\Repositories\medicamentosPqrsfsRepository;
use App\Http\Modules\Pqrsf\MedicamentosPqrsf\Requests\ActualizarMedicamentosPqrsfRequest;
use App\Http\Modules\Pqrsf\MedicamentosPqrsf\Services\MedicamentosPqrsfService;

class medicamentosPqrsfController extends Controller
{
    private $medicamentosRepository;

    public function __construct(private MedicamentosPqrsfService $medicamentosPqrsfService)
    {
        $this->medicamentosRepository = new medicamentosPqrsfsRepository();
    }


    public function listar(Request $request)
    {
        try {
            $medicamento = $this->medicamentosRepository->listarMedicamentos($request);
            return response()->json($medicamento, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function crear(CrearmedicamentosPqrsfsRequest $request): JsonResponse
    {
        try {
            $medicamento = $this->medicamentosPqrsfService->crearMedicamento($request->validated());
            return response()->json($medicamento, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function eliminar(Request $request): JsonResponse
    {
        try {
            $medicamento = $this->medicamentosRepository->eliminar($request);

            return response()->json($medicamento, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al crear la medicmanto de PQRSF!',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza los codesumis de un PQRSF
     * @param int $pqrsfId
     * @param ActualizarMedicamentosPqrsfRequest $request
     * @return JsonResponse
     * @author Thomas
     */
    public function actualizarCodesumi(int $pqrsfId, ActualizarMedicamentosPqrsfRequest $request): JsonResponse
    {
        try {
            $respuesta = $this->medicamentosRepository->actualizarCodesumi($pqrsfId, $request->validated());
            return response()->json($respuesta, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Elimina un codesumi de un PQRSF
     * @param int $pqrsfId
     * @param Request $request
     * @return JsonResponse
     * @author Thomas
     */
    public function removerCodesumi(int $pqrsfId, Request $request): JsonResponse
    {
        try {
            $respuesta = $this->medicamentosRepository->removerCodesumi($pqrsfId, $request->all());
            return response()->json($respuesta, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
