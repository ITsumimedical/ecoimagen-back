<?php

namespace App\Formats\ComponentesHistoriaClinica;

use App\Http\Modules\Historia\AntecedentesGinecologicos\CupGinecologico;
use App\Http\Modules\Historia\AntecedentesGinecologicos\CupMamografia;

class AntecedentesGinecologicosFormato
{

    public function bodyComponente($pdf, $consulta): void
    {
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('ANTECEDENTES GINECOBSTÉTRICOS'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);
        
        $edadCumplida = isset($consulta["Afiliado"]["edad_cumplida"]) ? $consulta["Afiliado"]["edad_cumplida"] : ' ';
        $presenteMenarquia = isset($consulta["HistoriaClinica"]["presente_menarquia"]) ? $consulta["HistoriaClinica"]["presente_menarquia"] : 'No Evaluado';
        $presenteMenopausia = isset($consulta["HistoriaClinica"]["menopausia_presente"]) ? $consulta["HistoriaClinica"]["menopausia_presente"] : 'No Evaluado';
        $edadMenopausia = isset($consulta["HistoriaClinica"]["fecha_inicio_menopausia"]) ? $consulta["HistoriaClinica"]["fecha_inicio_menopausia"] : 'No Evaluado';
        $edadMenarquia = isset($consulta["HistoriaClinica"]["edad"]) ? $consulta["HistoriaClinica"]["edad"] : 'No especificado';

        if ($edadCumplida > 40 && $presenteMenopausia === 'Si') {
        $pdf->SetX(12);
        $pdf->Cell(93, 6, utf8_decode('Menopausia: ' . $presenteMenopausia), 1, 0, 'L');
        $pdf->Cell(93, 6, utf8_decode('Edad: ' . $edadMenopausia . ' años'), 1, 1, 'L');
        } else if (($edadCumplida > 10 && $edadCumplida < 40) || $presenteMenopausia === 'No') {
        $pdf->SetX(12);
        $pdf->Cell(93, 6, utf8_decode('Menarquia: ' . $presenteMenarquia), 1, 0, 'L');
        if ($presenteMenarquia === 'Si') {
            $pdf->Cell(93, 6, utf8_decode('Edad: ' . $edadMenarquia . ' años'), 1, 1, 'L');
        } else {
            $pdf->Cell(93, 6, utf8_decode('Edad: No especificado'), 1, 1, 'L');
        }
        }

        if ($presenteMenarquia === 'Si') {
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetX(12);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('CICLOS MENSTRUALES'), 1, 0, 'C', 1);
            $pdf->Ln();
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFont('Arial', '', 8);

            $pdf->SetX(12);
            $pdf->Cell(46.5, 6, utf8_decode('Clasificación: ' . (isset($consulta["HistoriaClinica"]["clasificacion_ciclos"]) ? ($consulta["HistoriaClinica"]["clasificacion_ciclos"]) : 'No Evaluado')), 1);
            $pdf->Cell(46.5, 6, utf8_decode('Frecuencia: ' . (isset($consulta["HistoriaClinica"]["frecuencia_ciclos"]) ? ($consulta["HistoriaClinica"]["frecuencia_ciclos"]) : 'No Evaluado')), 1);
            $pdf->Cell(38.5, 6, utf8_decode('Duración: ' . (isset($consulta["HistoriaClinica"]["frecuencia_ciclos"]) ? $consulta["HistoriaClinica"]["frecuencia_ciclos"] : 'No Evaluado')), 1);
            $pdf->Cell(54.5, 6, utf8_decode('Fecha última menstruación: ' . utf8_decode(isset($consulta["HistoriaClinica"]["fecha_ultima_menstruacion"]) ? utf8_decode($consulta["HistoriaClinica"]["fecha_ultima_menstruacion"]) : 'No Evaluado')), 1);
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->Cell(60.5, 6, utf8_decode('Infecciones de transmisión sexual: ' . (isset($consulta["HistoriaClinica"]["presente_transmisionsexual"]) ? ($consulta["HistoriaClinica"]["presente_transmisionsexual"]) : 'No Evaluado')), 1);
            $pdf->Cell(56.5, 6, utf8_decode('Edad primera relación sexual: ' . (isset($consulta["HistoriaClinica"]["edad_primera"]) ? ($consulta["HistoriaClinica"]["edad_primera"]) . ' años' : 'No Evaluado')), 1);
            $pdf->Ln();
            $pdf->SetX(12);
            if ($consulta["HistoriaClinica"]["presente_transmisionsexual"] == 'Si') {
                $pdf->MultiCell(186, 6, utf8_decode('Descripción ITS: ' . (isset($consulta["HistoriaClinica"]["descripcion_transmision_sexual"]) ? ($consulta["HistoriaClinica"]["descripcion_transmision_sexual"]) : 'No Evaluado')), 1);
            }

            //Mtódo anticonceptivo
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(186, 4, utf8_decode('MÉTODO ANTICONCEPTIVO'), 1, 0, 'C', 1);
            $pdf->Ln();
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFont('Arial', '', 8);

            $pdf->SetX(12);
            $pdf->Cell(46.5, 6, utf8_decode('Presente: ' . (isset($consulta["HistoriaClinica"]["presente_metodo_anticonceptivo"]) ? utf8_decode($consulta["HistoriaClinica"]["presente_metodo_anticonceptivo"]) : 'No Evaluado')), 1);
            $pdf->Cell(46.5, 6, utf8_decode('Descripción: ' . (isset($consulta["HistoriaClinica"]["descripcion_metodo_anticonceptivo"]) ? utf8_decode($consulta["HistoriaClinica"]["descripcion_metodo_anticonceptivo"]) : 'No Evaluado')), 1);
            $pdf->Cell(46.5, 6, utf8_decode('Tipo: ' . (isset($consulta["HistoriaClinica"]["tipo_metodo_anticonceptivo"]) ? utf8_decode($consulta["HistoriaClinica"]["tipo_metodo_anticonceptivo"]) : 'No Evaluado')), 1);
            $pdf->Cell(46.5, 6, utf8_decode('Tratamiento: ' . (isset($consulta["HistoriaClinica"]["tratamiento_metodo_anticonceptivo"]) ? utf8_decode($consulta["HistoriaClinica"]["tratamiento_metodo_anticonceptivo"]) : 'No Evaluado')), 1);
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->Cell(46.5, 6, utf8_decode('Fecha de diagnóstico: ' . (isset($consulta["HistoriaClinica"]["fecha_metodo_anticonceptivo"]) ? utf8_decode($consulta["HistoriaClinica"]["fecha_metodo_anticonceptivo"]) : 'No Evaluado')), 1);
            $pdf->Ln();
            $pdf->Ln();


            // Procedimientos anteriores realizados en el cuello uterino
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(186, 4, utf8_decode('PROCEDIMIENTOS ANTERIORES EN EL CUELLO UTERINO'), 1, 0, 'C', 1);
            $pdf->Ln();
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFont('Arial', '', 8);

            $pdf->SetX(12);
            $pdf->Cell(93, 6, utf8_decode('Procedimientos en el cuello uterino: ' . (isset($consulta["HistoriaClinica"]["presente_procedimiento_cuello_uterino"]) ? utf8_decode($consulta["HistoriaClinica"]["presente_procedimiento_cuello_uterino"]) : 'No Evaluado')), 1);
            if (isset($consulta["HistoriaClinica"]["presente_procedimiento_cuello_uterino"]) == 'Si') {
                $pdf->Cell(93, 6, utf8_decode('Tratamiento en el cuello uterino: ' . (isset($consulta["HistoriaClinica"]["tratamiento_procedimiento_cuello_uterino"]) ? utf8_decode($consulta["HistoriaClinica"]["tratamiento_procedimiento_cuello_uterino"]) : 'No Evaluado')), 1);
                $pdf->Ln();
                $pdf->SetX(12);
            }
            $pdf->Ln();


            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(186, 4, utf8_decode('ANTECEDENTES OBSTETRICOS'), 1, 0, 'C', 1);
            $pdf->Ln();
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFont('Arial', '', 8);
            $pdf->SetX(12);
            $pdf->Cell(93, 6, utf8_decode('¿Planea embarazo antes de 1 año?: ' . (isset($consulta["HistoriaClinica"]["planea_embarazo"]) ? utf8_decode($consulta["HistoriaClinica"]["planea_embarazo"]) : 'No Evaluado')), 1);
            if (isset($consulta["HistoriaClinica"]["fecha_ultimo_parto"]) && $consulta["HistoriaClinica"]["fecha_ultimo_parto"] !== null) {
                $pdf->Cell(46.5, 6, utf8_decode('Fecha de último parto: ' . utf8_decode($consulta["HistoriaClinica"]["fecha_ultimo_parto"])), 1);
                $pdf->Cell(46.5, 6, utf8_decode('Gestas: ' . (isset($consulta["HistoriaClinica"]["gesta"]) ? utf8_decode($consulta["HistoriaClinica"]["gesta"]) : 'No Evaluado')), 1);
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->Cell(46.5, 6, utf8_decode('Partos: ' . (isset($consulta["HistoriaClinica"]["parto"]) ? utf8_decode($consulta["HistoriaClinica"]["parto"]) : 'No Evaluado')), 1);
                $pdf->Cell(46.5, 6, utf8_decode('Aborto: ' . (isset($consulta["HistoriaClinica"]["aborto"]) ? utf8_decode($consulta["HistoriaClinica"]["aborto"]) : 'No Evaluado')), 1);
                $pdf->Cell(46.5, 6, utf8_decode('Vivos: ' . (isset($consulta["HistoriaClinica"]["vivos"]) ? utf8_decode($consulta["HistoriaClinica"]["vivos"]) : 'No Evaluado')), 1);
                $pdf->Cell(46.5, 6, utf8_decode('Cesárea: ' . (isset($consulta["HistoriaClinica"]["cesarea"]) ? utf8_decode($consulta["HistoriaClinica"]["cesarea"]) : 'No Evaluado')), 1);
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->Cell(46.5, 6, utf8_decode('Mortinato: ' . (isset($consulta["HistoriaClinica"]["mortinato"]) ? utf8_decode($consulta["HistoriaClinica"]["mortinato"]) : 'No Evaluado')), 1);
                $pdf->Cell(46.5, 6, utf8_decode('Ectópicos: ' . (isset($consulta["HistoriaClinica"]["ectopicos"]) ? utf8_decode($consulta["HistoriaClinica"]["ectopicos"]) : 'No Evaluado')), 1);
                $pdf->Cell(46.5, 6, utf8_decode('Molas: ' . (isset($consulta["HistoriaClinica"]["molas"]) ? utf8_decode($consulta["HistoriaClinica"]["molas"]) : 'No Evaluado')), 1);
                $pdf->Cell(46.5, 6, utf8_decode('Gemelos: ' . (isset($consulta["HistoriaClinica"]["gemelos"]) ? utf8_decode($consulta["HistoriaClinica"]["gemelos"]) : 'No Evaluado')), 1);
            }
            $pdf->Ln();

            if (isset($consulta["HistoriaClinica"]["fecha_ultima_menstruacion_gestante"]) && $consulta["HistoriaClinica"]["fecha_ultima_menstruacion_gestante"] !== null) {
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(186, 4, utf8_decode('GESTANTE'), 1, 0, 'C', 1);
                $pdf->Ln();
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetFont('Arial', '', 8);

                $pdf->SetX(12);
                $pdf->Cell(62, 6, utf8_decode('Fecla última mentruación: ' . (isset($consulta["HistoriaClinica"]["fecha_ultima_menstruacion_gestante"]) ? utf8_decode($consulta["HistoriaClinica"]["fecha_ultima_menstruacion_gestante"]) : 'No Evaluado')), 1);
                $pdf->Cell(62, 6, utf8_decode('Edad gestacional por FUM: ' . (isset($consulta["HistoriaClinica"]["gestacional_fum"]) ? utf8_decode($consulta["HistoriaClinica"]["gestacional_fum"]) : 'No Evaluado')), 1);
                $pdf->Cell(62, 6, utf8_decode('Fecha probable de parto: ' . (isset($consulta["HistoriaClinica"]["fecha_probable"]) ? utf8_decode($consulta["HistoriaClinica"]["fecha_probable"]) : 'No Evaluado')), 1);
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->Cell(42.5, 6, utf8_decode('Embarazo deseado: ' . (isset($consulta["HistoriaClinica"]["embarazo_deseado"]) ? utf8_decode($consulta["HistoriaClinica"]["embarazo_deseado"]) : 'No Evaluado')), 1);
                $pdf->Cell(43.5, 6, utf8_decode('Embarazo planeado: ' . (isset($consulta["HistoriaClinica"]["embarazo_planeado"]) ? utf8_decode($consulta["HistoriaClinica"]["embarazo_planeado"]) : 'No Evaluado')), 1);
                $pdf->Cell(44.5, 6, utf8_decode('Embarazo aceptado: ' . (isset($consulta["HistoriaClinica"]["embarazo_aceptado"]) ? utf8_decode($consulta["HistoriaClinica"]["embarazo_aceptado"]) : 'No Evaluado')), 1);
                $pdf->Cell(55.5, 6, utf8_decode('Embarazo Fecha ecografia: ' . (isset($consulta["HistoriaClinica"]["fecha_pimera_eco"]) ? utf8_decode($consulta["HistoriaClinica"]["fecha_pimera_eco"]) : 'No Evaluado')), 1);
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->Cell(62, 6, utf8_decode('Edad gestacional en la ecografia: ' . (isset($consulta["HistoriaClinica"]["gestacional_eco_1"]) ? utf8_decode($consulta["HistoriaClinica"]["gestacional_eco_1"]) : 'No Evaluado')), 1);
                $pdf->Cell(62, 6, utf8_decode('Edad gestacional por ecografia: ' . (isset($consulta["HistoriaClinica"]["edad_gestacional_ecografia1"]) ? utf8_decode($consulta["HistoriaClinica"]["edad_gestacional_ecografia1"]) : 'No Evaluado')), 1);
                $pdf->Cell(62, 6, utf8_decode('Descripción: ' . (isset($consulta["HistoriaClinica"]["descripcion_eco_1"]) ? utf8_decode($consulta["HistoriaClinica"]["descripcion_eco_1"]) : 'No Evaluado')), 1);
                $pdf->Ln();

                $pdf->SetX(12);
                $pdf->Cell(62, 6, utf8_decode('Edad gestacional en la ecografia 2 : ' . (isset($consulta["HistoriaClinica"]["gestacional_eco_2"]) ? utf8_decode($consulta["HistoriaClinica"]["gestacional_eco_2"]) : 'No Evaluado')), 1);
                $pdf->Cell(62, 6, utf8_decode('Edad gestacional por ecografia 2: ' . (isset($consulta["HistoriaClinica"]["edad_gestacional_ecografia2"]) ? utf8_decode($consulta["HistoriaClinica"]["edad_gestacional_ecografia2"]) : 'No Evaluado')), 1);
                $pdf->Cell(62, 6, utf8_decode('Descripción:' . (isset($consulta["HistoriaClinica"]["descripcion_eco_2"]) ? utf8_decode($consulta["HistoriaClinica"]["descripcion_eco_2"]) : 'No Evaluado')), 1);
                $pdf->Ln();


                $pdf->SetX(12);
                $pdf->Cell(62, 6, utf8_decode('Edad gestacional en la ecografia 3: ' . (isset($consulta["HistoriaClinica"]["gestacional_eco_3"]) ? utf8_decode($consulta["HistoriaClinica"]["gestacional_eco_3"]) : 'No Evaluado')), 1);
                $pdf->Cell(62, 6, utf8_decode('Edad gestacional por ecografia 3: ' . (isset($consulta["HistoriaClinica"]["edad_gestacional_ecografia3"]) ? utf8_decode($consulta["HistoriaClinica"]["edad_gestacional_ecografia3"]) : 'No Evaluado')), 1);
                $pdf->Cell(62, 6, utf8_decode('Descripción: ' . (isset($consulta["HistoriaClinica"]["descripcion_eco_3"]) ? utf8_decode($consulta["HistoriaClinica"]["descripcion_eco_3"]) : 'No Evaluado')), 1);

                $pdf->Ln();
            }
        }

