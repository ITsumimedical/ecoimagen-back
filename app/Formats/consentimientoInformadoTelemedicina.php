<?php

namespace App\Formats;

use App\Http\Modules\Consultas\Models\Consulta;
use App\Traits\PdfTrait;
use Codedge\Fpdf\Fpdf\Fpdf;


class consentimientoInformadoTelemedicina extends FPDF
{
    use PdfTrait;

    public static $data;
    public static $consulta;
    public static $fechaHoy;
    public static $medicoAtendio;

    public function generar($consentimiento)
    {
        self::$consulta = $consentimiento;
        $this->generarPDF('I');
    }

    function MultiCellBlt($w, $h, $blt, $txt, $border = 0, $align = 'J', $fill = false)
    {
        $blt_width = $this->GetStringWidth($blt) + $this->cMargin * 2;
        $bak_x = $this->x;
        $this->Cell($blt_width, $h, $blt, 0, '', $fill);
        $this->MultiCell($w - $blt_width, $h, $txt, $border, $align, $fill);
        $this->x = $bak_x;
    }

    public function header()
    {
        $this->SetFont('Arial', 'B', 11);

        $this->Line(20, 5, 190, 5);
        $this->Line(20, 35, 190, 35);
        $this->Line(20, 5, 20, 35);
        $this->Line(190, 5, 190, 35);

        // $logo = public_path() . "/logoFomag.png";
        $logo = public_path('images/logoEcoimagen.png');
        $this->Image($logo, 24, 7, -240);
        $this->SetXY(73, 15);
        $this->Cell(68, 5, 'CONSENTIMIENTO INFORMADO', 0, 0, 'C', 0);
        $this->Ln();
        $this->SetXY(73, 20);
        $this->Cell(68, 5, utf8_decode('PARA ATENCIÓN BAJO'), 0, 0, 'C', 0);
        $this->Ln();
        $this->SetXY(73, 25);
        $this->Cell(68, 5, 'LA MODALIDAD DE TELEMEDICINA', 0, 0, 'C', 0);

        // $this->setX(106);
        // $this->Cell(1, 15, utf8_decode(self::$consentimientoC->nombre), 0, 0, 'C', 0);

        $this->Line(67, 5, 67, 35);
        $this->Line(147, 5, 147, 35);
        $this->Line(147, 25, 190, 25);
        $this->Line(147, 16, 190, 16);

        $this->SetXY(112, 13);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(0, 0, utf8_decode('Código:'), 0, 0, 'C', 0);

        $this->SetX(149);
        $this->SetFont('Arial', '', 11);
        $this->Cell(0, 0, utf8_decode('FO-CE-031'), 0, 0, 'C', 0);

        $this->SetFont('Arial', 'B', 11);
        $this->SetXY(113, 22);
        $this->Cell(0, 0, utf8_decode('Versión:'), 0, 0, 'C', 0);

        $this->SetFont('Arial', '', 11);
        $this->SetX(149);
        $this->Cell(0, 0, utf8_decode('02'), 0, 0, 'C', 0);

        $this->SetFont('Arial', 'B', 11);
        $this->SetXY(136, 28);
        $this->Cell(0, 0, utf8_decode('Fecha de aprobación:'), 0, 0, 'C', 0);
        $this->SetFont('Arial', '', 11);

        $this->SetX(115);

        $this->Cell(0, 10, utf8_decode('25/05/2023'), 0, 0, 'C', 0);

        $this->Ln();
    }

