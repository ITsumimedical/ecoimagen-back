<?php

namespace App\Http\Modules\AdjuntosProveedoresCompras\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Modules\AdjuntosProveedoresCompras\Request\AdjuntoProveedoresRequest;
use App\Http\Modules\AdjuntosProveedoresCompras\Service\AdjuntoProveedoresService;
use Illuminate\Http\Request;

class AdjuntosProveedorController extends Controller
{
    public function __construct(private AdjuntoProveedoresService $adjuntoProveedor)
    {
    }

    public function CrearAdjunto(AdjuntoProveedoresRequest $adjuntoFuratRequest) 
    {
        try {
            $adjunto = $this->adjuntoProveedor->CrearAdjunto($adjuntoFuratRequest->validated());
            return response()->json($adjunto);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()],400);
        }
    }


}
