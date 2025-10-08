<?php

namespace App\Formats\Medicamentos;

use App\Http\Modules\Operadores\Models\Operadore;
use App\Http\Modules\Prestadores\Models\Prestador;
use App\Http\Modules\Rips\Us\Models\Us;
use App\Http\Modules\Transcripciones\Transcripcion\Models\Transcripcione;
use App\Http\Modules\Usuarios\Models\User;
use Codedge\Fpdf\Fpdf\Fpdf;

class Medicamento extends Fpdf
{
    var $angle = 0;
    protected $orden;
    protected $rep;
    protected $afiliado;
    protected $consulta;
    protected $cie10s;
    protected $marcaDeAgua;
    protected $info;

    public function __construct()
    {
        # inicializmos el parent constructor
        parent::__construct('P', 'mm', 'A4');
    }

    public function Header()
    {
        $this->SetFont('Arial', 'B', 50);
        $this->SetTextColor(255, 192, 203);
        $this->RotatedText(12, 134, $this->marcaDeAgua, 33);
        $this->SetTextColor(0, 0, 0);

        $logo1 = public_path() . "/images/logoEcoimagen.png";
        $logo2 = null;
        // Si no hay logo2 personalizado, usar según entidad
        if (!$logo2) {
            if ($this->afiliado->entidad_id === 1) {
                $logo2 = public_path("/images/logoFomag.png");
            } elseif ($this->afiliado->entidad_id === 3) {
                $logo2 = public_path("/images/logotipo_fps.jpg");
            }
        }

        // Rectángulo
        $rectX = 5;
        $rectY = 5;
        $anchoRectangulo = 54;
        $altoRectangulo = 15;
        $this->Rect($rectX, $rectY, $anchoRectangulo, $altoRectangulo);

        // Tamaños
        $anchoLogo1 = 15;
        $altoLogo1 = 10;
        $anchoLogo2 = 15;
        $altoLogo2 = 10;

        // Posición logo1
        $posXLogo1 = $rectX + ($anchoRectangulo / 4) - ($anchoLogo1 / 2);
        $posYLogo1 = $rectY + ($altoRectangulo / 2) - ($altoLogo1 / 2);
        $this->Image($logo1, $posXLogo1, $posYLogo1, $anchoLogo1, $altoLogo1);

        // Posición logo2 si aplica
        if ($logo2) {
            $posXLogo2 = $rectX + (3 * $anchoRectangulo / 4) - ($anchoLogo2 / 2);
            $posYLogo2 = $rectY + ($altoRectangulo / 2) - ($altoLogo2 / 2);
            $this->Image($logo2, $posXLogo2, $posYLogo2, $anchoLogo2, $altoLogo2);
        }

        // Eliminar temporal si se creó
        if (isset($tempLogoPath) && file_exists($tempLogoPath)) {
            unlink($tempLogoPath);
        }


        $Y = 12;
        $this->SetFont('Arial', 'B', 9);
        $anchoRectangulo = 73; // Ancho del rectángulo
        $altoRectangulo = 15;  // Alto del rectángulo
        $posXRectangulo = 60;  // Posición X del rectángulo
        $posYRectangulo = 5;   // Posición Y del rectángulo

        // Dibuja el rectángulo
        $this->Rect($posXRectangulo, $posYRectangulo, $anchoRectangulo, $altoRectangulo);

        // Centrar el contenido dentro del rectángulo
        $anchoCelda = $anchoRectangulo - 10; // Resta un pequeño margen para evitar que el texto toque los bordes

        if ($this->consulta->tipo_consulta_id == 1) {
            $transcripcion = Transcripcione::where('consulta_id', $this->consulta->id)
                ->with([
                    'sede'
                ])
                ->first();
            $nombre = '';
            if ($transcripcion->prestador_id != null) {
                $prestador = Prestador::find($transcripcion->prestador_id);
                $nombre = $prestador->nombre_prestador;
            } else {
                $nombre = 'SUMIMEDICAL S.A.S';
            }
            $Y = 8;
            $this->SetFont('Arial', '', 5);

            // Líneas alineadas a la izquierda
            $this->SetXY($posXRectangulo + 5, $Y);
            $this->Cell($anchoCelda, 0, utf8_decode('FECHA DE AUTORIZACIÓN: ' . $this->orden->fecha_vigencia), 0, 0, 'L');

            $this->SetXY($posXRectangulo + 5, $Y + 3);
            $this->Cell($anchoCelda, 0, utf8_decode("RÉGIMEN: ESPECIAL"), 0, 0, 'L');

            $this->SetXY($posXRectangulo + 5, $Y + 6);
            $this->Cell($anchoCelda, 0, utf8_decode("NÚMERO DE AUTORIZACIÓN: " . $this->orden->id), 0, 0, 'L');

            $this->SetXY($posXRectangulo + 5, $Y + 10);
            $this->Cell($anchoCelda, 0, utf8_decode('IPS GENERADORA: ' . $nombre), 0, 0, 'L');

            // $this->SetXY($posXRectangulo + 5, $Y + 13);
            // $this->Cell($anchoCelda, 0, utf8_decode(self::$repId), 0, 0, 'L');
            // Líneas alineadas a la derecha
            $this->SetXY($posXRectangulo + 4, $Y); // Posición para la etiqueta "IPS ORDENA"
            $this->Cell($anchoCelda, 0, utf8_decode('IPS ORDENA:'), 0, 0, 'R');

            // Coloca el nombre debajo de la etiqueta "IPS ORDENA"
            $this->SetXY($posXRectangulo + 4, $Y + 3); // Ajusta la posición Y para el nombre
            $this->Cell($anchoCelda, 0, utf8_decode($nombre), 0, 0, 'R');
        } else {
            // Primera línea
            $Y = 8;
            $this->SetFont('Arial', '', 7);
            $this->SetXY($posXRectangulo + 5, $Y);
            $this->Cell($anchoCelda, 0, utf8_decode('FECHA DE AUTORIZACIÓN: ' . $this->orden->fecha_vigencia), 0, 0, 'L');

            $this->SetXY($posXRectangulo + 5, $Y + 3);
            $this->Cell($anchoCelda, 0, utf8_decode("RÉGIMEN: ESPECIAL"), 0, 0, 'L');

            $this->SetXY($posXRectangulo + 5, $Y + 6);
            $this->Cell($anchoCelda, 0, utf8_decode("NÚMERO DE AUTORIZACIÓN: " . $this->orden->id), 0, 0, 'L');

            $this->SetXY($posXRectangulo + 5, $Y + 10);
            $this->Cell($anchoCelda, 0, utf8_decode('IPS GENERADORA: ' . $this->afiliado->ips->nombre), 0, 0, 'L');

            // $this->SetXY($posXRectangulo + 5, $Y + 13);
            // $this->Cell($anchoCelda, 0, utf8_decode(self::$sedeProveedor->nombre), 0, 0, 'L');
        }
        $this->SetXY(80, $Y + 12);
        $this->SetFont('Arial', 'B', 8);
        // if ($this->afiliado->entidad_id == 3) {
        //     $this->Cell(90, 0, utf8_decode('Contrato Ferrocarriles'), 0, 0, 'C');
        // }

        $this->Rect(134, 5, 71, 15);

        $this->Line(145 + 30, 5, 145 + 30, 20);
        $this->SetXY(140, 8);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(30, 5, utf8_decode('SUMIMEDICAL S.A.S'), 0, 1, 'L');

        $this->SetXY(140, 15);
        $this->Cell(30, 5, utf8_decode('NIT: 900033371 Res: 004'), 0, 0, 'L');

        $qr = public_path() . "/images/qrMedicamentosFormatoNuevo.jpeg";
        $xQR = 170 + (30 - 11) / 2;

        $this->Image($qr, $xQR, 7, 16, 11);

        $this->Ln(10);
        $this->SetFillColor(216, 216, 216);
        $this->SetFont('Arial', 'B', 8);
        $this->SetXY(5, 21);
        $this->Cell(98, 4, utf8_decode('Nombre Paciente'), 1, 0, 'C', 1);
        $this->Cell(10, 4, utf8_decode('Sexo'), 1, 0, 'C', 1);
        $this->Cell(60, 4, utf8_decode('Identificación'), 1, 0, 'C', 1);
        $this->Cell(10, 4, 'Edad', 1, 0, 'C', 1);
        $this->Cell(22, 4, 'Nacimiento', 1, 0, 'C', 1);
        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', '', 8);
        $this->Cell(98, 4, utf8_decode($this->afiliado->nombre_completo), 1, 0, 'C');
        $this->SetFont('Arial', '', 7.5);
        $this->Cell(10, 4, utf8_decode($this->afiliado->sexo), 1, 0, 'C');
        $this->Cell(60, 4, utf8_decode($this->afiliado->tipoDocumento->sigla . " - " . $this->afiliado->numero_documento), 1, 0, 'C');
        $this->Cell(10, 4, $this->afiliado->edad_cumplida, 1, 0, 'C');
        $this->Cell(22, 4, $this->afiliado->fecha_nacimiento, 1, 0, 'C');
        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', '', 8);
        $this->Cell(200, 4, utf8_decode('IPS primaria: ' . $this->afiliado->ips->nombre), 1, 0, 'L');
        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', '', 8);
        $this->Cell(200, 4, utf8_decode('Dirección: ' . $this->afiliado->direccion_residencia_cargue), 1, 0, 'L');
        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(66.6, 4, 'Telefono', 1, 0, 'C', 1);
        $this->Cell(66.6, 4, 'Correo', 1, 0, 'C', 1);
        $this->Cell(66.7, 4, 'Municipio', 1, 0, 'C', 1);
        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', '', 7.5);
        $this->Cell(66.6, 4, utf8_decode($this->afiliado->telefono) . " - " . utf8_decode($this->afiliado->celular1), 1, 0, 'C');
        $this->Cell(66.6, 4, utf8_decode($this->afiliado->correo1), 1, 0, 'C');
        $this->Cell(66.7, 4, utf8_decode($this->afiliado->departamento_atencion->nombre . "-" . $this->afiliado->municipio_atencion->nombre), 1, 0, 'C');
        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(200, 4, utf8_decode('Nombre Prestador'), 1, 0, 'C', 1);
        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', '', 8);
        $this->Cell(200, 4, utf8_decode('Punto de entrega: FARMACIA FOMAG'), 1, 0, 'L');
        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(120, 4, 'Direccion', 1, 0, 'C', 1);
        $this->Cell(38, 4, 'Telefono', 1, 0, 'C', 1);
        $this->Cell(42, 4, 'Municipio', 1, 0, 'C', 1);
        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', '', 7);

        $this->Cell(120, 4, utf8_decode($this->rep->direccion), 1, 0, 'C');
        $this->Cell(38, 4, utf8_decode($this->rep->telefono1), 1, 0, 'C');
        $this->Cell(42, 4, utf8_decode($this->rep->municipio->nombre . "-" . $this->rep->municipio->departamento->nombre), 1, 0, 'C');
        $this->Ln();

        $this->SetX(5);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(25, 4, utf8_decode('Diagnósticos'), 1, 0, 'L', 1);
        $this->Cell(175, 4, count($this->cie10s) ? implode(', ', $this->cie10s) : 'NA', 1, 0, 'L');
        $this->SetFont('Arial', '', 7.5);

        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(18, 4, utf8_decode('Código'), 1, 0, 'C', 1);
        $this->Cell(85, 4, utf8_decode('Nombre'), 1, 0, 'C', 1);
        $this->Cell(17, 4, utf8_decode('Via Admin'), 1, 0, 'C', 1);
        $this->Cell(54, 4, utf8_decode('Dosificación'), 1, 0, 'C', 1);
        $this->Cell(14, 4, utf8_decode('Duración'), 1, 0, 'C', 1);
        $this->Cell(12, 4, utf8_decode('Dosis'), 1, 0, 'C', 1);
    }

