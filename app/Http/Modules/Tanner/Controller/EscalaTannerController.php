<?php

namespace App\Http\Modules\Tanner\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\Tanner\Repositories\EscalaTannerRepository;
use App\Http\Modules\Tanner\Request\CrearEscalaTannerRequest;
use Illuminate\Http\Request;

class EscalaTannerController extends Controller
{
    public function __construct(
        protected EscalaTannerRepository $tannerRepository,
    ) {}
    public function crear(CrearEscalaTannerRequest $request)
    {
        try {
            $tanner = $this->tannerRepository->crearTanner($request->validated());
            return response()->json($tanner);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }
    public function obtenerDatos($afiliadoId)
    {
        try {
            $tanner = $this->tannerRepository->obtenerDatos($afiliadoId);
            return response()->json($tanner);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }
}
