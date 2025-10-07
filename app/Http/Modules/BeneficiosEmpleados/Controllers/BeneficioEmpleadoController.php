<?php

namespace App\Http\Modules\BeneficiosEmpleados\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Beneficios\Models\Beneficio;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Http\Modules\BeneficiosEmpleados\Models\BeneficioEmpleado;
use App\Http\Modules\BeneficiosEmpleados\Requests\CrearBeneficioEmpleadoRequest;
use App\Http\Modules\BeneficiosEmpleados\Repositories\BeneficiosEmpleadosRepository;
use App\Http\Modules\BeneficiosEmpleados\Requests\ActualizarBeneficioEmpleadoRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use function PHPSTORM_META\map;

class BeneficioEmpleadoController extends Controller
{
    private $beneficioRepository;

    public function __construct(){
        $this->beneficioRepository = new BeneficiosEmpleadosRepository;
    }

    /**
     * lista los beneficios de los empleados
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request): JsonResponse
    {
        $beneficio = $this->beneficioRepository->listart();
        try {
            return response()->json([
                'res' => true,
                'data' => $beneficio
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los beneficios de los empleados',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un beneficio
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearBeneficioEmpleadoRequest $request){
        try {
            $beneficio_tipo = Beneficio::find($request->beneficio_id);
            $empleado_id = $request->empleado_id;
            $año_fecha_disfrute = date('Y', strtotime($request->fecha_disfrute));
            if ($beneficio_tipo->permitir_duplicidad == false) {
                $beneficios_empleados = BeneficioEmpleado::where('empleado_id', $empleado_id)
                ->whereYear('fecha_disfrute', $año_fecha_disfrute)->where('beneficio_id', $beneficio_tipo->id)->count();
                if ($beneficios_empleados === 0) {
                    $beneficio = $this->beneficioRepository->crear($request->validated());
                    return response()->json($beneficio, Response::HTTP_CREATED);
                }else {
                    return response()->json([
                        'res' => false,
                        'mensaje' => 'El beneficio ya se ha otorgado dentro del periodo anual'
                    ], Response::HTTP_BAD_REQUEST);
                }
            }else {
                $beneficio = $this->beneficioRepository->crear($request->validated());
                return response()->json($beneficio, Response::HTTP_CREATED);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza un beneficio
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizar(ActualizarBeneficioEmpleadoRequest $request, int $id): JsonResponse
    {
        try {
            $beneficio = $this->beneficioRepository->buscar($id);
            $beneficio->fill($request->validated());

            $actualizaBeneficio = $this->beneficioRepository->actualizar($beneficio,$request->validated());

            return response()->json([
                'res' => true,
                'data' => $actualizaBeneficio,
                'mensaje' => 'Beneficio actualizado con exito!.'
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al actualizar el beneficio'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function contadoresBeneficios()
    {
        $totalBeneficiosOtorgados = BeneficioEmpleado::whereNotNull('id')->count();
        $totalBeneficiosPendientes = BeneficioEmpleado::where('estado_id', 3)->count();
        $totalBeneficiosAutorizados = BeneficioEmpleado::where('estado_id', 4)->count();
        $totalBeneficiosAnulados = BeneficioEmpleado::where('estado_id', 5)->count();
        return response()->json([
            $totalBeneficiosOtorgados,
            $totalBeneficiosPendientes,
            $totalBeneficiosAutorizados,
            $totalBeneficiosAnulados,
        ], Response::HTTP_OK);
    }

    /**
     * exportar - exporta excel con los datos del modelo
     *
     * @return void
     */
    public function exportar()
    {
        return (new FastExcel(BeneficioEmpleado::select(
            'beneficio_empleados.id', 'empleados.nombre_completo', 'empleados.documento',
            'empleados.fecha_nacimiento', 'empleados.edad', 'area_ths.nombre as area', 'sedes.nombre as sede',
            'municipios.nombre as Municipio residencia', 'e.nombre_completo as Jefe inmediato', 'empleados.celular',
            'empleados.email_personal', 'empleados.email_corporativo', 'beneficios.nombre as beneficio otorgado',
            'beneficio_empleados.fecha_disfrute', 'beneficio_empleados.observaciones', 'estados.nombre as estado'

        )
        ->leftjoin('empleados', 'empleados.id', 'beneficio_empleados.empleado_id')
        ->leftjoin('area_ths', 'area_ths.id', 'empleados.areath_id')
        ->leftjoin('sedes', 'sedes.id', 'empleados.sede_id')
        ->leftjoin('empleados as e', 'e.id', 'empleados.jefe_inmediato_id')
        ->leftjoin('municipios', 'municipios.id', 'empleados.municipio_residencia_id')
        ->leftjoin('beneficios', 'beneficios.id', 'beneficio_empleados.beneficio_id')
        ->leftjoin('estados', 'estados.id', 'beneficio_empleados.estado_id')
        ->get()))->download('file.xlsx');
    }

    /**
     * autorizar -  autoriza un beneficio sobre un empleado
     *
     * @param  mixed $beneficio
     * @return void
     */
    public function autorizar(BeneficioEmpleado $beneficio){
        try {
            $beneficio->autorizar();
            return response()->json($beneficio, 200);
        }catch(\Throwable $th){
            return response()->json($th->getMessage(),400);
        }
    }

    /**
     * anular -  anula un beneficio sobre un empleado
     *
     * @param  mixed $beneficioEmpleado
     * @return void
     */
    public function anular(BeneficioEmpleado $beneficioEmpleado){
        try {
            $beneficioEmpleado->anular();
            return response()->json($beneficioEmpleado, 200);
        }catch(\Throwable $th){
            return response()->json($th->getMessage(),400);
        }
    }
}
