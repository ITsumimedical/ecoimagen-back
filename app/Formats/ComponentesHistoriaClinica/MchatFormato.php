<?php

namespace App\Formats\ComponentesHistoriaClinica;

class MchatFormato
{
    public function bodyComponente($pdf, $consulta): void
    {
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('TEST M-CHAT'), 1, 0, 'C', 1);
        $pdf->Ln();
        $y = $pdf->GetY();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $mchat = $consulta['escalaMchat']["interpretacion_resultado"] ?? 'No Aplica';
        $pdf->MultiCell(186, 4, utf8_decode("Resultado: " . $mchat), 1, "L", 0);
        $pdf->Ln();
    }

}
