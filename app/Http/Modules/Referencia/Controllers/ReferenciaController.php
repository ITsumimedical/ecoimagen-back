<?php

namespace App\Http\Modules\Referencia\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\AdmisionesUrgencias\Models\AdmisionesUrgencia;
use App\Http\Modules\AdmisionesUrgencias\Repositories\AdmisionesUrgenciaRepository;
use App\Http\Modules\Referencia\Models\Referencia;
use App\Http\Modules\Referencia\Repositories\ReferenciaRepository;
use App\Http\Modules\Referencia\Requests\ActualizarReferenciaRequest;
use App\Http\Modules\Referencia\Requests\CrearReferenciaRequest;
use App\Http\Modules\Referencia\Requests\CrearUrgenciaRequest;
use App\Http\Modules\Referencia\Services\ReferenciaService;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;

class ReferenciaController extends Controller
{

    public function __construct(protected ReferenciaRepository $referenciaRepository,
                                protected ReferenciaService $referenciaService,
                                protected AdmisionesUrgenciaRepository $admisionesUrgenciaRepository)
    {
    }

    /**
     * listar las referencias
     *
     * @param  mixed $request
     * @return JsonResponse
     * @author Manuela
     */
    public function listar(Request $request): JsonResponse
    {
        try {
            $referencia = $this->referenciaRepository->listar($request);
            return response()->json($referencia, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * crear una referencia
     *
     * @param  mixed $request
     * @return JsonResponse
     * @author Manuela and kobatime
     */
    public function crearReferencia(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            // se envia la informacion a un serivcio para agregar el reps logueado
            $data = $this->referenciaService->prepararData($request->all());
            // se envia la data preparada a el repositorio
            $referencia = $this->referenciaRepository->crear($data);
            //Guardar cie10
            $this->referenciaService->GuardarCie10($referencia, $data);
            //crea chat con referencia
            $this->referenciaService->crearChat($referencia);
            //guarda adjuntos
            $this->referenciaRepository->adjuntoReferencia($referencia, $data);
            //Anexos 2
            $this->referenciaRepository->verificarAnexo($referencia);

            DB::commit();
            return response()->json([
                'mensaje' => 'Creado con exito la referencias',
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al crear la referencias'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * actualizar una referencia
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return JsonResponse
     * @author Manuela
     */
    public function actualizarReferencia(ActualizarReferenciaRequest $request, Referencia $id): JsonResponse
    {
        try {
            $referencia = $this->referenciaRepository->actualizarReferencia($id, $request->validated());
            return response()->json([
                'mensaje' => 'La referencia fue actualizada con éxito'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * actualizar una referencia
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return JsonResponse
     * @author Manuela
     */
    public function finalizarReferencia(ActualizarReferenciaRequest $request, Referencia $id): JsonResponse
    {
        try {
            $referencia = $this->referenciaRepository->finalizarReferencia($id, $request->validated());
            return response()->json([
                'mensaje' => 'La referencia fue finalizada con éxito'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * listar Pedientes segun anexo
     *
     * @param  string $anexo
     * @return JsonResponse
     * @author kobatime
     */
    public function listarPedientes(Request $request): JsonResponse
    {
        try {
            
            #normalizo el tipo de dato que llega en el anexo para consultar por el array de tipos
            $request['anexo'] = $this->normalizarTipoAnexo($request['anexo']);
            
            $referencia = $this->referenciaRepository->listarPendientes($request);
            return response()->json($referencia, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al listar las referencias'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * listar Pedientes segun anexo
     *
     * @param  string $anexo
     * @return JsonResponse
     * @author kobatime
     */
    public function listarProcesados(Request $request): JsonResponse
    {
        try {
            $referencia = $this->referenciaRepository->listarProcesado($request);
            return response()->json($referencia, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al listar las referencias'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * listar Pedientes segun anexo
     *
     * @param  string $anexo
     * @return JsonResponse
     * @author kobatime
     */
    public function listarProcesadoPrestador(Request $request)
    {
        try {
            #normalizo el tipo de dato que llega en el anexo para consultar por el array de tipos
            $request['anexo'] = $this->normalizarTipoAnexo($request['anexo']);

            $referencia = $this->referenciaRepository->listarProcesadoPrestador($request);
            return response()->json($referencia, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al listar las referencias'
            ], Response::HTTP_BAD_REQUEST);
        }
    }



    /**
     * listar seguimiento segun anexo
     *
     * @param  string $anexo
     * @return JsonResponse
     * @author kobatime
     */
    public function listarSeguimiento(Request $request): JsonResponse
    {
        try {
             #normalizo el tipo de dato que llega en el anexo para consultar por el array de tipos
             $request['anexo'] = $this->normalizarTipoAnexo($request['anexo']);

            $referencia = $this->referenciaRepository->listarSeguimiento($request);
            return response()->json($referencia, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al listar las referencias'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function contadorReferenciasPendientes()
    {
        try {
            $referencia = $this->referenciaRepository->countReferenciaPendientes();
            return response()->json($referencia, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al contar las referencias'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function contadorReferenciasSeguimiento()
    {
        try {
            $referencia = $this->referenciaRepository->countReferenciaSeguimiento();
            return response()->json($referencia, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al contar las referencias'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function contadorReferenciasProcesado()
    {
        try {
            $referencia = $this->referenciaRepository->countReferenciaProcesado();
            return response()->json($referencia, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al contar las referencias'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function contadorReferenciasProcesadoPrestador()
    {
        try {
            $referencia = $this->referenciaRepository->countReferenciaProcesadoPrestador();
            return response()->json($referencia, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al contar las referencias'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarPedientesPrestador(Request $request)
    {
        try {
            #normalizo el tipo de dato que llega en el anexo para consultar por el array de tipos
            $request['anexo'] = $this->normalizarTipoAnexo($request['anexo']);

            $referencia = $this->referenciaRepository->listarPendientePrestador($request);
            return response()->json($referencia, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al listar las referencias'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function CrearConsulta(Request $request)
    {
        try {
            $referencia = $this->referenciaRepository->crearConsulta($request->all());
            return response()->json($referencia, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al listar las referencias'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function reporte(Request $request)
    {
        try {
            $reporte = Collect(DB::select('exec dbo.SP_Anexos ?,?', [$request->f_inicial, $request->f_final]));
            $array = json_decode($reporte, true);
            return (new FastExcel($array))->download('ReporteAnexosTecnicos.xls');
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al generar el reporte'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function crearUrgencia(CrearUrgenciaRequest $request)
    {
        DB::connection('secondary')->beginTransaction();
        try {
           $admision = AdmisionesUrgencia::find($request->admision);
            if ($request->entidad_id ==1 && $admision->codigo_centro_regulador == null) {
                 // Prepara datos de urgencia
            $data = $this->referenciaService->prepararDataUrgencia($request->all());
            //Crea la urgencia
            $referencia = $this->referenciaRepository->crearUrgencia($data);
            // Actualizar la admision con el codigo de la referencia
                $this->admisionesUrgenciaRepository->actualizarCodigo($request->admision,$referencia);
             // //Guardar cie10
            $this->referenciaService->GuardarCie10Urgencia($referencia, $data);
            // //crea chat con referencia
            $this->referenciaService->crearChatUrgencia($referencia);
            // //guarda adjuntos
           $adjunto = $this->referenciaRepository->adjuntoReferenciaUrgencias($referencia, $data);
            // //Anexos 2
            $this->referenciaRepository->verificarAnexoUrgencia($referencia);
            }
            DB::connection('secondary')->commit();
            return response()->json('ok', Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            DB::connection('secondary')->rollBack();
            return response()->json( $th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para normalizar el tipo de anexo y regresarlo como un array para buscar por ambos
     * @param mixed $tipoEntrada
     * @return array
     */
    private function normalizarTipoAnexo($tipoEntrada){
        $tipos =[
            'Informe de la atención de urgencias' => [2,'Informe de la atención de urgencias'],
            'Solicitud de autorización de servicios y tecnologías en salud' => [3,'Solicitud de autorización de servicios y tecnologías en salud'],
            'Referencia ' => [9,'Referencia'],
            'Contrareferencia ' =>[10,'Contrareferencia']
        ];

        foreach($tipos as $grupo){
            if(in_array($tipoEntrada,$grupo)){
                return $grupo;
            }
        }

        return [$tipoEntrada];
    }
}
