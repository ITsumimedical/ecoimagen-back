<?php

namespace App\Formats;

use App\Traits\PdfTrait;
use Codedge\Fpdf\Fpdf\Fpdf;

class Anexo3Medicamentos extends Fpdf
{
    use PdfTrait;

    protected static $ordenArticulo;
    protected static $afiliado;
    protected static $consulta;
    protected static $codesumi;
    protected static $historiaClinica;
    protected static $cie10DiagnosticoPpal;
    protected static $cie10DiagnosticoRelacionado;
    protected static $cie10Relacionado;
    protected static $cie10;

    public function generar($anexo3medicamentos)
    {
        self::$ordenArticulo = $anexo3medicamentos->ordenArticulo;
        self::$afiliado = $anexo3medicamentos->afiliado;
        self::$consulta = $anexo3medicamentos->consulta;
        self::$codesumi = $anexo3medicamentos->codesumi;
        self::$historiaClinica = $anexo3medicamentos->historiaClinica;
        self::$cie10DiagnosticoPpal = $anexo3medicamentos->cie10DiagnosticoPpal;
        self::$cie10 = $anexo3medicamentos->cie10;
        self::$cie10DiagnosticoRelacionado = $anexo3medicamentos->cie10DiagnosticoRelacionado;
        self::$cie10Relacionado = $anexo3medicamentos->cie10Relacionado;
        $this->generarPDF('I');
    }

    public function header()
    {
        $this->SetDrawColor(0, 0, 0);
        $this->Rect(4, 5, 202, 287);
        $this->SetDrawColor(0, 0, 0);
    }

    public function footer()
    {
        $this->SetXY(190, 287);

        $this->Cell(10, 4, utf8_decode('Página ') . $this->PageNo() . ' de {nb}', 0, 0, 'C');
    }

