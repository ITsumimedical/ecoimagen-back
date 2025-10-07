<?php

namespace App\Formats\HistoriasClinicas;

use App\Http\Modules\Historia\AntecedentesFarmacologicos\Models\AntecedentesFarmacologico;
use App\Http\Modules\RemisionProgramas\Model\RemisionProgramas;
use Codedge\Fpdf\Facades\Fpdf;
use Illuminate\Support\Facades\DB;

class HistoriaClinicaAplicacionQuimioterapia extends Fpdf
{
    protected static $consulta;
    public function bodyAplicacionQuimioterapia($pdf, $consulta)
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


        // Antecedentes Farmacologicos
        $afiliadoId = self::$consulta->afiliado_id;

        $consultarFarmacologicos = AntecedentesFarmacologico::whereHas('consulta', function ($query) use ($afiliadoId) {
            $query->where('afiliado_id', $afiliadoId);
        })
            ->whereNotNull('principio_activo_id')
            ->get();

        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('ANTECEDENTES ALÉRGICOS A MEDICAMENTOS'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 8);

        // Verificar si todos los antecedentes farmacológicos indican "No refiere antecedentes"
        if (isset(self::$consulta->antecedentesFarmacologicos)) {

            foreach ($consultarFarmacologicos as $farmacologico) {
                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $nombreMedicamento = utf8_decode($farmacologico->principioActivo->nombre ?? 'No refiere');
                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode('MEDICAMENTOS: ' . $nombreMedicamento), 1, 'L');
                $observacion = utf8_decode($farmacologico->observacion_medicamento ?? 'N/A');
                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode('OBSERVACIONES: ' . $observacion), 1, 'L');
                $fecha = utf8_decode($farmacologico->created_at->format('d/m/Y') ?? 'No especificada');

                $medico = utf8_decode($farmacologico->user->operador->nombre_completo ?? 'No refiere');

