<?php

namespace App\Http\Modules\Municipios\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Municipios\Models\Municipio;
use App\Http\Modules\Municipios\Services\MunicipioService;
use App\Http\Modules\Municipios\Repositories\MunicipioRepository;

class MunicipioController extends Controller
{
    private $municipioRepository;
    private $municipioService;

    /**
     * Constructor del controlador MunicipioController.
     * Inicializa los servicios y repositorios necesarios.
     */
    public function __construct(){
        $this->municipioRepository = new MunicipioRepository();
        $this->municipioService = new MunicipioService();
    }

    /**
     * Lista todos los municipios.
     *
     * @param Request $request La solicitud HTTP.
     * @return Response Respuesta JSON con los municipios.
     * @author leon
     * @modifiedBy kobatime 13 agosto 2024 se modifica la consulta donde se direcciona a un servicio
     */
    public function listar(Request $request)
    {
        try {
            // Se obtiene la lista de municipios a través del servicio.
            $municipios = $this->municipioService->listar($request);
            return response()->json($municipios, Response::HTTP_OK);
        } catch (\Throwable $th) {
            // Se maneja cualquier excepción y se responde con un error.
            return response()->json([
                'mensaje' => 'Error al buscar los municipios',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Lista las sedes primarias de un municipio específico.
     *
     * @param int $municipio_id El ID del municipio.
     * @return Response Respuesta JSON con las sedes primarias.
     * @author kobatime
     * @since 13 agosto 2024
     */
    public function listarReps($municipio_id)
    {
        try {
            // Se obtienen las sedes primarias del municipio especificado.
            $municipios = $this->municipioService->listarSedesPrimarias($municipio_id);
            return response()->json($municipios, Response::HTTP_OK);
        } catch (\Throwable $th) {
            // Se maneja cualquier excepción y se responde con un error.
            return response()->json([
                'mensaje' => 'Error al buscar las sedes primarias',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Listar municipios cachados con REDIS
     *
     * @return JsonResponse
     * @author Calvarez
     */
    public function listarMunicipios(): JsonResponse {
        try {
            $municipios = $this->municipioRepository->listarMunicipios();

            return response()->json($municipios, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al buscar los municipios',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Listar municipios Por departamento con redis
     *
     * @return
     * @author Calvarez
     */
    public function listarMunicipiosPorDepartamento(Request $request) {
        try {
            $municipios = $this->municipioRepository->listarMunicipiosPorDepartamento(intval($request->departamento_id));

            return response()->json($municipios, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al buscar los municipios',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
	 * Lista los municipios por departamento.
	 * @param int $departamentoId
	 * @return JsonResponse
	 * @throws \Throwable
	 */
    public function listarPorDepartamento(int $departamentoId): JsonResponse
	{
		try {
			$municipios = $this->municipioRepository->listarPorDepartamento($departamentoId);
			return response()->json($municipios, Response::HTTP_OK);
		} catch (\Throwable $th) {
			return response()->json([
				'mensaje' => 'Error al buscar los municipios por departamento',
			], Response::HTTP_BAD_REQUEST);
		}
	}
}
