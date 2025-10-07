<?php

namespace App\Http\Modules\LineasCompras\Services;

use App\Http\Modules\LineasCompras\Models\LineasCompras;

class LineasComprasService 
{

    public function crearArea($data)
    {
        return LineasCompras::create($data);
    }

    public function listarArea()
    {
        return LineasCompras::orderBy('id', 'desc')->get();
    }

    public function modificarLinea(int $ids, $request)
    {
        return LineasCompras::where('id', $ids)->update($request);
    }

    public function cambiarEstado(int $id)
    {
        $area = LineasCompras::findOrFail($id);
        return LineasCompras::where('id', $id)->update(['estado' => $area->estado ? false : true]);
    }

}
