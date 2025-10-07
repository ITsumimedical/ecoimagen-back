<?php

namespace App\Formats\ComponentesHistoriaClinica;


class SucesionEvolutivaFormato
{
    public function bodyComponente($pdf, $consulta): void
    {
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('SUCESION EVOLUTIVA DEL DESARROLLO'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $sucesion_conducta = $consulta["sucesionEvolutiva"]["sucesion_evolutiva_conducta"] ?? 'No refiere';
        $pdf->MultiCell(186, 4, utf8_decode('Sucesión evolutiva de la conducta: ' . $sucesion_conducta), 1, "L", 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $sucesion_lenguaje = $consulta["sucesionEvolutiva"]["sucesion_evolutiva_lenguaje"] ?? 'No refiere';
        $pdf->MultiCell(186, 4, utf8_decode('Sucesión evolutiva de lenguaje: ' . $sucesion_lenguaje), 1, "L", 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $sucesion_cognitiva = $consulta["sucesionEvolutiva"]["sucesion_evolutiva_area"] ?? 'No refiere';
        $pdf->MultiCell(186, 4, utf8_decode('Sucesión evolutiva de área cognitiva: ' . $sucesion_cognitiva), 1, "L", 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $sucesion_personal = $consulta["sucesionEvolutiva"]["sucesion_evolutiva_conducta_personal"] ?? 'No refiere';
        $pdf->MultiCell(186, 4, utf8_decode('Sucesión evolutiva de la conducta personal: ' . $sucesion_personal), 1, "L", 0);

        $pdf->Ln();
    }

}
