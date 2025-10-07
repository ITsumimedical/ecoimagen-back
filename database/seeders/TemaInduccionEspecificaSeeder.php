<?php

namespace Database\Seeders;

use App\Http\Modules\InduccionesEspecificas\PlantillasInduccionesEspecificas\Models\PlantillaInduccionEspecifica;
use App\Http\Modules\InduccionesEspecificas\TemasInduccionesEspecificas\Models\TemaInduccionEspecifica;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TemaInduccionEspecificaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // CREACIÓN DE PLANTILLA VISTO BUENO POR INDUCCIÓN ESPECÍFICA
        $induccionEspecifica = PlantillaInduccionEspecifica::create([
            'nombre' => 'VISTO BUENO POR INDUCCIÓN ESPECÍFICA',
            'activo' => 1,
        ]);

        // CREACIÓN DE TEMAS RELACIONADO A PLANTILLAS DE VISTO BUENO POR INDUCCIÓN ESPECÍFICA
        TemaInduccionEspecifica::create([
            'nombre' => 'Actividades específicas promoción y prevención, incluyen cumplimiento de metas (si aplica)',
            'plantilla_id' => $induccionEspecifica->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Horarios, turnos, manejo de tiempo de gestión, servicios o procesos que le corresponden dependiendo del cargo',
            'plantilla_id' => $induccionEspecifica->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Criterios de referencia a hospitalización y manejo del anexo 9 a cargos que aplique',
            'plantilla_id' => $induccionEspecifica->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Conductos regulares, solicitudes',
            'plantilla_id' => $induccionEspecifica->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Responsabilidades y limitaciones',
            'plantilla_id' => $induccionEspecifica->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Socialización de caracterización, mapa de riesgos, programas, procedimientos, planes, protocolos, manuales, guías e instructivos dependiendo de cargo o rol que va a ocupar dentro de la organización',
            'plantilla_id' => $induccionEspecifica->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Productos, informes o entregables periódicos requeridos',
            'plantilla_id' => $induccionEspecifica->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Participación en comités, equipos primarios o reuniones que aplique según su cargo',
            'plantilla_id' => $induccionEspecifica->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Actividades, funciones o acciones del cargo o rol',
            'plantilla_id' => $induccionEspecifica->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Resultados esperados o logros o metas del cargo',
            'plantilla_id' => $induccionEspecifica->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Asistencia a inducción general o realización de esta actividad de manera virtual. En caso de ser virtual, debe presentar el certificado obtenido de la plataforma educativa',
            'plantilla_id' => $induccionEspecifica->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Entrenamiento en las actividades a realizar y orientaciones específicas. (Indicar cuantos días tuvo supervisión directa y/o acompañamiento en la realización de sus actividades) ',
            'plantilla_id' => $induccionEspecifica->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Socialización de los ciclos de atención, realizando énfasis dependiendo de cargo o rol que va a ocupar dentro de la organización.',
            'plantilla_id' => $induccionEspecifica->id
        ]);

        // CREACIÓN DE PLANTILLA CHECKLIST DE SISTEMAS
        $checklistSistemas = PlantillaInduccionEspecifica::create([
            'nombre' => 'CHECKLIST DE SISTEMAS',
            'activo' => 1,
        ]);

        // CREACIÓN DE TEMAS RELACIONADO A PLANTILLAS DE CHECKLIST DE SISTEMAS
        TemaInduccionEspecifica::create([
            'nombre' => 'CORREO ELECTRÓNICO',
            'plantilla_id' => $checklistSistemas->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'USO DINÁMICA (según el cargo)',
            'plantilla_id' => $checklistSistemas->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'HORUS',
            'plantilla_id' => $checklistSistemas->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'AULASUMI',
            'plantilla_id' => $checklistSistemas->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'MOMENTOSUMI',
            'plantilla_id' => $checklistSistemas->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'ALMERA',
            'plantilla_id' => $checklistSistemas->id
        ]);

        // CREACIÓN DE PLANTILLA SERVICIO FARMACÉUTICO
        $servicioFarmaceutico = PlantillaInduccionEspecifica::create([
            'nombre' => 'SERVICIO FARMACÉUTICO',
            'activo' => 1,
        ]);

        // CREACIÓN DE TEMAS RELACIONADO A PLANTILLAS DE SERVICIO FARMACÉUTICO
        TemaInduccionEspecifica::create([
            'nombre' => 'Selección de tecnología farmacéutica',
            'plantilla_id' => $servicioFarmaceutico->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Adquisición de tecnología farmacéutica',
            'plantilla_id' => $servicioFarmaceutico->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'PC-SF-028 Procedimiento transporte de medicamentos, dispositivos médicos, reactivos de diagnóstico in vitro e insumos - V3',
            'plantilla_id' => $servicioFarmaceutico->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'PO-SF-003 Política de no reúso - V3',
            'plantilla_id' => $servicioFarmaceutico->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'PC-SF-001 Procedimiento adquisición de medicamentos, dispositivos médicos, reactivos de diagnóstico in vitro e insumos - V4',
            'plantilla_id' => $servicioFarmaceutico->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Dispensación de tecnologías farmacéutica',
            'plantilla_id' => $servicioFarmaceutico->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'PR-SF-001 Programa de farmacovigilancia - V3',
            'plantilla_id' => $servicioFarmaceutico->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'PC-SF-013 Procedimiento de productos no conforme - V3',
            'plantilla_id' => $servicioFarmaceutico->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'PC-SF-012 Control de inventarios y movimientos en los servicios farmacéuticos - V3',
            'plantilla_id' => $servicioFarmaceutico->id
        ]);

        // CREACIÓN DE PLANTILLA INGENIERÍA BIOMÉDICA
        $ingenieriaBiomedica = PlantillaInduccionEspecifica::create([
            'nombre' => 'INGENIERÍA BIOMÉDICA',
            'activo' => 1,
        ]);

        // CREACIÓN DE TEMAS RELACIONADO A PLANTILLAS DE INGENIERÍA BIOMÉDICA
        TemaInduccionEspecifica::create([
            'nombre' => 'Programa de gestión de la tecnología',
            'plantilla_id' => $ingenieriaBiomedica->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Manejo de equipos biomédicos del área',
            'plantilla_id' => $ingenieriaBiomedica->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Plataforma keeper',
            'plantilla_id' => $ingenieriaBiomedica->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'PR-GA-002 Programa de tecnovigilancia - v3',
            'plantilla_id' => $ingenieriaBiomedica->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Cuidado y control de equipos a su cargo',
            'plantilla_id' => $ingenieriaBiomedica->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Proceso para la solicitud de alquiler de equipos',
            'plantilla_id' => $ingenieriaBiomedica->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Recepción, lavado y transporte de equipos de laparoscopia',
            'plantilla_id' => $ingenieriaBiomedica->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Limpieza y desinfección de equipos biomédicos',
            'plantilla_id' => $ingenieriaBiomedica->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Manejo de torre de laparoscopia',
            'plantilla_id' => $ingenieriaBiomedica->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Manejo de equipos de la central esterilización',
            'plantilla_id' => $ingenieriaBiomedica->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'PC-SF-013 procedimiento de productos no conforme - v3',
            'plantilla_id' => $ingenieriaBiomedica->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Procesos establecidos de la central de esterilización',
            'plantilla_id' => $ingenieriaBiomedica->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Plan de contingencia de equipos biomédicos',
            'plantilla_id' => $ingenieriaBiomedica->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Rondas biomédicas y entregas de equipos',
            'plantilla_id' => $ingenieriaBiomedica->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Procedimientos seguros que el colaborador debe poner en práctica en su puesto de trabajo garantizando seguridad para el personal de la central de esterilización en el área de lavado.',
            'plantilla_id' => $ingenieriaBiomedica->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Solicitud y pedido de instrumental a la central de esterilización',
            'plantilla_id' => $ingenieriaBiomedica->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Despacho y entrega de instrumental de los diferentes proveedores',
            'plantilla_id' => $ingenieriaBiomedica->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Verificación de equipos cirugía segura',
            'plantilla_id' => $ingenieriaBiomedica->id
        ]);

        // CREACIÓN DE PLANTILLA HORUS ASISTENCIAL
        $horusAsistencial = PlantillaInduccionEspecifica::create([
            'nombre' => 'HORUS ASISTENCIAL',
            'activo' => 1,
        ]);

        // CREACIÓN DE TEMAS RELACIONADO A PLANTILLAS DE HORUS ASISTENCIAL
        TemaInduccionEspecifica::create([
            'nombre' => 'Conocimiento de la agenda del día a día de cada médico',
            'plantilla_id' => $horusAsistencial->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Exportar consolidado de citas según el rango de fecha',
            'plantilla_id' => $horusAsistencial->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Revisión de la actividad de la agenda medica con sus respectivos rangos y duración',
            'plantilla_id' => $horusAsistencial->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Conocimiento contextual sobre el manejo y creación de las agendas medicas',
            'plantilla_id' => $horusAsistencial->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Realizar reporte de eventos adversos',
            'plantilla_id' => $horusAsistencial->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Consulta de control del plan de manejo de los pacientes',
            'plantilla_id' => $horusAsistencial->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Verificar pendientes y próximas fórmulas de los pacientes',
            'plantilla_id' => $horusAsistencial->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Revisión detallada de nuestro vademécum',
            'plantilla_id' => $horusAsistencial->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Consultar agendamiento diario según su programa',
            'plantilla_id' => $horusAsistencial->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Consulta de la agenda del día actual',
            'plantilla_id' => $horusAsistencial->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Atención de los pacientes de la agenda del día actual',
            'plantilla_id' => $horusAsistencial->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Atención pacientes por consulta no programada',
            'plantilla_id' => $horusAsistencial->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Atención de los pacientes programados en grupales',
            'plantilla_id' => $horusAsistencial->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Atención de los pacientes programados como ingreso o egreso ocupacional',
            'plantilla_id' => $horusAsistencial->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Generar transcripciones del ordenamiento medico',
            'plantilla_id' => $horusAsistencial->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Consultar el histórico tanto de medicamentos, de servicios de historias clínicas y de incapacidades de cada paciente',
            'plantilla_id' => $horusAsistencial->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Realizar solicitudes de necesidades e inconvenientes que se tengan con respecto a un área en especifico',
            'plantilla_id' => $horusAsistencial->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Realizar el cargue de solicitudes de referencia según el anexo',
            'plantilla_id' => $horusAsistencial->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Revisar las solicitudes de referencia según el número de anexo',
            'plantilla_id' => $horusAsistencial->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Realizar el cargue de teleconcepto',
            'plantilla_id' => $horusAsistencial->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Crear esquema de pacientes oncológico',
            'plantilla_id' => $horusAsistencial->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Revisar las solicitudes de autorización de los pacientes oncológicos',
            'plantilla_id' => $horusAsistencial->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Revisar y descargar las historias clínicas de los pacientes que están ingresados al programa de hospitalización domiciliaria',
            'plantilla_id' => $horusAsistencial->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Revisar noticias y datos de interés en la intranet de la empresa',
            'plantilla_id' => $horusAsistencial->id
        ]);

        // CREACIÓN DE PLANTILLA HORUS ADMINISTRATIVO
        $horusAdministrativo = PlantillaInduccionEspecifica::create([
            'nombre' => 'HORUS ADMINISTRATIVO',
            'activo' => 1,
        ]);

        // CREACIÓN DE TEMAS RELACIONADO A PLANTILLAS DE HORUS ADMINISTRATIVO
        TemaInduccionEspecifica::create([
            'nombre' => 'Manejo de plataformas Helpdesk',
            'plantilla_id' => $horusAdministrativo->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Actualización de los datos básicos del paciente',
            'plantilla_id' => $horusAdministrativo->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Realizar reporte de eventos adversos',
            'plantilla_id' => $horusAdministrativo->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Consulta de control del plan de manejo de los pacientes',
            'plantilla_id' => $horusAdministrativo->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Verificar pendientes y próximas fórmulas de los pacientes',
            'plantilla_id' => $horusAdministrativo->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Generar transcripciones del ordenamiento medico',
            'plantilla_id' => $horusAdministrativo->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Consultar el histórico tanto de medicamentos, de servicios de historias clínicas y de incapacidades de cada paciente',
            'plantilla_id' => $horusAdministrativo->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Realizar solicitudes de necesidades e inconvenientes que se tengan con respecto a un área en especifico',
            'plantilla_id' => $horusAdministrativo->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Generar el cargue de las peticiones, quejas, reclamos, solicitudes, felicitaciones (PQRSF)',
            'plantilla_id' => $horusAdministrativo->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Revisar noticias y datos de interés en la intranet de la empresa',
            'plantilla_id' => $horusAdministrativo->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Descargar certificado laboral y retención de ingresos ante la DIAN',
            'plantilla_id' => $horusAdministrativo->id
        ]);

        // CREACIÓN DE PLANTILLA DINÁMICA ADMINISTRATIVA
        $dinamicaAdministrativa = PlantillaInduccionEspecifica::create([
            'nombre' => 'DINÁMICA ADMINISTRATIVA',
            'activo' => 1,
        ]);

        // CREACIÓN DE TEMAS RELACIONADO A PLANTILLAS DE DINÁMICA ADMINISTRATIVA
        TemaInduccionEspecifica::create([
            'nombre' => 'Realizar el cambio del estado de las camas según su necesidad',
            'plantilla_id' => $dinamicaAdministrativa->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Revisar la estancia del paciente según su ingreso',
            'plantilla_id' => $dinamicaAdministrativa->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Revisar el mapa de camas actualizado de los pacientes',
            'plantilla_id' => $dinamicaAdministrativa->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Revisar y descargar el censo diario de camas ocupadas',
            'plantilla_id' => $dinamicaAdministrativa->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Revisar los indicadores de gestión',
            'plantilla_id' => $dinamicaAdministrativa->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Realizar la activación de las camas colocadas por mantenimiento (Aseo)',
            'plantilla_id' => $dinamicaAdministrativa->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Crear, registrar y confirmar las solicitudes de traslado sean a un almacén o para consumo de enfermería',
            'plantilla_id' => $dinamicaAdministrativa->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Generar y descargar los diferentes tipos de informe e indicadores que ayudan a mantener los inventarios y la producción al día',
            'plantilla_id' => $dinamicaAdministrativa->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Confirmar al laboratorio cada orden de servicios que se le genera',
            'plantilla_id' => $dinamicaAdministrativa->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Consultar el historial de consultas, valoraciones y el ordenamiento de los pacientes en su paso por la clínica',
            'plantilla_id' => $dinamicaAdministrativa->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Crear y descargar reportes e indicadores que ayuden a tener conocimientos del comportamiento de los pacientes en su estancia',
            'plantilla_id' => $dinamicaAdministrativa->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Crear, modificar y organizar la programación de cirugías',
            'plantilla_id' => $dinamicaAdministrativa->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Crear cirugías en espera en caso de ser requerido',
            'plantilla_id' => $dinamicaAdministrativa->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Registrar la canasta de productos de los procedimientos programados en cirugía',
            'plantilla_id' => $dinamicaAdministrativa->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Revisar el listado de cirugías por fecha y estado',
            'plantilla_id' => $dinamicaAdministrativa->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Crear y descargar reportes e indicadores que nos ayuden a tener información del estado y uso de los quirófanos y cirugías',
            'plantilla_id' => $dinamicaAdministrativa->id
        ]);

        // CREACIÓN DE PLANTILLA DINÁMICA ASISTENCIAL
        $dinamicaAdsistencial = PlantillaInduccionEspecifica::create([
            'nombre' => 'DINÁMICA ASISTENCIAL',
            'activo' => 1,
        ]);

        // CREACIÓN DE TEMAS RELACIONADO A PLANTILLAS DE DINÁMICA ASISTENCIAL
        TemaInduccionEspecifica::create([
            'nombre' => 'Crear, registrar y confirmar las devoluciones de los productos de los pacientes solicitados por enfermería',
            'plantilla_id' => $dinamicaAdsistencial->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Dispensar y confirmar las solicitudes de los productos ordenados a los pacientes, tanto en enfermería como en personal medico',
            'plantilla_id' => $dinamicaAdsistencial->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Realizar los diferentes tipos de historia para los ingresos, evoluciones y ordenamientos de los pacientes',
            'plantilla_id' => $dinamicaAdsistencial->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Crear las ordenes de hospitalización, traslado a los pacientes según su necesidad',
            'plantilla_id' => $dinamicaAdsistencial->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Crear las autorizaciones de intervenciones según el procedimiento a realizar al paciente',
            'plantilla_id' => $dinamicaAdsistencial->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Generar transcripción de las incapacidades medicas a los pacientes según su necesidad',
            'plantilla_id' => $dinamicaAdsistencial->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Revisar y responder a las solicitudes de los procedimientos ordenados a los pacientes',
            'plantilla_id' => $dinamicaAdsistencial->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Consultar y completar la información de las epicrisis de los pacientes egresados',
            'plantilla_id' => $dinamicaAdsistencial->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Realizar el registro de enfermería con sus respectivas notas, aplicación de medicamentos y suministros, solicitud y devolución de suministros y hacer el cargue de los datos y valoraciones realizadas al paciente',
            'plantilla_id' => $dinamicaAdsistencial->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Revisar y responder las interconsultas que se tengan pendientes según las solicitudes de los pacientes',
            'plantilla_id' => $dinamicaAdsistencial->id
        ]);

        TemaInduccionEspecifica::create([
            'nombre' => 'Generar las solicitudes de referencia de los pacientes con solicitud de ingreso a la institución. ',
            'plantilla_id' => $dinamicaAdsistencial->id
        ]);

    }
}
