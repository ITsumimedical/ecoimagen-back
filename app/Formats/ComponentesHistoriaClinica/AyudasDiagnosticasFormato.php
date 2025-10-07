<?php

namespace App\Formats\ComponentesHistoriaClinica;

use App\Http\Modules\ResultadoAyudasDiagnosticos\Model\ResultadoAyudasDiagnosticas;

class AyudasDiagnosticasFormato
{
    public function bodyComponente($pdf, $consulta): void
    {

        // Imprimir ayudas diagnósticas
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('RESULTADOS AYUDAS DIAGNÓSTICAS'), 1, 0, 'C', 1);
        $pdf->Ln();

        $afiliadoId = $consulta->afiliado_id;


        $ayudasDiagnosticas = ResultadoAyudasDiagnosticas::with(['cups:id,nombre', 'user.operador:id,nombre,apellido,user_id'])
            ->whereHas('consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId);
            })
            ->orderBy('id', 'desc')
            ->get();


        $historiaClinica = $consulta["HistoriaClinica"] ?? null;

        $resultados = [];

        if ($historiaClinica && !empty($historiaClinica['resultado_ayuda_diagnostica'])) {
            $resultados[] = [
                'ayuda_diagnostica' => $historiaClinica['cup']['nombre'] ?? 'No especificado',
                'observaciones' => $historiaClinica['resultado_ayuda_diagnostica'],
                'registrado_por' => utf8_decode($consulta["medicoOrdena"]["operador"]["nombre_completo"]) ?? 'No Refiere',
                'fecha_realizacion' => $historiaClinica['created_at'] ? date('d/m/Y', strtotime($historiaClinica['created_at'])) : 'No Refiere',
            ];
        }



        foreach ($ayudasDiagnosticas as $ayuda) {
            if (!empty($ayuda->cups->nombre) && !empty($ayuda->observaciones)) {
                $resultados[] = [
                    'ayuda_diagnostica' => $ayuda->cups->nombre,
                    'observaciones' => $ayuda->observaciones,
                    'registrado_por' => $ayuda->user->operador->nombre_completo ?? 'No Refiere',
                    'fecha_realizacion' => $ayuda->created_at->format('d/m/Y'),
                ];
            }
        }

        $pdf->SetFont('Arial', '', 8);

        if (empty($resultados)) {
            $pdf->SetX(12);
            $pdf->Cell(186, 4, utf8_decode('No se encontraron resultados asociados.'), 1, 0, 'L');
            $pdf->Ln();
        } else {
            foreach ($resultados as $resultado) {
                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);

                // Ayuda Diagnóstica
                if (!empty($resultado['ayuda_diagnostica'])) {
                    $pdf->SetX(12);
                    $pdf->MultiCell(186, 4, utf8_decode('AYUDA DIAGNÓSTICA: ' . $resultado['ayuda_diagnostica']), 1, 'L');
                }

                // Observaciones
                if (!empty($resultado['observaciones'])) {
                    $pdf->SetX(12);
                    $pdf->MultiCell(186, 4, utf8_decode('OBSERVACIONES: ' . $resultado['observaciones']), 1, 'L');
                }

                // Registrado por
                $usuario = !empty($resultado['registrado_por'])
                    ? utf8_decode($resultado['registrado_por'])
                    : utf8_decode('No Aplica');

                // Fecha de registro
                $fecha = !empty($resultado['fecha_realizacion'])
                    ? utf8_decode($resultado['fecha_realizacion'])
                    : utf8_decode('No Aplica');

                $textoConcatenado = "REGISTRADO POR: $usuario | FECHA DE REGISTRO: $fecha";

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, $textoConcatenado, 1, 'L');

                $pdf->Ln(2);
            }
        }
        $pdf->Ln();
    }
}
