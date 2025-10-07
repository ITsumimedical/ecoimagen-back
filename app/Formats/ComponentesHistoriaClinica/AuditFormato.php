<?php

namespace App\Formats\ComponentesHistoriaClinica;


class AuditFormato
{
    public function bodyComponente($pdf, $consulta): void
    {
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('CUESTIONARIO AUDIT'), 1, 0, 'C', 1);
        $pdf->Ln();
        $y = $pdf->GetY();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $audit = $consulta['audit']["interpretacion_resultados"] ?? 'No refiere';
        $pdf->MultiCell(186, 4, utf8_decode("Resultado: " . $audit), 1, "L", 0);
        $pdf->Ln();
    }
}
