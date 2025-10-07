<?php

namespace App\Http\Modules\PrincipiosActivos\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\PrincipiosActivos\Model\principioActivo;
use App\Http\Modules\PrincipiosActivos\Repositories\principioActivoRepository;
use App\Http\Modules\PrincipiosActivos\Request\CrearPrincipioActivoRequest;
use Illuminate\Http\Request;

class principioActivoController extends Controller
{
    protected $principioActivo;

    public function __construct(principioActivoRepository $principioActivo)
    {
        $this->principioActivo = $principioActivo;
    }

    public function listar(Request $request)
    {
        try {
            $activos = $this->principioActivo->listar($request);
            return response()->json($activos);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public function crear(CrearPrincipioActivoRequest $request)
    {
        try {
           $principio = $this->principioActivo->crear($request->validated());
            return response()->json($principio, 201);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public function actualizar($id, Request $request)
    {
        try {
            $actualizar = $this->principioActivo->actualizarPrincipio($id, $request->all());
            return response()->json($actualizar);
        } catch (\Throwable $th) {
            return response()->json(['eror' => $th->getMessage()]);
        }
    }
}
