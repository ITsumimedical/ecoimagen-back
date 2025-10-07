<?php

namespace App\Http\Modules\MascotasEmpleados\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\MascotasEmpleados\Models\MascotaEmpleado;
use App\Http\Modules\MascotasEmpleados\Requests\CrearMascotaEmpleadoRequest;
use App\Http\Modules\MascotasEmpleados\Repositories\MascotaEmpleadoRepository;
use App\Http\Modules\MascotasEmpleados\Requests\ActualizarMascotaEmpleadoRequest;

class MascotaEmpleadoController extends Controller
{
    private $mascotaEmpleadoRepository;

    public function __construct(){
        $this->mascotaEmpleadoRepository = new MascotaEmpleadoRepository;
    }

    /**
     * lista las mascotas de los empleados según su id
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request, $id )
    {
        try {
            $mascotaEmpleado = $this->mascotaEmpleadoRepository->listarMascotaEmpleado($request, $id);
            return response()->json([
                'res' => true,
                'data' => $mascotaEmpleado
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar las mascotas del empleado',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda una mascota de un empleado
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearMascotaEmpleadoRequest $request):JsonResponse
    {
        try {
            $nuevaMascotaEmpleado = new MascotaEmpleado($request->all());
            $mascotaEmpleado = $this->mascotaEmpleadoRepository->guardar($nuevaMascotaEmpleado);
            return response()->json([
                'res' => true,
                'data' => $mascotaEmpleado,
                'mensaje' => 'Mascota creado con exito!.',
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al crear la mascota',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza una mascota de un empleado según su id
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizar(ActualizarMascotaEmpleadoRequest $request, int $id): JsonResponse
    {
        try {
            $mascotaEmpleado = $this->mascotaEmpleadoRepository->buscar($id);
            $mascotaEmpleado->fill($request->all());

            $actualizaMascotaEmpleado = $this->mascotaEmpleadoRepository->guardar($mascotaEmpleado);

            return response()->json([
                'res' => true,
                'data' => $actualizaMascotaEmpleado,
                'mensaje' => 'Mascota actualizado con exito!.'
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al actualizar la mascota'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
