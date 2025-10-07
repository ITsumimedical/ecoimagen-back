<?php

namespace App\Http\Modules\HistoricoContratoEmpleado\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\HistoricoContratoEmpleado\Requests\CrearHistoricoContratoEmpleado;
use App\Http\Modules\HistoricoContratoEmpleado\Repositories\HistoricoContratoEmpleadoRepository;

class HistoricoContratoEmpleadoController extends Controller
{
    private $historicoContratoRepository;

    public function __construct(){
        $this->historicoContratoRepository = new HistoricoContratoEmpleadoRepository();
    }

    /**
     * crear - crea un historico del
     * contrato laboral de un empleado
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function crear(CrearHistoricoContratoEmpleado $request):JsonResponse{
        try {
            $historico = $this->historicoContratoRepository->crear($request->validated());
            return response()->json($historico, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function listar($id)
    {
        try {
            $historico = $this->historicoContratoRepository->listarHistoricoContrato($id);
            return response()->json($historico, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al listar el histórico del contrato laboral',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
