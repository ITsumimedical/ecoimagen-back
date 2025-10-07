<?php

namespace App\Formats\ComponentesHistoriaClinica;

class ConductaInadaptativaFormato
{
    public function bodyComponente($pdf, $consulta): void
    {
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('CONDUCTA INADAPTATIVA'), 1, 0, 'C', 1);
        $pdf->Ln();

        $come_unas = !empty($consulta["conductaInadaptativa"]["come_unas"]) ? 'Sí' : 'No';
        $succiona = !empty($consulta["conductaInadaptativa"]["succiona_dedos"]) ? 'Sí' : 'No';
        $muerde_labio = !empty($consulta["conductaInadaptativa"]["muerde_labio"]) ? 'Sí' : 'No';
        $sudan_manos = !empty($consulta["conductaInadaptativa"]["sudan_manos"]) ? 'Sí' : 'No';

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetFillColor(255, 255, 255);

        $pdf->Cell(46.5, 4, utf8_decode("¿Se come las uñas?: $come_unas"), 1, 0, 'L', 0);
        $pdf->Cell(46.5, 4, utf8_decode("¿Succiona dedos?: $succiona"), 1, 0, 'L', 1);
        $pdf->Cell(46.5, 4, utf8_decode("¿Muerde labios?: $muerde_labio"), 1, 0, 'L', 0);
        $pdf->Cell(46.5, 4, utf8_decode("¿Sudan manos?: $sudan_manos"), 1, 0, 'L', 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $trastornos_comportamiento = $consulta["conductaInadaptativa"]["trastornos_comportamiento"] ?? 'No refiere';
        $pdf->MultiCell(186, 4, utf8_decode('Trastornos comportamiento: ' . $trastornos_comportamiento), 1, "L", 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $trastornos_emocionales = $consulta["conductaInadaptativa"]["trastornos_emocionales"] ?? 'No refiere';
        $pdf->MultiCell(186, 4, utf8_decode('Trastornos emocionales: ' . $trastornos_emocionales), 1, "L", 0);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('JUEGOS'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $juega_solo = $consulta["conductaInadaptativa"]["juega_solo"] ?? 'No refiere';
        $pdf->MultiCell(186, 4, utf8_decode('¿Su hijo juega solo?: ' . $juega_solo), 1, "L", 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $juegos_prefiere = $consulta["conductaInadaptativa"]["juegos_prefiere"] ?? 'No refiere';
        $pdf->MultiCell(186, 4, utf8_decode('¿Que juegos prefiere?: ' . $juegos_prefiere), 1, "L", 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $prefiere_mayores = $consulta["conductaInadaptativa"]["prefiere_jugar_ninos"] ?? 'No refiere';
        $pdf->MultiCell(186, 4, utf8_decode('¿Prefiere jugar con mayores o menores?: ' . $prefiere_mayores), 1, "L", 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $distracciones = $consulta["conductaInadaptativa"]["distracciones_hijos"] ?? 'No refiere';
        $pdf->MultiCell(186, 4, utf8_decode('¿Cuales son las distracciones de su hijo?: ' . $distracciones), 1, "L", 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $conductas = $consulta["conductaInadaptativa"]["conductas_juegos"] ?? 'No refiere';
        $pdf->MultiCell(186, 4, utf8_decode('Conductas en el juego: ' . $conductas), 1, "L", 0);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('ESCOLARIDAD'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $inicio_escolaridad = $consulta["conductaInadaptativa"]["inicio_escolaridad"] ?? 'No refiere';
        $pdf->MultiCell(186, 4, utf8_decode('Inicio, ¿A que edad?: ' . $inicio_escolaridad), 1, "L", 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $cambios_colegio = $consulta["conductaInadaptativa"]["cambio_colegio"] ?? 'No refiere';
        $pdf->MultiCell(186, 4, utf8_decode('¿Cambios de colegio? ¿Por qué?: ' . $cambios_colegio), 1, "L", 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $dificultades = $consulta["conductaInadaptativa"]["dificultad_aprendizaje"] ?? 'No refiere';
        $pdf->MultiCell(186, 4, utf8_decode('Observa dificultades en el aprendizaje: ' . $dificultades), 1, "L", 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $repeticiones = $consulta["conductaInadaptativa"]["repeticiones_escolares"] ?? 'No refiere';
        $pdf->MultiCell(186, 4, utf8_decode('Repeticiones escolares: ' . $repeticiones), 1, "L", 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $conducta_clase = $consulta["conductaInadaptativa"]["conducta_clase"] ?? 'No refiere';
        $pdf->MultiCell(186, 4, utf8_decode('Conducta en clase: ' . $conducta_clase), 1, "L", 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $mayor_nivel = $consulta["conductaInadaptativa"]["materias_mayor_nivel"] ?? 'No refiere';
        $pdf->MultiCell(186, 4, utf8_decode('Materias de mayor desempeño: ' . $mayor_nivel), 1, "L", 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $menor_nivel = $consulta["conductaInadaptativa"]["materias_menor_nivel"] ?? 'No refiere';
        $pdf->MultiCell(186, 4, utf8_decode('Materias de menor desempeño: ' . $menor_nivel), 1, "L", 0);
        $pdf->Ln();
    }


}
