<?php

namespace App\Formats\ComponentesHistoriaClinica;

class EstructuraDinamicaFamiliarFormato
{
    public function bodyComponente($pdf, $consulta): void
    {
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('DIMENSIONES'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetX(12);
        $pdf->MultiCell(186, 4, "Estructura dinamica: " . utf8_decode(isset($consulta["estructuraDinamica"]["estructura_dinamica"]) && $consulta["estructuraDinamica"]["estructura_dinamica"] !== null ? $consulta["estructuraDinamica"]["estructura_dinamica"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->SetX(12);
        $pdf->MultiCell(186, 4, "Situacion social: " . utf8_decode(isset($consulta["estructuraDinamica"]["situacion_socioeconomica"]) && $consulta["estructuraDinamica"]["situacion_socioeconomica"] !== null ? $consulta["estructuraDinamica"]["situacion_socioeconomica"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->SetX(12);
        $pdf->MultiCell(186, 4, "Entorno social: " . utf8_decode(isset($consulta["estructuraDinamica"]["entorno_social"]) && $consulta["estructuraDinamica"]["entorno_social"] !== null ? $consulta["estructuraDinamica"]["entorno_social"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->SetX(12);
        $pdf->MultiCell(186, 4, "Riesgo psicosocial: " . utf8_decode(isset($consulta["estructuraDinamica"]["riesgo_psicosocial"]) && $consulta["estructuraDinamica"]["riesgo_psicosocial"] !== null ? $consulta["estructuraDinamica"]["riesgo_psicosocial"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Ln();

    }
}
