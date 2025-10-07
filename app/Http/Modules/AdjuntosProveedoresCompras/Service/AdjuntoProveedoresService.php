<?php

namespace App\Http\Modules\AdjuntosProveedoresCompras\Service;

use App\Http\Modules\AdjuntosProveedoresCompras\Models\AdjuntoProveedor;

class AdjuntoProveedoresService
{
    public function crearAdjunto($request)
    {

        $adjunto = AdjuntoProveedor::create([ 
            'nombre' => $request['nombre'],
            'ruta_adjunto' => $request['ruta_adjunto'],
            'tipo_adjunto' => $request['tipo_adjunto'],
            'proveedor_id' => $request['proveedor_id'],
        ]);

        return $adjunto; 
    }
}
