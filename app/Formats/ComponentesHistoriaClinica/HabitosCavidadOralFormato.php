<?php

namespace App\Formats\ComponentesHistoriaClinica;

class HabitosCavidadOralFormato
{
    public function bodyComponente($pdf, $consulta): void
    {
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('HÁBITOS CAVIDAD ORAL'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Respiración bucal:	" . utf8_decode($consulta["HistoriaClinica"] !== null ? $consulta["HistoriaClinica"]["respiracion_bucal"] !== null ? $consulta["HistoriaClinica"]["respiracion_bucal"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Succión digital: " . utf8_decode($consulta["HistoriaClinica"] !== null ? $consulta["HistoriaClinica"]["succion_digital"] !== null ? $consulta["HistoriaClinica"]["succion_digital"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Lengua protactil: " . utf8_decode($consulta["HistoriaClinica"] !== null ? $consulta["HistoriaClinica"]["lengua_protactil"] !== null ? $consulta["HistoriaClinica"]["lengua_protactil"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Onicofagia: " . utf8_decode($consulta["HistoriaClinica"] !== null ? $consulta["HistoriaClinica"]["onicofagia"] !== null ? $consulta["HistoriaClinica"]["onicofagia"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Queilofagia: " . utf8_decode($consulta["HistoriaClinica"] !== null ? $consulta["HistoriaClinica"]["queilofagia"] !== null ? $consulta["HistoriaClinica"]["queilofagia"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Mordisqueo: " . utf8_decode($consulta["HistoriaClinica"] !== null ? $consulta["HistoriaClinica"]["mordisqueo"] !== null ? $consulta["HistoriaClinica"]["mordisqueo"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Biberón: " . utf8_decode($consulta["HistoriaClinica"] !== null ? $consulta["HistoriaClinica"]["biberon"] !== null ? $consulta["HistoriaClinica"]["biberon"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Chupos: " . utf8_decode($consulta["HistoriaClinica"] !== null ? $consulta["HistoriaClinica"]["chupos"] !== null ? $consulta["HistoriaClinica"]["chupos"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Otros: " . utf8_decode($consulta["HistoriaClinica"] !== null ? $consulta["HistoriaClinica"]["otros"] !== null ? $consulta["HistoriaClinica"]["otros"] : 'No' : 'No')), 1, 'L', 0);

    }
}
