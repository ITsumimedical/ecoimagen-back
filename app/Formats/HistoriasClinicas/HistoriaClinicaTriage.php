<?php

namespace App\Formats\HistoriasClinicas;

use App\Http\Modules\Historia\AntecedentesFamiliares\Models\AntecedenteFamiliare;
use App\Http\Modules\Historia\AntecedentesFarmacologicos\Models\AntecedentesFarmacologico;
use App\Http\Modules\Historia\AntecedentesHospitalarios\Models\AntecedentesHospitalario;
use App\Http\Modules\Historia\AntecedentesPersonales\Models\AntecedentePersonale;
use App\Http\Modules\Historia\AntecedentesQuirurgicos\Models\AntecedenteQuirurgico;
use App\Http\Modules\Historia\AntecedentesTransfusionales\Models\AntecedenteTransfusionale;
use App\Http\Modules\Historia\Vacunacion\Models\Vacuna;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Http\Modules\Historia\ResultadoLaboratorio\Models\ResultadoLaboratorio;
use App\Http\Modules\ResultadoAyudasDiagnosticos\Model\ResultadoAyudasDiagnosticas;


use Illuminate\Support\Facades\DB;

use DateTime;

class HistoriaClinicaTriage extends Fpdf
{
    protected static $consulta;

    public function bodyTriage($pdf, $consulta)
    {
        self::$consulta = $consulta;
        $y = $pdf->GetY();


        $pdf->SetXY(12, $y + 8);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('DATOS GENERALES'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->Cell(186, 4, utf8_decode('TRIAGE'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $triage = 'No Refiere';
        if (isset(self::$consulta["HistoriaClinica"])) {
            $triage = self::$consulta["HistoriaClinica"]["triage"] ?? 'No Refiere';
        }
        $pdf->MultiCell(186, 4, utf8_decode($triage), 1, "L", 0);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->Cell(186, 4, utf8_decode('REINGRESO'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $reingreso = 'No Refiere';
        if (isset(self::$consulta["HistoriaClinica"])) {
            $reingreso = self::$consulta["HistoriaClinica"]["reingreso"] ?? 'No Refiere';
        }
        $pdf->MultiCell(186, 4, utf8_decode($reingreso), 1, "L", 0);
        $pdf->Ln();

        // $pdf->SetX(12);
        // $pdf->SetFont('Arial', 'B', 8);
        // $reingreso = 'No Refiere';
        // if (isset(self::$consulta["HistoriaClinica"])) {
        //     $reingreso = self::$consulta["HistoriaClinica"]["reingreso"] ?? 'No Refiere';
        // }
        // $pdf->Cell(186,4, utf8_decode('Reingreso'), 0, 0, 'l');
        // $pdf->Ln();
        // $pdf->SetX(12);
        // $pdf->SetFont('Arial', '', 8);
        // $pdf->MultiCell(186, 4, utf8_decode($reingreso), 0, "L", 0);
        // $pdf->Ln();


        //Motivo de consulta
        $pdf->SetX(12);
        $pdf->Cell(186, 4, utf8_decode('MOTIVO DE CONSULTA'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();


        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $motivoConsulta = 'No Refiere';
        if (isset(self::$consulta["HistoriaClinica"])) {
            $motivoConsulta = self::$consulta["HistoriaClinica"]["motivo_consulta"] ?? 'No Refiere';
        }
        $pdf->MultiCell(186, 4, utf8_decode($motivoConsulta), 1, "L", 0);
        $pdf->Ln();

        // //Enfermedad actual
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

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('Motivo de ingreso'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $motivoIngreso = 'No especificado';
        if (isset(self::$consulta["HistoriaClinica"])) {
            $motivoIngreso = self::$consulta["HistoriaClinica"]["motivo_ingreso"] ?? 'No especificado';
        }
        $pdf->MultiCell(186, 4, utf8_decode($motivoIngreso), 1, "L", 0);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('Alergia'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $enfermedadActual = 'No especificado';
        if (isset(self::$consulta["HistoriaClinica"])) {
            $alergia = self::$consulta["HistoriaClinica"]["alergia"] ?? 'No especificado';
        }
        $pdf->MultiCell(186, 4, utf8_decode($alergia), 1, "L", 0);
        $pdf->Ln();

        if(self::$consulta['estado_triage']){
            $afiliadoId = self::$consulta->afiliado_id;
        $query = AntecedenteFamiliare::with('consulta.medicoOrdena.operador', 'cie10')
            ->whereHas('consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId);
            });

        // if (!$imprimirTodo) {
        //     $query->where('consulta_id', $consulta->id);
        // }
        $antecedentesFamiliares = $query->get();

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
            $pdf->Cell(186, 6, utf8_decode('No Refiere antecedentes familiares'), 1, 0, 'L');
            $pdf->Ln();
        } else {
            // Si hay antecedentes, imprimir detalles en formato tabla
            $contador = 1; // Inicializamos el contador
            foreach ($antecedentesFamiliares as $familiares) {
                if ($familiares->no_tiene_antecedentes) {
                    continue; // Si el antecedente tiene no_tiene_antecedentes como true, no se muestra
                }

                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(186, 6, utf8_decode('Registro ' . $contador), 1, 0, 'L', 1);
                $pdf->Ln();

                $pdf->SetFont('Arial', '', 8);

                // Fecha
                $fecha = utf8_decode((new DateTime($familiares->created_at))->format('Y-m-d'));
                $pdf->SetX(12);
                $pdf->MultiCell(186, 6, utf8_decode('FECHA: ' . $fecha), 1, 'L');

                // Médico que ordenó
                $nombreCompletoMedico = ($familiares->consulta && $familiares->consulta->medicoOrdena && $familiares->consulta->medicoOrdena->operador)
                    ? utf8_decode($familiares->consulta->medicoOrdena->operador->nombre . ' ' . $familiares->consulta->medicoOrdena->operador->apellido)
                    : utf8_decode('No Aplica');
                $pdf->SetX(12);
                $pdf->MultiCell(186, 6, utf8_decode('MÉDICO: ' . $nombreCompletoMedico), 1, 'L');

                // Parentesco
                $parentesco = !empty($familiares->parentesco)
                    ? utf8_decode($familiares->parentesco)
                    : utf8_decode('No especificado');
                $pdf->SetX(12);
                $pdf->MultiCell(186, 6, utf8_decode('PARENTESCO: ' . $parentesco), 1, 'L');

                // Fallecido
                $fallecio = utf8_decode(($familiares->fallecido == 1) ? 'Sí' : 'No');
                $pdf->SetX(12);
                $pdf->MultiCell(186, 6, utf8_decode('FALLECIDO: ' . $fallecio), 1, 'L');

                // Diagnóstico
                $diagnostico = $familiares->cie10
                    ? utf8_decode($familiares->cie10->nombre)
                    : utf8_decode('Diagnóstico no especificado');
                $pdf->SetX(12);
                $pdf->MultiCell(186, 6, utf8_decode('DIAGNÓSTICO: ' . $diagnostico), 1, 'L');

                $pdf->Ln(2);
                $contador++;
            }

            if ($antecedentesFamiliares->isEmpty()) {
                $pdf->SetX(12);
                $pdf->Cell(186, 6, utf8_decode('No refiere antecedentes familiares.'), 1, 0, 'L');
                $pdf->Ln();
            }
        }

        $afiliadoId = self::$consulta->afiliado_id;
        $antecedentesQuirurgicos = AntecedenteQuirurgico::with('consulta.medicoOrdena.operador')
            ->whereHas('consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId);
            })->get();

        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('ANTECEDENTES QUIRÚRGICOS'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 8);

        // Verificar si todos los antecedentes quirúrgicos indican "No refiere antecedentes quirúrgicos"
        $noTieneAntecedentesQuirurgicos = $antecedentesQuirurgicos->every(function ($quirurgico) {
            return $quirurgico->no_tiene_antecedente === 'No refiere antecedentes quirúrgicos';
        });

        if ($noTieneAntecedentesQuirurgicos) {
            // Si no hay antecedentes quirúrgicos, mostrar mensaje
            $pdf->SetX(12);
            $pdf->Cell(186, 6, utf8_decode('No refiere antecedentes quirúrgicos'), 1, 0, 'L');

            $pdf->Ln();
        } else {
            foreach ($antecedentesQuirurgicos as $quirurgico) {
                if ($quirurgico->no_tiene_antecedente === 'No refiere antecedentes quirúrgicos') {
                    continue; // Si el antecedente tiene no_tiene_antecedentes como true, no se muestra
                }

                $pdf->SetX(12);
                // $pdf->SetFont('Arial', 'B', 8);
                // $pdf->Cell(186, 4, utf8_decode('Registro ' . $contador), 1, 0, 'L', 1);
                // $pdf->Ln();

                $pdf->SetFont('Arial', '', 8);

                // Cirugía
                $cirugia = utf8_decode($quirurgico->cirugia ?? 'No especificada');
                $pdf->SetX(12);

                $pdf->MultiCell(186, 4, utf8_decode('CIRUGÍA: ' . $cirugia), 1, 'L');

                // Observaciones
                $observaciones = utf8_decode($quirurgico->observaciones ?? 'Sin observaciones');
                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode('OBSERVACIONES: ' . $observaciones), 1, 'L');

                // Edad
                $edad = utf8_decode($quirurgico->a_que_edad ? $quirurgico->a_que_edad . ' años' : 'No especificada');

                // Médico que ordenó
                $nombreCompletoMedico = ($quirurgico->consulta && $quirurgico->consulta->medicoOrdena && $quirurgico->consulta->medicoOrdena->operador)
                    ? utf8_decode($quirurgico->consulta->medicoOrdena->operador->nombre . ' ' . $quirurgico->consulta->medicoOrdena->operador->apellido)
                    : utf8_decode('No Aplica');

                $detalleQuirurgico = utf8_decode('EDAD: ' . $edad . ' | REGISTRADO POR: ' . utf8_decode($nombreCompletoMedico));

                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, $detalleQuirurgico, 1, 'L');


                $pdf->Ln(2);
            }

            if ($antecedentesQuirurgicos->isEmpty()) {
                $pdf->SetX(12);
                $pdf->Cell(186, 4, utf8_decode('No refiere antecedentes quirúrgicos.'), 1, 0, 'L');
                $pdf->Ln();
            }
        }

        $pdf->Ln();
        }


        $pdf->Ln();


        $afiliadoId = self::$consulta->afiliado_id;
        $query = AntecedentePersonale::with('consulta.medicoOrdena.operador')
            ->whereHas('consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId);
            });

        // if (!$imprimirTodo) {
        //     $query->where('consulta_id', $consulta->id);
        // }
        $antecedentes = $query->get();

        // Imprimir antecedentes personales
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 6, utf8_decode('ANTECEDENTES PERSONALES'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 8);

        if ($antecedentes->isEmpty()) {
            $pdf->SetX(12);
            $pdf->Cell(186, 6, utf8_decode('No refiere antecedentes personales.'), 1, 0, 'L');
            $pdf->Ln();
        } else {
            $contador = 1; // Inicializamos el contador
            foreach ($antecedentes as $antecedente) {
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(186, 6, utf8_decode('Registro ' . $contador), 1, 0, 'L', 1);
                $pdf->Ln();

                $pdf->SetFont('Arial', '', 8);

                // Patología
                $patologia = !empty($antecedente->patologias)
                    ? utf8_decode($antecedente->patologias)
                    : utf8_decode('No Aplica');
                $pdf->SetX(12);
                $pdf->MultiCell(186, 6, utf8_decode('PATOLOGÍA: ' . $patologia), 1, 'L');

                // Fecha de diagnóstico
                $fechaDiagnostico = !empty($antecedente->fecha_diagnostico)
                    ? utf8_decode(substr($antecedente->fecha_diagnostico, 0, 10))
                    : utf8_decode('No Aplica');
                $pdf->SetX(12);
                $pdf->MultiCell(186, 6, utf8_decode('FECHA DIAGNÓSTICO: ' . $fechaDiagnostico), 1, 'L');


                // Médico ordena (nombre completo)
                $nombreCompletoMedico = ($antecedente->consulta && $antecedente->consulta->medicoOrdena && $antecedente->consulta->medicoOrdena->operador)
                    ? utf8_decode($antecedente->consulta->medicoOrdena->operador->nombre . ' ' . $antecedente->consulta->medicoOrdena->operador->apellido)
                    : utf8_decode('No Aplica');
                $pdf->SetX(12);
                $pdf->MultiCell(186, 6, utf8_decode('REGISTRADO POR: ' . $nombreCompletoMedico), 1, 'L');

                $pdf->Ln(2);

                $contador++;
            }
        }
        $pdf->Ln();

        if(self::$consulta['estado_triage']){
            $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetX(12);
        $pdf->Cell(186, 4, utf8_decode('REVISIÓN POR SISTEMAS'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $revisionSistemas = 'No Refiere';
        if (isset(self::$consulta["HistoriaClinica"])) {
            $descripcion = self::$consulta["HistoriaClinica"]["descripcion_revision_sistemas"] ?? 'No Refiere';
            $revisionSistemas = "Descripción: " . $descripcion;
        }
        $pdf->MultiCell(186, 4, utf8_decode($revisionSistemas), 1, "L", 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $sintomaticoRespiratorio = 'No Refiere';

        if (isset(self::$consulta["HistoriaClinica"])) {
            $resultado = self::$consulta["HistoriaClinica"]["sintomatico_respiratorio"] ?? null;
            // Verificamos si el resultado es true o false
            if (is_bool($resultado)) {
                $descripcion = $resultado ? 'Sí' : 'No';
            } else {
                $descripcion = 'No Refiere';
            }
            $sintomaticoRespiratorio = "Sintomatico Respiratorio: " . $descripcion;
        }
        $pdf->MultiCell(186, 4, utf8_decode($sintomaticoRespiratorio), 1, "L", 0);

        //Se imprime el resultado sintomatico de piel
        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $sintomaticoPiel = 'No Refiere';
        if (isset(self::$consulta["HistoriaClinica"])) {
            $resultado = self::$consulta["HistoriaClinica"]["sintomatico_piel"] ?? null;
            // Verificamos si el resultado es true o false
            if (is_bool($resultado)) {
                $descripcion = $resultado ? 'Sí' : 'No';
            } else {
                $descripcion = 'No Refiere';
            }
            $sintomaticoPiel = "Sintomatico de piel: " . $descripcion;
        }
        $pdf->MultiCell(186, 4, utf8_decode($sintomaticoPiel), 1, "L", 0);
        $pdf->Ln();
        }


        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('EXAMEN FISICO'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "Aspecto General: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["aspecto_general"]) && self::$consulta["HistoriaClinica"]["aspecto_general"] !== null ? self::$consulta["HistoriaClinica"]["aspecto_general"] : (self::$consulta["HistoriaClinica"]["condicion_general"] !== null ? self::$consulta["HistoriaClinica"]["condicion_general"] : 'sin hallazgos')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);
        if (self::$consulta["afiliado"]["edad_cumplida"] >= 3) {
            $pdf->Cell(58, 4, utf8_decode(
                isset(self::$consulta["HistoriaClinica"]["presion_sistolica"]) && self::$consulta["HistoriaClinica"]["presion_sistolica"] !== null
                    ? "Presión sistólica: " . self::$consulta["HistoriaClinica"]["presion_sistolica"] . "milimetros de mercurio"
                    : "Presión sistólica: No Aplica"
            ), 1, 0, 'L', 0);

            $pdf->Cell(59, 4, utf8_decode(
                isset(self::$consulta["HistoriaClinica"]["presion_diastolica"]) && self::$consulta["HistoriaClinica"]["presion_diastolica"] !== null
                    ? "Presión Diastólica: " . self::$consulta["HistoriaClinica"]["presion_diastolica"] . " milimetros de mercurio"
                    : "Presión Diastólica: No Aplica"
            ), 1, 0, 'L', 0);

            $pdf->Cell(69, 4, utf8_decode(
                isset(self::$consulta["HistoriaClinica"]["presion_arterial_media"]) && self::$consulta["HistoriaClinica"]["presion_arterial_media"] !== null
                    ? "Presión arterial media: " . self::$consulta["HistoriaClinica"]["presion_arterial_media"] . " milimetros de mercurio"
                    : "Presión arterial media: No Aplica"
            ), 1, 0, 'L', 0);
        }

        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(58, 4, utf8_decode(
            isset(self::$consulta["HistoriaClinica"]["frecuencia_cardiaca"]) && self::$consulta["HistoriaClinica"]["frecuencia_cardiaca"] !== null
                ? "Frecuencia cardiaca: " . self::$consulta["HistoriaClinica"]["frecuencia_cardiaca"] . " latidos por minuto"
                : "Frecuencia cardiaca: No Aplica"
        ), 1, 0, 'L', 0);

        $pdf->Cell(59, 4, utf8_decode(
            isset(self::$consulta["HistoriaClinica"]["pulsos"]) && self::$consulta["HistoriaClinica"]["pulsos"] !== null
                ? "Pulsos: " . self::$consulta["HistoriaClinica"]["pulsos"] . " Pulsaciones por minuto"
                : "Pulsos:" . (self::$consulta["HistoriaClinica"]["frecuencia_cardiaca"]) . " Pulsaciones por minuto"
        ), 1, 0, 'L', 0);

        $pdf->Cell(69, 4, utf8_decode(
            isset(self::$consulta["HistoriaClinica"]["frecuencia_respiratoria"]) && self::$consulta["HistoriaClinica"]["frecuencia_respiratoria"] !== null
                ? "Frecuencia Respiratoria: " . self::$consulta["HistoriaClinica"]["frecuencia_respiratoria"] . " respiraciones por minuto"
                : "Frecuencia Respiratoria: No Aplica"
        ), 1, 0, 'L', 0);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(62, 4, utf8_decode(
            isset(self::$consulta["HistoriaClinica"]["temperatura"]) && self::$consulta["HistoriaClinica"]["temperatura"] !== null
                ? "Temperatura: " . self::$consulta["HistoriaClinica"]["temperatura"] . " °C"
                : "Temperatura: No Aplica"
        ), 1, 0, 'L', 0);
        $pdf->Cell(62, 4, utf8_decode(
            isset(self::$consulta["HistoriaClinica"]["saturacion_oxigeno"]) && self::$consulta["HistoriaClinica"]["saturacion_oxigeno"] !== null
                ? "Saturación de oxígeno: " . self::$consulta["HistoriaClinica"]["saturacion_oxigeno"] . " %"
                : "Saturación de oxígeno: No Aplica"
        ), 1, 0, 'L', 0);
        $pdf->Cell(62, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["fio"]) && self::$consulta["HistoriaClinica"]["fio"] !== null ? "Fracción inspiratoria de oxígeno: " . self::$consulta["HistoriaClinica"]["fio"] : "Fracción inspiratoria de oxígeno: 0.21"), 1, 0, 'L', 0);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(45, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["peso"]) && self::$consulta["HistoriaClinica"]["peso"] !== null ? "Peso: " . self::$consulta["HistoriaClinica"]["peso"] . " Kilogramos" : "Peso: 0"), 1, 0, 'L', 0);
        $pdf->Cell(45, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["talla"]) && self::$consulta["HistoriaClinica"]["talla"] !== null ? "Talla: " . self::$consulta["HistoriaClinica"]["talla"] . " Centímetros" : "Talla: 0"), 1, 0, 'L', 0);
        $pdf->Cell(27, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["imc"]) && self::$consulta["HistoriaClinica"]["imc"] !== null ? "IMC: " . self::$consulta["HistoriaClinica"]["imc"] : "IMC: No Evaluado"), 1, 0, 'L', 0);
        $pdf->Cell(69, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["isc"]) && self::$consulta["HistoriaClinica"]["isc"] !== null ? "Índice de superficie corporal: " . self::$consulta["HistoriaClinica"]["isc"] : "Índice de superficie corporal: No Evaluado"), 1, 0, 'L', 0);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "Cabeza y cuello: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["cabeza_cuello"]) && self::$consulta["HistoriaClinica"]["cabeza_cuello"] !== null ? self::$consulta["HistoriaClinica"]["cabeza_cuello"] : 'sin hallazgos'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $abdomenExamen = self::$consulta["HistoriaClinica"]["abdomen_examen"] ?? null;
        $abdomen = self::$consulta["HistoriaClinica"]["abdomen"] ?? null;
        $abdomenTexto = $abdomenExamen !== null ? $abdomenExamen : ($abdomen !== null ? $abdomen : 'sin hallazgos');
        $pdf->MultiCell(186, 4, "Abdomen: " . utf8_decode($abdomenTexto), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "Cardiorrespiratorio: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["examen_cardiorespiratorio"]) && self::$consulta["HistoriaClinica"]["examen_cardiorespiratorio"] !== null ? self::$consulta["HistoriaClinica"]["examen_cardiorespiratorio"] : 'sin hallazgos'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "Genitales: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["examen_genitales"]) && self::$consulta["HistoriaClinica"]["examen_genitales"] !== null ? self::$consulta["HistoriaClinica"]["examen_genitales"] : 'sin hallazgos'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "Extremidades: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["examen_extremidades"]) && self::$consulta["HistoriaClinica"]["examen_extremidades"] !== null ? self::$consulta["HistoriaClinica"]["examen_extremidades"] : 'sin hallazgos'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "Piel y anexos: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["piel_anexos"]) && self::$consulta["HistoriaClinica"]["piel_anexos"] !== null ? self::$consulta["HistoriaClinica"]["piel_anexos"] : 'sin hallazgos'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "Neurologico: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["neurologico"]) && self::$consulta["HistoriaClinica"]["neurologico"] !== null ? self::$consulta["HistoriaClinica"]["neurologico"] : 'sin hallazgos'), 1, 'L', 0);

        $pdf->Ln();

        if(self::$consulta['estado_triage']){
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
        $pdf->Cell(186, 4, utf8_decode("Analisis:"), 0, 0, 'L', 0);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);

        $analisis = isset(self::$consulta["HistoriaClinica"]["analisis"]) ? self::$consulta["HistoriaClinica"]["analisis"] : 'No Aplica';
        $pdf->SetX(12);
        $pdf->MultiCell(186, 4, utf8_decode($analisis), 0, 'L');
        $pdf->Line(12, $pdf->GetY(), 198, $pdf->GetY());
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
}
