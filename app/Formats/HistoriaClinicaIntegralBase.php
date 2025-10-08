<?php

namespace App\Formats;

use DateTime;
use SplFileInfo;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Traits\ArchivosTrait;
use App\Plugins\pdfProteccion;
use Illuminate\Support\Facades\Mail;

use App\Http\Modules\AdmisionesUrgencias\Models\AdmisionesUrgencia;
use App\Http\Modules\LogosRepsHistoria\Model\LogosRepsHistoria;
use App\Http\Modules\TipoHistorias\Models\TipoHistoria;
use App\Traits\PdfTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class HistoriaClinicaIntegralBase extends pdfProteccion
{
    protected $consulta;
    protected static $resultados;
    protected static $tipoHistoriaNombre;
    protected static $tipoHistoria;
    var $isLastPage = false;
    use ArchivosTrait;

    use PdfTrait;

    public function generar($consulta, $correo, $triage = null, $ruta = null)
    {
        $this->consulta = $consulta;
        $this->DatosTipoHistoria();
        $this->AliasNbPages();
        $this->AddPage();
        $this->body();
        //$pdfContent = $this->Output('S');
        if ($correo) {
            $this->SetProtection(['print'], $this->consulta["afiliado"]["numero_documento"], $this->consulta["afiliado"]["numero_documento"]);
            $data = [];
            $nombre = $this->consulta["afiliado"]["nombre_completo"];
            $cedula = $this->consulta["afiliado"]["numero_documento"];
            Mail::send('enviar_historia', $data, function ($message) use ($correo, $nombre, $cedula) {
                $message->to($correo);
                $message->subject($cedula . " " . $nombre);
                $message->attachData($this->Output("S"), 'Historia Integral' . ' ' . $cedula . ' ' . $nombre . '.pdf', [
                    'mime' => 'application/pdf',
                ]);
            });
        }


        if ($triage) {
            $admision = AdmisionesUrgencia::find($this->consulta->admision_urgencia_id);
            $ruta = 'adjuntosReferencia';
            $archivo = $this->Output("S");
            $nombreOriginal = $admision->codigo_centro_regulador . '/' . 'historia_triage_' . $this->consulta->id . '.pdf';
            $nombre = 'historia_triage_' . $this->consulta->id . '.pdf';
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

        if ($ruta) {
            return $this->Output('F', $ruta);
        } else {
            $this->Output();
        }
    }

    /**
     * DatosTipoHistoria
     * Obtiene los datos del tipo de historia que llega con sus componentes asociados
     *
     * @return void
     */
    private function DatosTipoHistoria()
    {
        $tipoHistoriaId = $this->consulta['cita']['tipo_historia_id'];
        self::$tipoHistoria = TipoHistoria::with('componentesHistoriaClinica')->find($tipoHistoriaId);
        self::$tipoHistoriaNombre = self::$tipoHistoria->nombre ?? 'HISTORIA CLÍNICA';
    }


    public function Header()
    {
        if ($this->page == 1) {
            $Y = 40;

            $this->SetFont('Arial', 'B', 9);
            $rep = $this->consulta->rep;
            $repId = $rep->id ?? null;

            if (!$repId) {
                $this->Image(public_path("/images/logoEcoimagen.png"), 16, 9, 40, 25);
            } else {
                $logo = LogosRepsHistoria::where('rep_id', $repId)->first();
                if (!$logo || !Storage::disk('server37')->exists("logosRepsHistoria/{$logo->nombre_logo}")) {
                    $this->Image(public_path("/images/logoEcoimagen.png"), 16, 9, 40, 25);
                } else {
                    $tempPath = null;
                    try {
                        $logoUrl = Storage::disk('server37')->temporaryUrl(
                            "logosRepsHistoria/{$logo->nombre_logo}",
                            now()->addMinutes(5)
                        );

                        $imageContent = file_get_contents($logoUrl);
                        $imageInfo = @getimagesizefromstring($imageContent);

                        $tiposPermitidos = [
                            'image/jpeg' => 'jpg',
                            'image/jpg'  => 'jpg',
                            'image/png'  => 'png',
                        ];

                        if (!$imageInfo || !array_key_exists($imageInfo['mime'], $tiposPermitidos)) {
                            $this->Image(public_path("/images/logoEcoimagen.png"), 16, 9, 40, 25);
                        } else {
                            $extension = $tiposPermitidos[$imageInfo['mime']];
                            $tempPath = storage_path("app/temp_logo_{$repId}.{$extension}");
                            file_put_contents($tempPath, $imageContent);

                            try {
                                $this->Image($tempPath, 16, 9, 40, 25);
                            } catch (\Exception $e) {
                                $this->Image(public_path("/images/logoEcoimagen.png"), 16, 9, 40, 25);
                            }
                        }
                    } catch (\Exception $e) {
                        $this->Image(public_path("/images/logoEcoimagen.png"), 16, 9, 40, 25);
                    } finally {
                        if ($tempPath && file_exists($tempPath)) {
                            unlink($tempPath);
                        }
                    }
                }
            }

            $Y = 35;
            $this->SetFont('Arial', '', 7);

            $nombre    = $rep->nombre     ?? 'SUMIMEDICAL S.A.S';
            $codigo    = $rep->codigo     ?? 'NIT: 900033371 Res: 004';
            $direccion = $rep->direccion  ?? 'Carrera 80C #32E-65';
            $telefono  = $rep->telefono1  ?? 'Teléfono: (604) 5201040';

            $this->SetXY(8, $Y);
            $this->Cell(60, 3, utf8_decode($nombre), 0, 0, 'C');
            $this->SetXY(8, $Y + 3);
            $this->Cell(60, 3, utf8_decode($codigo), 0, 0, 'C');
            $this->SetXY(8, $Y + 6);
            $this->Cell(60, 3, utf8_decode($direccion), 0, 0, 'C');
            $this->SetXY(8, $Y + 9);
            $this->Cell(60, 3, utf8_decode($telefono), 0, 0, 'C');


            $this->SetFont('Arial', 'B', 14);
            $this->SetXY(75, 17);
            $this->Cell(120, 8, utf8_decode(mb_strtoupper(self::$tipoHistoriaNombre)), 0, 0, 'R');

            $this->SetFont('Arial', 'B', 9);
            $this->SetXY(65, 30);
            $this->Cell(40, 4, utf8_decode('PUNTO DE ATENCIÓN:'), 0, 0, 'l');
            $this->SetFont('Arial', '', 8);
            if (isset($this->consulta["cita_no_programada"]) && $this->consulta["cita_no_programada"] == 'Cita no programada') {
                $dato = utf8_decode($this->consulta["rep"]["nombre"]);
            } else {
                $dato = isset($this->consulta["agenda"]["consultorio"]["rep"]["nombre"]) ? utf8_decode($this->consulta["agenda"]["consultorio"]["rep"]["nombre"]) : '';
            }
            $this->MultiCell(90, 4, $dato, 0, 'L');

            $this->SetXY(65, 34);
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(40, 4, utf8_decode('CONSULTA REALIZADA:'), 0, 0, 'l');
            $this->SetFont('Arial', '', 8);
            if (isset($this->consulta["cita_no_programada"]) && $this->consulta["cita_no_programada"] == 1) {
                $especialidad = utf8_decode($this->consulta["cita"]["nombre"]);
            } else {
                $especialidad = isset($this->consulta["agenda"]["cita"]["nombre"]) ? utf8_decode($this->consulta["agenda"]["cita"]["nombre"]) : '';
            }
            $this->MultiCell(90, 4, $especialidad, 0, 'L');

            $this->SetXY(65, 38);
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(40, 4, utf8_decode('FECHA DE CONSULTA:'), 0, 0, 'l');
            $this->SetFont('Arial', '', 8);
            $fechaConsulta = isset($this->consulta["hora_inicio_atendio_consulta"]) && !empty($this->consulta["hora_inicio_atendio_consulta"])
                ? $this->consulta["hora_inicio_atendio_consulta"]
                : $this->consulta["fecha_hora_inicio"];
            $this->MultiCell(46, 4, utf8_decode($fechaConsulta), 0, 'L');

            $this->detallesUsuario();
        }
    }

    private function calcularEdad($fechaNacimiento, $fechaConsulta)
    {
        $fechaNacimiento = new DateTime($fechaNacimiento);
        $fechaConsulta = new DateTime($fechaConsulta);
        $diferencia = $fechaNacimiento->diff($fechaConsulta);

        $totalMeses = ($diferencia->y * 12) + $diferencia->m;

        if ($totalMeses === 0) {
            // Si la edad es menor a un mes
            return $diferencia->d . ' Días';
        } elseif ($totalMeses < 24) {
            // Entre 1 mes y menos de 24 meses
            return $totalMeses . ' Meses';
        } else {
            // 2 años o más
            return $diferencia->y . ' Años';
        }
    }


    private function detallesUsuario()
    {
        $this->SetXY(12, 53);
        $this->SetFont('Arial', 'B', 9);
        $this->SetDrawColor(0, 0, 0);
        $this->SetFillColor(214, 214, 214);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(186, 4, utf8_decode('DATOS DEL USUARIO'), 1, 0, 'C', 1);
        $this->SetTextColor(0, 0, 0);
        $this->SetDrawColor(0, 0, 0);
        $this->Ln();

        $this->SetX(12);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('NOMBRE COMPLETO'), 1, 0, 'l');
        $this->SetFont('Arial', '', 6);
        $this->Cell(46.5, 4, utf8_decode(isset($this->consulta["afiliado"]["nombre_completo"]) && $this->consulta["afiliado"]["nombre_completo"] ? $this->consulta["afiliado"]["nombre_completo"] : 'No Reporta'), 1, 0, 'l');
        $this->SetX(105);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('TIPO DE IDENTIFICACIÓN'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(isset($this->consulta["afiliado"]["tipoDocumento"]["nombre"]) && $this->consulta["afiliado"]["tipoDocumento"]["nombre"] ? $this->consulta["afiliado"]["tipoDocumento"]["nombre"] : 'No Reporta'), 1, 0, 'l');
        $this->Ln();

        $edad = $this->calcularEdad($this->consulta["afiliado"]["fecha_nacimiento"], $this->consulta["fecha_hora_inicio"]);

        $this->SetX(12);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('FECHA DE NACIMIENTO'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(isset($this->consulta["afiliado"]["fecha_nacimiento"]) && $this->consulta["afiliado"]["fecha_nacimiento"] ? $this->consulta["afiliado"]["fecha_nacimiento"] : 'No Reporta'), 1, 0, 'l');
        $this->SetX(105);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('IDENTIFICACIÓN'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(isset($this->consulta["afiliado"]["numero_documento"]) && $this->consulta["afiliado"]["numero_documento"] ? $this->consulta["afiliado"]["numero_documento"] : 'No Reporta'), 1, 0, 'l');

        $this->Ln();

        $this->SetX(12);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('EDAD'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode($edad ?: 'No Reporta'), 1, 0, 'l');
        $this->SetX(105);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('SEXO'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(isset($this->consulta["afiliado"]["sexo"]) && $this->consulta["afiliado"]["sexo"] ? ($this->consulta["afiliado"]["sexo"] === 'M' ? 'Masculino' : 'Femenino') : 'No Reporta'), 1, 0, 'l');

        $this->Ln();
        $this->SetX(12);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('OCUPACIÓN'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(139.5, 4, utf8_decode(isset($this->consulta["afiliado"]["ocupacion"]) && $this->consulta["afiliado"]["ocupacion"] ? $this->consulta["afiliado"]["ocupacion"] : 'No Reporta'), 1, 0, 'l');
        $this->Ln();


        $this->SetX(12);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('DIRECCIÓN'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(139.5, 4, utf8_decode(isset($this->consulta["afiliado"]["direccion_residencia_cargue"]) && $this->consulta["afiliado"]["direccion_residencia_cargue"] ? $this->consulta["afiliado"]["direccion_residencia_cargue"] : 'No Reporta'), 1, 0, 'l');
        $this->Ln();
        $this->SetX(12);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('ASEGURADORA'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(139.5, 4, utf8_decode(isset($this->consulta["afiliado"]["entidad"]["nombre"]) && $this->consulta["afiliado"]["entidad"]["nombre"] ? $this->consulta["afiliado"]["entidad"]["nombre"] : 'No Reporta'), 1, 'L');
        $this->SetX(12);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('TELÉFONO DEL DOMICILIO'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode((isset($this->consulta["afiliado"]["telefono"]) && $this->consulta["afiliado"]["telefono"] ? $this->consulta["afiliado"]["telefono"] : 'No Reporta') . '-' . (isset($this->consulta["afiliado"]["celular1"]) && $this->consulta["afiliado"]["celular1"] ? $this->consulta["afiliado"]["celular1"] : 'No Reporta')), 1, 0, 'l');
        $this->SetX(105);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('LUGAR DE RESIDENCIA'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(isset($this->consulta["afiliado"]["municipio_afiliacion"]["nombre"]) && $this->consulta["afiliado"]["municipio_afiliacion"]["nombre"] ? $this->consulta["afiliado"]["municipio_afiliacion"]["nombre"] : 'No Reporta'), 1, 0, 'l');

        $this->Ln();
        $this->SetX(12);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('NOMBRE DEL RESPONSABLE'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(isset($this->consulta["afiliado"]["nombre_responsable"]) && $this->consulta["afiliado"]["nombre_responsable"] ? $this->consulta["afiliado"]["nombre_responsable"] : 'No Reporta'), 1, 0, 'l');


        $this->SetX(105);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('TELEFONO RESPONSABLE'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(isset($this->consulta["afiliado"]["telefono_responsable"]) && $this->consulta["afiliado"]["telefono_responsable"] ? $this->consulta["afiliado"]["telefono_responsable"] : 'No Reporta'), 1, 0, 'l');
        $this->Ln();

        $this->SetX(12);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('PARENTESO RESPONSABLE'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(isset($this->consulta["afiliado"]["parentesco_responsable"]) && $this->consulta["afiliado"]["parentesco_responsable"] ? $this->consulta["afiliado"]["parentesco_responsable"] : 'No Reporta'), 1, 0, 'l');

        $this->SetX(105);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('TIPO DE VINCULACIÓN'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(isset($this->consulta["afiliado"]["tipo_afiliado"]["nombre"]) && $this->consulta["afiliado"]["tipo_afiliado"]["nombre"] ? $this->consulta["afiliado"]["tipo_afiliado"]["nombre"] : 'No Reporta'), 1, 0, 'l');
        $this->Ln();
        $this->SetX(12);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('N° ATENCIÓN'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode($this->consulta["id"]), 1, 0, 'l');

        $this->SetX(105);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('ESTADO CIVIL'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(isset($this->consulta["afiliado"]["estado_civil"]) && $this->consulta["afiliado"]["estado_civil"] ? $this->consulta["afiliado"]["estado_civil"] : 'No Reporta'), 1, 0, 'l');
        $this->Ln();
        $this->SetX(12);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('ETNIA'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(isset($this->consulta["afiliado"]["etnia"]) && $this->consulta["afiliado"]["etnia"] ? $this->consulta["afiliado"]["etnia"] : 'No Reporta'), 1, 0, 'l');

        $this->SetX(105);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('ZONA DE VIVIENDA'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(isset($this->consulta["afiliado"]["zona_vivienda"]) && $this->consulta["afiliado"]["zona_vivienda"] ? $this->consulta["afiliado"]["zona_vivienda"] : 'No Reporta'), 1, 0, 'l');
        $this->Ln();

        $this->SetX(12);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('NIVEL EDUCATIVO'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(isset($this->consulta["afiliado"]["nivel_educativo"]) && $this->consulta["afiliado"]["nivel_educativo"] ? $this->consulta["afiliado"]["nivel_educativo"] : 'No Reporta'), 1, 0, 'l');


        $this->SetX(105);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('DISCAPACIDAD'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(isset($this->consulta["afiliado"]["discapacidad"]) && $this->consulta["afiliado"]["discapacidad"] ? $this->consulta["afiliado"]["discapacidad"] : 'No Reporta'), 1, 0, 'l');
        $this->Ln();
        $this->SetX(12);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('NOMBRE DEL ACOMPAÑANTE'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(isset($this->consulta["afiliado"]["nombre_acompanante"]) && $this->consulta["afiliado"]["nombre_acompanante"] ? $this->consulta["afiliado"]["nombre_acompanante"] : 'No Reporta'), 1, 0, 'l');
        $this->SetX(105);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('TELÉFONO DEL ACOMPAÑANTE'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(isset($this->consulta["afiliado"]["telefono_acompanante"]) && $this->consulta["afiliado"]["telefono_acompanante"] ? $this->consulta["afiliado"]["telefono_acompanante"] : 'No Reporta'), 1, 0, 'l');
        $this->Ln();

        $y = $this->GetY();
    }

    private function body()
    {
        foreach (self::$tipoHistoria->componentesHistoriaClinica as $componente) {
            $nombreClase = $componente->ruta_pdf;

            $sexoAfiliado = $this->consulta->afiliado->sexo ?? null;
            $edadAfiliado = $this->consulta->afiliado->edad_cumplida ?? null;

            // Validaciones de sexo
            $sexoComponente = $componente->sexo ?? null;
            $sexoValido = !$sexoComponente || $sexoComponente === 'A' || $sexoComponente === $sexoAfiliado;

            // Validaciones de edad
            $edadInicial = $componente->edad_inicial;
            $edadFinal = $componente->edad_final;

            $edadValida = (
                (is_null($edadInicial) && is_null($edadFinal)) ||
                ($edadAfiliado >= $edadInicial && $edadAfiliado <= $edadFinal)
            );

            // Si no cumple condiciones de visibilidad, omitir el componente
            if (!$sexoValido || !$edadValida) {
                continue;
            }

            $clasePDF = "App\\Formats\\ComponentesHistoriaClinica\\" . $nombreClase;

            if (class_exists($clasePDF)) {
                $instancia = new $clasePDF();
                if (method_exists($instancia, 'bodyComponente')) {
                    $instancia->bodyComponente($this, $this->consulta);
                }
            } else {
                Log::warning("No se encontró la clase PDF para: $clasePDF");
            }
        }

        $this->notaAclaratorias();
        $this->firma();
        $this->ordenamiento();
    }

    // public function getConsulta()
    // {
    //     return $this->consulta;
    // }


    function Close()
    {
        $this->isLastPage = true;
        parent::Close();
    }

    function notaAclaratorias()
    {
        $this->Ln();
        $notaAclaratoria = isset($this->consulta["HistoriaClinica"]["NotaAclaratoria"]) ? $this->consulta["HistoriaClinica"]["NotaAclaratoria"] : null;
        if ($notaAclaratoria && count($notaAclaratoria) > 0) {
            $this->Ln();
            $this->SetX(12);
            $this->SetFont('Arial', 'B', 9);
            $this->SetDrawColor(0, 0, 0);
            $this->SetFillColor(214, 214, 214);
            $this->SetTextColor(0, 0, 0);
            $this->Cell(186, 4, utf8_decode('NOTAS ACLARATORIAS'), 1, 0, 'C', 1);
            $this->Ln();

            foreach ($notaAclaratoria as $index => $nota) {
                $this->SetX(12);
                $this->SetFont('Arial', '', 9);
                $descripcion = !empty($nota->descripcion) ? $nota->descripcion : 'No refiere';
                $this->MultiCell(186, 4, utf8_decode('Nota ' . ($index + 1) . ': ' . $descripcion), 1, 'L', 0);

                $this->SetX(12);
                $nombreOperador = isset($nota->operador->operador->nombre) ? $nota->operador->operador->nombre : 'No refiere';
                $apellidoOperador = isset($nota->operador->operador->apellido) ? $nota->operador->operador->apellido : 'No refiere';
                $this->Cell(186, 4, utf8_decode('Realizado por: ' . $nombreOperador . ' ' . $apellidoOperador), 1, 'L');

                $this->SetX(12);
                $fechaHora = !empty($nota->created_at) ? $nota->created_at : 'No refiere';
                $this->Cell(186, 4, utf8_decode('Fecha y Hora: ' . $fechaHora), 1, 'L');

                $this->Ln();
            }
        }
    }

    function ordenamiento()
    {
        // Verificar si hay órdenes en la consulta
        if ($this->consulta['ordenes']->isNotEmpty()) {
            // Iterar sobre las órdenes
            foreach ($this->consulta['ordenes'] as $orden) {
                // Mostrar el ID de la orden
                $this->Ln();
                $this->SetX(12);
                $this->SetFont('Arial', 'B', 10);
                $this->Cell(195, 6, utf8_decode('Prescripción N°' . $orden->id), 0, 0, 'l');
                $this->Ln();
                $this->SetX(12);
                $this->SetFont('Arial', 'B', 10);
                $this->SetDrawColor(0, 0, 0);
                $this->SetFillColor(214, 214, 214);
                $this->SetTextColor(0, 0, 0);
                $this->Cell(195, 5, utf8_decode('Medicamento'), 0, 0, 'l', 1);
                $this->SetTextColor(0, 0, 0);
                $this->SetDrawColor(0, 0, 0);
                $this->Ln();
                // Iterar sobre los medicamentos de cada orden
                foreach ($orden->articulos as $articulo) {
                    if ($articulo->estado->id == 1 || $articulo->estado->id == 4) {
                        $codesumiNombre = $articulo->codesumi ? $articulo->codesumi->nombre : 'No asociado';
                        $codesumiCodigo = $articulo->codesumi ? $articulo->codesumi->codigo : 'No asociado';
                        $codesumiCantidad = $articulo->dosificacion_medico ? $articulo->codesumi->dosificacion_medico : '';
                        $this->SetX(12);
                        $this->SetFont('Arial', '', 8);
                        // Mostrar el estado, el código y el nombre del codesumi
                        $this->Cell(62, 4, utf8_decode(' * Código: ' . $codesumiCodigo . ' | ' . $codesumiNombre . ' - Cantidad: ' . $articulo->cantidad_medico), 0, 0, 'L');
                        $this->Ln();
                        $this->SetX(12);
                        $this->Cell(62, 4, utf8_decode('Dosis: ' . $codesumiCantidad), 0, 'L');
                        $this->Ln();
                    }
                }
                if (!count($orden->articulos)) {
                    $this->SetX(12);
                    $this->SetFont('Arial', '', 8);
                    $this->Cell(62, 4, utf8_decode('Esta prescripcion no posee medicamentos'), 0, 0, 'L');
                    $this->Ln();
                }
                $this->SetX(12);
                $this->SetFont('Arial', 'B', 10);
                $this->SetDrawColor(0, 0, 0);
                $this->SetFillColor(214, 214, 214);
                $this->SetTextColor(0, 0, 0);
                $this->Cell(195, 5, utf8_decode('Servicio'), 0, 0, 'l', 1);
                $this->SetTextColor(0, 0, 0);
                $this->SetDrawColor(0, 0, 0);
                $this->Ln();

                // Iterar sobre los procedimientos de cada orden
                foreach ($orden->procedimientos as $procedimiento) {
                    if ($procedimiento->estado->id == 1 || $procedimiento->estado->id == 4) {
                        $cupNombre = $procedimiento->cup ? $procedimiento->cup->nombre : 'No asociado';
                        $cupCodigo = $procedimiento->cup ? $procedimiento->cup->codigo : 'No asociado';
                        $this->SetX(12);
                        $this->SetFont('Arial', '', 8);
                        $texto = '* Servicio: ' . $cupCodigo . ' | ' . $cupNombre . ' - Cantidad: ' . $procedimiento->cantidad;
                        $this->MultiCell(200, 4, utf8_decode($texto), 0, 'L');
                        $this->SetX(12);
                        $this->Line(12, $this->GetY(), 200, $this->GetY());
                    }
                }
                if (!count($orden->procedimientos)) {
                    $this->SetX(12);
                    $this->SetFont('Arial', '', 8);
                    $this->Cell(62, 4, utf8_decode('Esta prescripcion no posee servicios'), 0, 0, 'L');
                    $this->Ln();
                }
            }
        }
    }

    function firma()
    {
        $this->Ln();
        $this->Cell(56, 11, "", 0, 0, 'L');
        $this->SetFont('Arial', '', 8);
        $this->SetX(12);
        $this->Cell(60, 4, utf8_decode('ATENDIDO POR: ' . (isset($this->consulta["medicoOrdena"]["operador"]["nombre_completo"]) ? $this->consulta["medicoOrdena"]["operador"]["nombre_completo"] : 'No disponible')), 0, 0, 'L');
        $this->Ln();
        $this->Cell(60, 4, utf8_decode('Especialidad: ' . (isset($this->consulta["especialidad"]["nombre"]) ? $this->consulta["especialidad"]["nombre"] : 'No disponible')), 0, 0, 'L');
        $this->Ln();
        $this->SetX(12);
        $this->Cell(32, 4, utf8_decode('REGISTRO: ' . (isset($this->consulta["medicoOrdena"]["operador"]["registro_medico"]) ? $this->consulta["medicoOrdena"]["operador"]["registro_medico"] : $this->consulta["medicoOrdena"]["operador"]["documento"])), 0, 0, 'L');
        $this->Cell(56, 11, "", 0, 0, 'L');
        $this->SetFont('Arial', '', 8);
        $this->SetX(125);

        $yDinamica = $this->GetY();

        if (isset($this->consulta["medicoOrdena"]["firma"])) {
            if (file_exists(storage_path(substr($this->consulta["medicoOrdena"]["firma"], 9)))) {
                $this->Image(storage_path(substr($this->consulta["medicoOrdena"]["firma"], 9)), 125, $yDinamica, 56, 11);
            }
        }
    }

    function Footer()
    {
        // Posición a 1.5 cm del final
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . ' de {nb}', 0, 0, 'C');
    }

    function Circle($x, $y, $r, $style = 'D')
    {
        $this->Ellipse($x, $y, $r, $r, $style);
    }

    function Ellipse($x, $y, $rx, $ry, $style = 'D')
    {
        if ($style == 'F')
            $op = 'f';
        elseif ($style == 'FD' or $style == 'DF')
            $op = 'B';
        else
            $op = 'S';

        $lx = 4 / 3 * (M_SQRT2 - 1) * $rx;
        $ly = 4 / 3 * (M_SQRT2 - 1) * $ry;

        // Arrancamos el "path"
        $this->_Arc($x + $rx, $y,      $x + $rx, $y - $ly, $x + $lx, $y - $ry, $x, $y - $ry);
        $this->_Arc($x,     $y - $ry,  $x - $lx, $y - $ry, $x - $rx, $y - $ly, $x - $rx, $y);
        $this->_Arc($x - $rx, $y,      $x - $rx, $y + $ly, $x - $lx, $y + $ry, $x, $y + $ry);
        $this->_Arc($x,     $y + $ry,  $x + $lx, $y + $ry, $x + $rx, $y + $ly, $x + $rx, $y);
        $this->_out($op);
    }

    function _Arc($x1, $y1, $x2, $y2, $x3, $y3, $x4, $y4)
    {
        $h = $this->h; // Alto total del documento
        $this->_out(sprintf(
            '%.2F %.2F %.2F %.2F %.2F %.2F c',
            $x1 * $this->k,
            ($h - $y1) * $this->k,
            $x2 * $this->k,
            ($h - $y2) * $this->k,
            $x3 * $this->k,
            ($h - $y3) * $this->k,
            $x4 * $this->k,
            ($h - $y4) * $this->k
        ));
    }
}
