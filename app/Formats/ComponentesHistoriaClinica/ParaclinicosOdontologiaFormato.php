<?php

namespace App\Formats\ComponentesHistoriaClinica;

class ParaclinicosOdontologiaFormato
{

    public function bodyComponente($pdf, $consulta): void
    {
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('PARACLINICOS'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);
        if (count($consulta["paraclinicosOdontologicos"]) > 0) {
            foreach ($consulta["paraclinicosOdontologicos"] as $odontograma) {
                $textoOdontograma = "Laboratorio: " . utf8_decode($odontograma->laboratorio) . ", Lectura Radiografica: " . utf8_decode($odontograma->lectura_radiografica) .
                    ", otros: " . utf8_decode($odontograma->oclusal ? $odontograma->otros : 'No Refiere');
                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode($textoOdontograma), 1, 'L');
            }
        } else {
            $textoOdontograma = utf8_decode('No Refiere');
            $pdf->SetX(12);
            $pdf->MultiCell(186, 4, utf8_decode($textoOdontograma), 1, 'L');
        }

    }
}
