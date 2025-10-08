<?php

namespace App\Formats;

use Codedge\Fpdf\Fpdf\Fpdf;
use Milon\Barcode\DNS1D;
use DNS2D;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Http\Modules\Reps\Models\Rep;
use App\Http\Modules\Usuarios\Models\User;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Empleados\Models\Empleado;
use App\Http\Modules\Ordenamiento\Models\Orden;
use App\Http\Modules\Municipios\Models\Municipio;
use App\Http\Modules\Prestadores\Models\Prestador;
use App\Http\Modules\Departamentos\Models\Departamento;
use App\Http\Modules\Cie10Afiliado\Models\Cie10Afiliado;
use App\Http\Modules\CobroFacturas\Models\CobroFacturas;
use App\Http\Modules\Contratos\Models\CobroServicio;
use App\Http\Modules\LogosRepsHistoria\Model\LogosRepsHistoria;
use App\Http\Modules\Operadores\Models\Operadore;
use App\Http\Modules\Ordenamiento\Models\OrdenProcedimiento;
use App\Http\Modules\Referencia\Models\Referencia;
use App\Http\Modules\Transcripciones\Transcripcion\Models\Transcripcione;
use Illuminate\Support\Facades\Storage;

class ReciboCaja extends Fpdf
{
    var $angle = 0;
    private static $data;
    private static $tipoMensaje;
    private static $afiliado;
    private static $departamentoAtencion;
    private static $municipioAtencion;
    private static $cobroServicios;
    private static $ordenProcedimiento;
    private static $factura;


    public function generar($request, $tipoMensaje = "R E C I B O D E C A J A")
    {
        self::$data = $request;
        self::$tipoMensaje = $tipoMensaje;
        self::$factura = CobroFacturas::find(self::$data['cobro_factura_id']);
        self::$cobroServicios = CobroServicio::where('cobro_factura_id', self::$data['cobro_factura_id'])
            ->where('estado_id', 14)
            ->get();
        self::$afiliado = Afiliado::join('consultas as cp', 'afiliados.id', 'cp.afiliado_id')
            ->where('cp.id', self::$cobroServicios[0]['consulta_id'])
            ->first();

        self::$departamentoAtencion = Departamento::find(self::$afiliado->departamento_atencion_id);
        self::$municipioAtencion = Municipio::find(self::$afiliado->municipio_atencion_id);

        $path = 'tempimg.png';
        $dataURI = "data:image/png;base64," . DNS2D::getBarcodePNG((string) self::$factura->id . '-' . self::$afiliado->numero_documento, 'QRCODE');
        $dataPieces = explode(',', $dataURI);
        $encodedImg = $dataPieces[1];
        $decodedImg = base64_decode($encodedImg);
        file_put_contents($path, $decodedImg);
        $pdf = new ReciboCaja('p', 'mm', 'A4');
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $this->body($pdf);
        $pdf->Output();
    }

    public function TextWithDirection($x, $y, $txt, $direction = 'R')
    {
        if ($direction == 'R') {
            $s = sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', 1, 0, 0, 1, $x * $this->k, ($this->h - $y) * $this->k, $this->_escape($txt));
        } elseif ($direction == 'L') {
            $s = sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', -1, 0, 0, -1, $x * $this->k, ($this->h - $y) * $this->k, $this->_escape($txt));
        } elseif ($direction == 'U') {
            $s = sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', 0, 1, -1, 0, $x * $this->k, ($this->h - $y) * $this->k, $this->_escape($txt));
        } elseif ($direction == 'D') {
            $s = sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', 0, -1, 1, 0, $x * $this->k, ($this->h - $y) * $this->k, $this->_escape($txt));
        } else {
            $s = sprintf('BT %.2F %.2F Td (%s) Tj ET', $x * $this->k, ($this->h - $y) * $this->k, $this->_escape($txt));
        }
        if ($this->ColorFlag) {
            $s = 'q ' . $this->TextColor . ' ' . $s . ' Q';
        }
        $this->_out($s);
    }

    function RotatedText($x, $y, $txt, $angle)
    {
        //Text rotated around its origin
        $this->Rotate($angle, $x, $y);
        $this->Text($x, $y, $txt);
        $this->Rotate(0);
    }

    function Rotate($angle, $x = -1, $y = -1)
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

    function _endpage()
    {
        if ($this->angle != 0) {
            $this->angle = 0;
            $this->_out('Q');
        }
        parent::_endpage();
    }


