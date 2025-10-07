<?php

namespace Database\Seeders;

use App\Http\Modules\Eventos\ClasificacionAreas\Models\ClasificacionArea;
use Illuminate\Database\Seeder;
use Illuminate\Http\Response;

class ClasificacionSucesoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {

                ClasificacionArea::create(['nombre'=>'Inoportunidad en el reporte de exámenes', 'suceso_id' => 113]);
                ClasificacionArea::create(['nombre'=>'Inoportunidad en la toma de muestras', 'suceso_id' => 113]);
                ClasificacionArea::create(['nombre'=>'Inoportunidad en el procesamiento de muestras ', 'suceso_id' => 113]);
                ClasificacionArea::create(['nombre'=>'Toma de examen a paciente equivocado', 'suceso_id' => 113]);
                ClasificacionArea::create(['nombre'=>'Perdida de muestras', 'suceso_id' => 113]);
                ClasificacionArea::create(['nombre'=>'Entrega de resultado equivocado', 'suceso_id' => 113]);
                ClasificacionArea::create(['nombre'=>'Falta de oportunidad en la toma de ayudas diagnosticas', 'suceso_id' => 114]);
                ClasificacionArea::create(['nombre'=>'Toma de ayuda diagnostica a paciente equivocado', 'suceso_id' => 114]);
                ClasificacionArea::create(['nombre'=>'Entrega de resultado equivocado', 'suceso_id' => 114]);
                ClasificacionArea::create(['nombre'=>'Reacción alérgica al medio de contraste', 'suceso_id' => 114]);
                ClasificacionArea::create(['nombre'=>'Extravasación del medio de contraste', 'suceso_id' => 114]);
                ClasificacionArea::create(['nombre'=>'Entrega equivocada de un neonato ', 'suceso_id' => 115]);
                ClasificacionArea::create(['nombre'=>'Retención de cuerpo extraño en paciente quirúrgico ', 'suceso_id' => 116]);
                ClasificacionArea::create(['nombre'=>'Mortalidad quirúrgica en cirugía electiva ', 'suceso_id' => 116]);
                ClasificacionArea::create(['nombre'=>'Intervención en sitio equivocado ', 'suceso_id' => 116]);
                ClasificacionArea::create(['nombre'=>'Otro evento adverso relacionado con cancelación o retraso de cirugía', 'suceso_id' => 1]);
                ClasificacionArea::create(['nombre'=>'Paciente con diagnóstico de apendicitis que no es intervenido en las 12 horas posteriores al diagnóstico', 'suceso_id' => 116]);
                ClasificacionArea::create(['nombre'=>'Luxación postquirúrgica en reemplazo de cadera', 'suceso_id' => 116]);
                ClasificacionArea::create(['nombre'=>'Deshiscencia de sutura', 'suceso_id' => 116]);
                ClasificacionArea::create(['nombre'=>'Infección del tracto urinario relacionado con catéter vesical ', 'suceso_id' => 117]);
                ClasificacionArea::create(['nombre'=>'Bacteremia asociada a catéter', 'suceso_id' => 117]);
                ClasificacionArea::create(['nombre'=>'Neumonia asociada a la ventilación mecanica', 'suceso_id' => 117]);
                ClasificacionArea::create(['nombre'=>'Neumonia asociada al cuidado de la salud', 'suceso_id' => 117]);
                ClasificacionArea::create(['nombre'=>'Infecciones cruzadas', 'suceso_id' => 117]);
                ClasificacionArea::create(['nombre'=>'Flebitis ', 'suceso_id' => 117]);
                ClasificacionArea::create(['nombre'=>'Infección del sitio operatorio ', 'suceso_id' => 117]);
                ClasificacionArea::create(['nombre'=>'Error en Prescripción', 'suceso_id' => 109]);
                ClasificacionArea::create(['nombre'=>'Error en Disponibilidad', 'suceso_id' => 109]);
                ClasificacionArea::create(['nombre'=>'Error en Dispensación', 'suceso_id' => 109]);
                ClasificacionArea::create(['nombre'=>'Error en Administración', 'suceso_id' => 109]);
                ClasificacionArea::create(['nombre'=>'Errores de calidad', 'suceso_id' => 109]);
                ClasificacionArea::create(['nombre'=>'Fallo Terapéutico', 'suceso_id' => 109]);
                ClasificacionArea::create(['nombre'=>'Otros problemas relacionados a medicamentos', 'suceso_id' => 109]);
                ClasificacionArea::create(['nombre'=>'Reacción Adversa a Medicamento', 'suceso_id' => 109]);
                ClasificacionArea::create(['nombre'=>'Evento adverso relacionado con dispositivos médicos', 'suceso_id' => 139]);
                ClasificacionArea::create(['nombre'=>'Evento adverso relacionado con equipo biomédico', 'suceso_id' => 139]);
                ClasificacionArea::create(['nombre'=>'Error en Transcripción', 'suceso_id' => 109]);
                ClasificacionArea::create(['nombre'=>'Éventos adversos post vacunación', 'suceso_id' => 109]);
                ClasificacionArea::create(['nombre'=>'Infecciones asociadas a la inserción de DIU', 'suceso_id' => 117]);
                ClasificacionArea::create(['nombre'=>'Infecciones asociadas al implante subdermico', 'suceso_id' => 117]);
                ClasificacionArea::create(['nombre'=>'Dermatitis asociada a la incontinencia', 'suceso_id' => 20]);
                ClasificacionArea::create(['nombre'=>'MARSI', 'suceso_id' => 20]);
                ClasificacionArea::create(['nombre'=>'Lesión por presión no estadiable', 'suceso_id' => 20]);
                ClasificacionArea::create(['nombre'=>'Lesión por presión categoría lll', 'suceso_id' => 20]);
                ClasificacionArea::create(['nombre'=>'Lesión por presión categoría ll', 'suceso_id' => 20]);
                ClasificacionArea::create(['nombre'=>'Lesión por presión categoría l', 'suceso_id' => 20]);
                ClasificacionArea::create(['nombre'=>'Otro', 'suceso_id' => 112]);
                ClasificacionArea::create(['nombre'=>'Reaccion adversa a la transfusión', 'suceso_id' => 112]);
                ClasificacionArea::create(['nombre'=>'Error en la administracion de hemoderivados', 'suceso_id' => 112]);
                ClasificacionArea::create(['nombre'=>'No disponibilidad de hemoderivados', 'suceso_id' => 112]);
                ClasificacionArea::create(['nombre'=>'Infecciosa (Presenta signos como salida de material purulento o fiebre)', 'suceso_id' => 134]);
                ClasificacionArea::create(['nombre'=>'Química (relacionada con el paso de medicamentos)', 'suceso_id' => 134]);
                ClasificacionArea::create(['nombre'=>'Mecánica (Relacionada con la inserción o manipulación del catéter)', 'suceso_id' => 134]);
                ClasificacionArea::create(['nombre'=>'Otro', 'suceso_id' => 116]);
                ClasificacionArea::create(['nombre'=>'Complicación quirúrgica', 'suceso_id' => 116]);
                ClasificacionArea::create(['nombre'=>'Lesión intrahospitalaria', 'suceso_id' => 116]);
                ClasificacionArea::create(['nombre'=>'Ingreso no programado a UCI', 'suceso_id' => 116]);
                ClasificacionArea::create(['nombre'=>'Cancelación de procedimiento quirúrgico programado', 'suceso_id' => 116]);
                ClasificacionArea::create(['nombre'=>'Dermatitis asociada a la incontinencia', 'suceso_id' => 147]);
                ClasificacionArea::create(['nombre'=>'MARSI', 'suceso_id' => 147]);
                ClasificacionArea::create(['nombre'=>'Lesión por presión no estadiable', 'suceso_id' => 147]);
                ClasificacionArea::create(['nombre'=>'Lesión por presión categoría lll', 'suceso_id' => 147]);
                ClasificacionArea::create(['nombre'=>'Lesión por presión categoría ll', 'suceso_id' => 147]);
                ClasificacionArea::create(['nombre'=>'Lesión por presión categoría l', 'suceso_id' => 147]);
                ClasificacionArea::create(['nombre'=>'Inadecuada preparación para ayudas diagnósticas', 'suceso_id' => 114]);
                ClasificacionArea::create(['nombre'=>'Inoportunidad en el reporte de ayudas diagnósticas', 'suceso_id' => 114]);
                ClasificacionArea::create(['nombre'=>'Polifarmacia', 'suceso_id' => 109]);
                ClasificacionArea::create(['nombre'=>'No concordancia en informe de ayuda diagnostica o laboratorio', 'suceso_id' => 114]);
                ClasificacionArea::create(['nombre'=>'No concordancia en informe de resultado laboratorio', 'suceso_id' => 113]);
                ClasificacionArea::create(['nombre'=>'Toma de ayuda diagnostica errada', 'suceso_id' => 114]);
                ClasificacionArea::create(['nombre'=>'Informe incompleto', 'suceso_id' => 114]);
                ClasificacionArea::create(['nombre'=>'Traqueítis', 'suceso_id' => 117]);
                ClasificacionArea::create(['nombre'=>'Relacionado con dispositivos médicos', 'suceso_id' => 139]);
                ClasificacionArea::create(['nombre'=>'Relacionado con equipo biomédico', 'suceso_id' => 139]);
                ClasificacionArea::create(['nombre'=>'Muerte', 'suceso_id' => 160]);
                ClasificacionArea::create(['nombre'=>'Pérdida de injerto', 'suceso_id' => 160]);
                ClasificacionArea::create(['nombre'=>'Complicaciones inesperadas (infecciones )', 'suceso_id' => 160]);
                ClasificacionArea::create(['nombre'=>'fallas en el proceso', 'suceso_id' => 160]);
                ClasificacionArea::create(['nombre'=>'Consumo de sustancias psicoactivas intrainstitucionales', 'suceso_id' => 161]);
                ClasificacionArea::create(['nombre'=>'Intento suicida intrainstitucional', 'suceso_id' => 161]);
                ClasificacionArea::create(['nombre'=>'Autolesión o heteroagresión', 'suceso_id' => 161]);
                ClasificacionArea::create(['nombre'=>'Reintervención quirúrgica', 'suceso_id' => 116]);
                ClasificacionArea::create(['nombre'=>'Omisión de dosis', 'suceso_id' => 109]);
                ClasificacionArea::create(['nombre'=>'PROA', 'suceso_id' => 109]);
                ClasificacionArea::create(['nombre'=>'Complicación durante el procedimiento', 'suceso_id' => 114]);

    }
}
