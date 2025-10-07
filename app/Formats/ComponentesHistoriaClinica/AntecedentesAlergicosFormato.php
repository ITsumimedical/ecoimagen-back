<?php

namespace App\Formats\ComponentesHistoriaClinica;

use App\Http\Modules\Historia\AntecedentesFarmacologicos\Models\AntecedentesFarmacologico;
use Illuminate\Support\Facades\DB;

class AntecedentesAlergicosFormato
{
    public function bodyComponente($pdf,$consulta): void
    {
        $afiliadoId = $consulta->afiliado_id;

        $antecedentesFarmacologicos = AntecedentesFarmacologico::select(
            'antecedentes_farmacologicos.observacion_medicamento',
            'antecedentes_farmacologicos.created_at',
            'principio_activos.nombre as medicamento',
            DB::raw("COALESCE(CONCAT(operadores.nombre, ' ', operadores.apellido), 'No refiere') as operador")
        )
            ->join('consultas', 'antecedentes_farmacologicos.consulta_id', '=', 'consultas.id')
            ->leftJoin('medicamentos', 'antecedentes_farmacologicos.medicamento_id', '=', 'medicamentos.id')
            ->leftJoin('codesumis', 'medicamentos.codesumi_id', '=', 'codesumis.id')
            ->leftJoin('users', 'antecedentes_farmacologicos.medico_registra', '=', 'users.id')
            ->leftJoin('operadores', 'operadores.user_id', '=', 'users.id')
            ->join('principio_activos', 'antecedentes_farmacologicos.principio_activo_id', 'principio_activos.id')
            ->where('consultas.afiliado_id', $afiliadoId)
            ->whereNotNull('antecedentes_farmacologicos.principio_activo_id')
            ->orderBy('antecedentes_farmacologicos.id', 'desc')
            ->get();

        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('ANTECEDENTES ALÉRGICOS A MEDICAMENTOS'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 8);

        if ($antecedentesFarmacologicos->isEmpty()) {
            $pdf->SetX(12);
            $pdf->Cell(186, 4, utf8_decode('No tiene antecedentes alérgicos a medicamentos'), 1, 0, 'L');
            $pdf->Ln();
        } else {
            foreach ($antecedentesFarmacologicos as $item) {
                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode("MEDICAMENTOS: {$item->medicamento}"), 1, 'L');

                $observacion = $item->observacion_medicamento ?? 'N/A';
                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode("OBSERVACIONES: {$observacion}"), 1, 'L');

                $fecha = optional($item->created_at)->format('d/m/Y') ?? 'No especificada';
                $detalle = "FECHA DE REGISTRO: {$fecha} | REGISTRADO POR: {$item->operador}";

                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode($detalle), 1, 'L');

                $pdf->Ln(2);
            }
        }

        $pdf->Ln();
    }
}
