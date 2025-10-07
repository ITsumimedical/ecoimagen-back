<?php

namespace App\Http\Modules\Cargos\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Http\Modules\Cargos\Models\Cargo;
use App\Http\Modules\Cargos\Requests\CrearCargoRequest;
use App\Http\Modules\Cargos\Repositories\CargoRepository;
use App\Http\Modules\Cargos\Requests\ActualizarCargoRequest;

class CargoController extends Controller
{
    private $cargoRepository;

    public function __construct()
    {
        $this->cargoRepository = new CargoRepository;
    }

    /**
     * lista los cargos
     *
     * @return JsonResponse
     * @author leon
     */
    // Lista los cargos paginados con la opcion de filtrar por nombre
    public function listar(Request $request)
    {
        try {
            $cargos = $this->cargoRepository->listarCargos($request);
            return response()->json($cargos, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar los cargos',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
    public function listarTodos()
    {
        try {
            $cargos = $this->cargoRepository->listarTodos();
            return response()->json($cargos, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar los cargos',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * guarda un cargo
     * @param  mixed $request
     */
    public function crear(CrearCargoRequest $request): JsonResponse
    {
        try {
            $cargo = $this->cargoRepository->crear($request->validated());
            return response()->json($cargo, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * actualiza un cargo según su id
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return JsonResponse
     */
    public function actualizar(ActualizarCargoRequest $request, Cargo $id)
    {
        try {
            $this->cargoRepository->actualizar($id, $request->validated());
            return response()->json([]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * exportar - exporta excel con los datos del modelo
     *
     * @return void
     */
    public function exportar()
    {
        return (new FastExcel(Cargo::all()))->download('file.xlsx');
    }
}
