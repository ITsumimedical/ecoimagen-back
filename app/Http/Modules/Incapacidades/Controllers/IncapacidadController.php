<?php

namespace App\Http\Modules\Incapacidades\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Incapacidades\Services\IncapacidadService;
use App\Http\Modules\Incapacidades\Repositories\IncapacidadRepository;
use App\Http\Modules\Incapacidades\Requests\CrearIncapacidadRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class IncapacidadController extends Controller
{
    private $incapacidadRepository;


    protected $incapacidadService;

    public function __construct(IncapacidadService $incapacidadService)
    {
        $this->incapacidadRepository = new IncapacidadRepository();
        $this->incapacidadService = $incapacidadService;
    }


    public function registrarIncapacidad(CrearIncapacidadRequest $request)
    {
        try {
            $incapacidad = $this->incapacidadService->registrar($request->validated());
            return response()->json([
                'res' => $incapacidad,
                'mensaje' => 'Incapacidad registrada con exito.'
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al registrar la incapacidad',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function historicoIncapacidad(Request $request)
    {
        try {
            $incapacidades = $this->incapacidadRepository->historico($request);
            return response()->json($incapacidades, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al consultar las incapacidades de afiliado',
                $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function editarFechaIncapacidad(Request $request)
    {
        try {
            $incapacidades = $this->incapacidadService->editarFechaIncapacidad($request);
            return response()->json($incapacidades, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al editar las fechas de la incapacidad',
                $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function anularIncapacidad(Request $request)
    {
        try {
            $incapacidades = $this->incapacidadService->anularIncapacidad($request);
            return response()->json($incapacidades, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al anular la incapacidad',
                $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function ordenesIncapacidadAfiliado(Request $request)
    {
        try {
            $ordenes = $this->incapacidadRepository->ordenesIncapacidadAfiliado($request->all());
            return response()->json($ordenes, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }


}
