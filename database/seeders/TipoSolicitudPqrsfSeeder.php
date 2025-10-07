<?php

namespace Database\Seeders;

use App\Http\Modules\GestionPqrsf\TipoSolicitudes\Models\TipoSolicitudpqrsf;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Http\Response;

class TipoSolicitudPqrsfSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {

        try {
            $tipos = [
                ['nombre' => 'Petición', 'descripcion' => 'Es una solicitud verbal o escrita, que tiene como propósito requerir la intervención de la entidad en un asunto concreto'],
                ['nombre' => 'Queja', 'descripcion' => 'Es la manifestación de inconformidad o descontento expresada por un proveedor, relacionada con el comportamiento o la atención prestada por parte de un funcionario o colaborador de la entidad'],
                ['nombre' => 'Reclamo', 'descripcion' => 'Es la exigencia de atención presentada por un proveedor, ocasionada y relacionada con la ausencia y deficiencia de un servicio o producto'],
                ['nombre' => 'Sugerencia', 'descripcion' => 'Es la propuesta de adecuación o mejora en la prestación de un servicio'],
                ['nombre' => 'Felicitación', 'descripcion' => 'Manifestación del usuario para expresar su satisfacción frente al servicio recibido por la Institución'],
                ['nombre' => 'Solicitud', 'descripcion' => 'Manifestación del usuario solicitando a la entidad sobre un tema que afecta a una persona o grupo en particular'],
                ['nombre' => 'Información', 'descripcion' => 'Interes del usuario en pedir informacíón relacionada'],
                ['nombre' => 'Deberes', 'descripcion' => 'Debel de la entidad o del afiliado en cumplir ciertas reglas'],


            ];
            foreach ($tipos as $tipo) {
                TipoSolicitudpqrsf::updateOrCreate([
                    'nombre' => $tipo['nombre']
                ],[
                    'nombre' => $tipo['nombre'],
                    'descripcion' => $tipo['descripcion']
                ]);
            };
        } catch (\Throwable $th) {
            return response()->json(['mensaje' => 'No se ha podido ejecutar el seeder TipoSolicitudPqrsfSeeder'],
            Response::HTTP_BAD_REQUEST);
        }
    }
}
