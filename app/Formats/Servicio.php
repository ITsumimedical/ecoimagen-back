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
use App\Http\Modules\LogosRepsHistoria\Model\LogosRepsHistoria;
use App\Http\Modules\Operadores\Models\Operadore;
use App\Http\Modules\Ordenamiento\Models\OrdenProcedimiento;
use App\Http\Modules\Referencia\Models\Referencia;
use App\Http\Modules\Transcripciones\Transcripcion\Models\Transcripcione;
use Illuminate\Support\Facades\Storage;

class Servicio extends Fpdf
{
    var $angle = 0;
    private static $data;
    private static $tipoMensaje;
    private static $orden;
    private static $afiliado;
    private static $ubicacion;
    private static $consulta;
    private static $medico;
    private static $cie10s;
    private static $qr;
    private static $departamentoAtencion;
    private static $municipioAtencion;
    private static $cie10_referencia;
    private static $ordenProcedimiento;

    private static $prestador;


    public function generar($request, $sendEmail, $correo, $outputPath, $tipoMensaje = "S E R V I C I O  M E D I C O", $fomag = false)
    {
        self::$data = $request;
        self::$tipoMensaje = $tipoMensaje;
        self::$ordenProcedimiento = OrdenProcedimiento::with('auditoria')->where('orden_id', self::$data['servicios'][0]['orden_id'])->first();
        self::$orden = Orden::where('id', self::$ordenProcedimiento->orden_id)->first();
        self::$afiliado = Afiliado::join('consultas as cp', 'afiliados.id', 'cp.afiliado_id')
        ->where('cp.id', self::$orden->consulta_id)
        ->first();

        self::$departamentoAtencion = Departamento::find(self::$afiliado->departamento_atencion_id);
        self::$municipioAtencion = Municipio::find(self::$afiliado->municipio_atencion_id);
        self::$ubicacion = $request['datos'];
        self::$consulta = Consulta::find(self::$orden->consulta_id);

        self::$medico = Operadore::where('user_id', self::$orden->user_id)
        ->first();
        self::$cie10s = Cie10Afiliado::select('cie10s.codigo_cie10')
        ->join('cie10s', 'cie10s.id', 'cie10_afiliados.cie10_id')
        ->where('cie10_afiliados.consulta_id', self::$consulta->id)
        ->get()
        ->toArray();

        if (self::$consulta->finalidad == 'Anexo 2') {
            $referencia = Referencia::where('codigo_remision', strval(self::$orden->id))
            ->with([
                'cie10s' => function ($query) {
                    $query->select('codigo_cie10');
                }
                ])
                ->first();
                if ($referencia) {
                    $cie10Nombre = [];
                    foreach ($referencia->cie10s as $ref) {
                        array_push($cie10Nombre, $ref->codigo_cie10);
                    }
                    self::$cie10_referencia = $cie10Nombre;
                }
            }

            $path = 'tempimg.png';
            $dataURI = "data:image/png;base64," . DNS2D::getBarcodePNG((string) self::$orden->id . '-' . self::$afiliado->numero_documento, 'QRCODE');
        $dataPieces = explode(',', $dataURI);
        $encodedImg = $dataPieces[1];
        $decodedImg = base64_decode($encodedImg);
        file_put_contents($path, $decodedImg);
        self::$qr = $path;
        $pdf = new Servicio('p', 'mm', 'A4');
        // dd('asdasd', $pdf);
        $pdf->AliasNbPages();
        //$pdf->AddPage();
        $this->body($pdf);

        if (!$fomag) {
            base64_encode($pdf->Output('F', $outputPath, true));
        }

        if ($sendEmail) {
            Mail::send('enviar_orden', ['email' => $correo], function ($message) use ($outputPath, $correo) {
                $message->to([$correo]);
                $message->subject(self::$afiliado->numero_documento . " " . self::$afiliado->primer_nombre . " " . self::$afiliado->primer_apellido);
                $message->attach($outputPath, [
                    'mime' => 'application/pdf',
                    'as' => 'Orden Fomag ' . self::$afiliado->numero_documento . ' ' . self::$afiliado->primer_nombre . " " . self::$afiliado->primer_apellido . '.pdf'
                ]);
            });
            Storage::disk('local')->delete($outputPath);
        }
        if ($fomag) {
            return base64_encode($pdf->Output('S'));
        } else {
            $pdf->Output();
        }
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
        $this->RotatedText(12, 134, self::$tipoMensaje, 33);
        $this->SetTextColor(0, 0, 0);
        $this->SetTextColor(0, 0, 0);
        $sedeProveedor = Rep::find(self::$afiliado->ips_id);
        // $logo1 = public_path() . "/images/logoEcoimagen.png";
        // if (self::$afiliado->entidad_id === 3) {
        //     $logo2 = public_path() . "/images/logotipo_fps.jpg";
        // }
        // // if (self::$afiliado->entidad_id === 1) {
        // //     $logo2 = public_path() . "/images/logoFomag.png";
        // // } elseif (self::$afiliado->entidad_id === 3) {
        // //     $logo2 = public_path() . "/images/logotipo_fps.jpg";
        // // }

        // // Tamaño del rectángulo
        // $rectX = 5;
        // $rectY = 5;
        // $centroX = 25;
        // $anchoRectangulo = 80;
        // $altoRectangulo = 18;
        // $this->Rect($rectX, $rectY, $anchoRectangulo, $altoRectangulo);
        // $anchoLogo1 = 30;
        // $altoLogo1 = 15;
        // $anchoLogo2 = 30;
        // $altoLogo2 = 15;

        // // Centrar logo1 en el rectángulo
        // if (self::$afiliado->entidad_id === 3){
        //     $posXLogo1 = $rectX + ($anchoRectangulo / 4) - ($anchoLogo1 / 2);
        //     $posYLogo1 = $rectY + ($altoRectangulo / 2) - ($altoLogo1 / 2);
        //     $this->Image($logo1, $posXLogo1, $posYLogo1, $anchoLogo1, $altoLogo1);
        // } else {
        //     $posXLogo1 = $centroX + ($anchoRectangulo / 4) - ($anchoLogo1 / 2);
        //     $posYLogo1 = $rectY + ($altoRectangulo / 2) - ($altoLogo1 / 2);
        //     $this->Image($logo1, $posXLogo1, $posYLogo1, $anchoLogo1, $altoLogo1);
        // }

        // // Centrar logo2 en el rectángulo
        // if (self::$afiliado->entidad_id === 3) {
        //     $posXLogo2 = $rectX + (3 * $anchoRectangulo / 4) - ($anchoLogo2 / 2);
        //     $posYLogo2 = $rectY + ($altoRectangulo / 2) - ($altoLogo2 / 2);
        //     $this->Image($logo2, $posXLogo2, $posYLogo2, $anchoLogo2, $altoLogo2);
        // }

        $Y = 12;
        $this->SetFont('Arial', 'B', 8);
        $anchoRectangulo = 80; // Ancho del rectángulo
        $altoRectangulo = 18;  // Alto del rectángulo
        $posXRectangulo = 85;  // Posición X del rectángulo
        $posYRectangulo = 5;   // Posición Y del rectángulo

        // Dibuja el rectángulo
        $this->Rect($posXRectangulo, $posYRectangulo, $anchoRectangulo, $altoRectangulo);

        // Define las posiciones de las dos columnas
        $columnaIzquierdaX = $posXRectangulo + 2.5;
        $columnaDerechaX = $posXRectangulo + ($anchoRectangulo / 2);
        $anchoColumna = ($anchoRectangulo / 2) - 5; // Mitad del ancho del rectángulo con margen

        $Y = 8;
        $this->SetFont('Arial', 'B', 7);

        if (self::$consulta->tipo_consulta_id == 1) {
            $transcripcion = Transcripcione::where('consulta_id', self::$consulta->id)->first();
            $nombre = ($transcripcion->prestador_id != null)
                ? Prestador::find($transcripcion->prestador_id)->nombre_prestador
                : 'SUMIMEDICAL S.A.S';

            // Columna Izquierda
            $this->SetXY($columnaIzquierdaX, $Y);
            $this->Cell($anchoColumna, 0, utf8_decode('FECHA DE ORDEN MÉDICA:'), 0, 0, 'L');
            $this->SetXY($columnaIzquierdaX, $Y + 3);
            $this->Cell($anchoColumna, 0, utf8_decode(self::$data["servicios"][0]['fecha_vigencia']), 0, 0, 'L');

            $this->SetXY($columnaIzquierdaX, $Y + 6);
            $this->Cell($anchoColumna, 0, utf8_decode("RÉGIMEN: ESPECIAL"), 0, 0, 'L');

            $this->SetXY($columnaIzquierdaX, $Y + 9);
            $this->Cell($anchoColumna, 0, utf8_decode('NÚMERO DE ORDEN MÉDICA:'), 0, 0, 'L');
            $this->SetXY($columnaIzquierdaX, $Y + 12);
            $this->Cell($anchoColumna, 0, utf8_decode(self::$orden->id), 0, 0, 'L');



            // Columna Derecha
            $this->SetXY($columnaDerechaX, $Y);
            $this->Cell($anchoColumna, 0, utf8_decode('IPS GENERADORA:'), 0, 0, 'L');
            $this->SetXY($columnaDerechaX, $Y + 3);
            $this->Cell($anchoColumna, 0, utf8_decode($sedeProveedor->nombre), 0, 0, 'L');

            $this->SetXY($columnaDerechaX, $Y + 6);
            $this->Cell($anchoColumna, 0, utf8_decode('IPS ORDENA:'), 0, 0, 'L');
            $this->SetXY($columnaDerechaX, $Y + 9);
            $this->Cell($anchoColumna, 0, utf8_decode($nombre), 0, 0, 'L');
        } else {
            // Columna Izquierda
            $this->SetXY($columnaIzquierdaX, $Y);
            $this->Cell($anchoColumna, 0, utf8_decode('FECHA DE ORDEN MÉDICA:'), 0, 0, 'L');
            $this->SetXY($columnaIzquierdaX, $Y + 3);
            $this->Cell($anchoColumna, 0, utf8_decode(self::$data["servicios"][0]['fecha_vigencia']), 0, 0, 'L');

            $this->SetXY($columnaIzquierdaX, $Y + 6);
            $this->Cell($anchoColumna, 0, utf8_decode("RÉGIMEN: ESPECIAL"), 0, 0, 'L');

            $this->SetXY($columnaIzquierdaX, $Y + 9);
            $this->Cell($anchoColumna, 0, utf8_decode('NÚMERO DE ORDEN MÉDICA:'), 0, 0, 'L');
            $this->SetXY($columnaIzquierdaX, $Y + 12);
            $this->Cell($anchoColumna, 0, utf8_decode(self::$orden->id), 0, 0, 'L');


            // Columna Derecha
            $this->SetXY($columnaDerechaX, $Y);
            $this->Cell($anchoColumna, 0, utf8_decode('IPS GENERADORA:'), 0, 0, 'L');
            $this->SetXY($columnaDerechaX, $Y + 3);
            $this->Cell($anchoColumna, 0, utf8_decode($sedeProveedor->nombre), 0, 0, 'L');
        }


        $this->Rect(165, 5, 40, 18);
        $this->SetXY(165, 6);
        $this->SetFont('Arial', 'B', 9);

        $this->Cell(40, 11, utf8_decode('SUMIMEDICAL S.A.S'), 0, 1, 'C');

        $this->SetXY(165, 12);
        $this->Cell(40, 10, utf8_decode('NIT: 900033371 Res: 004'), 0, 0, 'C');

        $proveedor = Rep::where('id', self::$ubicacion->id)->first();
        if ($proveedor) {
            $municipioPrestador = Municipio::select('municipios.nombre as mNombre', 'departamentos.nombre as dNombre')->join('departamentos', 'departamentos.id', 'municipios.departamento_id')->where('municipios.id', $proveedor->municipio_id)->first();
        }
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
        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(200, 4, utf8_decode('Nombre Prestador'), 1, 0, 'C', 1);
        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', '', 8);
        $this->Cell(200, 4, utf8_decode(self::$ubicacion->nombre), 1, 0, 'L');
        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(120, 4, 'Direccion', 1, 0, 'C', 1);
        $this->Cell(38, 4, 'Telefono', 1, 0, 'C', 1);
        $this->Cell(42, 4, 'Municipio', 1, 0, 'C', 1);
        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', '', 7);
        if (isset(self::$ubicacion->id)) {

            $this->Cell(120, 4, utf8_decode(self::$ubicacion->direccion), 1, 0, 'C');
            $this->Cell(38, 4, utf8_decode(self::$ubicacion->telefono1), 1, 0, 'C');
            $this->Cell(42, 4, utf8_decode($municipioPrestador->dNombre . "-" . $municipioPrestador->mNombre), 1, 0, 'C');
            $this->Ln();
        } else {
            $this->Cell(120, 4, utf8_decode(''), 1, 0, 'C');
            $this->Cell(38, 4, utf8_decode(''), 1, 0, 'C');
            $this->Cell(42, 4, utf8_decode('' . "-" . ''), 1, 0, 'C');
            $this->Ln();
        }
        $this->SetX(5);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(25, 4, utf8_decode('Diagnósticos'), 1, 0, 'L', 1);
        $this->Cell(175, 4, (self::$cie10s ? implode(', ', array_column(self::$cie10s, 'codigo_cie10')) : "NA"), 1, 0, 'L');
        $this->SetFont('Arial', '', 7.5);

        $this->Ln();
        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(15, 4, utf8_decode('Código'), 1, 0, 'C', 1);
        $this->Cell(165, 4, utf8_decode('Nombre'), 1, 0, 'C', 1);
        $this->Cell(20, 4, utf8_decode('Cantidad'), 1, 0, 'C', 1);
        //this->Cell(48, 4, utf8_decode('Observación'), 1, 0, 'C', 1);
    }


