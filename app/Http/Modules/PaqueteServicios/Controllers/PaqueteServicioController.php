<?php

namespace App\Http\Modules\PaqueteServicios\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\PaqueteServicios\Models\PaqueteServicio;
use App\Http\Modules\PaqueteServicios\Repositories\PaqueteServicioRepository;
use App\Http\Modules\PaqueteServicios\Requests\GuardarPaqueteServicioRequest;
use App\Http\Modules\PaqueteServicios\Requests\ActualizarPaqueteServicioRequest;
use App\Http\Modules\PaqueteServicios\Services\PaqueteServicioService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

class PaqueteServicioController extends Controller
{

    private $repository;
    private $service;

    public function __construct()
    {
        $this->repository = new PaqueteServicioRepository();
        $this->service = new PaqueteServicioService();
    }

    /**
     * lista los paquetes
     * @return Response
     * @author kobatime
     */
    public function listar(Request $request)
    {
        try {
            $paqueteServicio = $this->repository->listar($request);
            return response()->json($paqueteServicio, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Almacena un paquete
     * @param GuardarPaqueteServicioRequest $request
     * @return Response
     * @author kobatime
     */
    public function crear(GuardarPaqueteServicioRequest $request)
    {
        try {
            $nuevoPaqueteServicio = $this->repository->crear($request->validated());
            return response()->json($nuevoPaqueteServicio, 201);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * actualiza un paquete según su i
     * @param ActualizarPaqueteServicioRequest $request
     * @param PaqueteServicio $paquete_servicio
     * @return Response
     * @author David Peláez
     */
    public function actualizar(ActualizarPaqueteServicioRequest $request, PaqueteServicio $paquete_servicio)
    {
        try {
            $paquete_servicio->update($request->validated());
            return response()->json($paquete_servicio, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Consulta un paquete de servicios
     * @param Request $request
     * @param Response $response
     * @author David Peláez
     */
    public function consultar(Request $request, $id)
    {
        try {
            $paquete_servicio = PaqueteServicio::where('id', $id)->first();
            return response()->json($paquete_servicio);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Cambia el estado de un tipo de prestador
     * @param Request $request
     * @param PaqueteServicio $paquete_servicio
     * @return Response
     * @author David Peláez
     */
    public function cambiarEstado(Request $request, PaqueteServicio $paquete_servicio)
    {
        try {
            $paquete_servicio->cambiarEstado();
            return response()->json($paquete_servicio);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function agregarCup(Request $request, int $paquete_id)
    {
        try {
            $paquete_servicio = $this->service->agregarCup($request->all(), $paquete_id);
            return response()->json($paquete_servicio);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function listarCupsPorPaquete($request)
    {
        try {
            $cups = $this->repository->listarCupsPorPaquete($request);
            return response()->json($cups, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function eliminarCupPaquete(Request $request)
    {
        try {
            $cup_id = $request->input('cup_id');
            $paquete_id = $request->input('paquete_id');

            $deleted = $this->repository->deleteCupPaquete($cup_id, $paquete_id);

            if ($deleted) {
                return response()->json(['message' => 'Registro eliminado correctamente'], 200);
            } else {
                return response()->json(['message' => 'Registro no encontrado o no eliminado'], 404);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function listarCodigosPropiosPorPaquete($request)
    {
        try {
            $codigos_propios = $this->repository->listarCodigosPropiosPorPaquete($request);
            return response()->json($codigos_propios, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function agregarCodigoPropio(Request $request, int $paquete_id)
    {
        try {
            $paquete_servicio = $this->service->agregarCodigoPropio($request->all(), $paquete_id);
            return response()->json($paquete_servicio);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function eliminarCodigoPropioPaquete(Request $request)
    {
        try {
            $codigo_propio_id = $request->input('codigo_propio_id');
            $paquete_id = $request->input('paquete_id');

            $deleted = $this->repository->deleteCodigoPropioPaquete($codigo_propio_id, $paquete_id);

            if ($deleted) {
                return response()->json(['message' => 'Registro eliminado correctamente'], 200);
            } else {
                return response()->json(['message' => 'Registro no encontrado o no eliminado'], 404);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function buscarPaqueteServicio($nombre)
    {
        try {
            $cup = $this->repository->buscarPaqueteServicio($nombre);
            if ($cup === null) {
                return response()->json('No se encontraron CUPs con el nombre proporcionado', Response::HTTP_NOT_FOUND);
            } else {
                return response()->json($cup, Response::HTTP_OK);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
