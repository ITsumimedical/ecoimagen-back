<?php
namespace App\Formats;

use Codedge\Fpdf\Fpdf\Fpdf;

class IntructivoValidacion1552 extends FPDF
{
    public function generar()
    {
        $pdf= new IntructivoValidacion1552('p', 'mm', 'A4');
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $this->body($pdf);
        $pdf->Output();
    }

    public function header()
    {
         //this
        //image
    }

    public function body($pdf)
    {
        $Y = 40;
        #IMAGEN Y DATOS EMPRESARIALES
        $pdf->SetFont('Arial', 'B', 9);
        $logo ="/images/logoEcoimagen.png";
        $pdf->Image($logo, 13, 10, -235);
        #NIT
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetXY(12, 37);
        $pdf->Cell(35, 3, utf8_decode('NIT:900033371-4 Res: 004'), 0, 0, 'L');
        #Titulo
        $pdf->SetXY(90, 20);
        $pdf->SetFont('Arial', 'B', 30);
        $pdf->Cell(70, 4, utf8_decode('Instructivo Validador'), 0, 0, 'C');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetX(90);
        $pdf->SetFont('Arial', 'B', 20);
        $pdf->Cell(65, 4, utf8_decode('Resolucion 1552'), 0, 0, 'C');
        #nota
        $pdf->SetXY(13,50);
        $pdf->SetTextColor(255, 0, 0);
        $pdf->SetFont('Arial', 'B', 7.5);
        $pdf->Cell(30, 4, utf8_decode('*Nota: los campos en Rojo son campos de validación de estructura por lo cual la información a ingresar debe coincidir con los campos requeridos'), 0, 0, 'L');
        $pdf->SetTextColor(0, 0, 0);

        #tabla hoja 1
        $pdf->Line(12, 58, 200, 58);
        $pdf->Line(12, 74, 200, 74);
        $pdf->Line(12, 86, 200, 86);
        $pdf->Line(12, 102, 200, 102);
        $pdf->Line(12, 114, 200, 114);
        $pdf->Line(12, 123, 200, 123);
        $pdf->Line(12, 130, 200, 130);
        $pdf->Line(12, 138, 200, 138);
        $pdf->Line(12, 146, 200, 146);
        $pdf->Line(12, 255, 200, 255);
        $pdf->Line(12, 266, 200, 266);
        $pdf->Line(12, 58, 12, 266);
        $pdf->Line(42, 58, 42, 266);
        $pdf->Line(200, 58, 200, 266);
        #cuerpo
        $pdf->SetXY(13,60);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(255, 0, 0);
        $pdf->Cell(30, 4, utf8_decode('Mes de reporte:'), 0, 0, 'L');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(150, 4, utf8_decode('En este campo se debe validar el mes a que hace referencia el reporte y  debe ser númerico (máximo 2 logitud), Ejemplo si el reporte corresponde al mes de enero este campo se diligencia como 01 y si corresponde a febrero se diligencia como 02 y así sucesisamente.'), 0, 'J');
        $pdf->Ln();
        $pdf->SetX(13);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->MultiCell(30, 4, utf8_decode('Nombre del usuario:'),0, 'L');
        $pdf->SetXY(43,76);
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(150, 4, utf8_decode('Se debe registrar el nombre completo del afiliado al que se le asignó la cita, el cual debe corresponder a usuarios afiliados de sumimedical.'), 0, 'J');
        $pdf->Ln();
        $pdf->SetX(13);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(255, 0, 0);
        $pdf->MultiCell(30, 4, utf8_decode('Tipo identificacion:'),0, 'L');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(43,88);
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(150, 4, utf8_decode('Se debe ingresar el tipo de documento el cual debe ser en letra, campo de máximo 2 de longitud, si es cedula se ingresa como CC, si es tarjeta de identidad TI, registro civil RC, acorde al tipo de documento que tiene el afiliado o lo establecido por la norma.'), 0, 'J');
        $pdf->Ln();
        $pdf->SetX(13);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(255, 0, 0);
        $pdf->MultiCell(30, 4, utf8_decode('Numero identificacion:'),0, 'L');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(43,104);
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(150, 4, utf8_decode('Este campo es númerico y corresponde al número de identificación del afiliado que se le asigna la cita el cual debe corresponder a población sumimedical.'), 0, 'J');
        $pdf->Ln();
        $pdf->SetX(13);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->MultiCell(30, 4, utf8_decode('Telefono:'),0, 'L');
        $pdf->SetXY(43,116);
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(150, 4, utf8_decode('Número de contacto del afiliado, en el dado caso de no tener telefono debe colocar 0.'), 0, 'J');
        $pdf->Ln();
        $pdf->SetX(13);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->MultiCell(30, 4, utf8_decode('Direccion:'),0, 'L');
        $pdf->SetXY(43,124);
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(150, 4, utf8_decode('Dirección de residencia del afiliado.'), 0, 'J');
        $pdf->Ln();
        $pdf->SetX(13);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->MultiCell(30, 4, utf8_decode('Ips primaria:'),0, 'L');
        $pdf->SetXY(43,132);
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(150, 4, utf8_decode('Punto de atención asignado para la atención del afiliado.'), 0, 'J');
        $pdf->Ln();
        $pdf->SetX(13);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->MultiCell(30, 4, utf8_decode('Division:'),0, 'L');
        $pdf->SetXY(43,140);
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(150, 4, utf8_decode('Departamento donde se encuentra.'), 0, 'J');
        $pdf->Ln();
        $pdf->SetX(13);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(255, 0, 0);
        $pdf->MultiCell(30, 4, utf8_decode('Servicio:'),0, 'L');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(43,148);
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(150, 4, utf8_decode('Ingresar el número del servicio al que pertenece la cita asignada, acorde al listado de código de servicios , este campo es númerico maximo dos de longitud.'), 0, 'J');
        $pdf->Ln();
        $pdf->SetX(70);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(45, 4, utf8_decode('               Servicio'), 1, 'C');
        $pdf->Cell(30, 4, utf8_decode('        Codigo'), 1, 'C');
        $pdf->Ln();
        $pdf->SetX(70);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(45, 4, utf8_decode('Cita Medicina General'), 1, 'C');
        $pdf->Cell(30, 4, utf8_decode('1'), 1, 'C');
        $pdf->Ln();
        $pdf->SetX(70);
        $pdf->Cell(45, 4, utf8_decode('Cita Odontologia General'), 1, 'C');
        $pdf->Cell(30, 4, utf8_decode('2'), 1, 'C');
        $pdf->Ln();
        $pdf->SetX(70);
        $pdf->Cell(45, 4, utf8_decode('Cita de Medicina Interna'), 1, 'C');
        $pdf->Cell(30, 4, utf8_decode('3'), 1, 'C');
        $pdf->Ln();
        $pdf->SetX(70);
        $pdf->Cell(45, 4, utf8_decode('Cita de Pediatría'), 1, 'C');
        $pdf->Cell(30, 4, utf8_decode('4'), 1, 'C');
        $pdf->Ln();
        $pdf->SetX(70);
        $pdf->Cell(45, 4, utf8_decode('Cita de Ginecología'), 1, 'C');
        $pdf->Cell(30, 4, utf8_decode('5'), 1, 'C');
        $pdf->Ln();
        $pdf->SetX(70);
        $pdf->Cell(45, 4, utf8_decode('Cita de Obstetricia'), 1, 'C');
        $pdf->Cell(30, 4, utf8_decode('6'), 1, 'C');
        $pdf->Ln();
        $pdf->SetX(70);
        $pdf->Cell(45, 4, utf8_decode('Cita de cirugia General'), 1, 'C');
        $pdf->Cell(30, 4, utf8_decode('7'), 1, 'C');
        $pdf->Ln();
        $pdf->SetX(70);
        $pdf->Cell(45, 4, utf8_decode('Cita de Medicina Familiar'), 1, 'C');
        $pdf->Cell(30, 4, utf8_decode('8'), 1, 'C');
        $pdf->Ln();
        $pdf->SetX(70);
        $pdf->Cell(45, 4, utf8_decode('Cita de Oftalmologia'), 1, 'C');
        $pdf->Cell(30, 4, utf8_decode('9'), 1, 'C');
        $pdf->Ln();
        $pdf->SetX(70);
        $pdf->Cell(45, 4, utf8_decode('Cita de Otorrinolaringologia'), 1, 'C');
        $pdf->Cell(30, 4, utf8_decode('10'), 1, 'C');
        $pdf->Ln();
        $pdf->SetX(70);
        $pdf->Cell(45, 4, utf8_decode('Cita de Psiquiatria'), 1, 'C');
        $pdf->Cell(30, 4, utf8_decode('11'), 1, 'C');
        $pdf->Ln();
        $pdf->SetX(70);
        $pdf->Cell(45, 4, utf8_decode('Cita de Ortopedia'), 1, 'C');
        $pdf->Cell(30, 4, utf8_decode('12'), 1, 'C');
        $pdf->Ln();
        $pdf->SetX(70);
        $pdf->Cell(45, 4, utf8_decode('Cita de Dermatologia'), 1, 'C');
        $pdf->Cell(30, 4, utf8_decode('13'), 1, 'C');
        $pdf->Ln();
        $pdf->SetX(70);
        $pdf->Cell(45, 4, utf8_decode('Cita de Urologia'), 1, 'C');
        $pdf->Cell(30, 4, utf8_decode('14'), 1, 'C');
        $pdf->Ln();
        $pdf->SetX(70);
        $pdf->Cell(45, 4, utf8_decode('Cita de Medicina laboral'), 1, 'C');
        $pdf->Cell(30, 4, utf8_decode('15'), 1, 'C');
        $pdf->Ln();
        $pdf->SetX(70);
        $pdf->Cell(45, 4, utf8_decode('Cita de odontologia esp.'), 1, 'C');
        $pdf->Cell(30, 4, utf8_decode('16'), 1, 'C');
        $pdf->Ln();
        $pdf->SetX(70);
        $pdf->Cell(45, 4, utf8_decode('Cita de optometria'), 1, 'C');
        $pdf->Cell(30, 4, utf8_decode('17'), 1, 'C');
        $pdf->Ln();
        $pdf->SetX(70);
        $pdf->Cell(45, 4, utf8_decode('Cita de nutrición'), 1, 'C');
        $pdf->Cell(30, 4, utf8_decode('18'), 1, 'C');
        $pdf->Ln();
        $pdf->SetX(70);
        $pdf->Cell(45, 4, utf8_decode('Cita de Psicologia'), 1, 'C');
        $pdf->Cell(30, 4, utf8_decode('19'), 1, 'C');
        $pdf->Ln();
        $pdf->SetX(70);
        $pdf->Cell(45, 4, utf8_decode('Cita de Anestesia'), 1, 'C');
        $pdf->Cell(30, 4, utf8_decode('20'), 1, 'C');
        $pdf->Ln();
        $pdf->SetX(70);
        $pdf->Cell(45, 4, utf8_decode('Cita de cirugia Plastica'), 1, 'C');
        $pdf->Cell(30, 4, utf8_decode('21'), 1, 'C');
        $pdf->Ln();
        $pdf->SetX(70);
        $pdf->Cell(45, 4, utf8_decode('Cita otras especialidades'), 1, 'C');
        $pdf->Cell(30, 4, utf8_decode('22'), 1, 'C');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetX(13);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(255, 0, 0);
        $pdf->MultiCell(30, 4, utf8_decode('Tipo consulta:'),0, 'L');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(43,256);
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(150, 4, utf8_decode('se debe ingresar el número 1: si la consulta fue Intramural, 2: Extramuralo Domiciliaria y 3: si es por Telemedicina.'), 0, 'J');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        #cuerpo hoja 2
        $pdf->SetX(13);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(255, 0, 0);
        $pdf->MultiCell(30, 4, utf8_decode('Codigo de EAPB:'),0, 'L');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(43,10);
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(150, 4, utf8_decode('informar el código de EPS a la cual se encuentra afiliado el usuario, recuerda que este campo es de máximo 6 de longitud, ejemplo si es usuario ferrocarriles el código es el EAS027, Si es magisterio es el RES004.'), 0, 'J');
        $pdf->Ln();
        #tabla hoja 2
        $pdf->Line(12, 9, 200, 9);
        $pdf->Line(12, 24, 200, 24);
        $pdf->Line(12, 277, 200, 277);
        $pdf->Line(12, 9, 12, 277);
        $pdf->Line(42, 9, 42, 277);
        $pdf->Line(200, 9, 200, 277);
        #cuero hoja 2
        $pdf->SetX(13);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(255, 0, 0);
        $pdf->MultiCell(30, 4, utf8_decode('Fecha usuario solicita la cita:'),0, 'L');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(43,26);
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(150, 4, utf8_decode('Este campo es númerico y se debe diligenciar en formato mes-día-año (MM-DD-AAAA) y corresponde a la fecha en que el usuario hizo la solicitud del servicio.

        Esta fecha no puede ser mayor a la fecha de asignación de la cita. Ejemplo: Fecha en la que el suario solicita la cita 03/30/2021   asignación de cita 03/25/2021.

        En caso de que el formato de fecha al diligenciarlo no sea mes-día-año, se puede cambiar de la siguiente forma:

        Seleccionar las fechas:'), 0, 'J');
        $logo ="/images/Excel_1.png";
        $pdf->Image($logo, 43, 72, -88);
        $pdf->SetXY(43,180);
        $pdf->Multicell(150, 4, utf8_decode('Clic en fecha'), 0, 'J');
        $logo ="/images/Excel_2.PNG";
        $pdf->Image($logo, 43, 190, -110);
        #hoja 3
        $pdf->SetXY(43,277);
        $pdf->Multicell(150, 4, utf8_decode('Luego clic en más formatos de número'), 0, 'J');
        #tabla hoja 3
        $pdf->Line(12, 9, 200, 9);
        $pdf->Line(12, 277, 200, 277);
        $pdf->Line(12, 9, 12, 277);
        $pdf->Line(42, 9, 42, 277);
        $pdf->Line(200, 9, 200, 277);
        $logo ="/images/Excel_3.PNG";
        $pdf->Image($logo, 43, 20, -110);
        $pdf->SetXY(43,143);
        $pdf->Multicell(150, 4, utf8_decode('Seleccionar Personalizada y en tipo diligenciar mm/dd/yyyy. Posteriormente clic en aceptar y automáticamente la fecha cambia al formato mes-día- año que se requiere'), 0, 'J');
        $logo ="/images/Excel_4.PNG";
        $pdf->Image($logo, 43, 157, -110);
        #hoja 4
        $pdf->SetXY(43,277);
        $pdf->Multicell(150, 4, utf8_decode('y ya queda realizado el cambio'), 0, 'J');
        #tabla hoja 4
        $pdf->Line(12, 9, 200, 9);
        $pdf->Line(12, 118, 200, 118);
        $pdf->Line(12, 134, 200, 134);
        $pdf->Line(12, 150, 200, 150);
        $pdf->Line(12, 162, 200, 162);
        $pdf->Line(12, 178, 200, 178);
        $pdf->Line(12, 9, 12, 178);
        $pdf->Line(42, 9, 42, 178);
        $pdf->Line(200, 9, 200, 178);
        $logo ="/images/Excel_5.png";
        $pdf->Image($logo, 43, 20, -110);
        $pdf->Ln();
        $pdf->SetXY(13,120);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(255, 0, 0);
        $pdf->MultiCell(30, 4, utf8_decode('Fecha usuario solicita asignada la cita:'),0, 'L');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(43,120);
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(150, 4, utf8_decode('Este campo es númerico y se debe diligenciar en formato mes-día-año (MM-DD-AAAA) y corresponde a la fecha en que la que el usuario solicitó le fuera asignada la cita (fecha deseada) para el servicio.'), 0, 'J');
        $pdf->Ln();
        $pdf->SetX(13);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(255, 0, 0);
        $pdf->MultiCell(30, 4, utf8_decode('Fecha asigna la cita:'),0, 'L');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(43,136);
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(150, 4, utf8_decode('Este campo es númerico y se debe diligenciar en formato mes-día-año (MM-DD-AAAA) y corresponde a la fecha para la cual se le asigna la consulta, es decir la fecha en la que accede al servicio.'), 0, 'J');
        $pdf->Ln();
        $pdf->SetX(13);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->MultiCell(30, 4, utf8_decode('Ips responsable:'),0, 'L');
        $pdf->SetXY(43,153);
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(150, 4, utf8_decode('Nombre de la Institución prestadora que realiza el reporte.'), 0, 'J');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetX(13);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->MultiCell(30, 4, utf8_decode('Codigo habilitacion:'),0, 'L');
        $pdf->SetXY(43,165);
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(150, 4, utf8_decode('Corresponde al código de habilitación asignado a la IPS, este campo es número de máximo 12 de longitud.'), 0, 'J');
        $pdf->Ln();
    }

    public function footer()
    {
        $this->SetXY(190, 287);
        $this->Cell(10, 4, utf8_decode('Página ').$this->PageNo().' de {nb}', 0, 0, 'C');
    }
}
