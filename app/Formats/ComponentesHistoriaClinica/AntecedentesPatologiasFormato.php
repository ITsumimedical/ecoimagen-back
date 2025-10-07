<?php

namespace App\Formats\ComponentesHistoriaClinica;

use App\Http\Modules\Consultas\Models\Consulta;

class AntecedentesPatologiasFormato
{
    public function bodyComponente($pdf, $consulta): void
    {
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('ANTECEDENTES PATOLOGÍAS'), 1, 0, 'C', 1);        
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(46.5, 4, utf8_decode('PATOLOGÍA CANCER ACTUAL'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(139.5, 4, utf8_decode(isset($consulta["AntecedentesPatologias"]["patologia_cancer_actual"]) ? $consulta["AntecedentesPatologias"]["patologia_cancer_actual"] : 'No reporta'), 1, 'l');
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(46.5, 4, utf8_decode('FDX CANCER ACTUAL'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(46.5, 4,  utf8_decode(isset($consulta["AntecedentesPatologias"]["fdx_cancer_actual"]) ? $consulta["AntecedentesPatologias"]["fdx_cancer_actual"] : 'No reporta'), 1, 0, 'l');
        $pdf->SetX(105);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(46.5, 4, utf8_decode('FLABORATORIO PATOLOGÍA'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(46.5, 4, utf8_decode(isset($consulta["AntecedentesPatologias"]["flaboratorio_patologia"]) ? $consulta["AntecedentesPatologias"]["flaboratorio_patologia"] : 'No reporta'), 1, 'l');
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(46.5, 4, utf8_decode('TUMOR SEGUNDA BIOPSIA'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(46.5, 4, utf8_decode(isset($consulta["AntecedentesPatologias"]["tumor_segunda_biopsia"]) ? $consulta["AntecedentesPatologias"]["tumor_segunda_biopsia"] : 'No reporta'), 1, 0, 'l');
        $pdf->SetX(105);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(46.5, 4, utf8_decode('LOCALIZACION CANCER'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(46.5, 4, utf8_decode(isset($consulta["AntecedentesPatologias"]["localizacion_cancer"]) ? $consulta["AntecedentesPatologias"]["localizacion_cancer"] : 'No reporta'), 1, 'l');
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(46.5, 4, utf8_decode('DUKES'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(46.5, 4, utf8_decode(isset($consulta["AntecedentesPatologias"]["dukes"]) ? $consulta["AntecedentesPatologias"]["dukes"] : 'No reporta'), 1, 0, 'l');
        $pdf->SetX(105);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(46.5, 4, utf8_decode('GLEASON'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(46.5, 4, utf8_decode(isset($consulta["AntecedentesPatologias"]["gleason"]) ? $consulta["AntecedentesPatologias"]["gleason"] : 'No reporta'), 1, 'l');
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(46.5, 4, utf8_decode('HER2'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(46.5, 4, utf8_decode(isset($consulta["AntecedentesPatologias"]["her2"]) ? $consulta["AntecedentesPatologias"]["her2"] : 'No reporta'), 1, 0, 'l');
        $pdf->SetX(105);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(46.5, 4, utf8_decode('ESTADIFICACION CLINICA'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(46.5, 4, utf8_decode(isset($consulta["AntecedentesPatologias"]["estadificacion_clinica"]) ? $consulta["AntecedentesPatologias"]["estadificacion_clinica"] : 'No reporta'), 1, 'l');
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(46.5, 4, utf8_decode('ESTADIFICACION INICIAL'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(139.5, 4, utf8_decode(isset($consulta["AntecedentesPatologias"]["estadificacion_inicial"]) ? $consulta["AntecedentesPatologias"]["estadificacion_inicial"] : 'No reporta'), 1, 'l');
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(46.5, 4, utf8_decode('FECHA ESTADIFICACION'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(46.5, 4, utf8_decode(isset($consulta["AntecedentesPatologias"]["fecha_estadificacion"]) ? $consulta["AntecedentesPatologias"]["fecha_estadificacion"] : 'No reporta'), 1, 'l');
        $pdf->Ln();
    }
}