    public function footer()
    {
        $this->SetFont('Arial', '', 6);
        $yOffset = $this->GetY() + 2;

        // Ajustar el rectángulo de "IMPORTANTE"
        $this->Rect(5, $yOffset, 200, 7);
        $this->SetXY(5, $yOffset);

        if (self::$afiliado->entidad_id === 1) {
            $textoImportante = "Autorización valida solamente en los 120 dias despues de la fecha de su expedición, una vez cumplido dicho plazo no hay responsabilidad de FOMAG. (Resolucion 4331 de 2012)";
        } else {
            $textoImportante = "Autorización valida solamente en los 120 dias despues de la fecha de su expedición, una vez cumplido dicho plazo no hay responsabilidad. (Resolucion 4331 de 2012)";
        }


        $this->MultiCell(200, 3, utf8_decode("IMPORTANTE: " . $textoImportante), 0, "L", 0);

        $yOffset = $this->GetY(); // Actualiza el yOffset para continuar debajo del texto importante

        // Texto de notas de auditoría
        $textoNotas = "NOTAS AUDITORIA:";

        // estado no igual a 4 no va mostrar observaciones que se le hagan
        if (self::$ordenProcedimiento->estado_id == 4) {
            $notasAuditoria = array();
            foreach (self::$ordenProcedimiento->auditoria as $auditoria) {
                $notasAuditoria[] = utf8_decode($auditoria->observaciones);
            }
            $textoNotas = "NOTAS AUDITORIA: " . implode(', ', $notasAuditoria);
        }

        $lineas = $this->GetStringWidth($textoNotas) / 200;
        $alturaRect = ceil($lineas) * 5;

        $yOffset += 4;
        $this->Rect(5, $yOffset, 200, $alturaRect);
        $this->SetXY(5, $yOffset);
        $this->MultiCell(200, 4, $textoNotas, 0, "L", 0);

        $this->SetFont('Arial', 'B', 8);

        // Ancho total de la página menos los márgenes
        $anchoTotal = 200;

        // Ancho de cada rectángulo
        $anchoCuadro = $anchoTotal / 3;

        // Posiciones X de los textos
        $posX1 = 6;
        $posX2 = $posX1 + $anchoCuadro;
        $posX3 = $posX2 + $anchoCuadro;

        // Posiciones Y de los textos
        $yOffset = $this->GetY();

        $this->Text($posX1, $yOffset + 5, utf8_decode('Firmado electrónicamente por'));
        $this->Text($posX2, $yOffset + 5, utf8_decode('Recibido a conformidad'));
        $this->SetFont('Arial', '', 7.5);
        $this->Text($posX2, $yOffset + 20, utf8_decode('Firma válida para todas las fórmulas de este recetario.'));

        if (self::$consulta->tipo_consulta_id == 1) {
            $this->SetFont('Arial', 'B', 8);
            $this->Text($posX3, $yOffset + 6, utf8_decode('Firma de quien Transcribe')); // Ajuste para centrar mejor el texto
        }

        // Dibujar los rectángulos
        $this->Rect(5, $yOffset + 3, $anchoCuadro, 18);
        $this->Rect(5 + $anchoCuadro, $yOffset + 3, $anchoCuadro, 18);
        $this->Rect(5 + 2 * $anchoCuadro, $yOffset + 3, $anchoCuadro, 18);
        $newYOffset = $yOffset + 10 + 20.5 + 5;
        if (self::$consulta->tipo_consulta_id == 1) {
            $this->SetFont('Arial', 'B', 7);
            $transcripcion = Transcripcione::where('consulta_id', self::$consulta->id)->first();
            if ($transcripcion) {
                // Lógica basada en tipo_transcripcion
                if (empty($transcripcion->tipo_transcripcion) || $transcripcion->tipo_transcripcion == 'Externa') {
                    $transcripcion->tipo_transcripcion = $transcripcion->tipo_transcripcion ?? 'Externa';
                    $this->Text(6, $yOffset + 9, utf8_decode("Nombre: " . $transcripcion->nombre_medico_ordeno));
                    $this->Text(6, $yOffset + 13, utf8_decode("Documento/Registro Medico: " . $transcripcion->documento_medico_ordeno));
                } else {
                    if (self::$consulta->medico_ordena_id) {
                        $user = User::find(self::$consulta->medico_ordena_id);
                        $medicoTranscripcion = Operadore::where('operadores.user_id', $user->id)->first();

                        if ($medicoTranscripcion) {
                            if ($user->firma && file_exists(storage_path(substr($user->firma, 9)))) {
                                $this->Image(storage_path(substr($user->firma, 9)), 42, $yOffset + 9, 20, 10);
                                $this->Text(6, 10 + $yOffset, utf8_decode($medicoTranscripcion->nombre . " " . $medicoTranscripcion->apellido));
                                $this->Text(6, 15 + $yOffset, utf8_decode("R.M: " . $medicoTranscripcion->documento));
                            } else {
                                $this->firmaPorDefecto($this, $yOffset);
                            }
                        } else {
                            $this->firmaPorDefecto($this, $yOffset);
                        }
                    } else {
                        $this->firmaPorDefecto($this, $yOffset);
                    }
                }

                if ($transcripcion->tipo_transcripcion == 'Externa') {
                    $funcionarioGenera = Operadore::where('operadores.user_id', self::$consulta->medico_ordena_id)->first();
                    $this->Text(140, $yOffset + 9, utf8_decode("Nombre: " . $funcionarioGenera->nombre . " " . $funcionarioGenera->apellido));
                    $this->Text(140, $yOffset + 13, utf8_decode("Documento: " . $funcionarioGenera->documento));
                } else {
                    $user = User::find(self::$consulta->user_id);
                    if ($user) {
                        $transcriptor = Operadore::where('operadores.user_id', $user->id)->first();
                        if ($transcriptor && $user->firma && file_exists(storage_path(substr($user->firma, 9)))) {
                            $this->Image(storage_path(substr($user->firma, 9)), 175, $yOffset + 9, 20, 10);
                            $this->Text(140, 10 + $yOffset, utf8_decode($transcriptor->nombre . " " . $transcriptor->apellido));
                            $this->Text(140, 15 + $yOffset, utf8_decode("R.M: " . $transcriptor->documento));
                        } else {
                            $this->Text(140, $yOffset + 9, utf8_decode("Nombre: " . $transcriptor->nombre . " " . $transcriptor->apellido));
                            $this->Text(140, $yOffset + 13, utf8_decode("Documento: " . $transcriptor->documento));
                        }
                    }
                }
            }
        } else {
            if (isset(self::$medico)) {
                $usuario = User::find(self::$medico->user_id);
                $this->SetFont('Arial', 'B', 6);
                if ($usuario->firma && file_exists(storage_path(substr($usuario->firma, 9)))) {
                    $this->Text(6, 10 + $yOffset, utf8_decode(self::$medico->nombre . " " . self::$medico->apellido));
                    $this->Text(6, 15 + $yOffset, utf8_decode("R.M: " . self::$medico->documento));
                    $this->Image(storage_path(substr($usuario->firma, 9)), 42, $yOffset + 9, 20, 10);
                } else {
                    $this->firmaPorDefecto($this, $yOffset);
                }
            } else {
                $this->firmaPorDefecto($this, $yOffset);
            }

            // if(self::$consulta->firma_paciente){
            //     $base64Image= self::$consulta->firma_paciente;
            //     $explodedData = explode(',', $base64Image);
            //     $type = $explodedData[0];
            //     $base64Data = $explodedData[1];
            //     $imageData = base64_decode($base64Data);

            //     // Guarda la imagen temporalmente
            //     $tempImage = tempnam(sys_get_temp_dir(), 'firma') . '.png';
            //     file_put_contents($tempImage, $imageData);
            //     $this->Image($tempImage, 85, $yOffset + 8, 20, 10); // Ajusta las coordenadas y el tamaño según sea necesario
            //     // Elimina el archivo temporal
            //     unlink($tempImage);
            // }
        }

        $widthText = 100;

        $xText = 2;
        $yText = $newYOffset - 14;
        $this->SetXY($xText, $yText);

        $fechaImpresion = date('d/m/Y H:i:s');
        $text = utf8_decode('Fecha impresión: ' . $fechaImpresion);
        $this->MultiCell($widthText, 5, $text, 0, 'C', false);

        $this->SetXY($xText + 50, $yText);
        $correoElectronico = auth()->user()->email ?? 'Fomag';
        $textEmail = utf8_decode('Correo electrónico: ' . $correoElectronico);
        $this->MultiCell(200, 5, $textEmail, 0, 'C', false);
    }