    public function Footer()
    {
        $this->SetFont('Arial', '', 6);
        $yOffset = $this->GetY() + 2;

        // Ajustar el rectángulo de "IMPORTANTE"
        $this->Rect(5, $yOffset, 200, 7);
        $this->SetXY(5, $yOffset);

        $this->MultiCell(200, 3, utf8_decode($this->info), 0, "L", 0);

        $yOffset = $this->GetY(); // Actualiza el yOffset para continuar debajo del texto importante

        // $codesumiParametrizacion = CodesumiEntidad::where('codesumi_id', self::$ordenArticulo->codesumi_id)->where('entidad_id', $this->afiliado->entidad_id)->first();

        // if (isset($codesumiParametrizacion['requiere_mipres'])) {
        //     $notasAuditoria[] = 'MIPRES';
        // }

        // if (isset(self::$ordenArticulo->auditorias)) {
        //     foreach (self::$ordenArticulo->auditorias as $auditoria) {
        //         $notasAuditoria[] = utf8_decode($auditoria->observaciones);
        //     }
        // }
        $textoNotas = "NOTAS AUDITORIA: MIPRES";

        $lineas = $this->GetStringWidth($textoNotas) / 200;
        $alturaRect = ceil($lineas) * 5;

        $yOffset += 2;
        $this->Rect(5, $yOffset, 200, $alturaRect);
        $this->SetXY(5, $yOffset);
        $this->MultiCell(200, 5, $textoNotas, 0, "L", 0);

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

        $this->Text($posX1, $yOffset + 4, utf8_decode('Firmado electrónicamente por'));
        $this->Text($posX2, $yOffset + 4, utf8_decode('Recibido a conformidad'));
        $this->SetFont('Arial', '', 7.5);
        $this->Text($posX2, $yOffset + 18, utf8_decode('Firma válida para todas las fórmulas de este recetario.'));

        if ($this->consulta->tipo_consulta_id == 1) {
            $this->SetFont('Arial', 'B', 8);
            $this->Text($posX3, $yOffset + 4, utf8_decode('Firma de quien Transcribe')); // Ajuste para centrar mejor el texto
        }

        // Dibujar los rectángulos
        $this->Rect(5, $yOffset + 0.7, $anchoCuadro, 18);
        $this->Rect(5 + $anchoCuadro, $yOffset + 0.7, $anchoCuadro, 18);
        $this->Rect(5 + 2 * $anchoCuadro, $yOffset + 0.7, $anchoCuadro, 18);
        $newYOffset = $yOffset + 10 + 20.5 + 5;
        if ($this->consulta->tipo_consulta_id == 1) {
            $this->SetFont('Arial', 'B', 7);
            $transcripcion = Transcripcione::where('consulta_id', $this->consulta->id)->first();

            if ($transcripcion) {
                // Lógica basada en tipo_transcripcion
                if (empty($transcripcion->tipo_transcripcion) || $transcripcion->tipo_transcripcion == 'Externa') {
                    $transcripcion->tipo_transcripcion = $transcripcion->tipo_transcripcion ?? 'Externa';
                    $this->Text(6, $yOffset + 9, utf8_decode("Nombre: " . $transcripcion->nombre_medico_ordeno));
                    $this->Text(6, $yOffset + 13, utf8_decode("Documento/Registro Medico: " . $transcripcion->documento_medico_ordeno));
                } else {
                    if ($this->consulta->medico_ordena_id) {
                        $user = User::find($this->consulta->medico_ordena_id);
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
                    $funcionarioGenera = Operadore::where('operadores.user_id', $this->consulta->medico_ordena_id)->first();
                    $this->Text(140, $yOffset + 9, utf8_decode("Nombre: " . $funcionarioGenera->nombre . " " . $funcionarioGenera->apellido));
                    $this->Text(140, $yOffset + 13, utf8_decode("Documento: " . $funcionarioGenera->documento));
                } else {
                    $user = User::find($this->consulta->user_id);
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
            $medico = User::with('operador')
                ->find($this->orden->user_id);
            if ($medico) {
                $this->SetFont('Arial', 'B', 6);
                if ($medico->firma && file_exists(storage_path(substr($medico->firma, 9)))) {
                    $this->Text(6, 10 + $yOffset, utf8_decode($medico->operador->nombre . " " . $medico->operador->apellido));
                    $this->Text(6, 15 + $yOffset, utf8_decode("R.M: " . $medico->operador->documento));
                    $this->Image(storage_path(substr($medico->firma, 9)), 42, $yOffset + 9, 20, 10);
                } else {
                    $this->firmaPorDefecto($this, $yOffset);
                }
            } else {
                $this->firmaPorDefecto($this, $yOffset);
            }

            // if ($this->consulta->firma_paciente) {
            //     $base64Image = $this->consulta->firma_paciente;
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

        // Configuración inicial
        $xText = 4; // Posicionamiento X
        $yText = $newYOffset - 17; // Posicionamiento Y

        $widthText = 70; // Ancho de cada celda

        // Colocar fecha de impresión
        $this->SetXY($xText, $yText);
        $fechaImpresion = date('d/m/Y H:i:s');
        $textFecha = utf8_decode('Fecha impresión: ' . $fechaImpresion);
        $this->Cell($widthText, 5, $textFecha, 0, 0, 'L'); // Alinear a la izquierda

        // Colocar correo electrónico
        $this->SetXY($xText + $widthText, $yText); // Ajustar X para el siguiente campo
        $correoElectronico = auth()->user()->email ?? 'Fomag';
        $textEmail = utf8_decode('Correo electrónico: ' . $correoElectronico);
        $this->Cell($widthText, 5, $textEmail, 0, 0, 'L'); // Alinear a la izquierda

        // Colocar orden
        $this->SetXY($xText + $widthText * 2, $yText); // Ajustar X para el siguiente campo
        $orden = $this->orden->paginacion ?? 'No disponible';
        $textOrden = utf8_decode('Orden: ' . $orden);
        $this->Cell($widthText, 5, $textOrden, 0, 0, 'L'); // Alinear a la izquierda

        // Opcional: Salto de línea después de los tres campos
        $this->Ln(5); // Salto de línea para dejar espacio después de la fila

    }

    protected function firmaPorDefecto($pdf, $yOffset = 10)
    {
        $medicoDefecto = public_path() . "/images/firmaDefecto.png";
        $pdf->Image($medicoDefecto, 40, 6 + $yOffset, 20, 17);
        $pdf->Text(6, 9 + $yOffset, utf8_decode("Carlos Alfredo Pinto Hernández"));
        $pdf->Text(6, 13 + $yOffset, utf8_decode("R.M: 681618814"));
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
}
