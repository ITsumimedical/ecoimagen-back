<?php

namespace App\Http\Modules\Historia\AntecedentesPersonales\Controllers;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\Reps\Models\Rep;
use Illuminate\Http\Request;
use App\Http\Modules\Historia\AntecedentesPersonales\Services\AntecedentesService;
use App\Http\Modules\Historia\AntecedentesPersonales\Requests\AntecedentePersonalRequest;
use App\Http\Modules\Historia\AntecedentesPersonales\Repositories\AntecedentePersonalRepository;

class AntecedentePersonaleController extends Controller
{
    public function __construct(
        protected AntecedentePersonalRepository $antecedentePersonalRepository,
        protected AntecedentesService $antecedentesService
    ) {
    }

    public function guardar(AntecedentePersonalRequest $request)
    {
        try {
            $this->antecedentePersonalRepository->crearAntecedente($request->validated());
            return response()->json([
                'mensaje' => 'Se registran los antecedentes personales con exito.'
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al registran los antecedentes personales .',
                $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listar(Request $request)
    {
        try {
            $antecedentes =  $this->antecedentePersonalRepository->listarAntecedentes($request);
            return response()->json($antecedentes);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function eliminar(Request $request)
    {
        try {
            $antecedente = $this->antecedentePersonalRepository->eliminar($request);
            return response()->json([
                'mensaje' => 'Se ha eliminado la antecedente personal correctamente.',
                'data' => $antecedente
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarAntecedenteAfiliado($numero_documento)
    {

        try {
            $antecedentes = $this->antecedentePersonalRepository->listarAntecedenteAfiliado($numero_documento);
            return response()->json(
                 $antecedentes,
                 Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function obtenerDiabetes($afiliado_id)
    {
        try {
            $antecedentes = $this->antecedentePersonalRepository->obtenerDiabetes($afiliado_id);
            return response()->json(
                $antecedentes,
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
