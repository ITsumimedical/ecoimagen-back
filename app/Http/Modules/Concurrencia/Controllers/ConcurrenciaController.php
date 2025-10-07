<?php

namespace App\Http\Modules\Concurrencia\Controllers;

use App\Http\Modules\Concurrencia\Repositories\ConcurrenciaRepository;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\Concurrencia\Requests\ActualizarConcurrenciaRequest;
use App\Http\Modules\Concurrencia\Requests\CrearComplementoIngresoRequest;
use App\Http\Modules\Concurrencia\Requests\CrearConcurrenciaRequest;
use App\Http\Modules\Concurrencia\Requests\CrearOrdenamientoConcurrenciaRequest;
use App\Http\Modules\Concurrencia\Requests\CrearSeguimientoConcurrenciaRequest;
use App\Http\Modules\Concurrencia\Requests\IngresoConcurrenciaRequest;
use Illuminate\Http\Request;

class ConcurrenciaController extends Controller
{

    public function __construct(protected ConcurrenciaRepository $concurenciaRepository)
    {
    }

    public function crearIngreso(IngresoConcurrenciaRequest $request) {
        try {
            $concurrencia = $this->concurenciaRepository->crearIngreso($request);
            return response()->json($concurrencia, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al registrar la el ingreso a concurrencia',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function crearConcurrencia(CrearConcurrenciaRequest $request) {
        try {
            $concurrencia = $this->concurenciaRepository->crearConcurrencia($request);
            return response()->json($concurrencia, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al registrar la concurrencia',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarIngreso(Request $request){
        try {
            $ingreso = $this->concurenciaRepository->listarIngreso($request);
            return response()->json($ingreso, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'message' => 'Error al listar los ingresos',
                'error' => $th->getMessage()
            ], 400);
        }
    }

    public function actualizarIngreso(IngresoConcurrenciaRequest $request) {
        try {
            $concurrencia = $this->concurenciaRepository->actualizarIngreso($request);
            return response()->json($concurrencia, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al registrar la concurrencia',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizarConcurrencia(ActualizarConcurrenciaRequest $request) {
        try {
            $concurrencia = $this->concurenciaRepository->actualizarConcurrencia($request);
            return response()->json($concurrencia, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al registrar la concurrencia',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizarSeguimiento(CrearSeguimientoConcurrenciaRequest $request) {
        try {
            $concurrencia = $this->concurenciaRepository->actualizarSeguimiento($request);
            return response()->json($concurrencia, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al registrar la concurrencia',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function contadorSeguimiento()
    {
        try {
            $resultado = $this->concurenciaRepository->contadorSeguimientos();
            return response()->json(
                $resultado
            , Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al contar las concurrencias',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarConcurrencia()
    {
        try {
            $resultado = $this->concurenciaRepository->listarConcurrencias();
            return response()->json(
                $resultado
                , Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al contar las concurrencias',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarConcurrenciasIngreso($id)
    {
        try {
            $resultado = $this->concurenciaRepository->listarConcurrenciasIngreso($id);
            return response()->json(
                $resultado
                , Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al contar las concurrencias',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function complemento(CrearComplementoIngresoRequest $request) {
        try {
            $concurrencia = $this->concurenciaRepository->guardarComplementoConcurrencia($request);
            return response()->json($concurrencia, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al registrar el complemento de la concurrencia',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarComplementos($id)
    {
        try {
            $complemento = $this->concurenciaRepository->listarComplementos($id);
            return response()->json($complemento, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error listar los complementos',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function eliminarComplementos(Request $request)
    {
        try {
            $complemento = $this->concurenciaRepository->eliminarComplementoConcurrencia($request);
            return response()->json($complemento, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al eliminar los complementos',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function ordenamiento(CrearOrdenamientoConcurrenciaRequest $request) {
        try {
            $concurrencia = $this->concurenciaRepository->guardarOrdenamientoConcurrencia($request);
            return response()->json($concurrencia, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al registrar el complemento de la concurrencia',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarOrdenamientos($id)
    {
        try {
            $orden = $this->concurenciaRepository->listarOrdenes($id);
            return response()->json($orden, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error listar los complementos',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function eliminarOrdenamientos(Request $request)
    {
        try {
            $complemento = $this->concurenciaRepository->eliminarOrden($request);
            return response()->json($complemento, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al eliminar los complementos',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function crearSeguimiento(CrearSeguimientoConcurrenciaRequest $request) {
        try {
            $concurrencia = $this->concurenciaRepository->guardarSeguimiento($request);
            return response()->json($concurrencia, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al registrar el seguimiento de la concurrencia',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarSeguimiento($id)
    {
        try {
            $orden = $this->concurenciaRepository->listarSeguimiento($id);
            return response()->json($orden, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error listar los seguimientos',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarAlta(Request $request){
        try {
            $ingreso = $this->concurenciaRepository->listarAlta($request);
            return response()->json($ingreso, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'message' => 'Error al listar los registros de alta',
                'error' => $th->getMessage()
            ], 400);
        }
    }

    public function reabrir(Request $request){
        try {
            $concurrencia = $this->concurenciaRepository->reabrir($request);
            return response()->json($concurrencia, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'message' => 'Error al reabrir el proceso de concurrencia',
                'error' => $th->getMessage()
            ], 400);
        }
    }

}
