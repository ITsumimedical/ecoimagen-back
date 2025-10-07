<?php

namespace App\Formats\ComponentesHistoriaClinica;

class FiguraHumanaFormato
{
    public function bodyComponente($pdf, $consulta): void
    {
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('FIGURA HUMANA'), 1, 0, 'C', 1);
        $pdf->Ln();
        $y = $pdf->GetY();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $rqc = $consulta['FiguraHumana']["interpretacion_resultados"] ?? 'No refiere';
        $pdf->MultiCell(186, 4, utf8_decode("Edad mental del afiliado: " . $rqc), 1, "L", 0);
        $pdf->Ln();
    }
}
