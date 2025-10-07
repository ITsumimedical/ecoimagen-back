<?php

namespace App\Formats;

use App\Traits\PdfTrait;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Str;

class AnalisisCasos extends FPDF
{
    use PdfTrait;

    public static $eventos;
    public static $acciones_seguras;
    public static $analisisEvento;
    public static $accionesMejorasEventos;
    // public static $acciones_mejoras;

    public function generar($analisisCasos)
    {
        self::$eventos = $analisisCasos->eventosAdvero;
        self::$acciones_seguras = $analisisCasos->accionesSeguras;
        self::$analisisEvento = $analisisCasos->analisisEvento;
        self::$accionesMejorasEventos = $analisisCasos->accionesMejorasEventos;
        $this->generarPDF('I');
    }

    public function header()
    {
        $this->SetDrawColor(140, 190, 56);
        $this->Rect(5, 5, 200, 287);
        $this->SetDrawColor(0, 0, 0);

        $this->Line(12, 12, 198, 12);
        $this->Line(12, 12, 12, 35);
        $this->Line(12, 35, 198, 35);
        $this->Line(198, 12, 198, 35);
        $this->Line(159, 12, 159, 35);
        $this->Line(50, 12, 50, 35);
        $this->Line(159, 19, 198, 19);
        $this->Line(159, 25, 198, 25);


        $this->SetFont('Arial', 'B', 12);
        $this->SetXY(50, 22);
        $this->MultiCell(109, 4, utf8_decode("INFORME DE ANÁLISIS DE SUCESOS CLÍNICOS"), 0, 'C');
        $logo = public_path() . "/images/logo.png";
        $this->Image($logo, 16, 14, -320);

        $this->SetXY(160, 14);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(15, 4, utf8_decode("Código:"));
        $this->SetFont('Arial', '', 10);
        $this->Cell(20, 4, " FO-GC-049");

        $this->SetXY(160, 20);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(15, 4, utf8_decode("Versión:"));
        $this->SetFont('Arial', '', 10);
        $this->Cell(10, 4, "02");

        $this->SetXY(160, 26);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(20, 4, utf8_decode("Fecha de aprobación:"));
        $this->SetXY(160, 30);
        $this->SetFont('Arial', '', 10);
        $this->Cell(20, 4, "18/04/2022");
        $this->ln();
        $this->ln();
        $this->ln();
    }

    public function footer()
    {
        $this->SetXY(190, 287);
        $this->Cell(10, 4, utf8_decode('Página ') . $this->PageNo() . ' de {nb}', 0, 0, 'C');
    }

    public function body()
    {

        $this->SetFont('Arial', 'B', 10);
        $this->SetX(12);
        $this->SetFillColor(74, 152, 86);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(186, 6, utf8_decode('INFORMACIÓN GENERAL'), 1, 1, 'C', 1);
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0, 0, 0);

