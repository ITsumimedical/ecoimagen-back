<?php

namespace App\Formats;

use App\Traits\PdfTrait;
use Codedge\Fpdf\Fpdf\Fpdf;

class SolicitudCopiaHistoria extends FPDF
{
    use PdfTrait;

    public function generar()
    {
        $this->generarPDF('I');
    }

    public function header()
    {
        //cabecera
        $this->SetDrawColor(140, 190, 56);
        $this->Rect(5, 5, 200, 287);
        $this->SetDrawColor(0, 0, 0);

        $this->Line(12, 12, 198, 12);
        $this->Line(12, 12, 12, 35);
        $this->Line(12, 35, 198, 35);
        $this->Line(198, 12, 198, 35);
        $this->Line(159, 12, 159, 35);
        $this->Line(50, 12, 50, 35);
        $this->Line(159, 19, 198, 19);
        $this->Line(159, 25, 198, 25);


        $this->SetFont('Arial', 'B', 12);
        $this->SetXY(50, 22);
        $this->MultiCell(109, 4, utf8_decode("FORMATO ÚNICO DE SOLICITUD DE COPIA DE HISTORIA CLÍNICA"), 0, 'C');
        $logo = public_path() . "/logo.png";
        $this->Image($logo, 16, 14, -320);

        $this->SetXY(160, 14);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(15, 4, utf8_decode("Código:"));
        $this->SetFont('Arial', '', 10);
        $this->Cell(20, 4, " FO-CO-012");

        $this->SetXY(160, 20);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(15, 4, utf8_decode("Versión:"));
        $this->SetFont('Arial', '', 10);
        $this->Cell(10, 4, "03");

        $this->SetXY(160, 26);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(20, 4, utf8_decode("Fecha de aprobación:"));
        $this->SetXY(160, 30);
        $this->SetFont('Arial', '', 10);
        $this->Cell(20, 4, "21/12/2021");
        $this->ln();
        $this->ln();
        $this->ln();
    }

    public function footer()
    {
        $this->SetXY(20, 280);
        $this->MultiCell(180, 4, utf8_decode('Resolución 1995 de 1999, Artículo 14, Parágrafo: El acceso a la historia clínica, se entiende en todos los casos, única y exclusivamente para los fines que de acuerdo con la ley resulten procedentes, debiendo en todo caso, mantenerse la reserva legal. '), 0, 'C');
    }

