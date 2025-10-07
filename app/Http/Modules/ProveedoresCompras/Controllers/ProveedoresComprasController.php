<?php

namespace App\Http\Modules\ProveedoresCompras\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\ProveedoresCompras\Repository\ProveedoresComprasRepository;
use App\Http\Modules\ProveedoresCompras\Request\cargaMasivaProveedoresComprasRequest;
use App\Http\Modules\ProveedoresCompras\Request\crearProvedoresComprasRequest;
use App\Http\Modules\ProveedoresCompras\Request\modificarProveedoresComprasRequest;
use App\Http\Modules\ProveedoresCompras\Services\ProveedoresComprasService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProveedoresComprasController extends Controller
{

    public function __construct(private ProveedoresComprasService $proveedoresComprasService)
    {
    }

    public function crearProveedor(crearProvedoresComprasRequest $request)
    {
        try {
            $proveedor = $this->proveedoresComprasService->crearProveedor($request->all());
            return response()->json($proveedor, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function listarProveedor(Request $request)
    {
        try {
            $proveedor = $this->proveedoresComprasService->listarProveedor($request->all());
            return response()->json($proveedor, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function cambiarEstado(int $id)
    {
        try {
            $this->proveedoresComprasService->cambiarEstado($id);
            return response()->json(['message' => 'Estado cambiado con éxito'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function contadoresProveedor()
    {
        try {
            $proveedor = $this->proveedoresComprasService->contadoresProveedor();
            return response()->json($proveedor, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function proveedoresLineas(Request $request)
    {
        try {
            $this->proveedoresComprasService->proveedoresLineas($request->all());
            return response()->json(['Lineas agregadas con éxito'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function modificarProveedor($id, Request $request)
    {
        try {
            $this->proveedoresComprasService->modificarProveedor($request->all(), $id);
            return response()->json(['Proveedor modificado con éxito'], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function obtenerAdjuntosPorProveedorId($proveedor)
    {
        try {
            $adjuntosConUrl = $this->proveedoresComprasService->obtenerAdjuntosPorProveedorId($proveedor);
            return response()->json($adjuntosConUrl, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function cargaMasiva(cargaMasivaProveedoresComprasRequest $request)
    {
        try {
            return $this->proveedoresComprasService->cargaMasiva($request->validated());
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }    
}