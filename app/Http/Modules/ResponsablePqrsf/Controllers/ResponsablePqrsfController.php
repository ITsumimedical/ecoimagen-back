<?php

namespace App\Http\Modules\ResponsablePqrsf\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\ResponsablePqrsf\Repositories\ResponsablePqrsfRepository;

class ResponsablePqrsfController extends Controller
{
    public function __construct(private ResponsablePqrsfRepository $responsablePqrsfRespository) {
    }

    public function listar(Request $request)
    {
        try {
            $responsable = $this->responsablePqrsfRespository->listarReponsable($request);
            return response()->json($responsable, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                $th->getMessage(),
                'mensaje' => 'Error al recuperar los responsables',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
    public function listarTodos(Request $request)
    {
        try {
            $responsable = $this->responsablePqrsfRespository->listarTodos($request);
            return response()->json($responsable, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                $th->getMessage(),
                'mensaje' => 'Error al recuperar los responsables',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function crear(Request $request){
        // return $request->all();
        try {
            $responsable = $this->responsablePqrsfRespository->crear($request->all());
            return response()->json($responsable , Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function CambiarEstado($id)
    {
        try {
            $cambiarEstado = $this->responsablePqrsfRespository->cambiarEstado($id);
            return response()->json($cambiarEstado, Response::HTTP_ACCEPTED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizar(Request $request, int $id)
    {
        try {
            $responsablePqr = $this->responsablePqrsfRespository->buscar($id);
            $responsablePqr->fill($request->all());
            $responsableUpdate = $this->responsablePqrsfRespository->guardar($responsablePqr);
            return response()->json([
                'res' => true,
                'mensaje' => 'Actualizado con exito!.'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al actualizar el responsable',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
