<?php

namespace App\Formats\ComponentesHistoriaClinica;

class HabitosHigieneOralFormato
{
    public function bodyComponente($pdf, $consulta): void
    {
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('HÁBITOS HIGIENE ORAL'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Frecuencia de cepillado: " . utf8_decode($consulta["HistoriaClinica"] !== null ? $consulta["HistoriaClinica"]["frecuencia_cepillado"] : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Quien realiza la higiene: " . utf8_decode($consulta["HistoriaClinica"] !== null ? $consulta["HistoriaClinica"]["realiza_higiene"] : ' ')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Uso de crema dental: " . utf8_decode($consulta["HistoriaClinica"] !== null ? $consulta["HistoriaClinica"]["uso_crema_dental"] !== null ? $consulta["HistoriaClinica"]["uso_crema_dental"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Uso de seda dental: " . utf8_decode($consulta["HistoriaClinica"] !== null ? $consulta["HistoriaClinica"]["uso_seda_dental"] !== null ? $consulta["HistoriaClinica"]["uso_seda_dental"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Uso de enjuague bucal: " . utf8_decode($consulta["HistoriaClinica"] !== null ? $consulta["HistoriaClinica"]["uso_enjuague_bucal"] !== null ? $consulta["HistoriaClinica"]["uso_enjuague_bucal"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Uso de aparatología ortopédica: " . utf8_decode($consulta["HistoriaClinica"] !== null ? $consulta["HistoriaClinica"]["uso_aparatologia_ortopedica"] !== null ? $consulta["HistoriaClinica"]["uso_aparatologia_ortopedica"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Uso de aditamentos protésicos removibles: " . utf8_decode($consulta["HistoriaClinica"] !== null ? $consulta["HistoriaClinica"]["uso_adimentos_protesicos_removibles"] !== null ? $consulta["HistoriaClinica"]["uso_adimentos_protesicos_removibles"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Higiene de los aparatos o prótesis: " . utf8_decode($consulta["HistoriaClinica"] !== null ? $consulta["HistoriaClinica"]["higiene_aparatos_protesis"] !== null ? $consulta["HistoriaClinica"]["higiene_aparatos_protesis"] : 'No' : 'No')), 1, 'L', 0);

    }
}
