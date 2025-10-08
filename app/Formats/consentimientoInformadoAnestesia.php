<?php

namespace App\Formats;

use App\Traits\PdfTrait;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Carbon;

class consentimientoInformadoAnestesia extends FPDF
{
    use PdfTrait;

    public static $consulta;

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
        $this->Cell(68, 5, 'CONSENTIMIENTO INFORMADO DE', 0, 0, 'C', 0);
        $this->Ln();
        $this->SetXY(73, 20);
        $this->Cell(68, 5, utf8_decode('ANESTESIA'), 0, 0, 'C', 0);


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
        $this->Cell(0, 0, utf8_decode('FO-PS-089'), 0, 0, 'C', 0);

        $this->SetFont('Arial', 'B', 11);
        $this->SetXY(113, 22);
        $this->Cell(0, 0, utf8_decode('Versión:'), 0, 0, 'C', 0);

        $this->SetFont('Arial', '', 11);
        $this->SetX(149);
        $this->Cell(0, 0, utf8_decode('04'), 0, 0, 'C', 0);

        $this->SetFont('Arial', 'B', 11);
        $this->SetXY(136, 28);
        $this->Cell(0, 0, utf8_decode('Fecha de aprobación:'), 0, 0, 'C', 0);
        $this->SetFont('Arial', '', 11);

        $this->SetX(115);

        $this->Cell(0, 10, utf8_decode('14/04/2025'), 0, 0, 'C', 0);

