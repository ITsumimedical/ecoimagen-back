<?php

namespace App\Formats\ComponentesHistoriaClinica;


class LensometriaFormato
{
	public function bodyComponente($pdf, $consulta): void
    {
        $y = $pdf->GetY();

		$pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(186, 4, utf8_decode('LENSOMETRIA'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetX(12);
        $pdf->Cell(186, 4, utf8_decode('OJO DERECHO'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->MultiCell(186, 4, utf8_decode("Descripción: ") . utf8_decode(isset($consulta["HistoriaClinica"]["lateralidad_od"]) && $consulta["HistoriaClinica"]["lateralidad_od"] !== null ? $consulta["HistoriaClinica"]["lateralidad_od"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->SetX(12);
        $pdf->Cell(46.5, 4, utf8_decode("ESF: ") . utf8_decode(isset($consulta["HistoriaClinica"]["esf_od"]) && $consulta["HistoriaClinica"]["esf_od"] !== null ? $consulta["HistoriaClinica"]["esf_od"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Cell(46.5, 4, utf8_decode("CYL: ") . utf8_decode(isset($consulta["HistoriaClinica"]["cyl_od"]) && $consulta["HistoriaClinica"]["cyl_od"] !== null ? $consulta["HistoriaClinica"]["cyl_od"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Cell(46.5, 4, utf8_decode("EJE: ") . utf8_decode(isset($consulta["HistoriaClinica"]["eje_od"]) && $consulta["HistoriaClinica"]["eje_od"] !== null ? $consulta["HistoriaClinica"]["eje_od"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Cell(46.5, 4, utf8_decode("ADD: ") . utf8_decode(isset($consulta["HistoriaClinica"]["add_od"]) && $consulta["HistoriaClinica"]["add_od"] !== null ? $consulta["HistoriaClinica"]["add_od"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetX(12);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->Cell(186, 4, utf8_decode('OJO IZQUIERDO'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->MultiCell(186, 4, utf8_decode("Descripción: ") . utf8_decode(isset($consulta["HistoriaClinica"]["lateralidad_oi"]) && $consulta["HistoriaClinica"]["lateralidad_oi"] !== null ? $consulta["HistoriaClinica"]["lateralidad_oi"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->SetX(12);
        $pdf->Cell(46.5, 4, utf8_decode("ESF: ") . utf8_decode(isset($consulta["HistoriaClinica"]["esf_oi"]) && $consulta["HistoriaClinica"]["esf_oi"] !== null ? $consulta["HistoriaClinica"]["esf_oi"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Cell(46.5, 4, utf8_decode("CYL: ") . utf8_decode(isset($consulta["HistoriaClinica"]["cyl_oi"]) && $consulta["HistoriaClinica"]["cyl_oi"] !== null ? $consulta["HistoriaClinica"]["cyl_oi"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Cell(46.5, 4, utf8_decode("EJE: ") . utf8_decode(isset($consulta["HistoriaClinica"]["eje_oi"]) && $consulta["HistoriaClinica"]["eje_oi"] !== null ? $consulta["HistoriaClinica"]["eje_oi"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Cell(46.5, 4, utf8_decode("ADD: ") . utf8_decode(isset($consulta["HistoriaClinica"]["add_oi"]) && $consulta["HistoriaClinica"]["add_oi"] !== null ? $consulta["HistoriaClinica"]["add_oi"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Ln();
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->Cell(186, 4, utf8_decode('AGUDEZA VISUAL'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $checkboxsc = 'No Refiere';
        if (isset($consulta["HistoriaClinica"])) {
            $checkboxsc = $consulta["HistoriaClinica"]["checkboxsc"] ?? 'No Refiere';
        }
        $texto_completo = "SC: " . $checkboxsc;
        $pdf->MultiCell(186, 4, utf8_decode($texto_completo), 1, "L", 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $checkboxcc = 'No Refiere';
        if (isset($consulta["HistoriaClinica"])) {
            $checkboxcc = $consulta["HistoriaClinica"]["checkboxcc"] ?? 'No Refiere';
        }
        $texto_completo = "CC: " . $checkboxcc;
        $pdf->MultiCell(186, 4, utf8_decode($texto_completo), 1, "L", 0);



        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(186, 4, utf8_decode('VL'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetX(12);
        $pdf->Cell(186, 4, utf8_decode('OJO DERECHO'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->MultiCell(186, 4, utf8_decode("Descripción: ") . utf8_decode(isset($consulta["HistoriaClinica"]["agudeza_od"]) && $consulta["HistoriaClinica"]["agudeza_od"] !== null ? $consulta["HistoriaClinica"]["agudeza_od"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->SetX(12);
        $pdf->Cell(186, 4, utf8_decode("VP: ") . utf8_decode(isset($consulta["HistoriaClinica"]["agudezavp_od"]) && $consulta["HistoriaClinica"]["agudezavp_od"] !== null ? $consulta["HistoriaClinica"]["agudezavp_od"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetX(12);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->Cell(186, 4, utf8_decode('OJO IZQUIERDO'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->MultiCell(186, 4, utf8_decode("Descripción: ") . utf8_decode(isset($consulta["HistoriaClinica"]["agudeza_oi"]) && $consulta["HistoriaClinica"]["agudeza_oi"] !== null ? $consulta["HistoriaClinica"]["agudeza_oi"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->SetX(12);
        $pdf->Cell(186, 4, utf8_decode("VP: ") . utf8_decode(isset($consulta["HistoriaClinica"]["agudezavp_oi"]) && $consulta["HistoriaClinica"]["agudezavp_oi"] !== null ? $consulta["HistoriaClinica"]["agudezavp_oi"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Ln();
        $pdf->Ln();



        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->Cell(186, 4, utf8_decode('MOTILIDAD OCULAR'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetX(12);
        $pdf->Cell(186, 4, utf8_decode("VL: ") . utf8_decode(isset($consulta["HistoriaClinica"]["ocular_vl"]) && $consulta["HistoriaClinica"]["ocular_vl"] !== null ? $consulta["HistoriaClinica"]["ocular_vl"] : 'sin hallazgos'), 1, 1, 'L');
        $pdf->SetX(12);
        $pdf->Cell(186, 4, utf8_decode("VP: ") . utf8_decode(isset($consulta["HistoriaClinica"]["ocular_vp"]) && $consulta["HistoriaClinica"]["ocular_vp"] !== null ? $consulta["HistoriaClinica"]["ocular_vp"] : 'sin hallazgos'), 1, 1, 'L');
        $pdf->SetX(12);
        $pdf->Cell(186, 4, utf8_decode("PPC: ") . utf8_decode(isset($consulta["HistoriaClinica"]["ocular_ppc"]) && $consulta["HistoriaClinica"]["ocular_ppc"] !== null ? $consulta["HistoriaClinica"]["ocular_ppc"] : 'sin hallazgos'), 1, 1, 'L');
        $pdf->Ln();
	}
}
