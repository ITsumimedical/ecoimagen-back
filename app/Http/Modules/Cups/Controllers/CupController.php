<?php

namespace App\Http\Modules\Cups\Controllers;

use App\Http\Modules\Cups\Requests\EditarCupRequest;
use App\Http\Modules\Cups\Requests\GestionarEntidadesCups;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Modules\Cups\Models\Cup;
use App\Http\Modules\Cups\Repositories\CupEntidadRepository;
use App\Http\Modules\Cups\Repositories\CupRepository;
use App\Http\Modules\Cups\Requests\ActualizarCupRequest;
use App\Http\Modules\Cups\Requests\CrearCupRequest;
use App\Http\Modules\Cups\Requests\EditarCupEntidadRequest;
use App\Http\Modules\Cups\Services\CupService;

class CupController extends Controller
{

    public function __construct(protected CupRepository $cuprepository, protected CupService $cupservice, private readonly CupEntidadRepository $cupEntidadRepository)
    {
    }

    /**
     * lista los cups
     * @param Request $request
     * @return Response
     * @author kobatime
     */
    public function listar(Request $request)
    {
        try {
            $cups = $this->cuprepository->listarCups($request);
            return response()->json([
                'res' => true,
                'data' => $cups
            ], 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * guarda una familia
     * @param Request $request
     * @return Response
     * @author David Peláez
     */
    public function guardar(CrearCupRequest $request)
    {
        try {
            $familia = $this->cuprepository->crear($request->validated());
            return response()->json($familia, 201);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Actualiza una cup
     * @param Request $request
     * @param CupsFamilia $cup
     * @return Response
     * @author David Peláez
     */
    public function actualizar(ActualizarCupRequest $request, Cup $cup_id)
    {
        try {
            $cup = $this->cuprepository->actualizar($cup_id, $request->validated());
            return response()->json($cup);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), $th->getCode());
        }
    }

    /**
     * Cambia el estado de un cup
     * @param Request $request
     * @param Cup $cup
     * @return Response
     * @author David Peláez
     */
    public function cambiarEstado($cup_id)
    {
        try {
            $cups = $this->cuprepository->actualizarEstado($cup_id);
            return response()->json([
                'res' => true,
                'data' => $cups
            ], 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Consulta un cup
     * @param Request $request
     * @param int $id
     * @return Response
     * @author JDSS
     * @edit David Peláez
     */
    public function consultar(Request $request)
    {
        try {
            $cup_id = $request->input('cup_id');
            $cup = $this->cuprepository->consultarCupsId($cup_id);
            return response()->json($cup, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * subirArchivo
     *
     * @param mixed $request
     * @return void
     * @author kobatime
     */

    public function subirArchivo(Request $request)
    {
        try {
            $file = $request->file('file');
            $cups = $this->cupservice->cagar($file);

            if ($cups['resultado'] == false) {
                return response()->json([
                    'res' => false,
                    'mensaje' => $cups['Error'],
                ], 404);
            }

            return response()->json([
                'res' => true,
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al cargar el archivo',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function tarifasPrestador(Request $request)
    {
        try {
            $cups = $this->cuprepository->tarifaPrestadores($request->cup_id);
            return response()->json(
                $cups,
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al mostrar el contenido',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function ConsultarCupsNombreCodigo(Request $request)
    {
        try {
            $cups = $this->cuprepository->buscarCupNombreCodigo($request);
            return response()->json($cups, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar cups.'
            ]);
        }
    }

    // Funcion que toma el nombre o codigo del cup y lista los resultados coincidentes en la BD
    public function BuscarCup($nombre)
    {
        try {
            $cup = $this->cuprepository->getCups($nombre);
            if ($cup === null) {
                return response()->json('No se encontraron CUPs con el nombre proporcionado', Response::HTTP_NOT_FOUND);
            } else {
                return response()->json($cup, Response::HTTP_OK);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarTiposEducacion()
    {
        try {
            $cups = $this->cuprepository->listarCupsTiposEducacion();
            return response()->json($cups, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    public function asignarEntidades(Request $request, $cupId)
    {
        try {
            // Validar que el campo 'entidades' esté presente
            $entidades = $request->input('entidades');

            if (empty($entidades)) {
                return response()->json([
                    'Mensaje' => 'Debe proporcionar al menos una entidad.',
                ], 400); // Respuesta de error si el campo entidades está vacío
            }
            $cupConEntidades = $this->cuprepository->asignarEntidades($cupId, $entidades);

            return response()->json([
                $cupConEntidades
            ], 200);
        } catch (\Exception $th) {
            return response()->json([
                'Mensaje' => 'Ocurrió un error al asignar las entidades.',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function obtenerCupEntidad($cup_id)
    {
        try {
            $cupEntidad = $this->cuprepository->obtenerEntidadesAsignadas($cup_id);
            return response()->json($cupEntidad);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function guardarParametrosEntidad(Request $request)
    {
        try {
            $cupEntidad = $this->cuprepository->actualizarCupEntidad($request->all());
            return response()->json($cupEntidad);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }


    public function evaluarRequiereDiagnostico(Request $request)
    {
        try {
            $respuesta = $this->cupservice->evaluarRequiereDiagnostico($request->all());
            return response()->json($respuesta, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage(), Response::HTTP_BAD_REQUEST]);
        }
    }


    public function listarCupPorCita($cita_id)
    {
        try {
            $citas = $this->cuprepository->listarCupsPorCita($cita_id);
            return response()->json($citas, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Lista las entidades asignadas a un cup
     * @param int $cupId
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function listarEntidadesCup(int $cupId): JsonResponse
    {
        try {
            $entidades = $this->cuprepository->listarEntidadesCup($cupId);
            return response()->json($entidades, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Agrega entidades a un cup
     * @param GestionarEntidadesCups $request
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function agregarEntidadesCup(GestionarEntidadesCups $request): JsonResponse
    {
        try {
            $cups = $this->cuprepository->agregarEntidadesCup($request->validated());
            return response()->json($cups, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remueve entidades de un cup
     * @param GestionarEntidadesCups $request
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function removerEntidadesCup(GestionarEntidadesCups $request): JsonResponse
    {
        try {
            $cups = $this->cuprepository->removerEntidadesCup($request->validated());
            return response()->json($cups, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Lista los detalles de un cup
     * @param int $cupId
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function listarDetallesCup(int $cupId): JsonResponse
    {
        try {
            $cups = $this->cuprepository->listarDetallesCup($cupId);
            return response()->json($cups, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Edita un cup
     * @param Cup $cupId
     * @param EditarCupRequest $request
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function editarCup(Cup $cupId, EditarCupRequest $request): JsonResponse
    {
        try {
            $cup = $this->cuprepository->actualizar($cupId, $request->validated());
            return response()->json($cup, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Lista las entidades asignadas a un cup
     * @param int $cupId
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function listarCupEntidadPorCup(int $cupId): JsonResponse
    {
        try {
            $cupsEntidad = $this->cupEntidadRepository->listarCupEntidadPorCup($cupId);
            return response()->json($cupsEntidad, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Lista los detalles de un cup entidad
     * @param int $cupEntidadId
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function listarDetallesCupEntidad(int $cupEntidadId): JsonResponse
    {
        try {
            $cupEntidad = $this->cupEntidadRepository->buscar($cupEntidadId);
            return response()->json($cupEntidad, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Edita los detalles de una relación entre cup y entidad
     * @param int $cupEntidadId
     * @param EditarCupEntidadRequest $request
     * @return JsonResponse|mixed
     * @throws \Throwable
     * @author Thomas
     */
    public function editarCupEntidad(int $cupEntidadId, EditarCupEntidadRequest $request): JsonResponse
    {
        try {
            $cupEntidad = $this->cupEntidadRepository->editarCupEntidad($cupEntidadId, $request->validated());
            return response()->json($cupEntidad, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Lista las familias asignadas a un cup
     * @param int $cupId
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function listarFamiliasCup(int $cupId): JsonResponse
    {
        try {
            $familias = $this->cuprepository->listarFamiliaCups($cupId);
            return response()->json($familias, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * ESTO ES UN METODO PARA PROBAR EL SERVICIO
     * verifica el manual tarifario de un cup en especifico
     * @param Request $request
     * @author David Peláez
     */
    public function verificarManual(Request $request, int $cup){
        try {
            $sedesSumimedical = [16024, 1876, 14024, 13742, 77592, 13740, 13743, 13741, 77524, 13739, 1609, 2959, 14124, 77590, 497, 1667, 1392, 70539, 1193, 14489, 51350, 3497, 51547];
            $response = $this->cupservice->verificarManual($cup, [4,5], $sedesSumimedical);
            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
