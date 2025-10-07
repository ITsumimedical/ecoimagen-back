<?php

namespace App\Http\Modules\PerfilSociodemograficos\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\PerfilSociodemograficos\Models\PerfilSociodemografico;
use App\Http\Modules\perfilSociodemograficos\Requests\CrearPerfilSociodemograficoRequest;
use App\Http\Modules\PerfilSociodemograficos\Repositories\PerfilSociodemograficoRepository;
use App\Http\Modules\perfilSociodemograficos\Requests\ActualizarPerfilSociodemograficoRequest;

class PerfilSociodemograficoController extends Controller
{
    private $perfilSociodemograficoRepository;

    public function __construct(){
        $this->perfilSociodemograficoRepository = new PerfilSociodemograficoRepository;
    }

    /**
     * lista los perfiles sociodemográficos de los empleados según su id
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request, $id )
    {
        try {
            $perfil = $this->perfilSociodemograficoRepository->listarPerfilEmpleado($request, $id);
            return response()->json($perfil
                );
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar el perfil sociodemográfico del empleado',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un perfil sociodemográfico de un empleado
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearPerfilSociodemograficoRequest $request){
        try {
            $contrato = $this->perfilSociodemograficoRepository->crear($request->all());
            return response()->json($contrato,201);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(),400);
        }
    }

    /**
     * Actualiza un perfil sociodemográfico de un empleado según su id
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizar(ActualizarPerfilSociodemograficoRequest $request, int $id): JsonResponse
    {
        try {
            $perfilSociodemografico = $this->perfilSociodemograficoRepository->buscar($id);
            $perfilSociodemografico->fill($request->validated());

            $perfilEmpleado = $this->perfilSociodemograficoRepository->actualizar($perfilSociodemografico,$request->validated());

            return response()->json([
                'res' => true,
                'data' => $perfilEmpleado,
                'mensaje' => 'Perfil actualizado con exito!.'
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al actualizar el perfil'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

}
