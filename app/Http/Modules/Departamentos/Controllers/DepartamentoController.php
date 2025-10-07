<?php

namespace App\Http\Modules\Departamentos\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Departamentos\Services\DepartamentoService;
use App\Http\Modules\Departamentos\Repositories\DepartamentoRepository;

class DepartamentoController extends Controller
{
    private $departamentoRepository;
    private $departamentoService;

    /**
     * Constructor para inicializar el repositorio y el servicio de departamento.
     */
    public function __construct()
    {
        // Inicialización de la instancia del repositorio y el servicio de departamento.
        $this->departamentoRepository = new DepartamentoRepository();
        $this->departamentoService = new DepartamentoService();
    }

    /**
     * Método para listar los departamentos.
     *
     * @param Request $request La solicitud HTTP entrante.
     * @return Respuesta JSON con la lista de departamentos o un mensaje de error.
     * @author Kobatime
     */
    public function listar(Request $request)
    {
        try {
            // Llamada al servicio para obtener la lista de departamentos.
            $departamento = $this->departamentoService->listarDepartamentos($request);

            // Retornar la respuesta con los departamentos en formato JSON con el código de estado HTTP 200.
            return response()->json($departamento, Response::HTTP_OK);
        } catch (\Throwable $th) {
            // En caso de error, capturar la excepción y retornar un mensaje de error en formato JSON con el código de estado HTTP 400.
            return response()->json([
                'mensaje' => 'Error al buscar los departamentos',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Listar departamentos cachados con REDIS
     *
     * @return JsonResponse
     * @author Calvarez
     */
    public function listarDepartamentos(): JsonResponse {
        try {
            $departamento = $this->departamentoRepository->listarDepartamentos();

            return response()->json($departamento, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al buscar los departamentos',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
