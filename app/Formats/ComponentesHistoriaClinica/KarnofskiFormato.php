<?php

namespace App\Formats\ComponentesHistoriaClinica;

class KarnofskiFormato
{
    public function bodyComponente($pdf, $consulta): void
    {
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('ESCALA DE VALORACIÓN FUNCIONAL: ÍNDICE DE KARNOFSKI'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, utf8_decode($consulta["HistoriaClinica"]["valor_scala_karnofski"]), 1, 'L', 0);
        $pdf->Ln();
    }
}