                $detalleFarmacologico = utf8_decode('FECHA: ' . $fecha . ' | REGISTRADO POR: ' . utf8_decode($medico));

                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, $detalleFarmacologico, 1, 'L');

                $pdf->Ln(2);
            }
        } else {
            $pdf->SetX(12);
            $pdf->Cell(186, 4, utf8_decode('No tiene antecedentes alérgicos a medicamentos'), 1, 0, 'L');
            $pdf->Ln();
        }

        $pdf->Ln();

        if (!in_array(self::$consulta["especialidad_id"], [43, 45])) {
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('MEDIDAS ANTROPOMETRICAS'), 1, 0, 'C', 1);
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
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(62, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["clasificacion"]) && self::$consulta["HistoriaClinica"]["clasificacion"] !== null ? "Clasificación: " . self::$consulta["HistoriaClinica"]["clasificacion"] : "Clasificación: No Evaluado"), 1, 0, 'L', 0);
            $pdf->Cell(62, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["perimetro_abdominal"]) && self::$consulta["HistoriaClinica"]["perimetro_abdominal"] !== null ? "Perímetro abdominal: " . self::$consulta["HistoriaClinica"]["perimetro_abdominal"] . " Centímetros" : "Perímetro abdominal: No Evaluado"), 1, 0, 'L', 0);
            $pdf->Ln();

            if (self::$consulta["afiliado"]["ciclo_vida_atencion"] === "Primera Infancia (0-5 Años)") {
                $pdf->Cell(62, 4, utf8_decode('Perimetro Cefálico:' . (isset(self::$consulta["HistoriaClinica"]["perimetro_cefalico"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["perimetro_cefalico"]) : 'No Evaluado')), 1);

                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->Cell(186, 4, utf8_decode("Peso para la talla: " .
                    (isset(self::$consulta["HistoriaClinica"]["peso_talla"]) && self::$consulta["HistoriaClinica"]["peso_talla"] !== null
                        ? self::$consulta["HistoriaClinica"]["peso_talla"]
                        : "No refiere")), 1, 0, 'L', 0);
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->Cell(186, 4, utf8_decode("Clasificación peso para la talla: " .
                    (isset(self::$consulta["HistoriaClinica"]["clasificacion_peso_talla"]) && self::$consulta["HistoriaClinica"]["clasificacion_peso_talla"] !== null
                        ? self::$consulta["HistoriaClinica"]["clasificacion_peso_talla"]
                        : "No refiere")), 1, 0, 'L', 0);
                $pdf->Ln();

                $pdf->SetX(12);
                $pdf->Cell(186, 4, utf8_decode("Perímetro cefálico para la edad:  " .
                    (isset(self::$consulta["HistoriaClinica"]["clasificacion_cefalico_edad"]) && self::$consulta["HistoriaClinica"]["clasificacion_cefalico_edad"] !== null
                        ? self::$consulta["HistoriaClinica"]["clasificacion_cefalico_edad"]
                        : "No refiere")), 1, 0, 'L', 0);
                $pdf->Ln();


                $pdf->SetX(12);
                $pdf->Cell(186, 4, utf8_decode("Clasificación perímetro cefálico para la edad:  " .
                    (isset(self::$consulta["HistoriaClinica"]["cefalico_edad"]) && self::$consulta["HistoriaClinica"]["cefalico_edad"] !== null
                        ? self::$consulta["HistoriaClinica"]["cefalico_edad"]
                        : "No refiere")), 1, 0, 'L', 0);
                $pdf->Ln();


                $pdf->SetX(12);
                $pdf->Cell(186, 4, utf8_decode("Peso para la edad: " .
                    (isset(self::$consulta["HistoriaClinica"]["peso_edad"]) && self::$consulta["HistoriaClinica"]["peso_edad"] !== null
                        ? self::$consulta["HistoriaClinica"]["peso_edad"]
                        : "No refiere")), 1, 0, 'L', 0);
                $pdf->Ln();

                $pdf->SetX(12);
                $pdf->Cell(186, 4, utf8_decode("Clasificación peso para la edad: " .
                    (isset(self::$consulta["HistoriaClinica"]["clasificacion_peso_edad"]) && self::$consulta["HistoriaClinica"]["clasificacion_peso_edad"] !== null
                        ? self::$consulta["HistoriaClinica"]["clasificacion_peso_edad"]
                        : "No refiere")), 1, 0, 'L', 0);
                $pdf->Ln();
            }

            if (
                self::$consulta["afiliado"]["ciclo_vida_atencion"] === "Primera Infancia (0-5 Años)" ||
                self::$consulta["afiliado"]["ciclo_vida_atencion"] === "Infancia (6-11 Años)" ||
                self::$consulta["afiliado"]["ciclo_vida_atencion"] === "Adolescencia (12 A 17 Años)"
            ) {
                $pdf->SetX(12);
                $pdf->Cell(186, 4, utf8_decode("Clasificación talla para la edad: " .
                    (isset(self::$consulta["HistoriaClinica"]["clasificacion_talla_edad"]) && self::$consulta["HistoriaClinica"]["clasificacion_talla_edad"] !== null
                        ? self::$consulta["HistoriaClinica"]["clasificacion_talla_edad"]
                        : "No refiere")), 1, 0, 'L', 0);
                $pdf->Ln();

                $pdf->SetX(12);
                $pdf->Cell(186, 4, utf8_decode("IMC para la edad: " .
                    (isset(self::$consulta["HistoriaClinica"]["imc_edad"]) && self::$consulta["HistoriaClinica"]["imc_edad"] !== null
                        ? self::$consulta["HistoriaClinica"]["imc_edad"]
                        : "No refiere")), 1, 0, 'L', 0);
                $pdf->Ln();

                $pdf->SetX(12);
                $pdf->Cell(186, 4, utf8_decode("Clasificación IMC para la edad: " .
                    (isset(self::$consulta["HistoriaClinica"]["clasificacion_imc_edad"]) && self::$consulta["HistoriaClinica"]["clasificacion_imc_edad"] !== null
                        ? self::$consulta["HistoriaClinica"]["clasificacion_imc_edad"]
                        : "No refiere")), 1, 0, 'L', 0);
                $pdf->Ln();
            }

            if (
                self::$consulta["afiliado"]["ciclo_vida_atencion"] === "Primera Infancia (0-5 Años)" ||
                self::$consulta["afiliado"]["ciclo_vida_atencion"] === "Infancia (6-11 Años)" ||
                self::$consulta["afiliado"]["ciclo_vida_atencion"] === "Vejez (Mayor a 60 Años)"
            ) {
                $pdf->SetX(12);
                $pdf->Cell(186, 4, utf8_decode("Circunferencia brazo: " .
                    (isset(self::$consulta["HistoriaClinica"]["circunferencia_brazo"]) && self::$consulta["HistoriaClinica"]["circunferencia_brazo"] !== null
                        ? self::$consulta["HistoriaClinica"]["circunferencia_brazo"] . " centímetros"
                        : "No refiere")), 1, 0, 'L', 0);
                $pdf->Ln();
            }
        }
        $pdf->Ln();

        if (!in_array(self::$consulta["especialidad_id"], [42, 43, 44, 45])) {
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('SIGNOS VITALES'), 1, 0, 'C', 1);
            $pdf->Ln();

            $pdf->SetX(12);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFont('Arial', '', 8);
            if (self::$consulta["afiliado"]["edad_cumplida"] >= 3) {
                $pdf->Cell(58, 4, utf8_decode(
                    isset(self::$consulta["HistoriaClinica"]["presion_sistolica"]) && self::$consulta["HistoriaClinica"]["presion_sistolica"] !== null
                        ? "Presión sistólica: " . self::$consulta["HistoriaClinica"]["presion_sistolica"] . " milimetros de mercurio"
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
                    : "Pulsos: " . (self::$consulta["HistoriaClinica"]["frecuencia_cardiaca"]) . " Pulsaciones por minuto"
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
                    : "Temperatura: No evaluado"
            ), 1, 0, 'L', 0);
            $pdf->Cell(62, 4, utf8_decode(
                isset(self::$consulta["HistoriaClinica"]["saturacion_oxigeno"]) && self::$consulta["HistoriaClinica"]["saturacion_oxigeno"] !== null
                    ? "Saturación de oxígeno: " . self::$consulta["HistoriaClinica"]["saturacion_oxigeno"] . " %"
                    : "Saturación de oxígeno: No Aplica"
            ), 1, 0, 'L', 0);
            $pdf->Cell(62, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["fio"]) && self::$consulta["HistoriaClinica"]["fio"] !== null ? "Fracción inspiratoria de oxígeno: " . self::$consulta["HistoriaClinica"]["fio"] : "Fracción inspiratoria de oxígeno: 0.21"), 1, 0, 'L', 0);
            $pdf->Ln();
            $pdf->Ln();
        }


        if (self::$consulta["especialidad_id"] !== 43) {
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('EXAMEN FÍSICO'), 1, 0, 'C', 1);
            $pdf->Ln();

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 9);
            $pdf->MultiCell(186, 4, "Aspecto General: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["aspecto_general"]) && self::$consulta["HistoriaClinica"]["aspecto_general"] !== null ? self::$consulta["HistoriaClinica"]["aspecto_general"] : (self::$consulta["HistoriaClinica"]["condicion_general"] !== null ? self::$consulta["HistoriaClinica"]["condicion_general"] : 'sin hallazgos')), 1, 'L', 0);

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

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 9);
            $pdf->MultiCell(186, 4, "Agudeza Visual ojo Izquierdo: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["agudeza_visual_ojo_izquierdo"]) && self::$consulta["HistoriaClinica"]["agudeza_visual_ojo_izquierdo"] !== null ? self::$consulta["HistoriaClinica"]["agudeza_visual_ojo_izquierdo"] : 'sin hallazgos'), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 9);
            $pdf->MultiCell(186, 4, "Agudeza Visual ojo Derecho: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["agudeza_visual_ojo_derecho"]) && self::$consulta["HistoriaClinica"]["agudeza_visual_ojo_derecho"] !== null ? self::$consulta["HistoriaClinica"]["agudeza_visual_ojo_derecho"] : 'sin hallazgos'), 1, 'L', 0);


            $pdf->Ln();
        }

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
