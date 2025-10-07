<?php

namespace App\Http\Modules\ImagenesContratoSedes\Services;

use App\Http\Modules\ImagenesContratoSedes\Models\ImagenesContratoSedes;

class ImagenesContratoSedesService
{
    public function subirImagen($request)
    {
        $imagen = ImagenesContratoSedes::create([
            'nombre' => $request['nombre'],
            'url_imagen' => $request['url_imagen'],
            'rep_id' => $request['rep_id']
        ]);

        return $imagen;
    }

    public function consultarImagen($id)
    {
        $imagen = ImagenesContratoSedes::where('rep_id', $id)->get();
        return $imagen;
    }

    public function actualizarImagen(array $request, int $rep_id)
    {
        $actualizarImagen = ImagenesContratoSedes::where('rep_id', $rep_id);
        $actualizarImagen->update([
            'nombre' => $request['nombre'],
            'url_imagen' => $request['url_imagen'],
            'rep_id' => $request['rep_id']
        ]);
    }
}