    public function header()
    {
        $this->SetFont('Arial', 'B', 50);
        $this->SetTextColor(255, 192, 203);
        $this->SetTextColor(0, 0, 0);
        $this->SetTextColor(0, 0, 0);
        $sedeProveedor = Rep::find(self::$afiliado->ips_id);

        $Y = 12;
        $this->SetFont('Arial', 'B', 8);
        $anchoRectangulo = 80; // Ancho del rectángulo
        $altoRectangulo = 18;  // Alto del rectángulo
        $posXRectangulo = 85;  // Posición X del rectángulo
        $posYRectangulo = 5;   // Posición Y del rectángulo

        $rectX = 5;
        $rectY = 5;
        $centroX = 25;
        $anchoRectangulo = 80;
        $altoRectangulo = 18;
        $this->Rect($rectX, $rectY, $anchoRectangulo, $altoRectangulo);
        $anchoLogo1 = 30;
        $altoLogo1 = 15;
        $logo1 = public_path() . "/images/logoEcoimagen.png";
        $anchoLogo2 = 30;
        $altoLogo2 = 15;

        $posXLogo1 = $centroX + ($anchoRectangulo / 4) - ($anchoLogo1 / 2);
        $posYLogo1 = $rectY + ($altoRectangulo / 2) - ($altoLogo1 / 2);
        $this->Image($logo1, $posXLogo1, $posYLogo1, $anchoLogo1, $altoLogo1);

        // Dibuja el rectángulo
        $this->Rect($posXRectangulo, $posYRectangulo, $anchoRectangulo, $altoRectangulo);

        // Define las posiciones de las dos columnas
        $columnaIzquierdaX = $posXRectangulo + 2.5;
        $anchoColumna = ($anchoRectangulo / 2) - 5; // Mitad del ancho del rectángulo con margen

        $Y = 8;
        $this->SetFont('Arial', 'B', 8);

        $this->SetXY($columnaIzquierdaX, $Y);
        $this->Cell($anchoColumna, 0, utf8_decode('FECHA DE COBRO:  ' . self::$factura->created_at), 0, 0, 'L');

        $this->SetXY($columnaIzquierdaX, $Y + 3);
        $this->Cell($anchoColumna, 0, utf8_decode('NÚMERO DE RECIBO DE CAJA:   ' . self::$factura->id), 0, 0, 'L');

        $this->SetXY($columnaIzquierdaX, $Y + 6);
        $this->Cell($anchoColumna, 0, utf8_decode('IPS GENERADORA DEL COBRO:'), 0, 0, 'L');
        $this->SetXY($columnaIzquierdaX, $Y + 9);
        $this->Cell($anchoColumna, 0, utf8_decode('Medicina Integral S.A.S'), 0, 0, 'L');
        $this->SetXY($columnaIzquierdaX, $Y + 12);
        $this->Cell($anchoColumna, 0, utf8_decode('RECIBO DE CAJA'), 0, 0, 'L');



        $this->Rect(165, 5, 40, 18);
        $this->SetXY(165, 6);
        $this->SetFont('Arial', 'B', 8);

        $this->Cell(40, 11, utf8_decode('MEDICINA INTEGRAL S.A.S'), 0, 1, 'C');

        $this->SetXY(165, 12);
        $this->Cell(40, 10, utf8_decode('NIT: 800250634-3'), 0, 0, 'C');

        $this->Ln(10);
        $this->SetFillColor(216, 216, 216);
        $this->SetFont('Arial', 'B', 8);
        $this->SetXY(5, 25);
        $this->Cell(98, 4, utf8_decode('Nombre Paciente'), 1, 0, 'C', 1);
        $this->Cell(10, 4, utf8_decode('Sexo'), 1, 0, 'C', 1);
        $this->Cell(60, 4, utf8_decode('Identificación'), 1, 0, 'C', 1);
        $this->Cell(10, 4, 'Edad', 1, 0, 'C', 1);
        $this->Cell(22, 4, 'Nacimiento', 1, 0, 'C', 1);
        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', '', 8);
        $this->Cell(98, 4, utf8_decode(self::$afiliado["nombre_completo"]), 1, 0, 'C');
        $this->SetFont('Arial', '', 7.5);
        $this->Cell(10, 4, utf8_decode(self::$afiliado["sexo"]), 1, 0, 'C');
        $this->Cell(60, 4, utf8_decode(self::$afiliado["tipoDocumento"]["sigla"] . " - " . self::$afiliado["numero_documento"]), 1, 0, 'C');
        $this->Cell(10, 4, self::$afiliado["edad_cumplida"], 1, 0, 'C');
        $this->Cell(22, 4, self::$afiliado["fecha_nacimiento"], 1, 0, 'C');
        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', '', 8);
        $this->Cell(200, 4, utf8_decode('IPS primaria: ' . $sedeProveedor->nombre), 1, 0, 'L');
        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', '', 8);
        $this->Cell(200, 4, utf8_decode('Dirección: ' . self::$afiliado["direccion_residencia_cargue"]), 1, 0, 'L');
        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(66.6, 4, 'Telefono', 1, 0, 'C', 1);
        $this->Cell(66.6, 4, 'Correo', 1, 0, 'C', 1);
        $this->Cell(66.7, 4, 'Municipio', 1, 0, 'C', 1);
        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', '', 7.5);
        $this->Cell(66.6, 4, utf8_decode(self::$afiliado["telefono"]) . " - " . utf8_decode(self::$afiliado["celular1"]), 1, 0, 'C');
        $this->Cell(66.6, 4, utf8_decode(self::$afiliado["correo1"]), 1, 0, 'C');
        $this->Cell(66.7, 4, utf8_decode(self::$departamentoAtencion->nombre . "-" . self::$municipioAtencion->nombre), 1, 0, 'C');
        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(18, 4, utf8_decode('Código'), 1, 0, 'C', 1);
        $this->Cell(85, 4, utf8_decode('Nombre'), 1, 0, 'C', 1);
        $this->Cell(80, 4, utf8_decode('Descripción del Pago'), 1, 0, 'C', 1);
        $this->Cell(17, 4, utf8_decode('Valor'), 1, 0, 'C', 1);
    }