        $this->Ln();
    }

    public function body()
    {
        $this->SetFont('Arial', 'B', 9);
        $this->SetXY(9, 45);
        $this->Cell(0, 0, 'Fecha y hora de diligenciamiento: ' . Carbon::parse(self::$consulta->firma_consentimiento_time ?? '')->format('Y-m-d H:i'), 0, 0, 'L', 0);

        $this->SetTextColor(10, 10, 10);
        $this->SetFont('Arial', 'B', 9);
        $this->SetX(91);
        $this->Cell(0, 0, 'Asegurador: ' . (self::$consulta?->afiliado?->entidad?->nombre ?? ''), 0, 0, 'C', 0);
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
        $this->SetFont('Arial', '', 9);
        $this->MultiCell(186, 4, utf8_decode('La anestesia es el uso de medicamentos para prevenir el dolor durante una cirugía y otros procedimientos. Estos medicamentos se denominan anestésicos. Puede ser general, regional o local. 
La anestesia general se administra mediante inyección intravenosa o por inhalación de anestésicos. Siempre es necesario asegurar la vía aérea y mantener una oxigenación adecuada, a través de la aplicación de un tubo en la tráquea o el uso máscaras laríngea o facial, según el caso. Mientras que, la anestesia regional, consiste en el bloqueo de la sensibilidad y motricidad de una región anatómica del cuerpo o una parte determinada en el caso de la anestesia local por la inyección de anestésicos cerca de los nervios correspondientes. Puede ser central (como peridural y raquídea) donde se bloquean los nervios en la medula espinal o periférica cuando se bloquean los nervios específicos de las extremidades.'), 0, 'J');

        $this->Ln();
        $this->SetFont('Arial', 'B', 9);
        $this->SetX(13);
        $this->Cell(186, 4, utf8_decode('BENEFICIOS DEL PROCEDIMIENTO'), 0, 0, 'L', 0);

        $this->Ln();
        $this->setX(13);
        $this->SetFont('Arial', '', 9);
        $this->MultiCell(186, 4, utf8_decode('Los beneficios ante la aplicación de anestesia general son: reducción de la pérdida de sangre y facilitar la eventual realización del procedimiento quirúrgico por la eliminación completa del dolor durante la realización del mismo. Con la aplicación de anestesia regional se busca, disminución de las acciones sobre los sistemas cardiovascular y respiratorio y la disminución en los tiempos de recuperación.'), 0, 'J');

        $this->Ln();
        $this->SetFont('Arial', 'B', 9);
        $this->SetX(13);
        $this->Cell(186, 4, utf8_decode('RIESGOS DEL PROCEDIMIENTO'), 0, 0, 'L', 0);

        $this->Ln();
        $this->setX(13);
        $this->SetFont('Arial', '', 9);
        $this->MultiCell(186, 4, utf8_decode('Puede generar alergia a los medicamentos anestésicos, daño en la vena durante la aplicación de la anestesia general que puede necrosar (gangrena) y perder el tejido donde está dicha vena, requiriendo manejo quirúrgico para su tratamiento, fiebre alta que puede llegar a ser de difícil manejo, dolor de garganta, ronquera, daño dental, lesión de cuerda vocal, arritmias (latidos anormales del corazón), infarto cardiaco, paro cardiorespiratorio, daño cerebral, náuseas, vomito, disminución de la presión arterial, lesión de nervios en las extremidades, úlceras en la córnea, trastornos del sueño, recuerdos intraoperatorios, broncoaspiración (que se llenen los pulmones de alimentos y secreciones), laringoespasmo (cierre de la vía aérea), edema pulmonar (agua en los pulmones) e incluso, la muerte. En el caso de la anestesia, raquídea o epidural (con carácter o sin carácter) puedo presentar dolor de espalda crónico, dolor de cabeza que puede requerir una nueva inyección para colocar un parche con sangre, lesión en la columna, hematoma en la médula (coágulo de sangre que comprime la médula) y que puede requerir manejo quirúrgico para evitar secuelas neurológicas en las piernas, infección en la columna o incluso la muerte, también puede ocasionar pérdida o malformación del producto del embarazo. La aplicación de un tipo de anestesia no descarta que sea necesario cambiar la técnica inicial de acuerdo a las circunstancias. A pesar de no tener alteraciones anatómicas detectadas en el examen físico, se pueden presentar problemas en el manejo de la vía aérea. Se puede llegar a necesitar equipos médicos especiales de monitoreo para su utilización requiere de invadir el cuerpo con agujas, catéteres, guías metálicas, que pueden producir daños como lesiones pulmonares, vasculares, arritmias, perforación cardiaca, isquemia (falta de sangre) de los dedos que requiera incluso de amputación, es importante saber que incluso con una mínima dosis de anestésico, se puede ocasionar la muerte por una reacción alérgica.
En todos los casos, Sumimedical S.A.S. hace todos los esfuerzos para la reducción de los riesgos propios del procedimiento y dispone de los medios para el manejo de las complicaciones que lleguen a presentarse.'), 0, 'J');

        $this->Ln();
        $this->SetFont('Arial', 'B', 9);
        $this->SetX(13);
        $this->Cell(186, 4, 'ALTERNATIVAS DISPONIBLES AL PROCEDIMIENTO', 0, 0, 'L', 0);

        $this->Ln();
        $this->SetFont('Arial', '', 9);
        $this->SetX(13);
        $this->MultiCell(186, 4, utf8_decode('No se contemplan alternativas a la aplicación de la anestesia.'), 0, 'J');

        $this->Ln();
        $this->SetFont('Arial', 'B', 9);
        $this->SetX(13);
        $this->Cell(186, 4, 'RIESGO DE NO ACEPTAR EL PROCEDIMIENTO', 0, 0, 'L', 0);

        $this->Ln();
        $this->SetFont('Arial', '', 9);
        $this->SetX(13);
        $this->MultiCell(186, 4, utf8_decode('En caso de negarse a la administración de la anestesia, lo más probable es que no pueda ser intervenido quirúrgicamente.'), 0, 'J');

        $this->Ln();
        $this->SetX(13);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(186, 4, utf8_decode('¿QUÉ HACER SI NECESITA MÁS INFORMACIÓN?'), 0, 0, 'L', 0);

        $this->Ln();
        $this->SetFont('Arial', '', 9);
        $this->SetX(13);
        $this->MultiCell(186, 4, utf8_decode('En caso de requerir más información se puede contactar con el médico tratante.'), 0, 'J');

        $this->Ln();
        $this->SetX(13);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(186, 4, utf8_decode('RECOMENDACIONES'), 0, 0, 'L', 0);

        $this->Ln();
        $this->SetX(13);
        $this->SetFont('Arial', '', 9);
        $this->MultiCell(186, 4, utf8_decode('Es necesario que informe al personal médico cualquier alteración propia de su salud, la existencia de comorbilidades, tales como hipertensión, diabetes, alergias, entre otros; esto ayudará a conocer mejor sus condiciones de salud. 
El paciente debe advertir de las posibles alergias medicamentosas, alteraciones de la coagulación, enfermedades cardiopulmonares, existencia de prótesis marca pasos, medicaciones que esté recibiendo o cualquier otra circunstancia que afecte a su salud. 
La mujer en edad reproductiva debe informar si se encuentra o no en estado de embarazo.'), 0, 'J');

        $this->Ln();
        $this->SetX(13);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(186, 4, utf8_decode('IMPLICACIONES DEL ACTO ASISTENCIAL'), 0, 0, 'L', 0);

        $this->Ln();
        $this->SetX(13);
        $this->SetFont('Arial', '', 9);
        $this->MultiCell('186', 4, utf8_decode('Entiendo que el acto asistencial incluye el proceso diagnóstico, la propuesta terapéutica y la ejecución de la intervención bajo principios éticos, técnicos y científicos, que, de acuerdo con los riesgos, beneficios e implicaciones mencionados arriba, se requiere de cuidados posteriores y seguimiento clínico para lograr los resultados esperados. Acepto que el procedimiento busca el mayor beneficio para mi salud y comprendo que los resultados pueden variar según las condiciones individuales.'), 0, 'J');

        $this->Ln();
        $this->SetX(13);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(186, 4, utf8_decode('DECLARACIÓN DE CONSENTIMIENTO INFORMADO'), 0, 0, 'L', 0);

        $this->Ln();
        $this->SetX(13);
        $this->SetFont('Arial', '', 9);
        $this->MultiCell(186, 4, utf8_decode('En caso de realización de procedimiento en menor de edad o persona en condición de discapacidad, nombre del representante legal ' . (self::$consulta->nombre_representante ?? '')), 0, 'J');

        $this->Ln();
        $this->SetX(13);
        $this->SetFont('Arial', '', 9);
        $this->MultiCell(186, 4, utf8_decode('a) Declaro que he entendido las condiciones y objetivos de la cirugía que se me va a practicar, los cuidados que debo tener antes y después de ella, manifiesto que la información recibida del médico tratante ha sido en un lenguaje claro y sencillo, y me ha dado la oportunidad de preguntar y resolver las dudas a satisfacción, comprendo que, si es necesario extraer algún tejido, se someterá a estudio anatomopatológico siendo mi deber reclamar el resultado e informarlo al médico; comprendo y acepto el alcance y los riesgos que conlleva el procedimiento quirúrgico que me indican, por lo que manifiesto sentirme satisfecho(a) con la información recibida: ' . ($this->declaracion(self::$consulta?->declaracion_a)) . ' (marque con una X).'), 0, 'J');


        $this->Ln();
        $this->SetX(13);
        $this->SetFont('Arial', '', 9);
        $this->MultiCell(186, 4, utf8_decode('b) El profesional me ha planteado la posibilidad de participar en estudios investigativos que adelanta la institución con fines de mejoramiento continuo, me ha explicado que en caso de que sea sujeto de investigación mis datos serán empleados guardando estricta confidencialidad, asimismo existe posibilidad de que se tomen registros fotográficos y/o audiovisuales en el proceso con fines exclusivamente académicos, por lo que manifiesto sentirme satisfecho(a) con la información recibida y aceptarlo : ' . ($this->declaracion(self::$consulta?->declaracion_b)) . ' (marque con una X).'), 0, 'J');

        $this->Ln();
        $this->SetX(13);
        $this->SetFont('Arial', '', 9);
        $this->MultiCell(186, 4, utf8_decode('c) Por lo anteriormente dicho, y en pleno uso de mis facultades, autorizo al equipo de salud de la Sumimedical S.A.S. para que se me realice el procedimiento arriba descrito (o a mi representado según el caso) el cual fue solicitado por mi médico tratante. Entiendo y asumo los riesgos relacionados con la realización de este y autorizo a que se tomen las medidas necesarias ante cualquier complicación derivada del procedimiento.  ') . ($this->declaracion(self::$consulta?->aceptacion_consentimiento)) . ' (marque con una X).', 0, 'J');

        $this->Ln();
        $this->SetX(13);
        $this->MultiCell(186, 4, utf8_decode('Nota: como paciente, usted tiene derecho a retractarse de este consentimiento informado en cualquier momento antes o durante la realización de la intervención.'), 0, 'J');

        //firmas



        // $this->Ln();
        $inicio = $this->GetY();

        $this->Line(23, $inicio + 3, 190, $inicio + 3);
        $this->Line(23, $inicio + 9, 190, $inicio + 9);
        $this->Line(23, $inicio + 36, 190, $inicio + 36);
        $this->Line(23, $inicio + 3, 23, $inicio + 36);
        $this->Line(106, $inicio + 9, 106, $inicio + 36);
        $this->Line(190, $inicio + 3, 190, $inicio + 36);

        $this->Ln();

        $y1 = $this->GetY();


        if (self::$consulta?->aceptacion_consentimiento == 'Si') {

            $this->SetTextColor(10, 10, 10);
            $this->SetFont('Arial', 'B', 9);
            $this->SetXY(23, $y1 + 3);
            $this->Cell(0, 0, 'Fecha y hora del consentimiento:' . (self::$consulta->firma_consentimiento_time ?? ''), 0, 0, 'L', 0);

            $this->Ln();
            $y2 = $this->GetY();

            $y4 = $this->GetY();
            $this->SetTextColor(255, 255, 255);
            $this->SetFont('Arial', 'B', 9);
            $this->SetXY(23, $y4 + 19);
            $this->SetFillColor(46, 44, 126);
            $this->Cell(84, 6, utf8_decode('Firma del paciente o representante legal'), 1, 1, 'C', 'true');

            $y5 = $this->GetY();
            $this->SetTextColor(10, 10, 10);
            $this->SetFont('Arial', 'B', 8);
            $this->SetXY(23, $y5);
            if (self::$consulta?->numero_documento_representante == null) {
                $this->Cell(0, 4, utf8_decode('Identificación: ' . (self::$consulta->afiliado->numero_documento ?? '')), 0, 0, 'L', 0);
            } else {
                $this->Cell(0, 4, utf8_decode('Identificación: ' . (self::$consulta->numero_documento_representante ?? '')), 0, 0, 'L', 0);
            }

            $y10 = $this->GetY();
            $this->SetTextColor(255, 255, 255);
            $this->SetFont('Arial', 'B', 9);
            $this->SetXY(106, $y4 + 19);
            $this->SetFillColor(46, 44, 126);
            $this->Cell(84, 6, utf8_decode('Firma del médico'), 1, 1, 'C', 'true');

            $y7 = $this->GetY();
            $this->SetTextColor(10, 10, 10);
            $this->SetFont('Arial', 'B', 8);
            $this->SetXY(106, $y7 + 2);
            $this->Cell(50, 0, utf8_decode('Nombre: ' . (self::$consulta->medicoOrdena->operador->nombre_completo  ?? '')), 0, 'C');

            $firma_paciente = self::$consulta?->firma_consentimiento ?? self::$consulta?->firma_acompanante ?? '';
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

            $y9 = $this->GetY();
            $this->SetXY(145, $y9 + 12);
            if (isset(self::$consulta->medicoOrdena->firma)) {
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
        } else {
            $this->SetTextColor(10, 10, 10);
            $this->SetFont('Arial', 'B', 9);
            $this->SetXY(23, $y1 + 3);
            if (self::$consulta) {
                $this->Cell(0, 0, 'Fecha y hora del consentimiento:  NO APLICA', 0, 0, 'L', 0);
                $this->Text(50, $y1 + 15, 'NO APLICA');
            } else {

                $this->Cell(0, 0, 'Fecha y hora del consentimiento: ', 0, 0, 'L', 0);
            }

            $this->Ln();
            $y2 = $this->GetY();

            $y4 = $this->GetY();
            $this->SetTextColor(255, 255, 255);
            $this->SetFont('Arial', 'B', 9);
            $this->SetXY(23, $y4 + 19);
            $this->SetFillColor(46, 44, 126);
            $this->Cell(84, 6, utf8_decode('Firma del paciente o representante legal'), 1, 1, 'C', 'true');

            $y5 = $this->GetY();
            $this->SetTextColor(10, 10, 10);
            $this->SetFont('Arial', 'B', 8);
            $this->SetXY(23, $y5);
            if (self::$consulta) {
                $this->Cell(0, 4, utf8_decode('Identificación: NO APLICA '), 0, 0, 'L', 0);
                $this->Text(135, $y4 + 12, 'NO APLICA');
            } else {

                $this->Cell(0, 4, utf8_decode('Identificación:  '), 0, 0, 'L', 0);
            }

            $y10 = $this->GetY();
            $this->SetTextColor(255, 255, 255);
            $this->SetFont('Arial', 'B', 9);
            $this->SetXY(106, $y4 + 19);
            $this->SetFillColor(46, 44, 126);
            $this->Cell(84, 6, utf8_decode('Firma del médico'), 1, 1, 'C', 'true');

            $y7 = $this->GetY();
            $this->SetTextColor(10, 10, 10);
            $this->SetFont('Arial', 'B', 8);
            $this->SetXY(106, $y7 + 2);
            if (self::$consulta) {
                $this->Cell(50, 0, utf8_decode('Nombre:  NO APLICA'));
            } else {

                $this->Cell(50, 0, utf8_decode('Nombre: '), 0, 'C');
            }

            $sm = max($y1, $y2, $y4, $y5, $y7, $y10);
            $yt = $sm;

            $this->SetTextColor(10, 10, 10);
            $this->SetXY(80, $yt + 7);
            $this->SetFont('Arial', '', 8);
            $this->Cell(50, 0, utf8_decode('* La huella del paciente se toma únicamente para las personas que no saben firmar o que presentan perdida de la visión.'), 0, 0, 'C', 0);
        }

        $this->SetXY(70, $yt + 10);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(186, 4, utf8_decode('DISENTIMIENTO O DESISTIMIENTO INFORMADO'), 0, 'C');

        $this->Ln();
        $this->SetX(13);
        $this->SetFont('Arial', '', 8);
        if (self::$consulta && self::$consulta->aceptacion_consentimiento == 'Si') {
            $this->MultiCell(186, 4, utf8_decode('En el presente documento manifiesto que he sido informado sobre mi condición, las eventuales complicaciones y/o riesgos que se deriven, los beneficios de los procedimientos planeados, de manera que se puedan tomar decisiones informadas; no obstante, reunido con el profesional ____________________NO___APLICA____________________________, decido de forma libre y consciente no aceptar/revocar la realización del procedimiento propuesto, haciéndome responsable de las consecuencias que puedan derivarse de esta decisión.'), 0, 'J');
        } else if (self::$consulta && self::$consulta->aceptacion_consentimiento == 'No') {
            $this->MultiCell(186, 4, utf8_decode('En el presente documento manifiesto que he sido informado sobre mi condición, las eventuales complicaciones y/o riesgos que se deriven, los beneficios de los procedimientos planeados, de manera que se puedan tomar decisiones informadas; no obstante, reunido con el profesional ' . (self::$consulta->medicoOrdena->operador->nombre_completo) . ', decido de forma libre y consciente no aceptar/revocar la realización del procedimiento propuesto, haciéndome responsable de las consecuencias que puedan derivarse de esta decisión.'), 0, 'J');
        } else {
            $this->MultiCell(186, 4, utf8_decode('En el presente documento manifiesto que he sido informado sobre mi condición, las eventuales complicaciones y/o riesgos que se deriven, los beneficios de los procedimientos planeados, de manera que se puedan tomar decisiones informadas; no obstante, reunido con el profesional _____________________________________________________ , decido de forma libre y consciente no aceptar/revocar la realización del procedimiento propuesto, haciéndome responsable de las consecuencias que puedan derivarse de esta decisión.'), 0, 'J');
        }

        $inicio = $this->GetY();
        if ($inicio > 270) {
            $this->AddPage();
            $inicio = $this->GetY();
        }


        $this->Line(23, $inicio + 3, 190, $inicio + 3);
        $this->Line(23, $inicio + 9, 190, $inicio + 9);
        $this->Line(23, $inicio + 36, 190, $inicio + 36);
        $this->Line(23, $inicio + 3, 23, $inicio + 36);
        $this->Line(106, $inicio + 9, 106, $inicio + 36);
        $this->Line(190, $inicio + 3, 190, $inicio + 36);

        if (self::$consulta?->aceptacion_consentimiento == 'No') {
            $y1 = $this->GetY();
            $this->SetTextColor(10, 10, 10);
            $this->SetFont('Arial', 'B', 9);
            $this->SetXY(23, $y1 + 7);
            $this->Cell(50, 0, utf8_decode('Fecha y hora del disentimiento o desistimiento informado: ' . (self::$consulta->firma_consentimiento_time ?? '')), 0, 0, 'L', 0);

            $y2 = $this->GetY();

            $firma_paciente = self::$consulta->firma_consentimiento ?? '';

            $y4 = $this->GetY();
            if (isset($firma_paciente)) {
                $base64Image = $firma_paciente;
                $explodedData = explode(',', $base64Image);
                $type = $explodedData[0];
                $base64Data = $explodedData[1];
                $imageData = base64_decode($base64Data);

                $tempImage = tempnam(sys_get_temp_dir(), 'firma') . '.png';
                file_put_contents($tempImage, $imageData);
                $this->Image($tempImage, 40, $yt + 45, 46, 11);
            }

            $y9 = $this->GetY();
            if (isset(self::$consulta->medicoOrdena->firma)) {
                if (file_exists(storage_path(substr(self::$consulta->medicoOrdena->firma, 9)))) {
                    $this->Image(storage_path(substr(self::$consulta->medicoOrdena->firma, 9)), 130, $yt + 45, 46, 11);
                }
            }

            $y5 = $this->GetY();
            $this->SetTextColor(255, 255, 255);
            $this->SetFont('Arial', 'B', 9);
            $this->SetXY(23, $y4 + 19);
            $this->SetFillColor(46, 44, 126);
            $this->Cell(84, 6, utf8_decode('Firma del paciente o representante legal'), 1, 1, 'C', 'true');


            $y10 = $this->GetY();
            $this->SetFont('Arial', 'B', 9);
            $this->SetXY(106, $y4 + 19);
            $this->SetFillColor(46, 44, 126);
            $this->Cell(84, 6, utf8_decode('Firma del médico'), 1, 1, 'C', 'true');

            $y6 = $this->GetY();
            $this->SetTextColor(10, 10, 10);
            $this->SetFont('Arial', 'B', 8);
            $this->SetXY(106, $y6 + 2);
            $this->Cell(50, 0, utf8_decode('Nombre: ' . (self::$consulta->medicoOrdena->operador->nombre_completo ?? '')), 0, 'C');

            $y7 = $this->GetY();
            $this->SetFont('Arial', 'B', 8);
            $this->SetXY(23, $y7 - 2);
            if (self::$consulta?->numero_documento_representante == null) {
                $this->Cell(0, 4, utf8_decode('Identificación: ' . (self::$consulta->afiliado->numero_documento ?? '')), 0, 0, 'L', 0);
            } else {
                $this->Cell(0, 4, utf8_decode('Identificación: ' . (self::$medicoAtendio->numero_documento_representante ?? '')), 0, 0, 'L', 0);
            }


            $y8 = $this->GetY();
            $this->SetXY(30, $y8 + 7);
            $this->SetFont('Arial', '', 8);
            $this->Cell(50, 1, utf8_decode('* La huella del paciente se toma únicamente para las personas que no saben firmar o que presentan perdida de la visión.'), 0, 0, 'L', 0);
            $this->Ln();
            $this->Ln();
        } else {
            $y1 = $this->GetY();
            $this->SetTextColor(10, 10, 10);
            $this->SetFont('Arial', 'B', 9);
            $this->SetXY(23, $y1 + 7);
            if (self::$consulta && self::$consulta->aceptacion_consentimiento == 'Si') {
                $this->Cell(50, 0, utf8_decode('Fecha y hora del disentimiento o desistimiento informado: NO APLICA'), 0, 0, 'L', 0);
            } else {
                $this->Cell(50, 0, utf8_decode('Fecha y hora del disentimiento o desistimiento informado: '), 0, 0, 'L', 0);
            }

            $y2 = $this->GetY();

            $firma_paciente = self::$consulta->firma_consentimiento ?? '';
            $firma_paciente_discentimiento = self::$consulta->firma_consentimiento ?? '';

            $y4 = $this->GetY();
            if (self::$consulta->aceptacion_consentimiento == 'No') {
                if (isset($firma_paciente_discentimiento)) {
                    $base64Image = $firma_paciente_discentimiento;
                    $explodedData = explode(',', $base64Image);
                    $type = $explodedData[0];
                    $base64Data = $explodedData[1];
                    $imageData = base64_decode($base64Data);

                    $tempImage = tempnam(sys_get_temp_dir(), 'firma') . '.png';
                    file_put_contents($tempImage, $imageData);
                    $this->Image($tempImage, 40, $yt + 56, 46, 11);
                }
            }
            if (self::$consulta && self::$consulta->aceptacion_consentimiento == 'Si') {
                $this->Text(50, $y4 + 12, 'NO APLICA');
                if(self::$consulta->aceptacion_consentimiento == 'Si'){$this->Text(130,$y4+12,'NO APLICA');}
                $y5 = $this->GetY();
                $this->SetTextColor(255, 255, 255);
                $this->SetFont('Arial', 'B', 9);
                $this->SetXY(23, $y4 + 19);
                $this->SetFillColor(46, 44, 126);
                $this->Cell(84, 6, utf8_decode('Firma del paciente o representante legal'), 1, 1, 'C', 'true');


                $y10 = $this->GetY();
                $this->SetFont('Arial', 'B', 9);
                $this->SetXY(106, $y4 + 19);
                $this->SetFillColor(46, 44, 126);
                $this->Cell(84, 6, utf8_decode('Firma del médico'), 1, 1, 'C', 'true');

                $y6 = $this->GetY();
                $this->SetTextColor(10, 10, 10);
                $this->SetFont('Arial', 'B', 8);
                $this->SetXY(106, $y6 + 2);
                if (self::$consulta && self::$consulta->aceptacion_consentimiento == 'Si') {
                    $this->Cell(50, 0, utf8_decode('Nombre: NO APLICA'), 0, 'C');
                } else if (self::$consulta && self::$consulta->aceptacion_consentimiento == 'No') {
                    $this->Cell(50, 0, utf8_decode('Nombre: ' . (self::$consulta->medicoOrdena->operador->nombre_completo ?? '')), 0, 'C');
                } else {
                    $this->Cell(50, 0, utf8_decode('Nombre: '), 0, 'C');
                }

                $y7 = $this->GetY();
                $this->SetFont('Arial', 'B', 8);
                $this->SetXY(23, $y7 - 2);

                if (self::$consulta->aceptacion_consentimiento == 'Si') {
                    $this->Cell(0, 4, utf8_decode('Identificación: NO APLICA '), 0, 0, 'L', 0);
                } else if (self::$consulta->aceptacion_consentimiento == 'No') {
                    if (self::$consulta?->numero_documento_representante == null) {
                        $this->Cell(0, 4, utf8_decode('Identificación: ' . (self::$consulta->afiliado->numero_documento ?? '')), 0, 0, 'L', 0);
                    } else {
                        $this->Cell(0, 4, utf8_decode('Identificación: ' . (self::$medicoAtendio->numero_documento_representante ?? '')), 0, 0, 'L', 0);
                    }
                } else {
                    $this->Cell(0, 4, utf8_decode('Identificación: '), 0, 0, 'L', 0);
                }

                $y8 = $this->GetY();
                $this->SetXY(30, $y8 + 7);
                $this->SetFont('Arial', '', 8);
                $this->Cell(50, 1, utf8_decode('* La huella del paciente se toma únicamente para las personas que no saben firmar o que presentan perdida de la visión.'), 0, 0, 'L', 0);
                $this->Ln();
                $this->Ln();

                $y9 = $this->GetY();
                if (self::$consulta?->aceptacion_consentimiento == 'No') {
                    if (isset(self::$consulta->medicoOrdena->firma)) {
                        if (file_exists(storage_path(substr(self::$consulta->medicoOrdena->firma, 9)))) {
                            $this->Image(storage_path(substr(self::$consulta->medicoOrdena->firma, 9)), 130, $yt + 56, 46, 11);
                        }
                    }
                }
            }
        }
    }

    public function footer()
    {
        $this->SetXY(190, 287);
        $this->SetFont('Arial', '', 7);
        $this->Cell(10, 4, utf8_decode('Página ') . $this->PageNo() . ' de {nb}', 0, 0, 'C');
        $this->Ln();
        $this->Cell(186, 4, utf8_decode('Una vez descargado o impreso este documento se considera copia no controlada'), 0, 0, 'C');
    }

    private function declaracion($declaracion)
    {
        if ($declaracion === 'Si') {
            return 'SI_X_ NO_';
        } elseif ($declaracion === 'No') {
            return 'SI__ NO_X_';
        } else {
            return 'SI__ NO__';
        }
    }
}
