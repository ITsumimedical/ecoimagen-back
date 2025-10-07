<?php

namespace App\Formats;

use DateTime;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Carbon;
use App\Traits\PdfTrait;
class EvolucionCertificado extends FPDF
{
    use PdfTrait;

    protected static $consulta;
    protected static $evolucion;
    protected static $entidad;

    public function generar($evolucionCertificado)
    {
        self::$consulta = $evolucionCertificado->consulta;
        self::$evolucion = $evolucionCertificado->evolucion;
        self::$entidad = $evolucionCertificado->consulta->afiliado->entidad;

        $this->generarPDF('I');
    }


    public function Header()
    {
        $Y = 40;
        $this->SetFont('Arial', 'B', 9);
            $logo = public_path() . "/images/logoMedicinaIntegral.jpg";
            $this->Image($logo, 16, 9, 35, 25);
            $this->SetFont('Arial', '', 7);
            $this->SetXY(138, 15);
            $this->Cell(60, 3, utf8_decode('Código del prestador: 230010092401'), 0, 0, 'C');
            $this->SetXY(138, 18);
            $this->Cell(60, 3, utf8_decode('NIT: 800250634-3 '), 0, 0, 'C');
            $this->SetXY(138, 21);
            $this->Cell(60, 3, utf8_decode('Dirección: CALLE 44 # 14 - 282 MONTERIA'), 0, 0, 'C');
            $this->SetXY(138, 24);
            $this->Cell(60, 3, utf8_decode('Teléfono: Call Center 6046041571'), 0, 0, 'C');
            $this->SetXY(138, 27);
            // $this->Cell(60, 3, utf8_decode('Web: www.medicinaintegralsa.com'), 0, 0, 'C');
            // $this->SetXY(8, $Y + 8);
            $this->Cell(60, 3, utf8_decode('Email: info@medicinaintegralsa.com'), 0, 0, 'C');
            $this->SetXY(18, 17);
            $this->SetFont('Arial', 'B', 25);
            $this->Cell(155, 4, utf8_decode('Evolución Médica'), 0, 0, 'C');
            $this->SetXY(66, 23);
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(38, 4, utf8_decode('Fecha de Impresión:'), 0, 0, 'l');
            $this->SetFont('Arial', '', 8);
            $this->Cell(15, 4, utf8_decode(Carbon::now()), 0, 0, 'C');



    }