        $pdf->SetX(12);



        // Autocuidado de senos
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(186, 4, utf8_decode('¿PRACTICA EL AUTOEXAMEN DE SENOS?'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);

        $pdf->SetX(12);
        $pdf->Cell(93, 6, utf8_decode('¿Practica autoexamen de senos?: ' . (isset($consulta["HistoriaClinica"]["presente_auto_examen_senos"]) ? utf8_decode($consulta["HistoriaClinica"]["presente_auto_examen_senos"]) : 'No Evaluado')), 1);
        if ($consulta["HistoriaClinica"]["presente_auto_examen_senos"] == 'Si') {
            $pdf->Cell(93, 6, utf8_decode('Frecuencia en que lo realiza: ' . (isset($consulta["HistoriaClinica"]["frecuencia_auto_examen_senos"]) ? utf8_decode($consulta["HistoriaClinica"]["frecuencia_auto_examen_senos"]) : 'No Evaluado')), 1);
        }
        $pdf->Ln();


        $buscarCitologia = CupGinecologico::where('consulta_id', $consulta->id)
            ->with(
                'usuarioCrea.operador',
                'cup'
            )
            ->get();

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(186, 4, utf8_decode('CITOLOGÍA CERVICOUTERINA'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        if ($buscarCitologia->isNotEmpty()) {
            foreach ($buscarCitologia as $citologias) {
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode('TIPO CITOLOGÍA: ') . ' ' . utf8_decode($citologias->cup->nombre), 1, 'L');
                $pdf->SetX(12);
                $pdf->Cell(186, 4, utf8_decode('RESULTADOS: ' . ' ' . utf8_decode($citologias->resultados)), 1, 'L');
                $pdf->SetX(12);
                $pdf->Cell(186, 4, utf8_decode('PROFESIONAL QUE REGISTRA: ' . ' ' . ($citologias->usuarioCrea->operador->nombre_completo)), 1, 1, 'L');
                $pdf->SetX(12);
                $pdf->Cell(186, 4, utf8_decode('FECHA REALIZACIÓN: ') . ' ' . utf8_decode($citologias->fecha_realizacion), 1, 0, 'L');
                $pdf->Ln();
            }
        } else {
            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(186, 4, utf8_decode('No Refiere'), 1, 0, 'L');
        }

        $pdf->Ln();

        $buscarMamografia = CupMamografia::where('consulta_id', $consulta->id)
            ->with(
                'usuarioCrea.operador',
                'cup'
            )
            ->get();

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(186, 4, utf8_decode('MAMOGRAFÍA'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetX(12);

        if ($buscarMamografia->isNotEmpty()) {
            foreach ($buscarMamografia as $mamografia) {
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode('TIPO MAMOGRAFIA: ') . ' ' . utf8_decode($mamografia->cup->nombre), 1, 'L');
                $pdf->SetX(12);
                $pdf->Cell(186, 4, utf8_decode('RESULTADOS: ' . ' ' . ($mamografia->resultados)), 1, 'L');
                $pdf->SetX(12);
                $pdf->Cell(186, 4, utf8_decode('PROFESIONAL QUE REGISTRA: ' . ' ' . ($mamografia->usuarioCrea->operador->nombre_completo)), 1, 1, 'L');
                $pdf->SetX(12);
                $pdf->Cell(186, 4, utf8_decode('FECHA REALIZACIÓN: ') . ' ' . utf8_decode($mamografia->fecha_realizacion), 1, 0, 'L');
                $pdf->Ln();
            }
        } else {
            $pdf->SetFont('Arial', '', 9);
            $pdf->SetX(12);
            $pdf->Cell(186, 4, utf8_decode('No Refiere'), 1, 0, 'L');
        }

        $pdf->Ln();
    }
}
