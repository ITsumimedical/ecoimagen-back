<?php

namespace App\Http\Modules\Proveedores\Controllers;

use App\Http\Modules\Proveedores\Repositories\ProveedorRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function __construct(protected ProveedorRepository $proveedorRepository)
    {
    }

    public function listar()
    {
        try {
            $proveedores = $this->proveedorRepository->listar([]);
            return response()->json($proveedores);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al recuperar las area',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

}
