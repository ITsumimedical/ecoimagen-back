<?php

namespace Database\Seeders;

use App\Http\Modules\AreaClinica\Models\AreaClinica;
use Illuminate\Database\Seeder;
use Illuminate\Http\Response;

class AreaClinicaSedeer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
        $Areas = [
            ['nombre' => 'hospitalizacion'],
            ['nombre' => 'urgencias'],
            ['nombre' => 'cirugías'],
            ['nombre' => 'oncología'],
        ];
        foreach ($Areas as $Area) {
            AreaClinica::updateOrCreate([
                'nombre' => $Area['nombre'],
            ],[
                'nombre' => $Area['nombre'],
            ]);
        };
    } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al ejecutar el seeder de area clinica'
            ],Response::HTTP_BAD_REQUEST);
        }
    }
}