    public function firmaPorDefecto($pdf, $yOffset)
    {
        $medicoDefecto = public_path() . "/images/firmaDefecto.png";
        $pdf->Image($medicoDefecto, 40, 6 + $yOffset, 20, 17);
        $pdf->Text(6, 10 + $yOffset, utf8_decode("Carlos Alfredo Pinto Hernández"));
        $pdf->Text(6, 15 + $yOffset, utf8_decode("R.M: 681618814"));
    }

    public function body($pdf)
    {
        $servicios = OrdenProcedimiento::leftJoin('auditorias', 'auditorias.orden_procedimiento_id', 'orden_procedimientos.id')
            ->whereIn('orden_procedimientos.estado_id', [1, 4, 14, 54])
            ->where('orden_id', self::$data["servicios"][0]['orden_id'])
            ->get();

        $serviciosAgrupados = $servicios->groupBy('rep_id');

        foreach ($serviciosAgrupados as $rep_id => $servicios_rep) {
            $rep = Rep::where('id', intval($rep_id))->first();

            self::$ubicacion = new \stdClass();
            if (empty($rep_id)) {
                self::$ubicacion->nombre = 'N/A';
                self::$ubicacion->direccion = 'N/A';
                self::$ubicacion->telefono1 = 'N/A';
                self::$ubicacion->codigo_habilitacion = 'N/A';
                self::$ubicacion->prestador_id = null;
                self::$ubicacion->id = null;
            } else {
                $rep = Rep::find(intval($rep_id));
                self::$ubicacion->nombre = $rep->nombre ?? 'N/A';
                self::$ubicacion->direccion = $rep->direccion ?? 'N/A';
                self::$ubicacion->telefono1 = $rep->telefono1 ?? 'N/A';
                self::$ubicacion->codigo_habilitacion = $rep->codigo_habilitacion ?? 'N/A';
                self::$ubicacion->prestador_id = $rep->prestador_id ?? null;
                self::$ubicacion->id = $rep->id ?? null;
            }
            $pdf->AddPage();
            $logoBD = null;
            $logo1 = public_path("/images/logoEcoimagen.png");
            $tempLogoPath = null;

            if (!empty($rep_id) && is_numeric($rep_id)) {
                $logoBD = LogosRepsHistoria::where('rep_id', intval($rep_id))->first();
            }

            if ($logoBD && Storage::disk('server37')->exists("logosRepsHistoria/{$logoBD->nombre_logo}")) {
                try {
                    $tiposPermitidos = ['jpg', 'jpeg', 'png', 'gif'];
                    $extension = pathinfo($logoBD->nombre_logo, PATHINFO_EXTENSION);

                    if (in_array(strtolower($extension), $tiposPermitidos)) {
                        $urlTemporal = Storage::disk('server37')->temporaryUrl(
                            "logosRepsHistoria/{$logoBD->nombre_logo}",
                            now()->addMinutes(5)
                        );
                        $contenidoLogo = file_get_contents($urlTemporal);
                        $tempLogoPath = storage_path("app/temp_logo_sede_{$rep_id}.{$extension}");
                        file_put_contents($tempLogoPath, $contenidoLogo);
                        $logo1 = $tempLogoPath;
                    }
                } catch (\Exception $e) {

                }
            }

            $logo2 = null;
            if (self::$afiliado->entidad_id === 3) {
                $logo2 = public_path("/images/logotipo_fps.jpg");
            }

            $this->agregarEncabezado($pdf, $logo1, $logo2);

            $Y = 82;
            $countPerPage = 0;

            foreach ($servicios_rep as $servicio) {
                if ($countPerPage >= 3) {
                    $countPerPage = 0;
                    $pdf->AddPage();
                    $this->agregarEncabezado($pdf, $logo1, $logo2);
                    $Y = 82;
                }

                $pdf->SetFont('Arial', '', 6.5);
                $pdf->SetXY(5, $Y);
                $pdf->MultiCell(15, 2.8, $servicio->cup->codigo ?? 'N/A', 0, 'C', 0);
                $pdf->SetXY(24, $Y);
                $pdf->MultiCell(150, 2.8, utf8_decode(strtoupper($servicio->cup->nombre ?? 'N/A')), 0, 'L', 0);

                $YN1 = round($pdf->GetY(), 0, PHP_ROUND_HALF_DOWN);
                $YN2 = round($pdf->GetY(), 0, PHP_ROUND_HALF_DOWN);

                $pdf->SetXY(188, $Y);
                $pdf->MultiCell(20, 2.8, $servicio->cantidad ?? 'N/A', 0, 'C', 0);

                $YN = max($YN1, $YN2);
                $YO = round($pdf->GetY(), 0, PHP_ROUND_HALF_DOWN);
                $pdf->SetXY(5, max($YO, $YN));

                $pdf->SetFont('Arial', 'B', 7);
                $pdf->MultiCell(200, 4, utf8_decode('Observaciones: ' . ($servicio->observacion ?? 'N/A')), 0, 'L', 0);
                $pdf->Line(5, max($YO, $YN) + 4, 205, max($YO, $YN) + 4);

                $YL = round($pdf->GetY(), 0, PHP_ROUND_HALF_DOWN);
                $pdf->Line(5, $Y - 2, 5, max($YL, $YN));
                $pdf->Line(205, $Y - 2, 205, max($YL, $YN));

                $Y = $Y + (max($YN, $YL) - $Y);
                $countPerPage++;
            }

            if ($tempLogoPath && file_exists($tempLogoPath)) {
                unlink($tempLogoPath);
            }
        }
    }

