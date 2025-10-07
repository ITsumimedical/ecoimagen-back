<?php

namespace App\Http\Modules\OrdenCabecera\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\OrdenCabecera\Repositories\OrdenCabeceraRepository;
use Illuminate\Http\Request;

class OrdenCabeceraController extends Controller
{
    public function __construct( private OrdenCabeceraRepository $ordenCabeceraRepository) {
    }

    public function listarLaboratorios(Request $request){
        try {
            $bodegas = $this->ordenCabeceraRepository->listarLaboratorios($request->all());
            return response()->json($bodegas, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function resultados(Request $request){
        try {
            $bodegas = $this->ordenCabeceraRepository->resultados($request->all());
            return response()->json($bodegas, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }
}
