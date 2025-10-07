<?php

namespace App\Formats\HistoriasClinicas;

use App\Http\Modules\Historia\AntecedentesPersonales\Models\AntecedentePersonale;
use App\Http\Modules\ResultadoAyudasDiagnosticos\Model\ResultadoAyudasDiagnosticas;
use App\Http\Modules\RemisionProgramas\Model\RemisionProgramas;
use Codedge\Fpdf\Facades\Fpdf;

class HistoriaClinicaFisioterapia extends Fpdf
{
    protected static $consulta;
    public function bodyFisioterapia($pdf, $consulta)
    {
        self::$consulta = $consulta;
        $y = $pdf->GetY();

        $pdf->SetXY(12, $y + 8);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('ANAMNESIS'), 1, 0, 'C', 1);
        $pdf->Ln();


        //Motivo de consulta
        $pdf->SetX(12);
        $pdf->Cell(186, 4, utf8_decode('MOTIVO DE CONSULTA'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();


        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $motivoConsulta = 'No refiere';
        if (isset(self::$consulta["HistoriaClinica"])) {
            $motivoConsulta = self::$consulta["HistoriaClinica"]["motivo_consulta"] ?? 'No refiere';
        }
        $pdf->MultiCell(186, 4, utf8_decode($motivoConsulta), 1, "L", 0);
        $pdf->Ln();

        //Enfermedad actual
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('ENFERMEDAD ACTUAL'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $enfermedadActual = 'No especificado';
        if (isset(self::$consulta["HistoriaClinica"])) {
            $enfermedadActual = self::$consulta["HistoriaClinica"]["enfermedad_actual"] ?? 'No especificado';
        }
        $pdf->MultiCell(186, 4, utf8_decode($enfermedadActual), 1, "L", 0);
        $pdf->Ln();


        $afiliadoId = self::$consulta->afiliado_id;
        $antecedentes = AntecedentePersonale::with('consulta.medicoOrdena.operador')
            ->whereHas('consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId);
            })
            ->get();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('ANTECEDENTES PERSONALES'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 8);

        if ($antecedentes->isEmpty()) {
            $pdf->SetX(12);
            $pdf->Cell(186, 4, utf8_decode('No refiere antecedentes personales.'), 1, 0, 'L');
            $pdf->Ln();
        } else {
            foreach ($antecedentes as $antecedente) {
                $pdf->SetX(12);
                // $pdf->SetFont('Arial', 'B', 8);
                // $pdf->Cell(186, 4, utf8_decode('Registro ' . $contador), 1, 0, 'L', 1);
                // $pdf->Ln();

                $pdf->SetFont('Arial', '', 8);

                // Patología
                $patologia = !empty($antecedente->patologias)
                    ? utf8_decode($antecedente->patologias)
                    : utf8_decode('No Aplica');
                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode('PATOLOGÍA: ' . $patologia), 1, 'L');

                // Fecha de diagnóstico
                $fechaDiagnostico = !empty($antecedente->fecha_diagnostico)
                    ? utf8_decode(substr($antecedente->fecha_diagnostico, 0, 10))
                    : utf8_decode('No Aplica');

                // Médico ordena (nombre completo)
                $nombreCompletoMedico = ($antecedente->consulta && $antecedente->consulta->medicoOrdena && $antecedente->consulta->medicoOrdena->operador)
                    ? utf8_decode($antecedente->consulta->medicoOrdena->operador->nombre . ' ' . $antecedente->consulta->medicoOrdena->operador->apellido)
                    : utf8_decode('No Aplica');

                // Concatenar los campos en una sola línea
                $detalle = utf8_decode('FECHA DIAGNÓSTICO: ' . $fechaDiagnostico . ' | REGISTRADO POR: ' . utf8_decode($nombreCompletoMedico));

                // Imprimir el texto concatenado
                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, $detalle, 1, 'L');

                $pdf->Ln(2);
            }
        }
        $pdf->Ln();

