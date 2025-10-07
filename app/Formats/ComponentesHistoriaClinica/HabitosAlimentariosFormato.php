<?php

namespace App\Formats\ComponentesHistoriaClinica;

class HabitosAlimentariosFormato
{
    public function bodyComponente($pdf, $consulta): void
    {
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->Cell(186, 4, utf8_decode('HÁBITOS ALIMENTARIOS'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 8);

            if (!empty($consulta["HabitosAlimentarios"])) {
                $pdf->SetX(12);
                $campos = [
                    "Lactando Actualmente" => $consulta["HabitosAlimentarios"]["lactando_actualmente"]? "Sí" : "No",
                    "Lactancia Materna Exclusiva" => $consulta["HabitosAlimentarios"]["lactancia_materna_exclusiva"]? "Sí" : "No",
                    "Postura Madre-Niño" => $consulta["HabitosAlimentarios"]["postura_madre_niño"]?: "No",
                    "Agarre" => $consulta["HabitosAlimentarios"]["agarre"]?: "No",
                    "Succión" => $consulta["HabitosAlimentarios"]["succion"]?: "No",
                    "Madre Reconoce Hambre/Saciedad Bebé" => $consulta["HabitosAlimentarios"]["madre_reconoce_hambre_saciedad_bebe"]? "Sí" : "No",
                    "Necesidades Madre Lactancia Materna" => $consulta["HabitosAlimentarios"]["necesidades_madre_lactancia_materna"]?: "No",
                    "Recibió Preparación Prenatal" => $consulta["HabitosAlimentarios"]["recibio_preparacion_prenatal"]? "Sí" : "No",
                    "Suministra Leche en Hospital Neonatal" => $consulta["HabitosAlimentarios"]["suministra_leche_hospitalario_neonatal"]? "Sí" : "No",
                    "Expectativas Madre/Familia" => $consulta["HabitosAlimentarios"]["expectativas_madre_familia"]?: "No",
                    "Frecuencia Lactancia" => $consulta["HabitosAlimentarios"]["frecuencia_lactancia"]?: "No",
                    "Duración Lactancia" => $consulta["HabitosAlimentarios"]["duracion_lactancia"]?: "No",
                    "Dificultades Lactancia Materna" => $consulta["HabitosAlimentarios"]["dificultades_lactancia_materna"]?: "No",
                    "Madre Extrae/Conserva Leche" => $consulta["HabitosAlimentarios"]["madre_extrae_conserva_leche"]? "Sí" : "No",
                    "Cómo Realiza Extracción/Conservación Leche" => $consulta["HabitosAlimentarios"]["como_realiza_extraccion_conservacion_leche"]?: "No",
                    "Alimentado con Leche de Fórmula" => $consulta["HabitosAlimentarios"]["alimentado_leche_formula"]? "Sí" : "No",
                ];

                foreach ($campos as $campo => $valor) {
                    $pdf->Cell(186, 4, utf8_decode($campo . ": " . $valor), 1, "L", 0);
                    $pdf->SetX(12);
            }
        } else {
            $pdf->SetX(12);
            $pdf->MultiCell(186, 4, utf8_decode("No refiere"), 1, "L", 0);
        }
        $pdf->Ln();
    }
}