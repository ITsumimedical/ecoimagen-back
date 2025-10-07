<?php

namespace App\Formats\ComponentesHistoriaClinica;

class BiopsiaCancerOvarioFormato
{
    public function bodyComponente($pdf, $datosCancer): void
    {
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 5, utf8_decode('CÁNCER OVARIO'), 1, 0, 'C', 1);
        $pdf->Ln(6);

        $pdf->SetFont('Arial', '', 8);
        $pdf->SetX(12);
        $pdf->Cell(62, 5, utf8_decode('Lateralidad 1: ' . ($datosCancer["lateralidad_1"] ?? 'No refiere')), 1);
        $pdf->Cell(62, 5, utf8_decode('Lateralidad 2: ' . ($datosCancer["lateralidad_2"] ?? 'No refiere')), 1);
        $pdf->Cell(62, 5, utf8_decode('Laboratorio que procesa: ' . ($datosCancer["laboratorio_procesa"] ?? 'No refiere')), 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->Cell(93, 5, utf8_decode('Nombre del patólogo: ' . ($datosCancer["nombre_patologo"] ?? 'No refiere')), 1);
        $pdf->Cell(93, 5, utf8_decode('Fecha ingreso IHQ: ' . (!empty($datosCancer["fecha_ingreso_ihq"]) ? date('d/m/Y', strtotime($datosCancer["fecha_ingreso_ihq"])) : 'No refiere')), 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->Cell(93, 5, utf8_decode('Fecha salida IHQ: ' . (!empty($datosCancer["fecha_salida_ihq"]) ? date('d/m/Y', strtotime($datosCancer["fecha_salida_ihq"])) : 'No refiere')), 1);
        $pdf->Cell(31, 5, utf8_decode('Clasificación T: ' . ($datosCancer["clasificacion_t"] ?? 'No refiere')), 1);
        $pdf->Cell(31, 5, utf8_decode('Clasificación N: ' . ($datosCancer["clasificacion_n"] ?? 'No refiere')), 1);
        $pdf->Cell(31, 5, utf8_decode('Clasificación M: ' . ($datosCancer["clasificacion_m"] ?? 'No refiere')), 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(186, 5, utf8_decode('Estadio FIGO'), 1, 1, 'L');
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetX(12);
        $pdf->MultiCell(186, 5, utf8_decode($datosCancer["estadio_figo"] ?? 'No refiere'), 1);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(186, 5, utf8_decode('Descripción Estadio FIGO'), 1, 1, 'L');
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetX(12);
        $pdf->MultiCell(186, 5, utf8_decode($datosCancer["descripcion_estadio_figo"] ?? 'No refiere'), 1);
    }
}
