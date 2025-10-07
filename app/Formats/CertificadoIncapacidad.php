<?php

namespace App\Formats;

use Codedge\Fpdf\Fpdf\Fpdf;
use App\Traits\PdfTrait;
use Carbon\Carbon;

class CertificadoIncapacidad extends FPDF
{
    use PdfTrait;

    protected static $incapacidad;
    function generar($incapacidades)
    {
        self::$incapacidad = $incapacidades->incapacidad;

        if (!self::$incapacidad) {
            throw new \Exception("Incapacidad no encontrada.");
        }

        $this->generarPDF('I');
    }
    public function header()
    {
        $this->Image(public_path() . "/images/logotipo_fps.jpg", 3, 2, -500);
        $this->SetFont('Arial', '', 12);
        $this->SetTextColor(255, 0, 0);
        $this->Text(140, 8, 'CERTIFICADO DE INCAPACIDAD');
        $this->SetTextColor(0, 0, 0);
        $this->SetFillColor(255);
        $this->SetFont('Arial', 'B', 12);
        $this->RoundedRect(155, 10, 40, 8, 3.5, 'DF');
        $this->SetFillColor(000);
        $this->SetXY(157, 11);
        $this->Cell(30, 6, 'No.', 0, 1, 'L');
        $this->SetXY(167, 11);
        $this->SetFont('Arial', '', 12);
        $this->Cell(30, 6, self::$incapacidad['id'], 0, 1, 'L');
        $this->SetFillColor(255);
        $this->RoundedRect(5, 20, 200, 124, 3.5, 'DF');
        $this->SetFont('Arial', 'B', 7);
        $this->TextWithDirection(208, 80, utf8_decode('SERVICIOS ASISTENCIALES'), 'U');
    }

