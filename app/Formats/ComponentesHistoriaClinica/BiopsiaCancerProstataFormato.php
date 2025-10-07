<?php

namespace App\Formats\ComponentesHistoriaClinica;

class BiopsiaCancerProstataFormato
{
    public function bodyComponente($pdf, $datosCancer): void
    {
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('CÁNCER PRÓSTATA'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 8);
        $pdf->SetX(12);
        $pdf->Cell(63, 5, utf8_decode('PSA: ' . ($datosCancer["psa"] ?? 'No refiere')), 1, 0);
        $pdf->Cell(63, 5, utf8_decode('Lóbulo: ' . ($datosCancer["lobulo"] ?? 'No refiere')), 1, 0);
        $pdf->Cell(60, 5, utf8_decode('Lóbulo Derecho: ' . ($datosCancer["lobulo_derecho"] ?? 'No refiere')), 1);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->Cell(93, 5, utf8_decode('Lóbulo Izquierdo: ' . ($datosCancer["lobulo_izquierdo"] ?? 'No refiere')), 1);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->MultiCell(186, 5, utf8_decode('Grado: ' . ($datosCancer["grado"] ?? 'No evaluado')), 1);
        $pdf->SetX(12);
        $pdf->Cell(93, 5, utf8_decode('Riesgo: ' . ($datosCancer["riesgo"] ?? 'No refiere')), 1, 0);
        $pdf->Cell(93, 5, utf8_decode('Fecha ingreso IHQ: ' . (($datosCancer["fecha_ingreso_ihq"] ?? '') ? date('Y-m-d', strtotime($datosCancer["fecha_ingreso_ihq"])) : 'No refiere')), 1);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->Cell(93, 5, utf8_decode('Fecha salida IHQ: ' . (($datosCancer["fecha_salida_ihq"] ?? '') ? date('Y-m-d', strtotime($datosCancer["fecha_salida_ihq"])) : 'No refiere')), 1);
        $pdf->Ln(5);

        // Clasificación T
        $pdf->SetX(12);
        $pdf->Cell(186, 5, utf8_decode('Clasificación T: ' . ($datosCancer["clasificacion_t"] ?? 'No refiere')), 1);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->MultiCell(186, 5, utf8_decode('Descripción Clasificación T: ' . ($datosCancer["descripcion_clasificacion_t"] ?? 'No refiere')), 1);

        // Clasificación M
        $pdf->SetX(12);
        $pdf->Cell(186, 5, utf8_decode('Clasificación M: ' . ($datosCancer["clasificacion_m"] ?? 'No refiere')), 1);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->MultiCell(186, 5, utf8_decode('Descripción Clasificación M: ' . ($datosCancer["descripcion_clasificacion_m"] ?? 'No refiere')), 1);

        // Clasificación N
        $pdf->SetX(12);
        $pdf->Cell(186, 5, utf8_decode('Clasificación N: ' . ($datosCancer["clasificacion_n"] ?? 'No refiere')), 1);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->MultiCell(186, 5, utf8_decode('Descripción Clasificación N: ' . ($datosCancer["descripcion_clasificacion_n"] ?? 'No refiere')), 1);

        // Estadio
        $pdf->SetX(12);
        $pdf->MultiCell(186, 5, utf8_decode('Estadio: ' . ($datosCancer["estadio"] ?? 'No refiere')), 1);

        // Extensión
        $pdf->SetX(12);
        $pdf->MultiCell(186, 5, utf8_decode('Extensión: ' . ($datosCancer["extension"] ?? 'No refiere')), 1);
    }
}