    private function agregarEncabezado($pdf, $logo1, $logo2)
    {
        $rectX = 5;
        $rectY = 5;
        $centroX = 25;
        $anchoRectangulo = 80;
        $altoRectangulo = 18;
        $pdf->Rect($rectX, $rectY, $anchoRectangulo, $altoRectangulo);

        $anchoLogo1 = 30;
        $altoLogo1 = 15;
        $anchoLogo2 = 30;
        $altoLogo2 = 15;

        if (self::$afiliado->entidad_id === 3) {
            $posXLogo1 = $rectX + ($anchoRectangulo / 4) - ($anchoLogo1 / 2);
        } else {
            $posXLogo1 = $centroX + ($anchoRectangulo / 4) - ($anchoLogo1 / 2);
        }
        $posYLogo1 = $rectY + ($altoRectangulo / 2) - ($altoLogo1 / 2);

        if ($logo1 && file_exists($logo1)) {
            $pdf->Image($logo1, $posXLogo1, $posYLogo1, $anchoLogo1, $altoLogo1);
        }

        if ($logo2) {
            $posXLogo2 = $rectX + (3 * $anchoRectangulo / 4) - ($anchoLogo2 / 2);
            $posYLogo2 = $rectY + ($altoRectangulo / 2) - ($altoLogo2 / 2);
            $pdf->Image($logo2, $posXLogo2, $posYLogo2, $anchoLogo2, $altoLogo2);
        }
    }
}
