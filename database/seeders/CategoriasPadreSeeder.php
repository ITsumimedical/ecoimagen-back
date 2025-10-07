<?php

namespace Database\Seeders;

use App\Http\Modules\categoriasPadres\Models\CategoriaPadre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Http\Response;

class CategoriasPadreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        try {
            $categorias = [
                ['nombre' => 'Administrativo',  'descripcion' => 'Administrativo', 'estado_id' => 7],
                ['nombre' => 'Asistencial', 'descripcion' =>  'Asistencial','estado_id' => 7],

            ];
            foreach ($categorias as $categoria) {
                CategoriaPadre::updateOrCreate([
                    'nombre' => $categoria['nombre'],
                ], [
                    'nombre' => $categoria['nombre'],
                    'descripcion' => $categoria['descripcion'],
                    'estado_id' => $categoria['estado_id'],
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al ejecutar el seeder de de categoriasPadres'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
