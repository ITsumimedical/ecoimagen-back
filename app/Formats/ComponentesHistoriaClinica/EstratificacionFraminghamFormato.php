<?php

namespace App\Formats\ComponentesHistoriaClinica;

class EstratificacionFraminghamFormato
{
    public function bodyComponente($pdf, $consulta): void
    {
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('FRAMINGHAM'), 1, 0, 'C', 1);
        $pdf->Ln();
        $y = $pdf->GetY();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $framingham = $consulta['framingham']["resultado"] ?? 'No refiere (Faltan datos para el cálculo.)';
        $pdf->MultiCell(186, 4, utf8_decode("Resultado: " . $framingham), 1, "L", 0);
        $pdf->Ln();
    }
}
