<?php

namespace App\Formats;

use Carbon\Carbon;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Http\Modules\Ordenamiento\Models\Orden;

class MedicamentoIntrahospitalario extends Fpdf
{
    var int|float $angle = 0;
    public static Orden $orden;

    public function generar(array $data)
    {
        self::$orden = Orden::findOrFail($data['orden_id']);
        $pdf = new MedicamentoIntrahospitalario('p', 'mm', 'A4');
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $this->body($pdf);
        $pdf->Output();
    }

    public function header(): void
    {
        $this->SetFont('Arial', 'B', size: 50);
        $this->SetTextColor(255, 192, 203);
        $this->RotatedText(12, 134, 'F O R M U L A  M E D I C A', 33);
        $this->SetTextColor(0, 0, 0);

        $consulta = self::$orden->consulta;
        $afiliado = $consulta->afiliado;

        $startY = 5;
        $headerHeight = 20;

        // Márgenes y ancho útil
        $margins = 10;
        $pageWidth = $this->GetPageWidth();
        $contentWidth = $pageWidth - ($margins * 2);

        $sectionWidth = $contentWidth / 3;

        // Dibujar el rectángulo grande del header
        $this->Rect($margins, $startY, $contentWidth, $headerHeight);

        // Dibujar separadores verticales
        $firstSeparatorX = $margins + $sectionWidth;
        $secondSeparatorX = $margins + ($sectionWidth * 2);
        $this->Line($firstSeparatorX, $startY, $firstSeparatorX, $startY + $headerHeight);
        $this->Line($secondSeparatorX, $startY, $secondSeparatorX, $startY + $headerHeight);

        // Rutas de las imágenes
        $logoSumi = 'images/logo.png';
        $logoFomag = 'images/logoFomag.png';

        // Imagenes del primer cuadro 
        $logoSectionX = $margins;
        $logoSectionWidth = $sectionWidth;
        $halfSectionWidth = $logoSectionWidth / 2;
        $targetLogoHeight = 12;

        // Logo Sumi
        $sumiX = $logoSectionX + ($halfSectionWidth / 2) - ($targetLogoHeight / 2);
        $this->Image(
            $logoSumi,
            $sumiX,
            $startY + (($headerHeight - $targetLogoHeight) / 2),
            0,
            $targetLogoHeight
        );

        // Logo Fomag
        $fomagX = $logoSectionX + $halfSectionWidth + ($halfSectionWidth / 2) - ($targetLogoHeight / 2);
        $this->Image(
            $logoFomag,
            $fomagX,
            $startY + (($headerHeight - $targetLogoHeight) / 2),
            0,
            $targetLogoHeight
        );

        // Textos en el segundo cuadro
        $textSectionX = $firstSeparatorX; // Inicio del segundo cuadro
        $this->SetFont('Arial', '', 7); // Tamaño de letra pequeño
        $this->SetXY($textSectionX + 2, $startY + 4); // Ajuste inicial de posición

        $this->Cell(0, 3, 'FECHA DE AUTORIZACION: ' . self::$orden->created_at->format('Y-m-d'), 0, 1);
        $this->SetX($textSectionX + 2);
        $this->Cell(0, 3, 'REGIMEN: ESPECIAL', 0, 1);
        $this->SetX($textSectionX + 2);
        $this->Cell(0, 3, 'NUMERO DE AUTORIZACION: ' . self::$orden->id, 0, 1);
        $this->SetX($textSectionX + 2);
        $this->Cell(0, 3, 'IPS ORDENA: ' . $afiliado->ips->nombre, 0, 1);

        // Textos e imagen en el tercer cuadro
        $lastSectionX = $secondSeparatorX; // Inicio del tercer cuadro

        // Nueva división 60% / 40%
        $textWidth = $sectionWidth * 0.6;
        $imageWidth = $sectionWidth * 0.4;

        // Dibujar línea divisoria 60/40
        $middleX = $lastSectionX + $textWidth;
        $this->Line($middleX, $startY, $middleX, $startY + $headerHeight);

        // Texto en el lado izquierdo (60%)
        $this->SetFont('Arial', '', 7);
        $this->SetXY($lastSectionX + 2, $startY + 6);
        $this->Cell($textWidth - 4, 3, 'MEDICINA INTEGRAL S.A.', 0, 1);
        $this->SetX($lastSectionX + 2);
        $this->Cell($textWidth - 4, 3, 'NIT: XXX', 0, 1);

        // Imagen en el lado derecho (40%)
        $qrImagePath = 'images/qrMedicamentosFormatoNuevo.jpeg';
        $qrWidth = 14; // Aumentamos tamaño del QR
        $qrX = $middleX + ($imageWidth / 2) - ($qrWidth / 2);
        $qrY = $startY + ($headerHeight / 2) - ($qrWidth / 2);

        $this->Image(
            $qrImagePath,
            $qrX,
            $qrY,
            $qrWidth
        );

    }