    public function body()
    {
        $this->SetFont('Arial', 'B', 9);
        $this->SetXY(9, 45);
        $this->Cell(0, 0, 'Fecha y hora de diligenciamiento: ' . (self::$consulta->firma_consentimiento_time ?? ''), 0, 0, 'L', 0);

        $this->SetTextColor(10, 10, 10);
        $this->SetFont('Arial', 'B', 9);
        $this->SetX(90);
        $this->Cell(0, 0, 'Asegurador: ' . (self::$consulta->afiliado->entidad->nombre ?? ''), 0, 0, 'C', 0);
        $inicio = $this->GetY();

        $this->Line(10, 50, 200, 50);
        $this->Line(10, 65, 200, 65);
        $this->Line(10, 50, 10, 65);
        $this->Line(200, 50, 200, 65);
        $this->Line(25, 50, 25, 65);
        $this->Ln();
        $this->SetXY(10, 55);
        $this->Cell(40, 4, 'Paciente', 0, 0, 'L', 0);


        $y1 = $this->GetY();
        $this->SetX(25);
        $this->MultiCell(25, 4, utf8_decode(self::$consulta->afiliado->primer_apellido ?? ''), 0, 'C');

        $y2 = $this->GetY();
        $this->SetXY(50, $y1);
        $this->MultiCell(30, 4, utf8_decode(self::$consulta->afiliado->segundo_apellido ?? ''), 0, 'C');

        $y3 = $this->GetY();
        $this->SetXY(80, $y1);
        $this->MultiCell(68, 4, utf8_decode((self::$consulta->afiliado->primer_nombre ?? '') . "  " . (self::$consulta->afiliado->segundo_nombre ?? '')), 0, 'C');


        $y4 = $this->GetY();
        $this->SetXY(148, $y1);
        $this->MultiCell(32, 4, utf8_decode(self::$consulta->afiliado->numero_documento ?? ''), 0, 'C');


        $y5 = $this->GetY();
        $this->SetXY(180, $y1);
        $this->MultiCell(20, 4, utf8_decode(self::$consulta->afiliado->edad_cumplida ?? ''), 0, 'C');

        $conteo = max($y1, $y2, $y3, $y4, $y5);
        $this->Line(25, $conteo, 200, $conteo);
        $this->Line(50, $inicio + 5, 50, $conteo + 6);
        $this->Line(80, $inicio + 5, 80, $conteo + 6);
        $this->Line(148, $inicio + 5, 148, $conteo + 6);
        $this->Line(180, $inicio + 5, 180, $conteo + 6);
        // $y=$conteo;

        $y = $this->GetY();
        $y10 = $this->GetY();
        $this->SetX(25);
        $this->Cell(25, 4, 'Primer apellido', 0, 0, 'C', 0);
        $y11 = $this->GetY();
        $this->SetX(50);
        $this->Cell(30, 4, 'Segundo apellido', 0, 0, 'C', 0);
        $y12 = $this->GetY();
        $this->SetX(80);
        $this->Cell(68, 4, 'Nombre completo', 0, 0, 'C', 0);
        $y13 = $this->GetY();
        $this->SetX(148);
        $this->Cell(32, 4, 'Documento', 0, 0, 'C', 0);
        $y14 = $this->GetY();
        $this->SetX(180);
        $this->Cell(20, 4, 'Edad', 0, 0, 'C', 0);
        $max = max($y10, $y11, $y12, $y13, $y14);
        $yt = $max;
        $y = $this->GetY();

        $this->SetXY(13, $y + 8);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(186, 4, utf8_decode('DESCRIPCIÓN DEL PROCEDIMIENTO'), 0, 0, 'J', 0);

        $this->Ln();
        $this->SetX(13);
        $this->SetFont('Arial', '', 8);
        $this->MultiCell(186, 4, utf8_decode('La telemedicina involucra el uso de tecnología de telecomunicaciones y medios electrónicos para interactuar con usted, revisar su información médica para propósitos de diagnóstico, terapia, seguimiento y/o educación.'), 0, 'J');

        $this->Ln();
        $this->SetFont('Arial', 'B', 9);
        $this->SetX(13);
        $this->Cell(186, 4, utf8_decode('BENEFICIOS DEL PROCEDIMIENTO'), 0, 0, 'L', 0);

        $this->Ln();
        $this->setX(13);
        $this->SetFont('Arial', '', 8);
        $this->MultiCell(186, 4, utf8_decode('Los beneficios esperados de la atención bajo la modalidad de Telemedicina Interactiva son: Mayor acceso a la consulta médica por ser remota evitando desplazamiento. Protección frente a exposición a posibles contagios de enfermedades infecciosas por otras personas al recibir la atención mediante la modalidad de telemedicina en un sitio diferente a una Institución prestadora de servicios de salud, tal como mi vivienda. Disminuye los costos y riesgos de desplazamiento fuera de su entorno.'), 0, 'J');

        $this->Ln();
        $this->SetFont('Arial', 'B', 9);
        $this->SetX(13);
        $this->Cell(186, 4, utf8_decode('POSIBLES COMPLICACIONES'), 0, 0, 'L', 0);

        $this->Ln();
        $this->setX(13);
        $this->SetFont('Arial', '', 8);
        $this->MultiCell(186, 4, utf8_decode('La consulta médica a través de la modalidad de Telemedicina Interactiva conlleva a la ausencia de examen físico, lo que puede complicar o dificultar una impresión diagnóstica. Es posible que de acuerdo con los resultados de la valoración médica deba acudir de manera presencial para ser valorado por profesionales de Sumimedical S.A.S. o dirigirse a la red de prestadores de su asegurador. Es deber del paciente seguir y acatar las recomendaciones médicas. En casos excepcionales, la información transmitida puede no ser suficiente (p. ej. Baja resolución de las imágenes) para permitir una toma apropiada de decisiones médicas. Posibles demoras en la evaluación/tratamiento médico debido a deficiencias o fallos en el equipo electrónico En todos los casos, Sumimedical S.A.S. hace todos los esfuerzos para la reducción de los riesgos y dispone de los medios para el manejo de las complicaciones que lleguen a presentarse.'), 0, 'J');

        $y = $this->GetY();
        $this->SetFont('Arial', 'B', 9);
        $this->SetXY(13, $y + 8);
        $this->Cell(186, 4, 'ALTERNATIVAS DISPONIBLES A LA CONSULTA', 0, 0, 'L', 0);

        $this->Ln();
        $this->SetFont('Arial', '', 8);
        $this->SetX(13);
        $this->MultiCell(186, 4, utf8_decode('Si usted no acepta esta consulta puede solicitarla en modalidad presencial o dirigirse por sus propios medios al servicio de consulta prioritaria de Sumimedical S.A.S. o en la red de prestadores de su asegurador'), 0, 'J');

        $this->Ln();
        $this->SetFont('Arial', 'B', 9);
        $this->SetX(13);
        $this->Cell(186, 4, 'RIESGO DE NO ACEPTAR LA CONSULTA', 0, 0, 'L', 0);

        $this->Ln();
        $this->SetFont('Arial', '', 8);
        $this->SetX(13);
        $this->MultiCell(186, 4, utf8_decode('En caso de negarse probablemente continuará con los síntomas que ahora padece y se puede agravar su estado de salud.'), 0, 'J');

        $this->Ln();
        $this->SetX(13);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(186, 4, utf8_decode('¿QUÉ HACER SI NECESITA MÁS INFORMACIÓN?'), 0, 0, 'L', 0);

        $this->Ln();
        $this->SetFont('Arial', '', 8);
        $this->SetX(13);
        $this->MultiCell(186, 4, utf8_decode('En caso de requerir más información al respecto se puede dirigir a la sede donde se encuentre inscrito.'), 0, 'J');

        $this->Ln();
        $this->SetX(13);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(186, 4, utf8_decode('RECOMENDACIONES'), 0, 0, 'L', 0);

        $this->Ln();
        $this->SetX(13);
        $this->SetFont('Arial', '', 8);
        $this->MultiCell(186, 4, utf8_decode('Es necesario que informe al personal médico cualquier alteración propia de su salud, la existencia de comorbilidades, tales como hipertensión, diabetes, alergias, entre otros; esto ayudará a conocer mejor sus condiciones de salud. El paciente debe advertir de las posibles alergias medicamentosas, alteraciones de la coagulación, enfermedades cardiopulmonares, existencia de prótesis marca pasos, medicaciones que esté recibiendo o cualquier otra circunstancia que afecte a su salud.'), 0, 'J');

        $this->Ln();
        $this->SetX(13);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(186, 4, utf8_decode('DECLARACIÓN DEL PACIENTE / TUTOR / REPRESENTANTE LEGAL'), 0, 0, 'L', 0);

        $this->Ln();
        $this->SetX(13);
        $this->SetFont('Arial', '', 8);
        $this->MultiCell(186, 4, utf8_decode('Declaro en pleno uso de mis facultades mentales que he recibido una explicación y descripción clara y en lenguaje sencillo sobre el servicio de Consulta Externa bajo la modalidad de Telemedicina que voy a recibir, mediante la cual un Profesional de la Salud, haciendo uso de una herramienta de videollamada, hará una valoración de mi estado de salud, con miras a obtener un concepto médico y a ordenar los medicamentos y/o tecnologías en salud que considere necesarios para mi tratamiento.Se me han aclarado todas las dudas y se me han dicho los beneficios, posibles riesgos y complicaciones, así, como las otras alternativas de tratamiento al servicio que voy a recibir, y la posibilidad de que los profesionales de la Salud determinen la necesidad de cambio de modalidad en la atención, según la valoración que hagan de mi estado de salud o por fallas tecnológicas en el proceso de atención que impidan el cabal desarrollo de esta. Igualmente declaro que se me ha informado que para efectos de brindarme atención médica, autorizo expresamente a Sumimedical S.A.S para recolectar, clasificar, almacenar, utilizar, archivar y cualquier otra modalidad de tratamiento a mis Datos Personales, incluyendo mis datos sensibles, conforme a las finalidades establecidas en la Política de Tratamiento de Datos Personales disponible para su consulta en la página web https://sumimedical.com/politica-de-privacidad/ la cual puede ser modificada por la institución sin previo aviso. Estas finalidades incluyen soportar la atención medico asistencial, remitir información a su entidad aseguradora, gestionar procesos de cobro, realizar encuestas de satisfacción; enviar por cualquier canal (correo electrónico, SMS, físico) resultados de exámenes diagnósticos. Por lo anteriormente dicho, y en pleno uso de mis facultades, autorizo al equipo de salud de la Sumimedical S.A.S. el servicio de consulta externa bajo la modalidad de Telemedicina Interactiva y que el servicio requiere de una conexión a internet estable, lo que puede implicar un consumo de datos celulares o de ancho de banda para el paciente. Entiendo y asumo los riesgos relacionados con la realización de este y autorizo a que se tomen las medidas necesarias ante cualquier complicación derivada de la consulta. SI_x_ NO___ (marque con una X). Autorizo el tratamiento de mis datos personales, incluyendo mis datos sensibles, para los fines previamente señalados, así como la posibilidad de grabación y almacenamiento en la nube hacia servidores nacionales o internacionales SI_x_ NO___ (marque con una X). Nota: como paciente, usted tiene derecho a retractarse de este consentimiento informado en cualquier momento antes o durante la realización de la intervención. Consulta, y que, en caso de no aceptar esta modalidad de tratamiento, puedo continuar recibiendo atención médica.'), 0, 'J');

        $this->Ln();
        $this->SetX(13);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(186, 4, utf8_decode('MENORES DE EDAD E INCAPACES'), 0, 0, 'L', 0);

        $this->Ln();
        $this->SetX(13);
        $this->SetFont('Arial', '', 8);
        $this->MultiCell(186, 4, utf8_decode('En caso de que el paciente sea menor de 18 años, y/o incapaz, este consentimiento será suscrito por su representante legal. Sé que el paciente es incapaz de tomar por sí mismo la decisión de aceptar o rechazar el tratamiento descrito arriba. Por ende, en mi condición de Representante Legal del menor y/o incapaz _______________________________. El médico tratante me ha explicado de forma satisfactoria en qué consiste, cuáles son los objetivos del procedimiento y me han informado los riesgos y los procedimientos alternativos He comprendido todo lo anterior, y por ende Yó ___________________________________con cedula de ciudadanía número: __________ Otorgo mi Consentimiento en nombre del paciente menor de edad y/o incapaz, para que se le preste el servicio de Consulta Externa bajo la modalidad de Telemedicina Interactiva. SI_x_ NO___ (marque con una X).'), 0, 'J');

        $this->Ln();
        $this->SetX(13);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(186, 4, utf8_decode('MANIFESTACIÓN DE VOLUNTAD'), 0, 0, 'L', 0);

        $this->Ln();
        $this->SetX(13);
        $this->SetFont('Arial', '', 8);
        $this->MultiCell(186, 4, utf8_decode('En consideración a lo anterior, de manera libre y voluntaria doy mi consentimiento para ser atendido bajo la modalidad de Telemedicina Interactiva; de tal forma que el consentimiento que emito se encuentra exento de cualquier error. En cualquier caso, deseo que se me respeten las siguientes condiciones (si no hay condiciones escríbase “ninguna” y sí no se aceptan algunos de los otros puntos hágase constar)'), 0, 'J');

        //firmas



        $this->Ln();
        $inicio = $this->GetY();
        $inicio = $this->GetY();

        $this->Line(23, $inicio + 3, 190, $inicio + 3);
        $this->Line(23, $inicio + 9, 190, $inicio + 9);
        $this->Line(23, $inicio + 36, 190, $inicio + 36);
        $this->Line(23, $inicio + 3, 23, $inicio + 36);
        $this->Line(106, $inicio + 9, 106, $inicio + 36);
        $this->Line(190, $inicio + 3, 190, $inicio + 36);

        $this->Ln();

        $y1 = $this->GetY();


        $this->SetTextColor(10, 10, 10);
        $this->SetFont('Arial', 'B', 9);
        $this->SetXY(23, $y1 + 3);
        $this->Cell(0, 0, 'Fecha y hora del consentimiento:' . (self::$consulta->firma_consentimiento_time ?? ''), 0, 0, 'L', 0);

        $this->Ln();
        $y2 = $this->GetY();

        $y4 = $this->GetY();
        $this->SetTextColor(10, 10, 10);
        $this->SetFont('Arial', 'B', 9);
        $this->SetXY(23, $y4 + 19);
        $this->SetFillColor(129, 214, 54);
        $this->Cell(84, 6, utf8_decode('Firma del paciente o representante legal'), 1, 1, 'C', 'true');

        $y5 = $this->GetY();
        $this->SetFont('Arial', 'B', 8);
        $this->SetXY(23, $y5);
        $this->Cell(0, 4, utf8_decode('Identificación: ' . (self::$consulta->afiliado->numero_documento ?? '')), 0, 0, 'L', 0);

        $y10 = $this->GetY();
        $this->SetFont('Arial', 'B', 9);
        $this->SetXY(106, $y4 + 19);
        $this->SetFillColor(129, 214, 54);
        $this->Cell(84, 6, utf8_decode('Firma del médico'), 1, 1, 'C', 'true');

        $y7 = $this->GetY();
        $this->SetFont('Arial', 'B', 8);
        $this->SetXY(106, $y7 + 2);
        $this->Cell(50, 0, utf8_decode('Nombre: ' . (self::$consulta->medicoOrdena->operador->nombre_completo ?? '')), 0, 'C');


        $firma_paciente = self::$consulta->firma_consentimiento;

        $y8 = $this->GetY();
        $this->SetXY(23, $y2 + 12);
        if (!empty($firma_paciente)) {
            $base64Image = $firma_paciente;
            $explodedData = explode(',', $base64Image);
            $type = $explodedData[0];
            $base64Data = $explodedData[1];
            $imageData = base64_decode($base64Data);

            $tempImage = tempnam(sys_get_temp_dir(), 'firma') . '.png';
            file_put_contents($tempImage, $imageData);
            $this->Image($tempImage, 50, $y8 - 22, 46, 11);
        }

        $firmaMedico = self::$consulta->medicoOrdena->firma;

        $y9 = $this->GetY();
        $this->SetXY(145, $y9 + 12);
        if ($firmaMedico != null) {
            if (file_exists(storage_path(substr(self::$consulta->medicoOrdena->firma, 9)))) {
                $this->Image(storage_path(substr(self::$consulta->medicoOrdena->firma, 9)), 130, $y9 - 7, 46, 11);
            }
        }

        $sm = max($y1, $y2, $y4, $y5, $y7, $y8, $y9, $y10);
        $yt = $sm;

        $this->SetTextColor(10, 10, 10);
        $this->SetXY(80, $yt + 5);
        $this->SetFont('Arial', '', 8);
        $this->Cell(50, 0, utf8_decode('* La huella del paciente se toma únicamente para las personas que no saben firmar o que presentan perdida de la visión.'), 0, 0, 'C', 0);
    }

    public function footer()
    {
        $this->SetXY(190, 287);
        $this->SetFont('Arial', '', 7);
        $this->Cell(10, 4, utf8_decode('Página ') . $this->PageNo() . ' de {nb}', 0, 0, 'C');
        $this->Ln();
        $this->Cell(186, 4, utf8_decode('Una vez descargado o impreso este documento se considera copia no controlada'), 0, 0, 'C');
    }
}
