<?php

namespace App\Http\Modules\RegistroBiopsias\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\RegistroBiopsias\Repositories\RegistroBiopsiaPatologiasRepository;
use App\Http\Modules\RegistroBiopsias\Requests\RegistroBiopsiaPatologiasRequest;
use App\Http\Modules\RegistroBiopsias\Requests\RegistroCancerColonRequest;
use App\Http\Modules\RegistroBiopsias\Requests\RegistroCancerGastricoRequest;
use App\Http\Modules\RegistroBiopsias\Requests\RegistroCancerOvariosRequest;
use App\Http\Modules\RegistroBiopsias\Requests\RegistroCancerProstataRequest;
use App\Http\Modules\RegistroBiopsias\Requests\RegistroCancerPulmonRequest;
use App\Http\Modules\RegistroBiopsias\Services\RegistroBiopsiaPatologiasServices;
use Illuminate\Http\Request;

class RegistroBiopsiaPatologiasController extends Controller
{
    public function __construct(
        protected RegistroBiopsiaPatologiasServices $registroBiopsiaPatologiasServices,
        protected RegistroBiopsiaPatologiasRepository $registroBiopsiaPatologiasRepository
    ) {}

    public function registroBiopsiaPatologiaCancer(RegistroBiopsiaPatologiasRequest $request)
    {
        try {
            $registro = $this->registroBiopsiaPatologiasServices->registrarBiopsiaConTipo($request->validated(), 'mama');
            return response()->json($registro, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function listarUltimaBiopsiaAfiliado(int $afiliado_id)
    {
        try {
            $biopsiaCancer = $this->registroBiopsiaPatologiasRepository->listarUltimaBiopsiaAfiliado($afiliado_id);
            return response()->json($biopsiaCancer);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function listarHistoricoBiopsiaAfiliado(string $numeroDocumento, string $tipoDocumento) 
    {
        try {
            $biopsias = $this->registroBiopsiaPatologiasRepository->listarHistoricoBiopsiasPorAfiliado($numeroDocumento,$tipoDocumento);
            return response()->json($biopsias);
        } catch (\Throwable $th) {
           return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function listarRegistroCancerAfiliado(int $biopsia_id)
    {
        try {
            $cancer = $this->registroBiopsiaPatologiasRepository->obtenerRegistroCancerAfiliado($biopsia_id);
            return response()->json($cancer);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function registrarBiopsiaProstata(RegistroCancerProstataRequest $request)
    {
        try {
            $registro = $this->registroBiopsiaPatologiasServices->registrarBiopsiaConTipo($request->validated(), 'prostata');
            return response()->json($registro, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function registarBiopsiaOvarios(RegistroCancerOvariosRequest $request)
    {
        try {
            $registro = $this->registroBiopsiaPatologiasServices->registrarBiopsiaConTipo($request->validated(), 'ovario');
            return response()->json($registro);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function registarBiopsiaPulmon(RegistroCancerPulmonRequest $request)
    {
        try {
            $registro = $this->registroBiopsiaPatologiasServices->registrarBiopsiaConTipo($request->validated(), 'pulmon');
            return response()->json($registro);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function registarBiopsiaGastrico(RegistroCancerGastricoRequest $request)
    {
        try {
            $registro = $this->registroBiopsiaPatologiasServices->registrarBiopsiaConTipo($request->validated(), 'gastrico');
            return response()->json($registro);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function registarBiopsiaColon(RegistroCancerColonRequest $request)
    {
        try {
            $registro = $this->registroBiopsiaPatologiasServices->registrarBiopsiaConTipo($request->validated(), 'colon');
            return response()->json($registro);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }
}
