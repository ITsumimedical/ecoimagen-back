<?php

namespace App\Formats\ComponentesHistoriaClinica;

class AntecedentesOdontologicosFormato
{
    public function bodyComponente($pdf, $consulta): void
    {
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('ANTECEDENTES ODONTOLÓGICOS'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Ultima consulta: " . utf8_decode($consulta["antecedentesOdontologicos"] !== null ? $consulta["antecedentesOdontologicos"]["ultima_consulta_odontologo"] : 'No Evaluado')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Descripción ultima consulta: " . utf8_decode($consulta["antecedentesOdontologicos"] !== null ? $consulta["antecedentesOdontologicos"]["descripcion_ultima_consulta"] : 'No Evaluado')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Aplicacion de fluor y sellantes: " . utf8_decode($consulta["antecedentesOdontologicos"] !== null ? $consulta["antecedentesOdontologicos"]["aplicacion_fluor_sellantes"] == true ? 'SI - Descripcion: ' . $consulta["antecedentesOdontologicos"]["descripcion_aplicacion_fl_sellante"] : 'NO' : 'NO')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Exodoncias: " . utf8_decode($consulta["antecedentesOdontologicos"] !== null ? $consulta["antecedentesOdontologicos"]["descripcion_exodoncia"] == true ? 'SI - Descripcion: ' . $consulta["antecedentesOdontologicos"]["descripcion_exodoncia"] : 'NO' : 'NO')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Traumas: " . utf8_decode($consulta["antecedentesOdontologicos"] !== null ? $consulta["antecedentesOdontologicos"]["traumas"] == true ? 'SI - Descripcion: ' . $consulta["antecedentesOdontologicos"]["descripcion_trauma"] : 'NO' : 'NO')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Aparatologia: " . utf8_decode($consulta["antecedentesOdontologicos"] !== null ? $consulta["antecedentesOdontologicos"]["aparatologia"] == true ? 'SI - Descripcion: ' . $consulta["antecedentesOdontologicos"]["descripcion_aparatologia"] : 'NO' : 'NO')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Biopsias: " . utf8_decode($consulta["antecedentesOdontologicos"] !== null ? $consulta["antecedentesOdontologicos"]["biopsias"] == true ? 'SI - Descripcion: ' . $consulta["antecedentesOdontologicos"]["descripcion_biopsia"] : 'NO' : 'NO')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Cirugias orales: " . utf8_decode($consulta["antecedentesOdontologicos"] !== null ? $consulta["antecedentesOdontologicos"]["cirugias_orales"] == true ? 'SI - Descripcion: ' . $consulta["antecedentesOdontologicos"]["descripcion_cirugia_oral"] : 'NO' : 'NO')), 1, 'L', 0);

        $pdf->Ln();
    }
}
