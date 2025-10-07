<?php

namespace App\Formats\ComponentesHistoriaClinica;

class RefraccionFormato
{
	public function bodyComponente($pdf, $consulta): void
    {
        $y = $pdf->GetY();
		$pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(186, 4, utf8_decode('QUERATOMETRIA'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $queratometria_od = 'No Refiere';
        if (isset($consulta["HistoriaClinica"])) {
            $queratometria_od = $consulta["HistoriaClinica"]["queratometria_od"] ?? 'No Refiere';
        }
        $texto_completo = "Ojo derecho: " . $queratometria_od;
        $pdf->MultiCell(186, 4, utf8_decode($texto_completo), 1, "L", 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $queratometria_oi = 'No Refiere';
        if (isset($consulta["HistoriaClinica"])) {
            $queratometria_oi = $consulta["HistoriaClinica"]["queratometria_oi"] ?? 'No Refiere';
        }
        $texto_completo = "Ojo izquierdo: " . $queratometria_oi;
        $pdf->MultiCell(186, 4, utf8_decode($texto_completo), 1, "L", 0);
        $pdf->Ln();

		$pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(186, 4, utf8_decode('REFRACCION'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $refraccion_od = 'No Refiere';
        if (isset($consulta["HistoriaClinica"])) {
            $refraccion_od = $consulta["HistoriaClinica"]["refraccion_od"] ?? 'No Refiere';
        }
        $texto_completo = "OD: " . $refraccion_od;
        $pdf->MultiCell(186, 4, utf8_decode($texto_completo), 1, "L", 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $refraccionav_od = 'No Refiere';
        if (isset($consulta["HistoriaClinica"])) {
            $refraccionav_od = $consulta["HistoriaClinica"]["refraccionav_od"] ?? 'No Refiere';
        }
        $texto_completo = "AV: " . $refraccionav_od;
        $pdf->MultiCell(186, 4, utf8_decode($texto_completo), 1, "L", 0);


        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $refraccion_oi = 'No Refiere';
        if (isset($consulta["HistoriaClinica"])) {
            $refraccion_oi = $consulta["HistoriaClinica"]["refraccion_oi"] ?? 'No Refiere';
        }
        $texto_completo = "OI: " . $refraccion_oi;
        $pdf->MultiCell(186, 4, utf8_decode($texto_completo), 1, "L", 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $refraccionav_oi = 'No Refiere';
        if (isset($consulta["HistoriaClinica"])) {
            $refraccionav_oi = $consulta["HistoriaClinica"]["refraccionav_oi"] ?? 'No Refiere';
        }
        $texto_completo = "AV: " . $refraccionav_oi;
        $pdf->MultiCell(186, 4, utf8_decode($texto_completo), 1, "L", 0);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(186, 4, utf8_decode('SUBJETIVO'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $subjetivo_od = 'No Refiere';
        if (isset($consulta["HistoriaClinica"])) {
            $subjetivo_od = $consulta["HistoriaClinica"]["subjetivo_od"] ?? 'No Refiere';
        }
        $texto_completo = "OD: " . $subjetivo_od;
        $pdf->MultiCell(186, 4, utf8_decode($texto_completo), 1, "L", 0);


        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $subjetivoav_od = 'No Refiere';
        if (isset($consulta["HistoriaClinica"])) {
            $subjetivoav_od = $consulta["HistoriaClinica"]["subjetivoav_od"] ?? 'No Refiere';
        }
        $texto_completo = "AV: " . $subjetivoav_od;
        $pdf->MultiCell(186, 4, utf8_decode($texto_completo), 1, "L", 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $subjetivo_oi = 'No Refiere';
        if (isset($consulta["HistoriaClinica"])) {
            $subjetivo_oi = $consulta["HistoriaClinica"]["subjetivo_oi"] ?? 'No Refiere';
        }
        $texto_completo = "OI: " . $subjetivo_oi;
        $pdf->MultiCell(186, 4, utf8_decode($texto_completo), 1, "L", 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $subjetivoav_oi = 'No Refiere';
        if (isset($consulta["HistoriaClinica"])) {
            $subjetivoav_oi = $consulta["HistoriaClinica"]["subjetivoav_oi"] ?? 'No Refiere';
        }
        $texto_completo = "AV: " . $subjetivoav_oi;
        $pdf->MultiCell(186, 4, utf8_decode($texto_completo), 1, "L", 0);
        $pdf->Ln();

	}
}