    public function body()
    {
        $this->Line(5, 30, 205, 30);
        $this->SetXY(8, 21);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(90, 2, 'NOMBRES Y APELLIDOS DE AFILIADO', 0, 1, 'L');
        $this->SetXY(8, 24);
        $this->SetFont('Arial', '', 8);
        $this->Cell(10, 7, utf8_decode(self::$incapacidad->consulta->afiliado['primer_nombre']), 0, 1, 'L');
        $this->Line(126, 30, 126, 20);
        $this->SetXY(126, 21);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(10, 2, 'C.C. No.', 0, 1, 'L');
        $this->SetXY(126, 24);
        $this->SetFont('Arial', '', 8);
        $this->Cell(10, 7, utf8_decode(self::$incapacidad->consulta->afiliado['numero_documento']), 0, 1, 'L');
        $this->Line(148, 30, 148, 20);
        $this->SetXY(148, 21);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(10, 2, 'SEXO:', 0, 1, 'L');
        $this->SetXY(154, 24);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(10, 7, utf8_decode('MASC.'), 0, 1, 'L');
        $this->SetXY(165, 24);
        $this->SetFont('Arial', '', 10);
        $this->Cell(8, 7, utf8_decode(self::$incapacidad->consulta->afiliado['sexo'] === 'M' ? 'X' : ''), 0, 1, 'L');
        $this->SetXY(172, 24);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(10, 7, utf8_decode('FEM.'), 0, 1, 'L');
        $this->SetXY(180, 24);
        $this->SetFont('Arial', '', 10);
        $this->Cell(8, 7, utf8_decode(self::$incapacidad->consulta->afiliado['sexo'] === 'F' ? 'X' : ''), 0, 1, 'L');
        $this->Line(185, 30, 185, 20);
        $this->SetXY(185, 21);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(10, 2, 'EDAD:', 0, 1, 'L');
        $this->SetXY(185, 23);
        $this->SetFont('Arial', '', 12);
        $this->Cell(10, 7, self::$incapacidad->consulta->afiliado['edad_cumplida'], 0, 1, 'C');
        $this->SetXY(195, 24);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(10, 7, utf8_decode('AÑOS'), 0, 1, 'L');


        $this->Line(5, 40, 205, 40);
        $this->SetXY(8, 31);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(90, 2, 'ENTIDAD', 0, 1, 'L');
        $this->SetXY(8, 34);
        $this->SetFont('Arial', '', 8);
        $this->Cell(10, 7, utf8_decode('FONDO DE PASIVO SOCIAL'), 0, 1, 'L');
        $this->SetXY(100, 31);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(90, 2, utf8_decode('CÓDIGO'), 0, 1, 'L');
        $this->SetXY(102, 34);
        $this->SetFont('Arial', '', 12);
        $this->Cell(8, 7, utf8_decode('X'), 0, 1, 'C');
        $this->SetXY(110, 34);
        $this->Cell(8, 7, utf8_decode('X'), 0, 1, 'C');
        $this->SetXY(118, 34);
        $this->Cell(8, 7, utf8_decode('X'), 0, 1, 'C');
        $this->Line(126, 40, 126, 30);
        $this->SetXY(126, 31);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(10, 2, 'INCAPACIDAD POR:', 0, 1, 'L');
        $this->SetXY(145, 34);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(10, 7, utf8_decode('HOSPITALIZ.'), 0, 1, 'L');
        $this->SetXY(165, 34);
        $this->SetFont('Arial', '', 10);
        // $this->Cell(8,7,utf8_decode(self::$incapacidad->consulta->afiliado['amb`ito'] === 'Hospitalizacion'?'X':''),0,1,'L');
        $this->SetXY(176, 34);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(10, 7, utf8_decode('AMBULAT.'), 0, 1, 'L');
        $this->SetXY(195, 34);
        $this->SetFont('Arial', '', 10);
        // $this->Cell(8,7,utf8_decode(self::$transcripcion['ambito'] === 'Ambulatoria'?'X':''),0,1,'L');

        $this->Line(5, 60, 205, 60);
        $this->SetXY(8, 41);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(90, 2, utf8_decode('DÍAS DE INCAPACIDAD'), 0, 1, 'L');

        $this->SetXY(8, 56);
        $this->Cell(90, 2, utf8_decode('No.'), 0, 1, 'L');
        $this->SetFont('Arial', '', 12);
        $this->SetXY(14, 54);
        $this->Cell(90, 6, utf8_decode(self::$incapacidad['dias']), 0, 1, 'L');
        $this->SetFont('Arial', 'B', 8);
        $this->SetXY(25, 56);
        $this->Cell(90, 2, utf8_decode('LETRAS:'), 0, 1, 'L');
        $this->SetFont('Arial', '', 12);
        $this->SetXY(39, 54);
        $dias = intval(self::$incapacidad['dias']);
        $fechaBase = Carbon::now();
        $fechaNueva = $fechaBase->addDays($dias)->translatedFormat('d \d\e F \d\e Y');
        // Imprimir en PDF usando Cell
        $this->Cell(90, 6, $fechaNueva, 0, 1, 'L');

        $this->Cell(90, 6, $fechaNueva, 0, 1, 'L');
        $this->SetXY(97, 40);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(41, 5, utf8_decode('DURACÍON DE INCAPACIDAD'), 1, 1, 'C');
        $this->SetXY(97, 45);
        $fechaDesde = explode('-', self::$incapacidad['fecha_inicio']);
        $this->Cell(11, 7.5, utf8_decode('DEL'), 1, 1, 'C');
        $this->SetFont('Arial', 'B', 6.5);
        $this->SetXY(108, 45);
        $this->Cell(10, 3, utf8_decode('DÍA'), 1, 1, 'C');
        $this->SetXY(118, 45);
        $this->Cell(10, 3, utf8_decode('MES'), 1, 1, 'C');
        $this->SetXY(128, 45);
        $this->Cell(10, 3, utf8_decode('AÑO'), 1, 1, 'C');
        $this->SetXY(108, 48);
        $this->Cell(10, 4.5, utf8_decode($fechaDesde['2']), 1, 1, 'C');
        $this->SetXY(118, 48);
        $this->Cell(10, 4.5, utf8_decode($fechaDesde['1']), 1, 1, 'C');
        $this->SetXY(128, 48);
        $this->Cell(10, 4.5, utf8_decode($fechaDesde['0']), 1, 1, 'C');
        $this->SetFont('Arial', 'B', 8);
        $this->SetXY(97, 52.5);
        $fechaHasta = explode('-', self::$incapacidad['fecha_final']);
        $this->Cell(11, 7.5, utf8_decode('AL'), 1, 1, 'C');
        $this->SetFont('Arial', 'B', 6.5);
        $this->SetXY(108, 52.5);
        $this->Cell(10, 3, utf8_decode('DÍA'), 1, 1, 'C');
        $this->SetXY(118, 52.5);
        $this->Cell(10, 3, utf8_decode('MES'), 1, 1, 'C');
        $this->SetXY(128, 52.5);
        $this->Cell(10, 3, utf8_decode('AÑO'), 1, 1, 'C');
        $this->SetXY(108, 55.5);
        $this->Cell(10, 4.5, utf8_decode($fechaHasta[2]), 1, 1, 'C');
        $this->SetXY(118, 55.5);
        $this->Cell(10, 4.5, utf8_decode($fechaHasta[1]), 1, 1, 'C');
        $this->SetXY(128, 55.5);
        $this->Cell(10, 4.5, utf8_decode($fechaHasta[0]), 1, 1, 'C');
        $this->SetFont('Arial', 'B', 8);
        $this->SetXY(141, 44);
        $this->MultiCell(30, 3, utf8_decode('PRORROGA'), 0, 'C', 0);
        $this->SetXY(138, 52);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(8, 7, utf8_decode('SI'), 0, 1, 'C');
        $this->SetXY(144, 50);
        $this->SetFont('Arial', '', 12);
        $this->Cell(8, 7, utf8_decode(self::$incapacidad['prorroga'] ? 'X' : ''), 1, 1, 'C');
        $this->SetXY(154, 52);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(8, 7, utf8_decode('NO'), 0, 1, 'C');
        $this->SetXY(161, 50);
        $this->SetFont('Arial', '', 12);
        $this->Cell(8, 7, utf8_decode(!self::$incapacidad['prorroga'] ? 'X' : ''), 1, 1, 'C');
        $this->SetFont('Arial', 'B', 8);
        $this->SetXY(172, 43);
        $this->MultiCell(30, 3, utf8_decode('CÓDIGO DIAGNOSTICO'), 0, 'C', 0);
        $this->SetXY(172, 50);
        $this->SetFont('Arial', '', 12);
        $this->Cell(30, 4.5, utf8_decode(self::$incapacidad['diagnostico_id']), 0, 1, 'C');
        $this->SetXY(8, 61.5);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(90, 2, utf8_decode('LUGAR DE EXPEDICIÓN'), 0, 1, 'L');
        $this->SetXY(8, 64.5);
        $this->SetFont('Arial', '', 8);
        $this->Cell(10, 7, utf8_decode('BOGOTA DC'), 0, 1, 'L');
        $this->Line(102, 60, 102, 70);
        $this->SetFont('Arial', 'B', 8);
        $this->SetXY(105, 61);
        $fechaExpedicion = explode('-', self::$incapacidad['created_at']);
        $this->MultiCell(20, 4, utf8_decode('FECHA DE EXPEDICIÓN'), 0, 'C', 0);
        $this->SetFont('Arial', 'B', 6.5);
        $this->SetXY(125, 61.5);
        $this->Cell(10, 3, utf8_decode('DÍA'), 1, 1, 'C');
        $this->SetXY(135, 61.5);
        $this->Cell(10, 3, utf8_decode('MES'), 1, 1, 'C');
        $this->SetXY(145, 61.5);
        $this->Cell(10, 3, utf8_decode('AÑO'), 1, 1, 'C');
        $this->SetXY(125, 64.5);
        $this->Cell(10, 4.5, utf8_decode(substr($fechaExpedicion[2], 0, 2)), 1, 1, 'C');
        $this->SetXY(135, 64.5);
        $this->Cell(10, 4.5, utf8_decode($fechaExpedicion[1]), 1, 1, 'C');
        $this->SetXY(145, 64.5);
        $this->Cell(10, 4.5, utf8_decode($fechaExpedicion[0]), 1, 1, 'C');
        $this->Line(160, 60, 160, 70);
        $this->SetXY(163, 61.5);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(90, 2, utf8_decode('TOTAL DÍAS ACUMULADOS'), 0, 1, 'L');
        $this->SetXY(163, 64.5);
        $this->SetFont('Arial', '', 12);
        $this->Cell(40, 5, utf8_decode('0'), 0, 1, 'C');
        $this->Line(5, 70, 205, 70);
        $this->SetXY(8, 71.5);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(90, 2, utf8_decode('INCAPACIDAD POR:'), 0, 1, 'L');
        $this->SetXY(45, 76);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(90, 2, utf8_decode('ENFERMEDAD GENERAL'), 0, 1, 'L');
        $this->SetXY(83, 74);
        $this->SetFont('Arial', '', 12);
        $this->Cell(8, 5, utf8_decode(self::$incapacidad['contingencia'] === 'Enf. Comun' ? 'X' : ''), 1, 1, 'C');
        $this->SetXY(42, 85);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(90, 2, utf8_decode('LICENCIA DE MATERNIDAD'), 0, 1, 'L');
        $this->SetXY(83, 83);
        $this->SetFont('Arial', '', 12);
        $this->Cell(8, 5, utf8_decode(self::$incapacidad['contingencia'] === 'Licencia de Maternidad' ? 'X' : ''), 1, 1, 'C');
        $this->SetXY(110, 73);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(90, 2, utf8_decode('LICENCIA DE PATERNIDAD'), 0, 1, 'L');
        $this->SetXY(150, 71.5);
        $this->SetFont('Arial', '', 12);
        $this->Cell(8, 5, utf8_decode(self::$incapacidad['contingencia'] === 'Licencia de Paternidad' ? 'X' : ''), 1, 1, 'C');
        $this->SetXY(106, 79.5);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(90, 2, utf8_decode('ENFERMEDAD PROFESIONAL'), 0, 1, 'L');
        $this->SetXY(150, 77.5);
        $this->SetFont('Arial', '', 12);
        $this->Cell(8, 5, utf8_decode(self::$incapacidad['contingencia'] === 'Enfermedad Profesional' ? 'X' : ''), 1, 1, 'C');
        $this->SetXY(111, 85.5);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(90, 2, utf8_decode('ACCIDENTE DE TRABAJO'), 0, 1, 'L');
        $this->SetXY(150, 83.5);
        $this->SetFont('Arial', '', 12);
        $this->Cell(8, 5, utf8_decode(self::$incapacidad['contingencia'] === 'Accidente de trabajo' ? 'X' : ''), 1, 1, 'C');
        $this->Line(5, 90, 205, 90);
        $this->SetXY(8, 91.5);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(90, 2, utf8_decode('FIRMA DEL MEDICO RESPONSABLE F.P.S.F.C.N.'), 0, 1, 'L');
        $this->SetXY(140, 95);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(90, 2, utf8_decode('REGISTRO MÉDICO F.P.S.F.C.N.'), 0, 1, 'L');
    }
    public function footer()
    {
        $this->Line(5, 120, 205, 120);
        $this->SetXY(8, 121.5);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(90, 2, utf8_decode('INFORMACIÓN PERSONA QUE RECIBE EL CERTIFICADO'), 0, 1, 'L');
        $this->SetXY(8, 124.5);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(90, 2, utf8_decode('NOMBRE'), 0, 1, 'L');

        $this->SetXY(118, 122);
        $this->Cell(10, 12, utf8_decode(''), 1, 1, 'C');
        $this->SetXY(118, 122);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(10, 5, utf8_decode('DÍA'), 0, 1, 'C');
        $this->SetXY(118, 127);
        $this->SetFont('Arial', '', 12);
        $this->Cell(10, 7, utf8_decode(date('d')), 0, 1, 'C');
        $this->SetXY(128, 122);
        $this->Cell(10, 12, utf8_decode(''), 1, 1, 'C');
        $this->SetXY(128, 122);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(10, 5, utf8_decode('MES'), 0, 1, 'C');
        $this->SetXY(128, 127);
        $this->SetFont('Arial', '', 12);
        $this->Cell(10, 7, utf8_decode(date('m')), 0, 1, 'C');
        $this->SetXY(138.1, 122);
        $this->Cell(13, 12, utf8_decode(''), 1, 1, 'C');
        $this->SetXY(138, 122);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(13, 5, utf8_decode('AÑO'), 0, 1, 'C');
        $this->SetXY(138, 127);
        $this->SetFont('Arial', '', 12);
        $this->Cell(13, 7, utf8_decode(date('Y')), 0, 1, 'C');
        $this->SetXY(152, 132);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(90, 2, utf8_decode('TELÉFONO:'), 0, 1, 'L');

        $this->Line(170, 134, 205, 134);

        $this->SetXY(8, 138);
        $this->SetFont('Arial', 'B', 8);
        $this->MultiCell(190, 3, utf8_decode('BAJO LAS SANCIONES PENALES QUE SEÑALAN LA LEY, ESTE DOCUMENTO NO PUEDE SER USADO SINO POR EL PERSONAL AUTORIZADO PARA ELLO, POR EL FONDO DE PASIVO SOCIAL DE FERROCARRILES NACIONALES DE COLOMBIA.'), 0, 'C', 0);
    }

