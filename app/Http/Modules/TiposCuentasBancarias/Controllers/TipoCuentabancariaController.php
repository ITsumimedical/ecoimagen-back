<?php

namespace App\Http\Modules\TiposCuentasBancarias\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\TiposCuentasBancarias\Models\TipoCuentaBancaria;
use App\Http\Modules\TiposCuentasBancarias\Repositories\TipoCuentaBancariaRepository;
use App\Http\Modules\TiposCuentasBancarias\Requests\ActualizarTipoCuentaBancariaRequest;
use App\Http\Modules\TiposCuentasBancarias\Requests\CrearTipoCuentaBancariaRequest;

class TipoCuentabancariaController extends Controller
{
    private $tipoCuentaBancariaRepository;

    public function __construct(){
        $this->tipoCuentaBancariaRepository = new TipoCuentaBancariaRepository;
    }

    /**
     * lista los tipos de cuentas bancarias
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request): JsonResponse
    {
        $tipoCuenta = $this->tipoCuentaBancariaRepository->listar($request);
        try {
            return response()->json([
                'res' => true,
                'data' => $tipoCuenta
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los tipos de cuentas bancarias',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un tipo de cuenta bancaria
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearTipoCuentaBancariaRequest $request):JsonResponse{
        try {
            $tipoCuenta = $this->tipoCuentaBancariaRepository->crear($request->validated());
            return response()->json($tipoCuenta, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza un tipo de cuenta bancaria
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizar(ActualizarTipoCuentaBancariaRequest $request, TipoCuentaBancaria $id){
        try {
            $this->tipoCuentaBancariaRepository->actualizar($id, $request->validated());
            return response()->json([]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(),400);
        }
    }
}
