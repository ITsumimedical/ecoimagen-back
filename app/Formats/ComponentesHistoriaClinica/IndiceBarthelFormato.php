<?php

namespace App\Formats\ComponentesHistoriaClinica;


class IndiceBarthelFormato
{
    public function bodyComponente($pdf, $consulta): void
    {
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('ÍNDICE BARTHEL'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $lavarse = $consulta["HistoriaClinica"]["barthel_lavarse"] ?? 'No refiere';
        $pdf->Cell(46.5, 4, utf8_decode('Lavarse: ' . $lavarse), 1, 0 , "L");

        $vestirse = $consulta["HistoriaClinica"]["barthel_vestirse"] ?? 'No refiere';
        $pdf->Cell(46.5, 4, utf8_decode('Vestirse: ' . $vestirse), 1, 0 , "L");

        $arreglarse = $consulta["HistoriaClinica"]["barthel_arreglarse"] ?? 'No refiere';
        $pdf->Cell(46.5, 4, utf8_decode('Arreglarse: ' . $arreglarse), 1, 0 , "L");

        $deposiciones = $consulta["HistoriaClinica"]["barthel_deposiciones"] ?? 'No refiere';
        $pdf->Cell(46.5, 4, utf8_decode('Deposiciones: ' . $deposiciones), 1, 1 , "L");

        $pdf->SetX(12);
        $miccion = $consulta["HistoriaClinica"]["barthel_miccion"] ?? 'No refiere';
        $pdf->Cell(46.5, 4, utf8_decode('Micción: ' . $miccion), 1, 0 , "L");
        
        $comer = $consulta["HistoriaClinica"]["barthel_comer"] ?? 'No refiere';
        $pdf->Cell(46.5, 4, utf8_decode('Comer: ' . $comer), 1, 0 , "L");
        
        $usoRetrete = $consulta["HistoriaClinica"]["barthel_retrete"] ?? 'No refiere';
        $pdf->Cell(46.5, 4, utf8_decode('Uso del retrete: ' . $usoRetrete), 1, 0 , "L");
        
        $trasladarse = $consulta["HistoriaClinica"]["barthel_trasladarse"] ?? 'No refiere';
        $pdf->Cell(46.5, 4, utf8_decode('Trasladarse silla/cama: ' . $trasladarse), 1, 1, "L");
        
        $pdf->SetX(12);
        $deambular = $consulta["HistoriaClinica"]["barthel_deambular"] ?? 'No refiere';
        $pdf->Cell(46.5, 4, utf8_decode('Desplazamiento: ' . $deambular), 1, 0 , "L");
        
        $escalones = $consulta["HistoriaClinica"]["barthel_escalones"] ?? 'No refiere';
        $pdf->Cell(46.5, 4, utf8_decode('Escalones: ' . $escalones), 1, 0 , "L");

        $pdf->Cell(93, 4, utf8_decode(' '), 1, 1 , "L");

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $interpretacionBarthel = $consulta["HistoriaClinica"]["interpretacion_barthel"] ?? 'No refiere';
        $pdf->MultiCell(186, 4, utf8_decode('Interpretación resultado: ' . $interpretacionBarthel), 1, "L", 0);
        $pdf->Ln();
    }
}