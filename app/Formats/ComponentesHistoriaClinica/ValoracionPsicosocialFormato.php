<?php

namespace App\Formats\ComponentesHistoriaClinica;

class ValoracionPsicosocialFormato
{
    public function bodyComponente($pdf, $consulta)
    {
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('VALORACIÓN PSICOSOCIAL'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(93, 4, "Violencia: " . utf8_decode($consulta["HistoriaClinica"]["violencia_mental"] ?? 'No Reporta'), 1, 0 , 'L');
        $pdf->Cell(93, 4, "Violencia conflicto armado: " . utf8_decode($consulta["HistoriaClinica"]["violencia_conflicto"] ?? 'No Reporta'), 1, 'L', 0);

        if ($consulta["afiliado"]["edad_cumplida"] >= 12 && $consulta["afiliado"]["edad_cumplida"] <= 50) {
            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(93, 4, "Violencia sexual: " . utf8_decode($consulta["HistoriaClinica"]["violencia_sexual"] ?? 'No Reporta'), 1, 0, 'L');
            $pdf->Cell(93, 4, "Lesiones autoinflingidas: " . utf8_decode($consulta["HistoriaClinica"]["lesiones_auto_inflingidas"] ?? 'No Reporta'), 1, 'L', 0);
            $pdf->Ln();
        }   
    }
}