    public function footer()
    {
        $this->SetFont('Arial', 'B', 9);
        $yOffset = $this->GetY();
        $newYOffset = $yOffset + 10 + 20.5 + 5;
        $widthText = 100;
        $xText = 2;
        $yText = $newYOffset - 27;
        $valorLetras = $this->numeroALetras(self::$factura->valor);
        $valorMoneda = $this->formatoPesosCOP(self::$factura->valor);


        $this->SetXY($xText, $yText);
        $this->MultiCell(200, 5, utf8_decode('VALOR TOTAL: ' . $valorMoneda), 0, 'C', false);
        $this->MultiCell(200, 5, utf8_decode('VALOR EN LETRAS: ' . $valorLetras), 0, 'C', false);

        $this->SetFont('Arial', '', 7);
        $yText = $newYOffset - 13;
        $this->SetXY($xText, $yText);
        $fechaImpresion = date('d/m/Y H:i:s');
        $text = utf8_decode('Fecha impresión: ' . $fechaImpresion);
        $this->MultiCell($widthText, 5, $text, 0, 'C', false);

        $this->SetXY($xText + 50, $yText);
        $usuario = Operadore::where('user_id',auth()->user()->id)->first();
        $textEmail = utf8_decode('Impreso Por: ' . $usuario->nombre . ' ' . $usuario->apellido);
        $this->MultiCell(200, 5, $textEmail, 0, 'C', false);
    }

    public function body($pdf)
    {

        $Y = 54;
        $countPerPage = 0; // Contador de medicamentos por página

        foreach (self::$cobroServicios as $cobro) {

            $item = OrdenProcedimiento::select('o.codigo', 'o.nombre as descripcion_cup', 'orden_procedimientos.*')
                ->join('cups as o', 'orden_procedimientos.cup_id', 'o.id')
                ->where('orden_procedimientos.id', $cobro->orden_procedimiento_id)
                ->first();

            $pdf->SetFont('Arial', 'B', 6);
            // Colocar los elementos
            $pdf->SetXY(5, $Y);
            $pdf->MultiCell(15, 4, utf8_decode(strtoupper($item->codigo)), 0, 'C', 0);
            $pdf->SetXY(24, $Y);
            $pdf->MultiCell(70, 4, utf8_decode(strtoupper($item->descripcion_cup)), 0, 'L', 0);

            // Obtener la posición Y después de las celdas
            $YN1 = round($pdf->GetY(), 0, PHP_ROUND_HALF_DOWN);

            $pdf->SetXY(106, $Y);
            $pdf->MultiCell(80, 4, utf8_decode(strtoupper($cobro->tipo == 'cuota' ? 'DEPOSITO POR CUOTA MODERADORA' : 'DEPOSITO POR COPAGO')), 0, 'C', 0);

            $YN2 = round($pdf->GetY(), 0, PHP_ROUND_HALF_DOWN);

            $pdf->SetXY(190, $Y);
            $valorIndividual = $this->formatoPesosCOP($cobro->valor);
            $pdf->MultiCell(13, 4, utf8_decode($valorIndividual), 0, 'C', 0);

            // Calcular la posición Y final
            $YN = max($YN1, $YN2);

            $YL = round($pdf->GetY(), 0, PHP_ROUND_HALF_DOWN);

            // Dibujar la línea horizontal debajo de las observaciones
            $pdf->Line(5, max($YL, $YN) + 0.5, 205, max($YL, $YN) + 0.5); // Línea debajo de la observación

            // Actualizar $Y para la siguiente fila
            $Y = $Y + (max($YN, $YL) - $Y);
            $countPerPage++; // Incrementar el contador de medicamentos impresos en la página actual
        }
    }