    public function body()
    {

        // Extraer la fecha y la hora del campo fecha_hora_inicio
        $fechaHoraOrden = self::$ordenArticulo->created_at;
        $fechaOrden = date('Y-m-d', strtotime($fechaHoraOrden));
        $horaOrden = date('H:i:s', strtotime($fechaHoraOrden));


        $this->SetFont('Arial', 'B', 9);
        $logo = public_path() . "/images/logo_colombia.png";
        $this->Image($logo, 10, 6, -1200);

        $this->SetFont('Arial', 'B', 9);
        $this->SetXY(14, 8);
        $this->Cell(192, 4, utf8_decode("ANEXO TECNICO No. 3"), 0, 0, 'R');


        $this->SetXY(10, 8);
        $this->SetFont('Arial', '', 12);
        $this->Cell(192, 4, utf8_decode('MINISTERIO DE SALUD Y PROTECCIÓN SOCIAL'), 0, 0, 'C');
        $this->SetXY(10, 19);
        $this->SetFont('Arial', '', 12);
        $this->Cell(192, 4, utf8_decode('SOLICITUD DE AUTORIZACION DE SERVICIOS DE SALUD'), 0, 0, 'C');
        $this->SetXY(10, 30);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(35, 4, utf8_decode('NUMERO DE SOLICITUD:'), 0, 0, 'l');
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr(self::$ordenArticulo->id ?? '', 0, 2), 0, 1), 1, 'C');
        $this->SetXY(50, 30);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr(self::$ordenArticulo->id ?? '', 0, 2), 1, 1), 1, 'C');
        $this->SetXY(55, 30);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr(self::$ordenArticulo->id ?? '', 0, 3), 2, 1), 1, 'C');
        $this->SetXY(60, 30);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr(self::$ordenArticulo->id ?? '', 0, 4), 3, 1), 1, 'C');
        $this->SetXY(65, 30);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr(self::$ordenArticulo->id ?? '', 0, 5), 4, 1), 1, 'C');
        $this->SetXY(70, 30);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr(self::$ordenArticulo->id ?? '', 0, 6), 5, 1), 1, 'C');
        $this->SetXY(75, 30);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr(self::$ordenArticulo->id ?? '', 0, 7), 6, 1), 1, 'C');
        $this->SetXY(80, 30);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr(self::$ordenArticulo->id ?? '', 0, 8), 7, 1), 1, 'C');
        $this->SetXY(85, 30);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr(self::$ordenArticulo->id ?? '', 0, 9), 8, 1), 1, 'C');
        $this->SetXY(90, 30);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr(self::$ordenArticulo->id ?? '', 0, 10), 9, 1), 1, 'C');

        $this->SetXY(98, 30);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(13, 4, utf8_decode('FECHA:'), 0, 0, 'l');
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr($fechaOrden ?? '', 0, 2), 0, 1), 1, 'C');
        $this->SetXY(116, 30);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr($fechaOrden ?? '', 0, 2), 1, 1), 1, 'C');
        $this->SetXY(121, 30);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr($fechaOrden ?? '', 0, 3), 2, 1), 1, 'C');
        $this->SetXY(126, 30);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr($fechaOrden ?? '', 0, 4), 3, 1), 1, 'C');
        $this->SetXY(131, 30);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr($fechaOrden ?? '', 0, 5), 4, 1), 1, 'C');
        $this->SetXY(136, 30);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr($fechaOrden ?? '', 0, 6), 5, 1), 1, 'C');
        $this->SetXY(141, 30);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr($fechaOrden ?? '', 0, 7), 6, 1), 1, 'C');
        $this->SetXY(146, 30);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr($fechaOrden ?? '', 0, 8), 7, 1), 1, 'C');
        $this->SetXY(151, 30);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr($fechaOrden ?? '', 0, 9), 8, 1), 1, 'C');
        $this->SetXY(156, 30);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr($fechaOrden ?? '', 0, 10), 9, 1), 1, 'C');

        $this->SetXY(165, 30);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(10, 4, utf8_decode('Hora:'), 0, 0, 'l');
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr($horaOrden ?? '', 0, 2), 0, 1), 1, 'C');
        $this->SetXY(180, 30);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr($horaOrden ?? '', 0, 2), 1, 1), 1, 'C');
        $this->SetXY(185, 30);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr($horaOrden ?? '', 0, 3), 2, 1), 1, 'C');
        $this->SetXY(190, 30);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr($horaOrden ?? '', 0, 4), 3, 1), 1, 'C');
        $this->SetXY(195, 30);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr($horaOrden ?? '', 0, 5), 4, 1), 1, 'C');

        $this->ln();
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(10, 4, utf8_decode('INFORMACIÓN DE PRESTADOR(solicitante)'), 0, 0, 'l');
        $this->ln();

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(90, 4, utf8_decode('Nombre ' . 'SUMIMEDICAL S.A.S'), 1, 0, 'l');
        $this->SetXY(110, 42);
        $this->SetFont('Arial', '', 7);
        $this->Cell(5, 4, utf8_decode('X'), 1, 0, 'l');
        $this->Cell(8, 4, utf8_decode('NIT'), 0, 0, 'l');
        $this->Cell(5, 4, utf8_decode(''), 1, 0, 'l');
        $this->Cell(8, 4, utf8_decode('CC'), 0, 0, 'l');

        $this->SetXY(145, 42);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr('', 0, 2), 0, 1), 1, 'C');
        $this->SetXY(150, 42);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr('', 0, 2), 1, 1), 1, 'C');
        $this->SetXY(155, 42);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr('', 0, 3), 2, 1), 1, 'C');
        $this->SetXY(160, 42);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr('', 0, 4), 3, 1), 1, 'C');
        $this->SetXY(165, 42);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr('', 0, 5), 4, 1), 1, 'C');
        $this->SetXY(170, 42);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr('', 0, 6), 5, 1), 1, 'C');
        $this->SetXY(175, 42);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr('', 0, 7), 6, 1), 1, 'C');
        $this->SetXY(180, 42);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr('', 0, 8), 7, 1), 1, 'C');
        $this->SetXY(185, 42);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr('', 0, 9), 8, 1), 1, 'C');
        $this->SetXY(190, 42);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr('', 0, 10), 9, 1), 1, 'C');
        $this->SetXY(195, 42);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr('', 0, 11), 10, 1), 1, 'C');

        $this->Cell(90, 4, utf8_decode(''), 1, 0, 'l');
        $this->SetXY(145, 46);
        $this->SetFont('Arial', '', 8);
        $this->Cell(55, 4, utf8_decode('Número                                                  DV'), 1, 0, 'l');

        $this->ln();
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(20, 4, utf8_decode('Código:'), 1, 0, 'l');
        $this->SetXY(30, 50);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr('0500109022', 0, 2), 0, 1), 1, 'C');
        $this->SetXY(35, 50);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr('0500109022', 0, 2), 1, 1), 1, 'C');
        $this->SetXY(40, 50);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr('0500109022', 0, 3), 2, 1), 1, 'C');
        $this->SetXY(45, 50);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr('0500109022', 0, 4), 3, 1), 1, 'C');
        $this->SetXY(50, 50);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr('0500109022', 0, 5), 4, 1), 1, 'C');
        $this->SetXY(55, 50);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr('0500109022', 0, 6), 5, 1), 1, 'C');
        $this->SetXY(60, 50);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr('0500109022', 0, 7), 6, 1), 1, 'C');
        $this->SetXY(65, 50);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr('0500109022', 0, 8), 7, 1), 1, 'C');
        $this->SetXY(70, 50);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr('0500109022', 0, 9), 8, 1), 1, 'C');
        $this->SetXY(75, 50);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr('0500109022', 0, 10), 9, 1), 1, 'C');
        $this->SetXY(80, 50);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr('0500109022', 0, 11), 10, 1), 1, 'C');
        $this->SetXY(85, 50);
        $this->SetFont('Arial', 'B', 9);
        $this->MultiCell(115, 4, utf8_decode('Dirección prestador ' . 'CL 47D No. 70-113'), 1, 'l');

        $this->Cell(20, 4, utf8_decode('Telefono:'), 1, 0, 'l');
        $this->SetXY(30, 54);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr('6044114488', 0, 2), 0, 1), 1, 'C');
        $this->SetXY(35, 54);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr('6044114488', 0, 2), 1, 1), 1, 'C');
        $this->SetXY(40, 54);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr('6044114488', 0, 3), 2, 1), 1, 'C');
        $this->SetXY(45, 54);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr('6044114488', 0, 4), 3, 1), 1, 'C');
        $this->SetXY(50, 54);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr('6044114488', 0, 5), 4, 1), 1, 'C');
        $this->SetXY(55, 54);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr('6044114488', 0, 6), 5, 1), 1, 'C');
        $this->SetXY(60, 54);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr('6044114488', 0, 7), 6, 1), 1, 'C');
        $this->SetXY(65, 54);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr('6044114488', 0, 8), 7, 1), 1, 'C');
        $this->SetXY(70, 54);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr('6044114488', 0, 9), 8, 1), 1, 'C');
        $this->SetXY(75, 54);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr('6044114488', 0, 10), 9, 1), 1, 'C');
        $this->SetXY(80, 54);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, substr(substr('6044114488', 0, 11), 10, 1), 1, 'C');
        $this->SetXY(85, 54);
        $this->SetFont('Arial', 'B', 8);
        $this->MultiCell(50, 4, utf8_decode('Departamento ANTIOQUIA'), 1, 'l');
        $this->SetXY(130, 54);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, utf8_decode('0'), 1, 'C');
        $this->SetXY(135, 54);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, utf8_decode('5'), 1, 'C');
        $this->SetXY(140, 54);
        $this->SetFont('Arial', 'B', 8);
        $this->MultiCell(50, 4, utf8_decode('Municipio Medellin'), 1, 'l');
        $this->SetXY(185, 54);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, utf8_decode('0'), 1, 'C');
        $this->SetXY(190, 54);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, utf8_decode('0'), 1, 'C');
        $this->SetXY(195, 54);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, utf8_decode('1'), 1, 'C');

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(145, 4, utf8_decode('ENTIDAD A LA QUE SE LE SOLICITA (PAGADOR): ' . 'SUMIMEDICAL S.A.S'), 1, 0, 'l');
        $this->SetXY(155, 58);
        $this->SetFont('Arial', 'B', 8);
        $this->MultiCell(15, 4, utf8_decode('Codigo'), 1, 'l');
        $this->SetXY(170, 58);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, utf8_decode('R'), 1, 'C');
        $this->SetXY(175, 58);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, utf8_decode('E'), 1, 'C');
        $this->SetXY(180, 58);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, utf8_decode('S'), 1, 'C');
        $this->SetXY(185, 58);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, utf8_decode('0'), 1, 'C');
        $this->SetXY(190, 58);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, utf8_decode('0'), 1, 'C');
        $this->SetXY(195, 58);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(5, 4, utf8_decode('4'), 1, 'C');

        $this->SetFont('Arial', 'B', 9);
        $this->Cell(190, 4, utf8_decode('DATOS PACIENTE'), 1, 0, 'C');
        $this->ln();
        $this->Cell(48, 4, utf8_decode(self::$afiliado->primer_nombre ?? ''), 1, 0, 'C');
        $this->Cell(47, 4, utf8_decode(self::$afiliado->segundo_nombre ?? ''), 1, 0, 'C');
        $this->Cell(48, 4, utf8_decode(self::$afiliado->primer_apellido ?? ''), 1, 0, 'C');
        $this->Cell(47, 4, utf8_decode(self::$afiliado->segundo_apellido ?? ''), 1, 0, 'C');
        $this->ln();
        $this->Cell(48, 4, utf8_decode('1er Apellido'), 0, 0, 'C');
        $this->Cell(47, 4, utf8_decode('2do Apellido'), 0, 0, 'C');
        $this->Cell(48, 4, utf8_decode('1er Nombre'), 0, 0, 'C');
        $this->Cell(47, 4, utf8_decode('2do Nombre'), 0, 0, 'C');


        $this->ln();
        $this->Cell(0, 4, utf8_decode('Tipo de Documento de identidad'), 0, 1, 'L');
        $this->ln(3);
        $this->SetFont('Arial', '', 8);

        // Coordenadas iniciales
        $x = $this->GetX();
        $y = $this->GetY();

        // Primera columna
        $this->Cell(5, 4, utf8_decode(self::$afiliado->tipo_documento == 3 ? 'X' : ''), 1, 0, 'C');
        $this->Cell(40, 4, utf8_decode('Registro civil'), 0, 1, 'L');
        $this->SetXY($x, $y + 6);
        $this->Cell(5, 4, utf8_decode(self::$afiliado->tipo_documento == 2 ? 'X' : ''), 1, 0, 'C');
        $this->Cell(40, 4, utf8_decode('Tarjeta de identidad'), 0, 1, 'L');
        $this->SetXY($x, $y + 12);
        $this->Cell(5, 4, utf8_decode(self::$afiliado->tipo_documento == 1 ? 'X' : ''), 1, 0, 'C');
        $this->Cell(40, 4, utf8_decode('Cedula de ciudadanía'), 0, 1, 'L');
        $this->SetXY($x, $y + 18);
        $this->Cell(5, 4, utf8_decode(self::$afiliado->tipo_documento == 5 ? 'X' : ''), 1, 0, 'C');
        $this->Cell(40, 4, utf8_decode('Cedula de extranjeria'), 0, 1, 'L');

        // Segunda columna
        $x2 = $x + 40; // Ajusta este valor para juntar más las columnas
        $y2 = $y;
        $this->SetXY($x2, $y2);
        $this->Cell(5, 4, utf8_decode(self::$afiliado->tipo_documento == 7 ? 'X' : ''), 1, 0, 'C');
        $this->Cell(40, 4, utf8_decode('Pasaporte'), 0, 1, 'L');
        $this->SetXY($x2, $y2 + 6);
        $this->Cell(5, 4, utf8_decode(self::$afiliado->tipo_documento == 13 ? 'X' : ''), 1, 0, 'C');
        $this->Cell(40, 4, utf8_decode('Adulto sin identificación'), 0, 1, 'L');
        $this->SetXY($x2, $y2 + 12);
        $this->Cell(5, 4, utf8_decode(self::$afiliado->tipo_documento == 14 ? 'X' : ''), 1, 0, 'C');
        $this->Cell(40, 4, utf8_decode('Menor sin identificación'), 0, 1, 'L');

        // Sección de Número de documento de identificación
        $x3 = $x2 + 60; // Ajusta este valor según sea necesario
        $y3 = $y2;
        $this->SetXY($x3, $y3);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(60, 4, utf8_decode('Número de documento de identificación'), 0, 1, 'L');
        $this->SetXY($x3, $y3 + 6);
        for ($i = 0; $i < 12; $i++) {
            // Cambiado a 12 para más dígitos
            $this->SetFont('Arial', '', 8);
            $this->Cell(5, 4, utf8_decode(isset(self::$afiliado->numero_documento[$i]) ? self::$afiliado->numero_documento[$i] : ''), 1, 0, 'C');
            $this->SetX($this->GetX()); // Espacio entre las celdas
        }
        $this->ln(10); // Espacio para la siguiente línea

        // Sección de Fecha de Nacimiento
        $this->SetXY($x3 - 19, $y3 + 18); // Ajusta este valor según sea necesario
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(40, 4, utf8_decode('Fecha de Nacimiento'), 0, 0, 'L'); // Cambiado a 0 para la misma línea
        $this->SetX($this->GetX() + 2);
        for ($i = 0; $i < 10; $i++) {
            $this->SetFont('Arial', '', 8);
            $this->Cell(5, 4, utf8_decode(isset(self::$afiliado->fecha_nacimiento[$i]) ? self::$afiliado->fecha_nacimiento[$i] : ''), 1, 0, 'C');
            $this->SetX($this->GetX()); // Espacio entre las celdas
        }

        // Sección de Dirección de Residencia Habitual y Teléfono
        $this->ln(8); // Espacio adicional entre secciones si es necesario
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(55, 4, utf8_decode('Dirección de Residencia Habitual: '), 1, 0, 'L');
        $this->Cell(135, 4, utf8_decode(self::$afiliado->direccion_residencia_cargue ?? ''), 1, 0, 'C');
        $this->Ln();
        $this->Cell(20, 4, utf8_decode('Teléfono:'), 1, 0, 'L');
        for ($i = 0; $i < 10; $i++) {
            $this->Cell(17, 4, utf8_decode(isset(self::$afiliado->telefono[$i]) ? self::$afiliado->telefono[$i] : ''), 1, 0, 'C');
        }
        $this->ln();

        // Sección de Departamento y Municipio
        $this->SetFont('Arial', 'B', 0);
        $this->Cell(85, 4, utf8_decode('DEPARTAMENTO:  ' . self::$afiliado->departamento_afiliacion->nombre ?? ''), 1, 0, 'L');
        $this->SetFont('Arial', '', 8);
        $this->Cell(5, 4, utf8_decode(isset(self::$afiliado->departamento_afiliacion->codigo_dane[0]) ? self::$afiliado->departamento_afiliacion->codigo_dane[0] : ''), 1, 0, 'C');
        $this->Cell(5, 4, utf8_decode(isset(self::$afiliado->departamento_afiliacion->codigo_dane[1]) ? self::$afiliado->departamento_afiliacion->codigo_dane[1] : ''), 1, 0, 'C');
        $this->SetFont('Arial', 'B', 0);
        $this->Cell(85, 4, utf8_decode('MUNICIPIO:  ' . self::$afiliado->municipio_afiliacion->nombre ?? ''), 1, 0, 'L');
        $this->SetFont('Arial', '', 8);
        $this->Cell(5, 4, utf8_decode(isset(self::$afiliado->municipio_afiliacion->codigo_dane[0]) ? self::$afiliado->municipio_afiliacion->codigo_dane[0] : ''), 1, 0, 'C');
        $this->Cell(5, 4, utf8_decode(isset(self::$afiliado->municipio_afiliacion->codigo_dane[1]) ? self::$afiliado->municipio_afiliacion->codigo_dane[1] : ''), 1, 0, 'C');
        $this->ln();

        // Sección de Teléfono Celular y Correo Electrónico
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(60, 4, utf8_decode('Teléfono Celular'), 1, 0, 'L');
        for ($i = 0; $i < 10; $i++) {
            $this->Cell(13, 4, utf8_decode(isset(self::$afiliado->celular1[$i]) ? self::$afiliado->celular1[$i] : ''), 1, 0, 'C');
        }
        $this->Ln();
        $this->Cell(50, 4, utf8_decode('Correo electrónico:'), 1, 0, 'L');
        $this->Cell(140, 4, utf8_decode(self::$afiliado->correo1 ?? ''), 1, 0, 'C');



        // Sección de Cobertura en salud
        $this->ln(6); // Espacio adicional entre secciones si es necesario
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(0, 4, utf8_decode('Cobertura en salud'), 0, 1, 'L');
        $this->ln(3);
        $this->SetFont('Arial', '', 7);

        // Primera fila
        $this->Cell(5, 4, utf8_decode(''), 1, 0, 'C');
        $this->Cell(40, 4, utf8_decode('Régimen Contributivo'), 0, 0, 'L');
        $this->Cell(5, 4, utf8_decode(''), 1, 0, 'C');
        $this->Cell(50, 4, utf8_decode('Régimen Subsidiado - Parcial'), 0, 0, 'L');
        $this->Cell(5, 4, utf8_decode(''), 1, 0, 'C');
        $this->Cell(50, 4, utf8_decode('Población Pobre no asegurada sin SISBEN'), 0, 0, 'L');
        $this->Cell(5, 4, utf8_decode(''), 1, 0, 'C');
        $this->Cell(40, 4, utf8_decode('Plan adicional de salud'), 0, 1, 'L');
        $this->ln(2);

        // Segunda fila
        $this->Cell(5, 4, utf8_decode(''), 1, 0, 'C');
        $this->Cell(40, 4, utf8_decode('Régimen Subsidiado - Total'), 0, 0, 'L');
        $this->Cell(5, 4, utf8_decode(''), 1, 0, 'C');
        $this->Cell(50, 4, utf8_decode('Población pobre No asegurada con SISBEN'), 0, 0, 'L');
        $this->Cell(5, 4, utf8_decode(''), 1, 0, 'C');
        $this->Cell(50, 4, utf8_decode('Desplazado'), 0, 0, 'L');
        $this->Cell(5, 4, utf8_decode('X'), 1, 0, 'C');
        $this->Cell(40, 4, utf8_decode('Otro'), 0, 1, 'L');

        // Sección de Información de la Atención y Servicios Solicitados
        $this->ln(8); // Espacio adicional entre secciones si es necesario
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(0, 4, utf8_decode('INFORMACIÓN DE LA ATENCIÓN Y SERVICIOS SOLICITADOS'), 1, 1, 'C');
        $this->ln(2);

        // Sub-sección: Origen de la atención
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(60, 4, utf8_decode('Origen de la atención'), 0, 1, 'L');
        $this->SetFont('Arial', '', 7);
        $this->ln(2);


        // Primera fila
        $this->Cell(5, 4, utf8_decode('X'), 1, 0, 'C');
        $this->Cell(35, 4, utf8_decode('Enfermedad General'), 0, 0, 'L');
        $this->Cell(5, 4, utf8_decode(''), 1, 0, 'C');
        $this->Cell(35, 4, utf8_decode('Accidente de Trabajo'), 0, 0, 'L');
        $this->Cell(5, 4, utf8_decode(''), 1, 0, 'C');
        $this->Cell(28, 4, utf8_decode('Evento Catastrófico'), 0, 0, 'L');
        $this->Cell(5, 4, utf8_decode(''), 1, 0, 'C');
        $this->Cell(52, 4, utf8_decode('Posterior a la atención inicial de urgencias'), 0, 0, 'L');
        $this->Cell(5, 4, utf8_decode(''), 1, 0, 'C');
        $this->Cell(35, 4, utf8_decode('Prioritaria'), 0, 1, 'L');
        $this->ln(2);

        // Segunda fila
        $this->Cell(5, 4, utf8_decode(''), 1, 0, 'C');
        $this->Cell(35, 4, utf8_decode('Enfermedad Profesional'), 0, 0, 'L');
        $this->Cell(5, 4, utf8_decode(''), 1, 0, 'C');
        $this->Cell(35, 4, utf8_decode('Accidente de Tránsito'), 0, 0, 'L');
        $this->Cell(5, 4, utf8_decode(''), 0, 0, 'C');
        $this->Cell(28, 4, utf8_decode(''), 0, 0, 'L');
        $this->Cell(5, 4, utf8_decode(''), 1, 0, 'C');
        $this->Cell(52, 4, utf8_decode('Servicios electivos'), 0, 0, 'L');
        $this->Cell(5, 4, utf8_decode(''), 1, 0, 'C');
        $this->Cell(35, 4, utf8_decode('No prioritaria'), 0, 1, 'L');
        $this->ln(2);

        // Línea horizontal que cierra esta sección
        $this->SetDrawColor(0, 0, 0);
        $this->Line($this->GetX() - 6, $this->GetY(), $this->GetX() + 196, $this->GetY());

        // Sección de Ubicación del Paciente al momento de la solicitud de autorización
        $this->ln(2); // Espacio adicional entre secciones si es necesario
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(0, 4, utf8_decode('Ubicación del Paciente al momento de la solicitud de autorización:'), 0, 1, 'L');
        $this->ln(3);
        $this->SetFont('Arial', '', 7);

        // Primera fila
        $this->Cell(5, 4, utf8_decode('X'), 1, 0, 'C');
        $this->Cell(35, 4, utf8_decode('Consulta Externa'), 0, 0, 'L');
        $this->Cell(5, 4, utf8_decode(''), 1, 0, 'C');
        $this->Cell(35, 4, utf8_decode('Hospitalización'), 0, 0, 'L');
        $this->Cell(12, 4, utf8_decode('Servicio'), 0, 0, 'L');
        $this->Cell(40, 4, utf8_decode(''), 1, 0, 'C');

        // Añadir espacio antes de la celda de "Cama"
        $this->Cell(5, 4, '', 0, 0, 'L'); // Ajusta este valor para cambiar el espacio
        $this->Cell(14, 4, utf8_decode('Cama'), 0, 0, 'L');

        // Añadir 6 celdas vacías para "Cama"
        for ($i = 0; $i < 6; $i++) {
            $this->Cell(5, 4, '', 1, 0, 'C');
        }
        $this->ln(6);

        // Segunda fila
        $this->Cell(5, 4, utf8_decode(''), 1, 0, 'C');
        $this->Cell(35, 4, utf8_decode('Urgencias'), 0, 0, 'L');
        $this->ln(7);

        // Línea horizontal que cierra esta sección
        $this->SetDrawColor(0, 0, 0);
        $this->Line($this->GetX() - 6, $this->GetY(), $this->GetX() + 196, $this->GetY());


        // self::$ordenArticuloArticulo = OrdenArticulo::where('orden_id', self::$ordenArticulo->id)->first();

        // Sección de Manejo Integral
        $this->ln(2); // Espacio adicional entre secciones si es necesario
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(0, 4, utf8_decode('Manejo integral según guía de: _________________________________________________________________________________'), 0, 1, 'L');
        $this->ln(3);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(50, 4, utf8_decode('Código CUMS'), 0, 0, 'L');
        $this->Cell(25, 4, utf8_decode('Cantidad'), 0, 0, 'L');
        $this->Cell(35, 4, utf8_decode('Descripción'), 0, 0, 'L');
        $this->ln(5);

        for ($i = 0; $i < 9; $i++) {
            $this->SetFont('Arial', '', 9);
            $this->Cell(5, 4, self::$codesumi->codigo[$i] ?? '', 1, 0, 'C');
        }

        $this->Cell(5, 4, utf8_decode(''), 0, 0, 'L');

        $cantidad = str_pad(self::$ordenArticulo->cantidad_medico ?? 0, 3, ' ', STR_PAD_LEFT); // Convertir la cantidad a una cadena de 3 caracteres
        for ($i = 0; $i < 3; $i++) {
            $this->Cell(5, 4, $cantidad[$i], 1, 0, 'C');
        }

        $this->Cell(10, 4, utf8_decode(''), 0, 0, 'L');

        $this->SetFont('Arial', '', 9);
        $this->SetFillColor(255, 255, 255);
        $this->MultiCell(35, 4, utf8_decode(self::$codesumi->nombre ?? ''), 0, 0, 'L');
        $this->ln(6);

        // Línea horizontal que cierra esta sección
        $this->SetDrawColor(0, 0, 0);
        $this->Line($this->GetX() - 6, $this->GetY(), $this->GetX() + 196, $this->GetY());

        // Sección de Ubicación del Paciente al momento de la solicitud de autorización
        $this->ln(2); // Espacio adicional entre secciones si es necesario
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(0, 4, utf8_decode('Justificación Clínica'), 0, 1, 'L');
        $this->ln(3);
        $this->SetFont('Arial', '', 7);

        $transcripcion = self::$ordenArticulo->orden->consulta->transcripcion;


        if (self::$consulta->tipo_consulta_id == 1) {
            $this->Cell(0, 4, utf8_decode($transcripcion->observaciones ?? ''), 0, 1, 'L');
        } else {
            $this->Cell(0, 4, utf8_decode(self::$historiaClinica->motivo_consulta . ' - ' . self::$historiaClinica->plan_manejo ?? ''), 0, 1, 'L');
        }

        $this->ln(6);
        // Obtener el médico que ordena la consulta
        $medicoOrdena = self::$consulta->medicoOrdena;
        // Obtener la primera especialidad del médico
        $primeraEspecialidad = $medicoOrdena->especialidades()->first();

        $nombreEspecialidad = $primeraEspecialidad ? $primeraEspecialidad->nombre : '';

        $this->SetFont('Arial', 'B', 8);
        $this->Cell(50, 4, utf8_decode('Impresión Diagnóstica:'), 0, 0, 'L');
        $this->Cell(25, 4, utf8_decode('Código CIE10'), 0, 0, 'L');
        $this->Cell(35, 4, utf8_decode('Descripción'), 0, 0, 'L');
        $this->ln(5);

        $this->SetFont('Arial', 'B', 9);
        $this->Cell(50, 4, utf8_decode('Diagnóstico Principal:'), 0, 0, 'L');

        for ($i = 0; $i < 4; $i++) {
            $this->SetFont('Arial', '', 9);
            $this->Cell(5, 4, self::$cie10->codigo_cie10[$i] ?? '', 1, 0, 'C');
        }

        $this->Cell(5, 4, utf8_decode(''), 0, 0, 'L');

        $this->SetFont('Arial', '', 9);
        $this->Cell(50, 4, utf8_decode(self::$cie10->nombre ?? ''), 0, 0, 'L');
        $this->ln(6);

        $this->SetFont('Arial', 'B', 9);
        $this->Cell(50, 4, utf8_decode('Diagnóstico relacionado 1:'), 0, 0, 'L');

        for ($i = 0; $i < 4; $i++) {
            $this->SetFont('Arial', '', 9);
            $this->Cell(5, 4, self::$cie10Relacionado->codigo_cie10[$i] ?? '', 1, 0, 'C');
        }

        $this->Cell(5, 4, utf8_decode(''), 0, 0, 'L');


        $this->SetFont('Arial', '', 9);
        $this->Cell(50, 4, utf8_decode(self::$cie10Relacionado->nombre ?? ''), 0, 0, 'L');
        $this->ln(7);

        $this->SetFont('Arial', 'B', 9);
        $this->Cell(0, 4, utf8_decode('INFORMACIÓN DE LA PERSONA QUE SOLICITA'), 1, 1, 'C');
        $this->Cell(120, 4, utf8_decode('Nombre de que solicita: ' . self::$consulta->medicoOrdena->operador->nombre_completo ?? ''), 1, 0, 'L');
        $this->Cell(70, 4, utf8_decode('Teléfono:' . self::$consulta->medicoOrdena->operador->telefono_recuperacion ?? ''), 1, 0, 'L');
        $this->ln(4);
        $this->Cell(120, 4, utf8_decode('Cargo o actividad: ' . $nombreEspecialidad), 1, 0, 'L');
    }
}