         //imprimir ayudas diagnósticas
         $pdf->SetX(12);
         $pdf->SetFont('Arial', 'B', 9);
         $pdf->SetDrawColor(0, 0, 0);
         $pdf->SetFillColor(214, 214, 214);
         $pdf->SetTextColor(0, 0, 0);
         $pdf->Cell(186, 4, utf8_decode('RESULTADOS AYUDAS DIAGNÓSTICAS'), 1, 0, 'C', 1);
         $pdf->Ln();

         $afiliadoId = self::$consulta->afiliado_id;

         $ayudasDiagnosticas = ResultadoAyudasDiagnosticas::with(['cups:id,nombre', 'user.operador:id,nombre,apellido,user_id'])
             ->whereHas('consulta', function ($query) use ($afiliadoId) {
                 $query->where('afiliado_id', $afiliadoId);
             })
             ->orderBy('id', 'desc')
             ->get();

         $historiaClinica = self::$consulta["HistoriaClinica"] ?? null;

         $resultados = [];

         if ($historiaClinica) {
             if (!empty($historiaClinica['cup']['nombre']) && !empty($historiaClinica['resultado_ayuda_diagnostica'])) {
                 $resultados = [
                     'ayuda_diagnostica' => $historiaClinica['cup']['nombre'],
                     'observaciones' => $historiaClinica['resultado_ayuda_diagnostica'],
                     'registrado_por' => self::$consulta["medicoOrdena"]["operador"]["nombre_completo"] ?? 'No Refiere',
                 ];
             }
         }

         foreach ($ayudasDiagnosticas as $ayuda) {
             if (!empty($ayuda->cups->nombre) && !empty($ayuda->observaciones)) {
                 $resultados[] = [
                     'ayuda_diagnostica' => $ayuda->cups->nombre,
                     'observaciones' => $ayuda->observaciones,
                     'registrado_por' => utf8_decode($ayuda->user->operador->nombre_completo) ?? 'No Refiere',
                 ];
             }
         }

         $pdf->SetFont('Arial', '', 8);

         if (empty($resultados)) {
             $pdf->SetX(12);
             $pdf->Cell(186, 4, utf8_decode('No se encontraron resultados asociados.'), 1, 0, 'L');
             $pdf->Ln();
         } else {
             foreach ($resultados as $resultado) {
                 $pdf->SetX(12);
                 $pdf->SetFont('Arial', 'B', 8);
                 // $pdf->Cell(186, 4, utf8_decode('Registro ' . $contador), 1, 0, 'L', 1);
                 // $pdf->Ln();

                 // Ayuda Diagnóstica
                 if (!empty($resultado['ayuda_diagnostica'])) {
                     $pdf->SetX(12);
                     $pdf->SetFont('Arial', '', 8);
                     $pdf->MultiCell(186, 4, utf8_decode('AYUDA DIAGNÓSTICA: ' . $resultado['ayuda_diagnostica']), 1, 'L');
                 }

                 // Observaciones
                 if (!empty($resultado['observaciones'])) {
                     $pdf->SetX(12);
                     $pdf->MultiCell(186, 4, utf8_decode('OBSERVACIONES: ' . $resultado['observaciones']), 1, 'L');
                 }

                 // Registrado Por
                 if (!empty($resultado['registrado_por'])) {
                     $pdf->SetX(12);
                     $pdf->MultiCell(186, 4, utf8_decode('REGISTRADO POR: ' . utf8_decode($resultado['registrado_por'])), 1, 'L');
                 }

                 $pdf->Ln(2);
             }
         }
         $pdf->Ln();


