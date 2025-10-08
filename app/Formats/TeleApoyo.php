<?php

namespace App\Formats;

use App\Http\Modules\Teleapoyo\Models\Teleapoyo as ModelsTeleapoyo;
use App\Http\Modules\TipoDocumentos\Models\TipoDocumento;
use App\Modelos\IntegrantesJuntaGirs;

use Codedge\Fpdf\Fpdf\Fpdf;

class TeleApoyo extends FPDF
{

    public static $data;
    public static $teleconcepto;
    public static $tipoDocumento;

    public function generar($datos)
    {
        self::$teleconcepto = ModelsTeleapoyo::select('teleapoyos.*', 'tipo_solicitudes.nombre as tipoSolicitud')->join('tipo_solicitudes', 'teleapoyos.tipo_solicitudes_id', 'tipo_solicitudes.id')->where('teleapoyos.id', $datos["id"])->first();
        self::$data = $datos;
        self::$tipoDocumento = TipoDocumento::select('id','nombre')->where('id',self::$data["paciente"]["tipo_documento"])->first();
        $pdf = new TeleApoyo('p', 'mm', 'A4');
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $this->body($pdf);
        $pdf->Output();
    }

    public function header()
    {
        //cabecera

        $x = $this->GetX();
        $firmaY = $this->GetY();
        $this->SetDrawColor(140, 190, 56);
        $this->Rect(5, 5, 200, 287);
        $this->SetDrawColor(0, 0, 0);
        $this->SetFont('Arial', 'B', 9);
        $logo = public_path() . "/logoEcoimagen.png";
        $this->Image($logo, 16, 9, -220);
        $this->SetFont('Arial', '', 7);
        $this->SetXY(8, 37);
        $this->Cell(60, 3, utf8_decode('NIT:900033371-4 Res: 004 '), 0, 0, 'C');
    }

    public function footer()
    {
        $this->SetXY(185, 285);
        $this->Cell(18, 2, utf8_decode('Página ') . $this->PageNo() . ' de {nb}', 0, 0, 'C');
    }

    public function body($pdf)
    {
        //lineas
        //$teleApoyo='juntagirs';
        $pdf->SetXY(12, 45);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('DATOS DEL USUARIO'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetXY(12, 49);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(46.5, 4, utf8_decode('NOMBRE'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->cell(46.5, 4, utf8_decode(self::$data["paciente"]["nombre_completo"]), 1, 0, 'J');
        $pdf->SetXY(105, 49);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(46.5, 4, utf8_decode('TIPO DE IDENTIFICACIÓN'), 1, 0, 'L');
        $pdf->SetFont('Arial', '', 8);
        $pdf->cell(46.5, 4, utf8_decode(self::$tipoDocumento["nombre"]), 1, 0, 'J');
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(46.5, 4, utf8_decode('IDENTIFICACIÓN'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(46.5, 4, utf8_decode(self::$data["paciente"]["numero_documento"]), 1, 0, 'l');
        $pdf->SetXY(105, 53);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(46.5, 4, utf8_decode('EDAD'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(46.5, 4, utf8_decode(self::$data["paciente"]["edad_cumplida"]), 1, 0, 'l');
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(46.5, 4, utf8_decode('TELEFONO'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(46.5, 4, utf8_decode(self::$data["paciente"]["telefono"]), 1, 0, 'J');
        $pdf->SetXY(105, 57);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(46.5, 4, utf8_decode('CELULAR'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(46.5, 4, utf8_decode(self::$data["paciente"]["celular1"]), 1, 0, 'J');
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(46.5, 4, utf8_decode('EMAIL'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(46.5, 4, utf8_decode(self::$data["paciente"]["correo1"]), 1, 0, 'J');
        $pdf->SetXY(105, 61);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(46.5, 4, utf8_decode('EPS'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(46.5, 4, utf8_decode(self::$data["Ut"]), 1, 0, 'J');
        $pdf->Ln();

        //intval('')self::$teleconcepto->girs_auditor
        if (intval(self::$teleconcepto->girs_auditor)) {
            $pdf->Setx(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('JUNTA'), 1, 0, 'C', 1);
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(93, 4, utf8_decode('JUNTA PROFESIONAL APRUEBA'), 1, 0, 'C', 1);
            $pdf->Cell(93, 4, utf8_decode('CLASIFICACION PRIORIDAD SERVICIO'), 1, 0, 'C', 1);
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 9);

            $pdf->Cell(93, 4, utf8_decode(strtoupper(self::$teleconcepto->junta_aprueba)), 1, 0, 'C', 0);
            $pdf->Cell(93, 4, utf8_decode(self::$teleconcepto->tipoSolicitud), 1, 0, 'C', 0);
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(186, 4, utf8_decode('EVALUACION JUNTA'), 1, 0, 'C', 1);
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 9);
            $pdf->MultiCell(186, 4, utf8_decode(self::$teleconcepto->evaluacion_junta), 1, 'L', 0);
            $pdf->SetX(12);
            $firmaY = $pdf->GetY();
            $x = 12;
            $pdf->SetXY($x, $firmaY + 5);
            $pdf->SetFont('Arial', 'B', 15);
            $pdf->Cell(25, 6, utf8_decode('Firma Junta Medica'), 0, 0, 'L');
            $pdf->Ln();
        } else {
            $pdf->Setx(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('TELESALUD - FECHA: ' . self::$teleconcepto->created_at), 1, 0, 'C', 1);
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(30, 4, utf8_decode('MOTIVO:'), 1, 0, 'L', 0);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(156, 4, utf8_decode(self::$data["motivo"]), 1, 0, 'L', 0);
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('RESUMEN HISTORIA CLINICA'), 1, 0, 'C', 1);
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode(self::$data["ResumenHc"]), 1, "L", 0);
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('RESPUESTA FAMILIARISTA'), 1, 0, 'C', 1);
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode(self::$data["Respuesta"]), 1, "L", 0);
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('FIRMA'), 1, 0, 'C', 1);
            $firmaY = $pdf->GetY();
            $pdf->Rect(12, $firmaY, 186, 18);
            if (isset(self::$data["firma"])) {
                if (file_exists(storage_path(substr(self::$data["firma"], 9)))) {
                    $pdf->Image(storage_path(substr(self::$data["firma"], 9)), 65, $firmaY, 56, 11);
                }
            }
            $pdf->SetXY(12, $firmaY + 20);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(27, 4, utf8_decode('Registro Médico:'), 0, 0, 'J');
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(159, 4, utf8_decode(self::$data["Registromedico"]), 0, 0, "L");
            $this->Ln();
            $pdf->SetXY(12, $firmaY + 24);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(21, 4, utf8_decode('Especialidad:'), 0, 0, 'J');
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(165, 4, utf8_decode(self::$data["especialidad_medico"]), 0, 0, "L");
        }
    }
}
