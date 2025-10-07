<?php

namespace App\Formats\HistoriasClinicas;

use App\Http\Modules\Historia\AntecedentesFarmacologicos\Models\AntecedentesFarmacologico;
use App\Http\Modules\RemisionProgramas\Model\RemisionProgramas;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Facades\DB;
use DateTime;

class HistoriaClinicaFarmacologia extends Fpdf
{
    protected static $consulta;

    public function bodyFarmacologia($pdf, $consulta)
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
        $motivoConsulta = 'No Refiere';
        if (isset(self::$consulta["HistoriaClinica"])) {
            $motivoConsulta = self::$consulta["HistoriaClinica"]["motivo_consulta"] ?? 'No Refiere';
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

        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('MEDIDAS ANTROPOMETICAS'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(23, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["peso"]) && self::$consulta["HistoriaClinica"]["peso"] !== null ? "Peso: " . self::$consulta["HistoriaClinica"]["peso"] . " kg" : "Peso: 0"), 1, 0, 'L', 0);
        $pdf->Cell(23, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["talla"]) && self::$consulta["HistoriaClinica"]["talla"] !== null ? "Talla: " . self::$consulta["HistoriaClinica"]["talla"] . " CM" : "Talla: 0"), 1, 0, 'L', 0);
        $pdf->Cell(70, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["imc"]) && self::$consulta["HistoriaClinica"]["imc"] !== null ? "Índice de masa corporal: " . self::$consulta["HistoriaClinica"]["imc"] : "Índice de masa corporal: No Evaluado"), 1, 0, 'L', 0);
        $pdf->Cell(70, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["isc"]) && self::$consulta["HistoriaClinica"]["isc"] !== null ? "Índice de superficie corporal: " . self::$consulta["HistoriaClinica"]["isc"] : "Índice de superficie corporal: No Evaluado"), 1, 0, 'L', 0);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(62, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["clasificacion"]) && self::$consulta["HistoriaClinica"]["clasificacion"] !== null ? "Clasificación: " . self::$consulta["HistoriaClinica"]["clasificacion"] : "Clasificación: No Evaluado"), 1, 0, 'L', 0);
        $pdf->Cell(62, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["perimetro_abdominal"]) && self::$consulta["HistoriaClinica"]["perimetro_abdominal"] !== null ? "Perímetro abdominal: " . self::$consulta["HistoriaClinica"]["perimetro_abdominal"] : "Perímetro abdominal: No Evaluado"), 1, 0, 'L', 0);
        $pdf->Ln();


        if (self::$consulta["ciclo_vida_atencion"] == '1ra Infancia') {
            $pdf->SetX(12);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(93, 4, utf8_decode(self::$consulta["HistoriaClinica"]["peso_talla"] == null ? "Peso para la talla: " . 'No Evaluado' : "Peso para la talla: " . self::$consulta["HistoriaClinica"]["peso_talla"]), 1, 0, 'l', 0);
            $pdf->Cell(93, 4, utf8_decode(self::$consulta["HistoriaClinica"]["clasificacion_peso_talla"] == null ? "Clasificación peso para la talla: " . 'No Evaluado' : "Clasificación peso para la talla: " . self::$consulta["HistoriaClinica"]["clasificacion_peso_talla"]), 1, 0, 'l', 0);
            $pdf->Ln();

            $pdf->SetX(12);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(93, 4, utf8_decode(self::$consulta["HistoriaClinica"]["cefalico_edad"] == null ? "Perímetro cefálico para la edad: " . 'No Evaluado' : "Perímetro cefálico para la edad: " . self::$consulta["HistoriaClinica"]["cefalico_edad"]), 1, 0, 'l', 0);
            $pdf->Cell(93, 4, utf8_decode(self::$consulta["HistoriaClincia"]["clasificacion_cefalico_edad"] == null ? "Clasificación perímetro cefálico para la edad: " . 'No Evaluado' : "Clasificación perímetro cefálico para la edad: " . self::$consulta["HistoriaClinica"]["clasificacion_cefalico_edad"]), 1, 0, 'l', 0);
            $pdf->Ln();

            $pdf->SetX(12);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(93, 4, utf8_decode(self::$consulta["HistoriaClinica"]["imc_edad"] == null ? "IMC para la edad: " . 'No Evaluado' : "IMC para la edad: " . self::$consulta["HistoriaClinica"]["imc_edad"]), 1, 0, 'l', 0);
            $pdf->Cell(93, 4, utf8_decode(self::$consulta["HistoriaClinica"]["clasificacion_imc_edad"] == null ? "Clasificación IMC para la edad: " . 'No Evaluado' : "Clasificación IMC para la edad: " . self::$consulta["HistoriaClinica"]["clasificacion_imc_edad"]), 1, 0, 'l', 0);
            $pdf->Ln();

            $pdf->SetX(12);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(93, 4, utf8_decode(self::$consulta["HistoriaClinica"]["peso_edad"] == null ? "Peso para la edad: " . 'No Evaluado' : "Peso para la edad: " . self::$consulta["HistoriaClinica"]["peso_edad"]), 1, 0, 'l', 0);
            $pdf->Cell(93, 4, utf8_decode(self::$consulta["clasificacion_peso_edad"] == null ? "Clasificación peso para la edad: " . 'No Evaluado' : "Clasificación peso para la edad: " . self::$consulta["clasificacion_peso_edad"]), 1, 0, 'l', 0);
            $pdf->Ln();
        }

        if (self::$consulta["ciclo_vida_atencion"] == '1ra Infancia' || self::$consulta["ciclo_vida_atencion"] == 'Infancia' || self::$consulta["ciclo_vida_atencion"] == 'Adolescencia') {
            $pdf->SetX(12);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(93, 4, utf8_decode(self::$consulta["HistoriaClinica"]["talla_edad"] == null ? "Talla para la edad: " . 'No Evaluado' : "Talla para la edad: " . self::$consulta["HistoriaClinica"]["talla_edad"]), 1, 0, 'l', 0);
            $pdf->Cell(93, 4, utf8_decode(self::$consulta["HistoriaClinica"]["clasificacion_talla_edad"] == null ? "Clasificación talla para la edad: " . 'No Evaluado' : "Clasificación talla para la edad: " . self::$consulta["HistoriaClinica"]["clasificacion_talla_edad"]), 1, 0, 'l', 0);
            $pdf->Ln();
        }

        if (self::$consulta["ciclo_vida_atencion"] == '1ra Infancia' || self::$consulta["ciclo_vida_atencion"] == 'Infancia' || self::$consulta["ciclo_vida_atencion"] == 'Vejez') {
            $pdf->SetX(12);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(93, 4, utf8_decode(self::$consulta["HistoriaClinica"]["circunferencia_brazo"] == null ? "Circunferencia brazo: " . 'No Evaluado' : "Circunferencia brazo: " . self::$consulta["HistoriaClinica"]["circunferencia_brazo"]), 1, 0, 'l', 0);
            $pdf->Cell(93, 4, utf8_decode(self::$consulta["HistoriaClinica"]["circunferencia_pantorrilla"] == null ? "Circunferencia pantorrilla: " . 'No Evaluado' : "Circunferencia pantorrilla: " . self::$consulta["HistoriaClinica"]["circunferencia_pantorrilla"]), 1, 0, 'l', 0);
            $pdf->Ln();
        }

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
        $pdf->Cell(62, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["presion_sistolica"]) && self::$consulta["HistoriaClinica"]["presion_sistolica"] !== null ? "Presión sistólica: " . self::$consulta["HistoriaClinica"]["presion_sistolica"] : "Presión sistólica: No Evaluado"), 1, 0, 'L', 0);
        $pdf->Cell(62, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["presion_diastolica"]) && self::$consulta["HistoriaClinica"]["presion_diastolica"] !== null ? "Presión Diastólica: " . self::$consulta["HistoriaClinica"]["presion_diastolica"] : "Presión Diastólica: No Evaluado"), 1, 0, 'L', 0);
        $pdf->Cell(62, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["presion_arterial_media"]) && self::$consulta["HistoriaClinica"]["presion_arterial_media"] !== null ? "Presión arterial media: " . self::$consulta["HistoriaClinica"]["presion_arterial_media"] : "Presión arterial media: No Evaluado"), 1, 0, 'L', 0);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(62, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["frecuencia_cardiaca"]) && self::$consulta["HistoriaClinica"]["frecuencia_cardiaca"] !== null ? "Frecuencia cardiaca: " . self::$consulta["HistoriaClinica"]["frecuencia_cardiaca"] : "Frecuencia cardiaca: No Evaluado"), 1, 0, 'L', 0);
        $pdf->Cell(62, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["pulsos"]) && self::$consulta["HistoriaClinica"]["pulsos"] !== null ? "Pulsos: " . self::$consulta["HistoriaClinica"]["pulsos"] : "Pulsos: No Evaluado"), 1, 0, 'L', 0);
        $pdf->Cell(62, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["frecuencia_respiratoria"]) && self::$consulta["HistoriaClinica"]["frecuencia_respiratoria"] !== null ? "Frecuencia Respiratoria: " . self::$consulta["HistoriaClinica"]["frecuencia_respiratoria"] : "Frecuencia Respiratoria: No Evaluado"), 1, 0, 'L', 0);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(62, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["temperatura"]) && self::$consulta["HistoriaClinica"]["temperatura"] !== null ? "Temperatura: " . self::$consulta["HistoriaClinica"]["temperatura"] : "Temperatura: No Evaluado"), 1, 0, 'L', 0);
        $pdf->Cell(62, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["saturacion_oxigeno"]) && self::$consulta["HistoriaClinica"]["saturacion_oxigeno"] !== null ? "Saturación de oxígeno: " . self::$consulta["HistoriaClinica"]["saturacion_oxigeno"] : "Saturación de oxígeno: No Evaluado"), 1, 0, 'L', 0);
        $pdf->Cell(62, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["fio"]) && self::$consulta["HistoriaClinica"]["fio"] !== null ? "Fracción inspiratoria de oxígeno: " . self::$consulta["HistoriaClinica"]["fio"] : "Fracción inspiratoria de oxígeno: No Evaluado"), 1, 0, 'L', 0);
        $pdf->Ln();
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('EXAMEN FÍSICO'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "Aspecto General: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["aspecto_general"]) && self::$consulta["HistoriaClinica"]["aspecto_general"] !== null ? self::$consulta["HistoriaClinica"]["aspecto_general"] : (self::$consulta["HistoriaClinica"]["condicion_general"] !== null ? self::$consulta["HistoriaClinica"]["condicion_general"] : 'No Evaluado')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "Cabeza y cuello: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["cabeza_cuello"]) && self::$consulta["HistoriaClinica"]["cabeza_cuello"] !== null ? self::$consulta["HistoriaClinica"]["cabeza_cuello"] : 'No Evaluado'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "Abdomen: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["abdomen"]) && self::$consulta["HistoriaClinica"]["abdomen"] !== null ? self::$consulta["HistoriaClinica"]["abdomen"] : 'No Evaluado'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "Examen Cardiorespiratorio: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["examen_cardiorespiratorio"]) && self::$consulta["HistoriaClinica"]["examen_cardiorespiratorio"] !== null ? self::$consulta["HistoriaClinica"]["examen_cardiorespiratorio"] : 'No Evaluado'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "Genitales: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["examen_genitales"]) && self::$consulta["HistoriaClinica"]["examen_genitales"] !== null ? self::$consulta["HistoriaClinica"]["examen_genitales"] : 'No Evaluado'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "Extremidades: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["examen_extremidades"]) && self::$consulta["HistoriaClinica"]["examen_extremidades"] !== null ? self::$consulta["HistoriaClinica"]["examen_extremidades"] : 'No Evaluado'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "Piel y anexos: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["piel_anexos"]) && self::$consulta["HistoriaClinica"]["piel_anexos"] !== null ? self::$consulta["HistoriaClinica"]["piel_anexos"] : 'No Evaluado'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "Neurologico: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["neurologico"]) && self::$consulta["HistoriaClinica"]["neurologico"] !== null ? self::$consulta["HistoriaClinica"]["neurologico"] : 'No Evaluado'), 1, 'L', 0);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "Agudeza Visual ojo Izquierdo: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["agudeza_visual_ojo_izquierdo"]) && self::$consulta["HistoriaClinica"]["agudeza_visual_ojo_izquierdo"] !== null ? self::$consulta["HistoriaClinica"]["agudeza_visual_ojo_izquierdo"] : 'sin hallazgos'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "Agudeza Visual ojo Derecho: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["agudeza_visual_ojo_derecho"]) && self::$consulta["HistoriaClinica"]["agudeza_visual_ojo_derecho"] !== null ? self::$consulta["HistoriaClinica"]["agudeza_visual_ojo_derecho"] : 'sin hallazgos'), 1, 'L', 0);



        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('VALORACIÓN DEL DESARROLLO'), 1, 0, 'C', 1);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, "Motricidad gruesa: " . (isset(self::$consulta["HistoriaClinica"]["motricidad_gruesa"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["motricidad_gruesa"]) : 'No Refiere'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, "Motricidad fina: " . (isset(self::$consulta["HistoriaClinica"]["motricidad_fina"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["motricidad_fina"]) : 'NORMAL'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, "Audición y lenguaje: " . (isset(self::$consulta["HistoriaClinica"]["audicion_lenguaje"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["audicion_lenguaje"]) : 'NORMAL'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, "Personal-social: " . (isset(self::$consulta["HistoriaClinica"]["personal_social"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["personal_social"]) : 'NORMAL'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, "Percepción de los cuidadores del desarrollo del niño: " . (isset(self::$consulta["HistoriaClinica"]["cuidado"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["cuidado"]) : 'NORMAL'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, "Resultado escala abreviada del desarrollo: " . (isset(self::$consulta["HistoriaClinica"]["escala_desarrollo"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["escala_desarrollo"]) : 'NORMAL'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, "Resultado test tamizaje de autismo: " . (isset(self::$consulta["HistoriaClinica"]["autismo"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["autismo"]) : 'NORMAL'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, "Demuestran que sus actividades tienen un propósito: " . (isset(self::$consulta["HistoriaClinica"]["actividades"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["actividades"]) : 'NORMAL'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, "Ejercen autocontrol: " . (isset(self::$consulta["HistoriaClinica"]["autocontrol"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["autocontrol"]) : 'NORMAL'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, "Exhiben comportamientos fiables, consistentes y pensados: " . (isset(self::$consulta["HistoriaClinica"]["comportamientos"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["comportamientos"]) : 'NORMAL'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, "Expresan autoeficacia positiva: " . (isset(self::$consulta["HistoriaClinica"]["auto_eficacia"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["auto_eficacia"]) : 'NORMAL'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, "Demuestran independencia: " . (isset(self::$consulta["HistoriaClinica"]["independencia"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["independencia"]) : 'NORMAL'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, "Demuestran capacidad de resolución de problemas: " . (isset(self::$consulta["HistoriaClinica"]["actividades_proposito"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["actividades_proposito"]) : 'NORMAL'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, "Exhiben un foco de control interno: " . (isset(self::$consulta["HistoriaClinica"]["actividades_proposito"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["actividades_proposito"]) : 'NORMAL'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, "Funciones ejecutivas: " . (isset(self::$consulta["HistoriaClinica"]["funciones_ejecutivas"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["funciones_ejecutivas"]) : 'NORMAL'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, "Identidad: " . (isset(self::$consulta["HistoriaClinica"]["Identidad"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["Identidad"]) : 'NORMAL'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, "Resultado de instrumento valoración de la identidad: " . (isset(self::$consulta["HistoriaClinica"]["valoracion_identidad"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["valoracion_identidad"]) : 'NORMAL'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, "Autonomía: " . (isset(self::$consulta["HistoriaClinica"]["autonomia"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["autonomia"]) : 'NORMAL'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, "Resultado de instrumento valoración de la autonomía: " . (isset(self::$consulta["HistoriaClinica"]["valoracion_autonomia"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["valoracion_autonomia"]) : 'NORMAL'), 1, 'L', 0);

        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('VALORACIÓN SALUD AUDITIVA Y COMUNICATIVA'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Funciones de la articulación, voz y habla: ") . utf8_decode(self::$consulta["HistoriaClinica"]["funciones"] ?? 'No evaluado'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Desempeño comunicativo: ") . utf8_decode(self::$consulta["HistoriaClinica"]["desempenio_comunicativo"] ?? 'No evaluado'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, "Resultado cuestionario: " . utf8_decode(self::$consulta["HistoriaClinica"]["resultado_vale"] ?? 'No evaluado'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Lista de chequeo de factores de riesgo de las enfermedades del oído: ") . utf8_decode(self::$consulta["HistoriaClinica"]["factores_oido"] ?? 'No evaluado'), 1, 'L', 0);
        $pdf->Ln();


        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('VALORACIÓN PSICOSOCIAL'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, "Violencia: " . utf8_decode(self::$consulta["HistoriaClinica"]["violencia_mental"] ?? 'No evaluado'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, "Violencia conflicto armado: " . utf8_decode(self::$consulta["HistoriaClinica"]["violencia_conflicto"] ?? 'No evaluado'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, "Violencia sexual: " . utf8_decode(self::$consulta["HistoriaClinica"]["violencia_sexual"] ?? 'No evaluado'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, "Lesiones autoinflingidas: " . utf8_decode(self::$consulta["HistoriaClinica"]["lesiones_auto_inflingidas"] ?? 'No evaluado'), 1, 'L', 0);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('ADHERENCIA FARMACOTERAPEUTICA'), 1, 0, 'C', 1);
        $pdf->Ln();
        $y = $pdf->GetY();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->MultiCell(186, 4, utf8_decode("¿TOMA SIEMPRE LA MEDICACIÓN A LA HORA INDICADA?:") . utf8_decode(self::$consulta["adherenciaFarmaceutica"]["hora_indicada"] ?? 'No Aplica'), 1, 'L', 0);
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->MultiCell(186, 4, utf8_decode("¿EN CASO DE SENTIRSE MAL HA DEJADO DE TOMAR LA MEDICACIÓN ALGUNA VEZ?:") . utf8_decode(self::$consulta["adherenciaFarmaceutica"]["dejado_medicamento"] ?? 'No Aplica'), 1, 'L', 0);
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->MultiCell(186, 4, utf8_decode("EN ALGUNA OCASIÓN ¿SE HA OLVIDADO DE TOMAR LA MEDICACIÓN?:") . utf8_decode(self::$consulta["adherenciaFarmaceutica"]["dejado_medicamento"] ?? 'No Aplica'), 1, 'L', 0);
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->MultiCell(186, 4, utf8_decode("DURANTE EL FIN DE SEMANA ¿SE HA OLVIDADO DE ALGUNA TOMA DE MEDICACIÓN?:") . utf8_decode(self::$consulta["adherenciaFarmaceutica"]["finsemana_olvidomedicamento"] ?? 'No Aplica'), 1, 'L', 0);
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->MultiCell(186, 4, utf8_decode("EN LA ÚLTIMA SEMANA ¿CÚANTAS VECES NO TOMÓ ALGUNA DOSIS?: ") . utf8_decode(self::$consulta["adherenciaFarmaceutica"]["finsemana_notomomedicamento"] ?? 'No Aplica'), 1, 'L', 0);
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->MultiCell(186, 4, utf8_decode("DESDE LA ÚLTIMA VISITA ¿CÚANTAS DÍAS COMPLETOS NO TOMÓ LA MEDICACIÓN?:") . utf8_decode(self::$consulta["adherenciaFarmaceutica"]["dias_notomomedicamento"] ?? 'No Aplica'), 1, 'L', 0);
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
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->MultiCell(186, 4, utf8_decode("PORCENTAJE:  ") . utf8_decode(self::$consulta["adherenciaFarmaceutica"]["porcentaje"] ?? 'No Aplica'), 1, 'L', 0);
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->MultiCell(186, 4, utf8_decode("ADHERENCIA CRITERIO DEL QUIMICO:  ") . utf8_decode(self::$consulta["adherenciaFarmaceutica"]["criterio_quimico"] ?? 'No Aplica'), 1, 'L', 0);

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
