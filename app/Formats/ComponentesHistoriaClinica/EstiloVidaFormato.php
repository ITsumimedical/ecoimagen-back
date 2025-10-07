<?php

namespace App\Formats\ComponentesHistoriaClinica;


class EstiloVidaFormato
{
    public function bodyComponente($pdf, $consulta): void
    {   
        $pdf->SetX(12);
        $pdf->SetFont('arial', 'B', '9');
        $pdf->Cell(186, 4, utf8_decode('ESTILOS DE VIDA'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('arial', '', '8');
        $pdf->Cell(62, 4, "Consume frutas y verduras: " . utf8_decode(isset($consulta["HistoriaClinica"]["dieta_saludable"]) && $consulta["HistoriaClinica"]["dieta_saludable"] !== null ? $consulta["HistoriaClinica"]["dieta_saludable"] : 'No Refiere'), 1, 0, 'L');
        $pdf->Cell(62, 4, "Frecuencia: " . utf8_decode(isset($consulta["HistoriaClinica"]["frecuencia_dieta_saludable"]) && $consulta["HistoriaClinica"]["frecuencia_dieta_saludable"] !== null ? $consulta["HistoriaClinica"]["frecuencia_dieta_saludable"] : 'No Refiere'), 1, 0, 'L');
        $pdf->Cell(62, 4, "Dieta balanceada: " . utf8_decode(isset($consulta["HistoriaClinica"]["dieta_balanceada"]) && $consulta["HistoriaClinica"]["dieta_balanceada"] !== null ? $consulta["HistoriaClinica"]["dieta_balanceada"] : 'No Refiere'), 1, 0, 'L');
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->Cell(62, 4, utf8_decode("Comidas en el día: ") . utf8_decode(isset($consulta["HistoriaClinica"]["cuantas_comidas"]) && $consulta["HistoriaClinica"]["cuantas_comidas"] !== null ? $consulta["HistoriaClinica"]["cuantas_comidas"] : 'No Refiere'), 1, 0, 'L');
        $pdf->Cell(62, 4, utf8_decode("Sueño reparador: ") . utf8_decode(isset($consulta["HistoriaClinica"]["sueno_reparador"]) && $consulta["HistoriaClinica"]["sueno_reparador"] !== null ? $consulta["HistoriaClinica"]["sueno_reparador"] : 'No Refiere'), 1, 0, 'L');
        if ($consulta["HistoriaClinica"]["sueno_reparador"] === 'Si') {
            $pdf->Cell(62, 4, utf8_decode("Tipo de sueño: ") . utf8_decode(isset($consulta["HistoriaClinica"]["tipo_sueno"]) && $consulta["HistoriaClinica"]["tipo_sueno"] !== null ? $consulta["HistoriaClinica"]["tipo_sueno"] : 'No Refiere'), 1, 0, 'L');
        }
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->Cell(62, 4, utf8_decode("Duración del sueño: ") . utf8_decode(isset($consulta["HistoriaClinica"]["duracion_sueno"]) && $consulta["HistoriaClinica"]["duracion_sueno"] !== null ? $consulta["HistoriaClinica"]["duracion_sueno"] : 'No Refiere'), 1, 0, 'L');
        $pdf->Cell(62, 4, utf8_decode("Actividad fisica: ") . utf8_decode(isset($consulta["HistoriaClinica"]["actividad_fisica"]) && $consulta["HistoriaClinica"]["actividad_fisica"] !== null ? $consulta["HistoriaClinica"]["actividad_fisica"] : 'No Refiere'), 1, 0, 'L');
        $pdf->Cell(62, 4, utf8_decode("Esfinter vesical: ") . utf8_decode(isset($consulta["HistoriaClinica"]["esfinter"]) && $consulta["HistoriaClinica"]["esfinter"] !== null ? $consulta["HistoriaClinica"]["esfinter"] : 'No Refiere'), 1, 1, 'L');
        $pdf->SetX(12);
        $pdf->Cell(62, 4, utf8_decode("Esfinter rectal: ") . utf8_decode(isset($consulta["HistoriaClinica"]["esfinter_rectal"]) && $consulta["HistoriaClinica"]["esfinter_rectal"] !== null ? $consulta["HistoriaClinica"]["esfinter_rectal"] : 'No Refiere'), 1, 0, 'L');
        $pdf->Cell(62, 4, utf8_decode("Frecuencia de orina: ") . utf8_decode(isset($consulta["HistoriaClinica"]["caracteristicas_orina"]) && $consulta["HistoriaClinica"]["caracteristicas_orina"] !== null ? $consulta["HistoriaClinica"]["caracteristicas_orina"] : 'No Refiere'), 1, 1, 'L');
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('arial', 'B', '9');
        $pdf->Cell(186, 4, utf8_decode('HÁBITOS TÓXICOS'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('arial', '', '9');
        if ($consulta["HistoriaClinica"]["afiliado_fumador"]) {
            $pdf->Cell(62, 4, utf8_decode("Tipo de exposición: ") . utf8_decode(isset($consulta["HistoriaClinica"]["expuesto_humo"]) && $consulta["HistoriaClinica"]["expuesto_humo"] !== null ? $consulta["HistoriaClinica"]["expuesto_humo"] : 'No refiere'), 1, 0, 'L');
            if ($consulta["HistoriaClinica"]["expuesto_humo"] !== 'Fumador pasivo' && $consulta["HistoriaClinica"]["expuesto_humo"] !== 'No fumador') {
                $pdf->Cell(62, 4, utf8_decode("Número de cigarrillos al día: ") . utf8_decode(isset($consulta["HistoriaClinica"]["fuma_cantidad"]) && $consulta["HistoriaClinica"]["fuma_cantidad"] !== null ? $consulta["HistoriaClinica"]["fuma_cantidad"] : 'No refiere'), 1, 0, 'L');
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->Cell(62, 4, utf8_decode("Número de años que fumo: ") . utf8_decode(isset($consulta["HistoriaClinica"]["fumamos"]) && $consulta["HistoriaClinica"]["fumamos"] !== null ? $consulta["HistoriaClinica"]["fumamos"] : 'No refiere'), 1, 0, 'L');
                $pdf->Cell(62, 4, utf8_decode("índice tabaquico: ") . utf8_decode(isset($consulta["HistoriaClinica"]["tabaquico"]) && $consulta["HistoriaClinica"]["tabaquico"] !== null ? $consulta["HistoriaClinica"]["tabaquico"] : 'No refiere'), 1, 0, 'L');
                $pdf->Cell(62, 4, utf8_decode("Riesgo EPOC: ") . utf8_decode(isset($consulta["HistoriaClinica"]["riesgo_epoc"]) && $consulta["HistoriaClinica"]["riesgo_epoc"] !== null ? $consulta["HistoriaClinica"]["riesgo_epoc"] : 'No refiere'), 1, 0, 'L');
            }
        } else {
            $pdf->SetX(12);
            $pdf->SetFont('arial', '', '9');
            $pdf->Cell(186, 4, 'No refiere', 1, 0, 'L');
        }
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('arial', 'B', 9);
        $pdf->Cell(186, 4, utf8_decode('SUSTANCIAS PSICOACTIVAS'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('arial', '', 9);

        $anios = $consulta["HistoriaClinica"]["anios_expuesto_sustancias"] ?? null;
        $inicio = $consulta["HistoriaClinica"]["consumo_psicoactivo"] ?? null;
        $cantidad = $consulta["HistoriaClinica"]["psicoactivo_cantidad"] ?? null;

        if (empty($anios) && empty($inicio) && empty($cantidad)) {
            $pdf->MultiCell(186, 4, utf8_decode("No refiere"), 1, 'L');
        } else {
            $pdf->Cell(62, 4, utf8_decode("Frecuencia de exposición: ") . utf8_decode($anios ?? 'sin hallazgos'), 1, 0, 'L');
            $pdf->Cell(62, 4, utf8_decode("Fecha inicio de consumo: ") . utf8_decode($inicio ?? 'sin hallazgos'), 1, 0, 'L');
            $pdf->Cell(62, 4, utf8_decode("Cantidad consumo: ") . utf8_decode($cantidad ?? 'sin hallazgos'), 1, 0, 'L');
            $pdf->Ln();
        }

        if ($consulta["afiliado"]["edad_cumplida"] >= 11) {
            $pdf->SetX(12);
            $pdf->SetFont('arial', 'B', 9);
            $pdf->Cell(186, 4, utf8_decode('CONSUMO BEBIDAS ALCOHÓLICAS'), 1, 0, 'C', 1);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFont('arial', '', 8);

            $tragos = $consulta["HistoriaClinica"]["cantidad_licor"] ?? null;
            $frecuencia = $consulta["HistoriaClinica"]["licor_frecuencia"] ?? null;

            if (empty($tragos) && empty($frecuencia)) {
                $pdf->MultiCell(186, 4, utf8_decode("No refiere"), 1, 'L');
            } else {
                $pdf->Cell(93, 4, utf8_decode("Cantidad de tragos: ") . utf8_decode($tragos ?? 'sin hallazgos'), 1, 0, 'L');
                $pdf->Cell(93, 4, utf8_decode("Frecuencia consumo de bebidas: ") . utf8_decode($frecuencia ?? 'sin hallazgos'), 1, 0, 'L');
                $pdf->Ln();
            }
        }

        $pdf->SetX(12);
        $pdf->SetFont('arial', 'B', '9');
        $pdf->Cell(186, 4, utf8_decode('OBSERVACIONES'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetFont('arial', '', '9');
        $pdf->MultiCell(186, 4, utf8_decode("Observaciones adicionales: ") . utf8_decode(isset($consulta["HistoriaClinica"]["estilo_vida_observaciones"]) && $consulta["HistoriaClinica"]["estilo_vida_observaciones"] !== null ? $consulta["HistoriaClinica"]["estilo_vida_observaciones"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Ln();
    }
}
