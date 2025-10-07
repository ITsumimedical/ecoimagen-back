<?php

namespace App\Formats\ComponentesHistoriaClinica;

class HallazgosClinicosFormato
{
    public function bodyComponente($pdf, $consulta): void
    {
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('HALLAZGOS CLINICOS'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $hallazgosClinicos = 'No Refiere';
        if (isset(self::$consulta["HistoriaClinica"])) {
            $hallazgosClinicos = self::$consulta["HistoriaClinica"]["hallazgos_clinicos"] ?? 'No Refiere';
        }
        $pdf->MultiCell(186, 4, utf8_decode($hallazgosClinicos), 1, "L", 0);
        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $hallazgos_radiograficos = 'No Refiere';
        if (isset(self::$consulta["HistoriaClinica"])) {
            $hallazgos_radiograficos = self::$consulta["HistoriaClinica"]["hallazgos_radiograficos"] ?? 'No Refiere';
        }
        $pdf->MultiCell(186, 4, utf8_decode($hallazgos_radiograficos), 1, "L", 0);
        $pdf->Ln();


    }
}
