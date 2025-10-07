<?php

namespace App\Http\Modules\Codesumis\codesumis\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\Codesumis\codesumis\Repositories\CodesumiRepository;
use App\Http\Modules\Codesumis\codesumis\Request\CrearCodesumiRequest;
use App\Http\Modules\Codesumis\codesumis\Request\CrearViaAdministracionCodesumiRequest;
use App\Http\Modules\Codesumis\codesumis\Services\CodesumiService;

class CodesumiController extends Controller
{
    private CodesumiRepository $codesumiRepository;
    private CodesumiService $codesumiService;

    public function __construct(
        CodesumiRepository $codesumiRepository,
        CodesumiService $codesumiService
    ) {
        $this->codesumiRepository = $codesumiRepository;
        $this->codesumiService = $codesumiService;
    }

    public function listarCodigosSumi(Request $request)
    {
        try {
            $codesumi = $this->codesumiRepository->listarCodesumis($request);
            return response()->json($codesumi, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function crear(CrearCodesumiRequest $request)
    {
        try {
            $codesumi = $this->codesumiRepository->crear($request->validated());
            $codesumi->programasFarmacia()->sync($request['programa_farmacia_id']);
            return response()->json([
                'mensaje' => 'codesumi creado con éxito'
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_CONFLICT);
        }
    }

    public function actualizar(Request $request, $id)
    {
        try {
            $codigo = $this->codesumiRepository->actualizar($id, $request->all());
            return response()->json($codigo, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_CONFLICT);
        }
    }

    public function buscar(Request $request)
    {
        try {
            $nombre = $request->input('nombre');
            return $this->codesumiRepository->Buscarcodesumi($nombre);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }

    }


    public function codesumiEsquema(Request $request)
    {
        try {
            $sumi = $this->codesumiRepository->codesumiEsquema($request->esquema);
            return response()->json($sumi, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function cambiarEstadoProducto(Request $request)
    {
        try {
            $sumi = $this->codesumiRepository->cambiarEstadoProducto($request);
            return response()->json($sumi, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function sincronizarPrincipiosActivos(Request $request)
    {
        try {
            $codesumis = $this->codesumiRepository->sincronizarPrincipiosActivosCodesumis($request);
            return response()->json($codesumis);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function obtenerPrincipios($codesumi_id)
    {
        try {
            $codesumis = $this->codesumiRepository->obtenerPrincipiosActivosAsociados($codesumi_id);
            return response()->json($codesumis);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function agregarViaAdministracionCodesumi(CrearViaAdministracionCodesumiRequest $request)
    {
        try {
            $vias = $this->codesumiService->agregarViasAdministracionCodesumi($request->validated());
            return response()->json($vias);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function listarViasAdministracionPorCodesumi($codesumi_id)
    {
        try {
            $vias = $this->codesumiRepository->listarViasAdministracionPorCodesumi($codesumi_id);
            return response()->json($vias);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    /**
     * Valida si un medicamento está contratado para la IPS del afiliado
     * @param int $afiliadoId
     * @param int $codesumiId
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function validarContratacionCodesumi(int $afiliadoId, int $codesumiId): JsonResponse
    {
        try {
            $response = $this->codesumiService->validarContratacionCodesumi($afiliadoId, $codesumiId);
            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