    public function formatoPesosCOP($valor)
    {
        return '$' . number_format($valor, 0, ',', '.');
    }

    public function numeroALetras($numero)
    {
        $unidad = [
            '',
            'UNO',
            'DOS',
            'TRES',
            'CUATRO',
            'CINCO',
            'SEIS',
            'SIETE',
            'OCHO',
            'NUEVE',
            'DIEZ',
            'ONCE',
            'DOCE',
            'TRECE',
            'CATORCE',
            'QUINCE',
            'DIECISÉIS',
            'DIECISIETE',
            'DIECIOCHO',
            'DIECINUEVE',
            'VEINTE'
        ];

        $decena = [
            '',
            '',
            'VEINTI',
            'TREINTA',
            'CUARENTA',
            'CINCUENTA',
            'SESENTA',
            'SETENTA',
            'OCHENTA',
            'NOVENTA'
        ];

        $centena = [
            '',
            'CIENTO',
            'DOSCIENTOS',
            'TRESCIENTOS',
            'CUATROCIENTOS',
            'QUINIENTOS',
            'SEISCIENTOS',
            'SETECIENTOS',
            'OCHOCIENTOS',
            'NOVECIENTOS'
        ];

        if ($numero == 0) {
            return 'CERO PESOS M/CTE';
        }

        if ($numero == 100) {
            return 'CIEN PESOS M/CTE';
        }

        $num = str_pad($numero, 9, '0', STR_PAD_LEFT);
        $millones = substr($num, 0, 3);
        $mil = substr($num, 3, 3);
        $cientos = substr($num, 6);

        $letras = '';

        // Procesar millones
        if ((int)$millones > 0) {
            if ($millones == '001') {
                $letras .= 'UN MILLÓN ';
            } else {
                $letras .= $this->convertirGrupo($millones, $unidad, $decena, $centena) . ' MILLONES ';
            }
        }

        // Procesar miles
        if ((int)$mil > 0) {
            if ($mil == '001') {
                $letras .= 'MIL ';
            } else {
                $letras .= $this->convertirGrupo($mil, $unidad, $decena, $centena) . ' MIL ';
            }
        }

        // Procesar cientos
        if ((int)$cientos > 0) {
            $letras .= $this->convertirGrupo($cientos, $unidad, $decena, $centena);
        }

        return trim($letras) . ' PESOS M/CTE';
    }

    private function convertirGrupo($tresCifras, $unidad, $decena, $centena)
    {
        $c = (int)$tresCifras[0];
        $d = (int)$tresCifras[1];
        $u = (int)$tresCifras[2];
        $texto = '';

        // Centena
        if ($c == 1 && $d == 0 && $u == 0) {
            return 'CIEN';
        } elseif ($c > 0) {
            $texto .= $centena[$c] . ' ';
        }

        // Decena y unidad
        if ($d == 0) {
            $texto .= $unidad[$u];
        } elseif ($d == 1 || ($d == 2 && $u == 0)) {
            $texto .= $unidad[$d * 10 + $u];
        } elseif ($d == 2) {
            $texto .= 'VEINTI' . strtolower($unidad[$u]);
        } else {
            $texto .= $decena[$d];
            if ($u > 0) {
                $texto .= ' Y ' . $unidad[$u];
            }
        }

        return trim($texto);
    }
}
