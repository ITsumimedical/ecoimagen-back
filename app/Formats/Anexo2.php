<?php

namespace App\Formats;

use SplFileInfo;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Traits\ArchivosTrait;
use App\Http\Modules\AdmisionesUrgencias\Models\AdmisionesUrgencia;
use App\Traits\PdfTrait;

class Anexo2 extends Fpdf
{
    use ArchivosTrait;
    use PdfTrait;

    protected static $consulta;

    public function generar($consulta, $triage = null)
    {
        self::$consulta = $consulta;

        if ($triage) {
            $admision = AdmisionesUrgencia::find(self::$consulta->admision_urgencia_id);
            $ruta = 'adjuntosReferencia';
            $archivo = $this->Output("S");
            $nombreOriginal = $admision->codigo_centro_regulador . '/' . 'anexo tecnico 2' . self::$consulta->id . '.pdf';
            $nombre = 'historia_triage_' . self::$consulta->id . '.pdf';
            // Asegurarse de que la carpeta exista
            $directorio = storage_path("app/$ruta");
            if (!file_exists($directorio)) {
                mkdir($directorio, 0777, true); // Crear la carpeta si no existe
            }

            // Ruta completa del archivo
            $rutaCompleta = $directorio . '/' . $nombre;
            file_put_contents($rutaCompleta, $archivo);
            $this->subirArchivoNombre($ruta, new SplFileInfo($rutaCompleta), $nombreOriginal, 'fomag');
            if (file_exists($rutaCompleta)) {
                unlink($rutaCompleta);
            }
            return '/' . $ruta . '/' . $nombreOriginal;
        }
        $this->generarPDF('I');
    }

    public function header()
    {
        $this->SetDrawColor(0, 0, 0);
        $this->Rect(7, 7, 197, 284);
        $this->Rect(7, 7, 197, 284);
        $this->SetDrawColor(0, 0, 0);
    }

    public function footer()
    {
        $this->SetXY(190, 287);

        $this->Cell(10, 4, utf8_decode('Página ') . $this->PageNo() . ' de {nb}', 0, 0, 'C');
    }

