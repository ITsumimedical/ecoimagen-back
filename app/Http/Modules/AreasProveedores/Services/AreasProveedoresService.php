<?php

namespace App\Http\Modules\AreasProveedores\Services;

use App\Http\Modules\AreasProveedores\Models\AreasProveedores;

class AreasProveedoresService {


    public function crearArea(array $data)
    {
        return AreasProveedores::create($data);
    }

    public function listarArea($request)
    {
        return AreasProveedores::orderBy('id', 'desc')->get();
    }

    public function modificarArea(int $id, $request)
    {
        return AreasProveedores::where('id', $id)->update($request);
    }

    public function cambiarEstado(int $id)
    {
        $area = AreasProveedores::findOrFail($id);
        return AreasProveedores::where('id', $id)->update(['estado' => $area->estado ? false : true]);
    }

    public function asignarUsuariosporAreas(int $id, array $data)
    {
        $query = AreasProveedores::where('id', $id)->first();
        $query->users()->sync($data['operadores']);
        return $query;
    }

    public function listarOperadoresPorArea(int $id)
    {
        return AreasProveedores::where('id', $id)->with('users.operador',)->get();
    }    
}
