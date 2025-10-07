<?php

namespace App\Formats\ComponentesHistoriaClinica;

class ConductasRelacionamientoFormato
{
    public function bodyComponente($pdf, $consulta): void
    {
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('CONDUCTAS Y RELACIONAMIENTO'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 8);
        $pdf->SetTextColor(0);

        $campos = [
            'alimentacion' => 'Alimentación',
            'higiene' => 'Higiene',
            'sueno' => 'Sueño',
            'independencia_personal' => 'Independencia personal',
            'actividad' => 'Actividad',
            'atencion' => 'Atención',
            'impulsividad' => 'Impulsividad',
            'crisis_colericas' => 'Crisis coléricas',
            'adaptacion' => 'Adaptación',
            'labilidad_emocional' => 'Labilidad emocional',
            'relaciones_familiares' => 'Relaciones familiares',
            'tiempo_libre' => 'Tiempo libre',
            'ruidos_altos' => 'Ruidos altos',
            'socializacion' => 'Socialización',
        ];

        $pdf->SetX(12);
        foreach ($campos as $clave => $etiqueta) {
            $valor = $consulta['conductaRelacionamiento'][$clave] ?? 'No refiere';
            $pdf->SetX(12);
            $pdf->MultiCell(186, 6, utf8_decode("{$etiqueta}: {$valor}"), 1);
        }

        $pdf->Ln();
    }
}