        $this->SetX(12);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(31, 4, utf8_decode('RADICADO'), 1, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(30, 4, utf8_decode(self::$eventos->id), 1, 0, 'L');

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(31, 4, utf8_decode('SUCESO'), 1, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(94, 4, utf8_decode(self::$eventos->suceso_nombre ?? 'N/A'), 1, 0, 'L');
        $this->Ln();

        if (!empty(self::$eventos->clasificacion_area_nombre)) {
            $this->SetFont('Arial', 'B', 7);
            $this->cell(2);
            $this->Cell(31, 4, utf8_decode('CLASIFICACIÓN ÁREA'), 1, 0, 'L');
            $this->SetFont('Arial', '', 7);
            $this->Cell(155, 4, utf8_decode(self::$eventos->clasificacion_area_nombre), 1, 0, 'L');
            $this->Ln();
        }

        if (!empty(self::$eventos->tipo_evento_nombre)) {
            $this->SetX(12);
            $this->SetFont('Arial', 'B', 7);
            $this->Cell(31, 4, utf8_decode('TIPO EVENTO'), 1, 0, 'L');
            $this->SetFont('Arial', '', 7);
            $this->Cell(155, 4, utf8_decode(self::$eventos->tipo_evento_nombre), 1, 0, 'L');
            $this->Ln();
        }

        $this->SetX(12);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(31, 4, utf8_decode('NOMBRE COMPLETO'), 1, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(55, 4, utf8_decode(self::$eventos->nombre_afiliado), 1, 0, 'L');

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(31, 4, utf8_decode('IDENTIFICACIÓN'), 1, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(31, 4, utf8_decode(self::$eventos->numero_documento), 1, 0, 'L');

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(20, 4, utf8_decode('EDAD'), 1, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(18, 4, utf8_decode(self::$eventos->edad_cumplida . ' Años'), 1, 0, 'L');
        $this->Ln();

        $this->SetX(12);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(31, 4, utf8_decode('SEDE OCURRENCIA'), 1, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(80, 4, utf8_decode(self::$eventos->sedeOcurrencia), 1, 0, 'L');

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(25, 4, utf8_decode('SERVICIO'), 1, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(50, 4, utf8_decode(self::$eventos->servicio_ocurrencia ?? 'N/A'), 1, 0, 'L');
        $this->Ln();

        $this->SetX(12);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(31, 4, utf8_decode('FECHA DE REPORTE'), 1, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(31, 4, utf8_decode(self::$eventos->created_at), 1, 0, 'L');

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(34, 4, utf8_decode('FECHA DE OCURRENCIA'), 1, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(28, 4, utf8_decode(self::$eventos->fecha_ocurrencia), 1, 0, 'L');

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(31, 4, utf8_decode('FECHA DE ANÁLISIS'), 1, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(31, 4, utf8_decode(self::$eventos->fecha_analisis), 1, 0, 'L');
        $this->Ln();


        $this->Ln();

        if (self::$eventos->suceso_id == 139) {
            $this->SetFont('Arial', 'B', 10);
            $this->SetX(12);
            $this->SetFillColor(74, 152, 86);
            $this->SetTextColor(255, 255, 255);
            $this->Cell(186, 6, utf8_decode('DISPOSITIVO'), 1, 1, 'C', 1);
            $this->SetFillColor(255, 255, 255);
            $this->SetTextColor(0, 0, 0);
            $this->SetX(12);
            $this->SetFont('Arial', 'B', 7);
            $this->Cell(31, 4, utf8_decode('DISPOSITIVO'), 1, 0, 'l');
            $this->SetFont('Arial', '', 7);
            $this->Cell(55, 4, utf8_decode(self::$eventos->dispositivo), 1, 0, 'l');
            $this->SetFont('Arial', 'B', 7);
            $this->Cell(25, 4, utf8_decode('REFERENCIA'), 1, 0, 'l');
            $this->SetFont('Arial', '', 7);
            $this->Cell(25, 4, utf8_decode(self::$eventos->referencia_dispositivo), 1, 0, 'l');
            $this->SetFont('Arial', 'B', 7);
            $this->Cell(25, 4, utf8_decode('MARCA'), 1, 0, 'l');
            $this->SetFont('Arial', '', 7);
            $this->Cell(25, 4, utf8_decode(self::$eventos->marca_dispositivo), 1, 0, 'l');
            $this->Ln();
            $this->SetX(12);
            $this->SetFont('Arial', 'B', 7);
            $this->Cell(31, 4, utf8_decode('LOTE'), 1, 0, 'l');
            $this->SetFont('Arial', '', 7);
            $this->Cell(55, 4, utf8_decode(self::$eventos->lote_dispositivo), 1, 0, 'l');
            $this->SetFont('Arial', 'B', 7);
            $this->Cell(25, 4, utf8_decode('INVIMA'), 1, 0, 'l');
            $this->SetFont('Arial', '', 7);
            $this->Cell(25, 4, utf8_decode(self::$eventos->invima_dispositivo), 1, 0, 'l');
            $this->SetFont('Arial', 'B', 7);
            $this->Cell(25, 4, utf8_decode('FABRICANTE'), 1, 0, 'l');
            $this->SetFont('Arial', '', 7);
            $this->Cell(25, 4, utf8_decode(self::$eventos->fabricante_dispositivo), 1, 0, 'l');
            $this->Ln();
        }
        $this->Ln();
        if (self::$eventos->suceso_id == 139) {
            $this->SetFont('Arial', 'B', 10);
            $this->SetX(12);
            $this->SetFillColor(74, 152, 86);
            $this->SetTextColor(255, 255, 255);
            $this->Cell(186, 6, utf8_decode('EQUIPO BIOMÉDICO'), 1, 1, 'C', 1);
            $this->SetFillColor(255, 255, 255);
            $this->SetTextColor(0, 0, 0);
            $this->SetX(12);
            $this->SetFont('Arial', 'B', 7);
            $this->Cell(31, 4, utf8_decode('NOMBRE'), 1, 0, 'l');
            $this->SetFont('Arial', '', 7);
            $this->Cell(55, 4, utf8_decode(self::$eventos->nombre_equipo_biomedico), 1, 0, 'l');
            $this->SetFont('Arial', 'B', 7);
            $this->Cell(25, 4, utf8_decode('MARCA'), 1, 0, 'l');
            $this->SetFont('Arial', '', 7);
            $this->Cell(25, 4, utf8_decode(self::$eventos->marca_equipo_biomedico), 1, 0, 'l');
            $this->SetFont('Arial', 'B', 7);
            $this->Cell(25, 4, utf8_decode('INVIMA'), 1, 0, 'l');
            $this->SetFont('Arial', '', 7);
            $this->Cell(25, 4, utf8_decode(self::$eventos->invima_equipo_biomedico), 1, 0, 'l');
            $this->Ln();
            $this->SetX(12);
            $this->SetFont('Arial', 'B', 7);
            $this->Cell(31, 4, utf8_decode('MODELO'), 1, 0, 'l');
            $this->SetFont('Arial', '', 7);
            $this->Cell(55, 4, utf8_decode(self::$eventos->modelo_equipo_biomedico), 1, 0, 'l');
            $this->SetFont('Arial', 'B', 7);
            $this->Cell(25, 4, utf8_decode('SERIE'), 1, 0, 'l');
            $this->SetFont('Arial', '', 7);
            $this->Cell(25, 4, utf8_decode(self::$eventos->serie_equipo_biomedico), 1, 0, 'l');
            $this->SetFont('Arial', 'B', 7);
            $this->Cell(25, 4, utf8_decode('FABRICANTE'), 1, 0, 'l');
            $this->SetFont('Arial', '', 7);
            $this->Cell(25, 4, utf8_decode(self::$eventos->fabricante_biomedico), 1, 0, 'l');
            $this->Ln();
        }
        $this->SetFont('Arial', 'B', 10);
        $this->SetX(12);
        $this->SetFillColor(74, 152, 86);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(186, 6, utf8_decode('DESCRIPCIÓN DE LOS HECHOS'), 1, 1, 'C', 1);
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0, 0, 0);
        $this->SetX(12);
        $this->SetFont('Arial', '', 8);
        $this->MultiCell(186, 4, utf8_decode(self::$eventos->descripcion_hechos), 1, 'J');
        $this->SetFont('Arial', 'B', 10);
        $this->SetX(12);
        $this->SetFillColor(74, 152, 86);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(186, 6, utf8_decode('ACCIONES TOMADAS'), 1, 1, 'C', 1);
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0, 0, 0);
        $this->SetX(12);
        $this->SetFont('Arial', '', 8);
        $this->MultiCell(186, 4, utf8_decode(self::$eventos->accion_tomada), 1, 'J');
        $this->SetFont('Arial', 'B', 10);
        $this->SetX(12);
        $this->SetFillColor(74, 152, 86);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(186, 6, utf8_decode('ANÁLISIS'), 1, 1, 'C', 1);
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0, 0, 0);
        $this->SetX(12);
        $this->SetFont('Arial', '', 8);
        $this->MultiCell(186, 4, utf8_decode(self::$eventos->cronologia_suceso), 1, 'J');
        if (self::$eventos->suceso_id == 139) {
            $this->SetX(12);
            $this->SetFont('Arial', '', 8);
            $this->MultiCell(186, 4, utf8_decode('Clasifiacion tecnovigilancia: ' . self::$eventos->clasif_tecnovigilancia), 1, 'J');
        }

        $this->SetFont('Arial', 'B', 10);
        $this->SetX(12);
        $this->SetFillColor(74, 152, 86);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(186, 6, utf8_decode('ANÁLISIS CAUSAL DEL CASO'), 1, 1, 'C', 1);
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0, 0, 0);
        $this->SetX(12);
        $this->SetFont('Arial', '', 9);
        $this->MultiCell(186, 4, utf8_decode('Metodología de análisis: ' . self::$eventos->metodologia_analisis), 1, 'L');
        $y = $this->GetY();
        if ($y > 220) {
            $this->AddPage();
            $y = 15;
        }

        if (Str::lower(self::$eventos->metodologia_analisis) == 'protocolo de londres') {
            $n = 0;
            foreach (self::$acciones_seguras as $acciones_segura) {
                $n += 1;
                $y = $this->GetY();
                $this->SetFont('Arial', 'B', 8);
                $this->Cell(2);
                $this->MultiCell(73, 7, utf8_decode('ACCIÓN INSEGURA ' . $n . ': ' . $acciones_segura->nombre), 0, 'L');

                $this->SetXY(85, $y);
                $this->SetFillColor(106, 193, 34);
                $this->SetTextColor(255, 255, 255);
                $this->Cell(113, 6, utf8_decode('Factores Contributivos'), 1, 1, 'C', 1);
                $this->SetFillColor(255, 255, 255);
                $this->SetTextColor(0, 0, 0);
                $y7 = $this->GetY();

                $this->SetFont('Arial', '', 9);
                $this->SetXY(85, $y + 8);
                $this->MultiCell(30, 4, utf8_decode('Condiciones del Paciente: '), 0, 'L');
                $y9 = $this->GetY();
                $acciones_segura['condiciones_paciente'] = str_replace(array('[', ']', '"'), array('', '', ''), $acciones_segura['condiciones_paciente']);
                $this->SetFont('Arial', '', 9);
                $this->SetXY(120, $y + 8);
                $this->MultiCell(70, 4, utf8_decode($acciones_segura['condiciones_paciente'] == null ? 'No Aplica' : $acciones_segura['condiciones_paciente']), 0, 'L');
                $y8 = $this->GetY();
                $linea1 = max($y8, $y9);

                $this->SetXY(85, $linea1 + 4);
                $this->MultiCell(70, 4, utf8_decode('Métodos / Procesos: '), 0, 'L');
                $acciones_segura['metodos'] = str_replace(array('[', ']', '"'), array('', '', ''), $acciones_segura['metodos']);
                $this->SetXY(120, $linea1 + 4);
                $this->MultiCell(70, 4, utf8_decode($acciones_segura['metodos'] == null ? 'No Aplica' : $acciones_segura['metodos']), 0, 'L');
                $y1 = $this->GetY();

                $this->SetXY(85, $y1 + 4);
                $this->MultiCell(25, 4, utf8_decode('Colaborador / Individuo: '), 0, 'L');
                $y10 = $this->GetY();
                $acciones_segura['colaborador'] = str_replace(array('[', ']', '"'), array('', '', ''), $acciones_segura['colaborador']);
                $this->SetXY(120, $y1 + 4);
                $this->MultiCell(70, 4, utf8_decode($acciones_segura['colaborador'] == null ? 'No Aplica' : $acciones_segura['colaborador']), 0, 'L');
                $y2 = $this->GetY();
                $linea2 = max($y10, $y2);

                $this->SetXY(85, $linea2 + 4);
                $this->MultiCell(70, 4, utf8_decode('Equipo de trabajo: '), 0, 'L');
                $acciones_segura['equipo_trabajo'] = str_replace(array('[', ']', '"'), array('', '', ''), $acciones_segura['equipo_trabajo']);
                $this->SetXY(120, $linea2 + 4);
                $this->MultiCell(70, 4, utf8_decode($acciones_segura['equipo_trabajo'] == null ? 'No Aplica' : $acciones_segura['equipo_trabajo']), 0, 'L');
                $y3 = $this->GetY();

                $this->SetXY(85, $y3 + 4);
                $this->MultiCell(70, 4, utf8_decode('Ambiente: '), 0, 'L');
                $acciones_segura['ambiente'] = str_replace(array('[', ']', '"'), array('', '', ''), $acciones_segura['ambiente']);
                $this->SetXY(120, $y3 + 4);
                $this->MultiCell(70, 4, utf8_decode($acciones_segura['ambiente'] == null ? 'No Aplica' : $acciones_segura['ambiente']), 0, 'L');
                $y4 = $this->GetY();

                $this->SetXY(85, $y4 + 4);
                $this->MultiCell(30, 4, utf8_decode('Recursos / Materiales / Insumos: '), 0, 'L');
                $y12 = $this->GetY();
                $acciones_segura['recursos'] = str_replace(array('[', ']', '"'), array('', '', ''), $acciones_segura['recursos']);
                $this->SetXY(120, $y4 + 4);
                $this->MultiCell(70, 4, utf8_decode($acciones_segura['recursos'] == null ? 'No Aplica' : $acciones_segura['recursos']), 0, 'L');
                $y5 = $this->GetY();
                $linea3 = max($y5, $y12);

                $this->SetXY(85, $linea3 + 4);
                $this->MultiCell(70, 4, utf8_decode('Contexto institucional: '), 0, 'L');
                $acciones_segura['contexto'] = str_replace(array('[', ']', '"'), array('', '', ''), $acciones_segura['contexto']);
                $this->SetXY(120, $linea3 + 4);
                $this->MultiCell(70, 4, utf8_decode($acciones_segura['contexto'] == null ? 'No Aplica' : $acciones_segura['contexto']), 0, 'L');
                $y6 = $this->GetY();
                $conteoY = max($y1, $y2, $y3, $y4, $y5, $linea3, $y6);
                $this->Ln();
                $this->Line(12, $conteoY, 12, $y);
                $this->Line(198, $conteoY, 198, $y);
                $this->Line(12, $conteoY, 198, $conteoY);
                $this->Line(85, $y, 85, $conteoY);
                $this->Line(118, $y7, 118, $conteoY);

                $this->Line(85, $y1 + 2, 198, $y1 + 2);
                $this->Line(85, $linea2 + 2, 198, $linea2 + 2);
                $this->Line(85, $y3 + 2, 198, $y3 + 2);
                $this->Line(85, $y4 + 2, 198, $y4 + 2);
                $this->Line(85, $linea3 + 2, 198, $linea3 + 2);

                if ($conteoY > 220) {
                    $this->AddPage();
                    $y = 15;
                }
            }
        }

        if (self::$eventos->metodologia_analisis == 'Respuesta inmediata') {

            $this->SetFont('Arial', 'B', 10);
            $this->SetX(12);
            $this->SetFillColor(74, 152, 86);
            $this->SetTextColor(255, 255, 255);
            $this->Cell(186, 6, utf8_decode('RESPUESTA INMEDIATA'), 1, 1, 'C', 1);
            $this->SetFillColor(255, 255, 255);
            $this->SetTextColor(0, 0, 0);
            $y = $this->GetY();

            if ($y > 220) {
                $this->AddPage();
                $y = 15;
            }

            $this->SetFont('Arial', '', 9);
            $this->SetX(12);
            $this->MultiCell(186, 4, utf8_decode('Qué fallo: ' . self::$eventos->que_fallo), 1, 'L');

            if ($y > 220) {
                $this->AddPage();
                $y = 15;
            }

            $this->SetFont('Arial', '', 9);
            $this->SetX(12);
            $this->MultiCell(186, 4, utf8_decode('Cómo / por qué falló: ' . self::$eventos->como_fallo), 1, 'L');

            if ($y > 220) {
                $this->AddPage();
                $y = 15;
            }

            $this->SetFont('Arial', '', 9);
            $this->SetX(12);
            $this->MultiCell(186, 4, utf8_decode('Qué causó: ' . self::$eventos->que_causo), 1, 'L');

            if ($y > 220) {
                $this->AddPage();
                $y = 15;
            }

            $this->SetFont('Arial', '', 9);
            $this->SetX(12);
            $this->MultiCell(186, 4, utf8_decode('Qué plan de acción se implementó: ' . self::$eventos->plan_accion), 1, 'L');
            $this->Ln();

            if ($y > 220) {
                $this->AddPage();
                $y = 15;
            }
        }

        if (self::$eventos->analisis_id) {

            if (self::$analisisEvento && self::$analisisEvento->metodologia_analisis_farmaco) {
                $this->SetFont('Arial', 'B', 10);
                $this->SetX(12);
                $this->SetFillColor(74, 152, 86);
                $this->SetTextColor(255, 255, 255);
                $this->Cell(186, 6, utf8_decode('ANÁLISIS FARMACOLÓGICO'), 1, 1, 'C', 1);

                $this->SetFillColor(255, 255, 255);
                $this->SetTextColor(0, 0, 0);
                $this->SetX(12);
                $this->SetFont('Arial', '', 8);
                $this->MultiCell(186, 4, utf8_decode(self::$analisisEvento->metodologia_analisis_farmaco), 1, 'J');
                $this->SetFont('Arial', 'B', 9);
                if(self::$analisisEvento->metodologia_analisis_farmaco === 'Metodología AMEF'){
                    $this->SetFont('Arial', 'B',9);
                    $this->SetX(12);
                    $this->SetFillColor(74, 152, 86);
                    $this->SetTextColor(255, 255, 255);
                    $this->Cell(186, 6, utf8_decode('ELEMENTO'), 1, 1, 'C', 1);


                    $this->SetFillColor(255, 255, 255);
                    $this->SetTextColor(0, 0, 0);
                    $this->SetX(12);
                    $this->SetFont('Arial', '', 9);
                    $this->MultiCell(186, 5, utf8_decode(self::$analisisEvento->elemento_funcion?? 'No Aplica'), 1, 0, 'L');

                    $this->SetFont('Arial', 'B',9);
                    $this->SetX(12);
                    $this->SetFillColor(74, 152, 86);
                    $this->SetTextColor(255, 255, 255);
                    $this->Cell(186, 6, utf8_decode('MODO FALLO'), 1, 1, 'C', 1);

                    $this->SetFillColor(255, 255, 255);
                    $this->SetTextColor(0, 0, 0);
                    $this->SetX(12);
                    $this->SetFont('Arial', '', 9);
                    $this->MultiCell(186, 5, utf8_decode(self::$analisisEvento->modo_fallo?? 'No Aplica'), 1, 0, 'L');


                    $this->SetFont('Arial', 'B',9);
                    $this->SetX(12);
                    $this->SetFillColor(74, 152, 86);
                    $this->SetTextColor(255, 255, 255);
                    $this->Cell(186, 6, utf8_decode('EFECTO'), 1, 1, 'C', 1);


                    $this->SetFillColor(255, 255, 255);
                    $this->SetTextColor(0, 0, 0);
                    $this->SetX(12);
                    $this->SetFont('Arial', '', 9);
                    $this->MultiCell(186, 5, utf8_decode(self::$analisisEvento->efecto ?? 'No Aplica'), 1, 0, 'L');


                    $this->SetFont('Arial', 'B',9);
                    $this->SetX(12);
                    $this->SetFillColor(74, 152, 86);
                    $this->SetTextColor(255, 255, 255);
                    $this->Cell(186, 6, utf8_decode('NPR'), 1, 1, 'C', 1);


                    $this->SetFillColor(255, 255, 255);
                    $this->SetTextColor(0, 0, 0);
                    $this->SetX(12);
                    $this->SetFont('Arial', '', 9);
                    $this->MultiCell(186, 5, utf8_decode(self::$analisisEvento->npr ?? 'No Aplica'), 1, 'C', 'L');


                    $this->SetFont('Arial', 'B',9);
                    $this->SetX(12);
                    $this->SetFillColor(74, 152, 86);
                    $this->SetTextColor(255, 255, 255);
                    $this->Cell(186, 6, utf8_decode('ACCIONES PROPUESTAS'), 1, 1, 'C', 1);


                    $this->SetFillColor(255, 255, 255);
                    $this->SetTextColor(0, 0, 0);
                    $this->SetX(12);
                    $this->SetFont('Arial', '', 9);
                    $this->MultiCell(186, 5, utf8_decode(self::$analisisEvento->acciones_propuestas ?? 'No Aplica'), 1, 'L');
                    $this->Ln();
                }elseif(self::$analisisEvento->metodologia_analisis_farmaco === 'FT - VACA-DELASSALA'){
                    $this->SetX(12);
                    $this->SetFont('Arial', 'B', 9);
                    $this->Cell(60, 6, utf8_decode('Evaluación de Causalidad:'), 1, 0, 'L', 0);
                    $this->SetFont('Arial', '', 9);
                    $this->Cell(126, 6, utf8_decode(self::$analisisEvento->evaluacion_causalidad ?? 'No Aplica'), 1, 1, 'L', 0);

                    $this->SetX(12);
                    $this->SetFont('Arial', 'B', 9);
                    $this->Cell(60, 6, utf8_decode('Clasificación INVIMA:'), 1, 0, 'L', 0);
                    $this->SetFont('Arial', '', 9);
                    $this->Cell(126, 6, utf8_decode(self::$analisisEvento->clasificacion_invima ?? 'No Aplica'), 1, 1, 'L', 0);
                    if ($y > 220) {
                        $this->AddPage();
                        $y = 15;
                    }
                    $this->SetX(12);
                    $this->SetFont('Arial', 'B', 9);
                    $y = $this->GetY();
                    $this->MultiCell(60, 6, utf8_decode('Se presenta evento después de la administración de medicamento:'), 1, 'L');
                    $this->SetXY(72, $y);
                    $this->SetFont('Arial', '', 9);
                    $this->Cell(126, 12, utf8_decode(self::$analisisEvento->administrar_medicamento_evento ?? 'No Aplica'), 1, 0, 'L', 0);
                    $this->Ln();
                    if ($y > 220) {
                        $this->AddPage();
                        $y = 15;
                    }

                    $this->SetX(12);
                    $this->SetFont('Arial', 'B', 9);
                    $y = $this->GetY();
                    $this->MultiCell(60, 6, utf8_decode('Existen otros factores para explicar el evento'), 1, 'L');
                    $this->SetXY(72, $y);
                    $this->SetFont('Arial', '', 9);
                    $this->Cell(126, 12, utf8_decode(self::$analisisEvento->factores_explicar_evento ?? 'No Aplica'), 1, 0, 'L', 0);
                    $this->Ln();
                    if ($y > 220) {
                        $this->AddPage();
                        $y = 15;
                    }
                    $this->SetX(12);
                    $this->SetFont('Arial', 'B', 9);
                    $y = $this->GetY();
                    $this->MultiCell(60, 6, utf8_decode('¿El evento desapareció al disminuir o suspender el medicamento sospechoso?'), 1, 'L');
                    $this->SetXY(72, $y);
                    $this->SetFont('Arial', '', 9);
                    $this->Cell(126, 18, utf8_decode(self::$analisisEvento->evento_desaparecio_suspender_medicamento ?? 'No Aplica'), 1, 0, 'L', 0);
                    $this->Ln();
                    if ($y > 220) {
                        $this->AddPage();
                        $y = 15;
                    }
                    $this->SetX(12);
                    $this->SetFont('Arial', 'B', 9);
                    $y = $this->GetY();
                    $this->MultiCell(60, 6, utf8_decode('¿El paciente ya había presentado la misma reacción al medicamento sospechoso?'), 1, 'L');
                    $this->SetXY(72, $y);
                    $this->SetFont('Arial', '', 9);
                    $this->Cell(126, 18, utf8_decode(self::$analisisEvento->paciente_presenta_misma_reaccion ?? 'No Aplica'), 1, 0, 'L', 0);
                    $this->Ln();
                    if ($y > 220) {
                        $this->AddPage();
                        $y = 15;
                    }
                    $this->SetX(12);
                    $this->SetFont('Arial', 'B', 9);
                    $y = $this->GetY();
                    $this->MultiCell(60, 6, utf8_decode('¿Se puede ampliar la información del paciente relacionado con el evento'), 1, 'L');
                    $this->SetXY(72, $y);
                    $this->SetFont('Arial', '', 9);
                    $this->Cell(126, 12, utf8_decode(self::$analisisEvento->ampliar_informacion_relacionada_evento ?? 'No Aplica'), 1, 0, 'L', 0);
                    $this->Ln();
                    if ($y > 220) {
                        $this->AddPage();
                        $y = 15;
                    }
                    $this->SetX(12);
                    $this->SetFont('Arial', 'B', 9);
                    $y = $this->GetY();
                    $this->MultiCell(60, 6, utf8_decode('¿El fallo terapéutico refiere a un fármaco de cinética compleja?'), 1, 'L');
                    $this->SetXY(72, $y);
                    $this->SetFont('Arial', '', 9);
                    $this->Cell(126, 12, utf8_decode(self::$analisisEvento->farmaco_cinetica ?? 'No Aplica'), 1, 0, 'L', 0);
                    $this->Ln();
                    if ($y > 220) {
                        $this->AddPage();
                        $y = 15;
                    }

                    $this->SetX(12);
                    $this->SetFont('Arial', 'B', 9);
                    $y = $this->GetY();
                    $this->MultiCell(60, 6, utf8_decode('¿El paciente presenta condiciones que alteren la farmacocinética?'), 1, 'L');
                    $this->SetXY(72, $y);
                    $this->SetFont('Arial', '', 9);
                    $this->Cell(126, 12, utf8_decode(self::$analisisEvento->condiciones_farmacocinetica ?? 'No Aplica'), 1, 0, 'L', 0);
                    $this->Ln();
                    if ($y > 220) {
                        $this->AddPage();
                        $y = 15;
                    }
                    $this->SetX(12);
                    $this->SetFont('Arial', 'B', 9);
                    $y = $this->GetY();
                    $this->MultiCell(60, 6, utf8_decode('¿El medicamento se prescribió de manera inadecuada?'), 1, 'L');
                    $this->SetXY(72, $y);
                    $this->SetFont('Arial', '', 9);
                    $this->Cell(126, 12, utf8_decode(self::$analisisEvento->prescribio_manerainadecuada ?? 'No Aplica'), 1, 0, 'L', 0);
                    $this->Ln();
                    if ($y > 220) {
                        $this->AddPage();
                        $y = 15;
                    }
                    $this->SetX(12);
                    $this->SetFont('Arial', 'B', 9);
                    $y = $this->GetY();
                    $this->MultiCell(60, 6, utf8_decode('¿El medicamento se usó de manera inadecuada?'), 1, 'L');
                    $this->SetXY(72, $y);
                    $this->SetFont('Arial', '', 9);
                    $this->Cell(126, 12, utf8_decode(self::$analisisEvento->medicamento_manerainadecuada ?? 'No Aplica'), 1, 0, 'L', 0);
                    $this->Ln();
                    if ($y > 220) {
                        $this->AddPage();
                        $y = 15;
                    }
                    $this->SetX(12);
                    $this->SetFont('Arial', 'B', 9);
                    $y = $this->GetY();
                    $this->MultiCell(60, 6, utf8_decode('¿La administración del medicamento requiere un entrenamiento especial?'), 1, 'L');
                    $this->SetXY(72, $y);
                    $this->SetFont('Arial', '', 9);
                    $this->Cell(126, 12, utf8_decode(self::$analisisEvento->medicamento_entrenamiento ?? 'No Aplica'), 1, 0, 'L', 0);
                    $this->Ln();
                    if ($y > 220) {
                        $this->AddPage();
                        $y = 15;
                    }
                    $this->SetX(12);
                    $this->SetFont('Arial', 'B', 9);
                    $y = $this->GetY();
                    $this->MultiCell(60, 6, utf8_decode('¿Existen potenciales interacciones?'), 1, 'L');
                    $this->SetXY(72, $y);
                    $this->SetFont('Arial', '', 9);
                    $this->Cell(126, 6, utf8_decode(self::$analisisEvento->potenciales_interacciones ?? 'No Aplica'), 1, 0, 'L', 0);
                    $this->Ln();
                    if ($y > 220) {
                        $this->AddPage();
                        $y = 15;
                    }
                    $this->SetX(12);
                    $this->SetFont('Arial', 'B', 9);
                    $y = $this->GetY();
                    $this->MultiCell(60, 6, utf8_decode('¿La notificación se refiere a un medicamento genérico?'), 1, 'L');
                    $this->SetXY(72, $y);
                    $this->SetFont('Arial', '', 9);
                    $this->Cell(126, 12, utf8_decode(self::$analisisEvento->notificacion_refieremedicamento ?? 'No Aplica'), 1, 0, 'L', 0);
                    $this->Ln();
                    if ($y > 220) {
                        $this->AddPage();
                        $y = 15;
                    }
                    $this->SetX(12);
                    $this->SetFont('Arial', 'B', 9);
                    $y = $this->GetY();
                    $this->MultiCell(60, 6, utf8_decode('¿Existe algún problema biofarmacéutico estudiado?'), 1, 'L');
                    $this->SetXY(72, $y);
                    $this->SetFont('Arial', '', 9);
                    $this->Cell(126, 12, utf8_decode(self::$analisisEvento->problema_biofarmaceutico ?? 'No Aplica'), 1, 0, 'L', 0);
                    $this->Ln();
                    if ($y > 220) {
                        $this->AddPage();
                        $y = 15;
                    }
                    $this->SetX(12);
                    $this->SetFont('Arial', 'B', 9);
                    $y = $this->GetY();
                    $this->MultiCell(60, 6, utf8_decode('¿Existen deficiencias en el almacenamiento del medicamento?'), 1, 'L');
                    $this->SetXY(72, $y);
                    $this->SetFont('Arial', '', 9);
                    $this->Cell(126, 12, utf8_decode(self::$analisisEvento->deficiencias_sistemas ?? 'No Aplica'), 1, 0, 'L', 0);
                    $this->Ln();
                    if ($y > 220) {
                        $this->AddPage();
                        $y = 15;
                    }
                    $this->SetX(12);
                    $this->SetFont('Arial', 'B', 9);
                    $y = $this->GetY();
                    $this->MultiCell(60, 6, utf8_decode('¿Existe algún problema biofarmacéutico estudiado?'), 1, 'L');
                    $this->SetXY(72, $y);
                    $this->SetFont('Arial', '', 9);
                    $this->Cell(126, 12, utf8_decode(self::$analisisEvento->problema_biofarmaceutico ?? 'No Aplica'), 1, 0, 'L', 0);
                    $this->Ln();
                    if ($y > 220) {
                        $this->AddPage();
                        $y = 15;
                    }
                    $this->SetX(12);
                    $this->SetFont('Arial', 'B', 9);
                    $y = $this->GetY();
                    $this->MultiCell(60, 6, utf8_decode('¿Existen otros factores asociados que expliquen el fallo terapéutico?'), 1, 'L');
                    $this->SetXY(72, $y);
                    $this->SetFont('Arial', '', 9);
                    $this->Cell(126, 12, utf8_decode(self::$analisisEvento->factores_asociados ?? 'No Aplica'), 1, 0, 'L', 0);
                    $this->Ln();
                    if ($y > 220) {
                        $this->AddPage();
                        $y = 15;
                    }
                    $this->SetX(12);
                    $this->SetFont('Arial', 'B', 9);
                    $this->Cell(60, 6, utf8_decode('Seriedad:'), 1, 0, 'L', 0);
                    $this->SetFont('Arial', '', 9);
                    $this->Cell(126, 6, utf8_decode(self::$analisisEvento->seriedad ?? 'No Aplica'), 1, 1, 'L', 0);
                }else{

                $this->SetX(12);
                $this->SetFont('Arial', 'B', 9);
                $this->Cell(60, 6, utf8_decode('Evaluación de Causalidad:'), 1, 0, 'L', 0);
                $this->SetFont('Arial', '', 9);
                $this->Cell(126, 6, utf8_decode(self::$analisisEvento->evaluacion_causalidad ?? 'No Aplica'), 1, 1, 'L', 0);

                $this->SetX(12);
                $this->SetFont('Arial', 'B', 9);
                $this->Cell(60, 6, utf8_decode('Clasificación INVIMA:'), 1, 0, 'L', 0);
                $this->SetFont('Arial', '', 9);
                $this->Cell(126, 6, utf8_decode(self::$analisisEvento->clasificacion_invima ?? 'No Aplica'), 1, 1, 'L', 0);

                $this->SetX(12);
                $this->SetFont('Arial', 'B', 9);
                $y = $this->GetY();
                $this->MultiCell(60, 6, utf8_decode('Se presenta evento después de la administración de medicamento:'), 1, 'L');
                $this->SetXY(72, $y);
                $this->SetFont('Arial', '', 9);
                $this->Cell(126, 12, utf8_decode(self::$analisisEvento->administrar_medicamento_evento ?? 'No Aplica'), 1, 0, 'L', 0);
                $this->Ln();
                if ($y > 220) {
                    $this->AddPage();
                    $y = 15;
                }

                $this->SetX(12);
                $this->SetFont('Arial', 'B', 9);
                $y = $this->GetY();
                $this->MultiCell(60, 6, utf8_decode('Existen otros factores para explicar el evento'), 1, 'L');
                $this->SetXY(72, $y);
                $this->SetFont('Arial', '', 9);
                $this->Cell(126, 12, utf8_decode(self::$analisisEvento->factores_explicar_evento ?? 'No Aplica'), 1, 0, 'L', 0);
                $this->Ln();

                if ($y > 220) {
                    $this->AddPage();
                    $y = 15;
                }
                $this->SetX(12);
                $this->SetFont('Arial', 'B', 9);
                $y = $this->GetY();
                $this->MultiCell(60, 6, utf8_decode('¿El evento desapareció al disminuir o suspender el medicamento sospechoso?'), 1, 'L');
                $this->SetXY(72, $y);
                $this->SetFont('Arial', '', 9);
                $this->Cell(126, 18, utf8_decode(self::$analisisEvento->evento_desaparecio_suspender_medicamento ?? 'No Aplica'), 1, 0, 'L', 0);
                $this->Ln();

                if ($y > 220) {
                    $this->AddPage();
                    $y = 15;
                }

                $this->SetX(12);
                $this->SetFont('Arial', 'B', 9);
                $y = $this->GetY();
                $this->MultiCell(60, 6, utf8_decode('¿El paciente ya había presentado la misma reacción al medicamento sospechoso?'), 1, 'L');
                $this->SetXY(72, $y);
                $this->SetFont('Arial', '', 9);
                $this->Cell(126, 18, utf8_decode(self::$analisisEvento->paciente_presenta_misma_reaccion ?? 'No Aplica'), 1, 0, 'L', 0);
                $this->Ln();

                if ($y > 220) {
                    $this->AddPage();
                    $y = 15;
                }

                $this->SetX(12);
                $this->SetFont('Arial', 'B', 9);
                $y = $this->GetY();
                $this->MultiCell(60, 6, utf8_decode('¿Se puede ampliar la información del paciente relacionado con el evento'), 1, 'L');
                $this->SetXY(72, $y);
                $this->SetFont('Arial', '', 9);
                $this->Cell(126, 12, utf8_decode(self::$analisisEvento->ampliar_informacion_relacionada_evento ?? 'No Aplica'), 1, 0, 'L', 0);
                $this->Ln();

                if ($y > 220) {
                    $this->AddPage();
                    $y = 15;
                }

                $this->SetX(12);
                $this->SetFont('Arial', 'B', 9);
                $this->Cell(60, 6, utf8_decode('Seriedad:'), 1, 0, 'L', 0);
                $this->SetFont('Arial', '', 9);
                $this->Cell(126, 6, utf8_decode(self::$analisisEvento->seriedad ?? 'No Aplica'), 1, 1, 'L', 0);
            }
            }
        }


        $this->SetFont('Arial', 'B', 10);
        $this->SetX(12);
        $this->SetFillColor(74, 152, 86);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(186, 6, utf8_decode('DESENLACE Y CONCLUSIONES'), 1, 1, 'C', 1);
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0, 0, 0);
        $this->SetX(12);
        $this->SetFont('Arial', '', 8);

        $contenido = self::$eventos->descripcion_consecuencias . "\n\nDesenlace del evento: " . (self::$analisisEvento->desenlace_evento ?? 'N/A');

        $this->MultiCell(186, 4, utf8_decode($contenido), 1, 'J');
        $this->SetFont('Arial', 'B', 9);



        $this->SetX(12);

        if (self::$eventos->accion_resarcimiento) {
            $this->SetFont('Arial', 'B', 10);
            $this->SetX(12);
            $this->SetFillColor(74, 152, 86);
            $this->SetTextColor(255, 255, 255);
            $this->Cell(186, 6, utf8_decode('RESARCIMIENTO'), 1, 1, 'C', 1);
            $this->SetFillColor(255, 255, 255);
            $this->SetTextColor(0, 0, 0);
            $this->SetX(12);
            $this->SetFont('Arial', '', 8);
            $this->MultiCell(186, 4, utf8_decode(self::$eventos->accion_resarcimiento), 1, 'J');
            $this->SetFont('Arial', 'B', 9);
        }
        $this->SetX(12);
        $this->SetFillColor(74, 152, 86);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(35, 4, utf8_decode('CLASIFICACIÓN:'), 1, 0, 'L', 1);
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0, 0, 0);
        $this->SetX(47);
        $this->SetFont('Arial', '', 8);
        $this->MultiCell(151, 4, utf8_decode(self::$eventos->clasificacion_analisis), 1, 'L');
        $this->SetFont('Arial', 'B', 10);
        $this->SetX(12);
        $this->SetFillColor(74, 152, 86);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(186, 4, utf8_decode('PLAN DE MEJORA'), 1, 0, 'C', 1);
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0, 0, 0);
        $this->Ln();

        $this->SetX(12);
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(74, 152, 86);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(62, 4, utf8_decode('ACTIVIDAD'), 1, 0, 'C', 1);
        $this->Cell(42, 4, utf8_decode('RESPONSABLE'), 1, 0, 'C', 1);
        $this->Cell(20, 4, utf8_decode('FECHA'), 1, 0, 'C', 1);
        $this->Cell(62, 4, utf8_decode('DESCRIPCION'), 1, 0, 'C', 1);
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0, 0, 0);
        $this->Ln();
        $inicio = $this->GetY();
        $y1 = $this->GetY();


        foreach (self::$accionesMejorasEventos as $accionMejora) {
            $y_inicio = $this->GetY();
            $espacio_restante = 270 - $y_inicio;

            $this->SetFont('Arial', '', 8);

            $ancho_nombre = 50;
            $ancho_responsable = 54;
            $ancho_fecha = 20;
            $ancho_desc = 62;

            $altura_nombre = $this->GetStringWidth($accionMejora['nombre']) / $ancho_nombre * 4 + 2;
            $altura_fecha = 4;
            $altura_desc = $this->GetStringWidth($accionMejora['observacion']) / $ancho_desc * 4 + 2;

            $altura_fila = max($altura_nombre,  $altura_fecha, $altura_desc) + 12;

            if ($altura_fila > $espacio_restante) {
                $this->AddPage();
                $this->SetX(12);
                $this->SetFont('Arial', 'B', 8);
                $this->SetFillColor(74, 152, 86);
                $this->SetTextColor(255, 255, 255);
                $this->Cell($ancho_nombre, 6, utf8_decode('ACTIVIDAD'), 1, 0, 'C', 1);
                $this->Cell($ancho_responsable, 6, utf8_decode('RESPONSABLE'), 1, 0, 'C', 1);
                $this->Cell($ancho_fecha, 6, utf8_decode('FECHA'), 1, 0, 'C', 1);
                $this->Cell($ancho_desc, 6, utf8_decode('DESCRIPCIÓN'), 1, 1, 'C', 1);
                $this->SetFillColor(255, 255, 255);
                $this->SetTextColor(0, 0, 0);
                $y_inicio = $this->GetY();
            }

            $x_inicio = 12;

            $this->Rect($x_inicio, $y_inicio, $ancho_nombre, $altura_fila);
            $this->Rect($x_inicio + $ancho_nombre, $y_inicio, $ancho_responsable, $altura_fila);
            $this->Rect($x_inicio + $ancho_nombre + $ancho_responsable, $y_inicio, $ancho_fecha, $altura_fila);
            $this->Rect($x_inicio + $ancho_nombre + $ancho_responsable + $ancho_fecha, $y_inicio, $ancho_desc, $altura_fila);

            $this->SetXY($x_inicio, $y_inicio);
            $this->MultiCell($ancho_nombre, 4, utf8_decode($accionMejora['nombre'] ?? 'Sin nombre'), 0, 'L');

            $this->SetXY($x_inicio + $ancho_nombre, $y_inicio);
            if (!empty($accionMejora['responsable']) && is_array($accionMejora['responsable'])) {
                foreach ($accionMejora['responsable'] as $responsableRecorrido) {
                    $this->MultiCell(50, 4, utf8_decode($responsableRecorrido), 0, 'L');
                    $this->SetX($x_inicio + $ancho_nombre);
                }
            } else {
                $this->MultiCell(50, 4, utf8_decode('No asignado'), 0, 'L');
            }

            $this->SetXY($x_inicio + $ancho_nombre + $ancho_responsable, $y_inicio);
            $this->MultiCell($ancho_fecha, 4, utf8_decode($accionMejora['fecha_seguimiento'] ?? 'No definida'), 0, 'C');

            $this->SetXY($x_inicio + $ancho_nombre + $ancho_responsable + $ancho_fecha, $y_inicio);
            $this->MultiCell($ancho_desc, 4, utf8_decode($accionMejora['observacion'] ?? 'Sin observaciones'), 0, 'L');

            $this->SetY($y_inicio + $altura_fila);
        }



        $this->Ln();
        $this->Ln();

        $this->SetFont('Arial', 'B', 10);
        $this->SetX(12);
        $this->Cell(35, 4, utf8_decode('Responsable análisis: Comité de seguridad del paciente'), 0, 0, 'L');
    }
}
