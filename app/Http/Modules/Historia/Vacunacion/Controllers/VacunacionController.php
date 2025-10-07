<?php

namespace App\Http\Modules\Historia\Vacunacion\Controllers;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\Historia\Vacunacion\Repositories\VacunacionRepository;
use App\Http\Modules\Historia\Vacunacion\Requests\VacunacionRequest;
use App\Http\Modules\Historia\Vacunacion\Services\VacunacionService;
use Illuminate\Http\Request;

class VacunacionController extends Controller
{
    public function __construct(
        protected VacunacionRepository $vacunacionRepository,
        protected VacunacionService $vacunacionService
    ) {}

    public function guardar(VacunacionRequest $request)
    {
        try {
            $this->vacunacionService->guardarAntecedentes($request->validated());
            return response()->json([
                'mensaje' => 'Los antecedentes guardados con exito.'
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function guardarNotieneAntecedente(Request $request)
    {
        try {
            $this->vacunacionRepository->crear($request->all());
            return response()->json('Agregado con éxito', Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listar(Request $request)
    {
        try {
            $antecedentes =  $this->vacunacionRepository->listarAntecedentes($request);
            return response()->json($antecedentes);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'error al consultar los antecedentes'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function eliminar(Request $request)
    {
        try {
            $vacuna =  $this->vacunacionRepository->eliminarVacuna($request);
            return response()->json([
                'res' => true,
                'mensaje' => 'Vacuna eliminada con exito.',
                'data' => $vacuna
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
