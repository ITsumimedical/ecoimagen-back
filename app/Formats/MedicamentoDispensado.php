<?php

namespace App\Formats;

use DNS2D;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Carbon;
use App\Http\Modules\Reps\Models\Rep;
use App\Http\Modules\Usuarios\Models\User;
use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Empleados\Models\Empleado;
use App\Http\Modules\Ordenamiento\Models\Orden;
use App\Http\Modules\Municipios\Models\Municipio;
use App\Http\Modules\Departamentos\Models\Departamento;
use App\Http\Modules\Cie10Afiliado\Models\Cie10Afiliado;
use App\Http\Modules\Movimientos\Models\Movimiento;
use App\Http\Modules\Operadores\Models\Operadore;
use App\Http\Modules\Ordenamiento\Models\OrdenArticulo;
use App\Http\Modules\Prestadores\Models\Prestador;
use App\Http\Modules\Transcripciones\Transcripcion\Models\Transcripcione;
use Illuminate\Support\Facades\File;
use PhpParser\Node\Expr\Empty_;

class MedicamentoDispensado extends Fpdf
{
    var $angle = 0;
    private static $orden;
    private static $afiliado;
    private static $sedeProveedor;
    private static $qr;
    private static $cie10s;
    private static $consulta;
    private static $medico;
    private static $departamentoAtencion;
    private static $municipioAtencion;
    private static $proveedor;
    private static $municipioPrestador;
    private static $ordenArticulo;
    private static $movimiento;
    private static $filtro;
    private static $repId;

    public function generar($request, $movimiento_id, $filtro = null, $fomag = false, $guardar = false, $rutaCertificado = null)
    {
        self::$ordenArticulo = OrdenArticulo::find($request['id']);
        self::$filtro = $filtro;
        self::$movimiento = $movimiento_id;

        // return self::$ordenArticulo;
        self::$orden = Orden::where('id', self::$ordenArticulo->orden_id)->first();
        self::$consulta = Consulta::where('id', self::$orden['consulta_id'])->first();
        self::$afiliado = Afiliado::find(self::$consulta->afiliado_id);
        self::$departamentoAtencion = Departamento::find(self::$afiliado->departamento_atencion_id);
        self::$municipioAtencion = Municipio::find(self::$afiliado->municipio_atencion_id);
        self::$sedeProveedor = Rep::find(self::$afiliado->ips_id);
        self::$cie10s = Cie10Afiliado::select('cie10s.codigo_cie10')->join('cie10s', 'cie10s.id', 'cie10_afiliados.cie10_id')->where('cie10_afiliados.consulta_id', self::$consulta->id)->get()->toArray();
        self::$medico = Operadore::where('user_id', self::$orden->user_id)->first();
        if (self::$ordenArticulo->rep_id) {
            self::$proveedor = Rep::find(strval(self::$ordenArticulo->rep_id));
            if (self::$proveedor) {
                self::$municipioPrestador = Municipio::select('municipios.nombre as mNombre', 'departamentos.nombre as dNombre')->join('departamentos', 'departamentos.id', 'municipios.departamento_id')->where('municipios.id', self::$proveedor->municipio_id)->first();
            }
        }
        self::$repId = null;

        if (self::$consulta->tipo_consulta_id == 1) {
            $transcripcion = self::$consulta->transcripcion;
            if ($transcripcion && $transcripcion->sede) {
                self::$repId = $transcripcion->sede->nombre;
            }
        } elseif (self::$consulta->tipo_consulta_id == 2 && self::$consulta->rep && self::$consulta->rep->nombre) {
            self::$repId = self::$consulta->rep->nombre;
        } elseif (self::$consulta->tipo_consulta_id == 8 && self::$consulta->agenda && self::$consulta->agenda->consultorio && self::$consulta->agenda->consultorio->rep) {
            self::$repId = self::$consulta->agenda->consultorio->rep->nombre;
        }

        $pdf = new MedicamentoDispensado('p', 'mm', 'A4');
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $this->body($pdf);
        if (!$guardar) {
            $pdf->Output();
        } else {
            $rutaAfiliado = $rutaCertificado . '/' . self::$afiliado->numero_documento;
            if (!File::exists($rutaAfiliado)) {
                File::makeDirectory($rutaAfiliado, 0777, true, true);
            }
            $movimiento = Movimiento::where('id', self::$movimiento)->first();
            $pdf->Output('F', $rutaAfiliado . '/' . self::$orden['consulta_id'] . self::$afiliado->numero_documento . '_' . substr(str_replace('-', '_', $movimiento->created_at), 0, 10) . '.pdf');
        }
    }

