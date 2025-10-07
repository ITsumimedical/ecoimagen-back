<?php

namespace App\Formats\ComponentesHistoriaClinica;


class BiomicroscopiaFormato
{
	public function bodyComponente($pdf, $consulta): void
    {
        $y = $pdf->GetY();

		$pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(186, 4, utf8_decode('BIOMICROSCOPIA'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $biomicroscopiaod = 'No Refiere';
        if (isset($consulta["HistoriaClinica"])) {
            $biomicroscopiaod = $consulta["HistoriaClinica"]["biomicroscopiaod"] ?? 'No Refiere';
        }
        $texto_completo = "Ojo derecho: " . $biomicroscopiaod;
        $pdf->MultiCell(186, 4, utf8_decode($texto_completo), 1, "L", 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $biomicroscopiaoi = 'No Refiere';
        if (isset($consulta["HistoriaClinica"])) {
            $biomicroscopiaoi = $consulta["HistoriaClinica"]["biomicroscopiaoi"] ?? 'No Refiere';
        }
        $texto_completo = "Ojo izquierdo: " . $biomicroscopiaoi;
        $pdf->MultiCell(186, 4, utf8_decode($texto_completo), 1, "L", 0);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(186, 4, utf8_decode('PIO'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $piood = 'No Refiere';
        if (isset($consulta["HistoriaClinica"])) {
            $piood = $consulta["HistoriaClinica"]["piood"] ?? 'No Refiere';
        }
        $texto_completo = "Ojo derecho: " . $piood;
        $pdf->MultiCell(186, 4, utf8_decode($texto_completo), 1, "L", 0);


        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $piooi = 'No Refiere';
        if (isset($consulta["HistoriaClinica"])) {
            $piooi = $consulta["HistoriaClinica"]["piooi"] ?? 'No Refiere';
        }
        $texto_completo = "Ojo izquierdo: " . $piooi;
        $pdf->MultiCell(186, 4, utf8_decode($texto_completo), 1, "L", 0);
        $pdf->Ln();


        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(186, 4, utf8_decode('OFTALMOSCOPIA'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);


        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $oftalmoscopiaod = 'No Refiere';
        if (isset($consulta["HistoriaClinica"])) {
            $oftalmoscopiaod = $consulta["HistoriaClinica"]["oftalmoscopiaod"] ?? 'No Refiere';
        }
        $texto_completo = "Ojo derecho: " . $oftalmoscopiaod;
        $pdf->MultiCell(186, 4, utf8_decode($texto_completo), 1, "L", 0);


        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $queratometria_od = 'No Refiere';
        if (isset($consulta["HistoriaClinica"])) {
            $oftalmoscopiaoi = $consulta["HistoriaClinica"]["oftalmoscopiaoi"] ?? 'No Refiere';
        }
        $texto_completo = "Ojo izquierdo: " . $oftalmoscopiaoi;
        $pdf->MultiCell(186, 4, utf8_decode($texto_completo), 1, "L", 0);
        $pdf->Ln();
	}
}
