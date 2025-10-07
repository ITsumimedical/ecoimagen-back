<?php

namespace App\Formats\ComponentesHistoriaClinica;

class ExamenTejidosDurosFormato
{
    public function bodyComponente($pdf, $consulta): void
    {
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('EXÁMEN DE TEJIDOS DUROS'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('EXÁMEN PULPAR'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Sensibilidad al frio: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["sensibilidad_frio"] !== null ? $consulta["examenTejidoOdontologicos"]["sensibilidad_frio"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Sensibilidad al calor: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["sensibilidad_calor"] !== null ? $consulta["examenTejidoOdontologicos"]["sensibilidad_calor"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Cambio de color: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["cambio_de_color"] !== null ? $consulta["examenTejidoOdontologicos"]["cambio_de_color"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Percusión positiva: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["percusion_positiva"] !== null ? $consulta["examenTejidoOdontologicos"]["percusion_positiva"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Exposición pulpar: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["exposicion_pulpar"] !== null ? $consulta["examenTejidoOdontologicos"]["exposicion_pulpar"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Otros: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["otros"] !== null ? $consulta["examenTejidoOdontologicos"]["otros"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('EXÁMEN DE TEJIDOS DENTARIOS'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Supernumerarios: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["supernumerarios"] !== null ? $consulta["examenTejidoOdontologicos"]["supernumerarios"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Agenesia: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["agenesia"] !== null ? $consulta["examenTejidoOdontologicos"]["agenesia"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Anodoncia: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["anodoncia"] !== null ? $consulta["examenTejidoOdontologicos"]["anodoncia"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Decoloración: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["decoloracion"] !== null ? $consulta["examenTejidoOdontologicos"]["decoloracion"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Descalcificación: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["descalcificacion"] !== null ? $consulta["examenTejidoOdontologicos"]["descalcificacion"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Facetas de desgaste: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["facetas_desgaste"] !== null ? $consulta["examenTejidoOdontologicos"]["facetas_desgaste"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Atrición: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["atricion"] !== null ? $consulta["examenTejidoOdontologicos"]["atricion"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Abrasión, abfracción y/o erosión: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["abrasion"] !== null ? $consulta["examenTejidoOdontologicos"]["abrasion"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Fluorosis: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["fluorosis"] !== null ? $consulta["examenTejidoOdontologicos"]["fluorosis"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Prótesis fija: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["protesis_fija"] !== null ? $consulta["examenTejidoOdontologicos"]["protesis_fija"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Prótesis removible: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["protesis_removible"] !== null ? $consulta["examenTejidoOdontologicos"]["protesis_removible"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Prótesis total: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["protesis_total"] !== null ? $consulta["examenTejidoOdontologicos"]["protesis_total"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Implantes dentales: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["implantes_dentales"] !== null ? $consulta["examenTejidoOdontologicos"]["implantes_dentales"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Aparatología ortopédica u ortodoncia: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["aparatologia_ortopedica"] !== null ? $consulta["examenTejidoOdontologicos"]["aparatologia_ortopedica"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('ALTERACIONES PERIODONTALES'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Inflamación: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["inflamacion"] !== null ? $consulta["examenTejidoOdontologicos"]["inflamacion"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Sangrado: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["sangrado"] !== null ? $consulta["examenTejidoOdontologicos"]["sangrado"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Exudado: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["exudado"] !== null ? $consulta["examenTejidoOdontologicos"]["exudado"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Supuración: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["supuracion"] !== null ? $consulta["examenTejidoOdontologicos"]["supuracion"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Placa blanda: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["placa_blanda"] !== null ? $consulta["examenTejidoOdontologicos"]["placa_blanda"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Placa calcificada: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["placa_calcificada"] !== null ? $consulta["examenTejidoOdontologicos"]["placa_calcificada"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Retracciones: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["retracciones"] !== null ? $consulta["examenTejidoOdontologicos"]["retracciones"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Presencia de bolsas: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["presencia_bolsas"] !== null ? $consulta["examenTejidoOdontologicos"]["presencia_bolsas"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Cuellos sensibles: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["cuellos_sensibles"] !== null ? $consulta["examenTejidoOdontologicos"]["cuellos_sensibles"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Movilidad: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["movilidad"] !== null ? $consulta["examenTejidoOdontologicos"]["movilidad"] : 'No' : 'No')), 1, 'L', 0);

    }
}
