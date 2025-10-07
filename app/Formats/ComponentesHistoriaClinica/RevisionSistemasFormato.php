<?php

namespace App\Formats\ComponentesHistoriaClinica;

class RevisionSistemasFormato
{
    public function bodyComponente($pdf, $consulta)
    {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetX(12);
        $pdf->Cell(186, 4, utf8_decode('REVISIÓN POR SISTEMAS'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $revisionSistemas = 'No refiere';
        if (isset($consulta["HistoriaClinica"])) {
            $descripcion = $consulta["HistoriaClinica"]["descripcion_revision_sistemas"] ?? 'No refiere';
            $revisionSistemas = "Descripción: " . $descripcion;
        }
        $pdf->MultiCell(186, 4, utf8_decode($revisionSistemas), 1, "L", 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $sintomaticoRespiratorio = 'No refiere';

        if (isset($consulta["HistoriaClinica"])) {
            $resultado = $consulta["HistoriaClinica"]["sintomatico_respiratorio"] ?? null;
            // Verificamos si el resultado es true o false
            if (is_bool($resultado)) {
                $descripcion = $resultado ? 'Sí' : 'No';
            } else {
                $descripcion = 'No refiere';
            }
            $sintomaticoRespiratorio = "Sintomatico Respiratorio: " . $descripcion;
        }
        $pdf->MultiCell(186, 4, utf8_decode($sintomaticoRespiratorio), 1, "L", 0);

        //Se imprime el resultado sintomatico de piel
        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $sintomaticoPiel = 'No refiere';
        if (isset($consulta["HistoriaClinica"])) {
            $resultado = $consulta["HistoriaClinica"]["sintomatico_piel"] ?? null;
            // Verificamos si el resultado es true o false
            if (is_bool($resultado)) {
                $descripcion = $resultado ? 'Sí' : 'No';
            } else {
                $descripcion = 'No refiere';
            }
            $sintomaticoPiel = "Sintomatico de piel: " . $descripcion;
        }
        $pdf->MultiCell(186, 4, utf8_decode($sintomaticoPiel), 1, "L", 0);
        $pdf->Ln();
    }
}