    public function header()
    {
        $this->SetFont('Arial', 'B', 30);
        $this->SetTextColor(255, 192, 203);
        $this->RotatedText(12, 124, 'C O M P R O B A N T E  DE  E N T R E G A', 22);
        $this->SetTextColor(0, 0, 0);

        if (self::$afiliado->entidad_id === 1) {
            $logo2 = public_path() . "/images/logoFomag.png";
            $logo1 = public_path() . "/images/logo_ramedicas.png";
        } elseif (self::$afiliado->entidad_id === 3) {
            $logo1 = public_path() . "/images/logo.png";
            $logo2 = public_path() . "/images/logotipo_fps.jpg";
        }

        // Tamaño del rectángulo
        $rectX = 5;
        $rectY = 5;
        $anchoRectangulo = 55;
        $altoRectangulo = 20;
        $this->Rect($rectX, $rectY, $anchoRectangulo, $altoRectangulo);
        $anchoLogo1 = 20;
        $altoLogo1 = 15;
        $anchoLogo2 = 20;
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
        $altoRectangulo = 20;  // Alto del rectángulo
        $posXRectangulo = 65;  // Posición X del rectángulo
        $posYRectangulo = 5;   // Posición Y del rectángulo

        // Dibuja el rectángulo
        $this->Rect($posXRectangulo, $posYRectangulo, $anchoRectangulo, $altoRectangulo);

        // Centrar el contenido dentro del rectángulo
        $anchoCelda = $anchoRectangulo - 10; // Resta un pequeño margen para evitar que el texto toque los bordes
        $this->SetXY($posXRectangulo + 5, $Y - 2); // Ajusta la posición X para centrar el contenido


        if (self::$consulta->tipo_consulta_id == 1) {
            $transcripcion = Transcripcione::where('consulta_id', self::$consulta->id)->first();
            if ($transcripcion->prestador_id != null) {
                $prestador = Prestador::find($transcripcion->prestador_id);
                $nombre = $prestador->nombre_prestador;
            } else {
                $nombre = 'SUMIMEDICAL S.A.S';
            }
            $Y = 8;
            $this->SetFont('Arial', '', 6);

            // Líneas alineadas a la izquierda
            $this->SetXY($posXRectangulo + 5, $Y);
            $this->Cell($anchoCelda, 0, utf8_decode('FECHA DE AUTORIZACIÓN: ' . self::$orden->articulos[0]->fecha_vigencia), 0, 0, 'L');

            $this->SetXY($posXRectangulo + 5, $Y + 3);
            $this->Cell($anchoCelda, 0, utf8_decode("RÉGIMEN: ESPECIAL"), 0, 0, 'L');

            $this->SetXY($posXRectangulo + 5, $Y + 6);
            $this->Cell($anchoCelda, 0, utf8_decode("NÚMERO DE AUTORIZACIÓN: " . self::$orden->id), 0, 0, 'L');

            $this->SetXY($posXRectangulo + 5, $Y + 10);
            $this->Cell($anchoCelda, 0, utf8_decode('IPS GENERADORA: '), 0, 0, 'L');

            $this->SetXY($posXRectangulo + 5, $Y + 13);
            $this->Cell($anchoCelda, 0, utf8_decode(self::$repId), 0, 0, 'L');
            // Líneas alineadas a la derecha
            $this->SetXY($posXRectangulo + 4, $Y); // Posición para la etiqueta "IPS ORDENA"
            $this->Cell($anchoCelda, 0, utf8_decode('IPS ORDENA:'), 0, 0, 'R');

            // Coloca el nombre debajo de la etiqueta "IPS ORDENA"
            $this->SetXY($posXRectangulo + 4, $Y + 3); // Ajusta la posición Y para el nombre
            $this->Cell($anchoCelda, 0, utf8_decode($nombre), 0, 0, 'R');
        } else {

            $Y = 8;
            $this->SetFont('Arial', '', 6);

            // Líneas alineadas a la izquierda
            // Primera línea
            $this->SetXY($posXRectangulo + 5, $Y);
            $this->SetXY($posXRectangulo + 5, $Y);
            $this->Cell($anchoCelda, 0, utf8_decode('FECHA DE AUTORIZACIÓN: ' . self::$orden->articulos[0]->fecha_vigencia), 0, 0, 'L');

            $this->SetXY($posXRectangulo + 5, $Y + 3);
            $this->Cell($anchoCelda, 0, utf8_decode("RÉGIMEN: ESPECIAL"), 0, 0, 'L');

            $this->SetXY($posXRectangulo + 5, $Y + 6);
            $this->Cell($anchoCelda, 0, utf8_decode("NÚMERO DE AUTORIZACIÓN: " . self::$orden->id), 0, 0, 'L');

            $this->SetXY($posXRectangulo + 5, $Y + 10);
            $this->Cell($anchoCelda, 0, utf8_decode('IPS GENERADORA: '), 0, 0, 'L');

            $this->SetXY($posXRectangulo + 5, $Y + 13);
            $this->Cell($anchoCelda, 0, utf8_decode(self::$sedeProveedor->nombre), 0, 0, 'L');
        }

        $this->SetXY(80, $Y + 12);
        $this->SetFont('Arial', 'B', 8);
        // if (self::$afiliado->entidad_id == 3) {
        //     $this->Cell(90, 0, utf8_decode('Contrato Ferrocarriles'), 0, 0, 'C');
        // }

        $this->Rect(149, 5, 55, 20);
        $this->SetFont('Arial', 'B', 9);

        $texto1 = utf8_decode('SUMIMEDICAL S.A.S');
        $anchoTexto1 = $this->GetStringWidth($texto1);
        $xCentrado1 = 149 + (55 / 2) - ($anchoTexto1 / 2);
        $this->SetXY($xCentrado1, 8);
        $this->Cell($anchoTexto1, 11, $texto1, 0, 1, 'C');
        $texto2 = utf8_decode('NIT: 900033371 Res: 004');
        $anchoTexto2 = $this->GetStringWidth($texto2);
        $xCentrado2 = 149 + (55 / 2) - ($anchoTexto2 / 2);
        $this->SetXY($xCentrado2, 15);
        $this->Cell($anchoTexto2, 10, $texto2, 0, 0, 'C');

        $this->Ln(10);
        $this->SetFillColor(216, 216, 216);
        $this->SetFont('Arial', 'B', 8);
        $this->SetXY(5, 26);
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
        $this->Cell(200, 4, utf8_decode('IPS primaria: ' . self::$sedeProveedor->nombre), 1, 0, 'L');
        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', '', 8);

        $this->Cell(200, 4, utf8_decode(
            'Dirección: ' .
            (
            !empty(self::$afiliado["direccion_residencia_numero_exterior"]) &&
            !empty(self::$afiliado["direccion_residencia_via"]) &&
            !empty(self::$afiliado["direccion_residencia_numero_interior"]) &&
            !empty(self::$afiliado["direccion_residencia_interior"]) &&
            !empty(self::$afiliado["direccion_residencia_barrio"])
                ?
                trim(
                    self::$afiliado["direccion_residencia_via"] . ' ' .
                    self::$afiliado["direccion_residencia_numero_exterior"] . ' ' .
                    self::$afiliado["direccion_residencia_numero_interior"] . ' ' .
                    self::$afiliado["direccion_residencia_interior"] . ' ' .
                    self::$afiliado["direccion_residencia_barrio"]
                ) .
                (
                !empty(self::$afiliado["direccion_residencia_cargue"])
                    ? ' (' . self::$afiliado["direccion_residencia_cargue"] . ')'
                    : ''
                )
                : (self::$afiliado["direccion_residencia_cargue"])

            )
        ), 1, 0, 'L');

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
        if (self::$proveedor instanceof Rep) {

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
        if (self::$cie10s && count(self::$cie10s) === 1) {
            // Si hay un solo CIE10, mostrarlo directamente
            $cie10 = self::$cie10s[0]['codigo_cie10'];
        } else {
            // Si hay más de uno, usar implode para concatenarlos
            $cie10 = self::$cie10s ? implode(', ', array_column(self::$cie10s, 'codigo_cie10')) : "Z000";
        }

        $this->Cell(175, 4, $cie10, 1, 0, 'L');

        $this->SetFont('Arial', '', 7.5);

        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(18, 4, utf8_decode('Código'), 1, 0, 'C', 1);
        $this->Cell(85, 4, utf8_decode('Nombre'), 1, 0, 'C', 1);
        $this->Cell(17, 4, utf8_decode('Via Admin'), 1, 0, 'C', 1);
        $this->Cell(54, 4, utf8_decode('Dosificación'), 1, 0, 'C', 1);
        $this->Cell(14, 4, utf8_decode('Duración'), 1, 0, 'C', 1);
        $this->SetFont('Arial', 'B', 5);
        $this->Cell(12, 4, utf8_decode('Dispensado'), 1, 0, 'C', 1);
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
        $this->SetFont('Arial', '', 6.5);
        $movimiento = Movimiento::where('id', self::$movimiento)->first();
        $this->Text($posX2, $yOffset + 22, utf8_decode('Fecha de entrega: ' . $movimiento->created_at), 0, 0, 'C');

        if (self::$consulta->tipo_consulta_id == 1) {
            $this->SetFont('Arial', 'B', 8);
            $this->Text($posX3, $yOffset + 6, utf8_decode('Firma de quien Transcribe'));
        }

        // Dibujar los rectángulos
        $this->Rect(5, $yOffset + 3, $anchoCuadro, 20.5);
        $this->Rect(5 + $anchoCuadro, $yOffset + 3, $anchoCuadro, 20.5);
        $this->Rect(5 + 2 * $anchoCuadro, $yOffset + 3, $anchoCuadro, 20.5);
        $newYOffset = $yOffset + 10 + 20.5 + 5;
        if (self::$consulta->tipo_consulta_id == 1) {
            $this->SetFont('Arial', 'B', 7);
            $transcripcion = Transcripcione::where('consulta_id', self::$consulta->id)->first();

            if ($transcripcion) {
                // Lógica basada en tipo_transcripcion
                if (empty($transcripcion->tipo_transcripcion) || $transcripcion->tipo_transcripcion == 'Externa') {
                    $transcripcion->tipo_transcripcion = $transcripcion->tipo_transcripcion ?? 'Externa';
                    $this->Text(6, $yOffset + 12, utf8_decode("Nombre: " . $transcripcion->nombre_medico_ordeno));
                    $this->Text(6, $yOffset + 18, utf8_decode("Documento/Registro Medico: " . $transcripcion->documento_medico_ordeno));
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
                    $this->Text(140, $yOffset + 12, utf8_decode("Nombre: " . $funcionarioGenera->nombre . " " . $funcionarioGenera->apellido));
                    $this->Text(140, $yOffset + 18, utf8_decode("Documento: " . $funcionarioGenera->documento));
                } else {
                    $user = User::find(self::$consulta->user_id);
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

                if ($movimiento->firma_persona_recibe) {
                    $base64Image = $movimiento->firma_persona_recibe;
                    $explodedData = explode(',', $base64Image);
                    $type = $explodedData[0];
                    $base64Data = $explodedData[1];
                    $imageData = base64_decode($base64Data);

                    // Guarda la imagen temporalmente
                    $tempImage = tempnam(sys_get_temp_dir(), 'firma') . '.png';
                    file_put_contents($tempImage, $imageData);
                    $this->Image($tempImage, 74, $yOffset + 10, 62, 10); // Ajusta las coordenadas y el tamaño según sea necesario
                    $this->SetFont('Arial', '', 6);
                    $this->Text(73, 9 + $yOffset, utf8_decode(self::$afiliado["nombre_completo"] . ' ' . self::$afiliado["tipoDocumento"]["sigla"] . " - " . self::$afiliado["numero_documento"]));
                    // $this->Text(73, 12 + $yOffset, utf8_decode(self::$afiliado["tipoDocumento"]["sigla"] . " - " . self::$afiliado["numero_documento"]));
                    unlink($tempImage);
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

            if ($movimiento->firma_persona_recibe) {
                $base64Image = $movimiento->firma_persona_recibe;
                $explodedData = explode(',', $base64Image);
                $type = $explodedData[0];
                $base64Data = $explodedData[1];
                $imageData = base64_decode($base64Data);

                // Guarda la imagen temporalmente
                $tempImage = tempnam(sys_get_temp_dir(), 'firma') . '.png';
                file_put_contents($tempImage, $imageData);
                $this->Image($tempImage, 74, $yOffset + 10, 62, 10); // Ajusta las coordenadas y el tamaño según sea necesario
                $this->SetFont('Arial', '', 6);
                $this->Text(73, 9 + $yOffset, utf8_decode(self::$afiliado["nombre_completo"] . ' ' . self::$afiliado["tipoDocumento"]["sigla"] . " - " . self::$afiliado["numero_documento"]));
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
        $orden = self::$orden["paginacion"] ?? 'No disponible';
        $textOrden = utf8_decode('Orden: ' . $orden);
        $this->MultiCell($widthText, 5, $textOrden, 0, 'L', false);
    }

    public function firmaPorDefecto($pdf, $yOffset = 10)
    {
        $medicoDefecto = public_path() . "/images/firmaDefecto.png";
        $pdf->Image($medicoDefecto, 40, 6 + $yOffset, 20, 17);
        $pdf->Text(6, 10 + $yOffset, utf8_decode("Carlos Alfredo Pinto Hernández"));
        $pdf->Text(6, 15 + $yOffset, utf8_decode("R.M: 681618814"));
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


    public function body($pdf)
    {
        $movimientoInicial = Movimiento::where('id', self::$movimiento)->first(['id', 'created_at', 'orden_id']);


        $fecha = $movimientoInicial->created_at->format('Y-m-d');
        $ordenId = $movimientoInicial->orden_id;

        $movimientosDia = Movimiento::with(['detalleMovimientos','ordenArticulo.codesumi'])
            ->whereDate('created_at', $fecha)
            ->where('orden_id', $ordenId)
            ->get();



//        $ordenesArticulos = OrdenArticulo::with('codesumi')->whereIn('estado_id', [18, 34])->where('id', $movimiento->orden_articulo_id)->get();


        $Y = 76;
        $countPerPage = 0; // Contador de medicamentos por página

        foreach ($movimientosDia as $item) {
            // Obtener la suma de cantidad_solicitada
            // Obtener la suma de cantidad_solicitada desde detalleMovimientos
            $cantidadSolicitada = $item->detalleMovimientos->sum('cantidad_solicitada');

            // Verificar si cantidad_solicitada es cero o null
            if ($cantidadSolicitada === 0 || $cantidadSolicitada === null) {
                continue; // imprimir - continuar con el siguiente medicamento si es cero o null
            }

            if ($countPerPage >= 3) { // Si ya se imprimieron 3 medicamentos en esta página
                $countPerPage = 0; // Reiniciar el contador
                $pdf->AddPage(); // Agregar una nueva página
                $Y = 76; // Reiniciar la posición Y
            }

            $pdf->SetFont('Arial', 'B', 6);
            // Colocar los elementos
            $pdf->SetXY(5, $Y);
            $pdf->MultiCell(15, 4, utf8_decode(strtoupper($item->ordenArticulo->codesumi->codigo)), 0, 'C', 0);
            $pdf->SetXY(24, $Y);
            $pdf->MultiCell(70, 4, utf8_decode(strtoupper($item->ordenArticulo->codesumi->nombre)), 0, 'L', 0);

            // Obtener la posición Y después de las celdas
            $YN1 = round($pdf->GetY(), 0, PHP_ROUND_HALF_DOWN);

            $pdf->SetXY(106, $Y);
            $pdf->MultiCell(20, 4, utf8_decode(strtoupper($item->ordenArticulo->codesumi->via)), 0, 'C', 0);
            $pdf->SetXY(127, $Y);
            $pdf->MultiCell(51, 4, is_null($item->ordenArticulo->dosificacion_medico) ? utf8_decode($item->ordenArticulo->formula) : utf8_decode($item->ordenArticulo->dosificacion_medico), 0, 'L', 0);


            $YN2 = round($pdf->GetY(), 0, PHP_ROUND_HALF_DOWN);

            $pdf->SetXY(180, $Y);
            $pdf->MultiCell(13, 4, utf8_decode($item->ordenArticulo->duracion . ' días'), 0, 'C', 0);
            $pdf->SetXY(188, $Y);
            $pdf->MultiCell(20, 4, $cantidadSolicitada, 0, 'C', 0);

            // Calcular la posición Y final
            $YN = max($YN1, $YN2);
            $YO = round($pdf->GetY(), 0, PHP_ROUND_HALF_DOWN);
            $pdf->SetXY(5, max($YO, $YN));
            $pdf->Line(5, max($YN + 0.5, $YO), 205, max($YN + 0.5, $YO)); // Línea arriba de la observación

            // Dibujar la observación y una línea horizontal debajo de cada medicamento
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->MultiCell(200, 4, utf8_decode('Observaciones: ' . $item->ordenArticulo->observacion), 0, 'L', 0);


            $YL = round($pdf->GetY(), 0, PHP_ROUND_HALF_DOWN);

            // Dibujar la línea horizontal debajo de las observaciones
            $pdf->Line(5, max($YL, $YN) + 0.5, 205, max($YL, $YN) + 0.5); // Línea debajo de la observación

            // Actualizar $Y para la siguiente fila
            $Y = $Y + (max($YN, $YL) - $Y);
            $countPerPage++; // Incrementar el contador de medicamentos impresos en la página actual
        }
    }
}