    function RoundedRect($x, $y, $w, $h, $r, $style = '')
    {
        $k = $this->k;
        $hp = $this->h;
        if ($style == 'F')
            $op = 'f';
        elseif ($style == 'FD' || $style == 'DF')
            $op = 'B';
        else
            $op = 'S';
        $MyArc = 4 / 3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2F %.2F m', ($x + $r) * $k, ($hp - $y) * $k));
        $xc = $x + $w - $r;
        $yc = $y + $r;
        $this->_out(sprintf('%.2F %.2F l', $xc * $k, ($hp - $y) * $k));

        $this->_Arc($xc + $r * $MyArc, $yc - $r, $xc + $r, $yc - $r * $MyArc, $xc + $r, $yc);
        $xc = $x + $w - $r;
        $yc = $y + $h - $r;
        $this->_out(sprintf('%.2F %.2F l', ($x + $w) * $k, ($hp - $yc) * $k));
        $this->_Arc($xc + $r, $yc + $r * $MyArc, $xc + $r * $MyArc, $yc + $r, $xc, $yc + $r);
        $xc = $x + $r;
        $yc = $y + $h - $r;
        $this->_out(sprintf('%.2F %.2F l', $xc * $k, ($hp - ($y + $h)) * $k));
        $this->_Arc($xc - $r * $MyArc, $yc + $r, $xc - $r, $yc + $r * $MyArc, $xc - $r, $yc);
        $xc = $x + $r;
        $yc = $y + $r;
        $this->_out(sprintf('%.2F %.2F l', ($x) * $k, ($hp - $yc) * $k));
        $this->_Arc($xc - $r, $yc - $r * $MyArc, $xc - $r * $MyArc, $yc - $r, $xc, $yc - $r);
        $this->_out($op);
    }

    function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
    {
        $h = $this->h;
        $this->_out(sprintf(
            '%.2F %.2F %.2F %.2F %.2F %.2F c ',
            $x1 * $this->k,
            ($h - $y1) * $this->k,
            $x2 * $this->k,
            ($h - $y2) * $this->k,
            $x3 * $this->k,
            ($h - $y3) * $this->k
        ));
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
}
