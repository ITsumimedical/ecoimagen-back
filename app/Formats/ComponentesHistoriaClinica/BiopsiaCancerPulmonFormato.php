<?php

namespace App\Formats\ComponentesHistoriaClinica;

class BiopsiaCancerPulmonFormato
{
    public function bodyComponente($pdf, $datosCancer): void
    {
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 5, utf8_decode('CÁNCER PULMÓN'), 1, 0, 'C', 1);

        $pdf->Ln(6);
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetX(12);

        $camposCortos = [
            ['Laboratorio que procesa', 'laboratorio_procesa'],
            ['Fecha ingreso IHQ', 'fecha_ingreso_ihq'],
            ['Fecha salida IHQ', 'fecha_salida_ihq'],
            ['Tipo de cáncer de pulmón', 'tipo_cancer_pulmon'],
            ['Clasificación T', 'clasificacion_t'],
            ['Clasificación N', 'clasificacion_n'],
            ['Clasificación M', 'clasificacion_m'],
            ['Estadio inicial', 'estadio_inicial'],
        ];

        foreach (array_chunk($camposCortos, 2) as $fila) {
            $pdf->SetX(12);
            foreach ($fila as [$label, $campo]) {
                $valor = $datosCancer[$campo] ?? 'No refiere';
                if (str_contains($campo, 'fecha') && $valor !== 'No refiere') {
                    $valor = date('d/m/Y', strtotime($valor));
                }
                $pdf->Cell(93, 5, utf8_decode("$label: $valor"), 1);
            }
            $pdf->Ln();
        }

        $subtipo = $datosCancer['subtipo_histologico'] ?? null;
        if ($subtipo === 'Carcinoma de Pulmón de Células no Pequeñas') {
            $pdf->SetX(12);
            $pdf->MultiCell(186, 5, utf8_decode('Subtipo histológico: ' . $subtipo), 1);

            if (!empty($datosCancer['nota_subtipo_histologico'])) {
                $pdf->SetX(12);
                $pdf->MultiCell(186, 5, utf8_decode('Nota subtipo histológico: ' . $datosCancer['nota_subtipo_histologico']), 1);
            }
        }

        $camposLargos = [
            'panel_molecular' => 'Panel molecular',
            'egfr' => 'EGFR',
            'alk' => 'ALK',
            'ros_1' => 'ROS-1',
            'pd_l1' => 'PD-L1',
        ];

        foreach ($camposLargos as $campo => $label) {
            if (!empty($datosCancer[$campo])) {
                $pdf->SetX(12);
                $pdf->MultiCell(186, 5, utf8_decode("$label: " . $datosCancer[$campo]), 1);
            }
        }
    }
}
