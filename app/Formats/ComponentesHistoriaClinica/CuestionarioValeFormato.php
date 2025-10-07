<?php

namespace App\Formats\ComponentesHistoriaClinica;


class CuestionarioValeFormato
{
    public function bodyComponente($pdf, $consulta): void
    {
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('CUESTIONARIO VALE FORMATO'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $vale = $consulta["cuestionarioVale"]["valorItemC"] ?? 'No refiere';
        $pdf->Cell(46.5, 4, utf8_decode('Comprensión (C): ' . $vale), 1, 0 , "L");
        $vale = $consulta["cuestionarioVale"]["valorItemE"] ?? 'No refiere';
        $pdf->Cell(46.5, 4, utf8_decode('Expresión (E): ' . $vale), 1, 0 , "L");
        $vale = $consulta["cuestionarioVale"]["valorItemI"] ?? 'No refiere';
        $pdf->Cell(46.5, 4, utf8_decode('Interacción (I): ' . $vale), 1, 0 , "L");
        $vale = $consulta["cuestionarioVale"]["valorItemV"] ?? 'No refiere';
        $pdf->Cell(46.5, 4, utf8_decode('Vestibular (V): ' . $vale), 1, "L", 0);
        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $vale = $consulta["cuestionarioVale"]["observacionesItems"] ?? 'No refiere';
        $pdf->MultiCell(186, 4, utf8_decode('Observaciones o comentarios: ' . $vale), 1, "L", 0);
        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $vale = $consulta["cuestionarioVale"]["interpretacion_resultado"] ?? 'No refiere';
        $pdf->MultiCell(186, 4, utf8_decode('Interpretación resultado: ' . $vale), 1, "L", 0);
        $pdf->Ln();
    }
}
