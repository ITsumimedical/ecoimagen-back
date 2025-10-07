<?php

namespace App\Formats;

use Codedge\Fpdf\Fpdf\Fpdf;
use App\Http\Modules\Caracterizacion\Models\CaracterizacionEcis as ModeloCaracterizacionEcis;

class CaracterizacionEcis extends Fpdf
{
    public static ModeloCaracterizacionEcis $caracterizacionEcis;

    public function generar(array $data): void
    {
        self::$caracterizacionEcis = ModeloCaracterizacionEcis::with('afiliado')
            ->firstWhere('afiliado_id', $data['afiliadoId']);

        $this->AliasNbPages();
        $this->AddPage();
        $this->body();
        $this->Output();
    }

    public function Header()
    {
        $this->SetY(10);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 6, utf8_decode('Ministerio de Salud y Protección Social'), 0, 1, 'C');

        $this->SetFont('Arial', '', 11);
        $this->Cell(0, 6, utf8_decode('Formulario para caracterización - Equipos Básicos de Salud'), 0, 1, 'C');

        $this->Ln(5);
    }

    public function body()
    {
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(220, 220, 220);
        $this->SetTextColor(0, 0, 0);

        $this->Cell(0, 4, utf8_decode('1. INFORMACIÓN GENERAL'), 1, 1, 'L', true);
        $this->Ln(2);

        $this->Cell(0, 4, utf8_decode('1.1 Datos generales del escenario del entorno que se caracteriza'), 1, 1, 'L', true);

        $this->SetFont('Arial', '', 8);

        $departamento = utf8_decode(self::$caracterizacionEcis->afiliado->departamento_residencia->nombre ?? 'N/A');
        $unidadZonal = utf8_decode(self::$caracterizacionEcis->unidad_zonal_planeacion_evaluacion ?? 'N/A');

        $this->Cell(25, 4, utf8_decode('1. Departamento'), 1, 0, 'L', true);
        $this->Cell(25, 4, $departamento, 1, 0, 'L');
        $this->Cell(90, 4, utf8_decode('2. Unidad Zonal de Planeación y Evaluación - Regional - Provincia'), 1, 0, 'L', true);
        $this->Cell(50, 4, $unidadZonal, 1, 1, 'L');

        $municipio = utf8_decode(self::$caracterizacionEcis->afiliado->municipio_residencia->nombre ?? 'N/A');

        $this->Cell(55, 4, utf8_decode('3. Municipio / Área no municipalizada'), 1, 0, 'L', true);
        $this->Cell(135, 4, $municipio, 1, 1, 'L');

        $territorio_nombre = utf8_decode(self::$caracterizacionEcis->territorio_nombre ?? 'N/A');
        $territorio_id = utf8_decode(self::$caracterizacionEcis->territorio_id ?? 'N/A');
        $territorio_serial = utf8_decode(self::$caracterizacionEcis->territorio_serial ?? 'N/A');

        $this->Cell(25, 4, utf8_decode('4. Territorio'), 1, 0, 'L', true);
        $this->Cell(65, 4, $territorio_nombre, 1, 0, 'L');
        $this->Cell(6, 4, utf8_decode('ID:'), 1, 0, 'L', true);
        $this->Cell(44, 4, $territorio_id, 1, 0, 'L');
        $this->Cell(10, 4, utf8_decode('Serial:'), 1, 0, 'L', true);
        $this->Cell(40, 4, $territorio_serial, 1, 1, 'L');

        $microterritorio_nombre = utf8_decode(self::$caracterizacionEcis->microterritorio_nombre ?? 'N/A');
        $microterritorio_id = utf8_decode(self::$caracterizacionEcis->microterritorio_id ?? 'N/A');
        $microterritorio_serial = utf8_decode(self::$caracterizacionEcis->microterritorio_serial ?? 'N/A');

        $this->Cell(25, 4, utf8_decode('5. Micro territorio'), 1, 0, 'L', true);
        $this->Cell(65, 4, $microterritorio_nombre, 1, 0, 'L');
        $this->Cell(6, 4, utf8_decode('ID:'), 1, 0, 'L', true);
        $this->Cell(44, 4, $microterritorio_id, 1, 0, 'L');
        $this->Cell(10, 4, utf8_decode('Serial:'), 1, 0, 'L', true);
        $this->Cell(40, 4, $microterritorio_serial, 1, 1, 'L');

        $zona_poblada = utf8_decode(self::$caracterizacionEcis->zona_poblada ?? 'N/A');

        $this->Cell(115, 4, utf8_decode('6. Corregimiento / Centro de poblado / Vereda / Localidad / Barrio / Resguardo Indígena'), 1, 0, 'L', true);
        $this->Cell(75, 4, $zona_poblada, 1, 1, 'L');

        $direccion = utf8_decode(self::$caracterizacionEcis->afiliado->direccion_residencia_barrio ?? 'N/A');
        $geopunto = utf8_decode(self::$caracterizacionEcis->geopunto ?? 'N/A');

        $this->Cell(30, 4, utf8_decode('7. Dirección'), 1, 0, 'L', true);
        $this->Cell(65, 4, $direccion, 1, 0, 'L');
        $this->Cell(65, 4, utf8_decode('8. Geopunto (online-offline) y altitud'), 1, 0, 'L', true);
        $this->Cell(30, 4, $geopunto, 1, 1, 'L');

        $ubicacion_referencia = utf8_decode(self::$caracterizacionEcis->afiliado->direccion_residencia_cargue ?? 'N/A');

        $this->Cell(190, 4, utf8_decode('9. Ubicación del hogar (cuando no se cuenta con nomenclatura, punto de referencia)'), 1, 1, 'L', true);

        $this->MultiCell(190, 4, $ubicacion_referencia, 1, 'L');

        $numero_familia = utf8_decode(self::$caracterizacionEcis->numero_identificacion_familia ?? 'N/A');
        $estrato = utf8_decode(self::$caracterizacionEcis->afiliado->estrato ?? 'N/A');

        $this->SetFillColor(220, 220, 220);

        $this->Cell(60, 4, utf8_decode('10. Número de Identificación de la familia'), 1, 0, 'L', true);
        $this->Cell(35, 4, $numero_familia, 1, 0, 'L');

        $this->Cell(65, 4, utf8_decode('11. Estrato socioeconómico de la vivienda'), 1, 0, 'L', true);
        $this->Cell(30, 4, $estrato, 1, 1, 'L');

        $num_hogares = utf8_decode(self::$caracterizacionEcis->numero_hogares_vivienda ?? 'N/A');
        $num_familias = utf8_decode(self::$caracterizacionEcis->numero_familias_vivienda ?? 'N/A');
        $num_personas = utf8_decode(self::$caracterizacionEcis->numero_personas_vivienda ?? 'N/A');

        $this->SetFillColor(220, 220, 220);

        $this->Cell(45, 4, utf8_decode('12. N° de hogares en la vivienda'), 1, 0, 'L', true);
        $this->Cell(18, 4, $num_hogares, 1, 0, 'L');

        $this->Cell(45, 4, utf8_decode('13. N° de familias en la vivienda'), 1, 0, 'L', true);
        $this->Cell(18, 4, $num_familias, 1, 0, 'L');

        $this->Cell(45, 4, utf8_decode('14. N° de personas en la vivienda'), 1, 0, 'L', true);
        $this->Cell(19, 4, $num_personas, 1, 1, 'L');

        $this->Ln(2);
        $this->SetFillColor(220, 220, 220);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(190, 4, utf8_decode('1.2. Identificación del encuestador'), 1, 1, 'L', true);

        $equipo_salud = utf8_decode(self::$caracterizacionEcis->numero_identificacion_ebs ?? 'N/A');
        $prestador_adscrito = utf8_decode(self::$caracterizacionEcis->prestador->nombre_prestador ?? 'N/A');
        $responsable_eval = utf8_decode(self::$caracterizacionEcis->responsable_evaluacion_necesidades ?? 'N/A');

        $this->SetFillColor(220, 220, 220);
        $this->SetFont('Arial', '', 8);

        $this->Cell(100, 4, utf8_decode('15. Número de identificación del Equipo Básico de Salud (EBS)'), 1, 0, 'L', true);
        $this->Cell(90, 4, $equipo_salud, 1, 1, 'L');

        $this->Cell(100, 4, utf8_decode('16. Prestador primario / Organismo de adscripción del EBS'), 1, 0, 'L', true);
        $this->Cell(90, 4, $prestador_adscrito, 1, 1, 'L');

        $this->Cell(100, 4, utf8_decode('17. Responsable de la evaluación de necesidades en salud - caracterización'), 1, 0, 'L', true);
        $this->Cell(90, 4, $responsable_eval, 1, 1, 'L');

        $perfil_evaluador = utf8_decode(self::$caracterizacionEcis->perfil_evaluacion_necesidades ?? 'N/A');

        $this->Cell(190, 4, utf8_decode('18. Perfil de quien realiza la evaluación de necesidades en salud - caracterización)'), 1, 1, 'L', true);

        $this->MultiCell(190, 4, $perfil_evaluador, 1, 'L');

        $codigo_ficha = utf8_decode(self::$caracterizacionEcis->codigo_ficha ?? 'N/A');
        $fecha_ficha = utf8_decode(self::$caracterizacionEcis->fecha_diligenciamiento_ficha ?? 'N/A');

        $this->SetFillColor(220, 220, 220);

        $this->Cell(40, 4, utf8_decode('19. Código de la ficha'), 1, 0, 'L', true);
        $this->Cell(55, 4, $codigo_ficha, 1, 0, 'L');

        $this->Cell(55, 4, utf8_decode('20. Fecha diligenciamiento de la ficha'), 1, 0, 'L', true);
        $this->Cell(40, 4, $fecha_ficha, 1, 1, 'L');

        $this->Ln(2);

        $this->SetFont('Arial', 'B', 8);
        $this->Cell(0, 4, utf8_decode('2. CARACTERIZACIÓN DE LA FAMILIA'), 1, 1, 'L', true);
        $this->Ln(2);

        $this->Cell(0, 4, utf8_decode('2.1 Estructura y contexto familiar'), 1, 1, 'L', true);


        $this->SetFont('Arial', '', 8);
        $tipo_familia = utf8_decode(self::$caracterizacionEcis->tipo_familia ?? 'N/A');

        $this->Cell(30, 4, utf8_decode('21. Tipo de familia'), 1, 0, 'L', true);
        $this->Cell(160, 4, $tipo_familia, 1, 1, 'L');

        $num_personas_familia = utf8_decode(self::$caracterizacionEcis->numero_personas_familia ?? 'N/A');
        $tipo_riesgo = utf8_decode(self::$caracterizacionEcis->tipo_riesgo ?? 'N/A');

        $this->Cell(70, 4, utf8_decode('22. Número de personas que conforman la familia'), 1, 0, 'L', true);
        $this->Cell(25, 4, $num_personas_familia, 1, 0, 'L');

        $this->Cell(65, 4, utf8_decode('23. Tipo de riesgo'), 1, 0, 'L', true);
        $this->Cell(30, 4, $tipo_riesgo, 1, 1, 'L');

        $observaciones_estructura_contexto_familiar = utf8_decode(self::$caracterizacionEcis->observaciones_estructura_contexto_familiar ?? 'N/A');

        $this->Cell(190, 4, utf8_decode('Observaciones'), 1, 1, 'L', true);

        $this->MultiCell(190, 4, $observaciones_estructura_contexto_familiar, 1, 'L');

        $apgar_familiar = utf8_decode(self::$caracterizacionEcis->funcionalidad_familia ?? 'N/A');
        $cuidador_identificado = utf8_decode(self::$caracterizacionEcis->cuidador_principal == true ? 'SI' : 'NO');
        $escala_zarit = utf8_decode(self::$caracterizacionEcis->escala_zarit ?? 'No Aplica');
        $interrelaciones_familia = utf8_decode(self::$caracterizacionEcis->interrelaciones_familia_sociocultural ?? 'N/A');

        $this->Cell(120, 4, utf8_decode('24. Funcionalidad de la familia (Apgar familiar)'), 1, 0, 'L', true);
        $this->Cell(70, 4, $apgar_familiar, 1, 1, 'L');

        $this->Cell(160, 4, utf8_decode('25. En la familia se identifica un cuidador principal de niños, niñas, persona con discapacidad, adulto mayor o enfermedad?'), 1, 0, 'L', true);
        $this->Cell(30, 4, $cuidador_identificado, 1, 1, 'L');

        $this->Cell(120, 4, utf8_decode('26. Si la respuesta anterior es SÍ, aplicar escala ZARIT y registrar el resultado'), 1, 0, 'L', true);
        $this->Cell(70, 4, $escala_zarit, 1, 1, 'L');

        $this->Cell(120, 4, utf8_decode('27. Interrelaciones de la familia con el contexto socio cultural (diligenciar ECOMAPA)'), 1, 0, 'L', true);
        $this->Cell(70, 4, $interrelaciones_familia, 1, 1, 'L');

        $this->Ln(2);

        $this->SetFont('Arial', 'B', 8);
        $this->Cell(0, 4, utf8_decode('2.2 Situaciones o condiciones de especial protección de la familia y sus integrantes'), 1, 1, 'L', true);

        $this->SetFont('Arial', '', 8);

        $familia_niñez = utf8_decode(self::$caracterizacionEcis->familia_ninos_adolescentes == true ? 'SI' : 'NO');
        $familia_gestante = utf8_decode(self::$caracterizacionEcis->gestante_familia == true ? 'SI' : 'NO');
        $familia_adultos = utf8_decode(self::$caracterizacionEcis->familia_adultos_mayores == true ? 'SI' : 'NO');
        $familia_victima = utf8_decode(self::$caracterizacionEcis->familia_victima_conflicto_armado == true ? 'SI' : 'NO');

        $familia_transmisibles = utf8_decode(self::$caracterizacionEcis->familia_convive_enfermedad_transmisible == true ? 'SI' : 'NO');

        $this->Cell(70, 4, utf8_decode('28. Familia con niñas, niños y adolescentes'), 1, 0, 'L', true);
        $this->Cell(25, 4, $familia_niñez, 1, 0, 'L');

        $this->Cell(65, 4, utf8_decode('29. Gestante en la familia'), 1, 0, 'L', true);
        $this->Cell(30, 4, $familia_gestante, 1, 1, 'L');

        $this->Cell(70, 4, utf8_decode('30. Familia con personas adultas mayores'), 1, 0, 'L', true);
        $this->Cell(25, 4, $familia_adultos, 1, 0, 'L');

        $this->Cell(65, 4, utf8_decode('31. Familia víctima del conflicto armado'), 1, 0, 'L', true);
        $this->Cell(30, 4, $familia_victima, 1, 1, 'L');

        $familia_discapacidad = utf8_decode(self::$caracterizacionEcis->familia_convive_discapacidad ? 'SI' : 'NO');
        $familia_cronica = utf8_decode(self::$caracterizacionEcis->familia_convive_enfermedad_cronica ? 'SI' : 'NO');

        $this->Cell(140, 4, utf8_decode('32. Familia que convive con personas con discapacidad'), 1, 0, 'L', true);
        $this->Cell(50, 4, $familia_discapacidad, 1, 1, 'L');

        $this->Cell(140, 4, utf8_decode('33. Familia que convive con personas con enfermedad crónica, huérfana o en estado terminal'), 1, 0, 'L', true);
        $this->Cell(50, 4, $familia_cronica, 1, 1, 'L');

        $this->Cell(140, 4, utf8_decode('34. Familia que convive con personas que presentan alguna enfermedad transmisible'), 1, 0, 'L', true);
        $this->Cell(50, 4, $familia_transmisibles, 1, 1, 'L');

        $antecedentes = self::$caracterizacionEcis->familia_antecedentes_enfermedades;

        $sucesos_vitales = utf8_decode(self::$caracterizacionEcis->familia_vivencia_sucesos_vitales ? 'SI' : 'NO');
        $vulnerabilidad = utf8_decode(self::$caracterizacionEcis->familia_sitacion_vulnerabilidad_social ? 'SI' : 'NO');
        $cuidados_criticos = utf8_decode(self::$caracterizacionEcis->familia_practicas_cuidado_salud ? 'SI' : 'NO');
        $antecedentes_familia_enfermedades = utf8_decode($antecedentes ? 'SI' : 'NO');

        $this->Cell(140, 4, utf8_decode('35. Familia con vivencia de sucesos vitales normativos y no normativos'), 1, 0, 'L', true);
        $this->Cell(50, 4, $sucesos_vitales, 1, 1, 'L');

        $this->Cell(140, 4, utf8_decode('36. Familia en situación de vulnerabilidad social'), 1, 0, 'L', true);
        $this->Cell(50, 4, $vulnerabilidad, 1, 1, 'L');

        $this->Cell(140, 4, utf8_decode('37. Familias con prácticas de cuidado de salud críticas'), 1, 0, 'L', true);
        $this->Cell(50, 4, $cuidados_criticos, 1, 1, 'L');

        $this->Cell(140, 4, utf8_decode('38. Familia con integrantes con antecedentes de Ca, HTA, Diabetes, etc.'), 1, 0, 'L', true);
        $this->Cell(50, 4, $antecedentes_familia_enfermedades, 1, 1, 'L');

        if ($antecedentes) {
            $descripcion = utf8_decode(self::$caracterizacionEcis->familia_antecedentes_enfermedades_descripcion ?? 'No especificado');
            $tratamiento = self::$caracterizacionEcis->familia_antecedentes_enfermedades_tratamiento ? 'SI' : 'NO';
        } else {
            $descripcion = 'No aplica';
            $tratamiento = 'No aplica';
        }

        $this->Cell(190, 4, utf8_decode('38.2. Si la respuesta es sí, indique cuáles'), 1, 1, 'L', true);
        $this->MultiCell(190, 4, utf8_decode($descripcion), 1, 'L');

        $this->Cell(50, 4, utf8_decode('38.3. Recibe tratamiento'), 1, 0, 'L', true);
        $this->Cell(140, 4, utf8_decode($tratamiento), 1, 1, 'L');

        $obtencion_alimentos = utf8_decode(self::$caracterizacionEcis->obtencion_alimentos ?? 'No aplica');
        $obtencion_alimentos_otro = utf8_decode(self::$caracterizacionEcis->obtencion_alimentos === 'Otro' ? self::$caracterizacionEcis->obtencion_alimentos_descripcion : 'No aplica');

        $this->Cell(50, 4, utf8_decode('39. ¿Como obtiene sus alimentos?'), 1, 0, 'L', true);
        $this->Cell(140, 4, utf8_decode($obtencion_alimentos), 1, 1, 'L');

        $this->Cell(190, 4, utf8_decode('39.2. ¿Cúal?'), 1, 1, 'L', true);
        $this->MultiCell(190, 4, utf8_decode($obtencion_alimentos_otro), 1, 'L');

        $this->ln(2);

        $this->SetFont('Arial', 'B', 8);
        $this->Cell(0, 4, utf8_decode('2.3 Prácticas o condiciones protectoras para el cuidado de la salud predominantes en la familia'), 1, 1, 'L', true);

        $this->SetFont('Arial', '', 8);

        $habitos_vida_saludable = utf8_decode(self::$caracterizacionEcis->habitos_vida_saludable ? 'SI' : 'NO');

        $this->Cell(150, 4, utf8_decode('40. Hábitos de vida saludable adaptado a las condiciones contextuales y culturales de la familia y sus integrantes'), 1, 0, 'L', true);
        $this->Cell(40, 4, $habitos_vida_saludable, 1, 1, 'L');

        $recursos_socioemocionales = utf8_decode(self::$caracterizacionEcis->recursos_socioemocionales ? 'SI' : 'NO');

        $this->Cell(150, 4, utf8_decode('41. Recursos socioemocionales que potencian el cuidado de la salud de la familia'), 1, 0, 'L', true);
        $this->Cell(40, 4, $recursos_socioemocionales, 1, 1, 'L');

        $practicas_cuidado_proteccion = utf8_decode(self::$caracterizacionEcis->practicas_cuidado_proteccion ? 'SI' : 'NO');

        $this->Cell(150, 4, utf8_decode('42. Prácticas para el cuidado y protección de los entornos'), 1, 0, 'L', true);
        $this->Cell(40, 4, $practicas_cuidado_proteccion, 1, 1, 'L');

        $practicas_establecimiento_relaciones = utf8_decode(self::$caracterizacionEcis->practicas_establecimiento_relaciones ? 'SI' : 'NO');

        $this->Cell(150, 4, utf8_decode('43. Prácticas que favorecen el estabecimiento de relaciones sanas y constructivas'), 1, 0, 'L', true);
        $this->Cell(40, 4, $practicas_establecimiento_relaciones, 1, 1, 'L');

        $recursos_sociales_comunitarios = utf8_decode(self::$caracterizacionEcis->recursos_sociales_comunitarios ? 'SI' : 'NO');

        $this->Cell(150, 4, utf8_decode('44. Recursos sociales y comunitarios para el establecimiento de redes colectivas para la promoción de la salud'), 1, 0, 'L', true);
        $this->Cell(40, 4, $recursos_sociales_comunitarios, 1, 1, 'L');

        $practicas_autonomia_capacidad_funcional = utf8_decode(self::$caracterizacionEcis->practicas_autonomia_capacidad_funcional ? 'SI' : 'NO');

        $this->Cell(150, 4, utf8_decode('45. Prácticas para la conservación de la autonomía y la capacidad funcional de las personas mayores'), 1, 0, 'L', true);
        $this->Cell(40, 4, $practicas_autonomia_capacidad_funcional, 1, 1, 'L');

        $practicas_prevencion_enfermedades = utf8_decode(self::$caracterizacionEcis->practicas_prevencion_enfermedades ? 'SI' : 'NO');

        $this->Cell(150, 4, utf8_decode('46. Prácticas para la prevención de enfermedades en todas las edades'), 1, 0, 'L', true);
        $this->Cell(40, 4, $practicas_prevencion_enfermedades, 1, 1, 'L');

        $practicas_cuidado_saberes_ancestrales = utf8_decode(self::$caracterizacionEcis->practicas_cuidado_saberes_ancestrales ? 'SI' : 'NO');

        $this->Cell(150, 4, utf8_decode('47. Prácticas de cuidado desde los saberes ancetrales/tradicionales'), 1, 0, 'L', true);
        $this->Cell(40, 4, $practicas_cuidado_saberes_ancestrales, 1, 1, 'L');

        $capacidades_ejercicio_derecho_salud = utf8_decode(self::$caracterizacionEcis->capacidades_ejercicio_derecho_salud ? 'SI' : 'NO');

        $this->Cell(150, 4, utf8_decode('48. Capacidades de las familias para el ejercicio y exigibilidad del derecho a la salud'), 1, 0, 'L', true);
        $this->Cell(40, 4, $capacidades_ejercicio_derecho_salud, 1, 1, 'L');

        $this->Ln(2);

        $this->SetFont('Arial', 'B', 8);
        $this->Cell(0, 4, utf8_decode('3. CARACTERIZACIÓN DE LOS INTEGRANTES DE LA FAMILIA'), 1, 1, 'L', true);
        $this->Ln(2);

        $this->Cell(0, 4, utf8_decode('3.1 Identificación de cada uno de los integrantes'), 1, 1, 'L', true);

        $integrantes = self::$caracterizacionEcis->afiliado->integrantesFamilia ?? [];

        foreach ($integrantes as $index => $integrante) {
            $this->SetFont('Arial', '', 8);
            $primer_nombre = utf8_decode($integrante->primer_nombre ?? 'N/A');
            $segundo_nombre = utf8_decode($integrante->segundo_nombre ?? 'N/A');
            $primer_apellido = utf8_decode($integrante->primer_apellido ?? 'N/A');
            $segundo_apellido = utf8_decode($integrante->segundo_apellido ?? 'N/A');


            $this->Cell(30, 4, utf8_decode('49. Primer nombre'), 1, 0, 'L', true);
            $this->Cell(65, 4, $primer_nombre, 1, 0, 'L');

            $this->Cell(30, 4, utf8_decode('50. Segundo nombre'), 1, 0, 'L', true);
            $this->Cell(65, 4, $segundo_nombre, 1, 1, 'L');

            $this->Cell(30, 4, utf8_decode('51. Primer apellido'), 1, 0, 'L', true);
            $this->Cell(65, 4, $primer_apellido, 1, 0, 'L');

            $this->Cell(30, 4, utf8_decode('52. Segundo apellido'), 1, 0, 'L', true);
            $this->Cell(65, 4, $segundo_apellido, 1, 1, 'L');

            $tipo_identificacion = utf8_decode($integrante->tipo_documento->sigla ?? 'N/A');
            $numero_identificacion = utf8_decode($integrante->numero_documento ?? 'N/A');
            $fecha_nacimiento = utf8_decode($integrante->fecha_nacimiento ?? 'N/A');

            $this->Cell(40, 4, utf8_decode('53. Tipo de identificación'), 1, 0, 'L', true);
            $this->Cell(10, 4, $tipo_identificacion, 1, 0, 'L');

            $this->Cell(45, 4, utf8_decode('54. Número de identificación'), 1, 0, 'L', true);
            $this->Cell(30, 4, $numero_identificacion, 1, 0, 'L');

            $this->Cell(35, 4, utf8_decode('55. Fecha de nacimiento'), 1, 0, 'L', true);
            $this->Cell(30, 4, $fecha_nacimiento, 1, 1, 'L');

            $sexo = utf8_decode($integrante->sexo ?? 'N/A');

            $rol_familia = $integrante->rol_familia === 'Otro'
                ? utf8_decode($integrante->rol_familia_otro ?? 'No especificado')
                : utf8_decode($integrante->rol_familia ?? 'N/A');

            $this->Cell(40, 4, utf8_decode('56. Sexo'), 1, 0, 'L', true);
            $this->Cell(55, 4, $sexo, 1, 0, 'L');

            $this->Cell(50, 4, utf8_decode('57. Rol dentro de la familia'), 1, 0, 'L', true);
            $this->Cell(45, 4, $rol_familia, 1, 1, 'L');

            $ocupacion = utf8_decode($integrante->ocupacion ?? 'N/A');

            $this->Cell(40, 4, utf8_decode('58. Ocupación'), 1, 0, 'L', true);
            $this->Cell(150, 4, $ocupacion, 1, 1, 'L');

            $nivel_educativo = utf8_decode($integrante->nivel_educativo ?? 'N/A');
            $regimen_afiliacion = utf8_decode($integrante->tipo_afiliacion->nombre ?? 'N/A');
            $eapb = utf8_decode($integrante->entidad->nombre ?? 'N/A');

            $this->Cell(40, 4, utf8_decode('59. Nivel educativo'), 1, 0, 'L', true);
            $this->Cell(65, 4, $nivel_educativo, 1, 0, 'L');

            $this->Cell(40, 4, utf8_decode('60. Régimen de afiliación'), 1, 0, 'L', true);
            $this->Cell(45, 4, $regimen_afiliacion, 1, 1, 'L');

            $this->Cell(40, 4, utf8_decode('61. EAPB'), 1, 0, 'L', true);
            $this->Cell(150, 4, $eapb, 1, 1, 'L');

            $grupo_proteccion = utf8_decode($integrante->grupo_especial_proteccion ?? 'N/A');

            $this->Cell(100, 4, utf8_decode('62. Pertenencia a un grupo poblacional de especial protección'), 1, 0, 'L', true);
            $this->Cell(90, 4, $grupo_proteccion, 1, 1, 'L');

            $pertenencia_etnica = utf8_decode($integrante->pertenencia_etnica ?? 'N/A');
            $comunidad_indigena = utf8_decode($integrante->comunidad_pueblo_indigena ?? 'N/A');

            $this->Cell(40, 4, utf8_decode('63. Pertenencia étnica'), 1, 0, 'L', true);
            $this->Cell(50, 4, $pertenencia_etnica, 1, 0, 'L');

            $this->Cell(55, 4, utf8_decode('64. Comunidad o pueblo indígena'), 1, 0, 'L', true);
            $this->Cell(45, 4, $comunidad_indigena, 1, 1, 'L');

            $discapacidad = utf8_decode($integrante->discapacidad ?? 'N/A');
            $salud_cronica = utf8_decode($integrante->condiciones_salud_cronica == true ? 'SI' : 'NO');

            $this->Cell(80, 4, utf8_decode('65. ¿Reconoce alguna discapacidad?'), 1, 0, 'L', true);
            $this->Cell(110, 4, $discapacidad, 1, 1, 'L');

            $this->Cell(150, 4, utf8_decode('66. El integrante de la familia presenta situaciones o condiciones de salud crónica'), 1, 0, 'L', true);
            $this->Cell(40, 4, $salud_cronica, 1, 1, 'L');

            $this->Ln(2);
        }

        $this->SetFont('Arial', 'B', 8);

        $this->Cell(0, 4, utf8_decode('3.2 Situaciones o condiciones de salud'), 1, 1, 'L', true);

        $this->SetFont('Arial', '', 8);

        $cumple_esquema_atenciones = utf8_decode(self::$caracterizacionEcis->cumple_esquema_atenciones ? 'SI' : 'NO');

        $this->Cell(180, 4, utf8_decode('67. Cumple con el esquema de atenciones de promoción y mantenimiento para el momento de curso de vida o para la gestación'), 1, 0, 'L', true);
        $this->Cell(10, 4, $cumple_esquema_atenciones, 1, 1, 'L');

        $intervenciones_array = json_decode(self::$caracterizacionEcis->intervenciones_pendientes ?? '[]', true);

        $intervenciones_pendientes = empty($intervenciones_array)
            ? utf8_decode('No aplica')
            : utf8_decode(implode(' | ', $intervenciones_array)); // Separador más claro si hay comas internas

        $this->Cell(190, 4, utf8_decode('68. Intervenciones pendientes de promoción y mantenimiento de la salud'), 1, 1, 'L', true);
        $this->MultiCell(190, 4, $intervenciones_pendientes, 1, 'L');


        $motivos_no_atencion = utf8_decode(self::$caracterizacionEcis->motivos_no_atencion ?? 'N/A');

        $this->Cell(120, 4, utf8_decode('69. Motivo por el cual no ha recibido las atenciones de promoción y mantenimiento de la salud'), 1, 0, 'L', true);
        $this->Cell(70, 4, $motivos_no_atencion, 1, 1, 'L');

        $practica_deporte = utf8_decode(self::$caracterizacionEcis->practica_deportiva ? 'SI' : 'NO');
        $lactancia_6m = utf8_decode(self::$caracterizacionEcis->recibe_lactancia ? 'SI' : 'NO');
        $lactancia_meses = utf8_decode(self::$caracterizacionEcis->recibe_lactancia_meses ?? 'N/A');
        $es_menor_5 = utf8_decode(self::$caracterizacionEcis->es_menor_cinco_anios ? 'SI' : 'NO');

        $this->Cell(80, 4, utf8_decode('70. ¿Realiza alguna práctica deportiva o realiza ejercicio?'), 1, 0, 'L', true);
        $this->Cell(10, 4, $practica_deporte, 1, 0, 'L');

        $this->Cell(90, 4, utf8_decode('71. Si es menor de 6 meses, ¿recibe lactancia materna exclusiva?'), 1, 0, 'L', true);
        $this->Cell(10, 4, $lactancia_6m, 1, 1, 'L');

        $this->Cell(120, 4, utf8_decode('72. Si es menor de 2 años, ¿hasta cuándo recibió lactancia materna? (en meses)'), 1, 0, 'L', true);
        $this->Cell(10, 4, $lactancia_meses, 1, 0, 'L');

        $this->Cell(50, 4, utf8_decode('73. ¿Es menor de 5 años?'), 1, 0, 'L', true);
        $this->Cell(10, 4, $es_menor_5, 1, 1, 'L');

        $peso = utf8_decode(self::$caracterizacionEcis->medidas_antropometricas_peso ?? 'N/A');
        $talla = utf8_decode(self::$caracterizacionEcis->tallmedidas_antropometricas_talla ?? 'N/A');

        $this->Cell(40, 4, utf8_decode('74.1. Peso (kg)'), 1, 0, 'L', true);
        $this->Cell(55, 4, $peso, 1, 0, 'L');

        $this->Cell(40, 4, utf8_decode('74.2. Talla (cm)'), 1, 0, 'L', true);
        $this->Cell(55, 4, $talla, 1, 1, 'L');

        $diagnostico_nutricional = utf8_decode(self::$caracterizacionEcis->diagnostico_nutricional ?? 'N/A');

        $this->Cell(80, 4, utf8_decode('75. Diagnóstico nutricional indicador Peso para la talla'), 1, 0, 'L', true);
        $this->Cell(110, 4, $diagnostico_nutricional, 1, 1, 'L');

        $perimetro_braquial = utf8_decode(self::$caracterizacionEcis->medida_complementaria_riesgo_desnutricion ?? 'N/A');

        $this->Cell(140, 4, utf8_decode('76. Medida complementaria identificación de riesgo de muerte por desnutrición aguda, Perímetro Braquial'), 1, 0, 'L', true);
        $this->Cell(50, 4, $perimetro_braquial, 1, 1, 'L');

        $signos_desnutricion = utf8_decode(self::$caracterizacionEcis->signos_fisicos_desnutricion ? 'SI' : 'NO');

        $this->Cell(140, 4, utf8_decode('77. Se identifican signos físicos de desnutrición aguda'), 1, 0, 'L', true);
        $this->Cell(50, 4, $signos_desnutricion, 1, 1, 'L');

        $enfermedad_reciente = self::$caracterizacionEcis->enfermedades_alergias;
        $enfermedad_reciente_str = utf8_decode($enfermedad_reciente ? 'SI' : 'NO');

        $this->Cell(180, 4, utf8_decode('78. ¿Actualmente presenta o ha presentado en el último mes alguna enfermedad como: diarrea, gripa, alergias, accidente doméstico, etc.?'), 1, 0, 'L', true);
        $this->Cell(10, 4, $enfermedad_reciente_str, 1, 1, 'L');

        $enfermedades_cuales = $enfermedad_reciente
            ? utf8_decode(self::$caracterizacionEcis->enfermedades_alergias_cuales ?? 'No especificado')
            : 'No aplica';

        $tratamiento = $enfermedad_reciente
            ? (self::$caracterizacionEcis->tratamiento_actual ? 'SI' : 'NO')
            : 'No aplica';

        $this->Cell(30, 4, utf8_decode('78.2. ¿Cuáles?'), 1, 0, 'L', true);
        $this->Cell(40, 4, $enfermedades_cuales, 1, 0, 'L');

        $this->Cell(100, 4, utf8_decode('79. ¿Está recibiendo atencion y tratamiento para la enfermedad actual?'), 1, 0, 'L', true);
        $this->Cell(20, 4, utf8_decode($tratamiento), 1, 1, 'L');

        $tratamiento_actual = self::$caracterizacionEcis->tratamiento_actual;
        $motivo_no_atencion = !$tratamiento_actual
            ? utf8_decode(self::$caracterizacionEcis->motivo_no_atencion_enfermedad ?? 'No especificado')
            : 'No aplica';

        $this->Cell(190, 4, utf8_decode('80. Si la respuesta a la pregunta anterior es NO, marque el motivo por el cual no ha recibido la atención'), 1, 1, 'L', true);
        $this->Cell(190, 4, $motivo_no_atencion, 1, 1, 'L');

        $poblacion_etnica_acompanado = utf8_decode(self::$caracterizacionEcis->pertenece_poblacion_etnica == true ? 'SI' : 'NO');

        $this->Cell(170, 4, utf8_decode('81. Si pertenece a población étnica. ¿Actualmente es acompañado u orientado por algun agente de la medicina tradicional?'), 1, 0, 'L', true);
        $this->Cell(20, 4, utf8_decode($poblacion_etnica_acompanado), 1, 1, 'L');

        $this->Ln(2);

        $this->SetFont('Arial', 'B', 8);
        $this->Cell(0, 4, utf8_decode('4. CARACTERIZACIÓN DEL ENTORNO'), 1, 1, 'L', true);
        $this->Ln(2);

        $this->Cell(0, 4, utf8_decode('4.1 Características y condiciones del entorno y de la vivienda'), 1, 1, 'L', true);

        $this->SetFont('Arial', '', 8);

        $tipo_vivienda = utf8_decode(self::$caracterizacionEcis->tipo_vivienda ?? 'N/A');
        $tipo_vivienda_otro = ($tipo_vivienda === 'Otro')
            ? utf8_decode(self::$caracterizacionEcis->tipo_vivienda_otro ?? 'No especificado')
            : 'No aplica';

        $this->Cell(40, 4, utf8_decode('82. Tipo de vivienda'), 1, 0, 'L', true);
        $this->Cell(150, 4, $tipo_vivienda, 1, 1, 'L');

        $this->Cell(40, 4, utf8_decode('82.2. ¿Cuál?'), 1, 0, 'L', true);
        $this->Cell(150, 4, $tipo_vivienda_otro, 1, 1, 'L');

        $material_paredes = utf8_decode(self::$caracterizacionEcis->material_paredes ?? 'N/A');
        $material_paredes_otro = ($material_paredes === 'Otro')
            ? utf8_decode(self::$caracterizacionEcis->material_paredes_otro ?? 'No especificado')
            : 'No aplica';

        $this->Cell(80, 4, utf8_decode('83. ¿Cuál es el material predominante de las paredes?'), 1, 0, 'L', true);
        $this->Cell(110, 4, $material_paredes, 1, 1, 'L');

        $this->Cell(80, 4, utf8_decode('83.2. ¿Cuál?'), 1, 0, 'L', true);
        $this->Cell(110, 4, $material_paredes_otro, 1, 1, 'L');

        $material_piso = utf8_decode(self::$caracterizacionEcis->material_piso ?? 'N/A');
        $material_piso_otro = ($material_piso === 'Otro')
            ? utf8_decode(self::$caracterizacionEcis->material_piso_otro ?? 'No especificado')
            : 'No aplica';

        $this->Cell(80, 4, utf8_decode('84. ¿Cuál es el material predominante del piso de la vivienda?'), 1, 0, 'L', true);
        $this->Cell(110, 4, $material_piso, 1, 1, 'L');

        $this->Cell(80, 4, utf8_decode('84.2. ¿Cuál?'), 1, 0, 'L', true);
        $this->Cell(110, 4, $material_piso_otro, 1, 1, 'L');

        $material_techo = utf8_decode(self::$caracterizacionEcis->material_techo ?? 'N/A');
        $material_techo_otro = ($material_techo === 'Otro')
            ? utf8_decode(self::$caracterizacionEcis->material_techo_otro ?? 'No especificado')
            : 'No aplica';

        $this->Cell(80, 4, utf8_decode('85. ¿Cuál es el material predominante del techo?'), 1, 0, 'L', true);
        $this->Cell(110, 4, $material_techo, 1, 1, 'L');

        $this->Cell(80, 4, utf8_decode('85.2. ¿Cuál?'), 1, 0, 'L', true);
        $this->Cell(110, 4, $material_techo_otro, 1, 1, 'L');

        $cuartos_dormitorio = utf8_decode(self::$caracterizacionEcis->cuartos_dormitorio ?? 'N/A');
        $hacinamiento = utf8_decode(self::$caracterizacionEcis->hacinamiento ? 'SI' : 'NO');

        $this->Cell(110, 4, utf8_decode('86. ¿De cuántos cuartos o piezas dormitorio dispone esta vivienda?'), 1, 0, 'L', true);
        $this->Cell(20, 4, $cuartos_dormitorio, 1, 0, 'L');

        $this->Cell(40, 4, utf8_decode('87. Hacinamiento'), 1, 0, 'L', true);
        $this->Cell(20, 4, $hacinamiento, 1, 1, 'L');

        $escenarios_riesgo_raw = self::$caracterizacionEcis->escenarios_riesgo;
        $riesgos_accidente_array = [];

        if (!empty($escenarios_riesgo_raw)) {
            $riesgos_accidente_array = json_decode($escenarios_riesgo_raw, true) ?? [];
        }

        $riesgos_accidente_str = !empty($riesgos_accidente_array)
            ? utf8_decode(implode(' | ', $riesgos_accidente_array))
            : utf8_decode('No aplica');

        $this->Cell(190, 4, utf8_decode('88. Escenarios de riesgo de accidente en la vivienda'), 1, 1, 'L', true);
        $this->MultiCell(190, 4, $riesgos_accidente_str, 1, 'L');

        $acceso_vivienda = utf8_decode(self::$caracterizacionEcis->acceder_facilmente ?? 'N/A');

        $this->Cell(190, 4, utf8_decode('89. Desde la vivienda se puede acceder fácilmente a:'), 1, 1, 'L', true);
        $this->MultiCell(190, 4, $acceso_vivienda, 1, 'L');

        $fuente_energia_cocinar = utf8_decode(self::$caracterizacionEcis->fuente_energia_cocinar ?? 'N/A');
        $fuente_energia_cocinar_otro = ($fuente_energia_cocinar === 'Otro')
            ? utf8_decode(self::$caracterizacionEcis->fuente_energia_cocinar_otro ?? 'No especificado')
            : 'No aplica';

        $this->Cell(110, 4, utf8_decode('90. ¿Cuál es la fuente de energía o combustible que se usa para cocinar?'), 1, 0, 'L', true);
        $this->Cell(80, 4, $fuente_energia_cocinar, 1, 1, 'L');

        $this->Cell(80, 4, utf8_decode('90.2. ¿Cuál?'), 1, 0, 'L', true);
        $this->Cell(110, 4, $fuente_energia_cocinar_otro, 1, 1, 'L');

        $criaderos_transmisores_enfermedades = utf8_decode(self::$caracterizacionEcis->criaderos_transmisores_enfermedades ? 'SI' : 'NO');
        $criaderos_transmisores_enfermedades_cuales = utf8_decode(self::$caracterizacionEcis->criaderos_cuales ?? 'No aplica');

        $this->MultiCell(190, 4, utf8_decode('91. ¿Se observa cerca de la vivienda o dentro de ellas criaderos o reservorios que pueden favorecer la presencia de vectores transmisores de enfermedades?'), 1, 'L', true);
        $this->Cell(190, 4, $criaderos_transmisores_enfermedades, 1, 1, 'L');

        $this->Cell(190, 4, utf8_decode('91.2. ¿Cuál(es)?'), 1, 1, 'L', true);
        $this->Cell(190, 4, $criaderos_transmisores_enfermedades_cuales, 1, 1, 'L');

        $this->Ln(2);

        $this->SetFont('Arial', 'B', 8);
        $this->Cell(0, 4, utf8_decode('4.2 Oficios u ocupaciones que se desarrollan en la vivienda o en su entorno inmediato (peri domicilio)'), 1, 1, 'L', true);

        $this->SetFont('Arial', '', 8);

        $factores_array = json_decode(self::$caracterizacionEcis->factores_entorno_vivienda ?? '[]', true);
        $factores_entorno_vivienda = empty($factores_array)
            ? 'No aplica'
            : utf8_decode(implode(' | ', $factores_array));

        $factores_entorno_otro = utf8_decode(self::$caracterizacionEcis->factores_entorno_vivienda_otro ?? 'No aplica');

        $this->SetFillColor(220, 220, 220);
        $this->MultiCell(190, 4, utf8_decode('92. Observe si cerca de la vivienda hay alguno de los siguientes:'), 1, 'L', true);

        $this->SetFillColor(255, 255, 255);
        $this->MultiCell(190, 4, $factores_entorno_vivienda, 1, 'L');

        $this->SetFillColor(220, 220, 220);
        $this->Cell(190, 4, utf8_decode('92.2. Especifique'), 1, 1, 'L', true);

        $this->SetFillColor(255, 255, 255);
        $this->MultiCell(190, 4, $factores_entorno_otro, 1, 'L');

        $vivienda_realiza_actividad_economica = utf8_decode(self::$caracterizacionEcis->vivienda_realiza_actividad_economica ? 'SI' : 'NO');

        $this->SetFillColor(220, 220, 220);

        $this->Cell(170, 4, utf8_decode('93. ¿Al interior de la vivienda se realiza alguna actividad económica?'), 1, 0, 'L', true);
        $this->Cell(20, 4, $vivienda_realiza_actividad_economica, 1, 1, 'L');

        $animales_conviven_str = utf8_decode(self::$caracterizacionEcis->animales_conviven ?? 'No aplica');

        $this->SetFillColor(220, 220, 220);
        $this->MultiCell(190, 4, utf8_decode('94. Señale los animales que conviven con la familia dentro de la vivienda o en su entorno inmediato, e indique cuántos son:'), 1, 'L', true);

        $this->SetFillColor(255, 255, 255);
        $this->MultiCell(190, 4, $animales_conviven_str, 1, 'L');

        $animal_otro = utf8_decode(self::$caracterizacionEcis->animales_conviven_otro ?? 'No aplica');
        $this->SetFillColor(220, 220, 220);
        $this->Cell(30, 4, utf8_decode('94.2. ¿Cuál?'), 1, 0, 'L', true);
        $this->SetFillColor(255, 255, 255);
        $this->Cell(160, 4, $animal_otro, 1, 1, 'L');

        $cantidad_animales_raw = self::$caracterizacionEcis->animales_conviven_cantidad ?? 'N/A';
        $cantidad_animales = utf8_decode(trim((string) $cantidad_animales_raw));

        $this->SetFillColor(220, 220, 220);
        $this->Cell(50, 4, utf8_decode('94.3. Registrar cantidad'), 1, 0, 'L', true);
        $this->SetFillColor(255, 255, 255);
        $this->Cell(140, 4, $cantidad_animales, 1, 1, 'L');

        $this->Ln(2);

        $this->SetFillColor(220, 220, 220);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(0, 4, utf8_decode('4.3 Agua y saneamiento básico'), 1, 1, 'L', true);

        $this->SetFont('Arial', '', 8);

        $fuente_agua = utf8_decode(self::$caracterizacionEcis->fuente_agua ?? 'No aplica');
        $fuente_agua_otro = ($fuente_agua === 'Otro')
            ? utf8_decode(self::$caracterizacionEcis->fuente_agua_otro ?? 'No especificado')
            : 'No aplica';

        $this->Cell(130, 4, utf8_decode('95. ¿Cuál es la pricipal fuente de de abastecimiento de agua para consumo humano en la vivienda?'), 1, 0, 'L', true);
        $this->Cell(60, 4, $fuente_agua, 1, 1, 'L');

        $this->Cell(80, 4, utf8_decode('95.2. ¿Cuál?'), 1, 0, 'L', true);
        $this->Cell(110, 4, $fuente_agua_otro, 1, 1, 'L');

        $sistema_disposicion_excretas = utf8_decode(self::$caracterizacionEcis->sistema_disposicion_excretas ?? 'No aplica');
        $sistema_disposicion_excretas_otro = ($sistema_disposicion_excretas === 'Otro')
            ? utf8_decode(self::$caracterizacionEcis->sistema_disposicion_excretas_otro ?? 'No especificado')
            : 'No aplica';

        $this->Cell(130, 4, utf8_decode('96. ¿Cuál es el sistema de disposición de excretas en la vivienda?'), 1, 0, 'L', true);
        $this->Cell(60, 4, $sistema_disposicion_excretas, 1, 1, 'L');

        $this->Cell(80, 4, utf8_decode('96.2. ¿Cuál?'), 1, 0, 'L', true);
        $this->Cell(110, 4, $sistema_disposicion_excretas_otro, 1, 1, 'L');

        $sistema_disposicion_aguas_residuales = utf8_decode(self::$caracterizacionEcis->sistema_disposicion_aguas_residuales ?? 'No aplica');
        $sistema_disposicion_aguas_residuales_otro = ($sistema_disposicion_aguas_residuales === 'Otro')
            ? utf8_decode(self::$caracterizacionEcis->sistema_disposicion_aguas_residuales_otro ?? 'No especificado')
            : 'No aplica';

        $this->Cell(130, 4, utf8_decode('97. ¿Cuál es el sistema de disposición de aguas residuales en la vivienda?'), 1, 0, 'L', true);
        $this->Cell(60, 4, $sistema_disposicion_aguas_residuales, 1, 1, 'L');

        $this->Cell(80, 4, utf8_decode('97.2. ¿Cuál?'), 1, 0, 'L', true);
        $this->Cell(110, 4, $sistema_disposicion_aguas_residuales_otro, 1, 1, 'L');

        $sistema_disposicion_residuos = utf8_decode(self::$caracterizacionEcis->sistema_disposicion_residuos ?? 'No aplica');
        $sistema_disposicion_residuos_otro = ($sistema_disposicion_residuos === 'Otro')
            ? utf8_decode(self::$caracterizacionEcis->sistema_disposicion_residuos_otro ?? 'No especificado')
            : 'No aplica';

        $this->Cell(110, 4, utf8_decode('98. ¿Como se realiza la disposición final de los residuos ordinarios de la vivienda?'), 1, 0, 'L', true);
        $this->Cell(80, 4, $sistema_disposicion_residuos, 1, 1, 'L');

        $this->Cell(80, 4, utf8_decode('98.2. ¿Cuál?'), 1, 0, 'L', true);
        $this->Cell(110, 4, $sistema_disposicion_residuos_otro, 1, 1, 'L');
    }


}
