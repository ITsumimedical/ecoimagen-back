<?php

namespace Database\Seeders;

use Illuminate\Http\Response;
use Illuminate\Database\Seeder;
use App\Http\Modules\TipoConsultas\Models\TipoConsulta;

class TipoConsultaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        try {
            $tipos = [
                [
                    'nombre'    => 'Transcripción',
                    'descripcion' => 'Transcripción',
                ],
                [
                    'nombre'    => 'Citanoprogramada',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Procedimientos Menores',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Gestion Medica',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Demanda',
                    'descripcion' => 'Demanda',
                ],
                [
                    'nombre'    => 'Imagenologia',
                    'descripcion' => 'Imagenologia',
                ],
                [
                    'nombre'    => 'Oncologia',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Historia Sumimedical',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Proced menores domiciliaria',
                    'descripcion' => 'Medicina en Casa',
                ],
                [
                    'nombre'    => 'Enfermeria Oncologia',
                    'descripcion' => 'Notas de Enfermeria Oncologia',
                ],
                [
                    'nombre'    => 'Medico domiciliario',
                    'descripcion' => 'Medico domiciliario',
                ],
                [
                    'nombre'    => 'Oftalmologia',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Psicologia salud ocupacional',
                    'descripcion' => 'Salud ocupacional',
                ],
                [
                    'nombre'    => 'Voz',
                    'descripcion' => 'Salud ocupacional',
                ],
                [
                    'nombre'    => 'Visiometria',
                    'descripcion' => 'Salud ocupacional',
                ],
                [
                    'nombre'    => 'Consulta Medica',
                    'descripcion' => 'Salud ocupacional',
                ],
                [
                    'nombre'    => 'Optometria',
                    'descripcion' => 'Historia clinica sumimedical',
                ],

                [
                    'nombre'    => 'Quimica Farmacologica',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Medico Experto Salud Mental',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Medico Experto Reumatologia',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Medico Experto Anticoagulados',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Medico Experto Nefroproteccion',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Medico Experto Respiratorios',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Medico Experto Trasmisibles Cronicas',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Psiquiatria',
                    'descripcion' => 'Historia clinica sumimedical',
                ],[
                    'nombre'    => 'Neurologia',
                    'descripcion' => 'Historia clinica sumimedical',
                ],[
                    'nombre'    => 'Cardiologia',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Ginecologia',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Obstetricia',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Medicina Interna',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Anestesiologia',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Medicina Familiar',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Hematologia',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Nefrologia',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Otorrinolaringologia',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Ortopedia Y Traumatologia',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Endocrinologia',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Cirugia Coloproctologica',
                    'descripcion' => 'Historia clinica sumimedical',
                ],

                [
                    'nombre'    => 'Cirugia General',
                    'descripcion' => 'Historia clinica sumimedical',
                ],


                [
                    'nombre'    => 'Pediatria',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Dermatologia',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Medicina Del Deporte',
                    'descripcion' => 'Historia clinica sumimedical',
                ],

                [
                    'nombre'    => 'Alergologia',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Mastologia',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Neumologia',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Medicina Del Dolor',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Toxicologia',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Fisiatria',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Urologia',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Medicina Alternativa',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Neurocirugia',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Infectologia',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Reumatologia',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Electrofisiologia',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Fonoaudiologia',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Terapia Respiratoria',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Fisioterapia',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Trabajo Social',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Psicologia',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Nutricion',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Odontologia',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Enfermeria',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Audiologia',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Cirugía Cardiovascular',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Cirugía Bariátrica',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Cirugia Plastica',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Auxiliar De Enfermeria',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Medico Experto RCV',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Neuropsicologia',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Radiologia',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Cirugia Hepatobiliar',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Cirugia Columna Vertebral',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Cirugia Cabeza Y Cuello',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Grupales Rcv',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Primera Infancia',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Consulta Infancia',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Consulta Adolencencia',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Consulta Joven',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Consulta Adultez',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Consulta Vejez',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Control Prenatal',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Planificacion Familiar',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Recien Nacido',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Teleapoyo',
                    'descripcion' => 'Historia clinica sumimedical',
                ],
                [
                    'nombre'    => 'Orden carga resultados oncologicos',
                    'descripcion' => 'Se requiere para poder ordenar los servicios oncologícos',
                ],

            ];
            foreach ($tipos as $tipo) {
                TipoConsulta::updateOrCreate([
                    'nombre'    => $tipo['nombre']
                ],[
                    'nombre'    => $tipo['nombre'],
                    'descripcion' => $tipo['descripcion'],
                ]);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al ejecutar el seeder de tipo cita'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
