<?php

namespace App\Formats\ComponentesHistoriaClinica;

class PatologiaRespiratoriaFormato
{
    public function bodyComponente($pdf, $consulta): void
    {
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('PATOLOGIAS RESPIRATORIAS'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();
        if (isset($consulta['patologiaRespiratoria'])) {

            $patologiaRespiratoria = $consulta['patologiaRespiratoria'];
            foreach ($patologiaRespiratoria as $patologiaRespiratorias) {
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 9);
                $pdf->Cell(93, 4, utf8_decode("Hipoapnea obstructiva del Sueño: ") . '' . utf8_decode($patologiaRespiratorias->hipoapnea_obstructiva_sueno ? "Sí" : "No"), 1, 0, 'L');

                $pdf->Cell(93, 4, utf8_decode("Presenta sindrome de apnea: ") . '' . utf8_decode($patologiaRespiratorias->presenta_sindrome_apnea ? "Sí" : "No"), 1, 0, 'L');
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->Cell(93, 4, utf8_decode("Tipo de Apnea: ") . '' . utf8_decode($patologiaRespiratorias->tipoApnea), 1, 0, 'L');
                $pdf->Cell(93, 4, utf8_decode("Origen: ") . '' . utf8_decode($patologiaRespiratorias->origen), 1, 0, 'L');
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->Cell(186, 4, utf8_decode("Uso de CPAP/BIPAP: ") . '' . utf8_decode($patologiaRespiratorias->uso_cpap_bipap ? "Sí" : "No"), 1, 0, 'L');
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 9);
                $pdf->MultiCell(186, 4, "Observaciones: " . utf8_decode($patologiaRespiratorias->observacion_uso), 1, 'L', 0);
                $pdf->SetX(12);
                $pdf->Cell(186, 4, utf8_decode("Adherencia de CPAP/BIPAP: ") . '' . utf8_decode($patologiaRespiratorias->adherencia_cpap_bipap ? "Sí" : "No"), 1, 1, 'L');
                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 9);
                $pdf->MultiCell(186, 4, "Observaciones: " . utf8_decode($patologiaRespiratorias->observacion_adherencia), 1, 'L', 0);
                $pdf->SetX(12);
                $pdf->Cell(80, 4, utf8_decode("Uso de Oxigeno ") . utf8_decode($patologiaRespiratorias->uso_oxigeno ? "Sí" : "No"), 1, 0, 'L');
                $pdf->Cell(106, 4, utf8_decode("Litros de  Oxigeno: ") . '' . utf8_decode($patologiaRespiratorias->litro_oxigeno), 1, 0, 'L');
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->Cell(186, 4, utf8_decode("Clasificación del Control del Asma: ") . '' . utf8_decode($patologiaRespiratorias->clasificacion_control_asma), 1, 0, 'L');
                $pdf->Ln();
                $pdf->SetX(12);
            }
        } else {
            $pdf->Cell(186, 4, utf8_decode("No hay Registros en Patologia Respiratoria"), 1, 0, 'L');
            $pdf->Ln();
            $pdf->SetX(12);
        }

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();
    }
}