    public function body()
    {


        $this->SetFont('Arial', 'B', 9);
        $logo = public_path() . "/images/logo_colombia.png";
        $this->Image($logo, 10, 7, -1400);

        $this->SetFont('Arial', 'B', 9);
        $this->SetXY(14, 11);
        $this->Cell(195, 15, utf8_decode("ANEXO TÉCNICO No. 2"), 0, 0, 'C');


        $this->SetXY(10, 8);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(192, 4, utf8_decode('MINISTERIO DE SALUD Y PROTECCIÓN SOCIAL'), 0, 0, 'C');

        $this->SetXY(10, 20);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(192, 5, utf8_decode('INFORME DE LA ATENCIÓN INICIAL DE URGENCIAS'), 0, 0, 'C');

        $this->SetXY(74, 28);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(30, 5, utf8_decode('NUMERO DE ATENCIÓN '), 0, 0, 'l');
        $this->SetXY(105, 28);
        $this->Cell(13, 5, utf8_decode(self::$consulta->id), 1, 1, 'L');

        $this->SetXY(122, 28);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(15, 5, utf8_decode('FECHA '), 0, 0, 'l');
        $this->SetXY(133, 28);
        $this->Cell(23, 5, utf8_decode(substr(self::$consulta->hora_fin_atendio_consulta, 0, 10)), 1, 1, 'L');
        $partes = explode(' ', self::$consulta->hora_fin_atendio_consulta);
        $hora = $partes[0];
        $this->SetXY(160, 28);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(15, 5, utf8_decode('HORA '), 0, 0, 'l');
        $this->SetXY(170, 28);
        $this->Cell(23, 5, utf8_decode($hora), 1, 1, 'L');

        $this->SetXY(7, 35);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(102, 5, utf8_decode('INFORMACIÓN DEL PRESTADOR'), 0, 0, 'L');

        //---------------------linea 1------------------------------
        $this->SetXY(7, 40);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(15, 5, utf8_decode('Nombre'), 1, 0, 'L');
        $this->SetXY(22, 40);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(137, 5, utf8_decode('MEDICINA INTEGRAL S.A.S'), 1, 0, 'L');

        $this->SetXY(160, 40);
        $this->SetFont('Arial', '', 9);
        $this->Cell(10, 5, utf8_decode('NIT'), 0, 0, 'L');
        $this->SetXY(167, 40);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(5, 5, utf8_decode('X'), 1, 0, 'L');

        $this->SetXY(175, 40);
        $this->SetFont('Arial', '', 9);
        $this->Cell(23, 5, utf8_decode('800250634'), 1, 0, 'L');
        $this->SetXY(198, 40);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(6, 5, utf8_decode('3'), 1, 0, 'L');

        //---------------------linea 2------------------------------
        $this->SetXY(7, 45);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(152, 5, utf8_decode(''), 1, 0, 'L');

        $this->SetXY(160, 45);
        $this->SetFont('Arial', '', 9);
        $this->Cell(10, 5, utf8_decode('CC'), 0, 0, 'L');
        $this->SetXY(167, 45);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(5, 5, utf8_decode(''), 1, 0, 'L');

        $this->SetXY(175, 45);
        $this->SetFont('Arial', '', 9);
        $this->Cell(23, 5, utf8_decode(''), 1, 0, 'L');
        $this->SetXY(198, 45);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(6, 5, utf8_decode(''), 1, 0, 'L');

        //---------------------linea 3------------------------------
        $this->SetXY(7, 50);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(15, 5, utf8_decode('Código'), 1, 0, 'L');
        $this->SetXY(22, 50);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(40, 5, utf8_decode('230010092401'), 1, 0, 'L');

        $this->SetXY(62, 50);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(38, 5, utf8_decode('Dirección del prestador:'), 1, 0, 'L');
        $this->SetXY(100, 50);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(104, 5, utf8_decode('CALLE 44 # 14 - 282 MONTERIA'), 1, 0, 'L');

        //---------------------linea 4------------------------------
        $this->SetXY(7, 55);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(15, 10, utf8_decode('Teléfono:'), 1, 0, 'L');
        $this->SetXY(22, 55);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(20, 5, utf8_decode('1'), 1, 0, 'L');
        $this->SetXY(42, 55);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(20, 5, utf8_decode('6046041571'), 1, 0, 'L');
        $this->SetXY(22, 60);
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(20, 5, utf8_decode('Indicativo'), 1, 0, 'C');
        $this->SetXY(42, 60);
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(20, 5, utf8_decode('Número'), 1, 0, 'C');

        $this->SetXY(62, 60);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(62, 5, utf8_decode('Departamento: CORDOBA'), 1, 0, 'L');
        $this->SetXY(124, 60);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(8, 5, utf8_decode('23'), 1, 0, 'L');
        $this->SetXY(132, 60);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(64, 5, utf8_decode('Municipio: MONTERIA '), 1, 0, 'L');
        $this->SetXY(196, 60);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(8, 5, utf8_decode('001'), 1, 0, 'L');

        //---------------------linea 5------------------------------
        $this->SetXY(7, 65);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(170, 5, utf8_decode('ENTIDAD A LA QUE SE LE INFORMA (PAGADOR) FIDEICOMISOS PATRIMONIOS AUTONOMOS FIDUCIARIA LA PREVISORA S.A.'), 1, 0, 'L');

        $this->SetXY(177, 65);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(27, 5, utf8_decode('CÓDIGO'), 1, 0, 'L');

        //---------------------linea 6------------------------------
        $this->SetXY(7, 70);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(197, 5, utf8_decode('DATOS DEL PACIENTE'), 1, 0, 'C');

        //---------------------linea 7------------------------------
        $this->SetXY(7, 75);
        $this->SetFont('Arial', '', 9);
        $this->Cell(49, 5, utf8_decode(self::$consulta->afiliado->primer_apellido), 1, 0, 'C');

        $this->SetXY(56, 75);
        $this->SetFont('Arial', '', 9);
        $this->Cell(49, 5, utf8_decode(self::$consulta->afiliado->segundo_apellido), 1, 0, 'C');

        $this->SetXY(105, 75);
        $this->SetFont('Arial', '', 9);
        $this->Cell(49, 5, utf8_decode(self::$consulta->afiliado->primer_nombre), 1, 0, 'C');

        $this->SetXY(154, 75);
        $this->SetFont('Arial', '', 9);
        $this->Cell(50, 5, utf8_decode(self::$consulta->afiliado->segundo_nombre), 1, 0, 'C');

        //---------------------linea 8------------------------------
        $this->SetXY(7, 80);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(49, 5, utf8_decode('1er Apellido'), 0, 0, 'C');

        $this->SetXY(56, 80);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(49, 5, utf8_decode('2do Apellido'), 0, 0, 'C');

        $this->SetXY(105, 80);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(49, 5, utf8_decode('1er Nombre'), 0, 0, 'C');

        $this->SetXY(154, 80);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(50, 5, utf8_decode('2do Nombre'), 0, 0, 'C');

        //---------------------linea 9------------------------------
        //Tipo documento de identidad
        $this->ln();
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(0, 4, utf8_decode('Tipo de Documento de identidad'), 0, 1, 'L');
        $this->ln(3);
        $this->SetFont('Arial', '', 8);

        // Coordenadas iniciales
        $x = $this->GetX();
        $y = $this->GetY();

        // Primera columna
        $this->Cell(5, 4, utf8_decode(self::$consulta->afiliado->tipo_documento == 3 ? 'X' : ''), 1, 0, 'C');
        $this->Cell(40, 4, utf8_decode('Registro civil'), 0, 1, 'L');
        $this->SetXY($x, $y + 4);
        $this->Cell(5, 4, utf8_decode(self::$consulta->afiliado->tipo_documento == 2 ? 'X' : ''), 1, 0, 'C');
        $this->Cell(40, 4, utf8_decode('Tarjeta de identidad'), 0, 1, 'L');
        $this->SetXY($x, $y + 8);
        $this->Cell(5, 4, utf8_decode(self::$consulta->afiliado->tipo_documento == 1 ? 'X' : ''), 1, 0, 'C');
        $this->Cell(40, 4, utf8_decode('Cedula de ciudadanía'), 0, 1, 'L');
        $this->SetXY($x, $y + 12);
        $this->Cell(5, 4, utf8_decode(self::$consulta->afiliado->tipo_documento == 5 ? 'X' : ''), 1, 0, 'C');
        $this->Cell(40, 4, utf8_decode('Cedula de extranjeria'), 0, 1, 'L');

        // Segunda columna
        $x2 = $x + 40; // Ajusta este valor para juntar más las columnas
        $y2 = $y;
        $this->SetXY($x2, $y2);
        $this->Cell(5, 4, utf8_decode(self::$consulta->afiliado->tipo_documento == 7 ? 'X' : ''), 1, 0, 'C');
        $this->Cell(40, 4, utf8_decode('Pasaporte'), 0, 1, 'L');
        $this->SetXY($x2, $y2 + 4);
        $this->Cell(5, 4, utf8_decode(self::$consulta->afiliado->tipo_documento == 13 ? 'X' : ''), 1, 0, 'C');
        $this->Cell(40, 4, utf8_decode('Adulto sin identificación'), 0, 1, 'L');
        $this->SetXY($x2, $y2 + 8);
        $this->Cell(5, 4, utf8_decode(self::$consulta->afiliado->tipo_documento == 14 ? 'X' : ''), 1, 0, 'C');
        $this->Cell(40, 4, utf8_decode('Menor sin identificación'), 0, 1, 'L');

        $x3 = $x2 + 60;
        $y3 = $y2;
        $this->SetXY($x3 + 20, $y3 - 2);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(60, 4, utf8_decode(self::$consulta->afiliado->numero_documento), 1, 1, 'L');

        $this->SetXY($x3 + 20, $y3 + 3);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(60, 4, utf8_decode('Número de documento de identificación'), 0, 1, 'C');


        $this->SetXY($x3 + 2, $y3 + 11);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(60, 5, utf8_decode('Fecha de nacimiento'), 0, 1, 'C');

        $this->SetXY($x3 + 47, $y3 + 11);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(30, 5, utf8_decode(self::$consulta->afiliado->fecha_nacimiento), 1, 1, 'C');

        //---------------------linea 10------------------------------
        $this->SetXY(7, 108);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(150, 5, utf8_decode('Dirección de residencia habitual: ' . self::$consulta->afiliado->direccion_residencia_cargue), 1, 0, 'L');

        $this->SetXY(157, 108);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(47, 5, utf8_decode('Teléfono:' . self::$consulta->afiliado->telefono), 1, 0, 'L');

        //---------------------linea 11------------------------------
        $this->SetXY(7, 113);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(94, 5, utf8_decode('Departamento: ' . self::$consulta->afiliado->departamento_atencion->nombre), 1, 0, 'L');
        $this->SetXY(101, 113);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(9, 5, utf8_decode(self::$consulta->afiliado->departamento_atencion->codigo_dane), 1, 0, 'L');
        $this->SetXY(110, 113);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(84, 5, utf8_decode('Municipio: ' . self::$consulta->afiliado->municipio_atencion->nombre), 1, 0, 'L');
        $this->SetXY(194, 113);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(10, 5, utf8_decode(self::$consulta->afiliado->municipio_atencion->codigo_dane), 1, 0, 'L');


        // Sección de Cobertura en salud
        $this->ln(6); // Espacio adicional entre secciones si es necesario
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(0, 4, utf8_decode('Cobertura en salud'), 0, 1, 'L');
        $this->ln(3);
        $this->SetFont('Arial', '', 7);

        // Primera fila
        $this->Cell(5, 3, utf8_decode(''), 1, 0, 'C');
        $this->Cell(40, 3, utf8_decode('Régimen Contributivo'), 0, 0, 'L');
        $this->Cell(5, 3, utf8_decode(''), 1, 0, 'C');
        $this->Cell(50, 3, utf8_decode('Régimen Subsidiado - Parcial'), 0, 0, 'L');
        $this->Cell(5, 3, utf8_decode(''), 1, 0, 'C');
        $this->Cell(50, 3, utf8_decode('Población Pobre no asegurada sin SISBEN'), 0, 0, 'L');
        $this->Cell(5, 3, utf8_decode(''), 1, 0, 'C');
        $this->Cell(40, 3, utf8_decode('Plan adicional de salud'), 0, 1, 'L');
        $this->ln(2);

        // Segunda fila
        $this->Cell(5, 3, utf8_decode(''), 1, 0, 'C');
        $this->Cell(40, 3, utf8_decode('Régimen Subsidiado - Total'), 0, 0, 'L');
        $this->Cell(5, 3, utf8_decode(''), 1, 0, 'C');
        $this->Cell(50, 3, utf8_decode('Población pobre No asegurada con SISBEN'), 0, 0, 'L');
        $this->Cell(5, 3, utf8_decode(''), 1, 0, 'C');
        $this->Cell(50, 3, utf8_decode('Desplazado'), 0, 0, 'L');
        $this->Cell(5, 3, utf8_decode(''), 1, 0, 'C');
        $this->Cell(40, 3, utf8_decode('Otro'), 0, 1, 'L');

        $this->ln();
        $this->SetXY(7, 135);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(197, 5, utf8_decode('INFORMACIÓN DE LA ATENCIÓN'), 1, 1, 'C');
        $this->ln(2);

        // Sub-sección: Origen de la atención
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(60, 4, utf8_decode('Origen de la atención'), 0, 1, 'L');
        $this->SetFont('Arial', '', 7);
        $this->ln(2);


        // Primera fila
        $this->Cell(5, 3, utf8_decode(''), 1, 0, 'C');
        $this->Cell(35, 3, utf8_decode('Enfermedad General'), 0, 0, 'L');
        $this->Cell(5, 3, utf8_decode(''), 1, 0, 'C');
        $this->Cell(35, 3, utf8_decode('Accidente de Trabajo'), 0, 0, 'L');
        $this->Cell(5, 3, utf8_decode(''), 1, 0, 'C');
        $this->Cell(28, 3, utf8_decode('Evento Catastrófico'), 0, 0, 'L');
        $this->Cell(5, 3, utf8_decode(''), 0, 0, 'C');
        $this->Cell(28, 3, utf8_decode(''), 0, 0, 'L');
        $this->Cell(5, 3, utf8_decode(self::$consulta->HistoriaClinica->triage == 'TRIAGE I' ? 'X' : ''), 1, 0, 'C');
        $this->Cell(35, 3, utf8_decode('Rojo'), 0, 1, 'L');
        $this->ln(2);

        // Segunda fila
        $this->Cell(5, 3, utf8_decode(''), 1, 0, 'C');
        $this->Cell(35, 3, utf8_decode('Enfermedad Profesional'), 0, 0, 'L');
        $this->Cell(5, 3, utf8_decode(''), 1, 0, 'C');
        $this->Cell(35, 3, utf8_decode('Accidente de Tránsito'), 0, 0, 'L');
        $this->Cell(5, 3, utf8_decode(''), 0, 0, 'C');
        $this->Cell(28, 3, utf8_decode(''), 0, 0, 'L');
        $this->Cell(5, 3, utf8_decode(''), 0, 0, 'C');
        $this->Cell(28, 3, utf8_decode(''), 0, 0, 'L');
        $this->Cell(5, 3, utf8_decode(self::$consulta->HistoriaClinica->triage == 'TRIAGE II' ? 'X' : ''), 1, 0, 'C');
        $this->Cell(35, 3, utf8_decode('Amarillo'), 0, 1, 'L');
        $this->ln(2);

        // tercera fila
        $this->Cell(5, 3, utf8_decode(''), 0, 0, 'C');
        $this->Cell(35, 3, utf8_decode(''), 0, 0, 'L');
        $this->Cell(5, 3, utf8_decode(''), 0, 0, 'C');
        $this->Cell(35, 3, utf8_decode(''), 0, 0, 'L');
        $this->Cell(5, 3, utf8_decode(''), 0, 0, 'C');
        $this->Cell(28, 3, utf8_decode(''), 0, 0, 'L');
        $this->Cell(5, 3, utf8_decode(''), 0, 0, 'C');
        $this->Cell(28, 3, utf8_decode(''), 0, 0, 'L');
        $this->Cell(5, 3, utf8_decode(self::$consulta->HistoriaClinica->triage == 'TRIAGE III' ? 'X' : ''), 1, 0, 'C');
        $this->Cell(35, 3, utf8_decode('Verde'), 0, 1, 'L');
        $this->ln(2);

        $this->SetXY(123, 152);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(20, 4, utf8_decode('Clasificación triage'), 0, 0, '6');


        // Línea horizontal que cierra esta sección
        $this->SetXY(7, 172);
        $this->SetDrawColor(0, 0, 0);
        $this->Line($this->GetX(), $this->GetY() - 10, $this->GetX() + 197, $this->GetY() - 10);

        $this->SetXY(10, 162);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(20, 4, utf8_decode('Ingreso a urgencias'), 0, 0, '6');

        //-------------------- linea 13 -------------------------------

        $this->SetXY(18, 167);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(15, 5, utf8_decode('FECHA '), 0, 0, 'l');
        $this->SetXY(30, 167);
        $this->Cell(13, 5, utf8_decode(substr(self::$consulta->hora_inicio_atendio_consulta, 0, 10)), 1, 1, 'L');

        $this->SetXY(60, 167);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(15, 5, utf8_decode('HORA '), 0, 0, 'l');
        $this->SetXY(70, 167);
        $this->Cell(23, 5, utf8_decode(''), 1, 1, 'L');

        $this->SetXY(110, 167);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(30, 5, utf8_decode('Paciente viene remitido ? '), 0, 0, 'l');
        $this->SetXY(151, 167);
        $this->Cell(5, 5, utf8_decode(''), 1, 1, 'L');
        $this->SetXY(156, 167);
        $this->Cell(23, 5, utf8_decode('Si'), 0, 1, 'L');
        $this->SetXY(165, 167);
        $this->Cell(5, 5, utf8_decode(''), 1, 1, 'L');
        $this->SetXY(170, 167);
        $this->Cell(23, 5, utf8_decode('No'), 0, 1, 'L');

        //---------------------linea 14 ------------------------------
        $this->SetXY(7, 175);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(170, 5, utf8_decode('Nombre del Prestador de Servicios de Salud que remite'), 1, 0, 'L');

        $this->SetXY(177, 175);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(27, 5, utf8_decode('CÓDIGO'), 1, 0, 'L');

        //---------------------linea 15------------------------------
        $this->SetXY(7, 185);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(94, 5, utf8_decode('Departamento: '), 1, 0, 'L');
        $this->SetXY(101, 185);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(9, 5, utf8_decode(' '), 1, 0, 'L');
        $this->SetXY(110, 185);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(84, 5, utf8_decode('Municipio: '), 1, 0, 'L');
        $this->SetXY(194, 185);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(10, 5, utf8_decode(' '), 1, 0, 'L');

        //---------------------linea 16------------------------------
        $this->SetXY(7, 190);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(197, 5, utf8_decode('Motivo de consulta:'), 1, 0, 'L');

        //---------------------linea 17------------------------------
        $this->SetXY(7, 195);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(197, 13, utf8_decode(''), 1, 0, 'L');

        //---------------------linea 18------------------------------
        $this->SetXY(9, 210);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(40, 5, utf8_decode('Impresión Diagnóstica:'), 0, 0, 'L');
        $this->SetXY(48, 210);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(40, 5, utf8_decode('Código CIE 10'), 0, 0, 'L');
        $this->SetXY(75, 210);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(40, 5, utf8_decode('Descripción'), 0, 0, 'L');

        //---------------------linea 19------------------------------
        $this->SetXY(9, 218);
        $this->SetFont('Arial', '', 8);
        $this->Cell(40, 5, utf8_decode('Diagnóstico principal:'), 0, 0, 'L');
        $this->SetXY(51, 218);
        $this->SetFont('Arial', '', 8);
        $this->Cell(15, 5, utf8_decode(''), 1, 0, 'L');
        $this->SetXY(75, 218);
        $this->SetFont('Arial', '', 8);
        $this->Cell(120, 5, utf8_decode(''), 0, 0, 'L');
        $this->SetXY(76, 218);
        $this->SetDrawColor(0, 0, 0);
        $this->Line($this->GetX(), $this->GetY() + 5, $this->GetX() + 125, $this->GetY() + 5);

        //---------------------linea 20------------------------------
        $this->SetXY(9, 223);
        $this->SetFont('Arial', '', 8);
        $this->Cell(40, 5, utf8_decode('Diagnóstico relacionado 1:'), 0, 0, 'L');
        $this->SetXY(51, 223);
        $this->SetFont('Arial', '', 8);
        $this->Cell(15, 5, utf8_decode(''), 1, 0, 'L');
        $this->SetXY(75, 223);
        $this->SetFont('Arial', '', 8);
        $this->Cell(120, 5, utf8_decode(''), 0, 0, 'L');
        $this->SetXY(76, 223);
        $this->SetDrawColor(0, 0, 0);
        $this->Line($this->GetX(), $this->GetY() + 5, $this->GetX() + 125, $this->GetY() + 5);

        //---------------------linea 21------------------------------
        $this->SetXY(9, 228);
        $this->SetFont('Arial', '', 8);
        $this->Cell(40, 5, utf8_decode('Diagnóstico relacionado 2:'), 0, 0, 'L');
        $this->SetXY(51, 228);
        $this->SetFont('Arial', '', 8);
        $this->Cell(15, 5, utf8_decode(''), 1, 0, 'L');
        $this->SetXY(75, 228);
        $this->SetFont('Arial', '', 8);
        $this->Cell(120, 5, utf8_decode(''), 0, 0, 'L');
        $this->SetXY(76, 228);
        $this->SetDrawColor(0, 0, 0);
        $this->Line($this->GetX(), $this->GetY() + 5, $this->GetX() + 125, $this->GetY() + 5);

        //---------------------linea 22------------------------------
        $this->SetXY(9, 233);
        $this->SetFont('Arial', '', 8);
        $this->Cell(40, 5, utf8_decode('Diagnóstico relacionado 3:'), 0, 0, 'L');
        $this->SetXY(51, 233);
        $this->SetFont('Arial', '', 8);
        $this->Cell(15, 5, utf8_decode(''), 1, 0, 'L');
        $this->SetXY(75, 233);
        $this->SetFont('Arial', '', 8);
        $this->Cell(120, 5, utf8_decode(''), 0, 0, 'L');
        $this->SetXY(76, 233);
        $this->SetDrawColor(0, 0, 0);
        $this->Line($this->GetX(), $this->GetY() + 5, $this->GetX() + 125, $this->GetY() + 5);

        //linea cierre
        $this->SetXY(7, 235);
        $this->SetDrawColor(0, 0, 0);
        $this->Line($this->GetX(), $this->GetY() + 5, $this->GetX() + 197, $this->GetY() + 5);

        //---------------------linea 23------------------------------
        $this->SetXY(9, 240);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(40, 5, utf8_decode('Destino del paciente:'), 0, 0, 'L');

        $this->SetXY(30, 247);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(4, 4, utf8_decode(''), 1, 0, 'L');
        $this->SetXY(35, 247);
        $this->SetFont('Arial', '', 8);
        $this->Cell(40, 5, utf8_decode('Domicilio'), 0, 0, 'L');

        $this->SetXY(80, 247);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(4, 4, utf8_decode(''), 1, 0, 'L');
        $this->SetXY(85, 247);
        $this->SetFont('Arial', '', 8);
        $this->Cell(40, 5, utf8_decode('Internación'), 0, 0, 'L');

        $this->SetXY(130, 247);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(4, 4, utf8_decode(''), 1, 0, 'L');
        $this->SetXY(135, 247);
        $this->SetFont('Arial', '', 8);
        $this->Cell(40, 5, utf8_decode('Contrarremisión'), 0, 0, 'L');

        //segundo renglon
        $this->SetXY(30, 251);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(4, 4, utf8_decode(''), 1, 0, 'L');
        $this->SetXY(35, 251);
        $this->SetFont('Arial', '', 8);
        $this->Cell(40, 5, utf8_decode('Observación'), 0, 0, 'L');

        $this->SetXY(80, 251);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(4, 4, utf8_decode(''), 1, 0, 'L');
        $this->SetXY(85, 251);
        $this->SetFont('Arial', '', 8);
        $this->Cell(40, 5, utf8_decode('Remisión'), 0, 0, 'L');

        $this->SetXY(130, 251);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(4, 4, utf8_decode(''), 1, 0, 'L');
        $this->SetXY(135, 251);
        $this->SetFont('Arial', '', 8);
        $this->Cell(40, 5, utf8_decode('Otro'), 0, 0, 'L');

        //---------------------linea 23------------------------------
        $this->SetXY(7, 257);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(197, 5, utf8_decode('INFORMACION DE LA PERSONA QUE INFORMA'), 1, 0, 'C');

        //---------------------linea 24------------------------------
        $this->SetXY(7, 262);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(133, 5, utf8_decode('Nombre de Quien Informa: '), 1, 0, 'L');
        $this->SetXY(141, 265);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(15, 5, utf8_decode('Teléfono: '), 0, 0, 'L');
        $this->SetXY(159, 262);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(15, 4, utf8_decode(' '), 1, 0, 'L');
        $this->SetXY(174, 262);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(15, 4, utf8_decode(' '), 1, 0, 'L');
        $this->SetXY(189, 262);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(15, 4, utf8_decode(' '), 1, 0, 'L');

        //---------------------linea 25------------------------------

        $this->SetXY(158, 266);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(15, 5, utf8_decode('Indicativo'), 0, 0, 'C');
        $this->SetXY(174, 266);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(15, 5, utf8_decode('Número'), 0, 0, 'C');
        $this->SetXY(189, 266);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(15, 5, utf8_decode('Extensión'), 0, 0, 'C');


        //---------------------linea 26------------------------------
        $this->SetXY(7, 271);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(133, 5, utf8_decode('Cargo o Actividad: '), 1, 0, 'L');
        $this->SetXY(7, 267);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(133, 4, utf8_decode(''), 1, 0, 'L');
        $this->SetXY(140, 271);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(64, 5, utf8_decode('Teléfono celular: '), 1, 0, 'L');
    }
}
