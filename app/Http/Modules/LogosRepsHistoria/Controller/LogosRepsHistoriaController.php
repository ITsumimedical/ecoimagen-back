<?php

namespace App\Http\Modules\LogosRepsHistoria\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\LogosRepsHistoria\Requests\CrearLogosPorPrestadorHistoriaRequest;
use App\Http\Modules\LogosRepsHistoria\Requests\CrearLogosRepsHistoriaRequest;
use App\Http\Modules\LogosRepsHistoria\Services\LogosRepsHistoriaService;
use Illuminate\Http\Request;

class LogosRepsHistoriaController extends Controller
{
    public function __construct(
        protected LogosRepsHistoriaService $logosRepsHistoriaService,
    ) {}

	public function crear(CrearLogosRepsHistoriaRequest $request)
	{
		try {
			$logo = $this->logosRepsHistoriaService->crearLogoRepsHistoria($request->validated());
			return response()->json($logo, 201);
		} catch (\Throwable $th) {
			return response()->json(['error' => $th->getMessage()], 400);
		}
	}

	public function subirLogoVariosReps(CrearLogosPorPrestadorHistoriaRequest $request)
	{
		try {
			$logo = $this->logosRepsHistoriaService->subirLogoVariosReps($request->validated());
			return response()->json($logo, 201);
		} catch (\Throwable $th) {
			return response()->json(['error' => $th->getMessage()], 400);
		}
	}

	public function obtenerLogoPorRep($rep_id)
	{
		try {
			$logo = $this->logosRepsHistoriaService->obtenerLogoPorRepId($rep_id);
			return response()->json($logo, 200);
		} catch (\Throwable $th) {
			return response()->json(['error' => $th->getMessage()], 400);
		}
	}
}
