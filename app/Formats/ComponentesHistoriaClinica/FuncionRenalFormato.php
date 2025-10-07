<?php

namespace App\Formats\ComponentesHistoriaClinica;


class FuncionRenalFormato
{
    public function bodyComponente($pdf, $consulta): void
    {
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('FUNCIÓN RENAL'), 1, 0, 'C', 1);
        $pdf->Ln();
        $y = $pdf->GetY();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $resultado_cockcroft_gault = $consulta['funcionRenal']["resultado_cockcroft_gault"] ?? 'No refiere';
        $pdf->Cell(93, 4, utf8_decode("Resultado Cockcroft y Gault: " . $resultado_cockcroft_gault . ' mL/min'), 1, 0 , "L", 0);
        
        $resultado_ckd_epi = $consulta['funcionRenal']["resultado_ckd_epi"] ?? 'No refiere';
        $pdf->Cell(93, 4, utf8_decode("Resultado CKD-EPI: " . $resultado_ckd_epi . ' mL/min/1.73 m2'), 1, 0 , "L", 0);
        $pdf->Ln();
        $pdf->Ln();
        
    }
}
