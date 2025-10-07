<?php

namespace App\Formats\ComponentesHistoriaClinica;

class ValoracionSaludAuditivaFormato
{
    public function bodyComponente($pdf, $consulta)
    {
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('VALORACIÓN SALUD AUDITIVA Y COMUNICATIVA'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Funciones de la articulación, voz y habla: ") . utf8_decode($consulta["HistoriaClinica"]["funciones"] ?? 'No Reporta'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Desempeño comunicativo: ") . utf8_decode($consulta["HistoriaClinica"]["desempenio_comunicativo"] ?? 'No Reporta'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Lista de chequeo de factores de riesgo de las enfermedades del oído: ") . utf8_decode($consulta["HistoriaClinica"]["factores_oido"] ?? 'No Reporta'), 1, 'L', 0);
        $pdf->Ln();
    }
}
