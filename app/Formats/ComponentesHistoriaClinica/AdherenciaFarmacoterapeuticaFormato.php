<?php

namespace App\Formats\ComponentesHistoriaClinica;

class AdherenciaFarmacoterapeuticaFormato
{
    public function bodyComponente($pdf, $consulta): void
    {

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('ADHERENCIA FARMACOTERAPEUTICA'), 1, 0, 'C', 1);
        $pdf->Ln();
        $y = $pdf->GetY();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, utf8_decode("¿TOMA SIEMPRE LA MEDICACIÓN A LA HORA INDICADA?: ") . utf8_decode($consulta["adherenciaFarmaceutica"]["hora_indicada"] ?? 'No Aplica'), 1, 'L', 0);
        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, utf8_decode("¿EN CASO DE SENTIRSE MAL HA DEJADO DE TOMAR LA MEDICACIÓN ALGUNA VEZ?: ") . utf8_decode($consulta["adherenciaFarmaceutica"]["dejado_medicamento"] ?? 'No Aplica'), 1, 'L', 0);
        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, utf8_decode("EN ALGUNA OCASIÓN ¿SE HA OLVIDADO DE TOMAR LA MEDICACIÓN?: ") . utf8_decode($consulta["adherenciaFarmaceutica"]["dejado_medicamento"] ?? 'No Aplica'), 1, 'L', 0);
        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, utf8_decode("DURANTE EL FIN DE SEMANA ¿SE HA OLVIDADO DE ALGUNA TOMA DE MEDICACIÓN?: ") . utf8_decode($consulta["adherenciaFarmaceutica"]["finsemana_olvidomedicamento"] ?? 'No Aplica'), 1, 'L', 0);
        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, utf8_decode("EN LA ÚLTIMA SEMANA ¿CÚANTAS VECES NO TOMÓ ALGUNA DOSIS?: ") . utf8_decode($consulta["adherenciaFarmaceutica"]["finsemana_notomomedicamento"] ?? 'No Aplica'), 1, 'L', 0);
        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, utf8_decode("DESDE LA ÚLTIMA VISITA ¿CÚANTAS DÍAS COMPLETOS NO TOMÓ LA MEDICACIÓN?: ") . utf8_decode($consulta["adherenciaFarmaceutica"]["dias_notomomedicamento"] ?? 'No Aplica'), 1, 'L', 0);
        $pdf->Line(12, $pdf->GetY(), 198, $pdf->GetY());
        $y = $pdf->GetY();

        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('PORCENTAJE DE ADHERENCIA'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, utf8_decode("PORCENTAJE:  ") . utf8_decode($consulta["adherenciaFarmaceutica"]["porcentaje"] ?? 'No Aplica'), 1, 'L', 0);
        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, utf8_decode("ADHERENCIA CRITERIO DEL QUIMICO:  ") . utf8_decode($consulta["adherenciaFarmaceutica"]["criterio_quimico"] ?? 'No Aplica'), 1, 'L', 0);

        $pdf->Ln();
    }

}
