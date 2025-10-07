<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Http\Modules\EvaluacionDesempeño\th_pilares\Models\ThPilar;
use App\Http\Modules\EvaluacionDesempeño\th_competencias\Models\ThCompetencia;
use App\Http\Modules\EvaluacionDesempeño\th_tipo_plantillas\Models\ThTipoPlantilla;

class TipoPlantillaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $nivel_directivo = ThTipoPlantilla::create([
            'nombre' => 'nivel directivo',
            'esta_activo' => 1,
        ]);
        // CREACION DE PILARES ASOCIADAS A TIPO PLANTILLA NIVEL DIRECTIVO

            $atencion_centrada_nivel_directivo = ThPilar::create([
                'nombre' => 'Atención centrada en la persona',
                'porcentaje' => 8,
                'orden' => 1,
                'esta_activo' => 1,
                'th_tipo_plantilla_id' => $nivel_directivo->id
            ]);

            $orientacion_resultados_nivel_directivo = ThPilar::create([
                'nombre' => 'Orientación a resultados',
                'porcentaje' => 8,
                'orden' => 1,
                'esta_activo' => 1,
                'th_tipo_plantilla_id' => $nivel_directivo->id
            ]);

            $trabajo_equipo_nivel_directivo = ThPilar::create([
                'nombre' => 'Trabajo en equipo',
                'porcentaje' => 8,
                'orden' => 1,
                'esta_activo' => 1,
                'th_tipo_plantilla_id' => $nivel_directivo->id
            ]);

            $adaptabilidad_cambio_nivel_directivo = ThPilar::create([
                'nombre' => 'Adaptabilidad al cambio',
                'porcentaje' => 8,
                'orden' => 1,
                'esta_activo' => 1,
                'th_tipo_plantilla_id' => $nivel_directivo->id
            ]);

            $funciones_especificas_nivel_directivo = ThPilar::create([
                'nombre' => 'funciones especificas',
                'porcentaje' => 8,
                'orden' => 1,
                'esta_activo' => 1,
                'th_tipo_plantilla_id' => $nivel_directivo->id
            ]);

            $liderazgo_efectivo_nivel_directivo = ThPilar::create([
                'nombre' => 'Liderazgo efectivo',
                'porcentaje' => 15,
                'orden' => 1,
                'esta_activo' => 1,
                'th_tipo_plantilla_id' => $nivel_directivo->id
            ]);

            $organizacion_planeacion_control_nivel_directivo = ThPilar::create([
                'nombre' => 'Organización, planeación y control',
                'porcentaje' => 15,
                'orden' => 1,
                'esta_activo' => 1,
                'th_tipo_plantilla_id' => $nivel_directivo->id
            ]);

            $toma_decisiones_nivel_directivo = ThPilar::create([
                'nombre' => 'Toma de decisiones',
                'porcentaje' => 15,
                'orden' => 1,
                'esta_activo' => 1,
                'th_tipo_plantilla_id' => $nivel_directivo->id
            ]);

            $pensamiento_sistematico_nivel_directivo = ThPilar::create([
                'nombre' => 'Pensamiento sistémico',
                'porcentaje' => 15,
                'orden' => 1,
                'esta_activo' => 1,
                'th_tipo_plantilla_id' => $nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Valora y atiende las necesidades y peticiones de los usuarios de forma oportuna',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Dirigir las decisiones y acciones a la satisfacción de las necesidades e intereses de los usuarios (internos y externos)',
                'th_pilar_id' => $atencion_centrada_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Reconoce la interdependencia entre su trabajo y el de otros',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Dirigir las decisiones y acciones a la satisfacción de las necesidades e intereses de los usuarios (internos y externos)',
                'th_pilar_id' => $atencion_centrada_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Establece mecanismos para conocer las necesidades e inquietudes de los usuarios',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Dirigir las decisiones y acciones a la satisfacción de las necesidades e intereses de los usuarios (internos y externos)',
                'th_pilar_id' => $atencion_centrada_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Incorpora las necesidades de los usuarios en los proyectos institucionales, con base en criterios de Excelencia y alta calidad, teniendo en cuenta la visión de servicio a corto, mediano y largo plazo',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Dirigir las decisiones y acciones a la satisfacción de las necesidades e intereses de los usuarios (internos y externos)',
                'th_pilar_id' => $atencion_centrada_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Aplica los conceptos de "no estigmatización" y "no discriminación" y genera espacios y lenguaje incluyente',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Dirigir las decisiones y acciones a la satisfacción de las necesidades e intereses de los usuarios (internos y externos)',
                'th_pilar_id' => $atencion_centrada_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Escucha activamente e informa con veracidad al usuario interno y externo',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Dirigir las decisiones y acciones a la satisfacción de las necesidades e intereses de los usuarios (internos y externos)',
                'th_pilar_id' => $atencion_centrada_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Genera un trato empático, respetuoso, equitativo e incluyente con el usuario interno y externo',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Dirigir las decisiones y acciones a la satisfacción de las necesidades e intereses de los usuarios (internos y externos)',
                'th_pilar_id' => $atencion_centrada_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Utiliza un lenguaje claro, incluyente para dar a conocer instrucciones sobre el estado de salud, procesos o cualquier actividad relacionada con él',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Dirigir las decisiones y acciones a la satisfacción de las necesidades e intereses de los usuarios (internos y externos)',
                'th_pilar_id' => $atencion_centrada_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Asume la responsabilidad por sus resultados, con base en el pensamiento crítico, utilizando herramientas ofimáticas avanzadas',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Realizar las funciones y cumplir los compromisos organizacionales con eficacia, calidad y oportunidad.',
                'th_pilar_id' => $orientacion_resultados_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Trabaja con base en objetivos claramente establecidos y realistas',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Realizar las funciones y cumplir los compromisos organizacionales con eficacia, calidad y oportunidad.',
                'th_pilar_id' => $orientacion_resultados_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Diseña y utiliza indicadores para medir y comprobar los resultados obtenidos',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Realizar las funciones y cumplir los compromisos organizacionales con eficacia, calidad y oportunidad.',
                'th_pilar_id' => $orientacion_resultados_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Planea las actividades del área para la gestión integral',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Realizar las funciones y cumplir los compromisos organizacionales con eficacia, calidad y oportunidad.',
                'th_pilar_id' => $orientacion_resultados_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Adopta medidas para minimizar riesgos',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Realizar las funciones y cumplir los compromisos organizacionales con eficacia, calidad y oportunidad.',
                'th_pilar_id' => $orientacion_resultados_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Plantea estrategias para alcanzar o superar los resultados esperados',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Realizar las funciones y cumplir los compromisos organizacionales con eficacia, calidad y oportunidad.',
                'th_pilar_id' => $orientacion_resultados_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Se fija metas y obtiene los resultados institucionales esperados',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Realizar las funciones y cumplir los compromisos organizacionales con eficacia, calidad y oportunidad.',
                'th_pilar_id' => $orientacion_resultados_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Cumple con oportunidad las funciones de acuerdo con los estándares, objetivos y tiempos establecidos por la empresa',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Realizar las funciones y cumplir los compromisos organizacionales con eficacia, calidad y oportunidad.',
                'th_pilar_id' => $orientacion_resultados_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Gestiona recursos para mejorar la productividad y toma medidas necesarias para minimizar los riesgos',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Realizar las funciones y cumplir los compromisos organizacionales con eficacia, calidad y oportunidad.',
                'th_pilar_id' => $orientacion_resultados_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Gestiona el cambio y desarrollo de la organización, asegurando la competitividad y efectividad a un largo plazo',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Realizar las funciones y cumplir los compromisos organizacionales con eficacia, calidad y oportunidad.',
                'th_pilar_id' => $orientacion_resultados_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Evalúa de forma regular el grado de consecución de los objetivos y realiza informes de gestión',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Realizar las funciones y cumplir los compromisos organizacionales con eficacia, calidad y oportunidad.',
                'th_pilar_id' => $orientacion_resultados_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Cumple los compromisos que+E39:H51 adquiere con el equipo',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Trabajar con otros de forma integrada, colaborativa y armónica para la consecución de metas organizacionales comunes.',
                'th_pilar_id' => $trabajo_equipo_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Respeta la diversidad de criterios y opiniones de los miembros del equipo',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Trabajar con otros de forma integrada, colaborativa y armónica para la consecución de metas organizacionales comunes.',
                'th_pilar_id' => $trabajo_equipo_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Asume su responsabilidad como miembro de un equipo de trabajo y se enfoca en contribuir con el compromiso y la motivación de sus miembros',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Trabajar con otros de forma integrada, colaborativa y armónica para la consecución de metas organizacionales comunes.',
                'th_pilar_id' => $trabajo_equipo_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Planifica las propias acciones teniendo en cuenta su repercusión en la consecución de los objetivos grupales y el trabajo colaborativo',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Trabajar con otros de forma integrada, colaborativa y armónica para la consecución de metas organizacionales comunes.',
                'th_pilar_id' => $trabajo_equipo_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Establece una comunicación directa con los miembros del equipo que permite compartir información e ideas en condiciones de respeto y cordialidad',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Trabajar con otros de forma integrada, colaborativa y armónica para la consecución de metas organizacionales comunes.',
                'th_pilar_id' => $trabajo_equipo_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Integra a los nuevos miembros y facilita su proceso de reconocimiento y apropiación de las actividades a cargo del equipo',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Trabajar con otros de forma integrada, colaborativa y armónica para la consecución de metas organizacionales comunes.',
                'th_pilar_id' => $trabajo_equipo_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Realiza acompañamiento a los nuevos miembros del equipo',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Trabajar con otros de forma integrada, colaborativa y armónica para la consecución de metas organizacionales comunes.',
                'th_pilar_id' => $trabajo_equipo_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Prepara y promueve la capacitación de los equipos de la organización',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Trabajar con otros de forma integrada, colaborativa y armónica para la consecución de metas organizacionales comunes.',
                'th_pilar_id' => $trabajo_equipo_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Acepta y se adapta fácilmente a las nuevas situaciones',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Enfrentar con flexibilidad las situaciones nuevas asumiendo un manejo positivo y constructivo de los cambios',
                'th_pilar_id' => $adaptabilidad_cambio_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Responde al cambio con flexibilidad y dinamismo',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Enfrentar con flexibilidad las situaciones nuevas asumiendo un manejo positivo y constructivo de los cambios.',
                'th_pilar_id' => $adaptabilidad_cambio_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Apoya a la empresa en nuevas decisiones y coopera activamente en la implementación de nuevos objetivos, formas de trabajo y procedimientos',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Enfrentar con flexibilidad las situaciones nuevas asumiendo un manejo positivo y constructivo de los cambios.',
                'th_pilar_id' => $adaptabilidad_cambio_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Implementa cambios innovadores en los procesos, para la obtención de resultados estratégicos',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Enfrentar con flexibilidad las situaciones nuevas asumiendo un manejo positivo y constructivo de los cambios.',
                'th_pilar_id' => $adaptabilidad_cambio_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Promueve al grupo para que se adapten a las nuevas condiciones',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Enfrentar con flexibilidad las situaciones nuevas asumiendo un manejo positivo y constructivo de los cambios.',
                'th_pilar_id' => $adaptabilidad_cambio_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => '1. Cumple de manera eficiente con las funciones generales  (Ejemplo, presentación personal, puntualidad, uso adecuado de claves de acceso, respuesta oportuna de correos electrónico, cuidado de la  dotación, respuesta oportuna  a las PQRS, entre otros ). Que se encuentran en  el Manual de Funciones',
                'descripcion' => '',
                'th_pilar_id' => $funciones_especificas_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => '2. Cumple de manera eficiente con las funciones estratégicas y tácticas del cargo (Ejemplo, hace uso adecuado de las herramientas de trabajo software, cumple metas, entrega informes en los tiempos estipulados y demás funciones específicas del cargo ). Que se encuentran en  el Manual de Funciones',
                'descripcion' => '',
                'th_pilar_id' => $funciones_especificas_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => '3. El evaluado identifica su aporte en el cumplimiento de la misión, visión y objetivos estratégicos de la institución',
                'descripcion' => '',
                'th_pilar_id' => $funciones_especificas_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => '4. El evaluado introyecta y pone en práctica la propuesta de valor, los principios y valores de la institución',
                'descripcion' => '',
                'th_pilar_id' => $funciones_especificas_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Traduce la visión y logra que cada miembro del equipo se comprometa y aporte, en un entorno participativo y de toma de decisiones, en el corto y mediano plazo',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Gerenciar equipos, optimizando la aplicación del talento disponible y creando un entorno positivo y de compromiso para el logro de los resultados.',
                'th_pilar_id' => $liderazgo_efectivo_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Forma equipos y les delega responsabilidades y tareas en función de las competencias, el potencial y los intereses, habilidades de los miembros del equipo',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Gerenciar equipos, optimizando la aplicación del talento disponible y creando un entorno positivo y de compromiso para el logro de los resultados.',
                'th_pilar_id' => $liderazgo_efectivo_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Crea compromiso y moviliza a los miembros de su equipo a gestionar, aceptar retos, desafíos y directrices, superando intereses personales para alcanzar las metas propuestas en torno a los objetivos estratégicos',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Gerenciar equipos, optimizando la aplicación del talento disponible y creando un entorno positivo y de compromiso para el logro de los resultados.',
                'th_pilar_id' => $liderazgo_efectivo_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Brinda apoyo y motiva a su equipo en momentos de adversidad, a la vez que comparte las mejores prácticas y celebra el éxito con su gente, incidiendo positivamente en la calidad de vida laboral',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Gerenciar equipos, optimizando la aplicación del talento disponible y creando un entorno positivo y de compromiso para el logro de los resultados.',
                'th_pilar_id' => $liderazgo_efectivo_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Propicia, favorece y acompaña las condiciones para generar y mantener un clima laboral positivo en un entorno de inclusión y la equidad',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Gerenciar equipos, optimizando la aplicación del talento disponible y creando un entorno positivo y de compromiso para el logro de los resultados.',
                'th_pilar_id' => $liderazgo_efectivo_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Fomenta la comunicación clara, efectiva y asertiva, en un entorno de respeto',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Gerenciar equipos, optimizando la aplicación del talento disponible y creando un entorno positivo y de compromiso para el logro de los resultados.',
                'th_pilar_id' => $liderazgo_efectivo_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Prevé situaciones y escenarios futuros',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Determinar eficazmente las metas y prioridades organizacionales, identificando las acciones, los responsables, los plazos y los recursos requeridos para alcanzarlas.',
                'th_pilar_id' => $organizacion_planeacion_control_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Establece los planes de acción necesarios para el desarrollo de los objetivos estratégicos, teniendo en cuenta actividades, responsables, plazos y recursos requeridos; promoviendo altos estándares de desempeño',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Determinar eficazmente las metas y prioridades organizacionales, identificando las acciones, los responsables, los plazos y los recursos requeridos para alcanzarlas.',
                'th_pilar_id' => $organizacion_planeacion_control_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Hace seguimiento a la planeación organizacional, con base en los indicadores y metas planeadas, verificando que se realicen los ajustes, retroalimentando el proceso y verificando los planes de acción y operativos',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Determinar eficazmente las metas y prioridades organizacionales, identificando las acciones, los responsables, los plazos y los recursos requeridos para alcanzarlas.',
                'th_pilar_id' => $organizacion_planeacion_control_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Orienta la planeación organizacional con una visión estratégica',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Determinar eficazmente las metas y prioridades organizacionales, identificando las acciones, los responsables, los plazos y los recursos requeridos para alcanzarlas.',
                'th_pilar_id' => $organizacion_planeacion_control_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Optimiza el uso de los recursos',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Determinar eficazmente las metas y prioridades organizacionales, identificando las acciones, los responsables, los plazos y los recursos requeridos para alcanzarlas.',
                'th_pilar_id' => $organizacion_planeacion_control_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Concreta oportunidades que generan valor a corto, mediano y largo plazo',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Determinar eficazmente las metas y prioridades organizacionales, identificando las acciones, los responsables, los plazos y los recursos requeridos para alcanzarlas.',
                'th_pilar_id' => $organizacion_planeacion_control_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Revisa e identifica riesgos y controles establecidos en el proceso, promueve acciones preventivas y correctivas pertinentes',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Determinar eficazmente las metas y prioridades organizacionales, identificando las acciones, los responsables, los plazos y los recursos requeridos para alcanzarlas.',
                'th_pilar_id' => $organizacion_planeacion_control_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Elige con oportunidad, entre las alternativas disponibles, los proyectos a realizar, estableciendo responsabilidades precisas con base en las prioridades de la empresa',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Elegir entre dos o más alternativas para solucionar un problema o atender una situación, comprometiéndose con acciones concretas y consecuentes con la decisión.',
                'th_pilar_id' => $toma_decisiones_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Realiza análisis de datos del entorno nacional y mundial, para la toma de decisiones y para proponer proyectos',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Elegir entre dos o más alternativas para solucionar un problema o atender una situación, comprometiéndose con acciones concretas y consecuentes con la decisión.',
                'th_pilar_id' => $toma_decisiones_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Toma en cuenta la opinión técnica de los miembros de su equipo al analizar las alternativas existentes para tomar una decisión y desarrollarla',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Elegir entre dos o más alternativas para solucionar un problema o atender una situación, comprometiéndose con acciones concretas y consecuentes con la decisión.',
                'th_pilar_id' => $toma_decisiones_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Decide en situaciones de alta complejidad e incertidumbre organizacional, teniendo en consideración la consecución de logros y objetivos de la entidad',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Elegir entre dos o más alternativas para solucionar un problema o atender una situación, comprometiéndose con acciones concretas y consecuentes con la decisión.',
                'th_pilar_id' => $toma_decisiones_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Efectúa los cambios que considera necesarios para solucionar las dificultades detectadas o atender situaciones particulares y se hace responsable de la decisión tomada',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Elegir entre dos o más alternativas para solucionar un problema o atender una situación, comprometiéndose con acciones concretas y consecuentes con la decisión.',
                'th_pilar_id' => $toma_decisiones_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Detecta amenazas y oportunidades frente a posibles decisiones y elige de forma pertinente',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Elegir entre dos o más alternativas para solucionar un problema o atender una situación, comprometiéndose con acciones concretas y consecuentes con la decisión.',
                'th_pilar_id' => $toma_decisiones_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Asume los riesgos de las decisiones tomadas',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Elegir entre dos o más alternativas para solucionar un problema o atender una situación, comprometiéndose con acciones concretas y consecuentes con la decisión.',
                'th_pilar_id' => $toma_decisiones_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Integra varias áreas de conocimiento para interpretar las interacciones del entorno. Realiza análisis de las situaciones con metodologías científicas',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Comprender y afrontar la realidad y sus conexiones para abordar el funcionamiento integral y articulado de la organización e incidir en los resultados esperados.',
                'th_pilar_id' => $pensamiento_sistematico_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Comprende y gestiona las interrelaciones entre las causas y los efectos, árbol de problemas, entre otros; dentro de los diferentes procesos en los que participa',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Comprender y afrontar la realidad y sus conexiones para abordar el funcionamiento integral y articulado de la organización e incidir en los resultados esperados.',
                'th_pilar_id' => $pensamiento_sistematico_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Identifica la dinámica de los sistemas en los que se ve inmerso y sus conexiones para afrontar los retos del entorno',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Comprender y afrontar la realidad y sus conexiones para abordar el funcionamiento integral y articulado de la organización e incidir en los resultados esperados.',
                'th_pilar_id' => $pensamiento_sistematico_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Participa activamente en el equipo considerando su complejidad e interdependencia para impactar en los resultados esperados',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Comprender y afrontar la realidad y sus conexiones para abordar el funcionamiento integral y articulado de la organización e incidir en los resultados esperados.',
                'th_pilar_id' => $pensamiento_sistematico_nivel_directivo->id
            ]);
            $competencia = ThCompetencia::create([
                'competencia' => 'Influye positivamente al equipo desde una perspectiva sistémica, generando una dinámica propia que integre diversos enfoques para interpretar el entorno',
                'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Comprender y afrontar la realidad y sus conexiones para abordar el funcionamiento integral y articulado de la organización e incidir en los resultados esperados.',
                'th_pilar_id' => $pensamiento_sistematico_nivel_directivo->id
            ]);


         // CREACION DE PILARES ASOCIADAS A TIPO PLANTILLA NIVEL TACTICO CON PERSONAL A CARGO

        $nivel_tactico_personal_cargo =  ThTipoPlantilla::create([
            'nombre' => 'nivel táctico con perso a cargo',
            'esta_activo' => 1,
        ]);

         $pilar_atencion_centrada_con_persona_acargo = ThPilar::create([
            'nombre' => 'Atención centrada en la persona',
            'porcentaje' => 8,
            'orden' => 2,
            'esta_activo' => 1,
            'th_tipo_plantilla_id' => $nivel_tactico_personal_cargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Valora y atiende las necesidades y peticiones de los usuarios de forma oportuna',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Dirigir las decisiones y acciones a la satisfacción de las necesidades e intereses de los usuarios (internos y externos)',
            'th_pilar_id' => $pilar_atencion_centrada_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Reconoce la interdependencia entre su trabajo y el de otros',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Dirigir las decisiones y acciones a la satisfacción de las necesidades e intereses de los usuarios (internos y externos)',
            'th_pilar_id' => $pilar_atencion_centrada_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Establece mecanismos para conocer las necesidades e inquietudes de los usuarios',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Dirigir las decisiones y acciones a la satisfacción de las necesidades e intereses de los usuarios (internos y externos)',
            'th_pilar_id' => $pilar_atencion_centrada_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Incorpora las necesidades de los usuarios en los proyectos institucionales, con base en criterios de Excelencia y alta calidad, teniendo en cuenta la visión de servicio a corto, mediano y largo plazo',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Dirigir las decisiones y acciones a la satisfacción de las necesidades e intereses de los usuarios (internos y externos)',
            'th_pilar_id' => $pilar_atencion_centrada_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Aplica los conceptos de "no estigmatización" y "no discriminación" y genera espacios y lenguaje incluyente',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Dirigir las decisiones y acciones a la satisfacción de las necesidades e intereses de los usuarios (internos y externos)',
            'th_pilar_id' => $pilar_atencion_centrada_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Escucha activamente e informa con veracidad al usuario interno y externo',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Dirigir las decisiones y acciones a la satisfacción de las necesidades e intereses de los usuarios (internos y externos)',
            'th_pilar_id' => $pilar_atencion_centrada_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Genera un trato empático, respetuoso, equitativo e incluyente con el usuario interno y externo',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Dirigir las decisiones y acciones a la satisfacción de las necesidades e intereses de los usuarios (internos y externos)',
            'th_pilar_id' => $pilar_atencion_centrada_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Utiliza un lenguaje claro, incluyente para dar a conocer instrucciones sobre el estado de salud, procesos o cualquier actividad relacionada con él',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Dirigir las decisiones y acciones a la satisfacción de las necesidades e intereses de los usuarios (internos y externos)',
            'th_pilar_id' => $pilar_atencion_centrada_con_persona_acargo->id
        ]);


        $orientacion_resultado_con_persona_acargo = ThPilar::create([
            'nombre' => 'Orientación a resultados',
            'porcentaje' => 8,
            'orden' => 3,
            'esta_activo' => 1,
            'th_tipo_plantilla_id' => $nivel_tactico_personal_cargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Asume la responsabilidad por sus resultados, con base en el pensamiento crítico, utilizando herramientas ofimáticas avanzadas',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Realizar las funciones y cumplir los compromisos organizacionales con eficacia, calidad y oportunidad',
            'th_pilar_id' => $orientacion_resultado_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Trabaja con base en objetivos claramente establecidos y realistas',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Realizar las funciones y cumplir los compromisos organizacionales con eficacia, calidad y oportunidad',
            'th_pilar_id' => $orientacion_resultado_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Diseña y utiliza indicadores para medir y comprobar los resultados obtenidos',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Realizar las funciones y cumplir los compromisos organizacionales con eficacia, calidad y oportunidad',
            'th_pilar_id' => $orientacion_resultado_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Planea las actividades del área para la gestión integral',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Realizar las funciones y cumplir los compromisos organizacionales con eficacia, calidad y oportunidad',
            'th_pilar_id' => $orientacion_resultado_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Adopta medidas para minimizar riesgos',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Realizar las funciones y cumplir los compromisos organizacionales con eficacia, calidad y oportunidad',
            'th_pilar_id' => $orientacion_resultado_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Plantea estrategias para alcanzar o superar los resultados esperados',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Realizar las funciones y cumplir los compromisos organizacionales con eficacia, calidad y oportunidad',
            'th_pilar_id' => $orientacion_resultado_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Se fija metas y obtiene los resultados institucionales esperados',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Realizar las funciones y cumplir los compromisos organizacionales con eficacia, calidad y oportunidad',
            'th_pilar_id' => $orientacion_resultado_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Cumple con oportunidad las funciones de acuerdo con los estándares, objetivos y tiempos establecidos por la empresa',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Realizar las funciones y cumplir los compromisos organizacionales con eficacia, calidad y oportunidad',
            'th_pilar_id' => $orientacion_resultado_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Gestiona recursos para mejorar la productividad y toma medidas necesarias para minimizar los riesgos',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Realizar las funciones y cumplir los compromisos organizacionales con eficacia, calidad y oportunidad',
            'th_pilar_id' => $orientacion_resultado_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Gestiona el cambio y desarrollo de la organización, asegurando la competitividad y efectividad a un largo plazo',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Realizar las funciones y cumplir los compromisos organizacionales con eficacia, calidad y oportunidad',
            'th_pilar_id' => $orientacion_resultado_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Evalúa de forma regular el grado de consecución de los objetivos y realiza informes de gestión',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Realizar las funciones y cumplir los compromisos organizacionales con eficacia, calidad y oportunidad',
            'th_pilar_id' => $orientacion_resultado_con_persona_acargo->id
        ]);

        $trabajo_equipo_con_persona_acargo = ThPilar::create([
            'nombre' => 'Trabajo en equipo',
            'porcentaje' => 8,
            'orden' => 4,
            'esta_activo' => 1,
            'th_tipo_plantilla_id' => $nivel_tactico_personal_cargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Cumple los compromisos que adquiere con el equipo',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Trabajar con otros de forma integrada, colaborativa y armónica para la consecución de metas organizacionales comunes',
            'th_pilar_id' => $trabajo_equipo_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Respeta la diversidad de criterios y opiniones de los miembros del equipo',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Trabajar con otros de forma integrada, colaborativa y armónica para la consecución de metas organizacionales comunes',
            'th_pilar_id' => $trabajo_equipo_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Asume su responsabilidad como miembro de un equipo de trabajo y se enfoca en contribuir con el compromiso y la motivación de sus miembros',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Trabajar con otros de forma integrada, colaborativa y armónica para la consecución de metas organizacionales comunes',
            'th_pilar_id' => $trabajo_equipo_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Planifica las propias acciones teniendo en cuenta su repercusión en la consecución de los objetivos grupales y el trabajo colaborativo',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Trabajar con otros de forma integrada, colaborativa y armónica para la consecución de metas organizacionales comunes',
            'th_pilar_id' => $trabajo_equipo_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Establece una comunicación directa con los miembros del equipo que permite compartir información e ideas en condiciones de respeto y cordialidad',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Trabajar con otros de forma integrada, colaborativa y armónica para la consecución de metas organizacionales comunes',
            'th_pilar_id' => $trabajo_equipo_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Integra a los nuevos miembros y facilita su proceso de reconocimiento y apropiación de las actividades a cargo del equipo',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Trabajar con otros de forma integrada, colaborativa y armónica para la consecución de metas organizacionales comunes',
            'th_pilar_id' => $trabajo_equipo_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Realiza acompañamiento a los nuevos miembros del equipo',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Trabajar con otros de forma integrada, colaborativa y armónica para la consecución de metas organizacionales comunes',
            'th_pilar_id' => $trabajo_equipo_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Prepara y promueve la capacitación de los equipos de la organización',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Trabajar con otros de forma integrada, colaborativa y armónica para la consecución de metas organizacionales comunes',
            'th_pilar_id' => $trabajo_equipo_con_persona_acargo->id
        ]);

        $adaptabilidad_cambio_con_persona_acargo = ThPilar::create([
            'nombre' => 'Adaptabilidad al cambio',
            'porcentaje' => 8,
            'orden' => 5,
            'esta_activo' => 1,
            'th_tipo_plantilla_id' => $nivel_tactico_personal_cargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Acepta y se adapta fácilmente a las nuevas situaciones',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Enfrentar con flexibilidad las situaciones nuevas asumiendo un manejo positivo y constructivo de los cambios',
            'th_pilar_id' => $adaptabilidad_cambio_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Responde al cambio con flexibilidad y dinamismo',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Enfrentar con flexibilidad las situaciones nuevas asumiendo un manejo positivo y constructivo de los cambios',
            'th_pilar_id' => $adaptabilidad_cambio_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Apoya a la empresa en nuevas decisiones y coopera activamente en la implementación de nuevos objetivos, formas de trabajo y procedimientos',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Enfrentar con flexibilidad las situaciones nuevas asumiendo un manejo positivo y constructivo de los cambios',
            'th_pilar_id' => $adaptabilidad_cambio_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Implementa cambios innovadores en los procesos, para la obtención de resultados estratégicos',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Enfrentar con flexibilidad las situaciones nuevas asumiendo un manejo positivo y constructivo de los cambios',
            'th_pilar_id' => $adaptabilidad_cambio_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Promueve al grupo para que se adapten a las nuevas condiciones',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Enfrentar con flexibilidad las situaciones nuevas asumiendo un manejo positivo y constructivo de los cambios',
            'th_pilar_id' => $adaptabilidad_cambio_con_persona_acargo->id
        ]);

        $funciones_desempeño_con_persona_acargo = ThPilar::create([
            'nombre' => 'Funciones de desempeño específicas',
            'porcentaje' => 8,
            'orden' => 6,
            'esta_activo' => 1,
            'th_tipo_plantilla_id' => $nivel_tactico_personal_cargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => '1. Cumple de manera eficiente con las funciones generales  (Ejemplo, presentación personal, puntualidad, uso adecuado de claves de acceso, respuesta oportuna de correos electrónico, cuidado de la  dotación, respuesta oportuna  a las PQRS, entre otros ). Que se encuentran en  el Manual de Funciones',
            'descripcion' => 'Sin definición',
            'th_pilar_id' => $funciones_desempeño_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
        'competencia' => '2. Cumple de manera eficiente con las funciones estratégicas y tácticas del cargo (Ejemplo, hace uso adecuado de las herramientas de trabajo software, cumple metas, entrega informes en los tiempos estipulados y demás funciones específicas del cargo ). Que se encuentran en  el Manual de Funciones',
            'descripcion' => 'Sin definición',
            'th_pilar_id' => $funciones_desempeño_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
        'competencia' => '3. El evaluado identifica su aporte en el cumplimiento de la misión, visión y objetivos estratégicos de la institución',
            'descripcion' => 'Sin definición',
            'th_pilar_id' => $funciones_desempeño_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => '4. El evaluado introyecta y pone en práctica la propuesta de valor, los principios y valores de la institución',
            'descripcion' => 'Sin definición',
            'th_pilar_id' => $funciones_desempeño_con_persona_acargo->id
        ]);

        $comunicacion_efectiva_con_persona_acargo = ThPilar::create([
            'nombre' => 'Comunicación efectiva',
            'porcentaje' => 15,
            'orden' => 7,
            'esta_activo' => 1,
            'th_tipo_plantilla_id' => $nivel_tactico_personal_cargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Utiliza canales de comunicación, en su diversa expresión, con claridad, precisión y tono agradable para el receptor',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Establecer comunicación efectiva, asertiva y positiva con superiores jerárquicos, pares, equipos y ciudadanos, tanto en la expresión escrita, como verbal y gestual',
            'th_pilar_id' => $comunicacion_efectiva_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Redacta textos, informes, mensajes, cuadros o gráficas con claridad en la expresión para hacer efectiva y sencilla la comprensión',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Establecer comunicación efectiva, asertiva y positiva con superiores jerárquicos, pares, equipos y ciudadanos, tanto en la expresión escrita, como verbal y gestual',
            'th_pilar_id' => $comunicacion_efectiva_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Mantiene escucha y lectura atenta a efectos de comprender mejor los mensajes o información recibida',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Establecer comunicación efectiva, asertiva y positiva con superiores jerárquicos, pares, equipos y ciudadanos, tanto en la expresión escrita, como verbal y gestual',
            'th_pilar_id' => $comunicacion_efectiva_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Da respuesta a cada comunicación recibida de modo inmediato',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Establecer comunicación efectiva, asertiva y positiva con superiores jerárquicos, pares, equipos y ciudadanos, tanto en la expresión escrita, como verbal y gestual',
            'th_pilar_id' => $comunicacion_efectiva_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Evaluar y evidenciar la adherencia y comprensión de los mensajes enviados',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Establecer comunicación efectiva, asertiva y positiva con superiores jerárquicos, pares, equipos y ciudadanos, tanto en la expresión escrita, como verbal y gestual',
            'th_pilar_id' => $comunicacion_efectiva_con_persona_acargo->id
        ]);

        $gestion_procedimientos_con_persona_acargo = ThPilar::create([
            'nombre' => 'Gestión de procedimientos',
            'porcentaje' => 15,
            'orden' => 8,
            'esta_activo' => 1,
            'th_tipo_plantilla_id' => $nivel_tactico_personal_cargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Ejecuta sus tareas con los criterios de calidad establecidos promoviendo la estandarización',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Desarrollar las tareas a cargo en el marco de los procedimientos vigentes y proponer e introducir acciones para acelerar la mejora continua y la productividad',
            'th_pilar_id' => $gestion_procedimientos_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Revisa y efectúa procedimientos para mejorar los tiempos y resultados y para anticipar soluciones a problemas',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Desarrollar las tareas a cargo en el marco de los procedimientos vigentes y proponer e introducir acciones para acelerar la mejora continua y la productividad',
            'th_pilar_id' => $gestion_procedimientos_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Desarrolla las actividades de acuerdo con las pautas y protocolos definidos',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Desarrollar las tareas a cargo en el marco de los procedimientos vigentes y proponer e introducir acciones para acelerar la mejora continua y la productividad',
            'th_pilar_id' => $gestion_procedimientos_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Elabora documentos sistémicos para la mejora de los procesos',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Desarrollar las tareas a cargo en el marco de los procedimientos vigentes y proponer e introducir acciones para acelerar la mejora continua y la productividad',
            'th_pilar_id' => $gestion_procedimientos_con_persona_acargo->id
        ]);

        $instrumentacion_desiciones_con_persona_acargo = ThPilar::create([
            'nombre' => 'Instrumentación de decisiones',
            'porcentaje' => 15,
            'orden' => 9,
            'esta_activo' => 1,
            'th_tipo_plantilla_id' => $nivel_tactico_personal_cargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Discrimina con efectividad entre las decisiones que deben ser elevadas a un superior, socializadas al equipo de trabajo o pertenecen a la esfera individual de trabajo',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Decidir sobre las cuestiones en las que es responsable con criterios de economía, eficacia, eficiencia y transparencia de la decisión',
            'th_pilar_id' => $instrumentacion_desiciones_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Adopta decisiones sobre ellas con base en información válida y rigurosa',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Decidir sobre las cuestiones en las que es responsable con criterios de economía, eficacia, eficiencia y transparencia de la decisión',
            'th_pilar_id' => $instrumentacion_desiciones_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Maneja criterios objetivos para analizar la materia a decidir con las personas involucradas',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Decidir sobre las cuestiones en las que es responsable con criterios de economía, eficacia, eficiencia y transparencia de la decisión',
            'th_pilar_id' => $instrumentacion_desiciones_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Valida la adherencia de los procedimientos de forma periódica e informa a la alta gerencia los resultados',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Decidir sobre las cuestiones en las que es responsable con criterios de economía, eficacia, eficiencia y transparencia de la decisión',
            'th_pilar_id' => $instrumentacion_desiciones_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Asume los efectos de sus decisiones y también de las adoptadas por el equipo de trabajo al que pertenece',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Decidir sobre las cuestiones en las que es responsable con criterios de economía, eficacia, eficiencia y transparencia de la decisión',
            'th_pilar_id' => $instrumentacion_desiciones_con_persona_acargo->id
        ]);

        $direccion_desarrollo_personal_con_persona_acargo = ThPilar::create([
            'nombre' => 'Dirección y desarrollo de personal',
            'porcentaje' => 15,
            'orden' => 10,
            'esta_activo' => 1,
            'th_tipo_plantilla_id' => $nivel_tactico_personal_cargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Identifica, ubica y desarrolla el talento humano a su cargo',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Favorecer el aprendizaje y desarrollo de los colaboradores, identificando potencialidades personales y profesionales para facilitar el cumplimiento de objetivos institucionales',
            'th_pilar_id' => $direccion_desarrollo_personal_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Orienta la identificación de necesidades de formación y capacitación y apoya la ejecución de las acciones propuestas para satisfacerlas',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Favorecer el aprendizaje y desarrollo de los colaboradores, identificando potencialidades personales y profesionales para facilitar el cumplimiento de objetivos institucionales',
            'th_pilar_id' => $direccion_desarrollo_personal_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Hace uso de las habilidades y recursos del talento humano a su cargo, para alcanzar las metas y los estándares de productividad',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Favorecer el aprendizaje y desarrollo de los colaboradores, identificando potencialidades personales y profesionales para facilitar el cumplimiento de objetivos institucionales',
            'th_pilar_id' => $direccion_desarrollo_personal_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Establece espacios regulares o periódicos de retroalimentación y reconocimiento del buen desempeño, en pro del mejoramiento continuo de las personas y la organización',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Favorecer el aprendizaje y desarrollo de los colaboradores, identificando potencialidades personales y profesionales para facilitar el cumplimiento de objetivos institucionales',
            'th_pilar_id' => $direccion_desarrollo_personal_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Notifica de forma clara, objetiva y oportuna las novedades relacionadas con el talento humano a su cargo',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Favorecer el aprendizaje y desarrollo de los colaboradores, identificando potencialidades personales y profesionales para facilitar el cumplimiento de objetivos institucionales',
            'th_pilar_id' => $direccion_desarrollo_personal_con_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Fomenta la participación y conocimiento del equipo, sobre la Plataforma Estratégica',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Favorecer el aprendizaje y desarrollo de los colaboradores, identificando potencialidades personales y profesionales para facilitar el cumplimiento de objetivos institucionales',
            'th_pilar_id' => $direccion_desarrollo_personal_con_persona_acargo->id
        ]);
        $nivel_tactico_sin_personal_cargo = ThTipoPlantilla::create([
            'nombre' => 'nivel táctico sin perso a cargo',
            'esta_activo' => 1,
        ]);

        // CREACION DE PILARES ASOCIADAS A TIPO PLANTILLA NIVEL TACTICO SIN PERSONAL A CARGO

        $pilar_atencion_centrada_sin_persona_acargo = ThPilar::create([
            'nombre' => 'Atención centrada en la persona',
            'porcentaje' => 8,
            'orden' => 1,
            'esta_activo' => 1,
            'th_tipo_plantilla_id' => $nivel_tactico_sin_personal_cargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Valora y atiende las necesidades y peticiones de los usuarios de forma oportuna',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Dirigir las decisiones y acciones a la satisfacción de las necesidades e intereses de los usuarios (internos y externos)',
            'th_pilar_id' => $pilar_atencion_centrada_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Reconoce la interdependencia entre su trabajo y el de otros',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Dirigir las decisiones y acciones a la satisfacción de las necesidades e intereses de los usuarios (internos y externos)',
            'th_pilar_id' => $pilar_atencion_centrada_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Establece mecanismos para conocer las necesidades e inquietudes de los usuarios',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Dirigir las decisiones y acciones a la satisfacción de las necesidades e intereses de los usuarios (internos y externos)',
            'th_pilar_id' => $pilar_atencion_centrada_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Incorpora las necesidades de los usuarios en los proyectos institucionales, con base en criterios de Excelencia y alta calidad, teniendo en cuenta la visión de servicio a corto, mediano y largo plazo',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Dirigir las decisiones y acciones a la satisfacción de las necesidades e intereses de los usuarios (internos y externos)',
            'th_pilar_id' => $pilar_atencion_centrada_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Aplica los conceptos de "no estigmatización" y "no discriminación" y genera espacios y lenguaje incluyente',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Dirigir las decisiones y acciones a la satisfacción de las necesidades e intereses de los usuarios (internos y externos)',
            'th_pilar_id' => $pilar_atencion_centrada_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Escucha activamente e informa con veracidad al usuario interno y externo',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Dirigir las decisiones y acciones a la satisfacción de las necesidades e intereses de los usuarios (internos y externos)',
            'th_pilar_id' => $pilar_atencion_centrada_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Genera un trato empático, respetuoso, equitativo e incluyente con el usuario interno y externo',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Dirigir las decisiones y acciones a la satisfacción de las necesidades e intereses de los usuarios (internos y externos)',
            'th_pilar_id' => $pilar_atencion_centrada_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Utiliza un lenguaje claro, incluyente para dar a conocer instrucciones sobre el estado de salud, procesos o cualquier actividad relacionada con él',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Dirigir las decisiones y acciones a la satisfacción de las necesidades e intereses de los usuarios (internos y externos)',
            'th_pilar_id' => $pilar_atencion_centrada_sin_persona_acargo->id
        ]);
        $orientacion_resultado_sin_persona_acargo = ThPilar::create([
            'nombre' => 'Orientación a resultados',
            'porcentaje' => 8,
            'orden' => 2,
            'esta_activo' => 1,
            'th_tipo_plantilla_id' => $nivel_tactico_sin_personal_cargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Asume la responsabilidad por sus resultados, con base en el pensamiento crítico, utilizando herramientas ofimáticas avanzadas',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Realizar las funciones y cumplir los compromisos organizacionales con eficacia, calidad y oportunidad',
            'th_pilar_id' => $orientacion_resultado_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Trabaja con base en objetivos claramente establecidos y realistas',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Realizar las funciones y cumplir los compromisos organizacionales con eficacia, calidad y oportunidad',
            'th_pilar_id' => $orientacion_resultado_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Diseña y utiliza indicadores para medir y comprobar los resultados obtenidos',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Realizar las funciones y cumplir los compromisos organizacionales con eficacia, calidad y oportunidad',
            'th_pilar_id' => $orientacion_resultado_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Planea las actividades del área para la gestión integral',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Realizar las funciones y cumplir los compromisos organizacionales con eficacia, calidad y oportunidad',
            'th_pilar_id' => $orientacion_resultado_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Adopta medidas para minimizar riesgos',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Realizar las funciones y cumplir los compromisos organizacionales con eficacia, calidad y oportunidad',
            'th_pilar_id' => $orientacion_resultado_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Plantea estrategias para alcanzar o superar los resultados esperados',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Realizar las funciones y cumplir los compromisos organizacionales con eficacia, calidad y oportunidad',
            'th_pilar_id' => $orientacion_resultado_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Se fija metas y obtiene los resultados institucionales esperados',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Realizar las funciones y cumplir los compromisos organizacionales con eficacia, calidad y oportunidad',
            'th_pilar_id' => $orientacion_resultado_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Cumple con oportunidad las funciones de acuerdo con los estándares, objetivos y tiempos establecidos por la empresa',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Realizar las funciones y cumplir los compromisos organizacionales con eficacia, calidad y oportunidad',
            'th_pilar_id' => $orientacion_resultado_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Gestiona recursos para mejorar la productividad y toma medidas necesarias para minimizar los riesgos',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Realizar las funciones y cumplir los compromisos organizacionales con eficacia, calidad y oportunidad',
            'th_pilar_id' => $orientacion_resultado_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Gestiona el cambio y desarrollo de la organización, asegurando la competitividad y efectividad a un largo plazo',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Realizar las funciones y cumplir los compromisos organizacionales con eficacia, calidad y oportunidad',
            'th_pilar_id' => $orientacion_resultado_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Evalúa de forma regular el grado de consecución de los objetivos y realiza informes de gestión',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Realizar las funciones y cumplir los compromisos organizacionales con eficacia, calidad y oportunidad',
            'th_pilar_id' => $orientacion_resultado_sin_persona_acargo->id
        ]);
        $trabajo_equipo_sin_persona_acargo = ThPilar::create([
            'nombre' => 'Trabajo en equipo',
            'porcentaje' => 8,
            'orden' => 3,
            'esta_activo' => 1,
            'th_tipo_plantilla_id' => $nivel_tactico_sin_personal_cargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Cumple los compromisos que adquiere con el equipo',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Trabajar con otros de forma integrada, colaborativa y armónica para la consecución de metas organizacionales comunes',
            'th_pilar_id' => $trabajo_equipo_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Respeta la diversidad de criterios y opiniones de los miembros del equipo',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Trabajar con otros de forma integrada, colaborativa y armónica para la consecución de metas organizacionales comunes',
            'th_pilar_id' => $trabajo_equipo_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Asume su responsabilidad como miembro de un equipo de trabajo y se enfoca en contribuir con el compromiso y la motivación de sus miembros',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Trabajar con otros de forma integrada, colaborativa y armónica para la consecución de metas organizacionales comunes',
            'th_pilar_id' => $trabajo_equipo_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Planifica las propias acciones teniendo en cuenta su repercusión en la consecución de los objetivos grupales y el trabajo colaborativo',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Trabajar con otros de forma integrada, colaborativa y armónica para la consecución de metas organizacionales comunes',
            'th_pilar_id' => $trabajo_equipo_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Establece una comunicación directa con los miembros del equipo que permite compartir información e ideas en condiciones de respeto y cordialidad',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Trabajar con otros de forma integrada, colaborativa y armónica para la consecución de metas organizacionales comunes',
            'th_pilar_id' => $trabajo_equipo_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Integra a los nuevos miembros y facilita su proceso de reconocimiento y apropiación de las actividades a cargo del equipo',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Trabajar con otros de forma integrada, colaborativa y armónica para la consecución de metas organizacionales comunes',
            'th_pilar_id' => $trabajo_equipo_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Realiza acompañamiento a los nuevos miembros del equipo',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Trabajar con otros de forma integrada, colaborativa y armónica para la consecución de metas organizacionales comunes',
            'th_pilar_id' => $trabajo_equipo_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Prepara y promueve la capacitación de los equipos de la organización',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Trabajar con otros de forma integrada, colaborativa y armónica para la consecución de metas organizacionales comunes',
            'th_pilar_id' => $trabajo_equipo_sin_persona_acargo->id
        ]);
        $adaptabilidad_cambio_sin_persona_acargo = ThPilar::create([
            'nombre' => 'Adaptabilidad al cambio',
            'porcentaje' => 8,
            'orden' => 4,
            'esta_activo' => 1,
            'th_tipo_plantilla_id' => $nivel_tactico_sin_personal_cargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Acepta y se adapta fácilmente a las nuevas situaciones',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Enfrentar con flexibilidad las situaciones nuevas asumiendo un manejo positivo y constructivo de los cambios',
            'th_pilar_id' => $adaptabilidad_cambio_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Responde al cambio con flexibilidad y dinamismo',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Enfrentar con flexibilidad las situaciones nuevas asumiendo un manejo positivo y constructivo de los cambios',
            'th_pilar_id' => $adaptabilidad_cambio_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Apoya a la empresa en nuevas decisiones y coopera activamente en la implementación de nuevos objetivos, formas de trabajo y procedimientos',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Enfrentar con flexibilidad las situaciones nuevas asumiendo un manejo positivo y constructivo de los cambios',
            'th_pilar_id' => $adaptabilidad_cambio_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Implementa cambios innovadores en los procesos, para la obtención de resultados estratégicos',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Enfrentar con flexibilidad las situaciones nuevas asumiendo un manejo positivo y constructivo de los cambios',
            'th_pilar_id' => $adaptabilidad_cambio_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Promueve al grupo para que se adapten a las nuevas condiciones',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Enfrentar con flexibilidad las situaciones nuevas asumiendo un manejo positivo y constructivo de los cambios',
            'th_pilar_id' => $adaptabilidad_cambio_sin_persona_acargo->id
        ]);
        $funciones_desempeño_sin_persona_acargo = ThPilar::create([
            'nombre' => 'Funciones de desempeño específicas',
            'porcentaje' => 8,
            'orden' => 5,
            'esta_activo' => 1,
            'th_tipo_plantilla_id' => $nivel_tactico_sin_personal_cargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => '1. Cumple de manera eficiente con las funciones generales  (Ejemplo, presentación personal, puntualidad, uso adecuado de claves de acceso, respuesta oportuna de correos electrónico, cuidado de la  dotación, respuesta oportuna  a las PQRS, entre otros ). Que se encuentran en  el Manual de Funciones',
            'descripcion' => 'Sin definición',
            'th_pilar_id' => $funciones_desempeño_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => '2. Cumple de manera eficiente con las funciones estratégicas y tácticas del cargo (Ejemplo, hace uso adecuado de las herramientas de trabajo software, cumple metas, entrega informes en los tiempos estipulados y demás funciones específicas del cargo ). Que se encuentran en  el Manual de Funciones',
            'descripcion' => 'Sin definición',
            'th_pilar_id' => $funciones_desempeño_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => '3. El evaluado identifica su aporte en el cumplimiento de la misión, visión y objetivos estratégicos de la institución',
            'descripcion' => 'Sin definición',
            'th_pilar_id' => $funciones_desempeño_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => '4. El evaluado introyecta y pone en práctica la propuesta de valor, los principios y valores de la institución',
            'descripcion' => 'Sin definición',
            'th_pilar_id' => $funciones_desempeño_sin_persona_acargo->id
        ]);
        $comunicacion_efectiva_sin_persona_acargo = ThPilar::create([
            'nombre' => 'Comunicación efectiva',
            'porcentaje' => 15,
            'orden' => 6,
            'esta_activo' => 1,
            'th_tipo_plantilla_id' => $nivel_tactico_sin_personal_cargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Utiliza canales de comunicación, en su diversa expresión, con claridad, precisión y tono agradable para el receptor',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Establecer comunicación efectiva, asertiva y positiva con superiores jerárquicos, pares, equipos y ciudadanos, tanto en la expresión escrita, como verbal y gestual',
            'th_pilar_id' => $comunicacion_efectiva_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Redacta textos, informes, mensajes, cuadros o gráficas con claridad en la expresión para hacer efectiva y sencilla la comprensión',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Establecer comunicación efectiva, asertiva y positiva con superiores jerárquicos, pares, equipos y ciudadanos, tanto en la expresión escrita, como verbal y gestual',
            'th_pilar_id' => $comunicacion_efectiva_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Mantiene escucha y lectura atenta a efectos de comprender mejor los mensajes o información recibida',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Establecer comunicación efectiva, asertiva y positiva con superiores jerárquicos, pares, equipos y ciudadanos, tanto en la expresión escrita, como verbal y gestual',
            'th_pilar_id' => $comunicacion_efectiva_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Da respuesta a cada comunicación recibida de modo inmediato',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Establecer comunicación efectiva, asertiva y positiva con superiores jerárquicos, pares, equipos y ciudadanos, tanto en la expresión escrita, como verbal y gestual',
            'th_pilar_id' => $comunicacion_efectiva_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Evaluar y evidenciar la adherencia y comprensión de los mensajes enviados',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Establecer comunicación efectiva, asertiva y positiva con superiores jerárquicos, pares, equipos y ciudadanos, tanto en la expresión escrita, como verbal y gestual',
            'th_pilar_id' => $comunicacion_efectiva_sin_persona_acargo->id
        ]);
        $gestion_procedimientos_sin_persona_acargo = ThPilar::create([
            'nombre' => 'Gestión de procedimientos',
            'porcentaje' => 15,
            'orden' => 7,
            'esta_activo' => 1,
            'th_tipo_plantilla_id' => $nivel_tactico_sin_personal_cargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Ejecuta sus tareas con los criterios de calidad establecidos promoviendo la estandarización',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Desarrollar las tareas a cargo en el marco de los procedimientos vigentes y proponer e introducir acciones para acelerar la mejora continua y la productividad',
            'th_pilar_id' => $gestion_procedimientos_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Revisa y efectúa procedimientos para mejorar los tiempos y resultados y para anticipar soluciones a problemas',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Desarrollar las tareas a cargo en el marco de los procedimientos vigentes y proponer e introducir acciones para acelerar la mejora continua y la productividad',
            'th_pilar_id' => $gestion_procedimientos_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Desarrolla las actividades de acuerdo con las pautas y protocolos definidos',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Desarrollar las tareas a cargo en el marco de los procedimientos vigentes y proponer e introducir acciones para acelerar la mejora continua y la productividad',
            'th_pilar_id' => $gestion_procedimientos_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Elabora documentos sistémicos para la mejora de los procesos',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Desarrollar las tareas a cargo en el marco de los procedimientos vigentes y proponer e introducir acciones para acelerar la mejora continua y la productividad',
            'th_pilar_id' => $gestion_procedimientos_sin_persona_acargo->id
        ]);
        $instrumentacion_desiciones_sin_persona_acargo = ThPilar::create([
            'nombre' => 'Instrumentación de decisiones',
            'porcentaje' => 15,
            'orden' => 8,
            'esta_activo' => 1,
            'th_tipo_plantilla_id' => $nivel_tactico_sin_personal_cargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Discrimina con efectividad entre las decisiones que deben ser elevadas a un superior, socializadas al equipo de trabajo o pertenecen a la esfera individual de trabajo',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Decidir sobre las cuestiones en las que es responsable con criterios de economía, eficacia, eficiencia y transparencia de la decisión',
            'th_pilar_id' => $instrumentacion_desiciones_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Adopta decisiones sobre ellas con base en información válida y rigurosa',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Decidir sobre las cuestiones en las que es responsable con criterios de economía, eficacia, eficiencia y transparencia de la decisión',
            'th_pilar_id' => $instrumentacion_desiciones_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Maneja criterios objetivos para analizar la materia a decidir con las personas involucradas',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Decidir sobre las cuestiones en las que es responsable con criterios de economía, eficacia, eficiencia y transparencia de la decisión',
            'th_pilar_id' => $instrumentacion_desiciones_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Valida la adherencia de los procedimientos de forma periódica e informa a la alta gerencia los resultados',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Decidir sobre las cuestiones en las que es responsable con criterios de economía, eficacia, eficiencia y transparencia de la decisión',
            'th_pilar_id' => $instrumentacion_desiciones_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Asume los efectos de sus decisiones y también de las adoptadas por el equipo de trabajo al que pertenece',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Decidir sobre las cuestiones en las que es responsable con criterios de economía, eficacia, eficiencia y transparencia de la decisión',
            'th_pilar_id' => $instrumentacion_desiciones_sin_persona_acargo->id
        ]);
        $confiabilidad_tecnica_sin_persona_acargo = ThPilar::create([
            'nombre' => 'Confiabilidad Técnica',
            'porcentaje' => 15,
            'orden' => 9,
            'esta_activo' => 1,
            'th_tipo_plantilla_id' => $nivel_tactico_sin_personal_cargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Aplica el conocimiento técnico en el desarrollo de sus responsabilidades',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Contar con los conocimientos técnicos requeridos y aplicarlos a situaciones concretas de trabajo, con altos estándares de calidad',
            'th_pilar_id' => $confiabilidad_tecnica_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Mantiene actualizado su conocimiento técnico para apoyar su gestión',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Contar con los conocimientos técnicos requeridos y aplicarlos a situaciones concretas de trabajo, con altos estándares de calidad',
            'th_pilar_id' => $confiabilidad_tecnica_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Resuelve problemas utilizando conocimientos técnicos de su especialidad, para apoyar el cumplimiento de metas y objetivos organizacionales',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Contar con los conocimientos técnicos requeridos y aplicarlos a situaciones concretas de trabajo, con altos estándares de calidad',
            'th_pilar_id' => $confiabilidad_tecnica_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Emite conceptos técnicos, juicios o propuestas claros, precisos, pertinentes y ajustados a los lineamientos normativos y organizacionales',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Contar con los conocimientos técnicos requeridos y aplicarlos a situaciones concretas de trabajo, con altos estándares de calidad',
            'th_pilar_id' => $confiabilidad_tecnica_sin_persona_acargo->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Propone según sus habilidades y conocimientos, acciones de mejora en los procesos en los que participa',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Contar con los conocimientos técnicos requeridos y aplicarlos a situaciones concretas de trabajo, con altos estándares de calidad',
            'th_pilar_id' => $confiabilidad_tecnica_sin_persona_acargo->id
        ]);

        $nivel_tecnico_asistencial = ThTipoPlantilla::create([
            'nombre' => 'nivel técnico asistencial',
            'esta_activo' => 1,
        ]);

        // CREACION DE PILARES ASOCIADAS A TIPO PLANTILLA NIVEL TECNICO ASISTENCIA

        $atencion_centrada_tecnico_asistencial = ThPilar::create([
            'nombre' => 'Atención centrada en la persona',
            'porcentaje' => 8,
            'orden' => 1,
            'esta_activo' => 1,
            'th_tipo_plantilla_id' => $nivel_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Valora y atiende las necesidades y peticiones de los usuarios de forma oportuna',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Dirigir las decisiones y acciones a la satisfacción de las necesidades e intereses de los usuarios (internos y externos)',
            'th_pilar_id' => $atencion_centrada_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Reconoce la interdependencia entre su trabajo y el de otros',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Dirigir las decisiones y acciones a la satisfacción de las necesidades e intereses de los usuarios (internos y externos)',
            'th_pilar_id' => $atencion_centrada_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Establece mecanismos para conocer las necesidades e inquietudes de los usuarios',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Dirigir las decisiones y acciones a la satisfacción de las necesidades e intereses de los usuarios (internos y externos)',
            'th_pilar_id' => $atencion_centrada_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Incorpora las necesidades de los usuarios en los proyectos institucionales, con base en criterios de Excelencia y alta calidad, teniendo en cuenta la visión de servicio a corto, mediano y largo plazo',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Dirigir las decisiones y acciones a la satisfacción de las necesidades e intereses de los usuarios (internos y externos)',
            'th_pilar_id' => $atencion_centrada_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Aplica los conceptos de "no estigmatización" y "no discriminación" y genera espacios y lenguaje incluyente',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Dirigir las decisiones y acciones a la satisfacción de las necesidades e intereses de los usuarios (internos y externos)',
            'th_pilar_id' => $atencion_centrada_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Escucha activamente e informa con veracidad al usuario interno y externo',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Dirigir las decisiones y acciones a la satisfacción de las necesidades e intereses de los usuarios (internos y externos)',
            'th_pilar_id' => $atencion_centrada_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Genera un trato empático, respetuoso, equitativo e incluyente con el usuario interno y externo',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Dirigir las decisiones y acciones a la satisfacción de las necesidades e intereses de los usuarios (internos y externos)',
            'th_pilar_id' => $atencion_centrada_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Utiliza un lenguaje claro, incluyente para dar a conocer instrucciones sobre el estado de salud, procesos o cualquier actividad relacionada con él',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Dirigir las decisiones y acciones a la satisfacción de las necesidades e intereses de los usuarios (internos y externos)',
            'th_pilar_id' => $atencion_centrada_tecnico_asistencial->id
        ]);
        $orientacion_resultado_tecnico_asistencial = ThPilar::create([
            'nombre' => 'Orientación a resultados',
            'porcentaje' => 8,
            'orden' => 2,
            'esta_activo' => 1,
            'th_tipo_plantilla_id' => $nivel_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Asume la responsabilidad por sus resultados, con base en el pensamiento crítico, utilizando herramientas ofimáticas avanzadas',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Realizar las funciones y cumplir los compromisos organizacionales con eficacia, calidad y oportunidad',
            'th_pilar_id' => $orientacion_resultado_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Trabaja con base en objetivos claramente establecidos y realistas',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Realizar las funciones y cumplir los compromisos organizacionales con eficacia, calidad y oportunidad',
            'th_pilar_id' => $orientacion_resultado_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Diseña y utiliza indicadores para medir y comprobar los resultados obtenidos',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Realizar las funciones y cumplir los compromisos organizacionales con eficacia, calidad y oportunidad',
            'th_pilar_id' => $orientacion_resultado_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Planea las actividades del área para la gestión integral',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Realizar las funciones y cumplir los compromisos organizacionales con eficacia, calidad y oportunidad',
            'th_pilar_id' => $orientacion_resultado_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Adopta medidas para minimizar riesgos',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Realizar las funciones y cumplir los compromisos organizacionales con eficacia, calidad y oportunidad',
            'th_pilar_id' => $orientacion_resultado_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Plantea estrategias para alcanzar o superar los resultados esperados',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Realizar las funciones y cumplir los compromisos organizacionales con eficacia, calidad y oportunidad',
            'th_pilar_id' => $orientacion_resultado_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Se fija metas y obtiene los resultados institucionales esperados',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Realizar las funciones y cumplir los compromisos organizacionales con eficacia, calidad y oportunidad',
            'th_pilar_id' => $orientacion_resultado_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Cumple con oportunidad las funciones de acuerdo con los estándares, objetivos y tiempos establecidos por la empresa',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Realizar las funciones y cumplir los compromisos organizacionales con eficacia, calidad y oportunidad',
            'th_pilar_id' => $orientacion_resultado_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Gestiona recursos para mejorar la productividad y toma medidas necesarias para minimizar los riesgos',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Realizar las funciones y cumplir los compromisos organizacionales con eficacia, calidad y oportunidad',
            'th_pilar_id' => $orientacion_resultado_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Gestiona el cambio y desarrollo de la organización, asegurando la competitividad y efectividad a un largo plazo',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Realizar las funciones y cumplir los compromisos organizacionales con eficacia, calidad y oportunidad',
            'th_pilar_id' => $orientacion_resultado_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Evalúa de forma regular el grado de consecución de los objetivos y realiza informes de gestión',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Realizar las funciones y cumplir los compromisos organizacionales con eficacia, calidad y oportunidad',
            'th_pilar_id' => $orientacion_resultado_tecnico_asistencial->id
        ]);
        $trabajo_equipo_tecnico_asistencial = ThPilar::create([
            'nombre' => 'Trabajo en equipo',
            'porcentaje' => 8,
            'orden' => 3,
            'esta_activo' => 1,
            'th_tipo_plantilla_id' => $nivel_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Cumple los compromisos que adquiere con el equipo',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Trabajar con otros de forma integrada, colaborativa y armónica para la consecución de metas organizacionales comunes',
            'th_pilar_id' => $trabajo_equipo_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Respeta la diversidad de criterios y opiniones de los miembros del equipo',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Trabajar con otros de forma integrada, colaborativa y armónica para la consecución de metas organizacionales comunes',
            'th_pilar_id' => $trabajo_equipo_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Asume su responsabilidad como miembro de un equipo de trabajo y se enfoca en contribuir con el compromiso y la motivación de sus miembros',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Trabajar con otros de forma integrada, colaborativa y armónica para la consecución de metas organizacionales comunes',
            'th_pilar_id' => $trabajo_equipo_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Planifica las propias acciones teniendo en cuenta su repercusión en la consecución de los objetivos grupales y el trabajo colaborativo',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Trabajar con otros de forma integrada, colaborativa y armónica para la consecución de metas organizacionales comunes',
            'th_pilar_id' => $trabajo_equipo_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Establece una comunicación directa con los miembros del equipo que permite compartir información e ideas en condiciones de respeto y cordialidad',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Trabajar con otros de forma integrada, colaborativa y armónica para la consecución de metas organizacionales comunes',
            'th_pilar_id' => $trabajo_equipo_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Integra a los nuevos miembros y facilita su proceso de reconocimiento y apropiación de las actividades a cargo del equipo',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Trabajar con otros de forma integrada, colaborativa y armónica para la consecución de metas organizacionales comunes',
            'th_pilar_id' => $trabajo_equipo_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Realiza acompañamiento a los nuevos miembros del equipo',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Trabajar con otros de forma integrada, colaborativa y armónica para la consecución de metas organizacionales comunes',
            'th_pilar_id' => $trabajo_equipo_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Prepara y promueve la capacitación de los equipos de la organización',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Trabajar con otros de forma integrada, colaborativa y armónica para la consecución de metas organizacionales comunes',
            'th_pilar_id' => $trabajo_equipo_tecnico_asistencial->id
        ]);
        $adaptabilidad_cambio_tecnico_asistencial = ThPilar::create([
            'nombre' => 'Adaptabilidad al cambio',
            'porcentaje' => 8,
            'orden' => 4,
            'esta_activo' => 1,
            'th_tipo_plantilla_id' => $nivel_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Acepta y se adapta fácilmente a las nuevas situaciones',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Enfrentar con flexibilidad las situaciones nuevas asumiendo un manejo positivo y constructivo de los cambios',
            'th_pilar_id' => $adaptabilidad_cambio_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Responde al cambio con flexibilidad y dinamismo',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Enfrentar con flexibilidad las situaciones nuevas asumiendo un manejo positivo y constructivo de los cambios',
            'th_pilar_id' => $adaptabilidad_cambio_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Apoya a la empresa en nuevas decisiones y coopera activamente en la implementación de nuevos objetivos, formas de trabajo y procedimientos',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Enfrentar con flexibilidad las situaciones nuevas asumiendo un manejo positivo y constructivo de los cambios',
            'th_pilar_id' => $adaptabilidad_cambio_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Implementa cambios innovadores en los procesos, para la obtención de resultados estratégicos',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Enfrentar con flexibilidad las situaciones nuevas asumiendo un manejo positivo y constructivo de los cambios',
            'th_pilar_id' => $adaptabilidad_cambio_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Promueve al grupo para que se adapten a las nuevas condiciones',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Enfrentar con flexibilidad las situaciones nuevas asumiendo un manejo positivo y constructivo de los cambios',
            'th_pilar_id' => $adaptabilidad_cambio_tecnico_asistencial->id
        ]);
        $funciones_desempeño_tecnico_asistencial = ThPilar::create([
            'nombre' => 'Funciones de desempeño específicas',
            'porcentaje' => 8,
            'orden' => 5,
            'esta_activo' => 1,
            'th_tipo_plantilla_id' => $nivel_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => '1. Cumple de manera eficiente con las funciones generales  (Ejemplo, presentación personal, puntualidad, uso adecuado de claves de acceso, respuesta oportuna de correos electrónico, cuidado de la  dotación, respuesta oportuna  a las PQRS, entre otros ). Que se encuentran en  el Manual de Funciones',
            'descripcion' => 'Sin definición',
            'th_pilar_id' => $funciones_desempeño_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => '2. Cumple de manera eficiente con las funciones estratégicas y tácticas del cargo (Ejemplo, hace uso adecuado de las herramientas de trabajo software, cumple metas, diligencia adecuadamente las historias clínicas, entrega informes en los tiempos estipulados y demás funciones específicas del cargo ). Que se encuentran en  el Manual de Funciones',
            'descripcion' => 'Sin definición',
            'th_pilar_id' => $funciones_desempeño_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => '3. El evaluado identifica su aporte en el cumplimiento de la misión, visión y objetivos estratégicos de la institución',
            'descripcion' => 'Sin definición',
            'th_pilar_id' => $funciones_desempeño_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => '4. El evaluado introyecta y pone en práctica la propuesta de valor, los principios y valores de la institución',
            'descripcion' => 'Sin definición',
            'th_pilar_id' => $funciones_desempeño_tecnico_asistencial->id
        ]);
        $confiabilidad_tecnica_tecnico_asistencial = ThPilar::create([
            'nombre' => 'Confiabilidad Técnica',
            'porcentaje' => 15,
            'orden' => 6,
            'esta_activo' => 1,
            'th_tipo_plantilla_id' => $nivel_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Aplica el conocimiento técnico en el desarrollo de sus responsabilidades',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Contar con los conocimientos técnicos requeridos y aplicarlos a situaciones concretas de trabajo, con altos estándares de calidad',
            'th_pilar_id' => $confiabilidad_tecnica_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Mantiene actualizado su conocimiento técnico para apoyar su gestión',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Contar con los conocimientos técnicos requeridos y aplicarlos a situaciones concretas de trabajo, con altos estándares de calidad',
            'th_pilar_id' => $confiabilidad_tecnica_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Resuelve problemas utilizando conocimientos técnicos de su especialidad, para apoyar el cumplimiento de metas y objetivos organizacionales',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Contar con los conocimientos técnicos requeridos y aplicarlos a situaciones concretas de trabajo, con altos estándares de calidad',
            'th_pilar_id' => $confiabilidad_tecnica_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Emite conceptos técnicos, juicios o propuestas claros, precisos, pertinentes y ajustados a los lineamientos normativos y organizacionales',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Contar con los conocimientos técnicos requeridos y aplicarlos a situaciones concretas de trabajo, con altos estándares de calidad',
            'th_pilar_id' => $confiabilidad_tecnica_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Propone según sus habilidades y conocimientos, acciones de mejora en los procesos en los que participa',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Contar con los conocimientos técnicos requeridos y aplicarlos a situaciones concretas de trabajo, con altos estándares de calidad',
            'th_pilar_id' => $confiabilidad_tecnica_tecnico_asistencial->id
        ]);

        $disciplina_adherencia_norma_tecnico_asistencial = ThPilar::create([
            'nombre' => 'Disciplina y adherencia a la norma',
            'porcentaje' => 15,
            'orden' => 7,
            'esta_activo' => 1,
            'th_tipo_plantilla_id' => $nivel_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Recibe instrucciones y desarrolla actividades acordes con las mismas',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA:Adaptarse a las políticas institucionales y generar información acorde con los procesos',
            'th_pilar_id' => $disciplina_adherencia_norma_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Acepta la supervisión constante',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA:Adaptarse a las políticas institucionales y generar información acorde con los procesos',
            'th_pilar_id' => $disciplina_adherencia_norma_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Revisa de manera permanente los cambio en los procesos',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA:Adaptarse a las políticas institucionales y generar información acorde con los procesos',
            'th_pilar_id' => $disciplina_adherencia_norma_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Identifica los conductos regulares',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA:Adaptarse a las políticas institucionales y generar información acorde con los procesos',
            'th_pilar_id' => $disciplina_adherencia_norma_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Acata los lineamientos de la Dirección del Talento humano',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA:Adaptarse a las políticas institucionales y generar información acorde con los procesos',
            'th_pilar_id' => $disciplina_adherencia_norma_tecnico_asistencial->id
        ]);
        $manejo_informacion_tecnico_asistencial = ThPilar::create([
            'nombre' => 'Manejo de la información',
            'porcentaje' => 15,
            'orden' => 8,
            'esta_activo' => 1,
            'th_tipo_plantilla_id' => $nivel_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Maneja con responsabilidad y seguridad, las informaciones personales e institucionales de que dispone',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Manejar con responsabilidad y seguridad, la información personal e institucional de que dispone',
            'th_pilar_id' => $manejo_informacion_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Evade temas que indagan sobre información confidencial',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Manejar con responsabilidad y seguridad, la información personal e institucional de que dispone',
            'th_pilar_id' => $manejo_informacion_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Recoge solo información imprescindible para el desarrollo de la tarea',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Manejar con responsabilidad y seguridad, la información personal e institucional de que dispone',
            'th_pilar_id' => $manejo_informacion_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Escala con sus lideres, las inquietudes para obtener y brindar información fidedigna',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Manejar con responsabilidad y seguridad, la información personal e institucional de que dispone',
            'th_pilar_id' => $manejo_informacion_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Organiza y custodia de forma adecuada la información a su cuidado, teniendo en cuenta las normas legales y de la organización',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Manejar con responsabilidad y seguridad, la información personal e institucional de que dispone',
            'th_pilar_id' => $manejo_informacion_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'No hace pública la información laboral o de las personas que pueda afectar la organización o las personas',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Manejar con responsabilidad y seguridad, la información personal e institucional de que dispone',
            'th_pilar_id' => $manejo_informacion_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Transmite información oportuna y objetiva',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Manejar con responsabilidad y seguridad, la información personal e institucional de que dispone',
            'th_pilar_id' => $manejo_informacion_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Revisa oportunamente los correos institucionales, que imparten directrices organizacionales',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Manejar con responsabilidad y seguridad, la información personal e institucional de que dispone',
            'th_pilar_id' => $manejo_informacion_tecnico_asistencial->id
        ]);
        $relaciones_interpersonales_tecnico_asistencial = ThPilar::create([
            'nombre' => 'Relaciones interpersonales',
            'porcentaje' => 15,
            'orden' => 9,
            'esta_activo' => 1,
            'th_tipo_plantilla_id' => $nivel_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Escucha con interés y atención; y capta las necesidades de los demás',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Establecer y mantener relaciones de trabajo positivas, basadas en la comunicación abierta y fluida y en el respeto por los demás',
            'th_pilar_id' => $relaciones_interpersonales_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Practica el trato empático con las personas con las que se relaciona en su trabajo',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Establecer y mantener relaciones de trabajo positivas, basadas en la comunicación abierta y fluida y en el respeto por los demás',
            'th_pilar_id' => $relaciones_interpersonales_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Transmite la información de forma fidedigna, evitando situaciones que puedan generar deterioro en el ambiente laboral',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Establecer y mantener relaciones de trabajo positivas, basadas en la comunicación abierta y fluida y en el respeto por los demás',
            'th_pilar_id' => $relaciones_interpersonales_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Toma la iniciativa en el contacto con usuarios para dar avisos, citas o respuestas, utilizando un lenguaje claro para los destinatarios, especialmente con las personas que integran minorías con mayor vulnerabilidad social o con diferencias funcionales',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Establecer y mantener relaciones de trabajo positivas, basadas en la comunicación abierta y fluida y en el respeto por los demás',
            'th_pilar_id' => $relaciones_interpersonales_tecnico_asistencial->id
        ]);
        $competencia = ThCompetencia::create([
            'competencia' => 'Maneja el autocontrol y respeto en las situaciones laborales',
            'descripcion' => 'DEFINICIÓN DE LA COMPETENCIA: Establecer y mantener relaciones de trabajo positivas, basadas en la comunicación abierta y fluida y en el respeto por los demás',
            'th_pilar_id' => $relaciones_interpersonales_tecnico_asistencial->id
        ]);
    }
}
