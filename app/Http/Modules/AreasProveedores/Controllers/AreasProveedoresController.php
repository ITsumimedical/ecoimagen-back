<?php

namespace App\Http\Modules\AreasProveedores\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\AreasProveedores\Request\CrearAreasProveedoresRequest;
use App\Http\Modules\AreasProveedores\Request\ModificarAreasProveedoresRequest;
use App\Http\Modules\AreasProveedores\Services\AreasProveedoresService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AreasProveedoresController extends Controller
{

    public function __construct(private AreasProveedoresService $areasProveedoresService) 
    {
    }

    public function crearAreasProveedores(CrearAreasProveedoresRequest $request)
    {
        try {
            $areas = $this->areasProveedoresService->crearArea($request->all());
            return response()->json($areas, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function listarAreasProveedores(Request $request)
    {
        try {
            $areas = $this->areasProveedoresService->listarArea($request);
            return response()->json(data: $areas);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function modificarArea($id, ModificarAreasProveedoresRequest $request)
    {
        try {
            $this->areasProveedoresService->modificarArea($id, $request->validated());
            return response()->json('Se ha actualizado correctamente el area', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function cambiarEstado(int $id)
    {
        try {
            $this->areasProveedoresService->cambiarEstado($id);
             return response()->json(['message' => 'Estado cambiado con éxito'], 200);
         } catch (\Throwable $th) {
             return response()->json(['error'=> $th->getMessage()], 500);
         }
    }

    public function asignarUsuariosporAreas(int $id , Request $request)
    {
        try {
            $this->areasProveedoresService->asignarUsuariosporAreas($id, $request->all());
            return response()->json(['message' => 'Usuarios asignados con éxito'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error'=> $th->getMessage()], 500);
        }
    }

    public function listarOperadoresPorArea(int $id)
    {
        try {
            $operadores = $this->areasProveedoresService->listarOperadoresPorArea($id);
            return response()->json($operadores, 200);
        } catch (\Throwable $th) {
            return response()->json(['error'=> $th->getMessage()], 500);
        }
    }
}
