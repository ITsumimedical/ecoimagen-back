<?php

namespace App\Http\Modules\Prestadores\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Prestadores\Models\Prestador;
use App\Http\Modules\Prestadores\Services\PrestadorService;
use App\Http\Modules\Prestadores\Repositories\PrestadorRepository;
use App\Http\Modules\Prestadores\Requests\GuardarPrestadorRequest;
use App\Http\Modules\Prestadores\Requests\ActualizarPrestadorRequest;
use App\Http\Modules\Prestadores\Requests\FiltroTablaPrestadorRequest;
use App\Http\Modules\Prestadores\Requests\FiltroFacturasPrestadorRequest;

class PrestadorController extends Controller
{
    protected $repository;
    protected $service;

    public function __construct()
    {
        $this->repository = new PrestadorRepository();
        $this->service = new PrestadorService();
    }

    /**
     * Lista lor prestadores
     * @param Request $request
     * @return Response $prestadores
     * @author David Peláez
     * @edit Kobatime
     */
    public function listar(Request $request)
    {
        try {
            $prestadores = $this->repository->listarPrestadores($request);
            return response()->json([
                'data' => $prestadores
            ], 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Lista lor prestadores en contratos
     * @param Request $request
     * @return Response $prestadores
     * @author kobatime
     */
    public function prestadoresContrato(Request $request)
    {
        try {
            $prestadores = $this->repository->listarPrestadoresConFiltro($request->filtro);
            return response()->json($prestadores);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function buscarPrestador(Request $request)
    {
        $nombre = $request->input('nombre');
        $nit = $request->input('nit');

        try {
            $prestadores = $this->repository->buscarPrestador($nombre, $nit);
            return response()->json($prestadores);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al buscar prestador'], 500);
        }
    }

    public function contratoActivo()
    {
        try {
            $prestadores = $this->repository->PrestadoresContractoActivo();
            return response()->json([
                'res' => true,
                'data' => $prestadores
            ], 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Almacena un prestador
     * @param GuardarPrestadorRequest $request
     * @return Response $prestadores
     * @author David Peláez
     */
    public function crear(GuardarPrestadorRequest $request): JsonResponse
    {

        try {
            $prestador = $this->repository->crear($request->validated());
            return response()->json($prestador, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza un prestador
     * @param ActualizarPrestadorRequest $request
     * @param Prestador $prestador
     * @author David Peláez
     */
    public function actualizar(ActualizarPrestadorRequest $request, Prestador $prestador)
    {
        try {
            $prestador_actualizado = $this->repository->actualizar($prestador, $request->validated());
            return response()->json($prestador_actualizado, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Consulta un prestador
     * @param Prestador $prestadores
     * @return Response
     * @author JDSS
     */
    public function consultar(Request $request, $id)
    {
        try {
            $prestador = $this->repository->consultar($request->clave, $id, $request->with);
            return response()->json($prestador);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Consulta los acumulados que tiene un prestador
     * @param Request $request
     * @return JsonResponse
     * @author JDSS
     * @modifiedBy Jose Vasquez
     */

    public function acumuladoPrestador(Request $request): JsonResponse
    {
        try {
            $prestador = $this->repository->acumuladoPrestador($request->all());
            return response()->json($prestador, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['mensaje' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Cambia el estado
     * @param Request $request
     * @param prestador $prestador
     * @return Response
     * @author kobatime
     */
    public function cambiarEstado(Request $request, Prestador $prestador)
    {
        try {
            $cambio = $this->service->cambioEstado($prestador, $request->all());
            return response()->json(['data' => $cambio, 'mensaje' => 'Se actualizo correctamente'], 200);
        } catch (\Throwable $th) {
            return response()->json(['mensaje' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * lista las facturas asignadas para el modulo de cuentas medicas
     * @return Response $asignadas
     * @author JDSS
     */
    public function misAsignadas(Request $request)
    {
        try {
            $asignadas = $this->repository->misAsignadas($request);
            return response()->json($asignadas, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['mensaje' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Lista las auditadas
     * @return Response $auditadas
     * @author JDSS
     */

    public function auditados(Request $request)
    {
        try {
            $auditadas = $this->repository->auditadas($request);
            return response()->json($auditadas, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['mensaje' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Lista las facturas en auditoria final
     * @return Response $auditadas
     * @author JDSS
     */

    public function auditoriaFinal(Request $request)
    {
        try {
            $auditadas = $this->repository->auditoriaFinal($request);
            return response()->json($auditadas, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['mensaje' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Lista las facturas conciliadas en auditoria final
     * @return Response $conciliacion
     * @author JDSS
     */

    public function conciliadasAuditoriaFinal(Request $request)
    {
        try {
            $conciliacion = $this->repository->conciliacionAuditoriaFinal($request);
            return response()->json($conciliacion, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['mensaje' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Lista las facturas conciliadas en auditoria final
     * @return Response $conciliacion
     * @author JDSS
     */

    public function consiliadasConSaldo(Request $request)
    {
        try {
            $conciliacion = $this->repository->conciliacionConSaldo($request);
            return response()->json($conciliacion);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    /**
     * Lista las facturas cerradas
     * @return Response $auditadas
     * @author JDSS
     */

    public function auditoriaFinalCerradas(Request $request)
    {
        try {
            $auditadas = $this->repository->auditoriaFinalCerradas($request);
            return response()->json($auditadas);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    /**
     * listarExternos - lista los prestadores externos
     *
     * @param mixed $request
     * @return void
     */
    public function listarExternos(Request $request)
    {
        try {
            $prestadores = $this->repository->listarExternos($request);
            return response()->json([
                'res' => true,
                'data' => $prestadores
            ], 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * listarInternos - lista los prestadores internos
     *
     * @param mixed $request
     * @return void
     */
    public function listarInternos(Request $request)
    {
        try {
            $prestadores = $this->repository->listarInternos($request);
            return response()->json([
                'res' => true,
                'data' => $prestadores
            ], 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Lista las prestadores
     * @param Request $request
     * @return Response $prestadores
     * @author kobatime
     */
    public function listarConfiltro(Request $request)
    {
        try {
            $prestadores = $this->repository->listarConfiltro($request);
            return response()->json($prestadores, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * listarPrestadoresContratados - lista los prestadores con contrato activo
     *
     * @param mixed $request
     * @return void
     */
    public function listarPrestadoresContratados(Request $request)
    {
        try {
            $prestador = $this->repository->listarPrestadoresContratados($request);
            return response()->json($prestador, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * lista los prestadores
     * @param Request $request
     * @return Response
     * @author David Peláez
     */
    public function listarPrestadores(Request $request)
    {
        try {
            $prestadores = $this->repository->listarPrestadoresConFiltro($request->filtro);
            return response()->json($prestadores);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Verificar si un prestador ya tiene contrato
     * @param Request $request
     * @return Response
     * @author David Peláez
     */
    public function tieneContratoPrestador(int $prestador_id)
    {
        try {
            $prestadores = $this->service->tieneContrato($prestador_id);
            return response()->json($prestadores);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Lista los prestadores para los contratos de medicamentos
     * @param Request $request
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function listarPrestadoresContratosMedicamentos(Request $request): JsonResponse
    {
        try {
            $prestadores = $this->repository->listarPrestadoresContratosMedicamentos($request->all());
            return response()->json($prestadores, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => $th->getMessage(),
                'error' => 'Error al listar prestadores'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
