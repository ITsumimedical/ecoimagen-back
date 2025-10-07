<?php

namespace App\Formats\ComponentesHistoriaClinica;

class TestAssistFormato
{
    private function interpretarPorLetra($letra, $valor)
    {
        $nivel = "Valor inválido";

        if ($letra === "B") {
            if ($valor >= 0 && $valor <= 10) $nivel = "Bajo";
            elseif ($valor >= 11 && $valor <= 26) $nivel = "Moderado";
            elseif ($valor >= 27) $nivel = "Alto";
        } else {
            if ($valor >= 0 && $valor <= 3) $nivel = "Bajo";
            elseif ($valor >= 4 && $valor <= 26) $nivel = "Moderado";
            elseif ($valor >= 27) $nivel = "Alto";
        }

        $intervencion = "Valor inválido";
        if ($nivel === "Bajo") $intervencion = "Sin intervención";
        elseif ($nivel === "Moderado") $intervencion = "Intervención breve";
        elseif ($nivel === "Alto") $intervencion = "Tratamiento más intensivo";

        return [
            'nivel' => $nivel,
            'intervencion' => $intervencion
        ];
    }

    public function bodyComponente($pdf, $consulta): void
    {
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('TEST ASSIST'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);

        $etiquetas = [
            'A' => 'Tabaco',
            'B' => 'Alcohol',
            'C' => 'Marihuana',
            'D' => 'Cocaína',
            'E' => 'Estimulantes',
            'F' => 'Inhalantes',
            'G' => 'Tranquilizantes',
            'H' => 'Alucinógenos',
            'I' => 'Opiáceos',
            'J' => 'Otras sustancias',
        ];

        foreach (range('A', 'J') as $letra) {
            $valor = $consulta['testAssist']["resultadoItem$letra"] ?? null;

            if (is_numeric($valor)) {
                $interpreta = $this->interpretarPorLetra($letra, (int)$valor);
                $nivel = $interpreta['nivel'];
                $intervencion = $interpreta['intervencion'];
            } else {
                $nivel = "No refiere";
                $intervencion = "No refiere";
            }

            $etiqueta = $etiquetas[$letra] ?? "Sustancia $letra";
            $pdf->SetX(12);

            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(50, 4, utf8_decode("$etiqueta "), 1, 0, 'L', 0);

            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(136, 4, utf8_decode("Nivel - $nivel    /    $intervencion"), 1, 1, 'L', 0);
        }

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $interpretacion8 = $consulta["testAssist"]["interpretacion_item8"] ?? 'No refiere';
        $interpretacion8 = str_replace(
            ['“', '”', '‘', '’'],
            ['"', '"', "'", "'"],
            $interpretacion8
        );
        $pdf->MultiCell(186, 4, utf8_decode('Guía de intervención según patrón de inyección:  ' . $interpretacion8), 1, "L", 0);
        $pdf->Ln();
    }
}
