<?php

namespace App\Http\Modules\AdmisionesUrgencias\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\AdmisionesUrgencias\Repositories\AdmisionesUrgenciaRepository;
use App\Http\Modules\AdmisionesUrgencias\Request\GuardarAdmisionUrgenciaRequest;
use App\Http\Modules\AdmisionesUrgencias\Requests\ActualizarEstadoRequest;
use App\Http\Modules\AdmisionesUrgencias\Requests\FirmaAcompananteAdmisionRequest;
use App\Http\Modules\AdmisionesUrgencias\Requests\FirmaAfiliadoAdmisionRequest;
use App\Http\Modules\AdmisionesUrgencias\Requests\InasistirAdmisionRequest;
use App\Http\Modules\AdmisionesUrgencias\Requests\ListarAdmisionEvolucionRequest;
use App\Http\Modules\AdmisionesUrgencias\Services\AdmisionesUrgenciaService;
use App\Http\Modules\Contratos\Repositories\ContratoRepository;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdmisionesUrgenciaController extends Controller
{

    public function __construct(
        protected AdmisionesUrgenciaRepository $admisionesUrgenciaRepository,
        protected AdmisionesUrgenciaService $admisionesUrgenciaService,
        private ContratoRepository $repository,
    ) {
    }



    /**
     * Listar admisiones activas.
     * Manuela
     */
    public function index()
    {
        try {
            $admisiones = $this->admisionesUrgenciaRepository->getAdmisionesActivas();
            return response()->json($admisiones);
        } catch (\Throwable $th) {
            return response()->json([
                'Error' => $th->getMessage()
            ], 500);
        }

    }

    /**
     * Guarda una nueva admisión
     * @param GuardarAdmisionUrgenciaRequest $request
     * @return JsonResponse
     * @author Manuela
     * @modifiedBy Thomas - 12 Mayo 2025
     */
    public function store(GuardarAdmisionUrgenciaRequest $request): JsonResponse
    {
        try {
            $admision = $this->admisionesUrgenciaService->guardarAdmision($request->validated());
            return response()->json($admision);
        } catch (\Throwable $th) {
            return response()->json([
                'Error' => $th->getMessage()
            ], 500);
        }

    }


    public function listarTodosContratos(Request $request): JsonResponse
    {
        try {
            $contratos = $this->repository->listarContrato($request);
            return response()->json($contratos, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error al obtener los contratos.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * Guarda la firma del afiliado
     * @param Request $request
     * @return Response $admision
     * @author JDSS
     */
    public function firmaAfiliado(FirmaAfiliadoAdmisionRequest $request)
    {
        try {
            $admision = $this->admisionesUrgenciaRepository->firmaAfiliado($request->validated());
            return response()->json($admision);
        } catch (\Throwable $th) {
            return response()->json([
                'Error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Guarda la firma del acompañante
     * @param Request $request
     * @return Response $admision
     * @author JDSS
     */
    public function firmaAcompañante(FirmaAcompananteAdmisionRequest $request)
    {
        try {
            $admision = $this->admisionesUrgenciaRepository->firmaAcompañante($request->validated());
            return response()->json($admision);
        } catch (\Throwable $th) {
            return response()->json([
                'Error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Se inasiste la admision y se guarda la observacion
     * @param Request $request
     * @return Response $admision
     * @author JDSS
     */

    public function inasistir(InasistirAdmisionRequest $request)
    {
        try {
            $admision = $this->admisionesUrgenciaRepository->inasistir($request->validated());
            return response()->json($admision);
        } catch (\Throwable $th) {
            return response()->json([
                'Error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Se cambia el estado de la admision
     * @param Request $request
     * @return Response $admision
     * @author JDSS
     */
    public function actualizarEstadoAdmision(ActualizarEstadoRequest $request)
    {
        try {
            $admision = $this->admisionesUrgenciaRepository->actualizarEstadoAdmision($request->validated());
            return response()->json($admision);
        } catch (\Throwable $th) {
            return response()->json([
                'Error' => $th->getMessage()
            ], 500);
        }
    }


    /**
     * Se lista las admisiones listas para evoluvion
     * @param Request $request
     * @return Response $admision
     * @author JDSS
     */
    public function listarAdmisionesUrgenciasEvolucion(ListarAdmisionEvolucionRequest $request)
    {
        try {
            $admision = $this->admisionesUrgenciaRepository->listarAdmisionesUrgenciasEvolucion($request->validated());
            return response()->json($admision);
        } catch (\Throwable $th) {
            return response()->json([
                'Error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Se lista las admisiones listas para evoluvion
     * @param Request $request
     * @return Response $admision
     * @author JDSS
     */
    public function listarAsignacionCama(ListarAdmisionEvolucionRequest $request)
    {
        try {
            $admision = $this->admisionesUrgenciaRepository->listarAsignacionCama($request->validated());
            return response()->json($admision);
        } catch (\Throwable $th) {
            return response()->json([
                'Error' => $th->getMessage()
            ], 500);
        }
    }

}
