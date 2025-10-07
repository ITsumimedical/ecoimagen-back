<?php

namespace App\Formats\ComponentesHistoriaClinica;

class ExamenFisicoFisioterapiaFormato
{
    public function bodyComponente($pdf, $consulta): void
    {
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('EXÁMEN FISICO'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(62, 4, "Dolor presente: " . utf8_decode(isset($consulta["ExamenFisioterapia"]["dolor_presente"]) && $consulta["ExamenFisioterapia"]["dolor_presente"] !== null ? $consulta["ExamenFisioterapia"]["dolor_presente"] : 'sin hallazgos'), 1, 0, 'L');
        if ($consulta["ExamenFisioterapia"]["dolor_presente"] == 'Si') {
           $pdf->Cell(62, 4, "Frecuencia del dolor: " . utf8_decode(isset($consulta["ExamenFisioterapia"]["frecuencia_dolo"]) && $consulta["ExamenFisioterapia"]["frecuencia_dolo"] !== null ? $consulta["ExamenFisioterapia"]["frecuencia_dolo"] : 'sin hallazgos'), 1, 0, 'L');
           $pdf->Cell(62, 4, "Intensidad del dolor: " . utf8_decode(isset($consulta["ExamenFisioterapia"]["intensidad_dolor"]) && $consulta["ExamenFisioterapia"]["intensidad_dolor"] !== null ? $consulta["ExamenFisioterapia"]["intensidad_dolor"] : 'sin hallazgos'), 1, 0, 'L');
       }
       $pdf->Ln();
       $pdf->SetX(12);
       $pdf->Cell(93, 4, "Presenta edema: " . utf8_decode(isset($consulta["ExamenFisioterapia"]["edema_presente"]) && $consulta["ExamenFisioterapia"]["edema_presente"] !== null ? $consulta["ExamenFisioterapia"]["edema_presente"] : 'sin hallazgos'), 1, 0, 'L');
       if($consulta["ExamenFisioterapia"]["edema_presente"] == 'Si') {
           $pdf->Cell(93, 4, utf8_decode("Ubicación: ") . utf8_decode(isset($consulta["ExamenFisioterapia"]["ubicacion_edema"]) && $consulta["ExamenFisioterapia"]["ubicacion_edema"] !== null ? $consulta["ExamenFisioterapia"]["ubicacion_edema"] : 'sin hallazgos'), 1, 0, 'L');
       }
       $pdf->Ln();
       $pdf->SetX(12);
       $pdf->Cell(93, 4, "Sensibilidad Conservada: " . utf8_decode(isset($consulta["ExamenFisioterapia"]["sensibilidad_conservada"]) && $consulta["ExamenFisioterapia"]["sensibilidad_conservada"] !== null ? $consulta["ExamenFisioterapia"]["sensibilidad_conservada"] : 'sin hallazgos'), 1, 0, 'L');
       $pdf->Cell(93, 4, "Sensibilidad Alterada: " . utf8_decode(isset($consulta["ExamenFisioterapia"]["sensibilidad_alterada"]) && $consulta["ExamenFisioterapia"]["sensibilidad_alterada"] !== null ? $consulta["ExamenFisioterapia"]["sensibilidad_alterada"] : 'sin hallazgos'), 1, 0, 'L');
       $pdf->Ln();
       $pdf->SetX(12);
       $pdf->SetFillColor(255, 255, 255);
       $pdf->MultiCell(186, 4, "Ubicacion Sensibilidad: " . utf8_decode(isset($consulta["ExamenFisioterapia"]["ubicacion_sensibilidad"]) && $consulta["ExamenFisioterapia"]["ubicacion_sensibilidad"] !== null ? $consulta["ExamenFisioterapia"]["ubicacion_sensibilidad"] : 'sin hallazgos'), 1, 0, 'L');
       $pdf->SetX(12);
       $pdf->Cell(93, 4, utf8_decode("Calificación Fuerza Muscular: ") . utf8_decode(isset($consulta["ExamenFisioterapia"]["fuerza_muscular"]) && $consulta["ExamenFisioterapia"]["fuerza_muscular"] !== null ? $consulta["ExamenFisioterapia"]["fuerza_muscular"] : 'sin hallazgos'), 1, 0, 'L');
       $pdf->MultiCell(93, 4, "Pruebas semiologicas: " . utf8_decode(isset($consulta["ExamenFisioterapia"]["pruebas_semiologicas"]) && $consulta["ExamenFisioterapia"]["pruebas_semiologicas"] !== null ? $consulta["ExamenFisioterapia"]["pruebas_semiologicas"] : 'sin hallazgos'), 1, 0, 'L');
       $pdf->SetX(12);
       $pdf->Cell(46.5, 4, "Equilibrio Conservado: " . utf8_decode(isset($consulta["ExamenFisioterapia"]["equilibrio_conservado"]) && $consulta["ExamenFisioterapia"]["equilibrio_conservado"] !== null ? $consulta["ExamenFisioterapia"]["equilibrio_conservado"] : 'sin hallazgos'), 1, 0, 'L');
       $pdf->Cell(46.5, 4, "Equilibrio Alterado: " . utf8_decode(isset($consulta["ExamenFisioterapia"]["equilibrio_alterado"]) && $consulta["ExamenFisioterapia"]["equilibrio_alterado"] !== null ? $consulta["ExamenFisioterapia"]["equilibrio_alterado"] : 'sin hallazgos'), 1, 0, 'L');
       $pdf->Cell(46.5, 4, "Marcha Conservada: " . utf8_decode(isset($consulta["ExamenFisioterapia"]["marcha_conservada"]) && $consulta["ExamenFisioterapia"]["marcha_conservada"] !== null ? $consulta["ExamenFisioterapia"]["marcha_conservada"] : 'sin hallazgos'), 1, 0, 'L');
       $pdf->Cell(46.5, 4, "Marcha Alterada: " . utf8_decode(isset($consulta["ExamenFisioterapia"]["marcha_alterada"]) && $consulta["ExamenFisioterapia"]["marcha_alterada"] !== null ? $consulta["ExamenFisioterapia"]["marcha_alterada"] : 'sin hallazgos'), 1, 0, 'L');
       $pdf->Ln();
       $pdf->SetX(12);
       $pdf->MultiCell(186, 4, "Ayudas Externas: " . utf8_decode(isset($consulta["ExamenFisioterapia"]["ayudas_externas"]) && $consulta["ExamenFisioterapia"]["ayudas_externas"] !== null ? $consulta["ExamenFisioterapia"]["ayudas_externas"] : 'sin hallazgos'), 1, 0, 'L');
       $pdf->Ln();
    }
}