    public function body() {

        $this->SetXY(12, 40);
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
        $this->Cell(46.5, 4, utf8_decode(isset(self::$consulta->afiliado["nombre_completo"]) && self::$consulta->afiliado["nombre_completo"] ? self::$consulta->afiliado["nombre_completo"] : 'No Reporta'), 1, 0, 'l');
        $this->SetX(105);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('TIPO DE IDENTIFICACIÓN'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(isset(self::$consulta->afiliado->tipoDocumento->sigla) && self::$consulta->afiliado->tipoDocumento->sigla ? self::$consulta->afiliado->tipoDocumento->sigla : 'No Reporta'), 1, 0, 'l');
        $this->Ln();

        $edad = $this->calcularEdad(self::$consulta->afiliado["fecha_nacimiento"], self::$consulta["fecha_hora_inicio"]);
        $this->SetX(12);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('FECHA DE NACIMIENTO'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(isset(self::$consulta->afiliado["fecha_nacimiento"]) && self::$consulta->afiliado["fecha_nacimiento"] ? self::$consulta->afiliado["fecha_nacimiento"] : 'No Reporta'), 1, 0, 'l');
        $this->SetX(105);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('IDENTIFICACIÓN'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(isset(self::$consulta->afiliado["numero_documento"]) && self::$consulta->afiliado["numero_documento"] ? self::$consulta->afiliado["numero_documento"] : 'No Reporta'), 1, 0, 'l');

        $this->Ln();

        $this->SetX(12);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('EDAD'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode($edad ? $edad . ' Años' : 'No Reporta'), 1, 0, 'l');
        $this->SetX(105);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('SEXO'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(isset(self::$consulta->afiliado["sexo"]) && self::$consulta->afiliado["sexo"] ? (self::$consulta->afiliado["sexo"] === 'M' ? 'Masculino' : 'Femenino') : 'No Reporta'), 1, 0, 'l');

        $this->Ln();
        $this->SetX(12);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('OCUPACIÓN'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(139.5, 4, utf8_decode(isset(self::$consulta->afiliado["ocupacion"]) && self::$consulta->afiliado["ocupacion"] ? self::$consulta->afiliado["ocupacion"] : 'No Reporta'), 1, 0, 'l');
        $this->Ln();


        $this->SetX(12);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('DIRECCIÓN'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(139.5, 4, utf8_decode(isset(self::$consulta->afiliado["direccion_residencia_cargue"]) && self::$consulta->afiliado["direccion_residencia_cargue"] ? self::$consulta->afiliado["direccion_residencia_cargue"] : 'No Reporta'), 1, 0, 'l');
        $this->Ln();
        $this->SetX(12);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('ASEGURADORA'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(139.5, 4, utf8_decode(isset(self::$entidad["nombre"]) && self::$entidad["nombre"] ? self::$entidad["nombre"] : 'No Reporta'), 1, 'L');
        $this->SetX(12);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('TELÉFONO DEL DOMICILIO'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode((isset(self::$consulta->afiliado["telefono"]) && self::$consulta->afiliado["telefono"] ? self::$consulta->afiliado["telefono"] : 'No Reporta') . '-' . (isset(self::$consulta->afiliado["celular1"]) && self::$consulta->afiliado["celular1"] ? self::$consulta->afiliado["celular1"] : 'No Reporta')), 1, 0, 'l');
        $this->SetX(105);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('LUGAR DE RESIDENCIA'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(isset(self::$consulta->afiliado->municipio_afiliacion["nombre"]) && self::$consulta->afiliado->municipio_afiliacion["nombre"] ? self::$consulta->afiliado->municipio_afiliacion["nombre"] : 'No Reporta'), 1, 0, 'l');

        $this->Ln();
        $this->SetX(12);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('NOMBRE DEL RESPONSABLE'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(isset(self::$consulta->afiliado["nombre_responsable"]) && self::$consulta->afiliado["nombre_responsable"] ? self::$consulta->afiliado["nombre_responsable"] : 'No Reporta'), 1, 0, 'l');


        $this->SetX(105);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('TELEFONO RESPONSABLE'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(isset(self::$consulta->afiliado["telefono_responsable"]) && self::$consulta->afiliado["telefono_responsable"] ? self::$consulta->afiliado["telefono_responsable"] : 'No Reporta'), 1, 0, 'l');
        $this->Ln();

        $this->SetX(12);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('PARENTESO RESPONSABLE'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(isset(self::$consulta->afiliado["parentesco_responsable"]) && self::$consulta->afiliado["parentesco_responsable"] ? self::$consulta->afiliado["parentesco_responsable"] : 'No Reporta'), 1, 0, 'l');

        $this->SetX(105);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('TIPO DE VINCULACIÓN'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(isset(self::$consulta->afiliado->tipoDocumentoAfiliado["nombre"]) && self::$consulta->afiliado->tipoDocumentoAfiliado["nombre"] ? self::$consulta->afiliado->tipoDocumentoAfiliado["nombre"] : 'No Reporta'), 1, 0, 'l');
        $this->Ln();
        $this->SetX(12);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('Fecha ingreso'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);

        $this->Cell(46.5, 4, utf8_decode(Carbon::parse(self::$consulta->admision->created_at)->format('Y-m-d')   ), 1, 0, 'l');
        // $this->Ln();
        // $this->SetX(12);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('Hora ingreso'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(Carbon::parse(self::$consulta->admision->created_at)->format('H:i:s')), 1, 0, 'l');
        $this->Ln();
        $this->SetX(12);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('Fecha y hora de atención'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(self::$consulta["id"]), 1, 0, 'l');
        $this->SetX(105);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('N° ATENCIÓN'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(self::$consulta["id"]), 1, 0, 'l');
        $this->Ln();
        $this->SetX(12);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('ESTADO CIVIL'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(isset(self::$consulta->afiliado["estado_civil"]) && self::$consulta->afiliado["estado_civil"] ? self::$consulta->afiliado["estado_civil"] : 'No Reporta'), 1, 0, 'l');
        // $this->Ln();
        $this->SetX(105);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('ETNIA'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(isset(self::$consulta->afiliado["etnia"]) && self::$consulta->afiliado["etnia"] ? self::$consulta->afiliado["etnia"] : 'No Reporta'), 1, 0, 'l');

        $this->Ln();
        $this->SetX(12);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('NIVEL EDUCATIVO'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(isset(self::$consulta->afiliado["nivel_educativo"]) && self::$consulta->afiliado["nivel_educativo"] ? self::$consulta->afiliado["nivel_educativo"] : 'No Reporta'), 1, 0, 'l');
        $this->SetX(105);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('DISCAPACIDAD'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(isset(self::$consulta->afiliado["discapacidad"]) && self::$consulta->afiliado["discapacidad"] ? self::$consulta->afiliado["discapacidad"] : 'No Reporta'), 1, 0, 'l');
        $this->Ln();
        $this->SetX(12);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('NOMBRE DEL ACOMPAÑANTE'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(isset(self::$consulta->afiliado["nombre_acompanante"]) && self::$consulta->afiliado["nombre_acompanante"] ? self::$consulta->afiliado["nombre_acompanante"] : 'No Reporta'), 1, 0, 'l');
        $this->SetX(105);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('TELÉFONO DEL ACOMPAÑANTE'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(isset(self::$consulta->afiliado["telefono_acompanante"]) && self::$consulta->afiliado["telefono_acompanante"] ? self::$consulta->afiliado["telefono_acompanante"] : 'No Reporta'), 1, 0, 'l');
        $this->Ln();

        foreach (self::$evolucion as $evoluciones) {
            $this->Ln();
            $this->Ln();
            $y0 = $this->GetY();
            if($y0 >250){
              $this->AddPage();
              $y0 = 40;
            }
            $this->SetXY(12,$y0);
            $this->SetFont('Arial', 'B', 9);
            $this->SetDrawColor(0, 0, 0);
            $this->SetFillColor(214, 214, 214);
            $this->SetTextColor(0, 0, 0);
            $this->Cell(186, 4, utf8_decode('EVOLUCIÓN'), 1, 0, 'C', 1);
            $this->SetTextColor(0, 0, 0);
            $this->SetDrawColor(0, 0, 0);
            $this->Ln();
             $y0 = $this->GetY();
            if($y0 >255){
              $this->AddPage();
              $y0 = 40;
            }
            $this->SetXY(12,$y0);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(31, 4, utf8_decode('Evolución N°'), 1, 0, 'l');
            $this->SetFont('Arial', '', 8);
            $this->Cell(31, 4, utf8_decode($evoluciones['id']), 1, 0, 'l');
            // $this->Ln();
            $this->SetX(74);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(31, 4, utf8_decode('Fecha'), 1, 0, 'l');
            $this->SetFont('Arial', '', 8);
            $this->Cell(31, 4, utf8_decode(Carbon::parse($evoluciones["created_at"])->format('Y-m-d') ), 1, 0, 'l');
            $this->SetX(136);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(31, 4, utf8_decode('Hora'), 1, 0, 'l');
            $this->SetFont('Arial', '', 8);
            $this->Cell(31, 4, utf8_decode(Carbon::parse($evoluciones["created_at"])->format('H:i:s')), 1, 0, 'l');
            $this->Ln();
            $y0 = $this->GetY();
            if($y0 >255){
              $this->AddPage();
              $y0 = 40;
            }
            $this->SetXY(12,$y0);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(31, 4, utf8_decode('Medico'), 1, 0, 'l');
            $this->SetFont('Arial', '', 8);
            $this->Cell(62, 4, utf8_decode($evoluciones['createBy']['operador']['nombre_completo']), 1, 0, 'l');
            $this->SetX(105);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(31, 4, utf8_decode('Especialidad'), 1, 0, 'l');
            $this->SetFont('Arial', '', 8);
            $this->Cell(62, 4, utf8_decode($evoluciones['createBy']['especialidades'][0]['nombre']), 1, 0, 'l');
            $this->Ln();
            $y0 = $this->GetY();
            if($y0 >255){
              $this->AddPage();
              $y0 = 40;
            }
            $this->SetXY(12,$y0);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(11, 4, utf8_decode('Peso'), 1, 0, 'l');
            $this->SetFont('Arial', '', 8);
            $this->Cell(10, 4, utf8_decode($evoluciones['peso']), 1, 0, 'l');
            $this->SetX(33);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(28, 4, utf8_decode('Tensión arterial'), 1, 0, 'l');
            $this->SetFont('Arial', '', 8);
            $this->Cell(12, 4, utf8_decode($evoluciones['tension_arterial']), 1, 0, 'l');
            $this->SetX(73);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(34, 4, utf8_decode('Frecuencia respiratoria'), 1, 0, 'l');
            $this->SetFont('Arial', '', 8);
            $this->Cell(12, 4, utf8_decode($evoluciones['frecuencia_respiratoria']), 1, 0, 'l');
            $this->SetX(119);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(32, 4, utf8_decode('Frecuencia cardiaca'), 1, 0, 'l');
            $this->SetFont('Arial', '', 8);
            $this->Cell(12, 4, utf8_decode($evoluciones['frecuencia_cardiaca']), 1, 0, 'l');
            $this->SetX(163);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(22, 4, utf8_decode('Temperatura'), 1, 0, 'l');
            $this->SetFont('Arial', '', 8);
            $this->Cell(13, 4, utf8_decode($evoluciones['temperatura']), 1, 0, 'l');
            $this->Ln();
            $y0 = $this->GetY();
            if($y0 >255){
              $this->AddPage();
              $y0 = 40;
            }
            $this->SetXY(12,$y0);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(61, 4, utf8_decode('Unidad Funcional'), 1, 0, 'l');
            $this->SetFont('Arial', '', 8);
            $this->Cell(125, 4, utf8_decode('URGENCIAS'), 1, 0, 'l');
            $this->Ln();
            $y0 = $this->GetY();
            if($y0 >240){
              $this->AddPage();
              $y0 = 40;
            }
            $this->SetXY(12,$y0);
            $this->SetFont('Arial', 'B', 9);
            $this->SetDrawColor(0, 0, 0);
            $this->SetFillColor(214, 214, 214);
            $this->SetTextColor(0, 0, 0);
            $this->Cell(186, 4, utf8_decode('DIAGNÓSTICOS'), 1, 0, 'C', 1);
            $this->Ln();
            $y0 = $this->GetY();
            if($y0 >240){
              $this->AddPage();
              $y0 = 40;
            }
            $this->SetXY(12,$y0);
            $this->Cell(186, 4, utf8_decode('DIAGNÓSTICO PRINCIPAL'), 1, 0, 'C', 1);
            $this->Ln();
            $this->SetX(12);
            $this->SetTextColor(0, 0, 0);
            $this->SetDrawColor(0, 0, 0);
            $this->SetFont('Arial', '', 8);

        // Obtener el primer diagnóstico como principal
        $diagnosticoPrincipal = self::$consulta->cie10Afiliado->first();
        $codigoCie10 = isset($diagnosticoPrincipal->cie10->codigo_cie10) ? $diagnosticoPrincipal->cie10->codigo_cie10 : '';
        $descripcionDiagnostico = isset($diagnosticoPrincipal->cie10->nombre) ? $diagnosticoPrincipal->cie10->nombre : '';
        $tipoDiagnostico = isset($diagnosticoPrincipal->tipo_diagnostico) ? $diagnosticoPrincipal->tipo_diagnostico : '';

        $textoDXprincipal = "CODIGO CIE10: " . utf8_decode($codigoCie10) .
            ", DESCRIPCION DEL DIAGNOSTICO: " . utf8_decode($descripcionDiagnostico) .
            ", TIPO DEL DIAGNOSTICO: " . utf8_decode($tipoDiagnostico);

        $this->SetX(12);
        $this->MultiCell(186, 4, $textoDXprincipal, 1, "L", 0);
        // Filtrar diagnósticos secundarios
        $diagnosticosSecundarios = self::$consulta->cie10Afiliado->slice(1);
        if ($diagnosticosSecundarios->isNotEmpty()) {
            $this->SetX(12);
            $this->SetFont('Arial', 'B', 9);
            $this->SetDrawColor(0, 0, 0);
            $this->SetFillColor(214, 214, 214);
            $this->SetTextColor(0, 0, 0);
            $this->Cell(186, 4, utf8_decode('DIAGNÓSTICOS SECUNDARIOS'), 1, 0, 'C', 1);
            $this->Ln();
            $this->SetX(12);
            $this->SetTextColor(0, 0, 0);
            $this->SetDrawColor(0, 0, 0);
            $this->SetFont('Arial', '', 8);

            foreach ($diagnosticosSecundarios as $diagnostico) {
                $codigoCie10 = isset($diagnostico->cie10->codigo_cie10) ? $diagnostico->cie10->codigo_cie10 : '';
                $descripcion = isset($diagnostico->cie10->nombre) ? $diagnostico->cie10->nombre : '';
                $tipoDiagnostico = isset($diagnostico->tipo_diagnostico) ? $diagnostico->tipo_diagnostico : '';

                $textoDXSecundario = "CODIGO CIE10: " . utf8_decode($codigoCie10) .
                    ", DESCRIPCION DEL DIAGNOSTICO: " . utf8_decode($descripcion) .
                    ", TIPO DEL DIAGNOSTICO: " . utf8_decode($tipoDiagnostico);

                $this->SetX(12);
                $this->MultiCell(186, 4, $textoDXSecundario, 1, "L", 0);
            }
            $this->Ln();
         }
         $y0 = $this->GetY();
        if($y0 >240){
          $this->AddPage();
          $y0 = 40;
        }
        if ($y0 > 235 && round($this->GetStringWidth($evoluciones['subjetivo']), 2) > 1000) {
            $this->AddPage();
            $y0 = 40;
        }
         $this->SetFont('Arial', 'B', 8);
         $this->SetXY(12, $y0);
         $this->MultiCell(40,4,utf8_decode('Subjetivos'),0,'l',0);
         $y1 = $this->GetY();
         $this->SetXY(52, $y0);
         $this->SetFont('Arial', '', 8);
         $this->MultiCell(146,4,utf8_decode($evoluciones['subjetivo']),0,'l',0);
         $y2 = $this->GetY();
         $y = max($y1,$y2);
        // $this->Ln();
        #cuadrado
        $this->Line(12,$y0,198,$y0);
        $this->Line(12,$y,198,$y);
        $this->Line(12,$y0,12,$y);
        $this->Line(198,$y0,198,$y);
        #lineas verticales
        $this->Line(52,$y0,52,$y);

        // if($y > 250){
        //     $this->AddPage();
        //     $y0 = 10;
        // }

         #Descripcion fisica
         $y0 = $this->GetY();
        if($y0 >245){
          $this->AddPage();
          $y0 = 40;
        }
        if ($y0 > 235 && round($this->GetStringWidth($evoluciones['descripcion_fisica']), 2) > 1000) {
            $this->AddPage();
            $y0 = 40;
        }

         $this->SetFont('Arial', 'B', 8);
         $this->SetXY(12, $y0);
        $this->MultiCell(146,4,utf8_decode('Descripción fisica'),0,'l',0);
        //  $this->MultiCell(40,4,utf8_decode('Descripción Fisica'),0,'l',0);
         $y1 = $this->GetY();
         $this->SetXY(52, $y0);
         $this->SetFont('Arial', '', 8);
         $this->MultiCell(146,4,utf8_decode($evoluciones['descripcion_fisica']),0,'l',0);
         $y2 = $this->GetY();
         $y = max($y1,$y2);
        // $this->Ln();
        #cuadrado
        $this->Line(12,$y0,198,$y0);
        $this->Line(12,$y,198,$y);
        $this->Line(12,$y0,12,$y);
        $this->Line(198,$y0,198,$y);
        #lineas verticales
        $this->Line(52,$y0,52,$y);
        // if($y > 250){
        //     $this->AddPage();
        //     $y0 = 10;
        // }

         #Paraclinicos
         $y0 = $this->GetY();
         if($y0 >240){
           $this->AddPage();
           $y0 = 40;
         }
         if ($y0 > 235 && round($this->GetStringWidth($evoluciones['paraclinicos']), 2) > 1000) {
            $this->AddPage();
            $y0 = 40;
        }
         $this->SetFont('Arial', 'B', 8);
         $this->SetXY(12, $y0);
         $this->MultiCell(40,4,utf8_decode('Paraclínicos'),0,'l',0);
         $y1 = $this->GetY();
         $this->SetXY(52, $y0);
         $this->SetFont('Arial', '', 8);
         $this->MultiCell(146,4,utf8_decode($evoluciones['paraclinicos']),0,'l',0);
         $y2 = $this->GetY();
         $y = max($y1,$y2);
        // $this->Ln();
        #cuadrado
        $this->Line(12,$y0,198,$y0);
        $this->Line(12,$y,198,$y);
        $this->Line(12,$y0,12,$y);
        $this->Line(198,$y0,198,$y);
        #lineas verticales
        $this->Line(52,$y0,52,$y);
        // if($y > 250){
        //     $this->AddPage();
        //     $y0 = 10;
        // }

        // #Procedimientos
        $y0 = $this->GetY();
        if($y0 >240){
          $this->AddPage();
          $y0 = 40;
        }
        if ($y0 > 235 && round($this->GetStringWidth($evoluciones['procedimiento']), 2) > 1000) {
            $this->AddPage();
            $y0 = 40;
        }
        $this->SetFont('Arial', 'B', 8);
        $this->SetXY(12, $y0);
        $this->MultiCell(40,4,utf8_decode('Procedimientos'),0,'l',0);
        $y1 = $this->GetY();
        $this->SetXY(52, $y0);
        $this->SetFont('Arial', '', 8);
        $this->MultiCell(146,4,utf8_decode($evoluciones['procedimiento']),0,'l',0);
        $y2 = $this->GetY();
        $y = max($y1,$y2);
       // $this->Ln();
       #cuadrado
       $this->Line(12,$y0,198,$y0);
       $this->Line(12,$y,198,$y);
       $this->Line(12,$y0,12,$y);
       $this->Line(198,$y0,198,$y);
       #lineas verticales
       $this->Line(52,$y0,52,$y);
        #Analisis
        $y0 = $this->GetY();
        if($y0 >260){
            $this->AddPage();
            $y0 = 40;
          }
          if ($y0 > 235 && round($this->GetStringWidth($evoluciones['analisis']), 2) > 1000) {
            $this->AddPage();
            $y0 = 40;
        }
        $this->SetFont('Arial', 'B', 8);
        $this->SetXY(12, $y0);
        $this->MultiCell(40,4,utf8_decode('Analisis'),0,'l',0);
        $y1 = $this->GetY();
        $this->SetXY(52, $y0);
        $this->SetFont('Arial', '', 8);
        $this->MultiCell(146,4,utf8_decode($evoluciones['analisis']),0,'l',0);
        $y2 = $this->GetY();
        $y = max($y1,$y2);
    //    // $this->Ln();
    //     #cuadrado
        $this->Line(12,$y0,198,$y0);
        $this->Line(12,$y,198,$y);
        $this->Line(12,$y0,12,$y);
        $this->Line(198,$y0,198,$y);
        #lineas verticales
        $this->Line(52,$y0,52,$y);

         #Analisis
         $y0 = $this->GetY();
         if($y0 >260){
             $this->AddPage();
             $y0 = 40;
           }
           if ($y0 > 235 && round($this->GetStringWidth($evoluciones['tratamiento']), 2) > 1000) {
             $this->AddPage();
             $y0 = 40;
         }
         $this->SetFont('Arial', 'B', 8);
         $this->SetXY(12, $y0);
         $this->MultiCell(40,4,utf8_decode('Tratamiento'),0,'l',0);
         $y1 = $this->GetY();
         $this->SetXY(52, $y0);
         $this->SetFont('Arial', '', 8);
         $this->MultiCell(146,4,utf8_decode($evoluciones['tratamiento']),0,'l',0);
         $y2 = $this->GetY();
         $y = max($y1,$y2);
         #cuadrado
         $this->Line(12,$y0,198,$y0);
         $this->Line(12,$y,198,$y);
         $this->Line(12,$y0,12,$y);
         $this->Line(198,$y0,198,$y);
         #lineas verticales
         $this->Line(52,$y0,52,$y);

         $y0 = $this->GetY();
         if($y0 >260){
             $this->AddPage();
             $y0 = 40;
           }

        $this->SetFont('Arial', 'B', 8);
         $this->SetXY(12, $y0);
         $this->MultiCell(40,4,utf8_decode('Servicios/UF'),1,'l',0);
         $y1 = $this->GetY();
         $this->SetXY(52, $y0);
         $this->SetFont('Arial', '', 8);
         $this->MultiCell(146,4,utf8_decode('Urgencias'),1,'l',0);

         $this->Ln();
      $y0 = $this->GetY();
      if($y0 >250){
        $this->AddPage();
        $y0 = 40;
      }
      $this->SetXY(12,$y0);
      $this->SetFont('Arial', 'B', 9);
      $this->SetDrawColor(0, 0, 0);
      $this->SetFillColor(214, 214, 214);
      $this->SetTextColor(0, 0, 0);
      $this->Cell(186, 4, utf8_decode('Nota de cargo'), 1, 0, 'C', 1);
      $this->SetTextColor(0, 0, 0);
      $this->SetDrawColor(0, 0, 0);
      $this->Ln();

      $y0 = $this->GetY();
      if($y0 >250){
        $this->AddPage();
        $y0 = 40;
      }
      $this->SetXY(12,$y0);
      $this->SetFont('Arial', 'B', 8);
      $this->Cell(40, 4, utf8_decode('Codigo'), 1, 0, 'C');
      $this->Cell(110, 4, utf8_decode('Nombre'), 1, 0, 'C');
      $this->Cell(36, 4, utf8_decode('Cantidad'), 1, 0, 'C');
      $this->Ln();

      $y0 = $this->GetY();
      if($y0 >260){
        $this->AddPage();
        $y0 = 40;
      }
      $this->SetXY(12,$y0);
      $this->SetFont('Arial', '', 8);
      $this->Cell(40, 4, utf8_decode('890701'), 1, 0, 'C');
      $this->Cell(110, 4, utf8_decode('CONSULTA DE URGENCIAS POR MEDICINA GENERAL'), 1, 0, 'C');
      $this->Cell(36, 4, utf8_decode('1'), 1, 0, 'C');

        $this->Ln();
        $this->Ln();
        $this->SetFont('Arial', '', 8);
        $y0 = $this->GetY();
        if($y0 >255){
          $this->AddPage();
          $y0 = 40;
        }
        $this->SetXY(12,$y0);
        $this->Cell(60, 4, utf8_decode('ATENDIDO POR: ' .$evoluciones['createBy']['operador']['nombre_completo']), 0, 0, 'L');
        $this->Ln();
        $y0 = $this->GetY();
        if($y0 >260){
          $this->AddPage();
          $y0 = 40;
        }
        $this->SetXY(12,$y0);
        $this->Cell(60, 4, utf8_decode('Especialidad: ' .$evoluciones['createBy']['especialidades'][0]['nombre']), 0, 0, 'L');
        $this->Ln();
        $y0 = $this->GetY();
        if($y0 >260){
          $this->AddPage();
          $y0 = 40;
        }
        $this->SetXY(12,$y0);
        $this->Cell(32, 4, utf8_decode('REGISTRO: ' . (isset($evoluciones['createBy']['operador']["registro_medico"]) ? $evoluciones['createBy']['operador']["registro_medico"] : $evoluciones['createBy']['operador']["documento"])), 0, 0, 'L');
        $this->Cell(56, 11, "", 0, 0, 'L');
        $this->SetFont('Arial', '', 8);
        $this->SetX(125);

        $yDinamica = $this->GetY();

        if ($evoluciones["createBy"]["firma"]) {
            if (file_exists(storage_path(substr($evoluciones["createBy"]["firma"], 9)))) {
                $this->Image(storage_path(substr($evoluciones["createBy"]["firma"], 9)), 80, $yDinamica, 56, 20);
            }
        }
        $this->Line(10, $yDinamica + 21, 200, $yDinamica + 21);
      }
    }

    private function calcularEdad($fechaNacimiento, $fechaConsulta)
    {
        $fechaNacimiento = new DateTime($fechaNacimiento);
        $fechaConsulta = new DateTime($fechaConsulta);
        $edad = $fechaConsulta->diff($fechaNacimiento)->y;
        return $edad;
    }

    public function footer()
    {
        $this->SetXY(190,287);

        $this->Cell(10,4,utf8_decode('Página ').$this->PageNo().' de {nb}',0,0,'C');
        // $yOffset = $this->GetY() + 6;

        // $this->SetY($this->GetY() + 22);
        // $this->SetFont('Arial', 'B', 10);

        // $base64Image =  self::$admision->firma_afiliado;
        // $explodedData = explode(',', $base64Image);
        // $type = $explodedData[0];
        // $base64Data = $explodedData[1];
        // $imageData = base64_decode($base64Data);

        // $tempImage = tempnam(sys_get_temp_dir(), 'firma') . '.png';
        // file_put_contents($tempImage, $imageData);
        // $this->Image($tempImage, 152, $yOffset + 9, 65, 10);
        // unlink($tempImage);

        // if (isset(self::$admision->firma_acompanante)) {
        //     $base64Image = self::$admision->firma_acompanante;
        //     $explodedData = explode(',', $base64Image);
        //     $type = $explodedData[0];
        //     $base64Data = $explodedData[1];
        //     $imageData = base64_decode($base64Data);

        //     $tempImage = tempnam(sys_get_temp_dir(), 'firma') . '.png';
        //     file_put_contents($tempImage, $imageData);
        //     $this->Image($tempImage, 28, $yOffset + 9, 65, 10);
        //     unlink($tempImage);
        // }

        // $this->Ln();
        // $this->Cell(110, 10, utf8_decode('FIRMA DEL ACOMPAÑANTE '), 0, 0, 'C');
        // $this->Cell(130, 10, utf8_decode('FIRMA DEL PACIENTE'), 0, 0, 'C');


        // $this->Ln();
        // $this->Ln();
        // $this->SetFont('Arial', '', 10);
        // $this->Cell(100, 4, utf8_decode('Usuario:'.auth()->user()->operador->nombre_completo), 0, 0, 'l');
        // $this->Cell(70, 10, utf8_decode('TELEFONO'), 0, 0, 'C');

        // $this->Ln();
        // $this->Cell(320, -26, utf8_decode(self::$consulta->afiliado->numero_documento), 0, 1, 'C', false);
        // $this->Cell(490, 30, utf8_decode(self::$consulta->afiliado->celular1), 0, 0, 'C', false);
    }
}
