<?php

namespace App\Formats\ComponentesHistoriaClinica;

use App\Http\Modules\Historia\AntecedentesQuirurgicos\Models\AntecedenteQuirurgico;

class AntecedentesQuirurgicosFormato
{
    public function bodyComponente($pdf, $consulta): void
    {

        $afiliadoId = $consulta->afiliado_id;
        $antecedentesQuirurgicos = AntecedenteQuirurgico::with('consulta.medicoOrdena.operador')
            ->whereHas('consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId);
            })->get();

        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('ANTECEDENTES QUIRÚRGICOS'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 8);

        // Verificar si todos los antecedentes quirúrgicos indican "No refiere antecedentes quirúrgicos"
        $noTieneAntecedentesQuirurgicos = $antecedentesQuirurgicos->every(function ($quirurgico) {
            return $quirurgico->no_tiene_antecedente === 'No refiere antecedentes quirúrgicos';
        });

        if ($noTieneAntecedentesQuirurgicos) {
            // Si no hay antecedentes quirúrgicos, mostrar mensaje
            $pdf->SetX(12);
            $pdf->Cell(186, 4, utf8_decode('No refiere antecedentes quirúrgicos'), 1, 0, 'L');


            $pdf->Ln();
        } else {
            foreach ($antecedentesQuirurgicos as $quirurgico) {
                if ($quirurgico->no_tiene_antecedente === 'No refiere antecedentes quirúrgicos') {
                    continue; // Si el antecedente tiene no_tiene_antecedentes como true, no se muestra
                }

                $pdf->SetX(12);
                // $pdf->SetFont('Arial', 'B', 8);
                // $pdf->Cell(186, 4, utf8_decode('Registro ' . $contador), 1, 0, 'L', 1);
                // $pdf->Ln();

                $pdf->SetFont('Arial', '', 8);

                // Cirugía
                $cirugia = utf8_decode($quirurgico->cirugia ?? 'No especificada');
                $pdf->SetX(12);

                $pdf->MultiCell(186, 4, utf8_decode('CIRUGÍA: ' . $cirugia), 1, 'L');

                // Observaciones
                $observaciones = utf8_decode($quirurgico->observaciones ?? 'Sin observaciones');
                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode('OBSERVACIONES: ' . $observaciones), 1, 'L');

                // Edad
                $edad = $quirurgico->a_que_edad ? $quirurgico->a_que_edad . ' años' : 'No especificada';

                // Médico que ordenó
                $nombreCompletoMedico = ($quirurgico->consulta && $quirurgico->consulta->medicoOrdena && $quirurgico->consulta->medicoOrdena->operador)
                    ? $quirurgico->consulta->medicoOrdena->operador->nombre . ' ' . $quirurgico->consulta->medicoOrdena->operador->apellido
                    : 'No Aplica';

                // Armar texto completo
                $detalleQuirurgico = 'EDAD: ' . $edad . ' | REGISTRADO POR: ' . $nombreCompletoMedico;

                // Imprimir con solo una decodificación
                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode($detalleQuirurgico), 1, 'L');

                $pdf->Ln(2);
            }

            if ($antecedentesQuirurgicos->isEmpty()) {
                $pdf->SetX(12);
                $pdf->Cell(186, 4, utf8_decode('No refiere antecedentes quirúrgicos.'), 1, 0, 'L');
                $pdf->Ln();
            }
        }
    }
}
