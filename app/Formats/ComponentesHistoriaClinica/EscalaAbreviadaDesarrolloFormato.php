<?php

namespace App\Formats\ComponentesHistoriaClinica;

class EscalaAbreviadaDesarrolloFormato
{
    public function bodyComponente($pdf, $consulta): void
    {
        $y = $pdf->GetY();
        $pdf->SetXY(12, $y + 8);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('ESCALA ABREVIADA DE DESARROLLO'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetFont('arial', '', '9');
        $interpretaciones = [
            'Alto' => 'Desarrollo esperado para la edad.',
            'Medio' => 'Riesgo de problemas de desarrollo.',
            'Bajo' => 'Sospecha de problemas de desarrollo.'
        ];        
    
        $pdf->Cell(186, 4, utf8_decode(
            isset($consulta["RegistroEscalaAbreviadaDesarrollo"]["interpretacion_motricidad_gruesa"]) 
            ? "Motricidad gruesa: " . 
                ($interpretaciones[$consulta["RegistroEscalaAbreviadaDesarrollo"]["interpretacion_motricidad_gruesa"]] 
                ?? $consulta["RegistroEscalaAbreviadaDesarrollo"]["interpretacion_motricidad_gruesa"]) . 
                " - PT: " . 
                (isset($consulta["RegistroEscalaAbreviadaDesarrollo"]["puntuacion_total_motricidad_gruesa"]) 
                    ? $consulta["RegistroEscalaAbreviadaDesarrollo"]["puntuacion_total_motricidad_gruesa"] 
                    : "Sin puntuación")
            : "Motricidad gruesa: No Evaluado"
        ), 1, 0, 'L', 0);

        $pdf->Ln();
        $pdf->SetX(12);
        
        $pdf->Cell(186, 4, utf8_decode(
            isset($consulta["RegistroEscalaAbreviadaDesarrollo"]["interpretacion_finoadaptativa"]) 
            ? "Motricidad finoadaptativa: " . ($interpretaciones[$consulta["RegistroEscalaAbreviadaDesarrollo"]["interpretacion_finoadaptativa"]] ?? $consulta["RegistroEscalaAbreviadaDesarrollo"]["interpretacion_finoadaptativa"]) .
                " - PT: " . 
                (isset($consulta["RegistroEscalaAbreviadaDesarrollo"]["puntuacion_total_motricidad_finoadaptativa"]) 
                    ? $consulta["RegistroEscalaAbreviadaDesarrollo"]["puntuacion_total_motricidad_finoadaptativa"] 
                    : "Sin puntuación")
            : "Motricidad finoadaptativa: No Evaluado"
        ), 1, 0, 'L', 0);

        $pdf->Ln();
        $pdf->SetX(12);
        
        $pdf->Cell(186, 4, utf8_decode(
            isset($consulta["RegistroEscalaAbreviadaDesarrollo"]["interpretacion_audicion_lenguaje"]) 
            ? "Audición lenguaje: " . ($interpretaciones[$consulta["RegistroEscalaAbreviadaDesarrollo"]["interpretacion_audicion_lenguaje"]] ?? $consulta["RegistroEscalaAbreviadaDesarrollo"]["interpretacion_audicion_lenguaje"]) .
                " - PT: " . 
                (isset($consulta["RegistroEscalaAbreviadaDesarrollo"]["puntuacion_total_audicion_lenguaje"]) 
                    ? $consulta["RegistroEscalaAbreviadaDesarrollo"]["puntuacion_total_audicion_lenguaje"] 
                    : "Sin puntuación")
            : "Audición lenguaje: No Evaluado"
        ), 1, 0, 'L', 0);

        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->Cell(186, 4, utf8_decode(
            isset($consulta["RegistroEscalaAbreviadaDesarrollo"]["interpretacion_persona_social"]) 
            ? "Área personal social: " . ($interpretaciones[$consulta["RegistroEscalaAbreviadaDesarrollo"]["interpretacion_persona_social"]] ?? $consulta["RegistroEscalaAbreviadaDesarrollo"]["interpretacion_persona_social"]) . 
                " - PT: " . 
                (isset($consulta["RegistroEscalaAbreviadaDesarrollo"]["puntuacion_total_persona_social"]) 
                    ? $consulta["RegistroEscalaAbreviadaDesarrollo"]["puntuacion_total_persona_social"] 
                    : "Sin puntuación")
            : "Área personal social: No Evaluado"
        ), 1, 0, 'L', 0);
        $pdf->Ln();

        $mchat = new MchatFormato();
        $mchat->bodyComponente($pdf, $consulta);
    }
}
