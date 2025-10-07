<?php

namespace App\Formats\ComponentesHistoriaClinica;


class ApgarFormato
{
    public function bodyComponente($pdf, $consulta): void
    {
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('APGAR FAMILIAR'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);

        $resultado = isset($consulta["apgarFamiliar"]["resultado"]) && $consulta["apgarFamiliar"]["resultado"] !== null
            ? $consulta["apgarFamiliar"]["resultado"]
            : 'sin hallazgos';

        $interpretacion = isset($consulta["apgarFamiliar"]["interpretacion_resultado"]) && $consulta["apgarFamiliar"]["interpretacion_resultado"] !== null
            ? ' - ' . $consulta["apgarFamiliar"]["interpretacion_resultado"]
            : '';

        $pdf->Cell(186, 4, "Resultado: " . utf8_decode($resultado . $interpretacion), 1, 1, 'L');
        $pdf->SetX(12);
    }
}
