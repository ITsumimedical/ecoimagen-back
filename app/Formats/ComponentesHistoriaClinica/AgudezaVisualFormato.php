<?php

namespace App\Formats\ComponentesHistoriaClinica;

class AgudezaVisualFormato
{
    public function bodyComponente($pdf, $consulta): void
    {
         $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('AGUDEZA VISUAL'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, utf8_decode("Ojo derecho: ") . utf8_decode($consulta["HistoriaClinica"]["agudeza_visual_ojo_derecho"] ?? 'No refiere'), 1, 'L', 0);
        $pdf->SetX(12);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, utf8_decode("Ojo Izquierdo: ") . utf8_decode($consulta["HistoriaClinica"]["agudeza_visual_ojo_izquierdo"] ?? 'No refiere'), 1, 'L', 0);
        $pdf->SetX(12);
        $pdf->Ln();
    }
}
