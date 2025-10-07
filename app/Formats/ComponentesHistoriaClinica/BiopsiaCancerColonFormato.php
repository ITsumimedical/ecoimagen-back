<?php

namespace App\Formats\ComponentesHistoriaClinica;

class BiopsiaCancerColonFormato
{
    public function bodyComponente($pdf, $datosCancer): void
    {
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('CÁNCER COLON'), 1, 0, 'C', 1);
        $pdf->Ln(5);

        $pdf->SetFont('Arial', '', 9);

        $camposCortos = [
            ['Ubicación lesión', 'ubicacion_leson'],
            ['Laboratorio que procesa', 'laboratorio_procesa'],
            ['Nombre del patólogo', 'nombre_patologo'],
            ['Fecha ingreso IHQ', 'fecha_ingreso_ihq'],
            ['Fecha salida IHQ', 'fecha_salida_ihq'],
        ];

        foreach (array_chunk($camposCortos, 3) as $fila) {
            $pdf->SetX(12);
            foreach ($fila as [$label, $campo]) {
                $valor = $datosCancer[$campo] ?? 'No refiere';

                if (str_starts_with($campo, 'fecha_') && $valor !== 'No refiere') {
                    $valor = date('Y-m-d', strtotime($valor));
                }

                $pdf->Cell(62, 6, utf8_decode("$label: $valor"), 1);
            }
            $pdf->Ln();
        }

        $tipoCancer = $datosCancer['tipo_cancer_colon'] ?? 'No refiere';
        $pdf->SetX(12);
        $pdf->MultiCell(186, 6, utf8_decode("Tipo de cáncer de colon: $tipoCancer"), 1);

        // Subtipo solo si aplica
        if ($tipoCancer === 'Adenocarcinoma') {
            $subtipo = $datosCancer['subtipo_adenocarcinoma'] ?? 'No refiere';
            $pdf->SetX(12);
            $pdf->Cell(186, 6, utf8_decode("Subtipo de adenocarcinoma: $subtipo"), 1);
            $pdf->Ln();
        }

        $camposLargos = [
            ['Clasificación T', 'clasificacion_t'],
            ['Clasificación N', 'clasificacion_n'],
            ['Clasificación M', 'clasificacion_m'],
            ['Estadio', 'estadio'],
            ['Cambio de estadio', 'cambio_estadio'],
        ];

        foreach ($camposLargos as [$label, $campo]) {
            $valor = $datosCancer[$campo] ?? 'No refiere';
            $pdf->SetX(12);
            $pdf->MultiCell(186, 6, utf8_decode("$label: $valor"), 1);
        }
    }
}
