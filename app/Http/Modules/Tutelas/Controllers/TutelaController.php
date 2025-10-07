<?php

namespace App\Http\Modules\Tutelas\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\ActuacionTutelas\Services\ActuacionTutelaService;
use App\Http\Modules\Tutelas\Repositories\TutelaRepository;
use App\Http\Modules\Tutelas\Requests\ActualizarTutelaRequest;
use App\Http\Modules\Tutelas\Requests\cerrarTutelaRequest;
use App\Http\Modules\Tutelas\Requests\GuardarTutelaRequest;
use App\Http\Modules\Tutelas\Requests\ListarAccionRequest;
use App\Http\Modules\Tutelas\Services\TutelaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use RuntimeException;
use Throwable;

class TutelaController extends Controller
{

    function __construct(
                          private TutelaRepository $tutelaRepository,
                          private ActuacionTutelaService $actuacionTutelaService,
                          private TutelaService $tutelaService
                        )
    {

    }



    /**
     * Lista las acciones de acuerdo a los parametros que lleguen en el cuerpo de la peticion (estado, cedula paciente,numero radicado, municipio, entidad, fecha inicio o fecha fin)
     *@param ListarAccionRequest $request
     *@return Response acciones 
     *@author Alejo SR
     */
    public function listarAccion(ListarAccionRequest $request): JsonResponse
    {
        try{
            $data = $this->tutelaService->listar($request);
            return response()->json($data, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['mensaje' => 'Error al cargar las acciones', 'error'=>$th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
            

    }

    /**
     * Crea una tutela
     * @param Request $request
     * @return Response $tutela
     */

    public function crear(GuardarTutelaRequest $request): JsonResponse
    {
        try {
            $data = $this->tutelaService->crear($request);
            
            return response()->json([
                'respuesta'=>$data,
                'mensaje' => 'Acción constitucional fue creada con exito!'
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al crear una acción constitucional',
                'error' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza una Tutela
     * @param Request $request
     * @return JsonResponse $tutela
     */

    
    public function cerrarTutela(cerrarTutelaRequest $request): JsonResponse
    {
        try {
            $tutela = $this->tutelaService->cerrarTutela($request);
            return response()->json($tutela, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al cerrar la tutela'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Realiza el cambio y actualizacion del estado de tutela a cierre temporal
     * @param  $request
     * @return JsonResponse $historico Cierre tutela
     */
    public function cerrarTutelaTemporal(cerrarTutelaRequest $request): JsonResponse
    {
        try {
            $tutela = $this->tutelaService->cerrarTutelaTemporal($request);
            return response()->json($tutela, Response::HTTP_OK);
            
        }catch(\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al cerrar la tutela'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
    
    public function actualizar(ActualizarTutelaRequest $request, int $id): JsonResponse
    {
        try {
            $tutela = $this->tutelaRepository->buscar($id);
            $tutela->fill($request->validated());
            $this->tutelaRepository->guardar($tutela);
            return response()->json([
                'mensaje' => 'Tutela actualizada con éxito.'
            ], Response::HTTP_OK);
    
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al actualizar la tutela.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function abrirTutela(Request $request)
    {
        try {
            //Realizo el proceso de apertura tanto de la tutela 
            $tutela = $this->tutelaService->abrirTutela($request);
            
            
            //valido que la respuesta sea verdadera, de lo contrario arrojo un error
            if(!$tutela) {
                throw new \Error('No se pudo abrir la acción constitucional');           
            }
            

            //si tengo respuestas positivas para ambos servicios, regreso un positivo
            return response()->json(['mensaje'=>'La acción constitucional fue abierta éxitosamente'], Response::HTTP_OK);
            
            
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al abrir la acción constitucional'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
