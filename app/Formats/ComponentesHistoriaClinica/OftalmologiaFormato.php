<?php

namespace App\Formats\ComponentesHistoriaClinica;

class OftalmologiaFormato
{
    public function bodyComponente($pdf, $consulta): void
    {
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('OFTALMOLOGIA'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "AVCC OJO DERECHO: " . utf8_decode(isset($consulta["HistoriaClinica"]["avcc_ojoderecho"]) && $consulta["HistoriaClinica"]["avcc_ojoderecho"] !== null ? $consulta["HistoriaClinica"]["avcc_ojoderecho"] : 'No Evaluado'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "AVCC OJO IZQUIERDO: " . utf8_decode(isset($consulta["HistoriaClinica"]["avcc_ojoizquierdo"]) && $consulta["HistoriaClinica"]["avcc_ojoizquierdo"] !== null ? $consulta["HistoriaClinica"]["avcc_ojoizquierdo"] : 'No Evaluado'), 1, 'L', 0);


        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "AVSC OJO DERECHO: " . utf8_decode(isset($consulta["HistoriaClinica"]["avsc_ojoderecho"]) && $consulta["HistoriaClinica"]["avsc_ojoderecho"] !== null ? $consulta["HistoriaClinica"]["avsc_ojoderecho"] : 'No Evaluado'), 1, 'L', 0);


        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "AVSC OJO IZQUIERDO: " . utf8_decode(isset($consulta["HistoriaClinica"]["avsc_ojoizquierdo"]) && $consulta["HistoriaClinica"]["avsc_ojoizquierdo"] !== null ? $consulta["HistoriaClinica"]["avsc_ojoizquierdo"] : 'No Evaluado'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "PH OJO DERECHO: " . utf8_decode(isset($consulta["HistoriaClinica"]["ph_ojoderecho"]) && $consulta["HistoriaClinica"]["ph_ojoderecho"] !== null ? $consulta["HistoriaClinica"]["ph_ojoderecho"] : 'No Evaluado'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "PH OJO IZQUIERDO: " . utf8_decode(isset($consulta["HistoriaClinica"]["ph_ojoizquierdo"]) && $consulta["HistoriaClinica"]["ph_ojoizquierdo"] !== null ? $consulta["HistoriaClinica"]["ph_ojoizquierdo"] : 'No Evaluado'), 1, 'L', 0);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('MOTILIDAD OCULAR'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "OJO DERECHO: " . utf8_decode(isset($consulta["HistoriaClinica"]["motilidad_ojoderecho"]) && $consulta["HistoriaClinica"]["motilidad_ojoderecho"] !== null ? $consulta["HistoriaClinica"]["motilidad_ojoderecho"] : 'No Evaluado'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "COVERT TEST DERECHO: " . utf8_decode(isset($consulta["HistoriaClinica"]["covert_ojoderecho"]) && $consulta["HistoriaClinica"]["covert_ojoderecho"] !== null ? $consulta["HistoriaClinica"]["covert_ojoderecho"] : 'No Evaluado'), 1, 'L', 0);


        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "OJO IZQUIERDO: " . utf8_decode(isset($consulta["HistoriaClinica"]["motilidad_ojoizquierdo"]) && $consulta["HistoriaClinica"]["motilidad_ojoizquierdo"] !== null ? $consulta["HistoriaClinica"]["motilidad_ojoizquierdo"] : 'No Evaluado'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "COVERT TEST IZQUIERDO: " . utf8_decode(isset($consulta["HistoriaClinica"]["covert_ojoizquierdo"]) && $consulta["HistoriaClinica"]["covert_ojoizquierdo"] !== null ? $consulta["HistoriaClinica"]["covert_ojoizquierdo"] : 'No Evaluado'), 1, 'L', 0);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('BIOMICROSCOPIA'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "OJO DERECHO: " . utf8_decode(isset($consulta["HistoriaClinica"]["biomicros_ojoderecho"]) && $consulta["HistoriaClinica"]["biomicros_ojoderecho"] !== null ? $consulta["HistoriaClinica"]["biomicros_ojoderecho"] : 'No Evaluado'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "OJO IZQUIERDO: " . utf8_decode(isset($consulta["HistoriaClinica"]["biomicros_ojoizquierdo"]) && $consulta["HistoriaClinica"]["biomicros_ojoizquierdo"] !== null ? $consulta["HistoriaClinica"]["biomicros_ojoizquierdo"] : 'No Evaluado'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('PRESION INTRAOCULAR'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "OJO DERECHO: " . utf8_decode(isset($consulta["HistoriaClinica"]["presionintra_ojoderecho"]) && $consulta["HistoriaClinica"]["presionintra_ojoderecho"] !== null ? $consulta["HistoriaClinica"]["presionintra_ojoderecho"] : 'No Evaluado'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "OJO IZQUIERDO: " . utf8_decode(isset($consulta["HistoriaClinica"]["presionintra_ojoizquierdo"]) && $consulta["HistoriaClinica"]["presionintra_ojoizquierdo"] !== null ? $consulta["HistoriaClinica"]["presionintra_ojoizquierdo"] : 'No Evaluado'), 1, 'L', 0);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('GIONIOSCOPIA'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "OJO DERECHO: " . utf8_decode(isset($consulta["HistoriaClinica"]["gionios_ojoderecho"]) && $consulta["HistoriaClinica"]["gionios_ojoderecho"] !== null ? $consulta["HistoriaClinica"]["gionios_ojoderecho"] : 'No Evaluado'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "OJO IZQUIERDO: " . utf8_decode(isset($consulta["HistoriaClinica"]["gionios_ojoizquierdo"]) && $consulta["HistoriaClinica"]["gionios_ojoizquierdo"] !== null ? $consulta["HistoriaClinica"]["gionios_ojoizquierdo"] : 'No Evaluado'), 1, 'L', 0);
        $pdf->Ln();
    }

}
