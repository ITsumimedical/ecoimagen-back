<?php

namespace App\Http\Modules\Caracterizacion\Controllers;

use App\Http\Modules\Caracterizacion\Models\IntegrantesFamiliaCaracterizacionEcis;
use App\Http\Modules\Caracterizacion\Repositories\CaracterizacionEcisRepository;
use App\Http\Modules\Caracterizacion\Repositories\IntegrantesFamiliaCaracterizacionEcisRepository;
use App\Http\Modules\Caracterizacion\Requests\AgregarIntegranteCaracterizacionEcisRequest;
use App\Http\Modules\Caracterizacion\Requests\AsociarIntegranteExistenteRequest;
use App\Http\Modules\Caracterizacion\Requests\BuscarCaracterizacionEcisRequest;
use App\Http\Modules\Caracterizacion\Requests\GuardarCaracterizacionEcisRequest;
use App\Http\Modules\Caracterizacion\Services\CaracterizacionEcisService;
use App\Http\Modules\Caracterizacion\Services\IntegrantesFamiliaCaracterizacionEcisService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Modules\Caracterizacion\Services\CaracterizacionService;
use App\Http\Modules\Caracterizacion\Requests\CrearCaracterizacionRequest;
use App\Http\Modules\Caracterizacion\Repositories\CaracterizacionRepository;
use App\Http\Modules\Caracterizacion\Requests\ActualizarCaracterizacionRequest;
use Rap2hpoutre\FastExcel\FastExcel;

class CaracterizacionController extends Controller
{


    public function __construct(
        private CaracterizacionRepository $caracterizacionRepository,
        private CaracterizacionService $caracterizacionService,
        private readonly CaracterizacionEcisService $caracterizacionEcisService,
        private readonly IntegrantesFamiliaCaracterizacionEcisRepository $integrantesFamiliaCaracterizacionEcisRepository,
        private readonly IntegrantesFamiliaCaracterizacionEcisService $integrantesFamiliaCaracterizacionEcisService,
        private readonly CaracterizacionEcisRepository $caracterizacionEcisRepository
    ) {
    }

    public function listar($afiliado_id)
    {
        try {
            $caracterizacion = $this->caracterizacionRepository->ListarCaracterizacion($afiliado_id);
            return response()->json($caracterizacion, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function crear(CrearCaracterizacionRequest $request)
    {
        try {
            $this->caracterizacionService->crearCaracterizacion($request->validated());
            return response()->json([
                'mensaje' => 'Caracterizacion creada con éxito'
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al crear la caracterizacion.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizar(ActualizarCaracterizacionRequest $request, $id)
    {
        try {
            $this->caracterizacionService->actualizarCaracterizacion($id, $request->validated());
            return response()->json([
                'message' => 'Se ha actualizado la caracterizacion correctamente.',
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }


    /**
     * Funcion que descarga el reporte
     *
     * @param  mixed $request
     * @return void
     */
    public function reporteCaracterizacion(Request $request)
    {
        $demanda = Collect(DB::select('exec dbo. ?,?', [$request->fechaInicial, $request->fechaFinal]));
        $array = json_decode($demanda, true);
        return (new FastExcel($array))->download('.xls');
    }


    public function auditoriaCaracterizacion($id)
    {
        try {
            $auditoria = $this->caracterizacionService->auditoriaCaracterizacion($id);
            return response()->json($auditoria, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'No se puede generar la auditoria de la caracterizacion'
            ]);
        }
    }

    /**
     * Guarda la caracterizacion ECIS de un afiliado
     * @param GuardarCaracterizacionEcisRequest $request
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function guardarCaracterizacionEcis(GuardarCaracterizacionEcisRequest $request): JsonResponse
    {
        try {
            $response = $this->caracterizacionEcisService->guardarCaracterizacionEcis($request->validated());
            return response()->json($response, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Busca la caracterizacion ECIS de un afiliado
     * @param BuscarCaracterizacionEcisRequest $request
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function buscarCaracterizacionEcisAfiliado(BuscarCaracterizacionEcisRequest $request): JsonResponse
    {
        try {
            $response = $this->caracterizacionEcisService->buscarCaracterizacionEcisAfiliado($request->validated());
            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Funcion que agrega un integrante a la caracterizacion ECIS de un afiliado
     * @param AgregarIntegranteCaracterizacionEcisRequest $request
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function agregarIntegranteCaracterizacionEcis(AgregarIntegranteCaracterizacionEcisRequest $request): JsonResponse
    {
        try {
            $response = $this->integrantesFamiliaCaracterizacionEcisService->agregarIntegranteCaracterizacionEcis($request->validated());
            return response()->json($response, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Funcion que lista los integrantes de la familia de un afiliado
     * @param int $afiliado_id
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function listarIntegrantesFamilia(int $afiliado_id): JsonResponse
    {
        try {
            $response = $this->integrantesFamiliaCaracterizacionEcisRepository->listarIntegrantesFamilia($afiliado_id);
            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Funcion que elimina un integrante de la familia de un afiliado
     * @param int $integrante_id
     * @param int $afiliado_id
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function eliminarIntegranteFamiliaAfiliado(int $integrante_id, int $afiliado_id): JsonResponse
    {
        try {
            $response = $this->integrantesFamiliaCaracterizacionEcisRepository->eliminarIntegranteFamiliaAfiliado($integrante_id, $afiliado_id);
            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Funcion que agrega un integrante existente a la familia de un afiliado
     * @param AsociarIntegranteExistenteRequest $request
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function asociarIntegranteExistente(AsociarIntegranteExistenteRequest $request): JsonResponse
    {
        try {
            $response = $this->integrantesFamiliaCaracterizacionEcisService->asociarIntegranteExistente($request->validated());
            return response()->json($response, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Funcion que valida la caracterizacion ECIS de un afiliado
     * @param int $afiliadoId
     * @return JsonResponse
     * @author Thomas
     */
    public function validarCaracterizacionEcis(int $afiliadoId): JsonResponse
    {
        try {
            $response = $this->caracterizacionEcisRepository->validarCaracterizacionEcis($afiliadoId);
            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


}
