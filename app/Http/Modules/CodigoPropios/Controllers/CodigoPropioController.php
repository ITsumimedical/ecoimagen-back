<?php

namespace App\Http\Modules\CodigoPropios\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\CodigoPropios\Models\CodigoPropio;
use App\Http\Modules\CodigoPropios\Repositories\CodigoPropioRepository;
use App\Http\Modules\CodigoPropios\Requests\ActualizarCodigoPropioRequest;
use App\Http\Modules\CodigoPropios\Requests\CrearCodigoPropioRequest;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Traits\ArchivosTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CodigoPropioController extends Controller
{

    private $repository;
    use ArchivosTrait;


    public function __construct(CodigoPropioRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Lista los codigos propios
     * @param \App\Http\Request $request
     * @return JsonResponse
     * @author kobatime
     */
    public function listar(Request $request)
    {
        try {
            $consulta = $this->repository->listarPropio($request);
            return response()->json([
                'res' => true,
                'data' => $consulta
            ], 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 400);
        }
    }

    /**
     * Crea un codigo propio
     * @param \App\Http\Request $request
     * @return JsonResponse
     * @author David Peláez
     */
    public function crear(CrearCodigoPropioRequest $request)
    {
        try {
            $codigo_propio = $this->repository->crear($request->validated());
            return response()->json($codigo_propio, 201);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 400);
        }
    }

    /**
     * consulta un codigo propio
     * @param \App\Http\Request $request
     * @param CodigoPropio $codigo_propio
     * @return JsonResponse
     * @author David Peláez
     */
    public function consultar(Request $request, int $id)
    {
        try {
            $codigo_propio = $this->repository->consultarPropio($id);
            return response()->json($codigo_propio, 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 400);
        }
    }

    /**
     * Actualiza un codigo propio
     * @param \App\Http\Request $request
     * @param CodigoPropio $codigo_propio
     * @return JsonResponse
     * @author David Peláez
     */
    public function actualizar(ActualizarCodigoPropioRequest $request, CodigoPropio $codigo_propio_id)
    {
        try {
            $codigo_propio = $this->repository->actualizar($codigo_propio_id, $request->validated());
            return response()->json($codigo_propio, 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 400);
        }
    }

    /**
     * Cambia el estado de un codigo propio
     * @param \App\Http\Request $request
     * @param int $codigo_propio_id
     * @return JsonResponse
     * @author David Peláez
     */
    public function cambiarEstado(int $codigo_propio_id)
    {
        try {
            $codigo_propio = $this->repository->actualizarEstado($codigo_propio_id);
            return response()->json([
                'res' => true,
                'data' => $codigo_propio
            ]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function descargarPlantillaCodigoPropio(){
        try {
            $consulta = $this->repository->plantillaCodigoPropio();
            return (new FastExcel($consulta))->download('file.xlsx');
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al descargar!',
                'error' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function cargaMasiva(Request $request){
        try {
            ini_set('max_execution_time', -1);
            $tarifa = $this->repository->cargar($request->file('file'));
            return response()->json($tarifa, Response::HTTP_OK);
        } catch (\Throwable $th) {
            if($th->getCode() === 422){
                return response()->json(json_decode($th->getMessage()), 422);
            }
            return response()->json($th->getMessage(), 400);
        }
    }

    public function BuscarCodigoPropio($nombre) {
        try {
            $codigo_propio = $this->repository->consultarCodigoPropio($nombre);
            if ($codigo_propio === null) {
                return response()->json('No se encontraron Codigos Propios con el nombre proporcionado', Response::HTTP_NOT_FOUND);
            } else {
                return response()->json($codigo_propio, Response::HTTP_OK);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(),  Response::HTTP_BAD_REQUEST);
        }
    }
}
