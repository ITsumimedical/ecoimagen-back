<?php

namespace App\Http\Modules\Eventos\AccionesInseguras\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Eventos\AccionesInseguras\Models\AccionesInsegura;
use App\Http\Modules\Eventos\AccionesInseguras\Repositories\AccionInseguraRepository;
use App\Http\Modules\Eventos\AccionesInseguras\Requests\ActualizarAccionInseguraRequest;
use App\Http\Modules\Eventos\AccionesInseguras\Requests\CrearAccionInseguraRequest;

class AccionInseguraController extends Controller
{
    private $accionInseguraRepository;

    public function __construct(){
        $this->accionInseguraRepository = new AccionInseguraRepository();
    }

    /**
     * crear - crea una acción de inseguras
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function crear(CrearAccionInseguraRequest $request):JsonResponse{
        try {
            $accionInsegura = $this->accionInseguraRepository->crear($request->validated());
            return response()->json($accionInsegura, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function listar(Request $request, $id )
    {
        try {
            $accioninsegura = $this->accionInseguraRepository->listarAccionInsegura($request, $id);
            return response()->json($accioninsegura, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar las acciones inseguras',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizar(ActualizarAccionInseguraRequest $request, AccionesInsegura $id){
        try {
            $this->accionInseguraRepository->actualizar($id, $request->validated());
            return response()->json([]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(),400);
        }
    }

    public function actualizarDeletedAt(AccionesInsegura $accionInseguraEvento)
    {
        try {
            $accionInsegura = $this->accionInseguraRepository->actualizarDeletedAt($accionInseguraEvento);

            return response()->json([
                'res' => true,
                'mensaje' => 'Se ha eliminado correctamente el registro',
                'data' => $accionInsegura,
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al eliminar el registro',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
