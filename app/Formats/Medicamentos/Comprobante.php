<?php

namespace App\Formats\Medicamentos;

use App\Http\Modules\Movimientos\Models\Movimiento;
use App\Http\Modules\Operadores\Models\Operadore;
use App\Http\Modules\Reps\Models\Rep;
use App\Http\Modules\Ordenamiento\Models\Orden;
use App\Http\Modules\Ordenamiento\Models\OrdenArticulo;
use App\Http\Modules\Prestadores\Models\Prestador;
use App\Http\Modules\Transcripciones\Transcripcion\Models\Transcripcione;
use App\Http\Modules\Usuarios\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class Comprobante extends Medicamento
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * genera el pdf de una formula dispensada
     * @param string $nombre
     * @return string ruta donde se guardará el pdf
     */
    public function generar(Orden|int $orden, string $nombre = 'formula.pdf', string|null $fecha = null): string
    {
        if (is_int($orden)) {
            $this->orden = Orden::where('id', $orden)->first();
        } else {
            $this->orden = $orden;
        }

        $this->marcaDeAgua = 'SOPORTE DE ENTREGA';
        $this->consulta = $this->orden->consulta;
        $this->afiliado = $this->orden->consulta->afiliado;
        $this->info = "";
        $this->cie10s = [];

        if ($this->orden->articulos->count() < 1) {
            return false;
        }
        $this->body($this->orden->articulos->whereIn('estado_id', [34, 18]));
        return $this->Output('F', storage_path('app/' . $nombre));
    }

    public function Header()
    {
        $this->SetFont('Arial', 'B', 50);
        $this->SetTextColor(255, 192, 203);
        $this->RotatedText(12, 134, $this->marcaDeAgua, 33);
        $this->SetTextColor(0, 0, 0);

        $logo1 = public_path() . "/images/logo_ramedicas.png";
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
        // $anchoLogo1 = 15;
        // $altoLogo1 = 10;
        $anchoLogo2 = 15;
        $altoLogo2 = 10;

        // Posición logo1
        // $posXLogo1 = $rectX + ($anchoRectangulo / 4) - ($anchoLogo1 / 2);
        // $posYLogo1 = $rectY + ($altoRectangulo / 2) - ($altoLogo1 / 2);
        //$this->Image($logo1, $posXLogo1, $posYLogo1, $anchoLogo1, $altoLogo1);

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
        $this->Cell(200, 4, utf8_decode('Punto de entrega: ' . $this->rep->nombre), 1, 0, 'L');
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
        $this->Cell(12, 4, utf8_decode('Dispensado'), 1, 0, 'C', 1);
    }

    /**
     * cuerpo del pdf
     * @param Collection $ordenArticulos
     * @return void
     */
    private function body(Collection $ordenArticulos)
    {
        $ordenArticulosAgrupados = $ordenArticulos->groupBy('rep_id');
        foreach ($ordenArticulosAgrupados as $rep_id => $articulos) {
            if (!$rep_id) {
                $this->rep = Rep::where('id', 77526)
                    ->with([
                        'municipio',
                        'municipio.departamento',
                    ])
                    ->first(); // este ID esta pensado para produccion, pertenece a FARMACIA RAMEDICAS CENTRO
            } else {
                $this->rep = Rep::where('id', $rep_id)->first();
            }

            $this->AddPage();
            $Y = 70;
            $countPerPage = 0; // Contador de medicamentos por página

            foreach ($articulos as $articulo) {

                if ($countPerPage >= 3) {
                    $countPerPage = 0;
                    $this->AddPage();
                    $Y = 70;
                }

                $this->SetFont('Arial', 'B', 6);
                $this->SetXY(5, $Y);
                $this->MultiCell(15, 4, $articulo->codesumi->codigo, 0, 'C', 0);
                $this->SetXY(24, $Y);
                $this->MultiCell(70, 4, utf8_decode(strtoupper($articulo->codesumi->nombre)), 0, 'L', 0);

                $YN1 = round($this->GetY(), 0, PHP_ROUND_HALF_DOWN);
                $this->SetXY(106, $Y);
                $dosificacion = is_null($articulo->dosificacion_medico) ? $articulo->formula : $articulo->dosificacion_medico;
                $palabras = explode(' ', trim($dosificacion));
                $segundoValor = isset($palabras[2]) ? $palabras[2] : '';
                $this->MultiCell(51, 4, utf8_decode($segundoValor), 0, 'L', 0);
                $this->SetXY(127, $Y);
                $this->MultiCell(51, 4, is_null($articulo->dosificacion_medico) ? utf8_decode($articulo->formula) : utf8_decode($articulo->dosificacion_medico), 0, 'L', 0);

                $YN2 = round($this->GetY(), 0, PHP_ROUND_HALF_DOWN);
                $this->SetXY(180, $Y);
                $this->MultiCell(13, 4, $articulo->duracion . ' dias', 0, 'C', 0);
                $this->SetXY(188, $Y);
                $this->MultiCell(20, 4, $articulo->cantidad_medico, 0, 'C', 0);

                $YN = max($YN1, $YN2);
                $YO = round($this->GetY(), 0, PHP_ROUND_HALF_DOWN);
                $this->SetXY(5, max($YO, $YN));
                $this->Line(5, max($YN + 0.5, $YO), 205, max($YN + 0.5, $YO));
                $this->SetFont('Arial', 'B', 7);
                $this->MultiCell(200, 4, utf8_decode('Observaciones: ' . $articulo->observacion), 0, 'L', 0);

                $YL = round($this->GetY(), 0, PHP_ROUND_HALF_DOWN);
                $this->Line(5, max($YL, $YN) + 2, 205, max($YL, $YN) + 2);

                $Y = max($YL, $YN) + 6;
                $countPerPage++;
            }
        }
    }

    public function Footer()
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
        $this->SetFont('Arial', '', 6.5);

        $this->Text($posX2, $yOffset + 22, utf8_decode('Fecha de entrega: ' . $this->getFechaCreacionMovimiento()), 0, 0, 'C');

        if ($this->consulta->tipo_consulta_id == 1) {
            $this->SetFont('Arial', 'B', 8);
            $this->Text($posX3, $yOffset + 6, utf8_decode('Firma de quien Transcribe'));
        }

        // Dibujar los rectángulos
        $this->Rect(5, $yOffset + 3, $anchoCuadro, 20.5);
        $this->Rect(5 + $anchoCuadro, $yOffset + 3, $anchoCuadro, 20.5);
        $this->Rect(5 + 2 * $anchoCuadro, $yOffset + 3, $anchoCuadro, 20.5);
        $newYOffset = $yOffset + 10 + 20.5 + 5;
        if ($this->consulta->tipo_consulta_id === 1) {
            $this->SetFont('Arial', 'B', 7);
            $transcripcion = Transcripcione::where('consulta_id', $this->consulta->id)->first();
            if ($transcripcion) {
                // Lógica basada en tipo_transcripcion
                if (empty($transcripcion->tipo_transcripcion) || $transcripcion->tipo_transcripcion == 'Externa') {
                    $transcripcion->tipo_transcripcion = $transcripcion->tipo_transcripcion ?? 'Externa';
                    $this->Text(6, $yOffset + 12, utf8_decode("Nombre: " . $transcripcion->nombre_medico_ordeno));
                    $this->Text(6, $yOffset + 18, utf8_decode("Documento/Registro Medico: " . $transcripcion->documento_medico_ordeno));
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
                    $this->Text(140, $yOffset + 12, utf8_decode("Nombre: " . $funcionarioGenera->nombre . " " . $funcionarioGenera->apellido));
                    $this->Text(140, $yOffset + 18, utf8_decode("Documento: " . $funcionarioGenera->documento));
                } else {
                    $user = User::find($this->consulta->user_id);
                    if ($user) {
                        $transcriptor = Operadore::where('operadores.user_id', $user->id)->first();
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
                $firmaPaciente = $this->getFirmaPaciente();
                if ($firmaPaciente) {
                    $base64Image = $firmaPaciente;
                    $explodedData = explode(',', $base64Image);
                    $type = $explodedData[0];
                    $base64Data = $explodedData[1];
                    $imageData = base64_decode($base64Data);

                    // Guarda la imagen temporalmente
                    $tempImage = tempnam(sys_get_temp_dir(), 'firma') . '.png';
                    file_put_contents($tempImage, $imageData);
                    $this->Image($tempImage, 74, $yOffset + 10, 62, 10); // Ajusta las coordenadas y el tamaño según sea necesario
                    $this->SetFont('Arial', '', 6);
                    $this->Text(73, 9 + $yOffset, utf8_decode($this->afiliado->nombre_completo . ' ' . $this->afiliado->tipoDocumento->sigla . " - " . $this->afiliado->numero_documento));
                    // $this->Text(73, 12 + $yOffset, utf8_decode(self::$afiliado["tipoDocumento"]["sigla"] . " - " . self::$afiliado["numero_documento"]));
                    unlink($tempImage);
                }
            }
        } else {
            $medico = $this->orden->funcionario;
            if ($medico) {
                $operador = $medico->operador;
                $this->SetFont('Arial', 'B', 6);
                if ($medico->firma && file_exists(storage_path(substr($medico->firma, 9)))) {
                    $this->Text(6, 10 + $yOffset, utf8_decode($operador->nombre . " " . $operador->apellido));
                    $this->Text(6, 15 + $yOffset, utf8_decode("R.M: " . $operador->documento));
                    $this->Image(storage_path(substr($medico->firma, 9)), 42, $yOffset + 9, 20, 10);
                } else {
                    $this->firmaPorDefecto($this, $yOffset);
                }
            } else {
                $this->firmaPorDefecto($this, $yOffset);
            }
            $firmaPaciente = $this->getFirmaPaciente();
            if ($firmaPaciente) {
                $base64Image = $firmaPaciente;
                $explodedData = explode(',', $base64Image);
                $type = $explodedData[0];
                $base64Data = $explodedData[1];
                $imageData = base64_decode($base64Data);

                // Guarda la imagen temporalmente
                $tempImage = tempnam(sys_get_temp_dir(), 'firma') . '.png';
                file_put_contents($tempImage, $imageData);
                $this->Image($tempImage, 74, $yOffset + 10, 62, 10); // Ajusta las coordenadas y el tamaño según sea necesario
                $this->SetFont('Arial', '', 6);
                $this->Text(73, 9 + $yOffset, utf8_decode($this->afiliado->nombre_completo . ' ' . $this->afiliado->tipoDocumento->sigla . " - " . $this->afiliado->numero_documento));
                // Elimina el archivo temporal
                unlink($tempImage);
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
        $orden = $this->orden->paginacion ?? 'No disponible';
        $textOrden = utf8_decode('Orden: ' . $orden);
        $this->MultiCell($widthText, 5, $textOrden, 0, 'L', false);
    }

    /**
     * obtiene la firma del paciente, que esta en alguno de los medicamentos dispensados
     */
    private function getFirmaPaciente()
    {
        $firma = null;
        foreach ($this->orden->articulos as $articulo) {
            if ($articulo->ultimoMovimiento && $articulo->ultimoMovimiento->firma_persona_recibe) {
                $firma = $articulo->ultimoMovimiento->firma_persona_recibe;
                break;
            }
        }

        if (!$firma) {
            $ultimaFirma = Movimiento::whereHas('ordenArticulo.orden.consulta', function ($query) {
                $query->where('consultas.afiliado_id', $this->afiliado->id);
            })
                ->whereNotNull('firma_persona_recibe')
                ->orderBy('created_at', 'desc')
                ->first();
            $firma = $ultimaFirma ? $ultimaFirma->firma_persona_recibe : null;
        }

        return $firma;
    }

    /**
     * obtiene la fecha de creacion del movimiento del primero que encuentre
     */
    private function getFechaCreacionMovimiento()
    {
        $fecha = $this->orden->articulos
            ->whereIn('estado_id', [34, 18])
            ->whereNotNull('ultimoMovimiento')
            ->first()->ultimoMovimiento->created_at;
        return $fecha ? Carbon::parse($fecha)->format('Y-m-d H:i:s') : null;
    }
}
