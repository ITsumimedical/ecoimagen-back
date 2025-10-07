<?php

namespace Database\Seeders;

use App\Http\Modules\TipoDocumentos\Models\TipoDocumento;
use Illuminate\Database\Seeder;
use Illuminate\Http\Response;

class TipoDocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $documentos = [
                ['nombre' => 'Cédula ciudadanía',],
                ['nombre' => 'Tarjeta de identidad'],
                ['nombre' => 'Registro civil de nacimiento',],
                ['nombre' => 'Tarjeta de extranjería'],
                ['nombre' => 'Cédula de extranjería'],
                ['nombre' => 'NIT'],
                ['nombre' => 'Pasaporte'],
                ['nombre' => 'Tipo documento extranjero'],
                ['nombre' => 'Permiso especial de permanencia'],
                ['nombre' => 'Permiso protección temporal'],
                ['nombre' => 'SalvoConducto'],
                ['nombre' => 'Certificado de Nacido Vivo'],
            ];
            foreach ($documentos as $documento) {
                TipoDocumento::updateOrCreate([
                    'nombre' => $documento['nombre']
                ],[
                    'nombre' => $documento['nombre'],
                ]);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al ejecutar el seeder de tipo documento'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
