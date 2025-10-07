<?php

namespace App\Formats\ComponentesHistoriaClinica;

use App\Http\Modules\Historia\AntecedentesFamiliares\Models\AntecedenteFamiliare;
use DateTime;

class AntecedentesFamiliaresFormato
{
    public function bodyComponente($pdf, $consulta): void
    {
        $afiliadoId = $consulta->afiliado_id;
        $antecedentesFamiliares = AntecedenteFamiliare::with('consulta.medicoOrdena.operador', 'cie10')
            ->whereHas('consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId);
            })
            ->get();

        // Imprimir encabezado de antecedentes familiares
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('ANTECEDENTES FAMILIARES'), 1, 0, 'C', 1);

        $pdf->Ln();

        $pdf->SetFont('Arial', '', 8);

        $noTieneAntecedentes = $antecedentesFamiliares->every(function ($familiares) {
            return $familiares->no_tiene_antecedentes;
        });

        if ($noTieneAntecedentes) {
            // Si no hay antecedentes familiares, mostrar mensaje
            $pdf->SetX(12);
            $pdf->Cell(186, 4, utf8_decode('No refiere antecedentes familiares'), 1, 0, 'L');

            $pdf->Ln();
        } else {
            foreach ($antecedentesFamiliares as $familiares) {
                if ($familiares->no_tiene_antecedentes) {
                    continue; // Si el antecedente tiene no_tiene_antecedentes como true, no se muestra
                }

                $pdf->SetX(12);
                // $pdf->SetFont('Arial', 'B', 8);
                // $pdf->Cell(186, 4, utf8_decode('Registro ' . $contador), 1, 0, 'L', 1);
                // $pdf->Ln();

                $pdf->SetFont('Arial', '', 8);

                // Diagnóstico
                $diagnostico = $familiares->cie10
                    ? utf8_decode($familiares->cie10->nombre)
                    : utf8_decode('Diagnóstico no especificado');
                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode('DIAGNÓSTICO: ' . $diagnostico), 1, 'L');


                // Parentesco
                $parentesco = !empty($familiares->parentesco)
                    ? $familiares->parentesco
                    : 'No especificado';
                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode('PARENTESCO: ' . $parentesco), 1, 'L');

                // Fecha
                $fecha = (new DateTime($familiares->created_at))->format('Y-m-d');

                // Fallecido
                $fallecio = ($familiares->fallecido == 1) ? 'Sí' : 'No';

                // Médico que ordenó
                $nombreCompletoMedico = ($familiares->consulta && $familiares->consulta->medicoOrdena && $familiares->consulta->medicoOrdena->operador)
                    ? $familiares->consulta->medicoOrdena->operador->nombre . ' ' . $familiares->consulta->medicoOrdena->operador->apellido
                    : 'No Aplica';

                // Concatenar
                $detalle = 'FECHA: ' . $fecha . ' | FALLECIDO: ' . $fallecio . ' | REGISTRADO POR: ' . $nombreCompletoMedico;

                // Imprimir
                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode($detalle), 1, 'L');
                $pdf->Ln(2);
            }

            if ($antecedentesFamiliares->isEmpty()) {
                $pdf->SetX(12);
                $pdf->Cell(186, 4, utf8_decode('No refiere antecedentes familiares.'), 1, 0, 'L');

                $pdf->Ln();
            }
        }

        $pdf->Ln();
    }
}
