<?php

namespace App\Formats\ComponentesHistoriaClinica;

class BiopsiaCancerMamaFormato
{
    public function bodyComponente($pdf, $datosCancer): void
    {
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('CÁNCER MAMA'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 8);

        $camposCortos = [
            ['Laboratorio que procesa', 'laboratorio_procesa'],
            ['Nombre del patólogo', 'nombre_patologo'],
            ['Fecha ingreso IHQ', 'fecha_ingreso_ihq'],
            ['Fecha salida IHQ', 'fecha_salida_ihq'],
            ['Estrógenos', 'estrogenos'],
            ['% Estrógenos', 'porcentaje_estrogenos'],
            ['Progestágenos', 'progestagenos'],
            ['% Progestágenos', 'porcentaje_progestagenos'],
            ['Ki-67', 'ki_67'],
            ['Her2', 'her2']
        ];

        foreach (array_chunk($camposCortos, 2) as $fila) {
            $pdf->SetX(12);
            foreach ($fila as $col) {
                [$label, $campo] = $col;
                $valor = $datosCancer[$campo] ?? 'No evaluado';
                $pdf->Cell(93, 5, utf8_decode("$label: $valor"), 1);
            }
            $pdf->Ln();
        }

        $camposLargos = [
            'Clasificación T' => 'clasificacion_t',
            'Descripción T' => 'descripcion_t',
            'Clasificación N' => 'clasificacion_n',
            'Descripción N' => 'descripcion_n',
            'Clasificación M' => 'clasificacion_m',
            'Descripción M' => 'descripcion_m',
            'Subtipo molecular' => 'subtipo_molecular',
            'FISH' => 'fish',
            'BRCA' => 'brca',
            'Estadio' => 'estadio',
        ];

        foreach ($camposLargos as $label => $campo) {
            $valor = $datosCancer[$campo] ?? 'No evaluado';
            $pdf->SetX(12);
            $pdf->MultiCell(186, 5, utf8_decode("$label: $valor"), 1);
        }
    }
}