    public function body()
    {
        $this->SetXY(16, 40);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(34, 4, utf8_decode('Fecha de solicitud:'), 0, 0, 'l');
        $this->SetFont('Arial', '', 5);
        $this->MultiCell(10, 4, ('DD'), 1, 'C');
        $this->SetXY(60, 40);
        $this->SetFont('Arial', '', 5);
        $this->MultiCell(10, 4, ('MM'), 1, 'C');
        $this->SetXY(70, 40);
        $this->SetFont('Arial', '', 5);
        $this->MultiCell(15, 4, ('AAAA'), 1, 'C');

        $this->ln();
        $this->SetX(16);
        $this->SetFont('Arial', '', 11);
        $this->Cell(10, 4, utf8_decode('Usuario ___ Tercero (Persona diferente al paciente) ____ ¿Cuál? _______________________________'), 0, 0, 'l');
        $this->ln();
        $y = $this->GetY();
        $this->SetXY(16, $y + 2);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(10, 4, utf8_decode('1.	Datos de quien solicita la Historia Clínica	'), 0, 0, 'l');
        $this->ln();
        $y = $this->GetY();
        $this->SetXY(16, $y + 2);
        $this->SetFont('Arial', '', 11);
        $this->Cell(10, 4, utf8_decode('Nombres y Apellidos ________________________________________ C.C. ______________________'), 0, 0, 'l');
        $this->ln();
        $y = $this->GetY();
        $this->SetXY(16, $y + 2);
        $this->SetFont('Arial', '', 11);
        $this->Cell(10, 4, utf8_decode('Correo Electrónico ____________________________________________________________________'), 0, 0, 'l');
        $this->ln();
        $y = $this->GetY();
        $this->SetXY(16, $y + 2);
        $this->SetFont('Arial', '', 11);
        $this->Cell(10, 4, utf8_decode('Teléfono __________________________'), 0, 0, 'l');
        $this->ln();
        $y = $this->GetY();
        $this->SetXY(16, $y + 2);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(10, 4, utf8_decode('2.	Datos del Usuario de la IPS SUMIMEDICAL - RED VITAL UT'), 0, 0, 'l');
        $this->ln();
        $y = $this->GetY();
        $this->SetXY(16, $y + 2);
        $this->SetFont('Arial', '', 10);
        $this->Cell(10, 4, utf8_decode('Nombres y Apellido ____________________________________ Documento de Identidad ___________________'), 0, 0, 'l');
        $this->ln();
        $y = $this->GetY();
        $this->SetXY(16, $y + 2);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(10, 4, utf8_decode('3.	¿Cuáles de los siguientes documentos se adjunta?'), 0, 0, 'l');
        $this->ln();
        $y = $this->GetY();
        $this->SetXY(16, $y + 2);
        $this->SetFont('Arial', '', 11);
        $this->Cell(10, 4, utf8_decode('___ Registro Civil				                                         ___ Poder Autenticado '), 0, 0, 'l');
        $this->ln();
        $y = $this->GetY();
        $this->SetXY(16, $y + 2);
        $this->SetFont('Arial', '', 11);
        $this->Cell(10, 4, utf8_decode('___ Acta de Registro de Defunción		               ___ Autorización'), 0, 0, 'l');
        $this->ln();
        $y = $this->GetY();
        $this->SetXY(16, $y + 2);
        $this->SetFont('Arial', '', 11);
        $this->Cell(10, 4, utf8_decode('___ Declaración Extra - Juicio		                       ___ Fotocopia cédula Usuario '), 0, 0, 'l');
        $this->ln();
        $y = $this->GetY();
        $this->SetXY(16, $y + 2);
        $this->SetFont('Arial', '', 11);
        $this->Cell(10, 4, utf8_decode('___ Certificación Médica                                 ___ Fotocopia cédula solicitante'), 0, 0, 'l');
        $this->ln();
        $y = $this->GetY();
        $this->SetXY(16, $y + 2);
        $this->SetFont('Arial', '', 11);
        $this->Cell(10, 4, utf8_decode('___ Sentencia Judicial                                    ___ Fotocopia del carnet que acredita Institución y rol'), 0, 0, 'l');
        $this->ln();
        $y = $this->GetY();
        $this->SetXY(16, $y + 3);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(10, 4, utf8_decode('4.	Finalidad. ¿Para que Requiere la Historia Clínica?'), 0, 0, 'l');
        $this->ln();
        $y = $this->GetY();
        $this->SetXY(16, $y + 2);
        $this->SetFont('Arial', '', 11);
        $this->Cell(10, 4, utf8_decode('___________________________________________________________________________________'), 0, 0, 'l');
        $this->ln();
        $y = $this->GetY();
        $this->SetXY(16, $y + 2);
        $this->SetFont('Arial', '', 11);
        $this->Cell(10, 4, utf8_decode('___________________________________________________________________________________'), 0, 0, 'l');
        $this->ln();
        $y = $this->GetY();
        $this->SetXY(16, $y + 2);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(10, 4, utf8_decode('5.	Indique el periodo del cual solicita la copia de historia clínica:'), 0, 0, 'l');
        $this->ln();
        $y = $this->GetY();
        $this->SetXY(16, $y + 3);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(24, 4, utf8_decode('Fecha inicial:'), 0, 0, 'l');
        $this->SetFont('Arial', '', 16);
        $this->MultiCell(10, 4, substr(substr('', 0, 2), 0, 1), 1, 'C');
        $this->SetXY(50, $y + 3);
        $this->SetFont('Arial', '', 16);
        $this->MultiCell(10, 4, substr(substr('', 0, 2), 1, 1), 1, 'C');
        $this->SetXY(60, $y + 3);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(15, 4, substr(substr('', 0, 3), 2, 1), 1, 'C');
        $this->SetXY(100, $y + 3);
        $this->SetFont('Arial', 'B', 10);
        $this->MultiCell(24, 4, utf8_decode('Fecha final:'), 0, 'l');
        $this->SetXY(122, $y + 3);
        $this->SetFont('Arial', '', 16);
        $this->MultiCell(10, 4, substr(substr('', 0, 2), 1, 1), 1, 'C');
        $this->SetXY(132, $y + 3);
        $this->SetFont('Arial', '', 16);
        $this->MultiCell(10, 4, substr(substr('', 0, 2), 1, 1), 1, 'C');
        $this->SetXY(142, $y + 3);
        $this->SetFont('Arial', '', 16);
        $this->MultiCell(10, 4, substr(substr('', 0, 2), 1, 1), 1, 'C');

        $this->ln();
        $this->SetX(16);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(10, 4, utf8_decode('6.	Autorizo que la entrega por Correo electrónico:'), 0, 0, 'l');
        $y = $this->GetY();
        $this->SetXY(109, $y);
        $this->SetFont('Arial', '', 11);
        $this->Cell(10, 4, utf8_decode('Si__________ No __________'), 0, 0, 'l');
        $this->ln();
        $y = $this->GetY();
        $this->SetXY(16, $y + 4);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(10, 4, utf8_decode('7. Firma del usuario o Solicitante:'), 0, 0, 'l');
        $this->SetXY(79, $y + 4);
        $this->SetFont('Arial', '', 11);
        $this->Cell(10, 4, utf8_decode('_________________________'), 0, 0, 'l');
        $this->SetXY(149, $y + 4);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(10, 4, utf8_decode('Huella:'), 0, 0, 'l');
        $y = $this->GetY();
        $this->Line(165, $y, 188, $y);
        $this->Line(165, $y, 165, $y + 24);
        $this->Line(188, $y, 188, $y + 24);
        $this->Line(165, $y + 24, 188, $y + 24);

        $this->ln();
        $this->SetX(16);
        $this->SetFont('Arial', 'B', 10);
        $y = $this->GetY();
        $this->SetXY(16, $y + 22);
        $this->Cell(10, 4, utf8_decode('AVISO DE PRIVACIDAD '), 0, 0, 'l');
        $this->ln();
        $y = $this->GetY();
        $this->SetXY(16, $y + 2);
        $this->SetFont('Arial', '', 9);
        $this->MultiCell(180, 4, utf8_decode('En IPS SUMIMEDICAL _ RED VITAL UT queremos comunicarle que los datos personales que le solicitamos y que usted suministra en el presente formulario serás trasladados de manera segura y confidencial para analizar si es viable o no entregar la historia clínica que ha solicitado.'), 0, 'l');
        $this->SetXY(16, $y + 14);
        $this->SetFont('Arial', '', 9);
        $this->MultiCell(180, 4, utf8_decode('El tratamiento de los datos se realiza, adicionalmente, con el fin de evaluar el servicio prestado, atención al usuario y para aquellas otras finalidades necesariamente conexas con las funciones que la ley otorga a las IPS. Para estos tratamientos RED VITAL UT- IPS SUMIMEDICAL podrá acudir a los datos personales de contacto suministrados usando cualquier tecnología presente o futura.'), 0, 'l');
        // $this->ln();
        $this->SetXY(16, $y + 30);
        $this->SetFont('Arial', '', 9);
        $this->MultiCell(180, 4, utf8_decode('Informamos que los datos personales podrán ser tratados por terceros, dentro o fuera de Colombia como encargados de tratamiento de acuerdo con las finalidades que ya mencionamos. También se podrán entregar sus datos a las autoridades facultadas para su tratamiento, conforme la ley.'), 0, 'l');
        $this->ln();
        $this->SetXY(16, $y + 42);
        $this->SetFont('Arial', '', 9);
        $this->MultiCell(180, 4, utf8_decode('Si desea conocer nuestra política de protección de datos, puedes consultarla en nuestro portal Web: https://sumimedical.com/nosotros/. Cualquier consulta, reclamación o duda o si desea ejercer el derecho de Habeas Data puedes escribirnos al correo electrónico gestiondocumental@sumimedical.com.'), 0, 'l');
    }
}
