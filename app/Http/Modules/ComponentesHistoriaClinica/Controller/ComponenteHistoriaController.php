<?php

namespace App\Http\Modules\ComponentesHistoriaClinica\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\ComponentesHistoriaClinica\Repositories\ComponenteHistoriaRepository;
use App\Http\Modules\ComponentesHistoriaClinica\Request\ActualizarComponenteHistoriaRequest;
use App\Http\Modules\ComponentesHistoriaClinica\Request\CrearComponenteHistoriaRequest;
use App\Http\Modules\ComponentesHistoriaClinica\Services\ComponenteHistoriaService;
use Illuminate\Http\Request;

class ComponenteHistoriaController extends Controller
{
    public function __construct(
        protected ComponenteHistoriaRepository $componenteHistoriaRepository,
        protected ComponenteHistoriaService $componenteHistoriaService
    ) {}

    /**
     * crearComponente
     * Función para un componente para la parametrización de historias
     * @param  mixed $request
     * @return void
     */
    public function crearComponente(CrearComponenteHistoriaRequest $request)
    {
        try {
            $componente = $this->componenteHistoriaRepository->crear($request->validated());
            return response()->json($componente);
        } catch (\Throwable $th) {
            return response()->json(['error al registrar un componente', $th->getMessage()], 400);
        }
    }

    /**
     * listarComponentes
     * Función para listar los componentes creados
     * @param  mixed $request
     * @return void
     */
    public function listarComponentes(Request $request)
    {
        try {
            $componentes = $this->componenteHistoriaRepository->listar($request);
            return response()->json($componentes);
        } catch (\Throwable $th) {
            return response()->json(['error al listar los componentes', $th->getMessage()], 400);
        }
    }

    /**
     * actualizar
     * Función para actualizar los datos de un componente, recibiendo el id y la data
     * @param  mixed $id
     * @param  mixed $request
     * @return void
     */
    public function actualizar($id, ActualizarComponenteHistoriaRequest $request)
    {
        try {
            $componente = $this->componenteHistoriaService->actualizar($id,$request->validated());
            return response()->json($componente);
        } catch (\Throwable $th) {
            return response()->json(['error', $th->getMessage()], 400);
        }
    }

    /**
     * listarComponentesEscalas
     * Funcion para listar solo las escalas
     *
     * @return void
     */
    public function listarComponentesEscalas()
    {
        try {
            $escala = $this->componenteHistoriaRepository->listarComponentesEscalas();
            return response()->json($escala);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }
}
