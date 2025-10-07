<?php

namespace App\Formats\ComponentesHistoriaClinica;


class PieDiabeticoFormato
{
    public function bodyComponente($pdf, $consulta): void
    {
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('CLASIFICACIÓN DE PIE DIABÉTICO'), 1, 0, 'C', 1);
        $pdf->Ln();
        $y = $pdf->GetY();

        $pie = $consulta['pieDiabetico'] ?? null;
        
        if (
            !$pie ||
            empty($pie['presencia']) ||
            empty($pie['grado'])
        ) {
            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(186, 4, utf8_decode("Faltan datos para el cálculo."), 1, 0, "L", 0);
        }else {
            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $presencia = $consulta['pieDiabetico']["presencia"] ?? 'No refiere';
            $pdf->Cell(93, 4, utf8_decode("Presencia: " . $presencia), 1, 0, "L", 0);
    
            $grado = $consulta['pieDiabetico']["grado"] ?? 'No refiere';
            $pdf->Cell(93, 4, utf8_decode($grado), 1, 0, "L", 0);
            $pdf->Ln();
    
            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $estadio = $consulta['pieDiabetico']["estadio"] ?? 'No refiere';
            $pdf->Cell(60, 4, utf8_decode("Estadio: " . $estadio), 1, 0, "L", 0);
    
            $descripcion = $consulta['pieDiabetico']["descripcion"] ?? 'No refiere';
            $pdf->Cell(126, 4, utf8_decode("Descripción: " . $descripcion), 1, 0, "L", 0);
        }
        $pdf->Ln();
        $pdf->Ln();
    }
}
