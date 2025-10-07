<?php

namespace App\Http\Modules\Entidad\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Entidad\Models\Entidad;
use App\Http\Modules\Entidad\Repositories\EntidadRepository;
use App\Http\Modules\Entidad\Requests\ActualizarEntidadRequest;
use App\Http\Modules\Entidad\Requests\CrearEntidadRequest;
use App\Http\Modules\Entidad\Services\EntidadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class EntidadController extends Controller
{
    private $repository;
    private $service;

    public function __construct()
    {
        /** Inicializar los atributos, Repository y Services */
        $this->repository = new EntidadRepository;
        $this->service = new EntidadService;
    }

    /**
     ** lista las entidades del usuario logueado
     * @param Request $request
     * @return Response
     * @author David Peláez
     */
    public function listar(Request $request)
    {
        try {
            $consulta = $this->repository->listarEntidades($request);
            return response()->json($consulta, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al intentar listar las entidades!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * listarTodas,  lista todas las entidades
     *
     * @param mixed $request
     * @return void
     */
    public function listarTodas(Request $request): JsonResponse
    {
        try {
            $entidad = $this->repository->listar($request);
            return response()->json($entidad, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar las entidades',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarNoTiene(Request $request)
    {
        try {
            $consulta = $this->repository->listarNoTiene($request);
            return response()->json($consulta, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'res' => false,
                'mensaje' => 'Error al intentar listar las entidades!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     ** Almacena una entidad
     * @param Request $request
     * @return Response
     * @author David Peláez
     */
    public function crear(CrearEntidadRequest $request): JsonResponse
    {
        try {
            $entidad = $this->repository->crear($request->validated());
            return response()->json([
                'res' => true,
                'data' => $entidad,
                'mensaje' => 'La entidad fue creada con exito!'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * *Actualiza una entidad
     * @param Request $request
     * @param Entidad $entidad
     * @return Response
     * @author kobatime
     */
    public function actualizar(ActualizarEntidadRequest $request, int $id)
    {
        try {
            $entidad = $this->repository->buscar($id);
            $entidad->fill($request->except('imagenes'));
            $actualizarEntidad = $this->repository->guardar($entidad);
            return response()->json([
                'res' => true,
                'data' => $actualizarEntidad,
                'mensaje' => 'La entidad fue actualizada con exito!'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al intentar actualizar la entidad!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * *cambia el estado de una entidad
     * @param Request $request
     * @param Entidad $entidad
     * @return Response
     * @author David Peláez
     */
    public function consultar(Request $request, $id)
    {
        try {
            $entidad = Entidad::where('id', $id)->firtsOrFail();
            return response()->json($entidad, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * *Buscar por nombre la entidad
     * @param Request $request
     * @return Response
     * @author kobatime
     */
    public function buscar(Request $request)
    {
        try {
            $buscar = $this->repository->consultarLike('nombre', $request->nombre);
            return response()->json([
                'res' => true,
                'data' => $buscar,
                'mensaje' => 'La entidad fue consultada con exito!'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al intentar consultar las entidades!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function validar($entidad, $accion)
    {
        try {
            $entidad = $this->repository->validar($entidad, $accion);
            return response()->json($entidad, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     ** lista las entidades fomag y ferro en select, para generar rips
     * @param Request $request
     * @return Response
     * @author Manuela
     */
    public function listarFomagFerroRips(Request $request)
    {
        try {
            $consulta = $this->repository->listarEntidadesFomagFerro($request);
            return response()->json($consulta, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al intentar listar las entidades!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Lista las entidades del usuario loggeado
     * @return JsonResponse
     * @throws Throwable
     * @author Thomas
     */
    public function listarEntidadesUsuario(): JsonResponse
    {
        try {
            $entidades = $this->repository->listarEntidadesUsuario();
            return response()->json($entidades, Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al intentar listar las entidades!'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
