<?php

namespace App\Http\Modules\Empleados\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Exports\EmpleadosExport;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\ContratosEmpleados\Models\ContratoEmpleado;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Http\Modules\Empleados\Models\Empleado;
use App\Http\Modules\Empleados\Services\EmpleadoService;
use App\Http\Modules\Empleados\Repositories\EmpleadoRepository;
use App\Http\Modules\Empleados\Requests\ActualizarEmpleadoRequest;
use App\Http\Modules\Empleados\Requests\CrearEmpleadoRequest;
use App\Http\Modules\EvaluacionDesempeño\evaluaciones_desempeños\Models\EvaluacionesDesempeno;
use App\Http\Modules\IncapacidadesEmpleados\Models\IncapacidadEmpleado;
use App\Http\Modules\Reps\Models\Rep;
use App\Http\Modules\Usuarios\Models\User;
use App\Http\Modules\VacacionesEmpleados\Models\VacacionEmpleado;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EmpleadoController extends Controller
{
    protected $empleadoRepository;
    protected $empleadoService;

    public function __construct(EmpleadoRepository $empleadoRepository, EmpleadoService $empleadoService) {
        $this->empleadoRepository = $empleadoRepository;
        $this->empleadoService = $empleadoService;
    }

    public function crear(CrearEmpleadoRequest $request)
    {
        try {
            $usuario = $this->empleadoService->crearEmpleado($request->validated());
            return response()->json($usuario, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al intentar crear el usuario!',
                'error' => $th->getMessage()
            ]);
        }
    }

    /**
     * lista los empleados asociados a jefe inmediato
     * @return Response
     * @author Calvarez
     */
    public function jefe_empleados()
    {
        try {
            $empleados = $this->empleadoRepository->listarEmpleadosJefe();
            return response()->json($empleados, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al recuperar usuarios',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * lista los empleados
     * @param Request $request
     * @return Response
     * @author Calvarez
     */
    public function listar(Request $request): JsonResponse
    {
        try {
            $empleados = $this->empleadoRepository->listar($request);
            return response()->json([
                'res' => true,
                'data' => $empleados
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar usuarios',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Consultar empleado por documento
     * @param Request $request
     * @return Response
     * @author Calvarez
     */
    public function listarEmpleadoPorDocumento(Request $request): JsonResponse
    {
        try {
            $datosEmpleados = $this->empleadoRepository->informacionEmpleadoDocumento($request->documento);
            return response()->json($datosEmpleados, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar usuarios',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarEmpleadoPorCedula(Request $request): JsonResponse
    {
        try {
            $datosEmpleados = $this->empleadoRepository->informacionEmpleadoCedula($request->documento);
            return response()->json($datosEmpleados, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar usuarios',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarEmpleadoDocumento(int $documento): JsonResponse
    {
        try {
            $datosEmpleados = $this->empleadoRepository->informacionEmpleadoDocumento($documento);
            return response()->json($datosEmpleados, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar usuarios',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * actualizar -  actualiza un empleado
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return JsonResponse
     */
    public function actualizar(ActualizarEmpleadoRequest $request, int $id)
    {
        try {
            $empleado = $this->empleadoRepository->buscarEmpleado($id);

            $data = $this->empleadoService->prepararData($request->except(['fecha_inicial_periodo', 'fecha_final_periodo', 'cargo', 'tipoDocumento', 'nombre_completo']), true);
            $actualizaEmpleados = $this->empleadoRepository->actualizar($empleado, $data);

            return response()->json([
                'res' => true,
                'data' => $actualizaEmpleados,
                'mensaje' => 'Empleado actualizado con éxito!',
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al actualizar el empleado',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * exportar - exporta excel con los datos del modelo empleado
     *
     * @return void
     */
    public function exportar(){
        return (new FastExcel(Empleado::all()))->download('file.xlsx');
    }

    /**
     * contadoresEmpleados
     *
     * @return void
     */
    public function contadoresEmpleados()
    {
        $totalEmpleadoActivos = ContratoEmpleado::where('activo', 1)->count();
        $totalEmpleadoRetirados = ContratoEmpleado::where('activo', 0)->count();
        $incapacidadEmpleado = IncapacidadEmpleado::where('estado_id', 1)->count();
        $vacacionesEmpleado = VacacionEmpleado::where('estado_id', 10)->count();
        return response()->json([
            $totalEmpleadoActivos,
            $totalEmpleadoRetirados,
            $incapacidadEmpleado,
            $vacacionesEmpleado
        ], Response::HTTP_OK);
    }

    /**
     * contadoresEmpleadosPorJefeInmediato
     *
     * @return void
     */
    public function contadoresEmpleadosPorJefeInmediato()
    {
        $totalEmpleadoPorJefe = Empleado::where('jefe_inmediato_id', auth()->id())->whereHas('contratoEmpleado', function($q){
            $q->where('activo', '=', 1);
        })->count();
        $totalEmpleadoEvaluados = EvaluacionesDesempeno::where('esta_activo', 0)->count();
        return response()->json([
            $totalEmpleadoPorJefe,
            $totalEmpleadoEvaluados
        ], Response::HTTP_OK);
    }

    public function compromisosLaborales()
    {
        try {
            $empleadosConCompromisos = $this->empleadoRepository->listarColaboradoresConCompromisos();
            return response()->json($empleadosConCompromisos, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al recuperar usuarios',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function compromisosEvaluacion($documento)
    {
        try {
            $empleadosConCompromisos = $this->empleadoRepository->listarCompromisosEvaluacion($documento);
            return response()->json($empleadosConCompromisos, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al recuperar usuarios',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function consultarEmpleadoConFiltro(Request $request)
    {
        try {
            $empleado = $this->empleadoRepository->consultarEmpleadoConFiltro($request);
            return response()->json($empleado, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al consultar el empleado',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function exportEmpleadosProcedimiento()
    {
        try {
            $appointments = Collect(DB::select("exec dbo.SP_Descarga_Empleados"));
        $array = json_decode($appointments, true);
        return (new FastExcel($array))->download('empleados.xls');

        } catch (\Throwable $th) {
            return response()->json([
                'erro' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Consultar empleados que esten activos
     * @return Response, $empleados
     * @author jdss
     */
    public function listarEmpleadosActivos(): JsonResponse
    {
        try {
            $datosEmpleados = $this->empleadoRepository->informacionEmpleadoActivo();
            return response()->json($datosEmpleados, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar usuarios',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function firma(Request $request){
        try {
            $firma = $this->empleadoRepository->firma($request->all());
            return response()->json($firma, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarMedicoPorSede($id): JsonResponse
    {
        try {
            $medicos = $this->empleadoRepository->listarMedicoPorSede($id);
            return response()->json($medicos, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar los medicos por sede',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarEmpleadosContratados(): JsonResponse
    {
        try {
            $datosEmpleados = $this->empleadoRepository->informacionEmpleadoContratado();
            return response()->json($datosEmpleados, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar usuarios',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
