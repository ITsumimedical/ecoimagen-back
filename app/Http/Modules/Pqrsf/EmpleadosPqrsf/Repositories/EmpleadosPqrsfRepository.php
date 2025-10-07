<?php

namespace App\Http\Modules\Pqrsf\EmpleadosPqrsf\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\GestionPqrsf\Formulario\Models\Formulariopqrsf;
use App\Http\Modules\Pqrsf\EmpleadosPqrsf\Model\EmpleadosPqrsf;

class EmpleadosPqrsfRepository extends RepositoryBase
{



    public function __construct(protected EmpleadosPqrsf $empleadosPqrsfModel) {}

    public function listarEmpleados($data)
    {
        return   $this->empleadosPqrsfModel::where('formulario_pqrsf_id', $data['pqr_id'])->with('empleado')->get();
    }

    public function crearEmpleado($empleado, $pqr)
    {
        $this->empleadosPqrsfModel::create(['operador_id' => $empleado, 'formulario_pqrsf_id' => $pqr]);
    }

    public function eliminar($data)
    {
        return   $this->empleadosPqrsfModel::find($data['empleado'])->delete();
    }

    public function actualizarOperadores($pqrsfId, $request)
    {
        $pqrsf = Formulariopqrsf::findOrFail($pqrsfId);

        $pqrsf->operadorPqrsf()->syncWithoutDetaching($request['operadores']);

        return response()->json(['message' => 'Empleados actualizados correctamente']);
    }

    public function removerOperador($pqrsfId, $request)
    {
        $pqrsf = Formulariopqrsf::findOrFail($pqrsfId);

        // Eliminar la relación en la tabla intermedia
        $pqrsf->operadorPqrsf()->detach($request['operador']);

        return response()->json(['message' => 'Empleado eliminado correctamente']);
    }
}
