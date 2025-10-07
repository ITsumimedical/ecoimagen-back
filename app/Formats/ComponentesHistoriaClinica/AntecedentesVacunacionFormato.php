<?php

namespace App\Formats\ComponentesHistoriaClinica;

use App\Http\Modules\Historia\Vacunacion\Models\Vacuna;

class AntecedentesVacunacionFormato
{
    public function bodyComponente($pdf, $consulta): void
    {

        $afiliadoId = $consulta->afiliado_id;
        $antecedentesVacunales = Vacuna::with('consulta.medicoOrdena.operador')
            ->whereHas('consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId);
            })->get();


        // Imprimir encabezado de antecedentes vacunales
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('ANTECEDENTES VACUNALES'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 8);

        // Verificar si todos los antecedentes vacunales indican "No refiere antecedentes vacunales"
        $noTieneAntecedentesVacunales = $antecedentesVacunales->every(function ($vacuna) {
            return $vacuna->no_tiene_antecedente === 'No refiere antecedentes vacunales';
        });

        if ($noTieneAntecedentesVacunales) {
            // Si no hay antecedentes vacunales, mostrar mensaje
            $pdf->SetX(12);
            $pdf->Cell(186, 4, utf8_decode('No refiere antecedentes vacunales'), 1, 0, 'L');


            $pdf->Ln();
        } else {
            foreach ($antecedentesVacunales as $vacuna) {
                if ($vacuna->no_tiene_antecedente === 'No refiere antecedentes vacunales') {
                    continue; // Si el antecedente tiene no_tiene_antecedentes como true, no se muestra
                }

                $pdf->SetX(12);
                // $pdf->SetFont('Arial', 'B', 8);
                // $pdf->Cell(186, 4, utf8_decode('Registro ' . $contador), 1, 0, 'L', 1);
                // $pdf->Ln();

                $pdf->SetFont('Arial', '', 8);

                // Laboratorio
                $laboratorio = utf8_decode($vacuna->laboratorio ?? 'No especificado');
                $pdf->SetX(12);
                if($vacuna->vacuna === 'Covid'){
                    $pdf->MultiCell(186, 4, utf8_decode('LABORATORIO: ' . $laboratorio), 1, 'L');
                }

                // Médico que ordenó
                $nombreCompletoMedico = ($vacuna->consulta && $vacuna->consulta->medicoOrdena && $vacuna->consulta->medicoOrdena->operador)
                    ? $vacuna->consulta->medicoOrdena->operador->nombre . ' ' . $vacuna->consulta->medicoOrdena->operador->apellido
                    : 'No especificado';

                // Fecha de dosis
                $fechaDosis = $vacuna->fecha_dosis ?? 'No especificada';

                // Nombre de la vacuna
                $vacunaNombre = $vacuna->vacuna ?? 'No especificada';

                // Dosis
                $dosis = $vacuna->dosis ?? 'No especificada';

                // Concatenar los campos
                $detalleVacuna = 'VACUNA: ' . $vacunaNombre . ' | DOSIS: ' . $dosis . ' | FECHA DE DOSIS: ' . $fechaDosis . ' | REGISTRADO POR: ' . $nombreCompletoMedico;

                // Imprimir con una sola decodificación al final
                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode($detalleVacuna), 1, 'L');
            }

            if ($antecedentesVacunales->isEmpty()) {
                $pdf->SetX(12);
                $pdf->Cell(186, 4, utf8_decode('No refiere antecedentes vacunales.'), 1, 0, 'L');
                $pdf->Ln();
            }
        }
    }
}
