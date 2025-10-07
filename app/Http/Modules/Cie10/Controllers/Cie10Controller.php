<?php

namespace App\Http\Modules\Cie10\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Cie10\Repositories\Cie10Repository;
use App\Http\Modules\Cie10Afiliado\Repositories\Cie10AfiliadoRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class Cie10Controller extends Controller
{
    private $cie10Repository;

    public function __construct(private Cie10AfiliadoRepository $cie10AfiliadoRepository)
    {
        $this->cie10Repository = new Cie10Repository();
    }

    /**
     * lista los cie10
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request)
    {
        ini_set('memory_limit', '-1');

        $cie10 = Cache::remember('cie10s', 43200, function() use ($request) {
            return $this->cie10Repository->listar($request);
        });
        try {
            return response()->json($cie10, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar los cie10',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarFiltro(Request $request)
    {
        try {
            $cie10 = $this->cie10Repository->listarFiltro($request);
            return response()->json($cie10, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al recuperar los cie10',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarAntecedentesPersonales()
    {
        try {
            $cie10 = $this->cie10Repository->listarAntecedentesPersonales();
            return response()->json($cie10, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al recuperar los cie10',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    //LISTAR NUEVO PARA NO DAÑOR LOS OTROS
    public function listarc10(Request $request)
    {
        ini_set('memory_limit', '-1');
        return $this->cie10Repository->listarC10($request);
        // $cie10 = Cache::remember('cie10s', 43200, function() use ($request) {

        // });
        try {
            return response()->json($cie10, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar los cie10',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

     /**
     * lista los cie10 del afiliado por consulta
     * @param Request $request
     * @return Response
     * @author jdss
     */

     public function consultarCie10Consulta(Request $request){
        try {
            $cie10 = $this->cie10AfiliadoRepository->listarCie10Historico($request);
            return response()->json($cie10, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar los cie10',
            ], Response::HTTP_BAD_REQUEST);
        }
     }

     public function cie10Primario(int $consulta){
        try {
            $cie10 = $this->cie10AfiliadoRepository->diagnosticoPrimario($consulta);
            return response()->json($cie10, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
     }
}
