<?php

namespace App\Formats\ComponentesHistoriaClinica;

use App\Http\Modules\Historia\AntecedentesPersonales\Models\AntecedentePersonale;

class AntecedentesPersonalesFormato
{
    public function bodyComponente($pdf, $consulta): void
    {

        $afiliadoId = $consulta->afiliado_id;
        $antecedentes = AntecedentePersonale::with('consulta.medicoOrdena.operador')
            ->whereHas('consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId);
            })
            ->get();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('ANTECEDENTES PERSONALES'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 8);

        if ($antecedentes->isEmpty()) {
            $pdf->SetX(12);
            $pdf->Cell(186, 4, utf8_decode('No refiere antecedentes personales.'), 1, 0, 'L');
            $pdf->Ln();
        } else {
            foreach ($antecedentes as $antecedente) {
                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);

                // Patología
                $patologia = !empty($antecedente->patologias)
                    ? $antecedente->patologias
                    : 'No Aplica';

                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode('PATOLOGÍA: ' . $patologia), 1, 'L');

                // Fecha de diagnóstico
                $fechaDiagnostico = !empty($antecedente->fecha_diagnostico)
                    ? substr($antecedente->fecha_diagnostico, 0, 10)
                    : 'No Aplica';

                // Médico ordena
                $nombreCompletoMedico = ($antecedente->consulta && $antecedente->consulta->medicoOrdena && $antecedente->consulta->medicoOrdena->operador)
                    ? $antecedente->consulta->medicoOrdena->operador->nombre . ' ' . $antecedente->consulta->medicoOrdena->operador->apellido
                    : 'No Aplica';

                // Concatenar y decodificar una sola vez
                $detalle = 'FECHA DIAGNÓSTICO: ' . $fechaDiagnostico . ' | REGISTRADO POR: ' . $nombreCompletoMedico;

                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode($detalle), 1, 'L');
            }
        }
        $pdf->Ln();
    }
}
