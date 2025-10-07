<?php

use Codedge\Fpdf\Fpdf\Fpdf;
require('Fpdf/Fpdf.php');

class PDF extends FPDF
{
    function Header()
    {
        //logo - imagen
        $this->SetDrawColor(0, 0, 0);
        $this->Cell(8);
        $this->Cell(175, 30, '', 1, 1, 'C');
        $logo = "images/logo-redvital-1.png";
        $this->Image($logo, 21, 21, 42, 0);

        //lineas
        $this->SetDrawColor(0, 0, 0);
        $this->Line(65, 10, 65, 40);
        $this->Line(145, 10, 145, 40);
        $this->Line(145, 18, 193, 18);
        $this->Line(145, 26, 193, 26);

        //Texto del encabezado
        $this->SetFont('Arial', 'B', 12);
        $this->SetXY(22, 18);
        $this->SetTextColor(0, 0, 0);
        $this->MultiCell(158, 4, utf8_decode("        TRAMITE ADMINISTRATIVO
        POSTERIOR A NOTIFICACION DE
        CALIFICACIÓN DE PERDIDA DE
        CAPACIDAD LABORAL"), 0, 'C');

        $this->SetFont('Arial', 'B', 11);
        $this->SetXY(81, 12);
        $this->MultiCell(150, 4, utf8_decode("Código: "), 0, 'C');

        $this->SetFont('Arial', '', 11);
        $this->SetXY(99, 12);
        $this->MultiCell(150, 4, utf8_decode("OD-ML-011"), 0, 'C');

        $this->SetFont('Arial', 'B', 11);
        $this->SetXY(82, 20);
        $this->MultiCell(148, 4, utf8_decode("Versión: "), 0, 'C');

        $this->SetFont('Arial', '', 11);
        $this->SetXY(99, 20);
        $this->MultiCell(138, 4, utf8_decode("03"), 0, 'C');

        $this->SetFont('Arial', 'B', 11);
        $this->SetXY(110, 28);
        $this->MultiCell(118, 4, utf8_decode("Fecha de Actualización:"), 0, 'C');

        $this->SetFont('Arial', '', 11);
        $this->SetXY(110, 34);
        $this->MultiCell(120, 4, utf8_decode("15/02/2023"), 0, 'C');

        //Salto de pagina
        $this->ln();
    }

    function footer()
    {
        //Paginado
        $this->SetXY(178, 283);
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', '' , 10);
        $this->Cell(10, 2, utf8_decode('Página ').$this->PageNo().' de {nb}', 10, 10, 'C');
        $this->Ln();
        $this->SetFont('Arial', '' , 10);
        $this->SetXY(63, 288);
        $this->Cell(10, 2, utf8_decode('Una vez descargado o impreso este documento se considera copia no controlada'));
    }
}

        $pdf = new PDF;
        $pdf->AliasNbPages();
        $pdf->AddPage();

        //SubRayado
        $pdf->SetDrawColor(5, 63, 164);
        $pdf->Line(75, 103, 159, 103);
        $pdf->Line(43,227, 130, 227);


        //texto
        $pdf->SetFont('Arial','B', 11);
        $pdf->SetXY(15,50);
        $pdf->Write(5,utf8_decode('    EXPLICACIÓN TRÁMITE ADMINISTRATIVO POSTERIOR A NOTIFICACION DE PERDIDA DE
        CAPACIDAD LABORAL SUPERIOR A 50%, ES DECIR PENSIÓN DE INVALIDEZ'));

        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY(20, 73);
        $pdf->MultiCell(170, 5, utf8_decode('Una vez notificada en consulta médica el porcentaje de pérdida de capacidad laboral que le fue asignado al docente (porcentaje), explicación del mismo y manifestación de entendimiento por parte de este, el docente contara con 10 días siguientes a recibir la información (Dictamen y tablas de calificación) para manifestar cualquier tipo de inconformidad con dicha calificación. Esta solicitud de apelación debe ser enviada en oficio  al  correo  electrónico'),0, 'J');

        $pdf->SetFont('Arial' , '', 12);
        $pdf->SetXY(74,98);
        $pdf->SetTextColor(5, 63, 164);
        $pdf->Multicell(170, 5, utf8_decode('soportes.medicinalaboral@sumimedical.com'));

        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY(161, 98);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell(100, 5, utf8_decode('donde en este'),0, 'J');

        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY(20, 103);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell(100, 5, utf8_decode('se tramitará por parte de Medicina Laboral.'),0, 'J');


        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetXY(25, 115);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell(200, 5, utf8_decode('1). INCAPACIDAD ADMINISTRATIVA:'));


        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXy(25,121);
        $pdf->MultiCell(166, 5, utf8_decode('Las cuales continúan siendo dadas por el área de medicina laboral en cumplimiento del decreto 1655/2015 así:'), 0, 'J');

        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY(32, 137);
        $pdf->Cell(153, 5, utf8_decode('1. '));

        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY(37, 137);
        $pdf->MultiCell(153, 5, utf8_decode('Incapacidad administrativa inicial por 60 días (2 incapacidades de 30 días cada una), las cuales le son enviadas a su correo electrónico posterior a la notificación del dictamen de PCL.'), 0, 'J');

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetXY(32, 155);
        $pdf->MultiCell(153, 5, utf8_decode('2.'));

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetXY(37, 155);
        $pdf->MultiCell(153, 5, utf8_decode('Posterior a esos 60 días de incapacidad administrativa si usted no ha recibido la resolución que lo acredita como pensionado por invalidez por parte de Fiduprevisora / Ministerio de Educación Nacional enviar un correo electrónico con la copia del dictamen a la Secretaria de Educación Certificada a la cual usted pertenece de 2 a 3 días antes de que esta se venza la incapacidad administrativa actual con el fin de que ellos gestionen ante el operador de salud una nueva incapacidad administrativa por 30 días con la certeza de que la resolución de pensión para este docente no ha sido expedida y entregada a ellos.'), 0, 'J');

        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetXY(20, 208);
        $pdf->SetTextColor(22, 3, 255);
        $pdf->Write(5, utf8_decode('RESPONSABILIDAD DE LA SECRETARIA DE EDUCACION GESTION ADMINISTRATIVA'));

        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXy(20, 217);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell(171, 5, utf8_decode('Las Secretaria de Educación Certificada debe enviar al operador de salud al correo electrónico'), 0, 'J');

        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY(42, 222);
        $pdf->SetTextColor(5, 63, 164);
        $pdf->MultiCell(171, 5, utf8_decode('incapacidades.magisterio3@sumimedical.com'));

        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY(130, 222);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell(171, 5, utf8_decode(' toda  la  siguiente  información:'));

        $pdf->SetFont('Arial', '', 11);
        $pdf->SetXY(20,235);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell(171, 5, utf8_decode('En el ASUNTO anotar NOMBRE DEL DOCENTE, CC y SOLICITUD DE INCAPACIDAD ADMINISTRATIVA POR PENSIÓN POR PCL (esta solicitud debe ser enviada de 3- 4 días antes de que se termine la incapacidad), en el cuerpo del correo describir: '), 0, 'J');

        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY(20, 251);
        $pdf->MultiCell(171, 5, utf8_decode('
- Nombre y número de cedula de docente.
- Nombre completo de Institución educativa y municipio donde labora el docente.
- Adjuntar en formato PDF dictamen y tablas de calificación de la pérdida de capacidad laboral'), 0);

        //Segunda página


        $pdf->SetDrawColor(0 ,0 ,0);
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY(20, 295);
        $pdf->MultiCell(171, 5, utf8_decode('
Desde el correo electrónico donde realiza la solicitud se le enviará respuesta con la incapacidad administrativa cada mes que corresponda hasta que le sea generado la resolución de pensión por invalidez por parte del Ministerio de Educación Nacional / Fiduprevisora'), 0, 'J');

        //SubRayado segunda página
        $pdf->Line(44, 117, 56, 117);
        $pdf->SetDrawColor(5, 63, 164);
        $pdf->Line(108, 205, 192, 205);

        //Texto
        $pdf->SetFont('Arial', 'I', 12);
        $pdf->SetXY(47, 62);
        $pdf->MultiCell(171, 5, utf8_decode('(Es importante que usted y su Secretaria de educación certificada  a la cual'));


        $pdf->SetFont('Arial', 'I', 12);
        $pdf->SetXY(20, 67);
        $pdf->MultiCell(171, 5, utf8_decode('pertenece pongan en conocimiento al operador de salud sobre la expedición de dicha RESOLUCIÓN DE PENSION POR INVALIDEZ con el fin de que cese la expedición de incapacidades administrativas, ya que el operador de salud no es notificado por parte del Ministerio de Educación Nacional/ Fiduprevisora en el momento en que se surte dicho trámite).'), 0, 'J');

        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetXY(25, 105);
        $pdf->MultiCell(200, 5, utf8_decode('2). TRÁMITE DE LA PENSIÓN POR INVALIDEZ:'));

        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY(20, 112);
        $pdf->MultiCell(171, 5, utf8_decode('Asistir   con'));

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetXY(43, 112);
        $pdf->MultiCell(171, 5, utf8_decode('copia'));

        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY(54, 112);
        $pdf->MultiCell(171, 5, utf8_decode('  de  la   documentación  entregada  el  día  de  hoy  a  la  secretaría  de '));

        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY(20, 118);
        $pdf->MultiCell(171, 5, utf8_decode('educación  a  la   cual    pertenece'));

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetXY(81, 118);
        $pdf->MultiCell(171, 5, utf8_decode('    (siempre  usted  debe contar  con  los  documentos'));

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetX(20, 122);
        $pdf->MultiCell(171, 5, utf8_decode('originales de dictamen y tablas de calificación más una copia que  siempre permanezca en su poder con el fin de no tener contra tiempo para ninguno de sus trámites).'), 0, 'J');

        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY(20, 141);
        $pdf->MultiCell(171, 5, utf8_decode('Allí en la Secretaría  de Educación es  donde tramitarán  su pensión por invalidez  y  le  solicitarán los  documentos para la misma'), 0, 'J');

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetXY(101, 147);
        $pdf->MultiCell(171, 5, utf8_decode('con la mayor celeridad posible por parte de'));

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetXY(20, 152);
        $pdf->MultiCell(171, 5, utf8_decode('usted como docente y su empleador (En este trámite no interviene el operador de salud).'), 0, 'J');

        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetXY(25, 169);
        $pdf->MultiCell(200, 5, utf8_decode('3). REVISIÓN PENSIONAL EN 3 AÑOS:'));

        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY(20, 176);
        $pdf->MultiCell(171, 5, utf8_decode('El Decreto 1655/2015 reglamenta que cada 3 años el docente que fue pensionado debe tener una revisión pensional con Medicina laboral con el fin de mantener el porcentaje de pérdida de capacidad laboral, disminuirlo o aumentarlo según la evolución clínica del paciente; no necesita remisión. '), 0, 'J');

        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXy(30, 200);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell(163, 5, utf8_decode('- Se solicita la cita al  correo electrónico                                                                      del área de Medicina laboral '), 0, 'J');

        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY(107, 200);
        $pdf->SetTextColor(5, 63, 164);
        $pdf->MultiCell(171, 5, utf8_decode('soportes.medicinalaboral@sumimedical.com'));

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetXY(85, 205);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell(171, 5, utf8_decode('ojala 15 dias  hábiles antes de que se cumplan los  3 '), 0, 'J');

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetXY(30, 210);
        $pdf->MultiCell(171, 5, utf8_decode('y/o   antes  de cumplir  los  3  años'));

        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY(102, 210);
        $pdf->MultiCell(171, 5, utf8_decode('Para  que se  le  pueda  asignar esta cita  debe'));

        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY(30, 215);
        $pdf->MultiCell(163, 5, utf8_decode('adjuntar copia de las historias clínicas del médico especialista tratante relacionadas con las enfermedades y/o patologías que dieron origen a su pérdida de capacidad laboral superior a 50%, estas'),0, 'J');

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetXY(87, 225);
        $pdf->MultiCell(171, 5, utf8_decode('Historias clinicas'));

        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY(124,225);
        $pdf->MultiCell(171, 5, utf8_decode('obligatoriamente no pueden superar'));

        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY(30, 230);
        $pdf->MultiCell(163, 5, utf8_decode('los 12 meses previos a la cita programada, además de los documentos entregados el día de hoy'));

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetXY(51, 235);
        $pdf->MultiCell(163, 5,utf8_decode('(Dictamen y Tablas de calificación).'));

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetXY(20, 255);
        $pdf->SetTextColor(25, 50, 102);
        $pdf->MultiCell(171, 5, utf8_decode('Recuerde:'), 0, 'J');

        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY(20, 255);
        $pdf->SetTextColor(25, 50, 102);
        $pdf->MultiCell(171, 5, utf8_decode('               En el momento ya está reconocido por el área de medicina laboral como una persona con pérdida de la capacidad laboral superior al 50%, por lo cual, es de vital importancia la celeridad y cumplimiento de los trámites administrativos ante su empleador (secretaría de educación certificada a la que pertenece), con el fin de acceder a la'), 0, 'J');

        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY(20, 297);
        $pdf->MultiCell(171, 5, utf8_decode('que pertenece), con el fin de acceder a la condición de pensionado por invalidez ante el ministerio de educación nacional / fiduprevisora en los tiempos establecidos para ello. El dictamen, las tablas de calificación son enviadas al correo electrónico proporcionado por usted al igual que al de la secretaria de educación certificada a la cual usted pertenece y proporcionado por ellos.'),0 ,'J');

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(20, 100);
        $pdf->MultiCell(171, 5, utf8_decode('AREA DE MEDICINA LABORAL RED VITAL'),0 , 'J');

        $pdf->Output();
?>
