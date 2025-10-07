<?php

namespace App\Http\Modules\LineasCompras\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\LineasCompras\Repositories\LineasComprasRepository;
use App\Http\Modules\LineasCompras\Requests\crearLineasComprasRequest;
use App\Http\Modules\LineasCompras\Requests\modificarLineasComprasRequest;
use App\Http\Modules\LineasCompras\Services\LineasComprasService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LineasComprasController extends Controller
{

    public function __construct(private LineasComprasService $lineasComprasService)
    {
    }

    public function crearLinea(crearLineasComprasRequest $request)
    {
        try {
            $lineas = $this->lineasComprasService->crearArea($request->all());
            return response()->json($lineas, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function listarLinea()
    {
        try {
            $lineas = $this->lineasComprasService->listarArea();
            return response()->json($lineas, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }


    public function modificarLinea(int $ids, modificarLineasComprasRequest $request)
    {
        try {
            $lineas = $this->lineasComprasService->modificarLinea($ids, $request->all());
            return response()->json($lineas, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }


    public function cambiarEstado(int $id)
    {
        try {
            $this->lineasComprasService->cambiarEstado($id);
             return response()->json(['message' => 'Estado cambiado con éxito'], 200);
         } catch (\Throwable $th) {
             return response()->json(['error'=> $th->getMessage()], 500);
         }
    }
}