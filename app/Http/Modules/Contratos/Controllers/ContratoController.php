<?php

namespace App\Http\Modules\Contratos\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Contratos\Models\Contrato;
use App\Http\Modules\Contratos\Repositories\ContratoRepository;
use App\Http\Modules\Contratos\Requests\ActualizarContratoRequest;
use App\Http\Modules\Contratos\Requests\ContratoCupsRequest;
use App\Http\Modules\Contratos\Requests\GuardarContratoRequest;
use App\Http\Modules\Contratos\Services\ContratoService;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class ContratoController extends Controller
{
    /**
     * Constructor del controlador.
     *
     * @param ContratoRepository $repository
     * @param ContratoService $service
     */
    public function __construct(
        private ContratoRepository $repository,
        private ContratoService $service,
    ) {}


    /**
     * Descargar contratos de contratos.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|JsonResponse
     * @throws \Exception Si ocurre un error al descargar contratos.+
     * @author kobatime
     */
    public function descargarContratos()
    {
        try {
            $consulta = $this->service->descargarContratos();
            return (new FastExcel($consulta))->download('file.xlsx');
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al descargar los contratos.',
                'error' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
    
    /**
     * Lista todos los contratos.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception Si ocurre un error al obtener los contratos.
     */
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
     * Lista los contratos.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception Si ocurre un error al obtener los contratos.
     */
    public function listar(Request $request): JsonResponse
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
     * Almacena un contrato.
     *
     * @param GuardarContratoRequest $request
     * @return JsonResponse
     * @throws \Exception Si ocurre un error al guardar el contrato.
     */
    public function guardar(GuardarContratoRequest $request): JsonResponse
    {
        try {
            $contrato = $this->service->crear($request->validated());
            // Código comentado eliminado para mantener la limpieza
            return response()->json([
                'success' => true,
                'data' => $contrato,
                'message' => 'Contrato creado exitosamente.'
            ], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            Log::warning('Validación fallida al guardar contrato: ' . $e->getMessage(), ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Datos de entrada inválidos.',
                'errors' => $e->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            Log::error('Error al guardar contrato: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'Ha ocurrido un error al guardar el contrato.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * sube un archivo con varios contratos
     * @param Request $request
     * @return Response
     * @author David Peláez
     */
    public function cargaMasiva(Request $request){
        try {
            ini_set('max_execution_time', -1);
            $response = $this->service->cargaMasiva($request->file('file'));
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            if($th->getCode() === 422){
                return response()->json(json_decode($th->getMessage()), 422);
            }
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Consulta un contrato por su ID.
     *
     * @param int $contrato_id
     * @return JsonResponse
     * @throws \Exception Si ocurre un error al consultar el contrato.
     */
    public function consultarContrato(int $contrato_id): JsonResponse
    {
        try {
            $contrato = $this->repository->buscarContrato($contrato_id);
            return response()->json([
                'success' => true,
                'data' => $contrato,
                'message' => 'Contrato obtenido exitosamente.'
            ], Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            Log::warning('Contrato no encontrado: ' . $e->getMessage(), ['contrato_id' => $contrato_id]);
            return response()->json([
                'success' => false,
                'message' => 'Contrato no encontrado.'
            ], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            Log::error('Error al consultar contrato: ' . $e->getMessage(), ['exception' => $e, 'contrato_id' => $contrato_id]);
            return response()->json([
                'success' => false,
                'message' => 'Ha ocurrido un error al consultar el contrato.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Actualiza un contrato.
     *
     * @param ActualizarContratoRequest $request
     * @param int $contrato_id
     * @return JsonResponse
     * @throws \Exception Si ocurre un error al actualizar el contrato.
     */
    public function actualizar(ActualizarContratoRequest $request, int $contrato_id): JsonResponse
    {
        try {
            $contrato = $this->service->actualizar($contrato_id, $request->validated());
            return response()->json([
                'success' => true,
                'data' => $contrato,
                'message' => 'Contrato actualizado exitosamente.'
            ], Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            Log::warning('Contrato no encontrado para actualizar: ' . $e->getMessage(), ['contrato_id' => $contrato_id]);
            return response()->json([
                'success' => false,
                'message' => 'Contrato no encontrado.'
            ], Response::HTTP_NOT_FOUND);
        } catch (ValidationException $e) {
            Log::warning('Validación fallida al actualizar contrato: ' . $e->getMessage(), ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Datos de entrada inválidos.',
                'errors' => $e->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            Log::error('Error al actualizar contrato: ' . $e->getMessage(), ['exception' => $e, 'contrato_id' => $contrato_id]);
            return response()->json([
                'success' => false,
                'errors' => $e->getMessage(),
                'message' => 'Ha ocurrido un error al actualizar el contrato.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Cambia el estado de un contrato.
     *
     * @param Request $request
     * @param Contrato $contrato
     * @return JsonResponse
     * @throws \Exception Si ocurre un error al cambiar el estado del contrato.
     */
    public function cambiarEstado(Request $request, Contrato $contrato): JsonResponse
    {
        try {
            $contrato->cambiarEstado();
            return response()->json([
                'success' => true,
                'data' => $contrato,
                'message' => 'Estado del contrato actualizado exitosamente.'
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Error al cambiar estado del contrato: ' . $e->getMessage(), ['exception' => $e, 'contrato_id' => $contrato->id]);
            return response()->json([
                'success' => false,
                'message' => 'Ha ocurrido un error al cambiar el estado del contrato.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Asocia CUPS a un contrato.
     *
     * @param ContratoCupsRequest $request
     * @param Contrato $contrato
     * @return JsonResponse
     * @throws \Exception Si ocurre un error al asociar CUPS al contrato.
     */
    public function contratosCups(ContratoCupsRequest $request, Contrato $contrato): JsonResponse
    {
        try {
            $contrato->cups()->sync($request->cups);
            return response()->json([
                'success' => true,
                'data' => $contrato,
                'message' => 'CUPS asociados al contrato exitosamente.'
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Error al asociar CUPS al contrato: ' . $e->getMessage(), ['exception' => $e, 'contrato_id' => $contrato->id]);
            return response()->json([
                'success' => false,
                'message' => 'Ha ocurrido un error al asociar CUPS al contrato.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Sube masivamente los CUPS a un contrato.
     *
     * @param Request $request
     * @param int $contrato_id
     * @return JsonResponse
     * @throws \Exception Si ocurre un error al subir los CUPS.
     */
    public function subirCups(Request $request, int $contrato_id): JsonResponse
    {
        try {
            $file = $request->file('file');
            $tarifas = $this->service->cargar($file, $contrato_id);

            return response()->json([
                'success' => true,
                'data' => $tarifas,
                'message' => 'CUPS subidos exitosamente.'
            ], Response::HTTP_OK);
        } catch (ValidationException $e) {
            Log::warning('Validación fallida al subir CUPS: ' . $e->getMessage(), ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Datos de entrada inválidos.',
                'errors' => $e->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            Log::error('Error al subir CUPS: ' . $e->getMessage(), ['exception' => $e, 'contrato_id' => $contrato_id]);
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar el archivo.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Elimina un contrato.
     *
     * @param int $contrato_id
     * @return JsonResponse
     * @throws \Exception Si ocurre un error al eliminar el contrato.
     */
    public function eliminarContrato(int $contrato_id): JsonResponse
    {
        try {
            $contrato = $this->service->eliminarContrato($contrato_id);

            return response()->json([
                'success' => true,
                'data' => $contrato,
                'message' => 'Contrato eliminado exitosamente.'
            ], Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Contrato no encontrado.'
            ], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'message' => 'Error al eliminar el contrato.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

     /**
     * lista los contratos por prestador
     * @param Request $request
     * @param int $prestador_id
     * @return Response
     * @author David Pelaez
     */
    public function listarPorPrestador(Request $request, int $prestador_id){
        try {
            $contratos = $this->repository->listarPorPrestador($prestador_id);
            return response()->json($contratos);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), $th->getCode() ?: 400);
        }
    }

     /**
     * Consulta un contrato por su id
     * @param Request $request
     * @param int $id
     * @return Response
     * @author David Peláez
     */
    public function consultar(Request $request, int $contrato_id){
        try {
            $contrato = $this->repository->consultarContrato($contrato_id);
            return response()->json($contrato);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), $th->getCode()?: 400);
        }
    }

    /**
     * Descargar plantilla de cargue de contratos.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|JsonResponse
     * @throws \Exception Si ocurre un error al descargar la plantilla.
     */
    public function descargarPlantilla()
    {
        try {
            $consulta = $this->repository->plantilla();
            return (new FastExcel($consulta))->download('file.xlsx');
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al descargar la plantilla.',
                'error' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    
}
