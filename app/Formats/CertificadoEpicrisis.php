<?php

namespace App\Formats;

use DateTime;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Carbon;
use App\Http\Modules\Entidad\Models\Entidad;
use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\TipoDocumentos\Models\TipoDocumento;
use App\Http\Modules\AdmisionesUrgencias\Models\AdmisionesUrgencia;
use App\Http\Modules\Cie10\Models\Cie10;
use App\Http\Modules\Epicrisis\Models\Epicrisi;
use App\Http\Modules\Evoluciones\Models\Evolucion;
use App\Http\Modules\Municipios\Models\Municipio;
use App\Http\Modules\TipoAfiliados\Models\TipoAfiliado;

class CertificadoEpicrisis extends FPDF
{

    public static $consulta;
    public static $afiliado;
    public static $entidad;
    public static $tipo;
    public static $admision;
    public static $municipio;
    public static $tipoAfiliado;
    public static $epicrisis;
    public static $cie10;

    public function generar($data)
    {
        self::$epicrisis = Epicrisi::find($data['epicrisis']);
        self::$cie10 = Cie10::find(self::$epicrisis->cie10_id);
        self::$consulta = Consulta::find(self::$epicrisis->consulta_id);
        self::$afiliado = Afiliado::find(self::$consulta->afiliado_id);
        self::$tipo = TipoDocumento::find(self::$afiliado->tipo_documento);
        self::$entidad = Entidad::find(self::$afiliado->entidad_id);
        // self::$admision = AdmisionesUrgencia::find(self::$consulta->admision_urgencia_id);
        self::$municipio = Municipio::find(self::$afiliado->municipio_afiliacion_id);
        self::$tipoAfiliado = TipoAfiliado::find(self::$afiliado->tipo_afiliado_id);
        // self::$evolucion = Evolucion::where('consulta_id',self::$consulta->id)
        // ->where('admision_urgencia_id',self::$admision->id)->with(['createBy.operador','createBy.especialidades'])->orderBy('id','ASC')->get();

        $pdf = new CertificadoEpicrisis('p', 'mm', 'A4');
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $this->body($pdf);
        $pdf->Output();
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
            $this->Cell(155, 4, utf8_decode('EPICRISIS'), 0, 0, 'C');
            $this->SetXY(66, 23);
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(38, 4, utf8_decode('Fecha de Impresión:'), 0, 0, 'l');
            $this->SetFont('Arial', '', 8);
            $this->Cell(15, 4, utf8_decode(Carbon::now()), 0, 0, 'C');



    }

