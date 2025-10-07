<?php

namespace App\Http\Modules\CuestionarioVale\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\CuestionarioVale\Repositories\CuestionarioValeRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CuestionarioValeController extends Controller
{
    protected $cuestionarioValeRepository;

    public function __construct(CuestionarioValeRepository $cuestionarioValeRepository)
    {
        $this->cuestionarioValeRepository = $cuestionarioValeRepository;
    }

    public function crear(Request $request)
    {
        try {
            $this->cuestionarioValeRepository->crearVale($request->all());
            return response()->json('Creado con exito');
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function obtenerDatos($afiliadoId)
    {
        try {
            $audit = $this->cuestionarioValeRepository->obtenerDatosporAfiliado($afiliadoId);
            return response()->json($audit, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }}
