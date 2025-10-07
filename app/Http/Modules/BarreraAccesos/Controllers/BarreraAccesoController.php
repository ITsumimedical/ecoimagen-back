<?php

namespace App\Http\Modules\BarreraAccesos\Controllers;

use App\Http\Modules\BarreraAccesos\Requests\CrearBarreraAccesoRequest;
use App\Http\Modules\BarreraAccesos\Repositories\BarreraAccesoRepository;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\BarreraAccesos\Requests\ActualizarBarreraAccesoRequest;
use App\Http\Modules\BarreraAccesos\Requests\CerrarSolucionarBarreraAccesoRequest;
use App\Http\Modules\BarreraAccesos\Requests\SolucionarCorregirAnularBarreraAccesoRequest;
use App\Http\Modules\BarreraAccesos\Services\BarreraAccesoService;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;

class BarreraAccesoController extends Controller
{

    public function __construct(protected BarreraAccesoService $barreraAccesoService, protected BarreraAccesoRepository $barreraAccesoRepository) {}

    /**
     * lista los cups
     * @param Request $request
     * @return Response
     * @author kobatime
     */
    // public function listar(Request $request)
    // {
    //     try {
    //         $barrera = $this->barreraAccesoRepository->listarBarrera($request->all());
    //         if (isset($resultado['error'])) {
    //             return response()->json(['mensaje' => $resultado['mensaje']], 500);
    //         }
    //         return response()->json($barrera, 200);
    //     } catch (\Throwable $th) {
    //         return response()->json([
    //             'mensaje' => 'Error al registrar la barrera de acceso',
    //         ], Response::HTTP_BAD_REQUEST);
    //     }
    // }

    /**
     * Crear las barreras de acceso
     * @param CrearBarreraAccesoRequest $request
     * @return Response
     * @author Sofia O
     */
    public function crear(CrearBarreraAccesoRequest $request)
    {
        try {
            $resultado = $this->barreraAccesoService->crearBarrera($request->validated());
            return response()->json([
                $resultado,
                'mensaje' => 'La barrera de acceso fue registrada con exito.'
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al registrar la barrera de acceso',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualizar la barreras de acceso
     * @param ActualizarBarreraAccesoRequest $request
     * @return Response
     * @author Sofia O
     */
    public function actualizar(ActualizarBarreraAccesoRequest $request, $id)
    {
        try {
            $resultado = $this->barreraAccesoService->actualizarBarrera($request->validated(), $id);
            return response()->json([
                $resultado,
                'mensaje' => 'La barrera de acceso fue actualizada con exito.'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al actualizada la barrera de acceso',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Exportar excel barreras de acceso
     * @param Request $request
     * @return Response
     */
    public function exportar(Request $request)
    {
        try {
            $resultado = $this->barreraAccesoRepository->exportar($request->all());
            return response()->json($resultado, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al recuperar la información.',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * listar las barreras de acceso pendientes
     * @param Request $request
     * @return Response
     * @author Sofia O
     */
    public function listarBarrerasPendientes(Request $request)
    {
        try {
            $pendientes = $this->barreraAccesoRepository->listarPendientes($request->all());
            return response()->json($pendientes, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al listar los pendientes'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Listar las barreras de acceso asigandas
     * @param Request $request
     * @return responsa
     * @author Sofia O
     */
    public function listarBarrerasAsignadas(Request $request)
    {
        try {
            $asignadas = $this->barreraAccesoRepository->listarAsignadas($request->all());
            return response()->json($asignadas, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al listar las asignadas'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Listar las barreras de acceso pre-solucionadas
     * @param Request $request
     * @return responsa
     * @author Sofia O
     */
    public function listarBarrerasPresolucionadas(Request $request)
    {
        try {
            $presolucionadas = $this->barreraAccesoRepository->listarPresolucionadas($request->all());
            return response()->json($presolucionadas, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al listar las asignadas'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Listar las barraras de acceso solucionas o anuladas
     * @param Request $request
     * @return Response
     * @author Sofia O
     */
    public function listarBarrerasSolucionadasAnuladas(Request $request)
    {
        try {
            $solucionadasAnuladas = $this->barreraAccesoService->listarSolucionadasAnuladas($request->all());
            return response()->json($solucionadasAnuladas, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al listar las solucionas y anulados'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Observacion final y cierre solucionar, corregir y anular - Actualizar estado
     * @param CerrarSolucionarBarreraAccesoRequest $request
     * @param int $id
     * @return Response
     * @author Sofia O
     */
    public function solucionarAnularBarreraAcceso(CerrarSolucionarBarreraAccesoRequest $request, $id)
    {
        try {
            $cierre = $this->barreraAccesoService->solucionar($request->validated(), $id);
            return response()->json($cierre, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al cambiar el estado y cerrar la barrera de acceso.',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Asignar responsable de la barrera de acceso
     * @param Request $request
     * @return Response
     * @author Sofia O
     */
    public function asignarAreaResponsable(Request $request)
    {
        try {
            $asignar = $this->barreraAccesoService->asignar($request->all());
            return response()->json($asignar, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al asignar los responsables a la barrera de acceso',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Reasignar responsable de la barrera de acceso
     * @param Request $request
     * @return Response
     * @author Sofia O
     */
    public function reasignarAreaResponsable(Request $request)
    {
        try {
            $reasignar = $this->barreraAccesoService->reasignar($request->all());
            return response()->json($reasignar, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al reasignar los responsables a la barrera de acceso',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Listar las barreras repostadas por el user logueado
     * @param Request $request
     * @return Response
     * @author Sofia O
     */
    public function listarBarrerasRegistradasUser(Request $request)
    {
        try {
            $listasBarrerasUser = $this->barreraAccesoService->listarRegistradasUser($request->all());
            return response()->json($listasBarrerasUser, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al listar las barrera de acceso registradas por el user',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Listar las barreras asignadas al user logueado
     * @param Request $request
     * @return Response
     * @author Sofia O
     */
    public function listarBarrerasAsignadasUser(Request $request)
    {
        try {
            $listasBarrerasUser = $this->barreraAccesoRepository->listarAsignadasUser($request->all());
            return response()->json($listasBarrerasUser, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al listar las barrera de acceso registradas por el user',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Listar las barreras solucionadas o anuladas al user logueado
     * @param Request $request
     * @return Response
     * @author Sofia O
     */
    public function listarBarrerasSolucionadasAnuladasUser(Request $request)
    {
        try {
            $listasBarrerasUser = $this->barreraAccesoService->listarSolucionadasAnuladasUser($request->all());
            return response()->json($listasBarrerasUser, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al listar las barrera de acceso registradas por el user',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