         $pdf->SetX(12);
         $pdf->SetFont('Arial', 'B', 9);
         $pdf->SetDrawColor(0, 0, 0);
         $pdf->SetFillColor(214, 214, 214);
         $pdf->SetTextColor(0, 0, 0);
         $pdf->Cell(186, 4, utf8_decode('EXÁMEN FISICO'), 1, 0, 'C', 1);
         $pdf->Ln();
         $pdf->SetX(12);
         $pdf->SetFont('Arial', '', 9);
         $pdf->Cell(62, 4, "Dolor presente: " . utf8_decode(isset(self::$consulta["ExamenFisioterapia"]["dolor_presente"]) && self::$consulta["ExamenFisioterapia"]["dolor_presente"] !== null ? self::$consulta["ExamenFisioterapia"]["dolor_presente"] : 'sin hallazgos'), 1, 0, 'L');
         if (self::$consulta["ExamenFisioterapia"]["dolor_presente"] == 'Si') {
            $pdf->Cell(62, 4, "Frecuencia del dolor: " . utf8_decode(isset(self::$consulta["ExamenFisioterapia"]["frecuencia_dolo"]) && self::$consulta["ExamenFisioterapia"]["frecuencia_dolo"] !== null ? self::$consulta["ExamenFisioterapia"]["frecuencia_dolo"] : 'sin hallazgos'), 1, 0, 'L');
            $pdf->Cell(62, 4, "Intensidad del dolor: " . utf8_decode(isset(self::$consulta["ExamenFisioterapia"]["intensidad_dolor"]) && self::$consulta["ExamenFisioterapia"]["intensidad_dolor"] !== null ? self::$consulta["ExamenFisioterapia"]["intensidad_dolor"] : 'sin hallazgos'), 1, 0, 'L');
        }
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->Cell(93, 4, "Presenta edema: " . utf8_decode(isset(self::$consulta["ExamenFisioterapia"]["edema_presente"]) && self::$consulta["ExamenFisioterapia"]["edema_presente"] !== null ? self::$consulta["ExamenFisioterapia"]["edema_presente"] : 'sin hallazgos'), 1, 0, 'L');
        if(self::$consulta["ExamenFisioterapia"]["edema_presente"] == 'Si') {
            $pdf->Cell(93, 4, utf8_decode("Ubicación: ") . utf8_decode(isset(self::$consulta["ExamenFisioterapia"]["ubicacion_edema"]) && self::$consulta["ExamenFisioterapia"]["ubicacion_edema"] !== null ? self::$consulta["ExamenFisioterapia"]["ubicacion_edema"] : 'sin hallazgos'), 1, 0, 'L');
        }
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->Cell(93, 4, "Sensibilidad Conservada: " . utf8_decode(isset(self::$consulta["ExamenFisioterapia"]["sensibilidad_conservada"]) && self::$consulta["ExamenFisioterapia"]["sensibilidad_conservada"] !== null ? self::$consulta["ExamenFisioterapia"]["sensibilidad_conservada"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Cell(93, 4, "Sensibilidad Alterada: " . utf8_decode(isset(self::$consulta["ExamenFisioterapia"]["sensibilidad_alterada"]) && self::$consulta["ExamenFisioterapia"]["sensibilidad_alterada"] !== null ? self::$consulta["ExamenFisioterapia"]["sensibilidad_alterada"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->MultiCell(186, 4, "Ubicacion Sensibilidad: " . utf8_decode(isset(self::$consulta["ExamenFisioterapia"]["ubicacion_sensibilidad"]) && self::$consulta["ExamenFisioterapia"]["ubicacion_sensibilidad"] !== null ? self::$consulta["ExamenFisioterapia"]["ubicacion_sensibilidad"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->SetX(12);
        $pdf->Cell(93, 4, utf8_decode("Calificación Fuerza Muscular: ") . utf8_decode(isset(self::$consulta["ExamenFisioterapia"]["fuerza_muscular"]) && self::$consulta["ExamenFisioterapia"]["fuerza_muscular"] !== null ? self::$consulta["ExamenFisioterapia"]["fuerza_muscular"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->MultiCell(93, 4, "Pruebas semiologicas: " . utf8_decode(isset(self::$consulta["ExamenFisioterapia"]["pruebas_semiologicas"]) && self::$consulta["ExamenFisioterapia"]["pruebas_semiologicas"] !== null ? self::$consulta["ExamenFisioterapia"]["pruebas_semiologicas"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->SetX(12);
        $pdf->Cell(46.5, 4, "Equilibrio Conservado: " . utf8_decode(isset(self::$consulta["ExamenFisioterapia"]["equilibrio_conservado"]) && self::$consulta["ExamenFisioterapia"]["equilibrio_conservado"] !== null ? self::$consulta["ExamenFisioterapia"]["equilibrio_conservado"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Cell(46.5, 4, "Equilibrio Alterado: " . utf8_decode(isset(self::$consulta["ExamenFisioterapia"]["equilibrio_alterado"]) && self::$consulta["ExamenFisioterapia"]["equilibrio_alterado"] !== null ? self::$consulta["ExamenFisioterapia"]["equilibrio_alterado"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Cell(46.5, 4, "Marcha Conservada: " . utf8_decode(isset(self::$consulta["ExamenFisioterapia"]["marcha_conservada"]) && self::$consulta["ExamenFisioterapia"]["marcha_conservada"] !== null ? self::$consulta["ExamenFisioterapia"]["marcha_conservada"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Cell(46.5, 4, "Marcha Alterada: " . utf8_decode(isset(self::$consulta["ExamenFisioterapia"]["marcha_alterada"]) && self::$consulta["ExamenFisioterapia"]["marcha_alterada"] !== null ? self::$consulta["ExamenFisioterapia"]["marcha_alterada"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->MultiCell(186, 4, "Ayudas Externas: " . utf8_decode(isset(self::$consulta["ExamenFisioterapia"]["ayudas_externas"]) && self::$consulta["ExamenFisioterapia"]["ayudas_externas"] !== null ? self::$consulta["ExamenFisioterapia"]["ayudas_externas"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('REMISION A PROGRAMAS'), 1, 0, 'C', 1);
        $pdf->Ln();

        $afiliadoId = self::$consulta->afiliado_id;

        $remisiones = RemisionProgramas::whereHas('consulta', function ($query) use ($afiliadoId) {
            $query->where('afiliado_id', $afiliadoId);
        })
            ->orderBy('id', 'desc')
            ->get();

        if ($remisiones->isEmpty()) {
            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(186, 4, utf8_decode('No refiere'), 1, 0, 'L', 0);
            $pdf->Ln();
        } else {
            foreach ($remisiones as $remision) {
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(186, 4, utf8_decode("Remisión: " . ($remision->remision_programa ?? 'No refiere')), 1, 0, 'L', 0);
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, utf8_decode("Observación: ") . utf8_decode($remision->observacion ?? 'No refiere'), 1, 'L', 0);
            }
        }

         $pdf->Ln();
         $pdf->SetX(12);
         $pdf->SetFont('Arial', 'B', 9);
         $pdf->SetDrawColor(0, 0, 0);
         $pdf->SetFillColor(214, 214, 214);
         $pdf->SetTextColor(0, 0, 0);
         $pdf->Cell(186, 4, utf8_decode('DIAGNÓSTICOS'), 1, 0, 'C', 1);
         $pdf->Ln();
         $pdf->SetX(12);
         $pdf->Cell(186, 4, utf8_decode('DIAGNÓSTICO PRINCIPAL'), 1, 0, 'C', 1);
         $pdf->Ln();
         $pdf->SetX(12);
         $pdf->SetTextColor(0, 0, 0);
         $pdf->SetDrawColor(0, 0, 0);
         $pdf->SetFont('Arial', '', 8);

         // Obtener el primer diagnóstico como principal
         $diagnosticoPrincipal = self::$consulta->cie10Afiliado->first();
         $codigoCie10 = isset($diagnosticoPrincipal->cie10->codigo_cie10) ? $diagnosticoPrincipal->cie10->codigo_cie10 : '';
         $descripcionDiagnostico = isset($diagnosticoPrincipal->cie10->nombre) ? $diagnosticoPrincipal->cie10->nombre : '';
         $tipoDiagnostico = isset($diagnosticoPrincipal->tipo_diagnostico) ? $diagnosticoPrincipal->tipo_diagnostico : '';

         $textoDXprincipal = "CODIGO CIE10: " . utf8_decode($codigoCie10) .
             ", DESCRIPCION DEL DIAGNOSTICO: " . utf8_decode($descripcionDiagnostico) .
             ", TIPO DEL DIAGNOSTICO: " . utf8_decode($tipoDiagnostico);

         $pdf->SetX(12);
         $pdf->MultiCell(186, 4, $textoDXprincipal, 1, "L", 0);
         // Filtrar diagnósticos secundarios
         $diagnosticosSecundarios = self::$consulta->cie10Afiliado->slice(1);
         if ($diagnosticosSecundarios->isNotEmpty()) {
             $pdf->SetX(12);
             $pdf->SetFont('Arial', 'B', 9);
             $pdf->SetDrawColor(0, 0, 0);
             $pdf->SetFillColor(214, 214, 214);
             $pdf->SetTextColor(0, 0, 0);
             $pdf->Cell(186, 4, utf8_decode('DIAGNÓSTICOS SECUNDARIOS'), 1, 0, 'C', 1);
             $pdf->Ln();
             $pdf->SetX(12);
             $pdf->SetTextColor(0, 0, 0);
             $pdf->SetDrawColor(0, 0, 0);
             $pdf->SetFont('Arial', '', 8);

             foreach ($diagnosticosSecundarios as $diagnostico) {
                 $codigoCie10 = isset($diagnostico->cie10->codigo_cie10) ? $diagnostico->cie10->codigo_cie10 : '';
                 $descripcion = isset($diagnostico->cie10->nombre) ? $diagnostico->cie10->nombre : '';
                 $tipoDiagnostico = isset($diagnostico->tipo_diagnostico) ? $diagnostico->tipo_diagnostico : '';

                 $textoDXSecundario = "CODIGO CIE10: " . utf8_decode($codigoCie10) .
                     ", DESCRIPCION DEL DIAGNOSTICO: " . utf8_decode($descripcion) .
                     ", TIPO DEL DIAGNOSTICO: " . utf8_decode($tipoDiagnostico);

                 $pdf->SetX(12);
                 $pdf->MultiCell(186, 4, $textoDXSecundario, 1, "L", 0);
             }
             $pdf->Ln();
         }
         $pdf->Ln();

         $pdf->Ln();
         $pdf->SetX(12);
         $pdf->SetFont('Arial', 'B', 9);
         $pdf->SetDrawColor(0, 0, 0);
         $pdf->SetFillColor(214, 214, 214);
         $pdf->SetTextColor(0, 0, 0);
         $pdf->Cell(186, 4, utf8_decode('CONDUCTA'), 1, 0, 'C', 1);
         $pdf->Ln();
         $y = $pdf->GetY();

         $pdf->Ln();
         $pdf->SetX(12);
         $pdf->SetFont('Arial', 'B', 8);
         $pdf->Cell(186, 4, utf8_decode("PLAN DE MANEJO:"), 0, 0, 'L', 0);
         $pdf->Ln();
         $pdf->SetX(12);
         $pdf->SetFont('Arial', '', 8);

         $planManejo = isset(self::$consulta["HistoriaClinica"]["plan_manejo"]) ? self::$consulta["HistoriaClinica"]["plan_manejo"] : 'No Aplica';
         $pdf->SetX(12);
         $pdf->MultiCell(186, 4, utf8_decode($planManejo), 0, 'L');
         $pdf->Line(12, $pdf->GetY(), 198, $pdf->GetY());
         $y = $pdf->GetY();

         $pdf->SetFont('Arial', 'B', 8);
         $pdf->SetX(12);
         $pdf->Cell(186, 4, utf8_decode("RECOMENDACIONES:"), 0, 0, 'L', 0);
         $pdf->Ln();
         $pdf->SetX(12);
         $pdf->SetFont('Arial', '', 8);

         $recomendaciones = isset(self::$consulta["HistoriaClinica"]["recomendaciones"]) ? self::$consulta["HistoriaClinica"]["recomendaciones"] : 'No Aplica';
         $pdf->SetX(12);
         $pdf->MultiCell(186, 4, utf8_decode($recomendaciones), 0, 'L');
         $pdf->Line(12, $pdf->GetY(), 198, $pdf->GetY());
         $y = $pdf->GetY();

         $pdf->SetFont('Arial', 'B', 8);
         $pdf->SetX(12);
         $pdf->Cell(186, 4, utf8_decode("PORCENTAJE DE REHABILITACIÓN::"), 0, 0, 'L', 0);
         $pdf->Ln();
         $pdf->SetX(12);
         $pdf->SetFont('Arial', '', 8);
         $porcentaje = isset(self::$consulta["HistoriaClinica"]["porcentaje_rehabilitacion"]) ? self::$consulta["HistoriaClinica"]["porcentaje_rehabilitacion"] : 'No Aplica';
         $pdf->SetX(12);
         $pdf->MultiCell(186, 4, utf8_decode($porcentaje), 0, 'L');
         $pdf->Line(12, $pdf->GetY(), 198, $pdf->GetY());
         $y = $pdf->GetY();

         $pdf->SetFont('Arial', 'B', 8);
         $pdf->SetX(12);
         $pdf->Cell(186, 4, utf8_decode("ADHERENCIA ALTRATAMIENTO:"), 0, 0, 'L', 0);
         $pdf->Ln();
         $pdf->SetX(12);
         $pdf->SetFont('Arial', '', 8);
         $adherencia = isset(self::$consulta["HistoriaClinica"]["adherencia_tratamiento"]) ? self::$consulta["HistoriaClinica"]["adherencia_tratamiento"] : 'No Aplica';
         $pdf->SetX(12);
         $pdf->MultiCell(186, 4, utf8_decode($adherencia), 0, 'L');
         $pdf->Line(12, $pdf->GetY(), 198, $pdf->GetY());
         $y = $pdf->GetY();

         $pdf->SetFont('Arial', 'B', 8);
         $pdf->SetX(12);
         $pdf->Cell(186, 4, utf8_decode("DESTINO DEL PACIENTE:"), 0, 0, 'L', 0);
         $pdf->Ln();
         $pdf->SetX(12);
         $pdf->SetFont('Arial', '', 8);

         $destino = isset(self::$consulta["HistoriaClinica"]["destino_paciente"]) ? self::$consulta["HistoriaClinica"]["destino_paciente"] : 'No Aplica';
         $pdf->SetX(12);
         $pdf->MultiCell(186, 4, utf8_decode($destino), 0, 'L');
         $pdf->Line(12, $pdf->GetY(), 198, $pdf->GetY());
         $y = $pdf->GetY();

         $pdf->SetFont('Arial', 'B', 8);
         $pdf->SetX(12);
         $pdf->Cell(186, 4, utf8_decode("FINALIDAD:"), 0, 0, 'L', 0);
         $pdf->Ln();
         $pdf->SetX(12);
         $pdf->SetFont('Arial', '', 8);

         $nota_evolucion = isset(self::$consulta["HistoriaClinica"]["finalidadConsulta"]["nombre"])
             ? self::$consulta["HistoriaClinica"]["finalidadConsulta"]["nombre"]
             : (isset(self::$consulta["HistoriaClinica"]["finalidad"])
                 ? self::$consulta["HistoriaClinica"]["finalidad"]
                 : 'No Aplica');

         $pdf->SetX(12);
         $pdf->MultiCell(186, 4, utf8_decode($nota_evolucion), 0, 'L');
         $pdf->Line(12, $pdf->GetY(), 198, $pdf->GetY());
         $y = $pdf->GetY();

    }
}
