<?php

namespace App\Http\Modules\ProgramasFarmacia\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\ProgramasFarmacia\Repositories\ProgramasFarmaciaRepository;
use App\Http\Modules\ProgramasFarmacia\Request\ActualizarProgramaFarmaciaRequest;
use App\Http\Modules\ProgramasFarmacia\Request\ManejarDiagnosticosProgramaRequest;
use App\Http\Modules\ProgramasFarmacia\Request\CrearProgramaFarmaciaRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class ProgramasFarmaciaController extends Controller
{
    public function __construct(protected ProgramasFarmaciaRepository $programasFarmaciaRepository)
    {
    }

    public function listar(Request $request)
    {
        try {
            $programas = $this->programasFarmaciaRepository->listar($request);
            return response()->json($programas, 200);
        } catch (Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function crear(CrearProgramaFarmaciaRequest $request)
    {
        try {
            $this->programasFarmaciaRepository->crear($request->validated());
            return response()->json([
                'mensaje' => 'Programa de farmacia creado con éxito'
            ]);
        } catch (Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function actualizar(ActualizarProgramaFarmaciaRequest $request, $id)
    {

        try {
            $programa = $this->programasFarmaciaRepository->actualizar($request->validated(), $id);
            return response()->json(['message' => 'programa actualizado con éxito', $programa], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function cambiarEstado($id)
    {
        try {
            $this->programasFarmaciaRepository->cambiarEstado($id);
            return response()->json(['message' => 'Estado del programa cambiado con éxito'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Asocia los diagnósticos al programa
     * @param int $programaId
     * @param ManejarDiagnosticosProgramaRequest $request
     * @return JsonResponse
     * @throws Throwable
     * @author Thomas
     */
    public function asociarDiagnosticos(int $programaId, ManejarDiagnosticosProgramaRequest $request): JsonResponse
    {
        try {
            $response = $this->programasFarmaciaRepository->asociarDiagnosticos($programaId, $request->validated());
            return response()->json($response, Response::HTTP_CREATED);
        } catch (Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Ocurrió un error al asociar los diagnósticos.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Listar los diagnósticos de un programa
     * @param int $programaId
     * @return JsonResponse
     * @throws Throwable
     * @author Thomas
     */
    public function listarDiagnosticosPrograma(int $programaId): JsonResponse
    {
        try {
            $diagnosticos = $this->programasFarmaciaRepository->listarDiagnosticosPrograma($programaId);
            return response()->json($diagnosticos, Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Ocurrió un error al listar los diagnósticos.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remover los diagnósticos de un programa
     * @param int $programaId
     * @param ManejarDiagnosticosProgramaRequest $request
     * @return JsonResponse
     * @throws Throwable
     * @author Thomas
     */
    public function removerDiagnosticos(int $programaId, ManejarDiagnosticosProgramaRequest $request): JsonResponse
    {
        try {
            $response = $this->programasFarmaciaRepository->removerDiagnosticos($programaId, $request->validated());
            return response()->json($response, Response::HTTP_CREATED);
        } catch (Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Ocurrió un error al asociar los diagnósticos.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
