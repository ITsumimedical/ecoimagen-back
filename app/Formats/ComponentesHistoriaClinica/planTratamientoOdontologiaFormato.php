<?php

namespace App\Formats\ComponentesHistoriaClinica;

class planTratamientoOdontologiaFormato
{

    public function bodyComponente($pdf, $consulta): void
    {
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('PLAN DE TRATAMIENTO'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Operatoria: " . utf8_decode($consulta["planTramientoOdontologia"] !== null ? $consulta["planTramientoOdontologia"]["operatoria"] !== null ? $consulta["planTramientoOdontologia"]["operatoria"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Periodancia: " . utf8_decode($consulta["planTramientoOdontologia"] !== null ? $consulta["planTramientoOdontologia"]["periodancia"] !== null ? $consulta["planTramientoOdontologia"]["periodancia"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Endodoncia: " . utf8_decode($consulta["planTramientoOdontologia"] !== null ? $consulta["planTramientoOdontologia"]["endodoncia"] !== null ? $consulta["planTramientoOdontologia"]["endodoncia"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Cirugia oral: " . utf8_decode($consulta["planTramientoOdontologia"] !== null ? $consulta["planTramientoOdontologia"]["cirugia_oral"] !== null ? $consulta["planTramientoOdontologia"]["cirugia_oral"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Remision: " . utf8_decode($consulta["planTramientoOdontologia"] !== null ? $consulta["planTramientoOdontologia"]["remision"] !== null ? $consulta["planTramientoOdontologia"]["remision"] : 'No' : 'No')), 1, 'L', 0);
        $pdf->Ln();


        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('PROMOCIÓN Y PREVENCIÓN'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Educacion higiene oral: " . utf8_decode($consulta["planTramientoOdontologia"] !== null ? $consulta["planTramientoOdontologia"]["educacion_higiene_oral"] !== null ? $consulta["planTramientoOdontologia"]["educacion_higiene_oral"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Control de placa: " . utf8_decode($consulta["planTramientoOdontologia"] !== null ? $consulta["planTramientoOdontologia"]["control_de_placa"] !== null ? $consulta["planTramientoOdontologia"]["control_de_placa"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Profilaxis: " . utf8_decode($consulta["planTramientoOdontologia"] !== null ? $consulta["planTramientoOdontologia"]["profilaxis"] !== null ? $consulta["planTramientoOdontologia"]["profilaxis"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Detrartraje: " . utf8_decode($consulta["planTramientoOdontologia"] !== null ? $consulta["planTramientoOdontologia"]["detrartraje"] !== null ? $consulta["planTramientoOdontologia"]["detrartraje"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Topización barniz de fluor: " . utf8_decode($consulta["planTramientoOdontologia"] !== null ? $consulta["planTramientoOdontologia"]["topizacion_barniz_fluor"] !== null ? $consulta["planTramientoOdontologia"]["topizacion_barniz_fluor"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Sellantes: " . utf8_decode($consulta["planTramientoOdontologia"] !== null ? $consulta["planTramientoOdontologia"]["sellantes"] !== null ? $consulta["planTramientoOdontologia"]["sellantes"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Remision RIAS: " . utf8_decode($consulta["planTramientoOdontologia"] !== null ? $consulta["planTramientoOdontologia"]["remision_rias"] !== null ? $consulta["planTramientoOdontologia"]["remision_rias"] : 'No' : 'No')), 1, 'L', 0);
        $pdf->Ln();
    }
}
