<?php

namespace Database\Seeders;

use App\Http\Modules\Especialidades\Models\Especialidade;
use Illuminate\Database\Seeder;
use Illuminate\Http\Response;

class EspecialidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $Especialidades = [
                ['nombre' => 'Medicina General','estado' => 1],
                ['nombre' => 'Medico Experto Salud Mental','estado' => 1],
                ['nombre' => 'Medico Experto Reumatologia','estado' => 1],
                ['nombre' => 'Medico Experto Anticoagulados','estado' => 1],
                ['nombre' => 'Medico Experto Nefroproteccion','estado' => 1],
                ['nombre' => 'Medico Experto Respiratorios','estado' => 1],
                ['nombre' => 'Medico Experto Trasmisibles Cronicas','estado' => 1],
                ['nombre' => 'Psiquiatria','estado' => 1],
                ['nombre' => 'Neurologia','estado' => 1],
                ['nombre' => 'Cardiologia','estado' => 1],
                ['nombre' => 'Ginecologia','estado' => 1],
                ['nombre' => 'Obstetricia','estado' => 1],
                ['nombre' => 'Medicina Interna','estado' => 1],
                ['nombre' => 'Anestesiologia','estado' => 1],
                ['nombre' => 'Medicina Familiar','estado' => 1],
                ['nombre' => 'Hematologia','estado' => 1],
                ['nombre' => 'Nefrologia','estado' => 1],
                ['nombre' => 'Otorrinolaringologia','estado' => 1],
                ['nombre' => 'Oftalmologia','estado' => 1],
                ['nombre' => 'Ortopedia y Traumatologia','estado' => 1],
                ['nombre' => 'Endocrinologia','estado' => 1],
                ['nombre' => 'Cirugia Coloproctologica','estado' => 1],
                ['nombre' => 'Cirugia General','estado' => 1],
                ['nombre' => 'Pediatria','estado' => 1],
                ['nombre' => 'Dermatologia','estado' => 1],
                ['nombre' => 'Medicina del Deporte','estado' => 1],
                ['nombre' => 'Alergologia','estado' => 1],
                ['nombre' => 'Mastologia','estado' => 1],
                ['nombre' => 'Neumologia','estado' => 1],
                ['nombre' => 'Medicina del Dolor','estado' => 1],
                ['nombre' => 'Oncologia','estado' => 1],
                ['nombre' => 'Toxicologia','estado' => 1],
                ['nombre' => 'Fisiatria','estado' => 1],
                ['nombre' => 'Urologia','estado' => 1],
                ['nombre' => 'Neurocirugia','estado' => 1],
                ['nombre' => 'Infectologia','estado' => 1],
                ['nombre' => 'Reumatologia','estado' => 1],
                ['nombre' => 'Electrofisiologia','estado' => 1],
                ['nombre' => 'Fonoaudiologia','estado' => 1],
                ['nombre' => 'Terapia Respiratoria','estado' => 1],
                ['nombre' => 'Fisioterapia','estado' => 1],
                ['nombre' => 'Trabajo Social','estado' => 1],
                ['nombre' => 'Psicologia','estado' => 1],
                ['nombre' => 'Nutricion','estado' => 1],
                ['nombre' => 'Optometria','estado' => 1],
                ['nombre' => 'Odontologia','estado' => 1],
                ['nombre' => 'Especialidades de Odontologia','estado' => 1],
                ['nombre' => 'Enfermeria','estado' => 1],
                ['nombre' => 'Medicina Laboral','estado' => 1],
                ['nombre' => 'Medicina Alternativa','estado' => 1],
                ['nombre' => 'Cirugía Cardiovascular','estado' => 1],
                ['nombre' => 'Audiologia','estado' => 1],
                ['nombre' => 'Auxiliar de Enfermeria','estado' => 1],
                ['nombre' => 'Cirugía Bariátrica','estado' => 1],
                ['nombre' => 'Imagenologia','estado' => 1],
                ['nombre' => 'Terapia Ocupacional','estado' => 1],
                ['nombre' => 'Cirugia Plastica','estado' => 1],
                ['nombre' => 'Quimica Farmacologica','estado' => 1],
                ['nombre' => 'Enfermeria Sede','estado' => 1],
                ['nombre' => 'Examenes ocupacionales periódicos','estado' => 1],
                ['nombre' => 'Examenes ocupacionales ingreso','estado' => 1],
                ['nombre' => 'Examenes ocupacionales egreso','estado' => 1],
                ['nombre' => 'Examenes ocupacionales post incapacidad','estado' => 1],
                ['nombre' => 'Examenes ocupacionales reubicación','estado' => 1],
                ['nombre' => 'Consulta Individual De Riesgo Cardiovascular (30 Min)','estado' => 1],
                ['nombre' => 'Teleconsulta Riesgo Cardiovascular (30 min)','estado' => 1],
                ['nombre' => 'Especialidades Post Quirúrgica','estado' => 1],
                ['nombre' => 'Cirugia de Torax','estado' => 1],
                ['nombre' => 'Examenes ocupacionales para participar en eventos deportivos','estado' => 1],
                ['nombre' => 'Examenes ocupacionales para participar en eventos folcloricos','estado' => 1],
                ['nombre' => 'Cirugia Hepatobiliar','estado' => 1],
                ['nombre' => 'Cirugia Hepatobiliar Externa','estado' => 1],
                ['nombre' => 'Cirugia Cabeza y Cuello','estado' => 1],
                ['nombre' => 'Cirugía Vascular','estado' => 1],
                ['nombre' => 'Neuropsicología','estado' => 1],
                ['nombre' => 'Psicologia ocupacional','estado' => 0],
                ['nombre' => 'Voz ocupacional','estado' => 0],
                ['nombre' => 'Visiometria ocupacional','estado' => 0],
                ['nombre' => 'Consulta Medica ocupacional','estado' => 0],
            ];

            foreach ($Especialidades as $Especialidad) {
                Especialidade::updateOrCreate([
                    'nombre' => $Especialidad['nombre'],
                ],[
                    'nombre' => $Especialidad['nombre'],
                    'estado' => $Especialidad['estado'],
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al ejecutar el seeder de especialidades'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
