<?php

namespace App\Formats\ComponentesHistoriaClinica;

use App\Http\Modules\Historia\ResultadoLaboratorio\Models\ResultadoLaboratorio;

class ResultadosLaboratorioFormato
{
    public function bodyComponente($pdf, $consulta): void
    {
        $afiliadoId = $consulta->afiliado_id;
        $resultadosLaboratorio = ResultadoLaboratorio::whereHas('consulta', function ($query) use ($afiliadoId) {
            $query->where('afiliado_id', $afiliadoId);
        })->with(['user.operador'])
            ->when(empty($consulta["HistoriaClinica"]["imprimir_resultados_laboratorios"]), function ($query) use ($consulta) {
                $query->where('consulta_id', $consulta->id);
            })
            ->get();

        // Imprimir resultados de laboratorio
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('RESULTADOS LABORATORIOS'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 8);

        if ($resultadosLaboratorio->isEmpty()) {
            $pdf->SetX(12);
            $pdf->Cell(186, 4, utf8_decode('No se encontraron resultados asociados.'), 1, 0, 'L');

            $pdf->Ln();
        } else {
            foreach ($resultadosLaboratorio as $resultadoLaboratorio) {
                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                // Laboratorio
                $laboratorio = !empty($resultadoLaboratorio->laboratorio)
                    ? utf8_decode($resultadoLaboratorio->laboratorio)
                    : utf8_decode('No Aplica');
                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode('LABORATORIO: ' . $laboratorio), 1, 'L');

                // Resultado
                $resultadoLab = !empty($resultadoLaboratorio->resultado_lab)
                    ? utf8_decode($resultadoLaboratorio->resultado_lab)
                    : utf8_decode('No Aplica');
                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode('RESULTADO: ' . $resultadoLab), 1, 'L');

                // Concatenar ambos registros en un solo texto
                $fechaLaboratorio = !empty($resultadoLaboratorio->fecha_laboratorio)
                    ? utf8_decode(substr($resultadoLaboratorio->fecha_laboratorio, 0, 10))
                    : utf8_decode('No Aplica');

                $usuario = !empty($resultadoLaboratorio->user->operador->nombre_completo)
                    ? utf8_decode($resultadoLaboratorio->user->operador->nombre_completo)
                    : utf8_decode('No Aplica');

                // Crear el texto combinado
                $textoConcatenado = "FECHA LABORATORIO: $fechaLaboratorio - REGISTRADO POR: $usuario";

                // Establecer el texto combinado en el PDF
                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, $textoConcatenado, 1, 'L');

                $pdf->Ln(2);
            }
        }
        $pdf->Ln();
    }
}
