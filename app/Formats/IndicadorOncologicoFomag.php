<?php

namespace App\Formats;


use App\Http\Modules\Indicadores\Services\IndicadorService;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class IndicadorOncologicoFomag
{
    private $desde;
    private $hasta;
    private $indicadoreService;

//    private IndicadorService $indicadoreService;
    public function __construct($desde, $hasta)
    {
        $this->indicadoreService = new IndicadorService();
        $this->desde = $desde;
        $this->hasta = $hasta;
    }

    public function formato()
    {
        $ruta = storage_path('app/') . 'prueba.xlsx';
        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();
        $activeWorksheet->setCellValue('A1', 'TABLERO DE INDICADORES DE GESTION DEL RIESGO EN SALUD COHORTE ONCOLÓGICA');
        $activeWorksheet->mergeCells('A1:L3');
        $activeWorksheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);
        $activeWorksheet->getStyle("A1:L3")->getFont()->setName('Aptos Narrow')->setSize(18)->setBold(true);
        $primeraCabeceras = [
            'A' => 'N°',
            'B' => 'ATRIBUTO',
            'C' => 'ORIGEN',
            'D' => 'NOMBRE DEL INDICADOR',
            'E' => 'JUSTIFICACIÓN TÉCNICA',
            'F' => 'DEFINICIÓN OPERACIONAL',
            'G' => 'UNIDAD DE MEDIDA',
            'H' => 'PERIODICIDAD DE REPORTE'
        ];
        foreach ($primeraCabeceras as $key => $value) {
            $rango = $key . '4';
            $rangoConjunto = $key . '4:' . $key . '5';
            $activeWorksheet->setCellValue($rango, $value);
            $activeWorksheet->mergeCells($rangoConjunto);
            $activeWorksheet->getStyle($rango)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(false);
            $activeWorksheet->getStyle($rangoConjunto)->getFont()->setName('Aptos Narrow')->setSize(12)->setBold(true);
        }
        $activeWorksheet->setCellValue('I4', 'FUENTE');
        $activeWorksheet->mergeCells('I4:K4');
        $activeWorksheet->getStyle('I4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(false);
        $activeWorksheet->getStyle('I4:K4')->getFont()->setName('Aptos Narrow')->setSize(12)->setBold(true);
        $segundaCabeceras = [
            'I5' => 'PRIMARIA',
            'J5' => 'SECUNDARIA',
            'K5' => 'TERCIARIA'
        ];
        foreach ($segundaCabeceras as $key => $value) {
            $activeWorksheet->setCellValue($key, $value);
//            $activeWorksheet->mergeCells('I4:K4');
            $activeWorksheet->getStyle($key)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(false);
            $activeWorksheet->getStyle($key)->getFont()->setName('Aptos Narrow')->setSize(12)->setBold(true);
        }

        $tercerCuerpo = [
            ['Dias', 'Mensual'],
            ['Tasa expresada por 100.000 mujeres afiliadas', 'Semestral'],
            ['Porcentaje', 'Trimestral'],
            ['Porcentaje', 'Trimestral'],
            ['Porcentaje', 'Trimestral'],
            ['Porcentaje', 'Trimestral'],
            ['Porcentaje', 'Trimestral'],
            ['Porcentaje', 'Trimestral'],
            ['Porcentaje', 'Trimestral'],
            ['Porcentaje', 'Trimestral'],
            ['Porcentaje', 'Trimestral'],
            ['Porcentaje', 'Trimestral'],
            ['Porcentaje', 'Trimestral'],
            ['Porcentaje', 'Mensual'],
            ['Porcentaje', 'Trimestral'],
            ['Porcentaje', 'Trimestral'],
            ['Porcentaje', 'Trimestral'],
            ['Porcentaje', 'Trimestral'],
            ['Porcentaje', 'Trimestral'],
            ['Dias', 'Mensual'],
            ['Por 100.000 mujeres', 'Trimestral'],
            ['Dias', 'Mensual'],
            ['Porcentaje', 'trimesstral'],
            ['Porcentaje', 'Trimestral'],
            ['Porcentaje', 'Semestral'],
            ['Tasa expresada por 100.000 hombres afiliados', 'Semestral'],
            ['Porcentaje', 'Trimestral'],
            ['Porcentaje', 'Trimestral'],
            ['Días', 'Trimestral'],
            ['Días', 'Trimestral'],
            ['Días', 'Trimestral'],
            ['Porcentaje', 'Trimestral'],
            ['Porcentaje', 'Trimestral'],
            ['Porcentaje', 'Trimestral'],
            ['Días', 'Trimestral'],
            ['Días', 'Trimestral'],
            ['Días', 'Trimestral'],
            ['Porcentaje', 'Trimestral'],
            ['Porcentaje', 'Trimestral'],
            ['Porcentaje', 'Mensual'],
            ['Porcentaje', 'Mensual'],
            ['Porcentaje', 'Mensual'],
            ['Porcentaje', 'Mensual'],
            ['Porcentaje', 'Mensual'],
            ['Porcentaje', 'Mensual'],
            ['Porcentaje', 'Trimestral'],
            ['Días', 'Mensual'],
            ['Porcentaje', 'Mensual'],
            ['Porcentaje', 'Mensual'],
            ['Porcentaje', 'Mensual'],
            ['Porcentaje', 'Mensual'],
            ['Porcentaje', 'Mensual'],
            ['Días', 'Mensual'],
            ['Porcentaje', 'Mensual'],
            ['Porcentaje', 'Trimestral'],
            ['Días', 'Mensual'],
            ['Días', 'Mensual'],
            ['Porcentaje', 'Mensual'],
            ['Porcentaje', 'Mensual'],
            ['Porcentaje', 'Mensual'],


        ];
        $primerCuerpo = [
            ['OPORTUNIDAD', 'Res 256 de 2016', 'Tiempo promedio de espera para el inicio del tratamiento en cáncer de mama', 'La oportunidad, es la posibilidad que tiene el individuo de acceder al sistema de salud para el inicio de tratamiento, la supervivencia de la enfermedad está directamente relacionada con el estadio clínico al momento del diagnóstico y el inicio de tratamiento temprano para mejorar la posibilidad de curación.',],
            ['EFECTIVIDAD (EVITABILIDAD)', 'Modelo de Salud FOMAG', 'Tasa de Mortalidad por Cáncer de Seno invasivo', 'El cáncer de mama es una preocupación de salud pública en Colombia, pues continúa siendo el tipo de cáncer más frecuente. Según los datos reportados por la Organización Mundial de la Salud en su página de GLOBOCAN, para el 2020 se estimaron 15.509 casos nuevos y 4.411 muertes por esta enfermedad.',],
            ['CONTINUIDAD', 'CACGPC', 'Proporción de mujeres con cáncer de mama a quienes se les realizó estadificación TNM', 'La estadificación clínica permite dimensionar la extensión de la enfermedad, guiar el manejo quirúrgico y facilitar la toma de decisiones frente al tratamiento',],
            ['CONTINUIDAD', 'CACGPC', 'Proporción de mujeres con diagnóstico histopatológico antes de la cirugía. Cáncer de mama', 'Una lesión considerada maligna debe tener una confirmación histopatológica antes de que se realice cualquier cirugía y se tomen otras conductas terapéuticas.',],
            ['CONTINUIDAD', 'CACGPC', 'Proporción de mujeres con cáncer de mama con resultado de receptores hormonales (estrógenos/ progesterona).', 'La expresión de receptores hormonales permite direccionar la terapia sistémica más adecuada después de la cirugía. La realización de la medición y el reporte de los receptores hormonales (estrógenos/progesterona) en las mujeres con cáncer de mama es un aspecto que indica la adecuada gestión.',],
            ['CONTINUIDAD', 'CACGPC', 'Proporción de mujeres con resultado del estado de HER2', 'La expresión del Receptor 2 de Factor de Crecimiento Epidérmico Humano (HER2) permite direccionar la terapia sistémica más adecuada después de la cirugía',],
            ['CONTINUIDAD', 'CACGPC', 'Proporción de mujeres con cáncer de mama invasivo a quienes se les realizó cirugía conservadora de la mama', 'La efectividad de la cirugía de conservación de la mama cuando se usa de la mano de radioterapia, ha demostrado ser igual o superior a la mastectomía para el tratamiento del cáncer, pero con mejores resultados psicosociales y estéticos',],
            ['CONTINUIDAD', 'CACGPC', 'Proporción de mujeres con cáncer de mama a quienes se les realizó radioterapia después de la cirugía conservadora de la mama (incidentes)', 'La efectividad de la cirugía de conservación de la mama cuando se usa de la mano de radioterapia ha demostrado ser igual o superior a la mastectomía para el tratamiento del cáncer, pero con  Mejores resultados psicosociales y estéticos',],
            ['CONTINUIDAD', 'CAC', 'Proporción de mujeres con receptores hormonales positivos a quienes se les administra bloqueo hormonal como tratamiento', 'Alrededor del 75% de las mujeres con cáncer de mama son receptores hormonales positivos, lo que hace que respondan adecuadamente a la terapia hormonal frente a otras terapias.',],
            ['CONTINUIDAD', 'CAC', 'Proporción de mujeres que recibieron terapia anti-HER2.', 'Los pacientes HER2(+) se benefician del uso de Traztuzumab, Pertuzumab y Lapatinib como terapia adyuvante porque responden adecuadamente a estos medicamentos mejorando la supervivencia en este grupo de mujeres.',],
            ['CONTINUIDAD', 'CAC', 'Proporción de pacientes con cáncer de mama invasivo con valoración por cuidado paliativo.', 'Los cuidados paliativos se deben implementar en todos los pacientes con cáncer con el objetivo final de mejorar la calidad de vida. Una adecuada gestión del cáncer debe incluir este aspecto, ya que permite determinar si se está abordando de forma integral al paciente.',],
            ['CONTINUIDAD', 'CAC', 'Oportunidad de inicio de la terapia adyuvante (tiempo desde la cirugía hasta el primer tratamiento postquirúrgico: quimioterapia/radioterapia/bloqueo hormonal) (excluye in situ). Cáncer de mama', 'La terapia adyuvante como parte del tratamiento del cáncer tiene el objetivo de reducir la posibilidad de que el cáncer reaparezca.',],
            ['EFECTIVIDAD', 'CAC', 'Letalidad de cáncer de mama', 'Como resultado de las acciones para gestionar el riesgo a través del diagnóstico y tratamiento oportuno, la mortalidad en los pacientes con cáncer de mama debe disminuir progresivamente.',],
            ['CONTINUIDAD', 'CAC', 'Proporción de mujeres con cáncer de cuello uterino a quienes se les realizó estadificación clínica TNM o FIGO.', 'El estadio es el más relevante factor pronóstico en cáncer de cuello uterino  y el esquema de tratamiento está basado en él, por lo cual, la ausencia del mismo, denota falencias en la atención prestada en este grupo de pacientes.',],
            ['CONTINUIDAD', 'CAC', 'Proporción de mujeres con cáncer de cuello uterino en estadio IA hasta ib2 (estadío ia-ib2) que recibieron algún procedimiento curativo (conización/cirugía).', 'La terapia de elección para estadios tempranos de cáncer de cuello uterino es la conización/cirugía, por lo cual la realización de este tratamiento en este grupo de pacientes es un indicador de la adecuada gestión',],
            ['CONTINUIDAD', 'CAC', 'Proporción de mujeres con cáncer de cuello uterino en estadios II hasta IV (estadíos II-IV) a quienes se les suministró radioterapia', 'La terapia de elección para estadios invasivos del cáncer de cuello uterino es la radioterapia + quimioterapia. ',],
            ['CONTINUIDAD', 'CAC', 'Proporción de mujeres con cáncer de cuello uterino en estadios II hasta IV (estadíos II-IV) a quienes se les suministró quimioterapia', 'La terapia de elección para estadios invasivos del cáncer de cuello uterino es la radioterapia + quimioterapia. ',],
            ['CONTINUIDAD', 'CAC', 'Proporción de mujeres con cáncer de cuello uterino en estadios II - IV a quienes se les suministró quimioterapia y radioterapia concomitante con braquiterapia', 'La terapia de elección para estadios invasivos del cáncer de cuello uterino es la radioterapia + quimioterapia + braquiterapia',],
            ['CONTINUIDAD', 'CAC', 'Proporción de mujeres con cáncer de cuello uterino con valoración por cuidado paliativo', 'El cuidado paliativo encierra un amplio grupo de intervenciones que pueden realizarse en las mujeres con cáncer para mejorar la calidad de vida. La integralidad en el manejo del cáncer debe abordarse teniendo en cuenta no solo el aspecto fisiológico sino otros aspectos psicológicos, sociales, contextuales relacionados con el paciente y su familia.',],
            ['OPORTUNIDAD', 'Res 256 de 2016', 'Tiempo promedio de espera para el inicio del tratamiento en cáncer de cuello uterino', 'La oportunidad, es la posibilidad que tiene el individuo de acceder al sistema de salud para el inicio de tratamiento, la supervivencia de la enfermedad está directamente relacionada con el estadio clínico al momento del diagnóstico y el inicio de tratamiento temprano para mejorar la posibilidad de curación.',],
            ['EFECTIVIDAD (EVITABILIDAD)', 'CAC', 'Mortalidad general en mujeres con cáncer de cuello uterino', 'Como resultado de las acciones para gestionar el riesgo a través del diagnóstico y tratamiento oportuno, la mortalidad en los pacientes con cáncer de cérvix debe disminuir progresivamente.',],
            ['OPORTUNIDAD', 'Res 256 de 2016CAC', 'Tiempo promedio de espera para el inicio del tratamiento en cáncer de próstata', 'El cáncer de próstata es el cuarto cáncer más frecuente en el mundo en la población general y el segundo más frecuente en los hombres, despues del cáncer de pulmón la oportunidad de inicio de tratamiento temprano entendiendose como la posibilidad que tienene los individuos para acceder al sistema de salud el cual se expresa como como el número de días apartir de un evento temporal pasado hasta un evento temporal posteror buscando asi mejroar la calidad de vida.',],
            ['EFECTIVIDAD (EVITABILIDAD)', 'CAC', 'Proporción de pacientes con cáncer de próstata estadificados con TNM', 'El TNM, permite establecer el momento, el compromiso, pronóstico y las conductas terapéuticas en los cánceres de comportamiento sólido',],
            ['PROCESO', 'CACGPC', 'Proporción de pacientes estadificados en Gleason score.', 'Gleason es un sistema de estadificación para clasificar el grado de cáncer de un tejido en un sistema de 2 a 10, y es un examen complementario y no derogable por la clasificación TNM. Esta codificación  definen conductas terapéuticas en todos los pacientes con cáncer de próstata',],
            ['PROCESO', 'CAC', 'Seguimiento de PSA postratamiento en cáncer de próstata', 'La toma de PSA postratamiento es recomendada 3 meses después de la intervención y su valor debe ser indetectable cuando la intención de tratamiento es curativa. ',],
            ['EFECTIVIDAD (EVITABILIDAD)', 'Modelo de Salud FOMAG', 'Tasa de Mortalidad por cáncer de Próstata invasivo', 'El cáncer de próstata es el cuarto cáncer más frecuente en el mundo en la población general y el segundo más frecuente en los hombres, después del cáncer de pulmón la oportunidad de inicio de tratamiento temprano entendiéndose como la posibilidad que tienen los individuos para acceder al sistema de salud el cual se expresa como como el número de días a partir de un evento temporal pasado hasta un evento temporal posterior buscando así mejorar la calidad de vida',],
            ['CONTINUIDAD', 'CACGPC', 'Proporción de pacientes  con cáncer de próstata con valoración por cuidado paliativo', 'La integralidad en el manejo del cáncer debe abordarse teniendo en cuenta no solo el aspecto fisiológico sino otros aspectos psicológicos, sociales, contextuales relacionados con el paciente y su familia.',],
            ['CONTINUIDAD', 'CAC', 'Proporción de pacientes con estadificación por TNM. Cáncer gástrico.', 'La estadificación del paciente define la conducta terapéutica a seguir y predice el riesgo de mortalidad y complicación del paciente de acuerdo al grado de compromiso y diseminación de la lesión.',],
            ['OPORTUNIDAD', 'CAC', 'Oportunidad para inicio de tratamiento después del diagnóstico en cáncer gástrico.', 'Evaluar tiempos de oportunidad para inicio de tratamiento después del diagnóstico, lo cual va a determinar el pronóstico y evolución del paciente. El retraso en el inicio del tratamiento, puede hacer que este sea menos efectivo, ya que en un tiempo prolongado el paciente puede cambiar de estadificación; es decir que su enfermedad esté más avanzada.',],
            ['OPORTUNIDAD', 'CAC', 'Oportunidad entre la neoyuvancia y la cirugía curativa. Cáncer gástrico.', 'La terapia neoadyuvante es un estándar de cuidado para pacientes con adenocarcinoma de esófago y estómago',],
            ['OPORTUNIDAD', 'CAC', 'Oportunidad entre la cirugía y el inicio de adyuvancia. Cáncer gástrico.', 'Debido a las altas tasas de recurrencia locorregional y sistémica, la cirugía debe ser complementada con quimioterapia perioperatoria o quimiorradioterapia adyuvantes, según lo amerite el caso; esto mejora la supervivencia libre de enfermedad y la supervivencia global.',],
            ['CONTINUIDAD', 'CAC', 'Proporción de pacientes estadio 0 a III sometidos a cirugía como tratamiento curativo. Cáncer gástrico.', 'El único tratamiento potencialmente curativo para cáncer gástrico es la cirugía en pacientes con criterios de tumor resecable.',],
            ['CONTINUIDAD', 'CAC', 'Valoración por cuidados paliativos. Cáncer gástrico.', 'Los cuidados paliativos deberían comenzar en las fases tempranas del diagnóstico de una enfermedad que amenaza la vida, simultáneamente con los tratamientos curativos',],
            ['CONTINUIDAD', 'CAC', 'Proporción de pacientes con diagnóstico de cáncer de recto  con estadificación por TNM. ', 'La información obtenida de la estadificación se utiliza para determinar el pronóstico, para guiar el manejo y para evaluar la respuesta al tratamiento. Las decisiones basadas en información de estadificación incluyen: la operación curativa versus la operación paliativa, la extirpación radical versus local, la quimio radiación preoperatoria (46) y la terapia postquirúrgica adyuvante.',],
            ['OPORTUNIDAD', 'CAC', 'Oportunidad para inicio de tratamiento después del diagnóstico en cáncer  colorrectal', 'Evaluar tiempos de oportunidad para inicio de tratamiento después del diagnóstico, lo cual va a determinar el pronóstico y evolución del paciente.',],
            ['OPORTUNIDAD', 'CAC', 'Oportunidad entre la neoyuvancia y la cirugía curativa. Cáncer colorrectal', 'El tratamiento estándar actual del cáncer rectal localmente avanzado consiste en quimio radiación seguida de cirugía radical',],
            ['OPORTUNIDAD', 'CAC', 'Oportunidad entre la cirugía y el inicio de adyuvancia.  Cáncer colorrectal', 'Debido a las altas tasas de recurrencia locorregional y sistémica, la cirugía debe ser complementada con quimioterapia perioperatoria o quimiorradioterapia adyuvantes, según lo amerite el caso; esto mejora la supervivencia libre de enfermedad y la supervivencia global.',],
            ['CONTINUIDAD', 'CAC', 'Proporción de pacientes  estadio I a III sometidos a cirugía como tratamiento curativo. Cáncer colorrectal', 'La resección quirúrgica es el tratamiento potencialmente curativo en pacientes diagnosticados con cáncer de colon y recto',],
            ['CONTINUIDAD', 'Modelo de Salud FOMAG', 'Valoración por cuidados paliativos. Cáncer colorrectal.', 'Los cuidados paliativos deberían comenzar en las fases tempranas del diagnóstico de una enfermedad que amenaza la vida, simultáneamente con los tratamientos curativos',],
            ['OPORTUNIDAD', 'CAC', 'Oportunidad de confirmación diagnóstica (tiempo desde la realización de la biopsia hasta la confirmación del diagnóstico). LH y LNH', 'Evaluar y mejorar progresivamente el tiempo de oportunidad en días para la confirmación diagnóstica (reporte de la biopsia) en los pacientes con sospecha de linfomas Hodgkin y No Hodgkin a partir de la realización de la toma de la biopsia.',],
            ['OPORTUNIDAD', 'CAC', 'Oportunidad de tratamiento (tiempo entre el diagnóstico hasta el primer tratamiento).  LH y LNH', 'El inicio oportuno del tratamiento aumenta la sobrevida de los pacientes con cánceres he- matológicos, incluyendo los linfomas. La medición de un fragmento de tiempo permite a las entidades identificar en qué momento se presentan los retrasos en la atención para gestionar dichas falencias.',],
            ['CONTINUIDAD', 'CAC', 'Proporción de pacientes con diagnóstico de Linfoma Hodgkin y Linfoma No Hodgkin a quienes se les realizó estadificación completa', 'La estadificación se lleva a cabo de acuerdo con la clasificación de Ann Arbor en consideración de los factores de riesgo clínicos definidos. La guía de práctica clínica de Colombia, recomienda que el estadio de la enfermedad del paciente sea asignado de acuerdo con la Clasificación de Lugano, adaptación de Ann Arbor.',],
            ['CONTINUIDAD', 'CAC', 'Proporción de los pacientes con diagnóstico de linfoma en estadios I y II. LH y LNH', 'Al contar con la estadificación anterior, se puede determinar si la enfermedad se encontraba en estadios “limitados” (etapa I o etapa II no voluminoso), al momento del diagnóstico, el pronóstico y el tratamiento se establece de acuerdo con el estadio de la enfermedad',],
            ['CONTINUIDAD', 'CAC', 'Proporción de los pacientes diagnosticados con clasificación de riesgo: IPI, FLIPI, MIPI (LNH) y PPI (LH).', 'De acuerdo con la guía de práctica clínica colombiana, todos los pacientes con diagnóstico de linfoma deberán ser clasificados según el Índice pronostico internacional IPI en LBDCG e PPI o IPS en LH, FLIPI en linfoma folicular y MIPI en linfoma de células del manto. La clasificación del riesgo determina el pronóstico y la conducta terapéutica, por ende, todo paciente diagnosticado con linfoma debe contar con esta clasificación en su historia clínica y tener conocimiento de ella.',],
            ['CONTINUIDAD', 'CAC', 'Proporción de los pacientes con diagnóstico de linfoma que recibieron quimioterapia. LH y LNH', 'En los linfomas la conducta terapéutica está dada por diferentes factores son el estadio de la enfermedad y el tipo histológico, además de otras condiciones propias de la persona como su edad y su estado funcional, sin embargo, en términos generales la quimioterapia es la terapia estándar y primaria para un paciente con linfoma.',],
            ['CONTINUIDAD', 'Modelo de Salud FOMAG', 'Valoración por cuidados paliativos. Linfoma', 'Los cuidados paliativos deberían comenzar en las fases tempranas del diagnóstico de una enfermedad que amenaza la vida, simultáneamente con los tratamientos curativos',],
            ['OPORTUNIDAD', 'CAC', 'Tiempo entre el diagnóstico histológico y el primer tratamiento. Melanoma', 'El pronóstico de supervivencia global del paciente con melanoma depende del diagnóstico y tratamiento precoz del mismo. Varía según el estadio de la enfermedad tanto en el tiempo como en la definición del primer tratamiento',],
            ['CONTINUIDAD', 'CAC', 'Proporción de pacientes con melanoma cutáneo con estadificación TNM. Melanoma', 'La estadificación de la enfermedad permite definir un tratamiento y evaluar el pronóstico.',],
            ['CONTINUIDAD', 'CAC', 'Proporción de pacientes con melanoma cutáneo en estadios tempranos (I y II). Melanoma', 'Evidencia de que las actividades de promoción de la salud de la autoridad local para prevenir el cáncer de piel y reconocer los signos iniciales son consistentes con los mensajes de cualquier campaña nacional.',],
            ['CONTINUIDAD', 'CAC', 'Proporción de pacientes con diagnóstico de melanoma que reciben tratamiento sistémico. Melanoma', 'La mayoría de los melanomas metastásicos no son susceptibles a la cirugía, por lo cual a menudo se encuentra que la terapia sistémica es la mejor opción, al igual que como terapia adyuvante en los estadios IIC - III - IV',],
            ['CONTINUIDAD', 'CAC', 'Proporción de pacientes que suspenden la terapia sistémica. Melanoma', 'Este es un indicador de calidad y seguridad para la atención a pacientes con melanoma cutáneo.',],
            ['CONTINUIDAD', 'CAC', 'Proporción de pacientes con cáncer de pulmón en quienes se realizó estadificación TNM previo al inicio del tratamiento. Cáncer de pulmón.', 'La estadificación por TNM del cáncer de pulmón es determinante ya que se establece el pronóstico del paciente y provee información para definir el objetivo del tratamiento, dado que las opciones terapéuticas y su pronóstico son diferentes en cada estadio.',],
            ['OPORTUNIDAD', 'CAC', 'Oportunidad de tratamiento (tiempo entre el diagnóstico hasta el primer tratamiento). Cáncer de pulmón.', 'La oportunidad en términos de tiempo como un factor derivado de la atención médica capaz de ser gestionable, que refleje la continuidad en la atención, solo de esta manera se puede determinar la capacidad de los sistemas de salud para generar cambios que beneficien al paciente y el impacto financiero',],
            ['CONTINUIDAD', 'CAC', 'Proporción de pacientes en estadios tempranos (I-II) que fueron sometidos a cirugía con intención curativa. Cáncer de pulmón.', 'La resección quirúrgica continúa siendo el tipo de tratamiento potencialmente curativo para el cáncer de pulmón y debe ofrecérseles a todos los pacientes en estadios tempranos (I -II) como tratamiento de elección.',],
            ['CONTINUIDAD', 'CAC', 'Valoración por cuidados paliativos. Cáncer de pulmón.', 'Los cuidados paliativos deberían comenzar en las fases tempranas del diagnóstico de una enfermedad que amenaza la vida, simultáneamente con los tratamientos curativos',],
            ['OPORTUNIDAD', 'FOMAGCOHORTE', 'Oportunidad de tratamiento (tiempo entre el diagnóstico hasta el primer tratamiento). Cáncer de tiroides', 'La oportunidad en términos de tiempo como un factor derivado de la atención médica capaz de ser gestionable, que refleje la continuidad en la atención, solo de esta manera se puede determinar la capacidad de los sistemas de salud para generar cambios que beneficien al paciente y el impacto financiero',],
            ['CONTINUIDAD', 'FOMAGCOHORTE', 'Proporción de pacientes con cáncer de tiroides en quienes se realizó estadificación. Cáncer de tiroides', 'La estadificación clínica permite dimensionar la extensión de la enfermedad, guiar el manejo quirúrgico y facilitar la toma de decisiones frente al tratamiento',],
            ['CONTINUIDAD', 'FOMAGCOHORTE', 'Continuidad del manejo oncológico ', 'La continuidad de la atención del cáncer incluye evaluación de riesgos, prevención primaria, detección, diagnóstico, tratamiento, supervivencia y atención al final de la vida. La continuidad de la atención se define como cómo un paciente experimenta la atención a lo largo del tiempo, de forma coherente y vinculada, y es el resultado de un buen flujo de información, buenas habilidades interpersonales y una buena coordinación de la atención.',],
            ['CONTINUIDAD', 'FOMAGCOHORTE', 'Abandono del tratamiento', 'El abandono del tratamiento en pacientes con cáncer implica la imposibilidad de completar la terapia curativa, con el consiguiente aumento de las tasas de mortalidad. Las principales causas son el diagnóstico tardío y la toxicidad de los fármacos antineoplásicos',],
            ['EFICACIA', 'FOMAGCOHORTE', 'Adherencia a GPC a todos los tipos de cáncer.', 'La medición de la adherencia a las guías de práctica clínica es crucial para garantizar la calidad y seguridad de la atención médica dado que garantiza que los pacientes reciban tratamientos basados en evidencia, minimiza el riesgo de errores diagnósticos y terapéuticos,  puede mejorar la eficacia de los tratamientos y reducir las complicaciones, reducir los costos asociados con reingresos hospitalarios y tratamientos innecesarios y mejorar la experiencia del paciente y su satisfacción con la atención recibida.',]
        ];

        $quintoCuerpo = [
            ['Menor a 15 dias = 100%'],
            ['20,04 por 100mil muejres afiliadas - CAC Higia para el regimen excepcion año 2023'],
            ['≥90% '],
            ['≥70% '],
            ['≥90% '],
            ['≥90% '],
            ['≥70%'],
            ['≥90%'],
            ['≥90%'],
            ['≥70%'],
            ['≥90%'],
            ['≤ 42 días'],
            ['≤ 4,4 %'],
            ['≥ 90 %'],
            ['≥90%'],
            ['≥90%'],
            ['≥90%'],
            ['≥90%'],
            ['≥90%'],
            ['Menor a 15 dias. = 100%'],
            ['<5,5 x 100,000 afiliados'],
            ['Menor a 15 dias = 100%'],
            ['≥90%'],
            ['≥90%'],
            ['≥95%'],
            ['17,05  por 100mil hombres afiliados - CAC Higia para el regimen excepcion año 2023'],
            ['≥90%'],
            ['> 90 %'],
            ['<30días'],
            ['≤ 84 días'],
            ['≤ 84 días'],
            ['> 90 %'],
            ['> 90 %'],
            ['>90%'],
            ['<30días'],
            ['≤ 84 días'],
            ['≤ 56 días'],
            ['> 90 %'],
            ['> 90 %'],
            ['≤ 15 días'],
            ['≤ 30 días'],
            ['> 90 %'],
            ['> 60 %'],
            ['0,03'],
            ['> 90 %'],
            ['> 90 %'],
            ['≤ 30 días'],
            ['> 90%'],
            ['> 50%'],
            ['>60%.'],
            ['>60%.'],
            ['> 90 %'],
            ['< 30 días'],
            ['> 90 %'],
            ['> 90 %'],
            ['< 30 días'],
            ['> 90 %'],
            ['> 90 %'],
            ['≤ 10%'],
            ['> 85 %'],
        ];
        $columna = 6;
        $columna2 = 6;
        for ($i = 1; $i <= 60; $i++) {
            $activeWorksheet->setCellValue('A' . $columna, $i);
            $activeWorksheet->getStyle('A' . $columna)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(false);
            $activeWorksheet->getStyle('A' . $columna)->getFont()->setName('Aptos Narrow')->setSize(12)->setBold(false);
            $columna++;
            $activeWorksheet->setCellValue('A' . $columna, $i);
            $activeWorksheet->getStyle('A' . $columna)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(false);
            $activeWorksheet->getStyle('A' . $columna)->getFont()->setName('Aptos Narrow')->setSize(12)->setBold(false);
            $columna++;


            $valorInicial = $columna2;
            $valorFinal = $columna2 + 1;
            $rango = 'B' . $valorInicial;
            $rangoConjunto = 'B' . $valorInicial . ':B' . $valorFinal;
            $activeWorksheet->setCellValue($rango, $primerCuerpo[$i - 1][0]);
            $activeWorksheet->mergeCells($rangoConjunto);
            $activeWorksheet->getStyle($rango)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(false);
            $activeWorksheet->getStyle($rangoConjunto)->getFont()->setName('Aptos Narrow')->setSize(12)->setBold(false);


            $rango = 'C' . $valorInicial;
            $rangoConjunto = 'C' . $valorInicial . ':C' . $valorFinal;
            $activeWorksheet->setCellValue($rango, $primerCuerpo[$i - 1][1]);
            $activeWorksheet->mergeCells($rangoConjunto);
            $activeWorksheet->getStyle($rango)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(false);
            $activeWorksheet->getStyle($rangoConjunto)->getFont()->setName('Aptos Narrow')->setSize(12)->setBold(false);

            $rango = 'D' . $valorInicial;
            $rangoConjunto = 'D' . $valorInicial . ':D' . $valorFinal;
            $activeWorksheet->setCellValue($rango, $primerCuerpo[$i - 1][2]);
            $activeWorksheet->mergeCells($rangoConjunto);
            $activeWorksheet->getStyle($rango)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(false);
            $activeWorksheet->getStyle($rangoConjunto)->getFont()->setName('Aptos Narrow')->setSize(12)->setBold(false);


            $rango = 'E' . $valorInicial;
            $rangoConjunto = 'E' . $valorInicial . ':E' . $valorFinal;
            $activeWorksheet->setCellValue($rango, $primerCuerpo[$i - 1][3]);
            $activeWorksheet->mergeCells($rangoConjunto);
            $activeWorksheet->getStyle($rango)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(false);
            $activeWorksheet->getStyle($rangoConjunto)->getFont()->setName('Aptos Narrow')->setSize(12)->setBold(false);


            $rango = 'G' . $valorInicial;
            $rangoConjunto = 'G' . $valorInicial . ':G' . $valorFinal;
            $activeWorksheet->setCellValue($rango, $tercerCuerpo[$i - 1][0]);
            $activeWorksheet->mergeCells($rangoConjunto);
            $activeWorksheet->getStyle($rango)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(false);
            $activeWorksheet->getStyle($rangoConjunto)->getFont()->setName('Aptos Narrow')->setSize(12)->setBold(false);

            $rango = 'H' . $valorInicial;
            $rangoConjunto = 'H' . $valorInicial . ':H' . $valorFinal;
            $activeWorksheet->setCellValue($rango, $tercerCuerpo[$i - 1][1]);
            $activeWorksheet->mergeCells($rangoConjunto);
            $activeWorksheet->getStyle($rango)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(false);
            $activeWorksheet->getStyle($rangoConjunto)->getFont()->setName('Aptos Narrow')->setSize(12)->setBold(false);

            $rango = 'L' . $valorInicial;
            $rangoConjunto = 'L' . $valorInicial . ':L' . $valorFinal;
            $activeWorksheet->setCellValue($rango, $quintoCuerpo[$i - 1][0]);
            $activeWorksheet->mergeCells($rangoConjunto);
            $activeWorksheet->getStyle($rango)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(false);
            $activeWorksheet->getStyle($rangoConjunto)->getFont()->setName('Aptos Narrow')->setSize(12)->setBold(false);

            $columna2 = $columna2 + 2;
        }
        $segundoCuerpo = [
            'Numerador: Sumatoria de la diferencia de días calendario entre fecha de inicio de tratamiento y fecha de dignóstico de cáncer de mama incidentes en el período ',
            'Denominador: Número total de casos de cáncer de mama diagnosticados durante el período ',
            'Numerador: Número de mujeres con cáncer de mama invasivo que fallecieron durante el periodo',
            'Denominador: Total de mujeres afiliadas activas al periodo de reporte',
            'Numerador: Número de mujeres detectadas como carcinomas in situ al momento del diagnóstico.

10. DETECCIÓN TEMPRANA DE CÁNCER DE MAMA
10.1 Objetivos
Detectar lesiones de cáncer de mama en estadios tempranos a través de la
realización de pruebas de tamización de base poblacional ajustadas a la edad de la
mujer.
10.2 Población sujeto
Mujeres a partir de los 40 años: examen clínico de la mama.
Mujeres a partir de los 50 años hasta los 69 años: mamografía bilateral.',
            'Denominador: Total de mujeres diagnosticadas con cáncer de mama',
            'Numerador: Número de mujeres con diagnóstico histopatológico antes de la cirugía.',
            'Denominador: Total de mujeres que se sometieron cirugía.',
            'Numerador: Número de mujeres con cáncer de mama con resultado de receptores hormonales (estrógenos/progesterona).',
            'Denominador: Total de mujeres con cáncer de mama.',
            'Numerador: Número de mujeres con cáncer de mama invasivo con resultado del estado de HER2. ',
            'Denominador:: Total de mujeres con cáncer de mama invasivo.',
            'Numerador: Número de pacientes con cáncer de mama invasivo a quienes se les realizó cirugía conservadora de la mama',
            'Denominador: Total de pacientes con cáncer de mama invasivo que recibieron tratamiento quirúrgico',
            'Numerador:  Número de pacientes con cáncer de mama a quienes se les realizó radioterapia después de la cirugía conservadora de la mama. ',
            'Denominador: Total de pacientes con cáncer de mama a quienes se les realizó cirugía conservadora de la mama.',
            'Numerador:   Número de mujeres con cáncer de mama invasivo con receptores hormonales positivos a quienes se les administra bloqueo hormonal como tratamiento.',
            'Denominador: Total de mujeres con cáncer de mama invasivo y receptores hormonales positivos. ',
            'Numerador:  Número de mujeres con cáncer de mama invasivo que recibieron terapia anti-HER2.',
            'Denominador: Total de mujeres con cáncer de mama invasivo con receptor HER2 (+).',
            'Numerador: Número de pacientes con cáncer de mama invasivo con valoración por cuidado paliativo.',
            'Denominador: Número de pacientes con cáncer de mama invasivo.',
            'Numerador: Sumatoria de los días transcurridos entre la cirugía hasta el primer tratamiento postquirúrgico',
            'Denominador: Total de mujeres con cáncer de mama',
            'Numerador: Número de mujeres con cáncer de mama que fallecieron durante el periodo',
            'Denominador: Total de mujeres con cáncer de mama durante el periodo',
            'Numerador: Número de mujeres con cáncer de cuello uterino a quienes se les realizó y se les reportó la estadificación clínica inicial',
            'Denominador: Total de mujeres diagnosticadas con cáncer de cuello uterino.',
            'Numerador:  Número de mujeres con cáncer de cuello uterino en estadio IA-IB2 que recibieron algún procedimiento curativo (conización/cirugía).',
            'Denominador: Total de mujeres con cáncer de cuello uterino en estadio IA-IB2',
            'Numerador:  Número de mujeres con cáncer de cuello uterino en estadios II-IV a quienes se les suministró radioterapia ',
            'Denominador:Total de mujeres con cáncer de cuello uterino en estadios II-IV.',
            'Numerador:  Número de mujeres con cáncer de cuello uterino en estadios II-IV a quienes se les suministró o quimioterapia.',
            'Denominador:Total de mujeres con cáncer de cuello uterino en estadios II-IV.',
            'Numerador:  Número de mujeres con cáncer de cuello uterino en estadios II-IV a quienes se les suministró o quimioterapia + braquiterapia',
            'Denominador:Total de mujeres con cáncer de cuello uterino en estadios II-IV.',
            'Numerador:  Número de mujeres con cáncer de cuello uterino  en estadios avanzados a quienes se les realizó valoración por cuidado paliativo.',
            'Denominador: Total de mujeres con cáncer de cuello uterino.',
            'Numerador: Sumatoria de la diferencia de días calendario entre la fecha de inicio de tratamiento y fecha de diagnóstico de cáncer de cuello uterino en el período ',
            'Denominador:  Número total de casos de cáncer de cuello uterino diagnosticados durante el período ',
            'Numerador:  Número de mujeres con cáncer de cuello uterino fallecidos durante el periodo de análisis. ',
            'Denominador:Total de población femenina mayor de 18 años (Base de datos Única de Afiliados).',
            'Numerador: Sumatoria de la diferencia de días calendario entre la fecha de inicio de tratamiento y fecha de diagnóstico de cáncer de próstata en el período ',
            'Denominador:   Número total de casos de cáncer de próstata diagnosticados durante el período ',
            'Numerador: Número de pacientes incidentes con Cáncer de próstata a quienes se realizó estadificación por TNM al momento del Dx',
            'Denominador: Total pacientes incidentes diagnosticados con cáncer de próstata',
            'Numerador: Número de pacientes incidentes con cáncer de próstata a quienes se realizó estadificación Gleason',
            'Denominador: Total pacientes incidentes con reporte histopatológico ',
            'Numerador: Número de pacientes con cumplimiento de PSA postratamiento ( mínimo 1 PSA dentro de 1 año posterior a tratamiento)',
            'Denominador: El total de pacientes incidentes con indicación de PSA por fecha de primer tratamiento. ',
            'Numerador: Número de hombres con cáncer de próstata invasivo que fallecieron durante el periodo',
            'Denominador: Total de hombres afiliados activos al periodo de reporte',
            'Numerador:  Número de pacientes con cáncer de próstata quienes se les realizó valoración por cuidado paliativo.',
            'Denominador: Total de pacientes con cáncer de próstata.',
            'Numerador: Número de pacientes con cáncer gástrico a quienes se realizó estadificación por TNM',
            'Denominador: Total pacientes diagnosticados con cáncer gástrico',
            'Numerador: Número de días transcurridos entre diagnóstico y el primer tratamiento',
            'Denominador: Total pacientes diagnosticados con cáncer gástrico.',
            'Numerador: Número de días transcurridos entre neoadyuvancia y cirugía.',
            'Denominador: Total de pacientes con cáncer gástrico con neoadyuvancia.',
            'Numerador: Número de días transcurridos entre cirugía y adyuvancia.',
            'Denominador: Total de pacientes con cáncer gástrico sometidos a cirugía y adyuvancia.',
            'Numerador: Número de pacientes con diagnóstico de cáncer gástrico sometidos a cirugía curativa',
            'Denominador: Total pacientes diagnosticados con cáncer gástrico estadios 0 a III',
            'Numerador: Número de pacientes con diágnóstico de cáncer gástrico con valoración por cuidado paliativo',
            'Denominador: Total pacientes diagnosticados con cáncer gástrico',
            'Numerador: Número de pacientes con Ca de colon y recto a quienes se realizó estadificación por TNM',
            'Denominador: Total pacientes diagnosticados con cáncer de colon y recto',
            'Numerador: Número de días transcurridos entre Dx y el primer tratamiento.',
            'Denominador: Total pacientes diagnosticados con cáncer gástrico y colorrectal.',
            'Numerador: Número de días transcurridos entre la finalización de neoadyuvancia y cirugía',
            'Denominador: Total pacientes diagnosticados con cáncer de recto',
            'Numerador: Número de días transcurridos entre cirugía y adyuvancia',
            'Denominador: Total pacientes diagnosticados con cáncer de colony recto sometidos a cirgia y adyuvancia',
            'Numerador: Número de pacientes con Diagnostico de cáncer de colon y recto sometidos a cirugía curativa',
            'Denominador: Total pacientes diagnosticados estadios I a III)',
            'Numerador: Número de pacientes con diágnóstico de cáncer colorrectal con valoración por cuidado paliativo',
            'Denominador: Total pacientes diagnosticados con cáncer colorrectal.',
            'Numerador: Sumatoria de días transcurridos entre la fecha de la recolección de muestra hasta la fecha de diagnóstico',
            'Denominador: Total de casos nuevos diagnosticados con LNH o LH',
            'Numerador: Sumatoria de días transcurridos entre la fecha de diagnóstico y la fecha de inicio de tratamiento',
            'Denominador: Total de casos nuevos diagnosticados con LNH o LH',
            'Numerador: Número de casos nuevos de LNH o LH con estadiﬁcación Ann Arbor o Lugano',
            'Denominador: Total de casos nuevos diagnosticados con LNH o LH',
            'Numerador: Número de casos nuevos de LNH o LH en estadios I y II',
            'Denominador: Total de casos nuevos diagnosticados con LNH o LH con estadiﬁcación.',
            'Numerador: Número de casos nuevos que cuentan con clasificación de riesgo',
            'Denominador: Total de casos nuevos diagnosticados con LNH o LH',
            'Numerador: Número de casos nuevos con diagnóstico de linfoma que recibieron quimioterapia en el periodo',
            'Denominador: Total de casos nuevos diagnosticados con LNH o LH.',
            'Numerador: Número de pacientes con diágnóstico de Linfoma con valoración por cuidado paliativo',
            'Denominador: Total pacientes diagnosticados con Linfoma',
            'Numerador: Promedio del número de días transcurridos entre la fecha de confirmación diagnóstica por histopatología y la fecha del primer tratamiento realizado (terapia sistémica, radioterapia o cirugía)',
            'Denominador: Total de casos nuevos  diagnosticados con melanoma que cuentan con dichas fechas',
            'Numerador: Número de casos nuevos con diagnóstico de melanoma a quienes se les realizó estadificación TNM',
            'Denominador: Total de casos nuevos diagnosticados con melanoma',
            'Numerador: Número de casos nuevos con diagnóstico de melanoma en estadios I y II',
            'Denominador: Total de casos nuevos diagnosticados con melanoma con diagnóstico histopatológico ',
            'Numerador: Número de casos nuevos con diagnóstico de melanoma en estadio IIC - III - IV que recibieron terapia sistémica.',
            'Denominador:Total de casos nuevos diagnosticados con melanoma en estadio IIC - III - IV. ',
            'Numerador: Número de casos nuevos con diagnóstico de melanoma en estadio IIC - III - IV que recibieron terapia sistémica.',
            'Denominador:Total de casos nuevos diagnosticados con melanoma en estadio IIC - III - IV. ',
            'Numerador: Número de casos con cáncer de pulmón en quieres se realizó estadificación TNM previo al inicio del tratamiento',
            'Denominador: Total de casos nuevos reportados con cáncer de pulmón',
            'Numerador: Sumatoria de días transcurridos entre el diagnóstico y el primer tratamiento',
            'Denominador: Total de casos nuevos reportados con cáncer de pulmón',
            'Numerador: Número de casos nuevos reportados con cáncer de pulmón en estadios I-II sometidos a cirugía curativa',
            'Denominador: Total de casos nuevos reportados con cáncer de pulmón en estadios I-II',
            'Numerador: Número de pacientes con diágnóstico de cáncer de pulmón con valoración por cuidado paliativo',
            'Denominador: Total pacientes diagnosticados con cáncer de pulmón.',
            'Numerador: Sumatoria de días transcurridos entre el diagnóstico y el primer tratamiento',
            'Denominador: Total de casos nuevos reportados con cáncer de tiroides.',
            'Numerador: Número de casos con cáncer de tiroides en quieres se realizó estadificación.',
            'Denominador: Total de casos nuevos reportados con cáncer de tiroides',
            'Numerador: Numero de usuario con diagnóstico de cáncer con cumplimiento de cita de control (médica y/o paramédica), toma exámenes de laboratorio clínico y/o toma de exámenes apoyo diagnóstico periodo',
            'Denominador: Total de usuario con diagnóstico de cáncer con agendamientos de citas (médica y/o paramédica), ordenes medicas de laboratorio clínico y/o ordenes de medicas de apoyo diagnostico periodo',
            'Numerador: Número de pacientes con diagnóstico de cáncer con abandono de tratamiento instaurado (Quimioterapia y/o radioterapia y/o quirúrgico)',
            'Denominador: Total pacientes diagnosticados con cáncer con tratamiento instaurado (Quimioterapia y/o radioterapia y/o quirúrgico)',
            'Numerador: Sumatoria del número de historias clínicas evaluadas de pacientes atendidos con Dx de cáncer (según cronograma de guías a evaluar) que cumplen con las guías de práctica clínica según estándar institucional en el período',
            'Denominador: Sumatoria total de historias clínicas evaluadas de pacientes atendidos con Dx de cáncer (según cronograma de guías a evaluar) en el mismo período',

        ];
        $cuartoCuerpo = [
            ['Registro de asignación y/o aplicativo del sistema de información de citas establecidos por el contratista', 'Reporte consolidado del dato por parte del contratista', ''],
            ['Reporte  cohorte de la patología FOMAG', 'Historia clínica ', 'Reporte establecido por parte del contratista'],
            ['Reporte mortalidad por cáncer reportado por el contratista', 'Cohorte de la patología Cáncer', 'RUAF -  SIVIGILA'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Cohorte de la patología FOMAG', 'Historia clínica', ''],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Cohorte de la patología FOMAG', 'Historia clínica', ''],
            ['Base de afiliados', '', ''],
            ['Historia clinica', 'Registro de entrega de tratamientos y/o aplicativo del sistema de información establecidos por el contratista y/o reporte (cohorte de la patologia)', 'RIPS'],
            ['Reporte  cohorte de la patología FOMAG', 'Reporte consolidado por parte del contratista', ''],
            ['Cohorte de la patología FOMAG', 'Historia clínica', 'RUAF -  SIVIGILA'],
            ['Base de afiliados', '', ''],
            ['Historia clinica', 'Registro de entrega de tratamientos y/o aplicativo del sistema de información establecidos por el contratista y/o reporte (cohorte de la patologia)', 'RIPS'],
            ['Reporte  cohorte de la patología FOMAG', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Reporte mortalidad por cáncer reportado por el contratista', 'Cohorte de la patología Cáncer', 'RUAF -  SIVIGILA'],
            ['Base de afiliados', '', ''],
            ['Cohorte de la patología FOMAG', 'Historia clínica', ''],
            ['Base de afiliados', '', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', 'CAC'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', ''],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Historia clínica', 'Cohorte de la patología FOMAG', ''],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],
            ['Reporte consolidado por parte del contratista', 'Cohorte de la patología FOMAG', 'Instrumento de evaluación del prestador'],
            ['Base de afiliados', 'Reporte consolidado por parte del contratista', ''],

        ];
        $columna3 = 6;
        for ($i = 0; $i <= 119; $i++) {

            $rango = 'F' . $columna3;

            $activeWorksheet->setCellValue($rango, $segundoCuerpo[$i]);
            $activeWorksheet->mergeCells($rango);
            $activeWorksheet->getStyle($rango)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(false);
            $activeWorksheet->getStyle($rango)->getFont()->setName('Aptos Narrow')->setSize(12)->setBold(false);

            $rango1 = 'I' . $columna3;

            $activeWorksheet->setCellValue($rango1, $cuartoCuerpo[$i][0]);
            $activeWorksheet->mergeCells($rango1);
            $activeWorksheet->getStyle($rango1)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(false);
            $activeWorksheet->getStyle($rango1)->getFont()->setName('Aptos Narrow')->setSize(12)->setBold(false);

            $rango2 = 'J' . $columna3;

            $activeWorksheet->setCellValue($rango2, $cuartoCuerpo[$i][1]);
            $activeWorksheet->mergeCells($rango2);
            $activeWorksheet->getStyle($rango2)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(false);
            $activeWorksheet->getStyle($rango2)->getFont()->setName('Aptos Narrow')->setSize(12)->setBold(false);

            $rango3 = 'K' . $columna3;

            $activeWorksheet->setCellValue($rango3, $cuartoCuerpo[$i][2]);
            $activeWorksheet->mergeCells($rango3);
            $activeWorksheet->getStyle($rango3)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(false);
            $activeWorksheet->getStyle($rango3)->getFont()->setName('Aptos Narrow')->setSize(12)->setBold(false);

            $columna3++;
        }

        $meses = [
            '01' => 'Enero',
            '02' => 'Febrero',
            '03' => 'Marzo',
            '04' => 'Abril',
            '05' => 'Mayo',
            '06' => 'Junio',
            '07' => 'Julio',
            '08' => 'Agosto',
            '09' => 'Septiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre'
        ];
        $rangosFechas = $this->indicadoreService->calcularRangosFechasIndicadorOncologicoFomag($this->desde, $this->hasta);
        $letraTitulo = 'M';
        $letra = 'M';
        $letraIndicador = 'N';
        foreach ($rangosFechas['mensuales'] as $mes => $rango) {
            $valores = DB::select("SELECT * FROM fn_indicadores_oncologia(?,?,?,?,?,?)", [$rango['desde'], $rango['hasta'], $rangosFechas['trimestrales'][$mes]['desde'], $rangosFechas['trimestrales'][$mes]['hasta'], $rangosFechas['semestrales'][$mes]['desde'], $rangosFechas['semestrales'][$mes]['hasta']]);
            $nombreMes = strtoupper($meses[$mes]);
            for ($i = 1; $i <= 2; $i++) {
                $rango = $letraTitulo . '4';
                $rangoConjunto = $letraTitulo . '4:' . $letraTitulo . '5';
                $activeWorksheet->setCellValue($rango, ($i == 2 ? 'INDIDCADOR ' : '') . $nombreMes);
                $activeWorksheet->mergeCells($rangoConjunto);
                $activeWorksheet->getStyle($rango)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(false);
                $activeWorksheet->getStyle($rangoConjunto)->getFont()->setName('Aptos Narrow')->setSize(12)->setBold(true);
                $letraTitulo++;
            }
            $columna4 = 6;
            for ($i = 0; $i <= 59; $i++) {
                // NUMERADOR //
                $rango4 = $letra . $columna4;
                $columnaNumerador = $columna4;
                $activeWorksheet->setCellValue($rango4, $valores[$i]->numerador);
                $activeWorksheet->mergeCells($rango4);
                $activeWorksheet->getStyle($rango4)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(false);
                $activeWorksheet->getStyle($rango4)->getFont()->setName('Aptos Narrow')->setSize(12)->setBold(false);
                $columna4++;
                // DENOMINADOR //
                $rango5 = $letra . $columna4;
                $columnaDenominador = $columna4;
                $activeWorksheet->setCellValue($rango5, $valores[$i]->denominador);
                $activeWorksheet->mergeCells($rango5);
                $activeWorksheet->getStyle($rango5)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(false);
                $activeWorksheet->getStyle($rango5)->getFont()->setName('Aptos Narrow')->setSize(12)->setBold(false);

                $rangoMedida = $letraIndicador . $columnaNumerador . ':' . $letraIndicador . $columnaDenominador;
                $activeWorksheet->setCellValue($letraIndicador . $columnaNumerador, $valores[$i]->medida);
                $activeWorksheet->mergeCells($rangoMedida);
                $activeWorksheet->getStyle($rangoMedida)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(false);
                $activeWorksheet->getStyle($rangoMedida)->getFont()->setName('Aptos Narrow')->setSize(12)->setBold(true);
//                $letra++;
                $columna4++;
            }
            $letra++;
            $letra++;
            $letraIndicador++;
            $letraIndicador++;
        }


        //        $valores = DB::select("SELECT * FROM fn_indicadores_oncologia(?,?)",[$this->anio,$this->mes]);

        $columna4 = 6;
//        for ($i = 0; $i <= 59; $i++){
//            // NUMERADOR //
//            $primerRango =
//            $rango4 = 'M'.$columna4;
//            $columnaNumerador = $columna4;
//                $activeWorksheet->setCellValue($rango4,$valores[$i]->numerador);
//            $activeWorksheet->mergeCells($rango4);
//            $activeWorksheet->getStyle($rango4)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(false);
//            $activeWorksheet->getStyle($rango4)->getFont()->setName('Aptos Narrow')->setSize(12)->setBold(false);
//            $columna4++;
//            // DENOMINADOR //
//            $rango5 = 'M'.$columna4;
//            $columnaDenominador = $columna4;
//            $activeWorksheet->setCellValue($rango5,$valores[$i]->denominador);
//            $activeWorksheet->mergeCells($rango5);
//            $activeWorksheet->getStyle($rango5)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(false);
//            $activeWorksheet->getStyle($rango5)->getFont()->setName('Aptos Narrow')->setSize(12)->setBold(false);
//            $rangoMedida = 'N'.$columnaNumerador.':N'.$columnaDenominador;
////            dd($rangoMedida);
//
//            $activeWorksheet->setCellValue('N'.$columnaNumerador,$valores[$i]->medida);
//            $activeWorksheet->mergeCells($rangoMedida);
//            $activeWorksheet->getStyle($rangoMedida)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(false);
//            $activeWorksheet->getStyle($rangoMedida)->getFont()->setName('Aptos Narrow')->setSize(12)->setBold(true);
////
//            $columna4++;
//
//        }
//        $this->valorInficadores();
        $writer = new Xlsx($spreadsheet);
        $writer->save($ruta);
        return $ruta;
    }
}
