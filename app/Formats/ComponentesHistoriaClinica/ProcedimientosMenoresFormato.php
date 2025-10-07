<?php

namespace App\Formats\ComponentesHistoriaClinica;


class ProcedimientosMenoresFormato
{
    public function bodyComponente($pdf, $consulta): void
    {
        $y = $pdf->GetY();
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('PROCEDIMIENTO'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $nombreCup = 'No Refiere';

        if (isset($consulta["HistoriaClinica"])) {
            $historiaClinica = $consulta["HistoriaClinica"];
            $nombre_cup = $historiaClinica["cupMenor"]["nombre"] ?? 'No Refiere';
            $nombreCup = "Nombre: " . $nombre_cup;
        }
        $pdf->MultiCell(186, 4, utf8_decode($nombreCup), 1, "L", 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetX(12);
        $pdf->MultiCell(186, 4, utf8_decode('Descripción: ' . $consulta["HistoriaClinica"]['procedimiento_menor']), 1, 'L');

        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('INSUMOS Y MEDICAMENTOS'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();
        foreach ($consulta->insumos as $insumo) {
            $codesumi_nombre = $insumo->codesumi->nombre ?? 'N/A';
            $cantidad = $insumo->cantidad ?? 'N/A';
            $texto_insumo = "$codesumi_nombre - Cantidad: $cantidad";

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(186, 4, utf8_decode($texto_insumo), 1, 1, 'L', 0);
        }
        $pdf->Ln();
    }
}
