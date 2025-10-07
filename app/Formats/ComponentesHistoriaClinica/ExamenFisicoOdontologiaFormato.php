<?php

namespace App\Formats\ComponentesHistoriaClinica;

class ExamenFisicoOdontologiaFormato
{
    public function bodyComponente($pdf, $consulta): void
    {
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('EXAMÉN FISICO'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('CARA Y CUELLO'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Asimetrías: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["asimetria"] !== null ? $consulta["examenFisicoOdontologicos"]["asimetria"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Lunares, manchas, tatuajes: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["lunares_manchas_tatuajes"] !== null ? $consulta["examenFisicoOdontologicos"]["lunares_manchas_tatuajes"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Aumento de volúmen: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["aumento_volumen"] !== null ? $consulta["examenFisicoOdontologicos"]["aumento_volumen"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Ganglios linfáticos: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["ganglios_linfaticos"] !== null ? $consulta["examenFisicoOdontologicos"]["ganglios_linfaticos"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Senos maxilares: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["senos_maxilares"] !== null ? $consulta["examenFisicoOdontologicos"]["senos_maxilares"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "Agudeza Visual ojo Izquierdo: " . utf8_decode(isset($consulta["HistoriaClinica"]["agudeza_visual_ojo_izquierdo"]) && $consulta["HistoriaClinica"]["agudeza_visual_ojo_izquierdo"] !== null ? $consulta["HistoriaClinica"]["agudeza_visual_ojo_izquierdo"] : 'sin hallazgos'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "Agudeza Visual ojo Derecho: " . utf8_decode(isset($consulta["HistoriaClinica"]["agudeza_visual_ojo_derecho"]) && $consulta["HistoriaClinica"]["agudeza_visual_ojo_derecho"] !== null ? $consulta["HistoriaClinica"]["agudeza_visual_ojo_derecho"] : 'sin hallazgos'), 1, 'L', 0);
        $pdf->Ln();


        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('EXAMÉN DE ARTICULACIÓN TEMPOROMANDIBULAR'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Ruidos: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["ruidos"] !== null ? $consulta["examenFisicoOdontologicos"]["ruidos"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Chasquidos: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["chasquidos"] !== null ? $consulta["examenFisicoOdontologicos"]["chasquidos"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Crepitaciones: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["crepitaciones"] !== null ? $consulta["examenFisicoOdontologicos"]["crepitaciones"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Bloqueo mandibular: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["bloqueo_mandibular"] !== null ? $consulta["examenFisicoOdontologicos"]["bloqueo_mandibular"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Dolor: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["dolor"] !== null ? $consulta["examenFisicoOdontologicos"]["dolor"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Apertura y cierre:	" . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["apertura_cierre"] !== null ? $consulta["examenFisicoOdontologicos"]["apertura_cierre"] : 'No' : 'No')), 1, 'L', 0);


        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('EXÁMEN ESTOMATOLÓGICO'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Labio inferior: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["labio_inferior"] !== null ? $consulta["examenFisicoOdontologicos"]["labio_inferior"] : 'Normal' : 'Normal')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Labio superior: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["labio_superior"] !== null ? $consulta["examenFisicoOdontologicos"]["labio_superior"] : 'Normal' : 'Normal')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Comisuras: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["comisuras"] !== null ? $consulta["examenFisicoOdontologicos"]["comisuras"] : 'Normal' : 'Normal')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Mucosa oral: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["mucosa_oral"] !== null ? $consulta["examenFisicoOdontologicos"]["mucosa_oral"] : 'Normal' : 'Normal')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Carrillos: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["carrillos"] !== null ? $consulta["examenFisicoOdontologicos"]["carrillos"] : 'Normal' : 'Normal')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Surcos yugales: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["surcos_yugales"] !== null ? $consulta["examenFisicoOdontologicos"]["surcos_yugales"] : 'Normal' : 'Normal')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Frenillos: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["frenillos"] !== null ? $consulta["examenFisicoOdontologicos"]["frenillos"] : 'Normal' : 'Normal')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Orofaringe: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["orofaringe"] !== null ? $consulta["examenFisicoOdontologicos"]["orofaringe"] : 'Normal' : 'Normal')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Paladar: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["paladar"] !== null ? $consulta["examenFisicoOdontologicos"]["paladar"] : 'Normal' : 'Normal')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Glándulas salivares: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["glandulas_salivares"] !== null ? $consulta["examenFisicoOdontologicos"]["glandulas_salivares"] : 'Normal' : 'Normal')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Piso de boca: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["piso_boca"] !== null ? $consulta["examenFisicoOdontologicos"]["piso_boca"] : 'Normal' : 'Normal')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Dorso de lengua: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["dorso_lengua"] !== null ? $consulta["examenFisicoOdontologicos"]["dorso_lengua"] : 'Normal' : 'Normal')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Vientre de lengua:	" . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["vientre_lengua"] !== null ? $consulta["examenFisicoOdontologicos"]["vientre_lengua"] : 'Normal' : 'Normal')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Músculos masticadores: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["musculos_masticadores"] !== null ? $consulta["examenFisicoOdontologicos"]["musculos_masticadores"] : 'Normal' : 'Normal')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Riesgo de caídas: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["riesgo_caidas"] !== null ? $consulta["examenFisicoOdontologicos"]["riesgo_caidas"] : 'Normal' : 'Normal')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Otros:	" . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["otros"] !== null ? $consulta["examenFisicoOdontologicos"]["otros"] : 'Normal' : 'Normal')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('EXÁMEN FUNCIONAL'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Masticación: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["masticacion"] !== null ? $consulta["examenFisicoOdontologicos"]["masticacion"] : 'Normal' : 'Normal')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Deglución:	" . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["deglucion"] !== null ? $consulta["examenFisicoOdontologicos"]["deglucion"] : 'Normal' : 'Normal')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Habla: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["habla"] !== null ? $consulta["examenFisicoOdontologicos"]["habla"] : 'Normal' : 'Normal')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Fonación: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["fonacion"] !== null ? $consulta["examenFisicoOdontologicos"]["fonacion"] : 'Normal' : 'Normal')), 1, 'L', 0);


        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('OCLUSIÓN'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Relaciones molares: " . utf8_decode(isset($consulta["examenFisicoOdontologicos"]["relaciones_molares"]) ? $consulta["examenFisicoOdontologicos"]["relaciones_molares"] : 'No se puede determinar')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Relaciones caninas: " . utf8_decode(isset($consulta["examenFisicoOdontologicos"]["relaciones_caninas"]) ? $consulta["examenFisicoOdontologicos"]["relaciones_caninas"] : 'No se puede determinar')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Relación interdental: " . utf8_decode(isset($consulta["examenFisicoOdontologicos"]["relacion_interdental"]) ? $consulta["examenFisicoOdontologicos"]["relacion_interdental"] : 'No se puede determinar')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Tipo de oclusión: " . utf8_decode(isset($consulta["examenFisicoOdontologicos"]["tipo_oclusion"]) ? $consulta["examenFisicoOdontologicos"]["tipo_oclusion"] : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Apiñamiento: " . utf8_decode(isset($consulta["examenFisicoOdontologicos"]["apiñamiento"]) ? $consulta["examenFisicoOdontologicos"]["apiñamiento"] : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Mordida abierta: " . utf8_decode(isset($consulta["examenFisicoOdontologicos"]["mordida_abierta"]) ? $consulta["examenFisicoOdontologicos"]["mordida_abierta"] : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Mordida profunda: " . utf8_decode(isset($consulta["examenFisicoOdontologicos"]["mordida_profunda"]) ? $consulta["examenFisicoOdontologicos"]["mordida_profunda"] : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Mordida cruzada: " . utf8_decode(isset($consulta["examenFisicoOdontologicos"]["mordida_cruzada"]) ? $consulta["examenFisicoOdontologicos"]["mordida_cruzada"] : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Discrepancias óseas: " . utf8_decode(isset($consulta["examenFisicoOdontologicos"]["discrepancias_oseas"]) ? $consulta["examenFisicoOdontologicos"]["discrepancias_oseas"] : 'No')), 1, 'L', 0);

    }
}
