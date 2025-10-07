<?php

namespace App\Http\Modules\LicenciasEmpleados\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\LicenciasEmpleados\Models\LicenciaEmpleado;
use App\Http\Modules\LicenciasEmpleados\Repositories\LicenciaRepository;
use App\Http\Modules\LicenciasEmpleados\Requests\ActualizarLicenciaRequest;
use App\Http\Modules\LicenciasEmpleados\Requests\CrearLicenciaRequest;

class LicenciaController extends Controller
{
    private $licenciaRepository;

    public function __construct(){
        $this->licenciaRepository = new LicenciaRepository;
    }

    /**
     * lista las licencias de empleados
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request, $id )
    {
        try {
            $licencia = $this->licenciaRepository->listarConTipo($request, $id);
            return response()->json([
                'res' => true,
                'data' => $licencia
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'men' => $th->getMessage(),
                'mensaje' => 'Error al recuperar las licencias del empleado',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda una licencia
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearLicenciaRequest $request):JsonResponse{
        try {
            $licencia = $this->licenciaRepository->crear($request->validated());
            return response()->json($licencia, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza una licencia
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizar(ActualizarLicenciaRequest $request, LicenciaEmpleado $id){
        try {
            $this->licenciaRepository->actualizar($id, $request->validated());
            return response()->json([]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(),400);
        }
    }
}
