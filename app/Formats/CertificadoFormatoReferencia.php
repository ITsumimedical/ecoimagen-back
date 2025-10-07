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

class CertificadoFormatoReferencia extends FPDF
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
    public static $entidadEpi;

    public function generar($data)
    {
        self::$epicrisis = Epicrisi::find($data['epicrisis']);
        self::$entidadEpi = Entidad::find(self::$epicrisis['entidad_id']);
        self::$cie10 = Cie10::find(self::$epicrisis->cie10_id);
        self::$consulta = Consulta::with(['HistoriaClinica','medicoOrdena.especialidades',])->where('id',self::$epicrisis->consulta_id)->first();
        self::$afiliado = Afiliado::find(self::$consulta->afiliado_id);
        self::$tipo = TipoDocumento::find(self::$afiliado->tipo_documento);
        self::$entidad = Entidad::find(self::$afiliado->entidad_id);
        // self::$admision = AdmisionesUrgencia::find(self::$consulta->admision_urgencia_id);
        self::$municipio = Municipio::find(self::$afiliado->municipio_afiliacion_id);
        self::$tipoAfiliado = TipoAfiliado::find(self::$afiliado->tipo_afiliado_id);
        // self::$evolucion = Evolucion::where('consulta_id',self::$consulta->id)
        // ->where('admision_urgencia_id',self::$admision->id)->with(['createBy.operador','createBy.especialidades'])->orderBy('id','ASC')->get();

        $pdf = new CertificadoFormatoReferencia('p', 'mm', 'A4');
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
            $this->SetFont('Arial', 'B', 13);
            $this->Cell(155, 4, utf8_decode('Formato de referencia y contrareferencia'), 0, 0, 'C');
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
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('FORMATO UNICO DE REFERENCIA Y CONTRAREFERENCIA DE PACIENTES MUESTRA Y ESTUDIO'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('I. DATOS DE LA REFERENCIA:'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40,4,utf8_decode('A. Entidad que remite'),1,0,'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(146,4,utf8_decode('MEDICINA INTEGRAL S.A.S'),1,0,'l');
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40,4,utf8_decode('FECHA'),1,0,'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(43,4,utf8_decode(self::$epicrisis['fecha_referencia']),1,0,'l');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(30,4,utf8_decode('Hora de salida'),1,0,'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(73,4,utf8_decode(''),1,0,'l');
        $pdf->Ln();
        $y0 = $pdf->GetY();
        if($y0 >240){
          $pdf->AddPage();
          $y0 = 40;
        }
        if ($y0 > 235 && round($pdf->GetStringWidth(self::$epicrisis['objeto_remision']), 2) > 1000) {
            $pdf->AddPage();
            $y0 = 40;
        }
        $pdf->SetFont('Arial', 'B', 8);
         $pdf->SetX(12, $y0);
        $pdf->MultiCell(146,4,utf8_decode('Objeto de la remisión'),0,'l',0);
         $y1 = $pdf->GetY();
         $pdf->SetXY(52, $y0);
         $pdf->SetFont('Arial', '', 8);
         $pdf->MultiCell(146,4,utf8_decode(self::$epicrisis['objeto_remision']),0,'l',0);
         $y2 = $pdf->GetY();
         $y = max($y1,$y2);

        #cuadrado
        $pdf->Line(12,$y0,198,$y0);
        $pdf->Line(12,$y,198,$y);
        $pdf->Line(12,$y0,12,$y);
        $pdf->Line(198,$y0,198,$y);
        #lineas verticales
        $pdf->Line(52,$y0,52,$y);

        $y0 = $pdf->GetY();
        if($y0 >240){
          $pdf->AddPage();
          $y0 = 40;
        }
        $pdf->SetXY(12,$y0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40,4,utf8_decode('Entidad a donde se remite'),1,0,'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(146,4,utf8_decode(self::$entidadEpi['nombre']),1,0,'l');
        $pdf->Ln();
        $y0 = $pdf->GetY();
        if($y0 >240){
          $pdf->AddPage();
          $y0 = 40;
        }
        $pdf->SetXY(12,$y0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40,4,utf8_decode('Remitido al Servicio de:'),1,0,'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(146,4,utf8_decode(self::$epicrisis['servicio_remision']),1,0,'l');
        $pdf->Ln();
        $y0 = $pdf->GetY();
        if($y0 >240){
          $pdf->AddPage();
          $y0 = 40;
        }
        $pdf->SetXY(12,$y0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40,4,utf8_decode('Especifique (otro servicio):'),1,0,'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(146,4,utf8_decode(self::$epicrisis['otro_servicio']),1,0,'l');
        $pdf->Ln();
        $y0 = $pdf->GetY();
        if($y0 >240){
          $pdf->AddPage();
          $y0 = 40;
        }
        $pdf->SetXY(12,$y0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40,4,utf8_decode('Medios de Referencia:'),1,0,'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(146,4,utf8_decode(''),1,0,'l');
        $pdf->Ln();
        $y0 = $pdf->GetY();
        if($y0 >240){
          $pdf->AddPage();
          $y0 = 40;
        }
        $pdf->SetXY(12,$y0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40,4,utf8_decode(''),1,0,'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(43,4,utf8_decode(''),1,0,'l');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(30,4,utf8_decode(''),1,0,'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(73,4,utf8_decode(''),1,0,'l');
        $pdf->Ln();
        $y0 = $pdf->GetY();
        if($y0 >240){
          $pdf->AddPage();
          $y0 = 40;
        }
        $pdf->SetXY(12,$y0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40,4,utf8_decode('B. Equipo de Referencia:'),1,0,'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(146,4,utf8_decode(''),1,0,'l');
        $pdf->Ln();
        $y0 = $pdf->GetY();
        if($y0 >240){
          $pdf->AddPage();
          $y0 = 40;
        }
        $pdf->SetXY(12,$y0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40,4,utf8_decode('Nombre del Conductor:'),1,0,'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(146,4,utf8_decode(''),1,0,'l');
        $pdf->Ln();
        $y0 = $pdf->GetY();
        if($y0 >240){
          $pdf->AddPage();
          $y0 = 40;
        }
        $pdf->SetXY(12,$y0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40,4,utf8_decode('Nombre del Medico:'),1,0,'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(146,4,utf8_decode(''),1,0,'l');
        $pdf->Ln();
        $y0 = $pdf->GetY();
        if($y0 >240){
          $pdf->AddPage();
          $y0 = 40;
        }
        $pdf->SetXY(12,$y0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40,4,utf8_decode('Nombre(s) de Paramedico(s):'),1,0,'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(146,4,utf8_decode(''),1,0,'l');
        $pdf->Ln();
        $y0 = $pdf->GetY();
        if($y0 >240){
          $pdf->AddPage();
          $y0 = 40;
        }
        $pdf->SetXY(12,$y0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40,4,utf8_decode(''),1,0,'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(43,4,utf8_decode(''),1,0,'l');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(30,4,utf8_decode(''),1,0,'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(73,4,utf8_decode(''),1,0,'l');
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
        $pdf->Cell(186, 4, utf8_decode('II. RESUMEN DE HISTORIA CLINICA:'), 1, 0, 'C', 1);
        $pdf->Ln();
        $y0 = $pdf->GetY();
        if($y0 >240){
          $pdf->AddPage();
          $y0 = 40;
        }
        $pdf->SetXY(12,$y0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40,4,utf8_decode('Fecha'),1,0,'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(146,4,utf8_decode(Carbon::parse(self::$consulta['fecha_hora_inicio'])->format('Y-m-d')),1,0,'l');
        $pdf->Ln();
        $y0 = $pdf->GetY();
        if($y0 >240){
          $pdf->AddPage();
          $y0 = 40;
        }
        if ($y0 > 235 && round($pdf->GetStringWidth(self::$consulta["HistoriaClinica"]["motivo_consulta"]), 2) > 1000) {
            $pdf->AddPage();
            $y0 = 40;
        }
        $pdf->SetFont('Arial', 'B', 8);
         $pdf->SetX(12, $y0);
        $pdf->MultiCell(146,4,utf8_decode('Motivo de consulta'),0,'l',0);
         $y1 = $pdf->GetY();
         $pdf->SetXY(52, $y0);
         $pdf->SetFont('Arial', '', 8);
         $pdf->MultiCell(146,4,utf8_decode(self::$consulta["HistoriaClinica"]["motivo_consulta"] ),0,'l',0);
         $y2 = $pdf->GetY();
         $y = max($y1,$y2);

        #cuadrado
        $pdf->Line(12,$y0,198,$y0);
        $pdf->Line(12,$y,198,$y);
        $pdf->Line(12,$y0,12,$y);
        $pdf->Line(198,$y0,198,$y);
        #lineas verticales
        $pdf->Line(52,$y0,52,$y);


        $y0 = $pdf->GetY();
        if($y0 >240){
          $pdf->AddPage();
          $y0 = 40;
        }
        if ($y0 > 235 && round($pdf->GetStringWidth(self::$consulta["HistoriaClinica"]["motivo_consulta"]), 2) > 1000) {
            $pdf->AddPage();
            $y0 = 40;
        }
        $pdf->SetFont('Arial', 'B', 8);
         $pdf->SetX(12, $y0);
        $pdf->MultiCell(146,4,utf8_decode('Enfermedad actual'),0,'l',0);
         $y1 = $pdf->GetY();
         $pdf->SetXY(52, $y0);
         $pdf->SetFont('Arial', '', 8);
         $pdf->MultiCell(146,4,utf8_decode(self::$consulta["HistoriaClinica"]["enfermedad_actual"] ),0,'l',0);
         $y2 = $pdf->GetY();
         $y = max($y1,$y2);

        #cuadrado
        $pdf->Line(12,$y0,198,$y0);
        $pdf->Line(12,$y,198,$y);
        $pdf->Line(12,$y0,12,$y);
        $pdf->Line(198,$y0,198,$y);
        #lineas verticales
        $pdf->Line(52,$y0,52,$y);

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
        $pdf->Cell(186, 4, utf8_decode('Examen fisico'), 1, 0, 'C', 1);
        $pdf->Ln();
        $y0 = $pdf->GetY();
        if($y0 >240){
          $pdf->AddPage();
          $y0 = 40;
        }
        $pdf->SetXY(12,$y0);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(34, 4, utf8_decode('Signos vitales'), 1, 0, 'C', 0);
        $pdf->Cell(12, 4, utf8_decode('FR'), 1, 0, 'L', 0);
        $pdf->Cell(12, 4, utf8_decode(isset(self::$epicrisis["frecuencia_respiratoria"]) && self::$epicrisis["frecuencia_respiratoria"] !== null ? self::$epicrisis["frecuencia_respiratoria"] : ""), 1, 0, 'L', 0);
        $pdf->Cell(12, 4, utf8_decode('FC'), 1, 0, 'L', 0);
        $pdf->Cell(12, 4, utf8_decode(isset(self::$epicrisis["frecuencia_cardiaca"]) && self::$epicrisis["frecuencia_cardiaca"] !== null ? self::$epicrisis["frecuencia_cardiaca"] : ""), 1, 0, 'L', 0);
        $pdf->Cell(12, 4, utf8_decode('TA'), 1, 0, 'L', 0);
        $pdf->Cell(20, 4, utf8_decode(isset(self::$epicrisis["tension_arterial"]) && self::$epicrisis["tension_arterial"] !== null ? self::$epicrisis["tension_arterial"] : ""), 1, 0, 'L', 0);
        $pdf->Cell(12, 4, utf8_decode('T'), 1, 0, 'L', 0);
        $pdf->Cell(12, 4, utf8_decode(isset(self::$epicrisis["temperatura"]) && self::$epicrisis["temperatura"] !== null ? self::$epicrisis["temperatura"] : ""), 1, 0, 'L', 0);
        $pdf->Cell(12, 4, utf8_decode('PESO'), 1, 0, 'L', 0);
        $pdf->Cell(12, 4, utf8_decode(isset(self::$epicrisis["peso"]) && self::$epicrisis["peso"] !== null ? self::$epicrisis["peso"] : ""), 1, 0, 'L', 0);
        $pdf->Cell(12, 4, utf8_decode('TALLA'), 1, 0, 'L', 0);
        $pdf->Cell(12, 4, utf8_decode(isset(self::$epicrisis["talla"]) && self::$epicrisis["talla"] !== null ? self::$epicrisis["talla"] : ""), 1, 0, 'L', 0);
        $pdf->Ln();
        $y0 = $pdf->GetY();
        if($y0 >240){
          $pdf->AddPage();
          $y0 = 40;
        }
        $pdf->SetXY(12,$y0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, utf8_decode(isset(self::$epicrisis["aspecto_general"]) && self::$epicrisis["aspecto_general"] !== null ? "Apariencia General: " .self::$epicrisis["aspecto_general"] : "Apariencia General:"), 1, 'L', 0);
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
        $pdf->Cell(186, 4, utf8_decode('EVALUACION DE APARATOS Y SISTEMAS'), 1, 0, 'C', 1);
        $pdf->Ln();
        $y0 = $pdf->GetY();
        if($y0 >240){
          $pdf->AddPage();
          $y0 = 40;
        }
        $pdf->SetXY(12,$y0);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(32, 4, utf8_decode('Cabeza'), 1, 0, 'C', 0);
        $pdf->Cell(24, 4, utf8_decode(isset(self::$epicrisis["cabeza"]) && self::$epicrisis["cabeza"] !== null ? self::$epicrisis["cabeza"] : ""), 1, 0, 'C', 0);
        $pdf->SetXY(77,$y0);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(32, 4, utf8_decode('Abdomen'), 1, 0, 'C', 0);
        $pdf->Cell(24, 4, utf8_decode(isset(self::$epicrisis["abdomen"]) && self::$epicrisis["abdomen"] !== null ? self::$epicrisis["abdomen"] : ""), 1, 0, 'C', 0);
        $pdf->SetXY(142,$y0);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(32, 4, utf8_decode('S.N.P'), 1, 0, 'C', 0);
        $pdf->Cell(24, 4, utf8_decode(isset(self::$epicrisis["snp"]) && self::$epicrisis["snp"] !== null ? self::$epicrisis["snp"] : ""), 1, 0, 'C', 0);
        $pdf->Ln();
        $y0 = $pdf->GetY();
        if($y0 >240){
          $pdf->AddPage();
          $y0 = 40;
        }
        $pdf->SetXY(12,$y0);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(32, 4, utf8_decode('Cuello'), 1, 0, 'C', 0);
        $pdf->Cell(24, 4, utf8_decode(isset(self::$epicrisis["cuello"]) && self::$epicrisis["cuello"] !== null ? self::$epicrisis["cuello"] : ""), 1, 0, 'C', 0);
        $pdf->SetXY(77,$y0);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(32, 4, utf8_decode('Torax'), 1, 0, 'C', 0);
        $pdf->Cell(24, 4, utf8_decode(isset(self::$epicrisis["torax"]) && self::$epicrisis["torax"] !== null ? self::$epicrisis["torax"] : ""), 1, 0, 'C', 0);
        $pdf->SetXY(142,$y0);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(32, 4, utf8_decode('Extremidades Sup.'), 1, 0, 'C', 0);
        $pdf->Cell(24, 4, utf8_decode(isset(self::$epicrisis["extremidad_superior"]) && self::$epicrisis["extremidad_superior"] !== null ? self::$epicrisis["extremidad_superior"] : ""), 1, 0, 'C', 0);
        $pdf->Ln();
        $y0 = $pdf->GetY();
        if($y0 >240){
          $pdf->AddPage();
          $y0 = 40;
        }
        $pdf->SetXY(12,$y0);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(32, 4, utf8_decode('Ojos'), 1, 0, 'C', 0);
        $pdf->Cell(24, 4, utf8_decode(isset(self::$epicrisis["ojos"]) && self::$epicrisis["ojos"] !== null ? self::$epicrisis["ojos"] : ""), 1, 0, 'C', 0);
        $pdf->SetXY(77,$y0);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(32, 4, utf8_decode('Respiratorio'), 1, 0, 'C', 0);
        $pdf->Cell(24, 4, utf8_decode(isset(self::$epicrisis["respiratorio"]) && self::$epicrisis["respiratorio"] !== null ? self::$epicrisis["respiratorio"] : ""), 1, 0, 'C', 0);
        $pdf->SetXY(142,$y0);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(32, 4, utf8_decode('Extremidades inf.'), 1, 0, 'C', 0);
        $pdf->Cell(24, 4, utf8_decode(isset(self::$epicrisis["extremidad_inferior"]) && self::$epicrisis["extremidad_inferior"] !== null ? self::$epicrisis["extremidad_inferior"] : ""), 1, 0, 'C', 0);
        $pdf->Ln();
        $y0 = $pdf->GetY();
        if($y0 >240){
          $pdf->AddPage();
          $y0 = 40;
        }
        $pdf->SetXY(12,$y0);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(32, 4, utf8_decode('Oidos'), 1, 0, 'C', 0);
        $pdf->Cell(24, 4, utf8_decode(isset(self::$epicrisis["oidos"]) && self::$epicrisis["oidos"] !== null ? self::$epicrisis["oidos"] : ""), 1, 0, 'C', 0);
        $pdf->SetXY(77,$y0);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(32, 4, utf8_decode('Gastrointestinales'), 1, 0, 'C', 0);
        $pdf->Cell(24, 4, utf8_decode(isset(self::$epicrisis["gastrointestinal"]) && self::$epicrisis["gastrointestinal"] !== null ? self::$epicrisis["gastrointestinal"] : ""), 1, 0, 'C', 0);
        $pdf->SetXY(142,$y0);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(32, 4, utf8_decode('Funciones cerebrales.'), 1, 0, 'C', 0);
        $pdf->Cell(24, 4, utf8_decode(isset(self::$epicrisis["funcion_cerebral"]) && self::$epicrisis["funcion_cerebral"] !== null ? self::$epicrisis["funcion_cerebral"] : ""), 1, 0, 'C', 0);
        $pdf->Ln();
        $y0 = $pdf->GetY();
        if($y0 >240){
          $pdf->AddPage();
          $y0 = 40;
        }
        $pdf->SetXY(12,$y0);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(32, 4, utf8_decode('Boca y garganta'), 1, 0, 'C', 0);
        $pdf->Cell(24, 4, utf8_decode(isset(self::$epicrisis["boca_garganta"]) && self::$epicrisis["boca_garganta"] !== null ? self::$epicrisis["boca_garganta"] : ""), 1, 0, 'C', 0);
        $pdf->SetXY(77,$y0);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(32, 4, utf8_decode('Linfático'), 1, 0, 'C', 0);
        $pdf->Cell(24, 4, utf8_decode(isset(self::$epicrisis["linfatico"]) && self::$epicrisis["linfatico"] !== null ? self::$epicrisis["linfatico"] : ""), 1, 0, 'C', 0);
        $pdf->SetXY(142,$y0);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(32, 4, utf8_decode('Reflejos'), 1, 0, 'C', 0);
        $pdf->Cell(24, 4, utf8_decode(isset(self::$epicrisis["reflejos"]) && self::$epicrisis["reflejos"] !== null ? self::$epicrisis["reflejos"] : ""), 1, 0, 'C', 0);

        $pdf->Ln();
        $y0 = $pdf->GetY();
        if($y0 >240){
          $pdf->AddPage();
          $y0 = 40;
        }
        $pdf->SetXY(12,$y0);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(32, 4, utf8_decode('Piel y mucosa'), 1, 0, 'C', 0);
        $pdf->Cell(24, 4, utf8_decode(isset(self::$epicrisis["piel_mucosa"]) && self::$epicrisis["piel_mucosa"] !== null ? self::$epicrisis["piel_mucosa"] : ""), 1, 0, 'C', 0);
        $pdf->SetXY(77,$y0);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(32, 4, utf8_decode('Desarrollo psicomotor'), 1, 0, 'C', 0);
        $pdf->Cell(24, 4, utf8_decode(isset(self::$epicrisis["psicomotor"]) && self::$epicrisis["psicomotor"] !== null ? self::$epicrisis["psicomotor"] : ""), 1, 0, 'C', 0);

        $pdf->Ln();
        $y0 = $pdf->GetY();
        if($y0 >240){
          $pdf->AddPage();
          $y0 = 40;
        }
        $pdf->SetXY(12,$y0);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(32, 4, utf8_decode('Urogenital'), 1, 0, 'C', 0);
        $pdf->Cell(24, 4, utf8_decode(isset(self::$epicrisis["urogenital"]) && self::$epicrisis["urogenital"] !== null ? self::$epicrisis["urogenital"] : ""), 1, 0, 'C', 0);
        $pdf->SetXY(77,$y0);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(32, 4, utf8_decode('S.N.C'), 1, 0, 'C', 0);
        $pdf->Cell(24, 4, utf8_decode(isset(self::$epicrisis["snc"]) && self::$epicrisis["snc"] !== null ? self::$epicrisis["snc"] : ""), 1, 0, 'C', 0);
        $pdf->Ln();
        $pdf->Ln();
        $y0 = $pdf->GetY();
        if($y0 >240){
          $pdf->AddPage();
          $y0 = 40;
        }
        $pdf->SetXY(12,$y0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, utf8_decode(isset(self::$epicrisis["evolucion_anterior"]) && self::$epicrisis["evolucion_anterior"] !== null ? "Anormalidades evolucion anterior: " .self::$epicrisis["evolucion_anterior"] : "Anormalidades evolucion anterior:"), 1, 'L', 0);
        $y0 = $pdf->GetY();
        if($y0 >240){
          $pdf->AddPage();
          $y0 = 40;
        }
        $pdf->SetXY(12,$y0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, utf8_decode(isset(self::$epicrisis["impresion_diagnostica"]) && self::$epicrisis["impresion_diagnostica"] !== null ? "Impresion diagnostica: " .self::$epicrisis["impresion_diagnostica"] : "Impresion diagnostica:"), 1, 'L', 0);
        $y0 = $pdf->GetY();
        if($y0 >240){
          $pdf->AddPage();
          $y0 = 40;
        }
        $pdf->SetXY(12,$y0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, utf8_decode(isset(self::$epicrisis["plan"]) && self::$epicrisis["plan"] !== null ? "Plan: " .self::$epicrisis["plan"] : "Plan:"), 1, 'L', 0);
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
        $pdf->Cell(186, 4, utf8_decode('III. DATOS DE LA ENTIDAD RECEPTORA:'), 1, 0, 'C', 1);
        $pdf->Ln();
        $y0 = $pdf->GetY();
        if($y0 >240){
          $pdf->AddPage();
          $y0 = 40;
        }
        $pdf->SetXY(12,$y0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40,4,utf8_decode('Nombre de la Entidad:'),1,0,'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(146,4,utf8_decode(''),1,0,'l');
        $pdf->Ln();
        $y0 = $pdf->GetY();
        if($y0 >240){
          $pdf->AddPage();
          $y0 = 40;
        }
        $pdf->SetXY(12,$y0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40,4,utf8_decode('FECHA'),1,0,'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(43,4,utf8_decode(Carbon::parse(self::$epicrisis['fecha_referencia'])->format('Y-m-d')  ),1,0,'l');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(30,4,utf8_decode('Hora de ingreso'),1,0,'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(73,4,utf8_decode(''),1,0,'l');
        $pdf->Ln();

        $y0 = $pdf->GetY();
        if($y0 >240){
          $pdf->AddPage();
          $y0 = 40;
        }
        $pdf->SetXY(12,$y0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40,4,utf8_decode('Ingreso al Servicio de:'),1,0,'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(146,4,utf8_decode(''),1,0,'l');
        $pdf->Ln();
        $y0 = $pdf->GetY();
        if($y0 >240){
          $pdf->AddPage();
          $y0 = 40;
        }
        $pdf->SetXY(12,$y0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40,4,utf8_decode('Especifique (otro servicio):'),1,0,'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(146,4,utf8_decode(''),1,0,'l');
        $pdf->Ln();
        $y0 = $pdf->GetY();
        if($y0 >240){
          $pdf->AddPage();
          $y0 = 40;
        }
        $pdf->SetXY(12,$y0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40,4,utf8_decode('Responsable de Ingreso:'),1,0,'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(146,4,utf8_decode(''),1,0,'l');
        $pdf->Ln();

        $y0 = $pdf->GetY();
        if($y0 >240){
          $pdf->AddPage();
          $y0 = 40;
        }
        $pdf->SetXY(12,$y0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40,4,utf8_decode('Cargo'),1,0,'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(43,4,utf8_decode(''),1,0,'l');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(30,4,utf8_decode('Codigo'),1,0,'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(73,4,utf8_decode(''),1,0,'l');
        $pdf->Ln();
        $y0 = $pdf->GetY();
        if($y0 >240){
          $pdf->AddPage();
          $y0 = 40;
        }
        $pdf->SetXY(12,$y0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40,4,utf8_decode('Firma y codigo:'),1,0,'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(146,4,utf8_decode(''),1,0,'l');
        $pdf->Ln();
        $y0 = $pdf->GetY();
        if($y0 >240){
          $pdf->AddPage();
          $y0 = 40;
        }
        $pdf->SetXY(12,$y0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40,4,utf8_decode(''),1,0,'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(43,4,utf8_decode(''),1,0,'l');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(30,4,utf8_decode(''),1,0,'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(73,4,utf8_decode(''),1,0,'l');
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
        $pdf->Cell(186, 4, utf8_decode('IV. CONTRAREFERENCIA:'), 1, 0, 'C', 1);
        $pdf->Ln();
        $y0 = $pdf->GetY();
        if($y0 >240){
          $pdf->AddPage();
          $y0 = 40;
        }
        $pdf->SetXY(12,$y0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40,4,utf8_decode('FECHA'),1,0,'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(146,4,utf8_decode(Carbon::parse(self::$epicrisis['fecha_referencia'])->format('Y-m-d')  ),1,0,'l');
        $pdf->Ln();
        $y0 = $pdf->GetY();
        if($y0 >240){
          $pdf->AddPage();
          $y0 = 40;
        }
        $pdf->SetXY(12,$y0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40,4,utf8_decode('Motivo'),1,0,'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(146,4,utf8_decode(''),1,0,'l');
        $pdf->Ln();
        $y0 = $pdf->GetY();
        if($y0 >240){
          $pdf->AddPage();
          $y0 = 40;
        }
        $pdf->SetXY(12,$y0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40,4,utf8_decode('Plan'),1,0,'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(146,4,utf8_decode(''),1,0,'l');
        $pdf->Ln();
        $y0 = $pdf->GetY();
        if($y0 >240){
          $pdf->AddPage();
          $y0 = 40;
        }
        $pdf->SetXY(12,$y0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40,4,utf8_decode(''),1,0,'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(100,4,utf8_decode(''),1,0,'l');
        $pdf->Cell(21,4,utf8_decode(''),1,0,'l');
        $pdf->Cell(25,4,utf8_decode(''),1,0,'l');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 8);
        $y0 = $pdf->GetY();
        if($y0 >255){
          $pdf->AddPage();
          $y0 = 40;
        }

        $pdf->SetXY(12,$y0);
        $pdf->Cell(60, 4, utf8_decode('ATENDIDO POR: ' .self::$consulta["medicoOrdena"]["operador"]["nombre_completo"]), 0, 0, 'L');
        $pdf->Ln();
        $y0 = $pdf->GetY();
        if($y0 >260){
          $pdf->AddPage();
          $y0 = 40;
        }
        $pdf->SetXY(12,$y0);
        $pdf->Cell(60, 4, utf8_decode('Especialidad: ' .self::$consulta["medicoOrdena"]['especialidades'][0]['nombre']), 0, 0, 'L');
        $pdf->Ln();
        $y0 = $pdf->GetY();
        if($y0 >260){
          $pdf->AddPage();
          $y0 = 40;
        }
        $pdf->SetXY(12,$y0);
        $pdf->Cell(32, 4, utf8_decode('REGISTRO: ' . (isset(self::$consulta["medicoOrdena"]['operador']["registro_medico"]) ? self::$consulta["medicoOrdena"]['operador']["registro_medico"] : self::$consulta["medicoOrdena"]['operador']["documento"])), 0, 0, 'L');
        $pdf->Cell(56, 11, "", 0, 0, 'L');
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetX(125);

        $yDinamica = $pdf->GetY();

        if (self::$consulta["medicoOrdena"]["firma"]) {
            if (file_exists(storage_path(substr(self::$consulta["medicoOrdena"]["firma"], 9)))) {
                $pdf->Image(storage_path(substr(self::$consulta["medicoOrdena"]["firma"], 9)), 12, $yDinamica, 56, 20);
            }
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
    }
}
