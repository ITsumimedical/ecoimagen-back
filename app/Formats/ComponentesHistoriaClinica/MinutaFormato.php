<?php

namespace App\Formats\ComponentesHistoriaClinica;

class MinutaFormato
{
    public function bodyComponente($pdf, $consulta): void
    {
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('MINUTA'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(93, 4, utf8_decode("Tragos: ") . utf8_decode(isset($consulta["minuta"]["tragos"]) && $consulta["minuta"]["tragos"] !== null ? ($consulta["minuta"]["tragos"] ? 'Si' : 'No') : 'No Refiere'), 1, 0, 'L');

        $tragos_sino = $consulta["minuta"]["tragos"] ?? null;

        if ($tragos_sino) {
            $pdf->Cell(93, 4, utf8_decode("Hora de los tragos: ") . utf8_decode(isset($consulta["minuta"]["hora_tragos"]) && $consulta["minuta"]["hora_tragos"] !== null ? $consulta["minuta"]["hora_tragos"] : 'No Refiere'), 1, 0, 'L');
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->MultiCell(186, 4, utf8_decode("Descripción: ") . utf8_decode(isset($consulta["minuta"]["descripcion_tragos"]) && $consulta["minuta"]["descripcion_tragos"] !== null ? $consulta["minuta"]["descripcion_tragos"] : 'No Refiere'), 1, 1, 'L');
        } else {
            $pdf->Ln();
        }

        $pdf->SetX(12);
        $pdf->Cell(93, 4, utf8_decode("Desayuno: ") . utf8_decode(isset($consulta["minuta"]["desayuna_sino"]) && $consulta["minuta"]["desayuna_sino"] !== null ? ($consulta["minuta"]["desayuna_sino"] ? 'Si' : 'No') : 'No Refiere'), 1, 0, 'L');

        $desayuno_sino = $consulta["minuta"]["desayuna_sino"] ?? null;

        if ($desayuno_sino) {
            $pdf->Cell(93, 4, utf8_decode("Hora del desayuno: ") . utf8_decode(isset($consulta["minuta"]["desayuno"]) && $consulta["minuta"]["desayuno"] !== null ? $consulta["minuta"]["desayuno"] : 'No Refiere'), 1, 0, 'L');
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->MultiCell(186, 4, utf8_decode("Descripción: ") . utf8_decode(isset($consulta["minuta"]["observaciones_desayuno"]) && $consulta["minuta"]["observaciones_desayuno"] !== null ? $consulta["minuta"]["observaciones_desayuno"] : 'No Refiere'), 1, 1, 'L');
        }


        $pdf->SetX(12);
        $pdf->Cell(93, 4, utf8_decode("Media mañana: ") . utf8_decode(isset($consulta["minuta"]["mm_sino"]) && $consulta["minuta"]["mm_sino"] !== null ? ($consulta["minuta"]["mm_sino"] ? 'Si' : 'No') : 'No Refiere'), 1, 0, 'L');
        $media_manana = $consulta["minuta"]["mm_sino"] ?? null;
        if ($media_manana) {
            $pdf->Cell(93, 4, utf8_decode("Hora de la media mañana: ") . utf8_decode(isset($consulta["minuta"]["media_manana"]) && $consulta["minuta"]["media_manana"] !== null ? $consulta["minuta"]["media_manana"] : 'No Refiere'), 1, 0, 'L');
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->MultiCell(186, 4, utf8_decode("Descripción: ") . utf8_decode(isset($consulta["minuta"]["mm_descripcion"]) && $consulta["minuta"]["mm_descripcion"] !== null ? $consulta["minuta"]["mm_descripcion"] : 'No Refiere'), 1, 1, 'L');
        } else {
            $pdf->Ln();
        }

        $pdf->SetX(12);
        $pdf->Cell(93, 4, utf8_decode("Almuerzo: ") . utf8_decode(isset($consulta["minuta"]["almuerzo_sino"]) && $consulta["minuta"]["almuerzo_sino"] !== null ? ($consulta["minuta"]["almuerzo_sino"] ? 'Si' : 'No') : 'No Refiere'), 1, 0, 'L');
        $almuerzosino = $consulta["minuta"]["almuerzo_sino"] ?? null;
        if ($almuerzosino) {
            $pdf->Cell(93, 4, utf8_decode("Hora del almuerzo: ") . utf8_decode(isset($consulta["minuta"]["almuerzo"]) && $consulta["minuta"]["almuerzo"] !== null ? $consulta["minuta"]["almuerzo"] : 'No Refiere'), 1, 0, 'L');
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->MultiCell(186, 4, utf8_decode("Descripción: ") . utf8_decode(isset($consulta["minuta"]["descripcion_almuerzo"]) && $consulta["minuta"]["descripcion_almuerzo"] !== null ? $consulta["minuta"]["descripcion_almuerzo"] : 'No Refiere'), 1, 1, 'L');
        }else {
            $pdf->Ln();
        }

        $pdf->SetX(12);
        $pdf->Cell(93, 4, utf8_decode("Algo: ") . utf8_decode(isset($consulta["minuta"]["algo_sino"]) && $consulta["minuta"]["algo_sino"] !== null ? ($consulta["minuta"]["algo_sino"] ? 'Si' : 'No') : 'No Refiere'), 1, 0, 'L');
        $algosino = $consulta["minuta"]["algo_sino"] ?? null;
        if ($algosino) {
            $pdf->Cell(93, 4, utf8_decode("Hora del algo: ") . utf8_decode(isset($consulta["minuta"]["algo"]) && $consulta["minuta"]["algo"] !== null ? $consulta["minuta"]["algo"] : 'No Refiere'), 1, 0, 'L');
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->MultiCell(186, 4, utf8_decode("Descripción: ") . utf8_decode(isset($consulta["minuta"]["descripcion_algo"]) && $consulta["minuta"]["descripcion_algo"] !== null ? $consulta["minuta"]["descripcion_algo"] : 'No Refiere'), 1, 0, 'L');
        } else{
            $pdf->Ln();
        }

        $pdf->SetX(12);
        $pdf->Cell(93, 4, utf8_decode("Comida: ") . utf8_decode(isset($consulta["minuta"]["comida_sino"]) && $consulta["minuta"]["comida_sino"] !== null ? ($consulta["minuta"]["comida_sino"] ? 'Si' : 'No') : 'No Refiere'), 1, 0, 'L');
        $comidasino = $consulta["minuta"]["comida_sino"] ?? null;
        if ($comidasino) {
            $pdf->Cell(93, 4, utf8_decode("Hora de la comida: ") . utf8_decode(isset($consulta["minuta"]["comida"]) && $consulta["minuta"]["comida"] !== null ? $consulta["minuta"]["comida"] : 'No Refiere'), 1, 0, 'L');
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->MultiCell(186, 4, utf8_decode("Descripción: ") . utf8_decode(isset($consulta["minuta"]["comida_descripcion"]) && $consulta["minuta"]["comida_descripcion"] !== null ? $consulta["minuta"]["comida_descripcion"] : 'No Refiere'), 1, 0, 'L');
        } else{
            $pdf->Ln();
        }

        $pdf->SetX(12);
        $pdf->Cell(93, 4, utf8_decode("Merienda: ") . utf8_decode(isset($consulta["minuta"]["merienda_sino"]) && $consulta["minuta"]["merienda_sino"] !== null ? ($consulta["minuta"]["merienda_sino"] ? 'Si' : 'No') : 'No Refiere'), 1, 0, 'L');
        $merienda_sino = $consulta["minuta"]["merienda_sino"] ?? null;
        if ($merienda_sino) {
            $pdf->Cell(93, 4, utf8_decode("Hora de la merienda: ") . utf8_decode(isset($consulta["minuta"]["merienda"]) && $consulta["minuta"]["merienda"] !== null ? $consulta["minuta"]["merienda"] : 'No Refiere'), 1, 0, 'L');
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->MultiCell(186, 4, utf8_decode("Descripción: ") . utf8_decode(isset($consulta["minuta"]["descripcion_merienda"]) && $consulta["minuta"]["descripcion_merienda"] !== null ? $consulta["minuta"]["descripcion_merienda"] : 'No Refiere'), 1, 1, 'L');
        }
        $pdf->Ln();
    }
}
