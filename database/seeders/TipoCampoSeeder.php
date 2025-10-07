<?php

namespace Database\Seeders;

use App\Http\Modules\TipoCampo\Models\TipoCampo;
use Illuminate\Database\Seeder;
use Illuminate\Http\Response;

class TipoCampoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $campos = [
                [
                    'nombre'         => 'string',
                    'descripcion'    => 'Campo de 191 caracteres',
                ],
                [
                    'nombre'         => 'text',
                    'descripcion'    => 'Campo de 1024 caracteres',
                ],
                [
                    'nombre'         => 'boolean',
                    'descripcion'    => 'Campo para falso o verdadero',
                ],
                [
                    'nombre'         => 'date',
                    'descripcion'    => 'Campo de fecha',
                ],
                [
                    'nombre'         => 'double',
                    'descripcion'    => 'Campo para decimales',
                ],
                [
                    'nombre'         => 'time',
                    'descripcion'    => 'Campo para hora',
                ],
                [
                    'nombre'         => 'dateTime',
                    'descripcion'    => 'Campo para fecha y hora',
                ],
                [
                    'nombre'         => 'number',
                    'descripcion'    => 'Campo para numeros enteros',
                ],
                [
                    'nombre'         => 'select',
                    'descripcion'    => 'Campo para listas desplegables',
                ],
                [
                    'nombre'         => 'subcategoria',
                    'descripcion'    => 'Titulo separador',
                ],
                [
                    'nombre'         => 'Calificacion',
                    'descripcion'    => 'Lista de preguntas con un valor asignado',
                ],
                [
                    'nombre'         => 'Promedio',
                    'descripcion'    => 'Lista de preguntas con varias opciones, cada una con un valor diferentes',
                ],
            ];
            foreach ($campos as $campo) {
                TipoCampo::updateOrCreate([
                    'nombre'      => $campo['nombre']
                ],[
                    'nombre'      => $campo['nombre'],
                    'descripcion' => $campo['descripcion'],
                ]);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al ejecutar el seeder de tipo campo'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