    public function body($pdf): void
    {
        $consulta = self::$orden->consulta;
        $afiliado = $consulta->afiliado;
        $cie10s = $consulta->cie10Afiliado;

        // Extraer los códigos CIE10 de la relación
        $cie10sArray = $cie10s->map(fn($item) => $item->cie10->codigo_cie10 ?? null)
            ->filter()
            ->toArray();

        $codigoDiagnosticos = empty($cie10sArray)
            ? "Z000"
            : (count($cie10sArray) === 1
                ? $cie10sArray[0]
                : implode(', ', $cie10sArray)
            );

        $articulos = self::$orden->articulosIntrahospitalarios;

        // Márgenes y posición inicial
        $margins = 10;
        $startX = $margins;
        $startY = 27; // Después del header
        $pageWidth = $pdf->GetPageWidth();
        $contentWidth = $pageWidth - ($margins * 2);

        // Altura de las filas
        $rowHeight = 4;

        // Anchos de cada columna
        $colNombre = $contentWidth * 0.40;
        $colSexo = $contentWidth * 0.10;
        $colIdentificacion = $contentWidth * 0.20;
        $colEdad = $contentWidth * 0.10;
        $colNacimiento = $contentWidth * 0.20;

        $pdf->SetFont('Arial', 'B', 7); // Negrita para los títulos
        $pdf->SetXY($startX, $startY);

        // Color de fondo para títulos (gris claro)
        $pdf->SetFillColor(220, 220, 220);

        // Fila de títulos (con fondo)
        $pdf->Cell($colNombre, $rowHeight, 'NOMBRE PACIENTE', 1, 0, 'C', true);
        $pdf->Cell($colSexo, $rowHeight, 'SEXO', 1, 0, 'C', true);
        $pdf->Cell($colIdentificacion, $rowHeight, utf8_decode('IDENTIFICACIÓN'), 1, 0, 'C', true);
        $pdf->Cell($colEdad, $rowHeight, 'EDAD', 1, 0, 'C', true);
        $pdf->Cell($colNacimiento, $rowHeight, 'NACIMIENTO', 1, 1, 'C', true);

        // Color de fondo para valores (blanco)
        $pdf->SetFillColor(255, 255, 255);

        // Fila de datos
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetX($startX);

        $nombrePaciente = strtoupper(trim($afiliado->primer_nombre . ' ' . $afiliado->segundo_nombre . ' ' . $afiliado->primer_apellido . ' ' . $afiliado->segundo_apellido));
        $sexo = strtoupper($afiliado->sexo);
        $tipoIdentificacion = strtoupper($afiliado->tipoDocumento->sigla ?? '') . ' - ' . $afiliado->numero_documento;
        $edad = $afiliado->edad_cumplida;
        $fechaNacimiento = !empty($afiliado->fecha_nacimiento) ? Carbon::parse($afiliado->fecha_nacimiento)->format('Y-m-d') : '';

        $pdf->Cell($colNombre, $rowHeight, $nombrePaciente, 1, 0, 'C', true);
        $pdf->Cell($colSexo, $rowHeight, $sexo, 1, 0, 'C', true);
        $pdf->Cell($colIdentificacion, $rowHeight, $tipoIdentificacion, 1, 0, 'C', true);
        $pdf->Cell($colEdad, $rowHeight, $edad, 1, 0, 'C', true);
        $pdf->Cell($colNacimiento, $rowHeight, $fechaNacimiento, 1, 1, 'C', true);

        // IPS Primaria y Dirección
        $col50 = $contentWidth / 2;

        // Fila de títulos
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetFillColor(220, 220, 220);
        $pdf->SetX($startX);
        $pdf->Cell($col50, $rowHeight, 'IPS PRIMARIA', 1, 0, 'C', true);
        $pdf->Cell($col50, $rowHeight, utf8_decode('DIRECCIÓN'), 1, 1, 'C', true);

        // Fila de valores
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetX($startX);
        $pdf->Cell($col50, $rowHeight, $afiliado->ips->nombre ?? '', 1, 0, 'C', true);
        $pdf->Cell($col50, $rowHeight, $afiliado->direccion ?? '', 1, 1, 'C', true);

        // Teléfono, Correo y Municipio
        $col33 = $contentWidth / 3;

        // Fila de títulos
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetFillColor(220, 220, 220);
        $pdf->SetX($startX);
        $pdf->Cell($col33, $rowHeight, utf8_decode('TELÉFONO'), 1, 0, 'C', true);
        $pdf->Cell($col33, $rowHeight, 'CORREO', 1, 0, 'C', true);
        $pdf->Cell($col33, $rowHeight, 'MUNICIPIO', 1, 1, 'C', true);

        // Fila de valores
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetX($startX);

        // Construir municipio + departamento
        $municipio = $afiliado->municipio_residencia->nombre ?? '';
        $departamento = $afiliado->municipio_residencia->departamento->nombre ?? '';
        $municipioCompleto = trim($municipio . ' - ' . $departamento);

        $pdf->Cell($col33, $rowHeight, utf8_decode($afiliado->telefono ?? ''), 1, 0, 'C', true);
        $pdf->Cell($col33, $rowHeight, utf8_decode($afiliado->correo1 ?? ''), 1, 0, 'C', true);
        $pdf->Cell($col33, $rowHeight, utf8_decode($municipioCompleto), 1, 1, 'C', true);

        // Punto de Entrega
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetFillColor(220, 220, 220);
        $pdf->SetX($startX);
        $pdf->Cell($contentWidth, $rowHeight, 'PUNTO DE ENTREGA', 1, 1, 'C', true);

        // Valor de Punto de Entrega
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetX($startX);
        $pdf->Cell($contentWidth, $rowHeight, utf8_decode($afiliado->ips->nombre ?? ''), 1, 1, 'C', true);

        // Dirección, Teléfono y Municipio de la IPS
        $colIps = $contentWidth / 3;

        // Fila de títulos
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetFillColor(220, 220, 220);
        $pdf->SetX($startX);
        $pdf->Cell($colIps, $rowHeight, utf8_decode('DIRECCIÓN'), 1, 0, 'C', true);
        $pdf->Cell($colIps, $rowHeight, utf8_decode('TELÉFONO'), 1, 0, 'C', true);
        $pdf->Cell($colIps, $rowHeight, 'MUNICIPIO', 1, 1, 'C', true);

        // Fila de valores
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetX($startX);

        $direccionIps = utf8_decode($afiliado->ips->direccion ?? '');
        $telefonoIps = utf8_decode($afiliado->ips->telefono1 ?? '');
        $municipioIps = utf8_decode(($afiliado->ips->municipio->nombre ?? '') . ' - ' . ($afiliado->ips->municipio->departamento->nombre ?? ''));

        $pdf->Cell($colIps, $rowHeight, $direccionIps, 1, 0, 'C', true);
        $pdf->Cell($colIps, $rowHeight, $telefonoIps, 1, 0, 'C', true);
        $pdf->Cell($colIps, $rowHeight, $municipioIps, 1, 1, 'C', true);

        // Diagnósticos
        $colDiagnosticoTitulo = $contentWidth * 0.2;
        $colDiagnosticoValor = $contentWidth * 0.8;

        // Fila de título (gris claro)
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetFillColor(220, 220, 220);
        $pdf->SetX($startX);
        $pdf->Cell($colDiagnosticoTitulo, $rowHeight, utf8_decode('DIAGNÓSTICOS'), 1, 0, 'C', true);

        // Fila de valor (blanco)
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->Cell($colDiagnosticoValor, $rowHeight, utf8_decode($codigoDiagnosticos), 1, 1, 'C', true);

        // Ancho de cada columna Fila 7
        $anchosColsTablaOrdenes = [20, 80, 30, 40, 20];
        $margenIzquierdo = 10;
        $anchoTotal = array_sum($anchosColsTablaOrdenes);

        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetFillColor(220, 220, 220);

        // Encabezado de la fila 7
        $pdf->SetX($margenIzquierdo);
        $pdf->Cell($anchosColsTablaOrdenes[0], 4, utf8_decode('CÓDIGO'), 1, 0, 'C', true);
        $pdf->Cell($anchosColsTablaOrdenes[1], 4, utf8_decode('ARTÍCULO'), 1, 0, 'C', true);
        $pdf->Cell($anchosColsTablaOrdenes[2], 4, utf8_decode('ADMINISTRACIÓN'), 1, 0, 'C', true);
        $pdf->Cell($anchosColsTablaOrdenes[3], 4, utf8_decode('DOSIFICACIÓN'), 1, 0, 'C', true);
        $pdf->Cell($anchosColsTablaOrdenes[4], 4, utf8_decode('DURACIÓN'), 1, 1, 'C', true);

        $yInicioTabla = $pdf->GetY();

        foreach ($articulos as $ordenArticulo) {

            $pdf->SetFont('Arial', '', 6);
            $articulo = $ordenArticulo->codesumi;
            $dosificacion = $ordenArticulo->finalizacion === 'DOSIS_UNICA' ? ($ordenArticulo->cantidad . ' DOSIS ÚNICA') : ($ordenArticulo->cantidad . ' CADA ' . $ordenArticulo->frecuencia . ' ' . $ordenArticulo->unidad_tiempo);

            $lineHeight = 3;
            $padding = 4;
            $alturaArticulo = $pdf->GetMultiCellHeight($anchosColsTablaOrdenes[1], $lineHeight, utf8_decode($articulo->nombre)) + $padding;
            $alturaDosificacion = $pdf->GetMultiCellHeight($anchosColsTablaOrdenes[3], $lineHeight, utf8_decode($ordenArticulo->formula)) + $padding;
            $alturaMaxima = max($alturaArticulo, $alturaDosificacion);

            $yInicio = $pdf->GetY();

            // Columna: Código
            $pdf->SetX($margenIzquierdo);
            $pdf->Cell($anchosColsTablaOrdenes[0], $alturaMaxima, utf8_decode($articulo->codigo), 0, 0, 'C');

            // Columna: Artículo
            $pdf->SetX($margenIzquierdo + $anchosColsTablaOrdenes[0]);
            $pdf->MultiCell($anchosColsTablaOrdenes[1], $lineHeight, utf8_decode($articulo->nombre), 0, 'C');
            $yMulti = $pdf->GetY();

            // Columna: Administración
            $pdf->SetXY($margenIzquierdo + array_sum(array_slice($anchosColsTablaOrdenes, 0, 2)), $yInicio);
            $pdf->Cell(
                $anchosColsTablaOrdenes[2],
                $alturaMaxima,
                utf8_decode(strtoupper($ordenArticulo->via->nombre))
                ,
                0,
                0,
                'C'
            );

            // Columna: Dosificación
            $pdf->SetXY($margenIzquierdo + array_sum(array_slice($anchosColsTablaOrdenes, 0, 3)), $yInicio);
            $pdf->MultiCell($anchosColsTablaOrdenes[3], $lineHeight, utf8_decode($dosificacion), 0, 'C');

            // Columna: Duración
            $pdf->SetXY($margenIzquierdo + array_sum(array_slice($anchosColsTablaOrdenes, 0, 4)), $yInicio);
            $pdf->Cell($anchosColsTablaOrdenes[4], $alturaMaxima, utf8_decode($ordenArticulo->horas_vigencia . ' HORA(S)'), 0, 1, 'C');

            // Dibujar bordes de cada fila
            $xActual = $margenIzquierdo;
            foreach ($anchosColsTablaOrdenes as $ancho) {
                $pdf->Line($xActual, $yInicio, $xActual, $yInicio + $alturaMaxima);
                $xActual += $ancho;
            }
            $pdf->Line($margenIzquierdo + $anchoTotal, $yInicio, $margenIzquierdo + $anchoTotal, $yInicio + $alturaMaxima);
            $pdf->Line($margenIzquierdo, $yInicio + $alturaMaxima, $margenIzquierdo + $anchoTotal, $yInicio + $alturaMaxima);

        }
        $pdf->Ln(2);

        $yFirmas = $pdf->GetY();
        $altoFirmas = 22;

        $pdf->Rect($margenIzquierdo, $yFirmas, $anchoTotal, $altoFirmas);

        $pdf->SetY($yFirmas + $altoFirmas + 4);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetXY($margenIzquierdo + 2, $yFirmas + 2);
        $pdf->Cell(0, 4, utf8_decode('Funcionario que Ordenó'), 0, 1, 'L');

        $pdf->SetFont('Arial', '', 8);
        $pdf->Ln(16);
        $pdf->Cell(63, 5, utf8_decode('Fecha de Impresión: ' . Carbon::now()->format('d/m/Y')), 0, 0, 'L');


    }

    public function RotatedText($x, $y, $txt, $angle)
    {
        //Text rotated around its origin
        $this->Rotate($angle, $x, $y);
        $this->Text($x, $y, $txt);
        $this->Rotate(0);
    }

    public function Rotate($angle, $x = -1, $y = -1)
    {
        if ($x == -1)
            $x = $this->x;
        if ($y == -1)
            $y = $this->y;
        if ($this->angle != 0)
            $this->_out('Q');
        $this->angle = $angle;
        if ($angle != 0) {
            $angle *= M_PI / 180;
            $c = cos($angle);
            $s = sin($angle);
            $cx = $x * $this->k;
            $cy = ($this->h - $y) * $this->k;
            $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm', $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy));
        }
    }

    public function GetMultiCellHeight($width, $lineHeight, $text): int|float
    {
        // Obtener el ancho de la celda para calcular las líneas necesarias
        $nbLines = $this->GetStringWidth($text) / $width;

        // Calcular la altura final
        return ceil($nbLines) * $lineHeight;
    }
}