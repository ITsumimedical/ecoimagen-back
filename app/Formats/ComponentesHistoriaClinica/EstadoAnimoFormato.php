<?php

namespace App\Formats\ComponentesHistoriaClinica;

class EstadoAnimoFormato
{
    public function bodyComponente($pdf, $consulta): void
    {
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('NEUROPSICOLOGIA ADULTOS'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "Estado animo: " . utf8_decode(isset($consulta["neuropsicologia"]["estado_animo_comportamiento"]) && $consulta["neuropsicologia"]["estado_animo_comportamiento"] !== null ? $consulta["neuropsicologia"]["estado_animo_comportamiento"] : 'No Refiere'), 1, 1);
        $pdf->SetX(12);
        $pdf->MultiCell(186, 4, utf8_decode("Actividades básicas: ") . utf8_decode(isset($consulta["neuropsicologia"]["actividades_basicas_instrumentales"]) && $consulta["neuropsicologia"]["actividades_basicas_instrumentales"] !== null ? $consulta["neuropsicologia"]["actividades_basicas_instrumentales"] : 'No Refiere'), 1, 1);
        $pdf->SetX(12);
        $pdf->MultiCell(186, 4, "Composicion familiar: " . utf8_decode(isset($consulta["neuropsicologia"]["composicion_familiar"]) && $consulta["neuropsicologia"]["composicion_familiar"] !== null ? $consulta["neuropsicologia"]["composicion_familiar"] : 'No Refiere'), 1, 1);
        $pdf->SetX(12);
        $pdf->MultiCell(186, 4, utf8_decode("Evolución y pruebas: ") . utf8_decode(isset($consulta["neuropsicologia"]["evolucion_pruebas"]) && $consulta["neuropsicologia"]["evolucion_pruebas"] !== null ? $consulta["neuropsicologia"]["evolucion_pruebas"] : 'No Refiere'), 1, 1);
        $pdf->SetX(12);
        $pdf->MultiCell(186, 4, utf8_decode("Nivel pre morbido: ") . utf8_decode(isset($consulta["neuropsicologia"]["nivel_pre_morbido"]) && $consulta["neuropsicologia"]["nivel_pre_morbido"] !== null ? $consulta["neuropsicologia"]["nivel_pre_morbido"] : 'No Refiere'), 1, 0);
        $pdf->Ln();
        $pdf->Ln();
    }
}