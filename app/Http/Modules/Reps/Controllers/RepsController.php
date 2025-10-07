<?php

namespace App\Http\Modules\Reps\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\Reps\Models\Rep;
use App\Http\Modules\Reps\Services\RepsService;
use App\Http\Modules\Reps\Repositories\RepsRepository;
use App\Http\Modules\Reps\Requests\GuardarRepsRequest;
use App\Http\Modules\Reps\Requests\ActualizarRepsRequest;
use App\Http\Modules\Reps\Models\ParametrizacionCupPrestador;
use App\Http\Modules\Reps\Repositories\ParametrizacionCupPrestadoresRepository;

class RepsController extends Controller
{
    public function __construct(protected RepsService $repsService, protected RepsRepository $repsRepository, protected ParametrizacionCupPrestadoresRepository $parametrizacionCupPrestadorRepository)
    {}

    /**
     * Lista las reps
     * @param Request $request
     * @return Response $sede
     * @author David Peláez
     * @edit kobatime
     */
    public function listar(Request $request)
    {
        try {
            $sede = $this->repsRepository->listarFiltro($request);
            return response()->json($sede, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Almacena una reps
     * @param Request $request
     * @return JsonResponse $sede
     * @author David Peláez
     */
    public function crear(GuardarRepsRequest $request)
    {
        try {
            $sede = $this->repsService->crear($request->validated());
            return response()->json($sede, 201);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * actualiza una reps
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @author David Peláez
     */
    public function actualizar(ActualizarRepsRequest $request, $id)
    {
        try {
            $rep = $this->repsRepository->consultar('id', $id, $request->with);
            $this->repsRepository->actualizar($rep, $request->validated());
            return response()->json($rep);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * consulta un rep
     * @param Request $request
     * @param $reps
     * @return JsonResponse
     * @author David Peláez
     */
    public function consultar(Rep $reps)
    {
        try {
            return response()->json($reps);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Cambia el estado de un reps
     * @param Request $request
     * @param Rep $rep
     * @return Response
     * @author David Peláez
     */
    public function cambiarEstado(Request $request, Rep $rep)
    {
        try {
            $cambio = $this->repsService->cambioEstado($rep, $request->all());
            return response()->json(['data' => $cambio, 'mensaje' => 'Se actualizo correctamente'], 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }


    /**
     * Lista las reps
     * @param Request $request
     * @return Response $sede
     * @author jdss
     */
    public function listarSinfiltro(Request $request)
    {
        try {
            $sede = $this->repsRepository->listar($request);
            return response()->json($sede, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Lista las reps
     * @param Request $request
     * @return Response $sede
     * @author jdss
     */
    public function listarConfiltro(Request $request)
    {
        try {
            $sede = $this->repsRepository->listarConfiltro($request);
            return response()->json($sede, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * listarPropias - lista los reps propios
     *
     * @param  mixed $request
     * @return void
     */
    public function listarPropias()
    {
        try {
            $sede = $this->repsRepository->listarPropias();
            return response()->json($sede, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function buscarRep($codigoONombre)
    {
        try {
            $reps = $this->repsRepository->buscarPorCodigoONombre($codigoONombre);

            if ($reps->isEmpty()) {
                return response()->json('No se encontraron Reps con el código o nombre proporcionado', Response::HTTP_NOT_FOUND);
            } else {
                return response()->json($reps, Response::HTTP_OK);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarSedesUsuario(Request $request)
    {
        try {
            $sedesUsuario = $this->repsRepository->listarSedesUsuario($request);
            return response()->json($sedesUsuario, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function listarFarmaciasSumi(Request $request)
    {
        try {
            $sedes = $this->repsRepository->listarFarmaciasSumi();
            return response()->json($sedes, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function actualizarPrestador($rep_id, $prestador_id)
    {
        try {
            $rep = $this->repsRepository->actualizarPrestador($rep_id, $prestador_id);
            return response()->json(['message' => 'Prestador actualizado correctamente', 'rep' => $rep], 200);
        } catch (\Exception $th) {
            return response()->json(['error' => 'Error al actualizar el prestador: ' . $th->getMessage()], 400);
        }
    }
    public function listarPorPrestador(Request $request, string $prestador_id)
    {
        try {
            $prestadores = $this->repsRepository->listarPorPrestador($prestador_id);
            return response()->json($prestadores);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * lista las sedes deacuerdo a las entidades del usuario logueado
     *
     * @return void
     * @author Manuela
     */
    public function listarPorEntidad(Request $request)
    {
        try {
            $user_id = auth()->id();
            $reps = $this->repsRepository->listarPorEntidad($user_id);
            return response()->json($reps, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    public function cupsPrestador()
    {
        try {
            $parametrizaciones = $this->parametrizacionCupPrestadorRepository->listarParametrizacion();
            return response()->json($parametrizaciones);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function guardarParametrizacionCup(Request $request)
    {
        try {
            $this->parametrizacionCupPrestadorRepository->crear($request->all());
            return response()->json(['mensaje' => 'Datos Guardados']);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function eliminarParametrizacionCup($id)
    {
        try {
            $this->parametrizacionCupPrestadorRepository->eliminar($id);
            return response()->json(['mensaje' => 'Datos Actualizados']);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function parametrizacionCategoriaSede($id)
    {
        return $categorias = ParametrizacionCupPrestador::select('categoria')
            ->where('rep_id',$id)
            ->distinct()
            ->get();
        return response()->json($categorias);
    }

    public function consultarRep(Request $request, int $id)
    {
        try {
            $reps = $this->repsRepository->consultarReps($request->all(), $id);
            return response()->json($reps, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Ha ocurrido un Error al consultar Rep'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function actualizarReps(Request $request, $id)
    {
        try {
            $reps = $this->repsService->actualizarRep($request->all(), $id);
            return response()->json($reps, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Ha ocurrido un Error al Actualizar'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Lista los reps para el direccionamiento de servicios
     * @param Request $request
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function listarRepsDireccionamientoServicios(Request $request): JsonResponse
    {
        try {
            $reps = $this->repsRepository->listarRepsDireccionamientoServicios($request->all());
            return response()->json($reps, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Lista los reps para el direccionamiento de codigos propios
     * @param Request $request
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function listarRepsDireccionamientoCodigosPropios(Request $request): JsonResponse
    {
        try {
            $reps = $this->repsRepository->listarRepsDireccionamientoCodigosPropios($request->all());
            return response()->json($reps);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], 500);
        }
    }

    /**
     * Lista los reps para el direccionamiento de medicamentos
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function listarRepsDireccionamientoMedicamentos(): JsonResponse
    {
        try {
            $reps = $this->repsRepository->listarRepsDireccionamientoMedicamentos();
            return response()->json($reps);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], 500);
        }
    }
    /**
     * listar tosas las reps y cacharlas con REDIS
     *
     * @return void
     * @author Calvarez
     */
    public function listarRepsCachados()
    {
        try {
            $reps = $this->repsRepository->listarRepsCachados();
            return response()->json($reps);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     *
     */
    public function listarRepsPropiosActivos() {
        try {
            $repsPropios = $this->repsRepository->listarPropiosActivos();
            return response()->json($repsPropios, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Huno un error al listar los reps propios'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
