<?php

namespace App\Http\Modules\Empleados\Services;

use App\Http\Modules\Empleados\Models\Empleado;
use App\Http\Modules\Empleados\Repositories\EmpleadoRepository;
use App\Http\Modules\Empleados\Requests\CrearEmpleadoRequest;
use App\Http\Modules\Usuarios\Models\User;
use App\Http\Modules\Usuarios\Repositories\UsuarioRepository;
use Error;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class EmpleadoService
{

    /**
     * Prepara la data para empleado
     * @param Object $request
     * @param int $user_id
     * @autor David Peláez
     */
    public function prepararData($data, $actualizando = false)
    {
        if (!$actualizando) {
            $data['user_id'] = null;
        }
        unset($data['especialidad_id'], $data['medico']);

        return $data;
    }


    /**
     * Valida la informacion de empleado
     * @param Array $data
     * @return boolean|Array
     * @author David Peláez
     */
    public function crearEmpleado($data)
    {
        $objGuardarEmpleadoRequest = new CrearEmpleadoRequest();
        $reglas = $objGuardarEmpleadoRequest->rules();
        $validator = Validator::make($data, $reglas);

        if ($validator->fails()) {
            throw new Error(json_encode($validator->errors()), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $empleado = new Empleado();
        $empleado->fill($data);
        $empleado->save();

        return $empleado;
    }
}
