<?php

namespace App\Formats\ComponentesHistoriaClinica;

class TannerFormato
{
    public function bodyComponente($pdf, $consulta): void
    {
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('TANNER'), 1, 0, 'C', 1);
        $pdf->Ln();
        $y = $pdf->GetY();

        if ($consulta["afiliado"]["sexo"] == "F") {
            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $mamario = $consulta['escalaTanner']["mamario_mujeres"] ?? 'No refiere';
            $pdf->MultiCell(186, 4, utf8_decode("mamario mujeres: " . $mamario), 1, "L", 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pubiano = $consulta['escalaTanner']["pubiano_mujeres"] ?? 'No refiere';
            $pdf->MultiCell(186, 4, utf8_decode("pubiano mujeres: " . $pubiano), 1, "L", 0);

            $pdf->Ln();
        } else {
            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $genital = $consulta['escalaTanner']["genital_hombres"] ?? 'No refiere';
            $pdf->MultiCell(186, 4, utf8_decode("genital hombres: " . $genital), 1, "L", 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pubiano = $consulta['escalaTanner']["pubiano_hombres"] ?? 'No refiere';
            $pdf->MultiCell(186, 4, utf8_decode("pubiano hombres: " . $pubiano), 1, "L", 0);

        }
    }
}
