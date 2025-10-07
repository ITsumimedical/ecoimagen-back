<?php

namespace Database\Seeders;

use App\Http\Modules\TipoUsuarios\Models\TipoUsuario;
use Illuminate\Database\Seeder;
use Illuminate\Http\Response;

class TipoUsuarioSeeder extends Seeder
{
    /**
     * Ejecutar el seeder para el registro de tipoUsuarios y validar si ya el nombre existe en DB.
     *
     * @return void
     * @author calvarez
     */
    public function run()
    {

       try {
        $tipoUsuarios = [
            [
                'nombre'       =>  'Empleado',
                'descripcion'  =>  'Uso exclusivo para empleados sumimedical!',
                'estado_id'    =>  1
            ],
            [
                'nombre'       =>  'Afiliado',
                'descripcion'  =>  'Uso exclusivo para afiliados',
                'estado_id'    =>  1
            ],
            [
                'nombre'      =>  'Operador',
                'descripcion' =>  'Uso exclusivo para operadores externos',
                'estado_id'   =>  1
            ],
            [
                'nombre'      =>  'Externos',
                'descripcion' =>  'Uso exclusivo para usuarios que estan en reps',
                'estado_id'   =>  1
            ],
        ];
        foreach ($tipoUsuarios as $tipoUsuario) {
            TipoUsuario::updateOrCreate(
            ['nombre'           => $tipoUsuario['nombre']],
            [
                'nombre'        => $tipoUsuario['nombre'],
                'descripcion'   => $tipoUsuario['descripcion'],
                'estado_id'     => $tipoUsuario['estado_id']
            ]);
        }

       } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al ejecutar el seeder de tipo usuario'
            ], Response::HTTP_BAD_REQUEST);
       }
    }
}