    public function body($pdf) {

        $pdf->SetXY(12, 40);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('DATOS DEL USUARIO'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(46.5, 4, utf8_decode('NOMBRE COMPLETO'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(46.5, 4, utf8_decode(isset(self::$afiliado["nombre_completo"]) && self::$afiliado["nombre_completo"] ? self::$afiliado["nombre_completo"] : 'No Reporta'), 1, 0, 'l');
        $pdf->SetX(105);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(46.5, 4, utf8_decode('TIPO DE IDENTIFICACIÓN'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(46.5, 4, utf8_decode(isset(self::$tipo->sigla) && self::$tipo->sigla ? self::$tipo->sigla : 'No Reporta'), 1, 0, 'l');
        $pdf->Ln();

        $edad = $this->calcularEdad(self::$afiliado["fecha_nacimiento"], self::$consulta["fecha_hora_inicio"]);
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(46.5, 4, utf8_decode('FECHA DE NACIMIENTO'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(46.5, 4, utf8_decode(isset(self::$afiliado["fecha_nacimiento"]) && self::$afiliado["fecha_nacimiento"] ? self::$afiliado["fecha_nacimiento"] : 'No Reporta'), 1, 0, 'l');
        $pdf->SetX(105);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(46.5, 4, utf8_decode('IDENTIFICACIÓN'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(46.5, 4, utf8_decode(isset(self::$afiliado["numero_documento"]) && self::$afiliado["numero_documento"] ? self::$afiliado["numero_documento"] : 'No Reporta'), 1, 0, 'l');

        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(46.5, 4, utf8_decode('EDAD'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(46.5, 4, utf8_decode($edad ? $edad . ' Años' : 'No Reporta'), 1, 0, 'l');
        $pdf->SetX(105);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(46.5, 4, utf8_decode('SEXO'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(46.5, 4, utf8_decode(isset(self::$afiliado["sexo"]) && self::$afiliado["sexo"] ? (self::$afiliado["sexo"] === 'M' ? 'Masculino' : 'Femenino') : 'No Reporta'), 1, 0, 'l');

        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(46.5, 4, utf8_decode('OCUPACIÓN'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(139.5, 4, utf8_decode(isset(self::$afiliado["ocupacion"]) && self::$afiliado["ocupacion"] ? self::$afiliado["ocupacion"] : 'No Reporta'), 1, 0, 'l');
        $pdf->Ln();


        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(46.5, 4, utf8_decode('DIRECCIÓN'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(139.5, 4, utf8_decode(isset(self::$afiliado["direccion_residencia_cargue"]) && self::$afiliado["direccion_residencia_cargue"] ? self::$afiliado["direccion_residencia_cargue"] : 'No Reporta'), 1, 0, 'l');
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(46.5, 4, utf8_decode('ASEGURADORA'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(139.5, 4, utf8_decode(isset(self::$entidad["nombre"]) && self::$entidad["nombre"] ? self::$entidad["nombre"] : 'No Reporta'), 1, 'L');
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(46.5, 4, utf8_decode('TELÉFONO DEL DOMICILIO'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(46.5, 4, utf8_decode((isset(self::$afiliado["telefono"]) && self::$afiliado["telefono"] ? self::$afiliado["telefono"] : 'No Reporta') . '-' . (isset(self::$afiliado["celular1"]) && self::$afiliado["celular1"] ? self::$afiliado["celular1"] : 'No Reporta')), 1, 0, 'l');
        $pdf->SetX(105);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(46.5, 4, utf8_decode('LUGAR DE RESIDENCIA'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(46.5, 4, utf8_decode(isset(self::$municipio["nombre"]) && self::$municipio["nombre"] ? self::$municipio["nombre"] : 'No Reporta'), 1, 0, 'l');

        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(46.5, 4, utf8_decode('NOMBRE DEL RESPONSABLE'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(46.5, 4, utf8_decode(isset(self::$afiliado["nombre_responsable"]) && self::$afiliado["nombre_responsable"] ? self::$afiliado["nombre_responsable"] : 'No Reporta'), 1, 0, 'l');


        $pdf->SetX(105);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(46.5, 4, utf8_decode('TELEFONO RESPONSABLE'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(46.5, 4, utf8_decode(isset(self::$afiliado["telefono_responsable"]) && self::$afiliado["telefono_responsable"] ? self::$afiliado["telefono_responsable"] : 'No Reporta'), 1, 0, 'l');
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(46.5, 4, utf8_decode('PARENTESO RESPONSABLE'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(46.5, 4, utf8_decode(isset(self::$afiliado["parentesco_responsable"]) && self::$afiliado["parentesco_responsable"] ? self::$afiliado["parentesco_responsable"] : 'No Reporta'), 1, 0, 'l');

        $pdf->SetX(105);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(46.5, 4, utf8_decode('TIPO DE VINCULACIÓN'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(46.5, 4, utf8_decode(isset(self::$tipoAfiliado["nombre"]) && self::$tipoAfiliado["nombre"] ? self::$tipoAfiliado["nombre"] : 'No Reporta'), 1, 0, 'l');
        $pdf->Ln();
    //     $pdf->SetX(12);
    //     $pdf->SetFont('Arial', 'B', 8);
    //     $pdf->Cell(46.5, 4, utf8_decode('Fecha ingreso'), 1, 0, 'l');
    //     $pdf->SetFont('Arial', '', 8);
    //     $pdf->Cell(46.5, 4, utf8_decode(Carbon::parse(self::$admision["created_at"])->format('Y-m-d')   ), 1, 0, 'l');
    //     // $pdf->Ln();
    //     // $pdf->SetX(12);
    //     $pdf->SetFont('Arial', 'B', 8);
    //     $pdf->Cell(46.5, 4, utf8_decode('Hora ingreso'), 1, 0, 'l');
    //     $pdf->SetFont('Arial', '', 8);
    //     $pdf->Cell(46.5, 4, utf8_decode(Carbon::parse(self::$admision["created_at"])->format('H:i:s')), 1, 0, 'l');
    //     $pdf->Ln();
    //     $pdf->SetX(12);
    //     $pdf->SetFont('Arial', 'B', 8);
    //     $pdf->Cell(46.5, 4, utf8_decode('Fecha y hora de atención'), 1, 0, 'l');
    //     $pdf->SetFont('Arial', '', 8);
    //     $pdf->Cell(46.5, 4, utf8_decode(self::$consulta["id"]), 1, 0, 'l');
    //     $pdf->SetX(105);
    //     $pdf->SetFont('Arial', 'B', 8);
    //     $pdf->Cell(46.5, 4, utf8_decode('N° ATENCIÓN'), 1, 0, 'l');
    //     $pdf->SetFont('Arial', '', 8);
    //     $pdf->Cell(46.5, 4, utf8_decode(self::$consulta["id"]), 1, 0, 'l');
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(46.5, 4, utf8_decode('ESTADO CIVIL'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(46.5, 4, utf8_decode(isset(self::$afiliado["estado_civil"]) && self::$afiliado["estado_civil"] ? self::$afiliado["estado_civil"] : 'No Reporta'), 1, 0, 'l');
        // $pdf->Ln();
        $pdf->SetX(105);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(46.5, 4, utf8_decode('ETNIA'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(46.5, 4, utf8_decode(isset(self::$afiliado["etnia"]) && self::$afiliado["etnia"] ? self::$afiliado["etnia"] : 'No Reporta'), 1, 0, 'l');

        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(46.5, 4, utf8_decode('NIVEL EDUCATIVO'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(46.5, 4, utf8_decode(isset(self::$afiliado["nivel_educativo"]) && self::$afiliado["nivel_educativo"] ? self::$afiliado["nivel_educativo"] : 'No Reporta'), 1, 0, 'l');
        $pdf->SetX(105);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(46.5, 4, utf8_decode('DISCAPACIDAD'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(46.5, 4, utf8_decode(isset(self::$afiliado["discapacidad"]) && self::$afiliado["discapacidad"] ? self::$afiliado["discapacidad"] : 'No Reporta'), 1, 0, 'l');
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(46.5, 4, utf8_decode('NOMBRE DEL ACOMPAÑANTE'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(46.5, 4, utf8_decode(isset(self::$afiliado["nombre_acompanante"]) && self::$afiliado["nombre_acompanante"] ? self::$afiliado["nombre_acompanante"] : 'No Reporta'), 1, 0, 'l');
        $pdf->SetX(105);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(46.5, 4, utf8_decode('TELÉFONO DEL ACOMPAÑANTE'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(46.5, 4, utf8_decode(isset(self::$afiliado["telefono_acompanante"]) && self::$afiliado["telefono_acompanante"] ? self::$afiliado["telefono_acompanante"] : 'No Reporta'), 1, 0, 'l');
        $pdf->Ln();
        $pdf->Ln();
            $y0 = $pdf->GetY();
            if($y0 >240){
              $pdf->AddPage();
              $y0 = 40;
            }
            $pdf->SetXY(12,$y0);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('DIAGNÓSTICOS'), 1, 0, 'C', 1);
            $pdf->Ln();
            $y0 = $pdf->GetY();
            if($y0 >240){
              $pdf->AddPage();
              $y0 = 40;
            }
            $pdf->SetXY(12,$y0);
            $pdf->Cell(186, 4, utf8_decode('DIAGNÓSTICO PRINCIPAL'), 1, 0, 'C', 1);
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFont('Arial', '', 8);

        // Obtener el primer diagnóstico como principal
        $diagnosticoPrincipal = self::$consulta->cie10Afiliado->first();
        $codigoCie10 = isset($diagnosticoPrincipal->cie10->codigo_cie10) ? $diagnosticoPrincipal->cie10->codigo_cie10 : '';
        $descripcionDiagnostico = isset($diagnosticoPrincipal->cie10->nombre) ? $diagnosticoPrincipal->cie10->nombre : '';
        $tipoDiagnostico = isset($diagnosticoPrincipal->tipo_diagnostico) ? $diagnosticoPrincipal->tipo_diagnostico : '';

        $textoDXprincipal = "CODIGO CIE10: " . utf8_decode($codigoCie10) .
            ", DESCRIPCION DEL DIAGNOSTICO: " . utf8_decode($descripcionDiagnostico) .
            ", TIPO DEL DIAGNOSTICO: " . utf8_decode($tipoDiagnostico);

        $pdf->SetX(12);
        $pdf->MultiCell(186, 4, $textoDXprincipal, 1, "L", 0);
         $y0 = $pdf->GetY();
        if($y0 >240){
          $pdf->AddPage();
          $y0 = 40;
        }
         $pdf->SetFont('Arial', 'B', 8);
         $pdf->SetXY(12, $y0);
         $pdf->MultiCell(40,4,utf8_decode('Diagnostico Egreso'),1,'l',0);
         $pdf->SetXY(52, $y0);
         $pdf->SetFont('Arial', '', 8);
         $pdf->MultiCell(146,4,utf8_decode(self::$cie10['codigo_cie10'].'-'.self::$cie10['descripcion']),1,'l',0);
         $pdf->SetX(12);
         $pdf->SetFont('Arial', 'B', 8);
         $pdf->Cell(40,4,utf8_decode('Motivo de salida'),1,0,'l');
         $pdf->SetFont('Arial', '', 8);
         $pdf->Cell(146,4,utf8_decode(self::$epicrisis['motivo_salida']),1,0,'l');
         $pdf->Ln();
         $pdf->SetX(12);
         $pdf->SetFont('Arial', 'B', 8);
         $pdf->Cell(40,4,utf8_decode('Estado a la salida'),1,0,'l');
         $pdf->SetFont('Arial', '', 8);
         $pdf->Cell(146,4,utf8_decode(self::$epicrisis['estado_salida']),1,0,'l');
         $pdf->Ln();
         if(self::$epicrisis['estado_salida']=='Muerto'){
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(45,4,utf8_decode('Fecha y hora del suceso'),1,0,'l');
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(48,4,utf8_decode(self::$epicrisis['fecha_deceso']),1,0,'l');
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(45,4,utf8_decode('Certificado de defuncion'),1,0,'l');
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(48,4,utf8_decode(self::$epicrisis['certificado_defuncion']),1,0,'l');
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(40,4,utf8_decode('Causa de muerte'),1,0,'l');
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(146,4,utf8_decode(self::$epicrisis['causa_muerte']),1,0,'l');
            $pdf->Ln();
         }
         $y0 = $pdf->GetY();
        $pdf->SetFont('Arial', 'B', 8);
         $pdf->SetX(12, $y0);
        $pdf->MultiCell(146,4,utf8_decode('Observacion'),0,'l',0);
         $y1 = $pdf->GetY();
         $pdf->SetXY(52, $y0);
         $pdf->SetFont('Arial', '', 8);
         $pdf->MultiCell(146,4,utf8_decode(self::$epicrisis['observacion']),0,'l',0);
         $y2 = $pdf->GetY();
         $y = max($y1,$y2);

        #cuadrado
        $pdf->Line(12,$y0,198,$y0);
        $pdf->Line(12,$y,198,$y);
        $pdf->Line(12,$y0,12,$y);
        $pdf->Line(198,$y0,198,$y);
        #lineas verticales
        $pdf->Line(52,$y0,52,$y);

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
    }
}
