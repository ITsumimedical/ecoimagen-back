<?php

namespace App\Http\Modules\ContactosEmpleados\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\ContactosEmpleados\Models\ContactoEmpleado;
use App\Http\Modules\ContactosEmpleados\Requests\CrearContactoEmpleadoRequest;
use App\Http\Modules\ContactosEmpleados\Repositories\ContactoEmpleadoRepository;
use App\Http\Modules\ContactosEmpleados\Requests\ActualizarContactoEmpleadoRequest;

class ContactoEmpleadoController extends Controller
{
    private $contactoEmpleadoRepository;

    public function __construct(){
        $this->contactoEmpleadoRepository = new ContactoEmpleadoRepository;
    }

    /**
     * lista los contactos de un empleado según su id
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request, $id )
    {
        try {
            $contactoEmpleado = $this->contactoEmpleadoRepository->listarContactoEmpleado($request, $id);
            return response()->json([
                'res' => true,
                'data' => $contactoEmpleado
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar los contactos del empleado',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda contacto de un empleado
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearContactoEmpleadoRequest $request):JsonResponse{
        try {
            $contactoEmpleado = $this->contactoEmpleadoRepository->crear($request->validated());
            return response()->json($contactoEmpleado, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza un contacto de un empleado
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizar(ActualizarContactoEmpleadoRequest $request, ContactoEmpleado $id){
        try {
            $this->contactoEmpleadoRepository->actualizar($id, $request->validated());
            return response()->json([]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(),400);
        }
    }
}
