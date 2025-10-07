<?php

namespace App\Formats\ComponentesHistoriaClinica;

class cuestionarioGad2Formato
{
    public function bodyComponente($pdf, $consulta): void
    {
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('CUESTIONARIO GAD-2'), 1, 0, 'C', 1);
        $pdf->Ln();
        $y = $pdf->GetY();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $rqc = $consulta['gad2']["interpretacion_resultado"] ?? 'No refiere';
        $pdf->MultiCell(186, 4, utf8_decode("Resultado: " . $rqc), 1, "L", 0);
        $pdf->Ln();
    }
}
