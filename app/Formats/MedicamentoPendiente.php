<?php

namespace App\Formats;

use Codedge\Fpdf\Fpdf\Fpdf;
use App\Traits\PdfTrait;

class MedicamentoPendiente extends Fpdf
{

    use PdfTrait;

    var $angle = 0;
    private static $orden;
    private static $cie10s;
    private static $ordenesArticulos;
    private static $proveedor;
    private static $municipioPrestador;
    private static $transcripcion;


    public function generar($medicamentoPendiente, $fomag = false)
    {

        self::$orden = $medicamentoPendiente->orden;
        self::$cie10s = $medicamentoPendiente->cie10s;
        self::$proveedor = $medicamentoPendiente->proveedor;
        self::$municipioPrestador = $medicamentoPendiente->municipioPrestador;
        self::$ordenesArticulos =  $medicamentoPendiente->ordenesArticulos;
        self::$transcripcion = $medicamentoPendiente->transcripcion;

        if ($fomag) {
            $this->convertirPdfenBase64();
        } else {
            $this->generarPDF('I');
        }
    }

    public function header()
    {
        $this->SetFont('Arial', 'B', 50);
        $this->SetTextColor(255, 192, 203);
        $this->RotatedText(12, 134, 'M E D. P E N D I E N T E', 33);
        $this->SetTextColor(0, 0, 0);

        if (self::$orden->consulta->afiliado->entidad_id === 1) {
            $logo2 = public_path() . "/images/logoFomag.png";
            $logo1 = public_path() . "/images/logo_ramedicas.png";
        } elseif (self::$orden->consulta->afiliado->entidad_id === 3) {
            $logo1 = public_path() . "/images/logo.png";
            $logo2 = public_path() . "/images/logotipo_fps.jpg";
        }

        // Tamaño del rectángulo
        $rectX = 5;
        $rectY = 5;
        $anchoRectangulo = 80;
        $altoRectangulo = 25;
        $this->Rect($rectX, $rectY, $anchoRectangulo, $altoRectangulo);
        $anchoLogo1 = 30;
        $altoLogo1 = 15;
        $anchoLogo2 = 30;
        $altoLogo2 = 15;

        // Centrar logo1 en el rectángulo
        $posXLogo1 = $rectX + ($anchoRectangulo / 4) - ($anchoLogo1 / 2);
        $posYLogo1 = $rectY + ($altoRectangulo / 2) - ($altoLogo1 / 2);
        $this->Image($logo1, $posXLogo1, $posYLogo1, $anchoLogo1, $altoLogo1);

        // Centrar logo2 en el rectángulo
        $posXLogo2 = $rectX + (3 * $anchoRectangulo / 4) - ($anchoLogo2 / 2);
        $posYLogo2 = $rectY + ($altoRectangulo / 2) - ($altoLogo2 / 2);
        $this->Image($logo2, $posXLogo2, $posYLogo2, $anchoLogo2, $altoLogo2);


        $Y = 12;
        $this->SetFont('Arial', 'B', 9);
        $anchoRectangulo = 80; // Ancho del rectángulo
        $altoRectangulo = 25;  // Alto del rectángulo
        $posXRectangulo = 85;  // Posición X del rectángulo
        $posYRectangulo = 5;   // Posición Y del rectángulo

        // Dibuja el rectángulo
        $this->Rect($posXRectangulo, $posYRectangulo, $anchoRectangulo, $altoRectangulo);

        // Centrar el contenido dentro del rectángulo
        $anchoCelda = $anchoRectangulo - 10; // Resta un pequeño margen para evitar que el texto toque los bordes
        $this->SetXY($posXRectangulo + 5, $Y - 2); // Ajusta la posición X para centrar el contenido



        if (self::$orden->consulta->tipo_consulta_id == 1) {

            if (self::$transcripcion->prestador_id != null) {
                $prestador = self::$transcripcion->prestador;
                $nombre = $prestador->nombre_prestador;
            } else {
                $nombre = 'SUMIMEDICAL S.A.S';
            }
            $Y = 8;
            $this->SetFont('Arial', 'B', 7);
            // Primera línea
            $this->SetXY($posXRectangulo + 5, $Y); // Sube el valor de Y para colocar la siguiente línea
            $this->Cell($anchoCelda, 0, utf8_decode('FECHA DE AUTORIZACIÓN: ' . self::$orden->articulos[0]->fecha_vigencia), 0, 0, 'L');

            // Segunda línea
            $this->SetXY($posXRectangulo + 5, $Y + 3); // Sube el valor de Y para colocar la siguiente línea
            $this->Cell($anchoCelda, 0, utf8_decode("RÉGIMEN: ESPECIAL"), 0, 0, 'L');
            $this->SetXY($posXRectangulo + 5, $Y + 6); // Sube el valor de Y para colocar la siguiente línea
            $this->Cell($anchoCelda, 0, utf8_decode("NÚMERO DE AUTORIZACIÓN: " . self::$orden->id), 0, 0, 'L');

            // Tercera línea
            $this->SetXY($posXRectangulo + 5, $Y + 10); // Continúa ajustando la posición Y
            $this->Cell($anchoCelda, 0, utf8_decode('IPS GENERADORA: '), 0, 0, 'L');
            // Cuarta línea
            $this->SetXY($posXRectangulo + 5, $Y + 13); // Continúa ajustando la posición Y
            $this->Cell($anchoCelda, 0, utf8_decode(self::$orden->consulta->afiliado->ips->nombre), 0, 0, 'L');
            //Quinta linea
            $this->SetXY($posXRectangulo + 5, $Y + 17); // Continúa ajustando la posición Y
            $this->Cell($anchoCelda, 0, utf8_decode('IPS ORDENA:'), 0, 0, 'l');

            //Sexta linea
            $this->SetXY($posXRectangulo + 5, $Y + 20); // Continúa ajustando la posición Y
            $this->Cell($anchoCelda, 0, utf8_decode($nombre), 0, 0, 'l');
        } else {
            // Primera línea
            $this->Cell($anchoCelda, 0, utf8_decode('FECHA DE AUTORIZACIÓN: ' . self::$orden->articulos[0]->fecha_vigencia), 0, 0, 'L');

            // Segunda línea
            $this->SetXY($posXRectangulo + 5, $Y + 2); // Sube el valor de Y para colocar la siguiente línea
            $this->Cell($anchoCelda, 0, utf8_decode("RÉGIMEN: ESPECIAL"), 0, 0, 'L');
            $this->SetXY($posXRectangulo + 5, $Y + 6); // Sube el valor de Y para colocar la siguiente línea
            $this->Cell($anchoCelda, 0, utf8_decode("NÚMERO DE AUTORIZACIÓN: " . self::$orden->id), 0, 0, 'L');

            // Tercera línea
            $this->SetXY($posXRectangulo + 5, $Y + 10); // Continúa ajustando la posición Y
            $this->Cell($anchoCelda, 0, utf8_decode('IPS GENERADORA: '), 0, 0, 'L');
            // Tercera línea
            $this->SetXY($posXRectangulo + 5, $Y + 14); // Continúa ajustando la posición Y
            $this->SetFont('Arial', '', 8);
            $this->Cell($anchoCelda, 0, utf8_decode(self::$orden->consulta->afiliado->ips->nombre), 0, 0, 'L');
        }

        $this->SetXY(80, $Y + 12);
        $this->SetFont('Arial', 'B', 8);
        // if (self::$orden->consulta->afiliado->entidad_id == 3) {
        //     $this->Cell(90, 0, utf8_decode('Contrato Ferrocarriles'), 0, 0, 'C');
        // }

        $this->Rect(165, 5, 40, 25);
        $this->SetXY(165, 8);
        $this->SetFont('Arial', 'B', 9);

        $this->Cell(40, 11, utf8_decode('SUMIMEDICAL S.A.S'), 0, 1, 'C');

        $this->SetXY(165, 15);
        $this->Cell(40, 10, utf8_decode('NIT: 900033371 Res: 004'), 0, 0, 'C');



        $this->Ln(10);
        $this->SetFillColor(216, 216, 216);
        $this->SetFont('Arial', 'B', 8);
        $this->SetXY(5, 35);
        $this->Cell(98, 4, utf8_decode('Nombre Paciente'), 1, 0, 'C', 1);
        $this->Cell(10, 4, utf8_decode('Sexo'), 1, 0, 'C', 1);
        $this->Cell(60, 4, utf8_decode('Identificación'), 1, 0, 'C', 1);
        $this->Cell(10, 4, 'Edad', 1, 0, 'C', 1);
        $this->Cell(22, 4, 'Nacimiento', 1, 0, 'C', 1);
        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', '', 8);
        $this->Cell(98, 4, utf8_decode(self::$orden->consulta->afiliado["nombre_completo"]), 1, 0, 'C');
        $this->SetFont('Arial', '', 7.5);
        $this->Cell(10, 4, utf8_decode(self::$orden->consulta->afiliado["sexo"]), 1, 0, 'C');
        $this->Cell(60, 4, utf8_decode(self::$orden->consulta->afiliado["tipoDocumento"]["sigla"] . " - " . self::$orden->consulta->afiliado["numero_documento"]), 1, 0, 'C');
        $this->Cell(10, 4, self::$orden->consulta->afiliado["edad_cumplida"], 1, 0, 'C');
        $this->Cell(22, 4, self::$orden->consulta->afiliado["fecha_nacimiento"], 1, 0, 'C');
        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', '', 8);
        $this->Cell(200, 4, utf8_decode('IPS primaria: ' . self::$orden->consulta->afiliado->ips->nombre), 1, 0, 'L');
        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', '', 8);
        $this->Cell(200, 4, utf8_decode('Dirección: ' . self::$orden->consulta->afiliado->direccion_residencia_cargue), 1, 0, 'L');
        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(66.6, 4, 'Telefono', 1, 0, 'C', 1);
        $this->Cell(66.6, 4, 'Correo', 1, 0, 'C', 1);
        $this->Cell(66.7, 4, 'Municipio', 1, 0, 'C', 1);
        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', '', 7.5);
        $this->Cell(66.6, 4, utf8_decode(self::$orden->consulta->afiliado->telefono) . " - " . utf8_decode(self::$orden->consulta->afiliado->celular1), 1, 0, 'C');
        $this->Cell(66.6, 4, utf8_decode(self::$orden->consulta->afiliado->correo1), 1, 0, 'C');
        $this->Cell(66.7, 4, utf8_decode(self::$orden->consulta->afiliado->departamento_atencion->nombre . "-" . self::$orden->consulta->afiliado->municipio_atencion->nombre), 1, 0, 'C');
        $this->Ln();
        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(200, 4, utf8_decode('Nombre Prestador'), 1, 0, 'C', 1);
        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', '', 8);
        if (self::$proveedor == null) {
            $this->Cell(200, 4, utf8_decode('Punto de entrega: Farmacia'), 1, 0, 'L');
        } else {
            $this->Cell(200, 4, utf8_decode('Punto de entrega: ' . self::$proveedor->nombre), 1, 0, 'L');
        }
        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(120, 4, 'Direccion', 1, 0, 'C', 1);
        $this->Cell(38, 4, 'Telefono', 1, 0, 'C', 1);
        $this->Cell(42, 4, 'Municipio', 1, 0, 'C', 1);
        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', '', 7);
        if (self::$proveedor) {
            $this->Cell(120, 4, utf8_decode(self::$proveedor->direccion), 1, 0, 'C');
            $this->Cell(38, 4, utf8_decode(self::$proveedor->telefono1), 1, 0, 'C');
            $this->Cell(42, 4, utf8_decode(self::$municipioPrestador->dNombre . "-" . self::$municipioPrestador->mNombre), 1, 0, 'C');
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
        $this->Cell(175, 4, (self::$cie10s ? implode(', ', array_column(self::$cie10s, 'codigo_cie10')) : "Z000"), 1, 0, 'L');
        $this->SetFont('Arial', '', 7.5);

        $this->Ln();
        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(18, 4, utf8_decode('Código'), 1, 0, 'C', 1);
        $this->Cell(85, 4, utf8_decode('Nombre'), 1, 0, 'C', 1);
        $this->Cell(17, 4, utf8_decode('Via Admin'), 1, 0, 'C', 1);
        $this->Cell(54, 4, utf8_decode('Dosificación'), 1, 0, 'C', 1);
        $this->Cell(14, 4, utf8_decode('Duración'), 1, 0, 'C', 1);
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(12, 4, utf8_decode('Pendiente'), 1, 0, 'C', 1);
        $this->SetFont('Arial', 'B', 7);
    }



    public function footer()
    {
        $yOffset = $this->GetY() + 4;

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

        $this->Text($posX1, $yOffset + 6, utf8_decode('Firmado electrónicamente por'));
        $this->Text($posX2, $yOffset + 6, utf8_decode('Recibido a conformidad'));
        $this->SetFont('Arial', '', 7.5);
        $this->Text($posX2, $yOffset + 22, utf8_decode('Firma válida para todas las fórmulas de este recetario.'));

        if (self::$orden->consulta->tipo_consulta_id == 1) {
            $this->SetFont('Arial', 'B', 8);
            $this->Text($posX3, $yOffset + 6, utf8_decode('Firma de quien Transcribe')); // Ajuste para centrar mejor el texto
        }

        // Dibujar los rectángulos
        $this->Rect(5, $yOffset + 3, $anchoCuadro, 20.5);
        $this->Rect(5 + $anchoCuadro, $yOffset + 3, $anchoCuadro, 20.5);
        $this->Rect(5 + 2 * $anchoCuadro, $yOffset + 3, $anchoCuadro, 20.5);
        $newYOffset = $yOffset + 10 + 20.5 + 5;
        if (self::$orden->consulta->tipo_consulta_id == 1) {
            $this->SetFont('Arial', 'B', 7);

            if (self::$transcripcion) {
                // Lógica basada en tipo_transcripcion
                if (empty(self::$transcripcion->tipo_transcripcion) || self::$transcripcion->tipo_transcripcion == 'Externa') {
                    self::$transcripcion->tipo_transcripcion = $transcripcion->tipo_transcripcion ?? 'Externa';
                    $this->Text(6, $yOffset + 12, utf8_decode("Nombre: " . self::$transcripcion->nombre_medico_ordeno));
                    $this->Text(6, $yOffset + 18, utf8_decode("Documento/Registro Medico: " . self::$transcripcion->documento_medico_ordeno));
                } else {
                    if (self::$orden->consulta->medico_ordena_id) {
                        $medicoTranscripcion = self::$orden->consulta->medicoOrdena->operador;

                        if ($medicoTranscripcion) {
                            if (self::$orden->consulta->medicoOrdena->firma && file_exists(storage_path(substr(self::$orden->consulta->medicoOrdena->firma, 9)))) {
                                $this->Image(storage_path(substr(self::$orden->consulta->medicoOrdena->firma, 9)), 42, $yOffset + 9, 20, 10);
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

                if (self::$transcripcion->tipo_transcripcion == 'Externa') {
                    $funcionarioGenera = self::$orden->consulta->medicoOrdena;
                    $this->Text(140, $yOffset + 12, utf8_decode("Nombre: " . $funcionarioGenera->nombre . " " . $funcionarioGenera->apellido));
                    $this->Text(140, $yOffset + 18, utf8_decode("Documento: " . $funcionarioGenera->documento));
                } else {
                    $user = self::$orden->consulta->user;
                    if ($user) {
                        $transcriptor = self::$orden->consulta->user->operador;
                        if ($transcriptor && $user->firma && file_exists(storage_path(substr($user->firma, 9)))) {
                            $this->Image(storage_path(substr($user->firma, 9)), 175, $yOffset + 9, 20, 10);
                            $this->Text(140, 10 + $yOffset, utf8_decode($transcriptor->nombre . " " . $transcriptor->apellido));
                            $this->Text(140, 15 + $yOffset, utf8_decode("R.M: " . $transcriptor->documento));
                        } else {
                            $this->Text(140, $yOffset + 12, utf8_decode("Nombre: " . $transcriptor->nombre . " " . $transcriptor->apellido));
                            $this->Text(140, $yOffset + 18, utf8_decode("Documento: " . $transcriptor->documento));
                        }
                    }
                }
            }
        } else {
            if (isset(self::$orden->funcionario->operador)) {
                $usuario = self::$orden->funcionario;
                $this->SetFont('Arial', 'B', 6);
                if ($usuario->firma && file_exists(storage_path(substr($usuario->firma, 9)))) {
                    $this->Text(6, 10 + $yOffset, utf8_decode(self::$orden->funcionario->operador->nombre . " " . self::$orden->funcionario->operador->apellido));
                    $this->Text(6, 15 + $yOffset, utf8_decode("R.M: " . self::$orden->funcionario->operador->documento));
                    $this->Image(storage_path(substr($usuario->firma, 9)), 42, $yOffset + 9, 20, 10);
                } else {
                    $this->firmaPorDefecto($this, $yOffset);
                }
            } else {
                $this->firmaPorDefecto($this, $yOffset);
            }
        }
        $this->SetFont('Times', 'B', 7);

        $widthText = 100;
        $xText = 35;
        $yText = $newYOffset - 12;
        $this->SetXY($xText, $yText);
        $fechaImpresion = date('d/m/Y H:i:s');
        $text = utf8_decode('Fecha impresión: ' . $fechaImpresion);
        $this->MultiCell($widthText, 5, $text, 0, 'L', false);

        $this->SetXY($xText + 50, $yText);
        $correoElectronico = auth()->user()->email ?? 'Fomag';
        $textEmail = utf8_decode('Correo electrónico: ' . $correoElectronico);
        $this->MultiCell(200, 5, $textEmail, 0, 'L', false);

        $this->SetXY($xText + 120, $yText);
        $orden = self::$orden["paginacion"] ?? 'No disponible';
        $textOrden = utf8_decode('Orden: ' . $orden);
        $this->MultiCell($widthText, 5, $textOrden, 0, 'L', false);
    }

    public function firmaPorDefecto($name, $yOffset = 10)
    {
        $medicoDefecto = public_path() . "/images/firmaDefecto.png";
        $this->Image($medicoDefecto, 40, 6 + $yOffset, 20, 17);
        $this->Text(6, 10 + $yOffset, utf8_decode("Carlos Alfredo Pinto Hernández"));
        $this->Text(6, 15 + $yOffset, utf8_decode("R.M: 681618814"));
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


    public function body()
    {

        $Y = 91;
        $this->SetFont('Arial', '', 8);
        $countPerPage = 0;
        foreach (self::$ordenesArticulos as $ordenesArticulo) {
            if ($countPerPage >= 3) { // Si ya se imprimieron 3 medicamentos en esta página
                $countPerPage = 0; // Reiniciar el contador
                $this->AddPage(); // Agregar una nueva página
                $Y = 91; // Reiniciar la posición Y
            }

            $this->SetFont('Arial', 'B', 6);
            // Colocar los elementos
            $this->SetXY(5, $Y);
            $this->MultiCell(15, 4, $ordenesArticulo->codesumi->codigo, 0, 'C', 0);
            $this->SetXY(24, $Y);
            $this->MultiCell(70, 4, utf8_decode(strtoupper($ordenesArticulo->codesumi->nombre)), 0, 'L', 0);

            // Obtener la posición Y después de las celdas
            $YN1 = round($this->GetY(), 0, PHP_ROUND_HALF_DOWN);

            $this->SetXY(106, $Y);
            $this->MultiCell(20, 4, $ordenesArticulo->codesumi->via, 0, 'C', 0);
            $this->SetXY(127, $Y);
            $this->MultiCell(51, 4, is_null($ordenesArticulo->dosificacion_medico) ? utf8_decode($ordenesArticulo->formula) : utf8_decode($ordenesArticulo->dosificacion_medico), 0, 'L', 0);


            $YN2 = round($this->GetY(), 0, PHP_ROUND_HALF_DOWN);

            $this->SetXY(180, $Y);
            $this->MultiCell(13, 4, utf8_decode($ordenesArticulo->duracion . ' días'), 0, 'C', 0);
            $this->SetXY(188, $Y);
            $this->MultiCell(20, 4, $ordenesArticulo->cantidad_mensual_disponible, 0, 'C', 0);

            // Calcular la posición Y final
            $YN = max($YN1, $YN2);
            $YO = round($this->GetY(), 0, PHP_ROUND_HALF_DOWN);
            $this->SetXY(5, max($YO, $YN));

            // Dibujar la observación y una línea horizontal debajo de cada medicamento
            $this->SetFont('Arial', 'B', 7);
            $this->MultiCell(200, 4, utf8_decode('Observaciones: ' . $ordenesArticulo->observacion), 0, 'L', 0);
            $this->Line(5, max($YO, $YN) + 4, 205, max($YO, $YN) + 4);

            // Obtener la nueva posición Y después de la observación
            $YL = round($this->GetY(), 0, PHP_ROUND_HALF_DOWN);

            // Dibujar la línea vertical al lado del contenido de cada medicamento
            // El punto inicial es $Y y el punto final es el máximo entre $YN y $YL
            $this->Line(5, $Y - 2, 5, max($YL, $YN)); // Línea vertical en la columna de código
            $this->Line(205, $Y - 2, 205, max($YL, $YN)); // Línea vertical al final de la tabla

            // Actualizar $Y para la siguiente fila
            $Y = $Y + (max($YN, $YL) - $Y);
            $countPerPage++; // Incrementar el contador de medicamentos impresos en la página actual
        }
    }
}
