<?php

namespace App\Formats\HistoriasClinicas;

use App\Http\Modules\Historia\AntecedentesFamiliares\Models\AntecedenteFamiliare;
use App\Http\Modules\Historia\AntecedentesPersonales\Models\AntecedentePersonale;
use App\Http\Modules\RemisionProgramas\Model\RemisionProgramas;

use Codedge\Fpdf\Facades\Fpdf;
use DateTime;

class HistoriaClinicaNeuropsicologiaAdulto extends Fpdf
{
    protected static $consulta;

    public function bodyNeuropsicologiaAdulto($pdf, $consulta)
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

        $afiliadoId = self::$consulta->afiliado_id;
        $antecedentesFamiliares = AntecedenteFamiliare::with('consulta.medicoOrdena.operador', 'cie10')
            ->whereHas('consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId);
            })
            ->get();

        // Imprimir encabezado de antecedentes familiares
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 6, utf8_decode('ANTECEDENTES FAMILIARES'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 8);

        $noTieneAntecedentes = $antecedentesFamiliares->every(function ($familiares) {
            return $familiares->no_tiene_antecedentes;
        });

        if ($noTieneAntecedentes) {
            // Si no hay antecedentes familiares, mostrar mensaje
            $pdf->SetX(12);
            $pdf->Cell(186, 6, utf8_decode('No refiere antecedentes familiares'), 1, 0, 'L');
            $pdf->Ln();
        } else {
            foreach ($antecedentesFamiliares as $familiares) {
                if ($familiares->no_tiene_antecedentes) {
                    continue; // Si el antecedente tiene no_tiene_antecedentes como true, no se muestra
                }

                $pdf->SetX(12);
                // $pdf->SetFont('Arial', 'B', 8);
                // $pdf->Cell(186, 4, utf8_decode('Registro ' . $contador), 1, 0, 'L', 1);
                // $pdf->Ln();

                $pdf->SetFont('Arial', '', 8);

                // Diagnóstico
                $diagnostico = $familiares->cie10
                    ? utf8_decode($familiares->cie10->nombre)
                    : utf8_decode('Diagnóstico no especificado');
                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode('DIAGNÓSTICO: ' . $diagnostico), 1, 'L');


                // Parentesco
                $parentesco = !empty($familiares->parentesco)
                    ? utf8_decode($familiares->parentesco)
                    : utf8_decode('No especificado');
                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode('PARENTESCO: ' . $parentesco), 1, 'L');

                // Fecha
                $fecha = utf8_decode((new DateTime($familiares->created_at))->format('Y-m-d'));

                // Fallecido
                $fallecio = utf8_decode(($familiares->fallecido == 1) ? 'Sí' : 'No');

                // Médico que ordenó
                $nombreCompletoMedico = ($familiares->consulta && $familiares->consulta->medicoOrdena && $familiares->consulta->medicoOrdena->operador)
                    ? utf8_decode($familiares->consulta->medicoOrdena->operador->nombre . ' ' . $familiares->consulta->medicoOrdena->operador->apellido)
                    : utf8_decode('No Aplica');

                // Concatenar los tres campos
                $detalle = utf8_decode('FECHA: ' . $fecha . ' | FALLECIDO: ' . $fallecio . ' | REGISTRADO POR: ' . utf8_decode($nombreCompletoMedico));

                // Imprimir el texto concatenado
                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, $detalle, 1, 'L');

                $pdf->Ln(2);
            }

            if ($antecedentesFamiliares->isEmpty()) {
                $pdf->SetX(12);
                $pdf->Cell(186, 6, utf8_decode('No refiere antecedentes familiares.'), 1, 0, 'L');
                $pdf->Ln();
            }
        }
        $pdf->Ln();


        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(186, 4, utf8_decode('NEUROPSICOLOGIA ADULTOS'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetX(12);
        $pdf->Cell(62, 4, "Estado animo: " . utf8_decode(isset(self::$consulta["neuropsicologia"]["estado_animo_comportamiento"]) && self::$consulta["neuropsicologia"]["estado_animo_comportamiento"] !== null ? self::$consulta["neuropsicologia"]["estado_animo_comportamiento"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Cell(62, 4, utf8_decode("Actividades básicas: ") . utf8_decode(isset(self::$consulta["neuropsicologia"]["actividades_basicas_instrumentales"]) && self::$consulta["neuropsicologia"]["actividades_basicas_instrumentales"] !== null ? self::$consulta["neuropsicologia"]["actividades_basicas_instrumentales"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Cell(62, 4, "Composicion familiar: " . utf8_decode(isset(self::$consulta["neuropsicologia"]["composicion_familiar"]) && self::$consulta["neuropsicologia"]["composicion_familiar"] !== null ? self::$consulta["neuropsicologia"]["composicion_familiar"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->Cell(62, 4, utf8_decode("Evolución y pruebas: ") . utf8_decode(isset(self::$consulta["neuropsicologia"]["evolucion_pruebas"]) && self::$consulta["neuropsicologia"]["evolucion_pruebas"] !== null ? self::$consulta["neuropsicologia"]["evolucion_pruebas"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Cell(62, 4, utf8_decode("Nivel pre morbido: ") . utf8_decode(isset(self::$consulta["neuropsicologia"]["nivel_pre_morbido"]) && self::$consulta["neuropsicologia"]["nivel_pre_morbido"] !== null ? self::$consulta["neuropsicologia"]["nivel_pre_morbido"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Ln();
        $pdf->Ln();


        $pdf->SetX(12);
        $pdf->Cell(186, 4, utf8_decode('ESTILOS DE VIDA'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->Cell(62, 4, "Consume frutas y verduras: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["dieta_saludable"]) && self::$consulta["HistoriaClinica"]["dieta_saludable"] !== null ? self::$consulta["HistoriaClinica"]["dieta_saludable"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Cell(62, 4, "Frecuencia: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["frecuencia_dieta_saludable"]) && self::$consulta["HistoriaClinica"]["frecuencia_dieta_saludable"] !== null ? self::$consulta["HistoriaClinica"]["frecuencia_dieta_saludable"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Cell(62, 4, "Dieta balanceada: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["dieta_balanceada"]) && self::$consulta["HistoriaClinica"]["dieta_balanceada"] !== null ? self::$consulta["HistoriaClinica"]["dieta_balanceada"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->Cell(62, 4, utf8_decode("Comidas en el día: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["cuantas_comidas"]) && self::$consulta["HistoriaClinica"]["cuantas_comidas"] !== null ? self::$consulta["HistoriaClinica"]["cuantas_comidas"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Cell(62, 4, utf8_decode("Sueño reparador: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["sueno_reparador"]) && self::$consulta["HistoriaClinica"]["sueno_reparador"] !== null ? self::$consulta["HistoriaClinica"]["sueno_reparador"] : 'sin hallazgos'), 1, 0, 'L');
        if (self::$consulta["HistoriaClinica"]["sueno_reparador"] === 'Si') {
            $pdf->Cell(62, 4, utf8_decode("Tipo de sueño: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["tipo_sueno"]) && self::$consulta["HistoriaClinica"]["tipo_sueno"] !== null ? self::$consulta["HistoriaClinica"]["tipo_sueno"] : 'sin hallazgos'), 1, 0, 'L');
        }
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->Cell(62, 4, utf8_decode("Duración del sueño: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["duracion_sueno"]) && self::$consulta["HistoriaClinica"]["duracion_sueno"] !== null ? self::$consulta["HistoriaClinica"]["duracion_sueno"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Cell(62, 4, utf8_decode("Actividad fisica: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["actividad_fisica"]) && self::$consulta["HistoriaClinica"]["actividad_fisica"] !== null ? self::$consulta["HistoriaClinica"]["actividad_fisica"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Cell(62, 4, utf8_decode("Esfinter vesical: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["esfinter"]) && self::$consulta["HistoriaClinica"]["esfinter"] !== null ? self::$consulta["HistoriaClinica"]["esfinter"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->Cell(62, 4, utf8_decode("Esfinter rectal: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["esfinter_rectal"]) && self::$consulta["HistoriaClinica"]["esfinter_rectal"] !== null ? self::$consulta["HistoriaClinica"]["esfinter_rectal"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Cell(62, 4, utf8_decode("Frecuencia de orina: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["caracteristicas_orina"]) && self::$consulta["HistoriaClinica"]["caracteristicas_orina"] !== null ? self::$consulta["HistoriaClinica"]["caracteristicas_orina"] : 'sin hallazgos'), 1, 0, 'L');

        $pdf->SetX(12);
        $pdf->SetFont('arial', 'B', '9');
        $pdf->Cell(186, 4, utf8_decode('HÁBITOS TÓXICOS'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('arial', '', '9');
        if (self::$consulta["HistoriaClinica"]["afiliado_fumador"]) {
            $pdf->Cell(62, 4, utf8_decode("Tipo de exposición: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["expuesto_humo"]) && self::$consulta["HistoriaClinica"]["expuesto_humo"] !== null ? self::$consulta["HistoriaClinica"]["expuesto_humo"] : 'No refiere'), 1, 0, 'L');
            if (self::$consulta["HistoriaClinica"]["expuesto_humo"] !== 'Fumador pasivo' && self::$consulta["HistoriaClinica"]["expuesto_humo"] !== 'No fumador') {
                $pdf->Cell(62, 4, utf8_decode("Número de años expuesto: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["anios_expuesto"]) && self::$consulta["HistoriaClinica"]["anios_expuesto"] !== null ? self::$consulta["HistoriaClinica"]["anios_expuesto"] : 'No refiere'), 1, 0, 'L');
                $pdf->Cell(62, 4, utf8_decode("Número de cigarrillos al día: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["fuma_cantidad"]) && self::$consulta["HistoriaClinica"]["fuma_cantidad"] !== null ? self::$consulta["HistoriaClinica"]["fuma_cantidad"] : 'No refiere'), 1, 0, 'L');
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->Cell(62, 4, utf8_decode("Número de años que fumo: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["fumamos"]) && self::$consulta["HistoriaClinica"]["fumamos"] !== null ? self::$consulta["HistoriaClinica"]["fumamos"] : 'No refiere'), 1, 0, 'L');
                $pdf->Cell(62, 4, utf8_decode("índice tabaquico: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["tabaquico"]) && self::$consulta["HistoriaClinica"]["tabaquico"] !== null ? self::$consulta["HistoriaClinica"]["tabaquico"] : 'No refiere'), 1, 0, 'L');
                $pdf->Cell(62, 4, utf8_decode("Riesgo EPOC: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["riesgo_epoc"]) && self::$consulta["HistoriaClinica"]["riesgo_epoc"] !== null ? self::$consulta["HistoriaClinica"]["riesgo_epoc"] : 'No refiere'), 1, 0, 'L');
            }
        } else {
            $pdf->SetX(12);
            $pdf->SetFont('arial', '', '9');
            $pdf->Cell(186, 4, 'No refiere', 1, 0, 'L');
        }
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->Cell(186, 4, utf8_decode('SUSTANCIAS PSICOACTIVAS'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->Cell(62, 4, utf8_decode("Frecuencia de exposicion: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["anios_expuesto_sustancias"]) && self::$consulta["HistoriaClinica"]["anios_expuesto_sustancias"] !== null ? self::$consulta["HistoriaClinica"]["anios_expuesto_sustancias"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Cell(62, 4, utf8_decode("Fecha inicio de consumo: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["consumo_psicoactivo"]) && self::$consulta["HistoriaClinica"]["consumo_psicoactivo"] !== null ? self::$consulta["HistoriaClinica"]["consumo_psicoactivo"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Cell(62, 4, utf8_decode("Cantidad consumo: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["psicoactivo_cantidad"]) && self::$consulta["HistoriaClinica"]["psicoactivo_cantidad"] !== null ? self::$consulta["HistoriaClinica"]["psicoactivo_cantidad"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->Cell(186, 4, utf8_decode('CONSUMO BEBIDAS ALCOHOLICAS'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->Cell(93, 4, utf8_decode("Cantidad de tragos: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["cantidad_licor"]) && self::$consulta["HistoriaClinica"]["cantidad_licor"] !== null ? self::$consulta["HistoriaClinica"]["cantidad_licor"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Cell(93, 4, utf8_decode("Frecuencia consumo de bebidas: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["licor_frecuencia"]) && self::$consulta["HistoriaClinica"]["licor_frecuencia"] !== null ? self::$consulta["HistoriaClinica"]["licor_frecuencia"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->Cell(186, 4, utf8_decode('OBSERVACIONES'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->MultiCell(186, 4, utf8_decode("Observaciones adicionales: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["estilo_vida_observaciones"]) && self::$consulta["HistoriaClinica"]["estilo_vida_observaciones"] !== null ? self::$consulta["HistoriaClinica"]["estilo_vida_observaciones"] : 'sin hallazgos'), 1, 0, 'L');
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
