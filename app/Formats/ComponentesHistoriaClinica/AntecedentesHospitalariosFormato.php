<?php

namespace App\Formats\ComponentesHistoriaClinica;

use App\Http\Modules\Historia\AntecedentesHospitalarios\Models\AntecedentesHospitalario;

class AntecedentesHospitalariosFormato
{

    public function bodyComponente($pdf, $consulta): void
    {
        $afiliadoId = $consulta->afiliado_id;
        $antecedentesHospitalarios = AntecedentesHospitalario::whereHas('consulta', function ($query) use ($afiliadoId) {
            $query->where('afiliado_id', $afiliadoId)
                ->whereNotNull(['hospitalizacion_uci', 'hospitalizacion_ultimo_anio']);
        })->get();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('ANTECEDENTES HOSPITALARIOS'), 1, 0, 'C', 1);

        $pdf->Ln();

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 7);

        if ($antecedentesHospitalarios->isEmpty()) {
            $pdf->SetX(12);
            $pdf->Cell(186, 4, utf8_decode('No refiere'), 1, 0, 'L');

            $pdf->Ln();
        } else {
            $contador = 1;

            foreach ($antecedentesHospitalarios as $antecedente) {
                $pdf->SetX(12);
                $pdf->Cell(186, 4, utf8_decode('Registro #' . $contador), 1, 0, 'L', 1);
                $pdf->Ln();

                $pdf->SetX(12);
                $pdf->Cell(62, 4, utf8_decode('Hospitalización último año: ' . ($antecedente->hospitalizacion_ultimo_anio ?? 'No Evaluado')), 1);
                if ($antecedente->hospitalizacion_ultimo_anio == 'Si') {
                    $pdf->Cell(62, 4, utf8_decode('Cuántas hospitalizaciones ha tenido: ' . ($antecedente->cantidad_hospitalizaciones ?? 'No Evaluado')), 1);
                    $pdf->Cell(62, 4, utf8_decode('Fecha: ' . ($antecedente->fecha_ultimas_hospitalizaciones ?? 'No Evaluado')), 1);

                }
                if ($antecedente->hospitalizacion_ultimo_anio == 'Si') {
                    $pdf->Ln();
                    $pdf->SetX(12);
                    $pdf->MultiCell(186, 4, utf8_decode('Descripción hospitalización: ' . ($antecedente->descripcion_hospiurg ?? 'No Evaluado')), 1);
                }
                $pdf->SetX(12);

                $pdf->Cell(93, 4, utf8_decode('Hospitalización en UCI: ' . ($antecedente->hospitalizacion_uci ?? 'No Evaluado')), 1);
                if ($antecedente->hospitalizacion_uci == 'Si') {
                    $pdf->Cell(93, 4, utf8_decode('Fecha de hospitalización en UCI: ' . ($antecedente->fecha_hospitalizacion_uci_ultimo_ano ?? 'No Evaluado')), 1);

                }
                if ($antecedente->hospitalizacion_uci == 'Si') {
                    $pdf->Ln();
                    $pdf->SetX(12);
                    $pdf->MultiCell(186, 4, utf8_decode('Descripción hospitalización UCI: ' . ($antecedente->descripcion_hospi_uci ?? 'No Evaluado')), 1);

                }
                $contador++;
            }
        }

    }
}
