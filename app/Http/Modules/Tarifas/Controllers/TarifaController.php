<?php

namespace App\Http\Modules\Tarifas\Controllers;

use App\Http\Modules\Tarifas\Repositories\TarifaRepository;
use App\Http\Modules\Tarifas\Requests\CrearTarifaRequest;
use App\Http\Modules\Tarifas\Services\TarifaService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Rap2hpoutre\FastExcel\FastExcel;

class TarifaController extends Controller
{

    public function __construct(
        private TarifaService $service,
        private TarifaRepository $repository,
    ) {}

    public function listar(Request $request)
    {
        try {
            $tarifas = $this->repository->listarTarifas($request);
            return response()->json([
                'res' => true,
                'data' => $tarifas
            ], 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * listar cups que peternecen a una tarifa
     * @param  $tarifa_id
     * @return Response $tarifa
     * @author kobatime
     */
    public function listarCupTarifas(Request $request)
    {
        try {
            $tarifa = $this->repository->listarCupTarifas($request);
            return response()->json($tarifa, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function consultarTarifa(Request $request)
    {
        try {
            $tarifa = $this->repository->consultarTarifas($request);
            return response()->json($tarifa, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Guarda una tarifa
     * @param Request $request
     * @return Response $tarifa
     * @author kobatime
     * @edit David Peláez
     */
    public function crear(CrearTarifaRequest $request): JsonResponse
    {
        try {
            $tarifa = $this->service->crear($request->validated());
            return response()->json($tarifa);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), $th->getCode() ?: 400);
        }
    }

    /**
     * Guarda una cups en una tarifa
     * @param Request $request
     * @return Response $tarifa
     * @author kobatime
     */
    public function tarifaCups(Request $request, $tarifa_id): JsonResponse
    {
        try {
            $cups = $this->service->agregarCupsTarifa($request, $tarifa_id);
            return response()->json($cups, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al agregar el cups!',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * eliminar un cups de una tarifa
     * @param Request $request
     * @return Response $tarifa
     * @author kobatime
     */
    public function deleteCupsTarifas(Request $request)
    {
        try {

            $eliminar = $this->repository->eliminarCupTarifa($request);
            return response()->json($eliminar, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al eliminar!',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function editarValor(Request $request)
    {
        try {
            $cupTarifa = $this->repository->editarValor($request);
            return response()->json($cupTarifa, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al eliminar!',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function tarifaPropia(Request $request)
    {
        try {
            $propio = $this->repository->tarifaPropia($request);
            return response()->json($propio, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al eliminar!',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public  function subirArchivo(Request $request)
    {
        try {
            $file = $request->file('file');
            $cups = $this->service->cargar($file, $request->tarifa_id);
            return $cups;
            //return (new FastExcel($cups['Error']))->download('file.xls');
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al cargar el archivo',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizarTarifas(Request $request)
    {
        try {
            $tarifa = $this->repository->actualizarTarifa($request);
            return response()->json($tarifa, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al actualizar la tarifa',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function tarifaPaquete(Request $request, $tarifa_id)
    {
        try {
            $this->repository->tarifaPaquete($request, $tarifa_id);
            return response()->json(Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al guardar!',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarPaquete(Request $request)
    {
        try {
            $consulta = $this->repository->listarTarifaPaquete($request);
            return response()->json($consulta, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al guardar!',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function descargarPlantillaCups()
    {
        try {
            $consulta = $this->repository->plantilla();
            return (new FastExcel($consulta))->download('file.xlsx');
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al descargar!',
                'error' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function descargarPlantillaTarifas()
    {
        try {
            $consulta = $this->repository->plantillaMultiplesTarifas();
            return (new FastExcel($consulta))->download('file.xlsx');
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al descargar!',
                'error' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function descargarPlantillaTarifaCup()
    {
        try {
            $consulta = $this->repository->plantillaTarifaCup();
            return (new FastExcel($consulta))->download('file.xlsx');
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al descargar!',
                'error' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    public function listarCodigosPropiosTarifas(int $tarifa_id)
    {
        try {
            $codigos_proios = $this->repository->listarCodigosPropiosTarifas($tarifa_id);
            return response()->json($codigos_proios, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al obtener los codigos propios de la tarifa!',
                'error' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function eliminarCodigoPropioTarifa(int $tarifa_id, int $codigo_propio_id)
    {
        try {
            $codigo_propio = $this->repository->eliminarCodigoPropioTarifa($tarifa_id, $codigo_propio_id);
            return response()->json($codigo_propio, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al eliminar el codigo propio de la tarifa!',
                'error' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarPaqueteTarifa(int $tarifa_id)
    {
        try {
            $paquetes = $this->repository->listarPaqueteTarifa($tarifa_id);
            return response()->json($paquetes, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al obtener los paquetes de la tarifa!',
                'error' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function eliminarPaqueteTarifa(int $tarifa_id, int $paquete_id)
    {
        try {
            $paquete = $this->repository->eliminarPaqueteTarifa($tarifa_id, $paquete_id);
            return response()->json($paquete, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al eliminar el paquete de la tarifa!',
                'error' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizarPrecioPaquete(Request $request)
    {
        try {
            $validateData = $request->validate([
                'tarifa_id' => 'required|integer',
                'paquete_id' => 'required|integer',
                'precio' => 'required|numeric|min:0',
            ]);

            $actualizado = $this->repository->actualizarPrecioPaquete(
                $validateData['tarifa_id'],
                $validateData['paquete_id'],
                $validateData['precio'],
            );

            return response()->json($actualizado, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al actualizar el paquete de la tarifa!',
                'error' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    public function actualizarPrecioCodigoPropio(Request $request)
    {
        try {
            $validateData = $request->validate([
                'tarifa_id' => 'required|integer',
                'codigo_propio_id' => 'required|integer',
                'precio' => 'required|numeric|min:0',
            ]);

            $actualizado = $this->repository->actualizarPrecioCodigoPropio(
                $validateData['tarifa_id'],
                $validateData['codigo_propio_id'],
                $validateData['precio'],
            );

            return response()->json($actualizado, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al actualizar el paquete de la tarifa!',
                'error' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizarPrecioCupsTarifa(Request $request)
    {
        try {
            $validateData = $request->validate([
                'cup_tarifas_id' => 'required|integer',
                'valor' => 'required|numeric|min:0',
            ]);

            $actualizado = $this->repository->actualizarPrecioCupsTarifa(
                $validateData['cup_tarifas_id'],
                $validateData['valor'],
            );

            return response()->json($actualizado, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al actualizar el paquete de la tarifa!',
                'error' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function eliminarCupsTarifas(Request $request)
    {
        try {
            $data = $request->all();

            $cupsEliminados = $this->service->eliminarCupsTarifa($data);

            return response()->json(['message' => 'Registros eliminados con éxito', 'cups' => $cupsEliminados], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al eliminar!',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function eliminarTarifas(int $tarifa_id)
    {
        try {
            $tarifa = $this->service->eliminarTarifa($tarifa_id);
            return response()->json($tarifa, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al eliminar la tarfia',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * lista las tarifas por el contrato
     * @param Request $request
     * @param int $contrato_id
     * @return Response
     * @author David Peláez
     */
    public function listarPorContrato(Request $request, $contrato_id)
    {
        try {
            $tarifas = $this->repository->listarPorContrato($contrato_id);
            return response()->json($tarifas, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), $th->getCode() ?: 400);
        }
    }

    /**
     * agrega cups a una tarifa
     * @param Request $request
     * @param int $tarifa_id
     * @return Response
     * @author David Peláez
     */
    public function agregarCups(Request $request, $tarifa_id)
    {
        try {
            $tarifa = $this->service->agregarCups($tarifa_id, $request->all());
            return response()->json($tarifa, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * lista los cups pertenecientes a una tarifa
     * @param Request $request
     * @param int $tarifa_id
     * @return Response
     * @author David Peláez
     */
    public function listarCupsPorTarifa(Request $request, $tarifa_id)
    {
        try {
            $cups = $this->repository->listarCupsPorTarifa($tarifa_id);
            return response()->json($cups, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), $th->getCode() ?: 400);
        }
    }

    /**
     * carga los cups a una tarifa masivamente
     * @param Request
     * @return Response
     * @author David Peláez
     */
    public function cargaMasiva($tarifa_id, Request $request)
    {
        try {
            ini_set('max_execution_time', -1);
            $tarifa = $this->service->cargar($request->file('file'), $tarifa_id);
            return response()->json($tarifa, Response::HTTP_OK);
        } catch (\Throwable $th) {
            if ($th->getCode() === 422) {
                return response()->json(json_decode($th->getMessage()), 422);
            }
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * carga los cups a una tarifa masivamente
     * @param Request
     * @return Response
     * @author David Peláez
     */
    public function cargaMasivaMultiple(Request $request)
    {
        try {
            ini_set('max_execution_time', -1);
            $tarifa = $this->service->cargarMultipleTarifas($request->file('file'));
            return response()->json($tarifa, Response::HTTP_OK);
        } catch (\Throwable $th) {
            if ($th->getCode() === 422) {
                return response()->json(json_decode($th->getMessage()), 422);
            }
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * agregar los municipios a una tarifa
     * @param Request
     * @return Response
     * @author kobatime
     */
    public function tarifaMunicipio(int $tarifa_id, Request $request)
    {
        try {
            $tarifa = $this->service->municipioTarifa($tarifa_id, $request->all());
            return response()->json($tarifa, Response::HTTP_OK);
        } catch (\Throwable $th) {
            if ($th->getCode() === 422) {
                return response()->json(json_decode($th->getMessage()), 422);
            }
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Obtener los municipios a una tarifa
     * @param Request
     * @return Response
     * @author kobatime
     */
    public function getMunicipiotarifa(int $tarifa_id)
    {
        try {
            $tarifa = $this->service->getMunicipioTarifa($tarifa_id);
            return response()->json($tarifa, Response::HTTP_OK);
        } catch (\Throwable $th) {
            if ($th->getCode() === 422) {
                return response()->json(json_decode($th->getMessage()), 422);
            }
            return response()->json($th->getMessage(), 400);
        }
    }

    public function deleteMunicipioTarifas(Request $request)
    {
        try {
            $municipio = $this->repository->eliminarMunicipioTarifa($request->all());
            return response()->json($municipio, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al eliminar el municipio de la tarifa!',
                'error' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * agrega cums a una tarifa
     * @param Request $request
     * @param int $tarifa_id
     * @return Response
     * @author Kobatime
     */
    public function tarifaCums(int $tarifa_id, Request $request)
    {
        try {
            $tarifa = $this->service->cumsTarifa($tarifa_id, $request->all());
            return response()->json($tarifa, Response::HTTP_OK);
        } catch (\Throwable $th) {
            if ($th->getCode() === 422) {
                return response()->json(json_decode($th->getMessage()), 422);
            }
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Obtener los cums a una tarifa
     * @param Request
     * @return Response
     * @author Kobatime
     */    public function getCumTarifas(int $tarifa_id)
    {
        try {
            $tarifa = $this->service->getCumTarifas($tarifa_id);
            return response()->json($tarifa, Response::HTTP_OK);
        } catch (\Throwable $th) {
            if ($th->getCode() === 422) {
                return response()->json(json_decode($th->getMessage()), 422);
            }
            return response()->json($th->getMessage(), 400);
        }
    }
    /**
     * agrega diagnosticos a una tarifa
     * @param Request $request
     * @return Response
     * @author Kobatime
     */
    public function agregarTarifaDiagnostico(int $tarifa_id, Request $request)
    {
        try {
            $tarifa = $this->service->diagnosticoTarifa($tarifa_id, $request->all());
            return response()->json($tarifa, Response::HTTP_OK);
        } catch (\Throwable $th) {
            if ($th->getCode() === 422) {
                return response()->json(json_decode($th->getMessage()), 422);
            }
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Obtener los diagnosticos a una tarifa
     * @param Request
     * @return Response
     * @author Kobatime
     */    public function getDiagnosticoTarifa(int $tarifa_id)
    {
        try {
            $tarifa = $this->service->getDiagnosticoTarifa($tarifa_id);
            return response()->json($tarifa, Response::HTTP_OK);
        } catch (\Throwable $th) {      
            if ($th->getCode() === 422) {
                return response()->json(json_decode($th->getMessage()), 422);
            }
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * eliminar diagnosticos de una tarifa
     * @param Request
     * @return Response
     * @author Kobatime
     */    public function deleteDiagnosticoTarifas(Request $request)
    {
        try {
            $diagnostico = $this->service->eliminarDiagnosticoTarifa($request->all());
            return response()->json($diagnostico, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([         
                'mensaje' => 'Error al eliminar el diagnostico de la tarifa!',
                'error' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * eliminar cums de una tarifa
     * @param Request
     * @return Response
     * @author Kobatime
     */
    public function eliminarCumTarifa(Request $request)
    {
        try {
            $cum = $this->service->eliminarCumTarifa($request->all());
            return response()->json($cum, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al eliminar el cum de la tarifa!',
                'error' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
