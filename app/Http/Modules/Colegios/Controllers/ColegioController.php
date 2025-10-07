<?php

namespace App\Http\Modules\Colegios\Controllers;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\Colegios\Requests\CrearColegioRequest;
use App\Http\Modules\Colegios\Repositories\ColegioRepository;
use App\Http\Modules\Colegios\Services\ColegioService;
use Illuminate\Http\Request;

class ColegioController extends Controller
{
    protected $colegioRepository;
    protected $colegioService;

    public function __construct(ColegioRepository $colegioRepository, ColegioService $colegioService)
    {
        $this->colegioRepository = $colegioRepository;
        $this->colegioService = $colegioService;
    }

    /**
     * Registrar un nuevo colegio.
     *
     * @param CrearColegioRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registrarColegio(CrearColegioRequest $request)
    {
        try {
            $this->colegioRepository->crear($request->validated());
            return response()->json([
                'mensaje' => 'El colegio fue registrado con éxito.'
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al registrar el colegio',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Listar colegios activos.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function listarColegios()
    {
        try {
            $colegios = $this->colegioRepository->listarColegios();
            return response()->json($colegios, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Listar todos los colegios.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function listarTodos()
    {
        try {
            $colegios = $this->colegioRepository->listarTodos();
            return response()->json($colegios, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Inactivar un colegio.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function inactivarColegio(Request $request)
    {
        try {
            $colegio = $this->colegioRepository->buscar($request->id);

            if (!$colegio) {
                return response()->json([
                    'mensaje' => 'Colegio no encontrado.'
                ], Response::HTTP_NOT_FOUND);
            }

            $colegio->fill(['estado' => false]);
            $this->colegioRepository->guardar($colegio);

            return response()->json([
                'mensaje' => 'Colegio inactivado con éxito.'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al inactivar el colegio',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Activar un colegio.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function activarColegio(Request $request)
    {
        try {
            $colegio = $this->colegioRepository->buscar($request->id);

            if (!$colegio) {
                return response()->json([
                    'mensaje' => 'Colegio no encontrado.'
                ], Response::HTTP_NOT_FOUND);
            }

            $colegio->fill(['estado' => true]);
            $this->colegioRepository->guardar($colegio);

            return response()->json([
                'mensaje' => 'Colegio activado con éxito.'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al activar el colegio',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Buscar un colegio por nombre.
     *
     * @param string $nombre
     * @return \Illuminate\Http\JsonResponse
     */
    public function buscarColegio(string $nombre)
    {
        try {
            $colegios = $this->colegioRepository->buscarColegioPorNombre($nombre);

            if ($colegios->isEmpty()) {
                return response()->json([
                    'mensaje' => 'No se encontraron colegios con el nombre proporcionado.'
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json($colegios, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al buscar el colegio',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Listar colegios por departamento.
     *
     * @param int $departamento_id
     * @return \Illuminate\Http\JsonResponse
     * @author kobatime
     * @since 18 agosto 2024
     */
    public function listarColegioDepartamento(int $departamento_id)
    {
        try {
            $colegios = $this->colegioService->listarColegiosDepartamento($departamento_id);
            return response()->json($colegios, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al buscar los colegios por departamento',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
