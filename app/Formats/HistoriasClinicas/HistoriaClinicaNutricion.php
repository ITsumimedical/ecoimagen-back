<?php

namespace App\Formats\HistoriasClinicas;

use App\Http\Modules\ResultadoAyudasDiagnosticos\Model\ResultadoAyudasDiagnosticas;
use App\Http\Modules\Historia\ResultadoLaboratorio\Models\ResultadoLaboratorio;
use Codedge\Fpdf\Facades\Fpdf;
use App\Http\Modules\RemisionProgramas\Model\RemisionProgramas;


class HistoriaClinicaNutricion extends Fpdf
{
    protected static $consulta;

    public function bodyNutricion($pdf, $consulta)
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
                    'registrado_por' => $ayuda->user->operador->nombre_completo ?? 'No Refiere',
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

        $afiliadoId = $consulta->afiliado_id;
        $resultadosLaboratorio = ResultadoLaboratorio::whereHas('consulta', function ($query) use ($afiliadoId) {
            $query->where('afiliado_id', $afiliadoId);
        })->with(['user.operador'])
            ->get();

        // Imprimir resultados de laboratorio
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('RESULTADOS LABORATORIOS'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 8);

        if ($resultadosLaboratorio->isEmpty()) {
            $pdf->SetX(12);
            $pdf->Cell(186, 6, utf8_decode('No se encontraron resultados asociados.'), 1, 0, 'L');
            $pdf->Ln();
        } else {
            foreach ($resultadosLaboratorio as $resultadoLaboratorio) {
                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                // Laboratorio
                $laboratorio = !empty($resultadoLaboratorio->laboratorio)
                    ? utf8_decode($resultadoLaboratorio->laboratorio)
                    : utf8_decode('No Aplica');
                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode('LABORATORIO: ' . $laboratorio), 1, 'L');

                // Resultado
                $resultadoLab = !empty($resultadoLaboratorio->resultado_lab)
                    ? utf8_decode($resultadoLaboratorio->resultado_lab)
                    : utf8_decode('No Aplica');
                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode('RESULTADO: ' . $resultadoLab), 1, 'L');

                // Concatenar ambos registros en un solo texto
                $fechaLaboratorio = !empty($resultadoLaboratorio->fecha_laboratorio)
                    ? utf8_decode(substr($resultadoLaboratorio->fecha_laboratorio, 0, 10))
                    : utf8_decode('No Aplica');

                $usuario = !empty($resultadoLaboratorio->user->operador->nombre_completo)
                    ? utf8_decode($resultadoLaboratorio->user->operador->nombre_completo)
                    : utf8_decode('No Aplica');

                // Crear el texto combinado
                $textoConcatenado = "FECHA LABORATORIO: $fechaLaboratorio - REGISTRADO POR: $usuario";

                // Establecer el texto combinado en el PDF
                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, $textoConcatenado, 1, 'L');

                $pdf->Ln(2);
            }
        }
        $pdf->Ln();


        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(186, 4, utf8_decode('ESTILOS DE VIDA'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(62, 4, "Consume frutas y verduras: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["dieta_saludable"]) && self::$consulta["HistoriaClinica"]["dieta_saludable"] !== null ? self::$consulta["HistoriaClinica"]["dieta_saludable"] : 'No Refiere'), 1, 0, 'L');
        $pdf->Cell(62, 4, "Frecuencia: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["frecuencia_dieta_saludable"]) && self::$consulta["HistoriaClinica"]["frecuencia_dieta_saludable"] !== null ? self::$consulta["HistoriaClinica"]["frecuencia_dieta_saludable"] : 'No Refiere'), 1, 0, 'L');
        $pdf->Cell(62, 4, "Dieta balanceada: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["dieta_balanceada"]) && self::$consulta["HistoriaClinica"]["dieta_balanceada"] !== null ? self::$consulta["HistoriaClinica"]["dieta_balanceada"] : 'No Refiere'), 1, 0, 'L');
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->Cell(62, 4, utf8_decode("Comidas en el día: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["cuantas_comidas"]) && self::$consulta["HistoriaClinica"]["cuantas_comidas"] !== null ? self::$consulta["HistoriaClinica"]["cuantas_comidas"] : 'No Refiere'), 1, 0, 'L');
        $pdf->Cell(62, 4, utf8_decode("Sueño reparador: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["sueno_reparador"]) && self::$consulta["HistoriaClinica"]["sueno_reparador"] !== null ? self::$consulta["HistoriaClinica"]["sueno_reparador"] : 'No Refiere'), 1, 0, 'L');
        if (self::$consulta["HistoriaClinica"]["sueno_reparador"] === 'Si') {
            $pdf->Cell(62, 4, utf8_decode("Tipo de sueño: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["tipo_sueno"]) && self::$consulta["HistoriaClinica"]["tipo_sueno"] !== null ? self::$consulta["HistoriaClinica"]["tipo_sueno"] : 'No Refiere'), 1, 0, 'L');
        }
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->Cell(62, 4, utf8_decode("Duración del sueño: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["duracion_sueno"]) && self::$consulta["HistoriaClinica"]["duracion_sueno"] !== null ? self::$consulta["HistoriaClinica"]["duracion_sueno"] : 'No Refiere'), 1, 0, 'L');
        $pdf->Cell(62, 4, utf8_decode("Actividad fisica: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["actividad_fisica"]) && self::$consulta["HistoriaClinica"]["actividad_fisica"] !== null ? self::$consulta["HistoriaClinica"]["actividad_fisica"] : 'No Refiere'), 1, 0, 'L');
        $pdf->Cell(62, 4, utf8_decode("Esfinter vesical: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["esfinter"]) && self::$consulta["HistoriaClinica"]["esfinter"] !== null ? self::$consulta["HistoriaClinica"]["esfinter"] : 'No Refiere'), 1, 0, 'L');
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->Cell(62, 4, utf8_decode("Esfinter rectal: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["esfinter_rectal"]) && self::$consulta["HistoriaClinica"]["esfinter_rectal"] !== null ? self::$consulta["HistoriaClinica"]["esfinter_rectal"] : 'No Refiere'), 1, 0, 'L');
        $pdf->Cell(62, 4, utf8_decode("Frecuencia de orina: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["caracteristicas_orina"]) && self::$consulta["HistoriaClinica"]["caracteristicas_orina"] !== null ? self::$consulta["HistoriaClinica"]["caracteristicas_orina"] : 'No Refiere'), 1, 0, 'L');

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
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(186, 4, utf8_decode('SUSTANCIAS PSICOACTIVAS'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(62, 4, utf8_decode("Frecuencia de exposicion: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["anios_expuesto_sustancias"]) && self::$consulta["HistoriaClinica"]["anios_expuesto_sustancias"] !== null ? self::$consulta["HistoriaClinica"]["anios_expuesto_sustancias"] : 'No Refiere'), 1, 0, 'L');
        $pdf->Cell(62, 4, utf8_decode("Fecha inicio de consumo: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["consumo_psicoactivo"]) && self::$consulta["HistoriaClinica"]["consumo_psicoactivo"] !== null ? self::$consulta["HistoriaClinica"]["consumo_psicoactivo"] : 'No Refiere'), 1, 0, 'L');
        $pdf->Cell(62, 4, utf8_decode("Cantidad consumo: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["psicoactivo_cantidad"]) && self::$consulta["HistoriaClinica"]["psicoactivo_cantidad"] !== null ? self::$consulta["HistoriaClinica"]["psicoactivo_cantidad"] : 'No Refiere'), 1, 0, 'L');
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(186, 4, utf8_decode('CONSUMO BEBIDAS ALCOHOLICAS'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(93, 4, utf8_decode("Cantidad de tragos: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["cantidad_licor"]) && self::$consulta["HistoriaClinica"]["cantidad_licor"] !== null ? self::$consulta["HistoriaClinica"]["cantidad_licor"] : 'No Refiere'), 1, 0, 'L');
        $pdf->Cell(93, 4, utf8_decode("Frecuencia consumo de bebidas: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["licor_frecuencia"]) && self::$consulta["HistoriaClinica"]["licor_frecuencia"] !== null ? self::$consulta["HistoriaClinica"]["licor_frecuencia"] : 'No Refiere'), 1, 0, 'L');
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(186, 4, utf8_decode('OBSERVACIONES'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Observaciones adicionales: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["estilo_vida_observaciones"]) && self::$consulta["HistoriaClinica"]["estilo_vida_observaciones"] !== null ? self::$consulta["HistoriaClinica"]["estilo_vida_observaciones"] : 'No Refiere'), 1, 0, 'L');
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('VALORACION ANTROPOMETRICA'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(62, 4, utf8_decode("Registro del peso anterior: ") . utf8_decode(isset(self::$consulta["valoracionAntropometrica"]["peso_anterior"]) && self::$consulta["valoracionAntropometrica"]["peso_anterior"] !== null ? self::$consulta["valoracionAntropometrica"]["peso_anterior"] . ' kilogramos'  : 'No Refiere'), 1, 0, 'L');
        $pdf->Cell(62, 4, utf8_decode("Fecha del registro: ") . utf8_decode(isset(self::$consulta["valoracionAntropometrica"]["fecha_registro_peso_anterior"]) && self::$consulta["valoracionAntropometrica"]["fecha_registro_peso_anterior"] !== null ? self::$consulta["valoracionAntropometrica"]["fecha_registro_peso_anterior"] : 'No Refiere'), 1, 0, 'L');
        $pdf->Cell(62, 4, utf8_decode("Registro del peso actual: ") . utf8_decode(isset(self::$consulta["valoracionAntropometrica"]["peso_actual"]) && self::$consulta["valoracionAntropometrica"]["peso_actual"] !== null ? self::$consulta["valoracionAntropometrica"]["peso_actual"] . ' Kilogramos' : 'No Refiere'), 1, 0, 'L');
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->Cell(93, 4, utf8_decode("Registro de la talla: ") . utf8_decode(isset(self::$consulta["valoracionAntropometrica"]["altura_actual"]) && self::$consulta["valoracionAntropometrica"]["altura_actual"] !== null ? self::$consulta["valoracionAntropometrica"]["altura_actual"] . ' Centímetros' : 'No Refiere'), 1, 0, 'L');
        $pdf->Cell(93, 4, utf8_decode("IMC: ") . utf8_decode(isset(self::$consulta["valoracionAntropometrica"]["imc"]) && self::$consulta["valoracionAntropometrica"]["imc"] !== null ? self::$consulta["valoracionAntropometrica"]["imc"] : 'No Refiere'), 1, 0, 'L');
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->Cell(93, 4, utf8_decode("Clasificacion: ") . utf8_decode(isset(self::$consulta["valoracionAntropometrica"]["clasificacion"]) && self::$consulta["valoracionAntropometrica"]["clasificacion"] !== null ? self::$consulta["valoracionAntropometrica"]["clasificacion"] : 'No Refiere'), 1, 0, 'L');
        $pdf->Cell(93, 4, utf8_decode("Perimetro braquial: ") . utf8_decode(isset(self::$consulta["valoracionAntropometrica"]["perimetro_braquial"]) && self::$consulta["valoracionAntropometrica"]["perimetro_braquial"] !== null ? self::$consulta["valoracionAntropometrica"]["perimetro_braquial"] . ' Centímetros' : 'No Refiere'), 1, 0, 'L');
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->Cell(93, 4, utf8_decode("Pliegue de grasa tricipital: ") . utf8_decode(isset(self::$consulta["valoracionAntropometrica"]["pliegue_grasa_tricipital"]) && self::$consulta["valoracionAntropometrica"]["pliegue_grasa_tricipital"] !== null ? self::$consulta["valoracionAntropometrica"]["pliegue_grasa_tricipital"] . ' Centímetros' : 'No Refiere'), 1, 0, 'L');
        $pdf->Cell(93, 4, utf8_decode("Pliegue de grasa subescapular: ") . utf8_decode(isset(self::$consulta["valoracionAntropometrica"]["pliegue_grasa_subescapular"]) && self::$consulta["valoracionAntropometrica"]["pliegue_grasa_subescapular"] !== null ? self::$consulta["valoracionAntropometrica"]["pliegue_grasa_subescapular"] . ' Centímetros' : 'No Refiere'), 1, 0, 'L');
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->Cell(93, 4, utf8_decode("Peso/Talla: ") . utf8_decode(isset(self::$consulta["valoracionAntropometrica"]["peso_talla"]) && self::$consulta["valoracionAntropometrica"]["peso_talla"] !== null ? self::$consulta["valoracionAntropometrica"]["peso_talla"] : 'No Refiere'), 1, 0, 'L');
        $pdf->Cell(93, 4, utf8_decode("Talla o longitud: ") . utf8_decode(isset(self::$consulta["valoracionAntropometrica"]["longitud_talla"]) && self::$consulta["valoracionAntropometrica"]["longitud_talla"] !== null ? self::$consulta["valoracionAntropometrica"]["longitud_talla"] : 'No Refiere'), 1, 0, 'L');


        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('MINUTA'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(93, 4, utf8_decode("Tragos: ") . utf8_decode(isset(self::$consulta["minuta"]["tragos"]) && self::$consulta["minuta"]["tragos"] !== null ? (self::$consulta["minuta"]["tragos"] ? 'Si' : 'No') : 'No Refiere'), 1, 0, 'L');
        $tragos_sino = self::$consulta["minuta"]["tragos"] ?? null;
        if ($tragos_sino) {
            $pdf->Cell(93, 4, utf8_decode("Hora de los tragos: ") . utf8_decode(isset(self::$consulta["minuta"]["hora_tragos"]) && self::$consulta["minuta"]["hora_tragos"] !== null ? self::$consulta["minuta"]["hora_tragos"] : 'No Refiere'), 1, 0, 'L');
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->MultiCell(186, 4, utf8_decode("Descripción: ") . utf8_decode(isset(self::$consulta["minuta"]["descripcion_tragos"]) && self::$consulta["minuta"]["descripcion_tragos"] !== null ? self::$consulta["minuta"]["descripcion_tragos"] : 'No Refiere'), 1, 0, 'L');
        }
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->Cell(93, 4, utf8_decode("Desayuno: ") . utf8_decode(isset(self::$consulta["minuta"]["desayuna_sino"]) && self::$consulta["minuta"]["desayuna_sino"] !== null ? (self::$consulta["minuta"]["desayuna_sino"] ? 'Si' : 'No') : 'No Refiere'), 1, 0, 'L');
        $desayuno_sino = self::$consulta["minuta"]["desayuna_sino"] ?? null;
        if ($desayuno_sino) {
            $pdf->Cell(93, 4, utf8_decode("Hora del desayuno: ") . utf8_decode(isset(self::$consulta["minuta"]["desayuno"]) && self::$consulta["minuta"]["desayuno"] !== null ? self::$consulta["minuta"]["desayuno"] : 'No Refiere'), 1, 0, 'L');
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->MultiCell(186, 4, utf8_decode("Descripción: ") . utf8_decode(isset(self::$consulta["minuta"]["observaciones_desayuno"]) && self::$consulta["minuta"]["observaciones_desayuno"] !== null ? self::$consulta["minuta"]["observaciones_desayuno"] : 'No Refiere'), 1, 1, 'L');
        }

        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->Cell(93, 4, utf8_decode("Media mañana: ") . utf8_decode(isset(self::$consulta["minuta"]["mm_sino"]) && self::$consulta["minuta"]["mm_sino"] !== null ? (self::$consulta["minuta"]["mm_sino"] ? 'Si' : 'No') : 'No Refiere'), 1, 0, 'L');
        $media_manana = self::$consulta["minuta"]["mm_sino"] ?? null;
        if ($media_manana) {
            $pdf->Cell(93, 4, utf8_decode("Hora de la media mañana: ") . utf8_decode(isset(self::$consulta["minuta"]["media_manana"]) && self::$consulta["minuta"]["media_manana"] !== null ? self::$consulta["minuta"]["media_manana"] : 'No Refiere'), 1, 0, 'L');
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->MultiCell(186, 4, utf8_decode("Descripción: ") . utf8_decode(isset(self::$consulta["minuta"]["mm_descripcion"]) && self::$consulta["minuta"]["mm_descripcion"] !== null ? self::$consulta["minuta"]["mm_descripcion"] : 'No Refiere'), 1, 1, 'L');
        }

        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->Cell(93, 4, utf8_decode("Almuerzo: ") . utf8_decode(isset(self::$consulta["minuta"]["almuerzo_sino"]) && self::$consulta["minuta"]["almuerzo_sino"] !== null ? (self::$consulta["minuta"]["almuerzo_sino"] ? 'Si' : 'No') : 'No Refiere'), 1, 0, 'L');
        $almuerzosino = self::$consulta["minuta"]["almuerzo_sino"] ?? null;
        if ($almuerzosino) {
            $pdf->Cell(93, 4, utf8_decode("Hora del almuerzo: ") . utf8_decode(isset(self::$consulta["minuta"]["almuerzo"]) && self::$consulta["minuta"]["almuerzo"] !== null ? self::$consulta["minuta"]["almuerzo"] : 'No Refiere'), 1, 0, 'L');
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->MultiCell(186, 4, utf8_decode("Descripción: ") . utf8_decode(isset(self::$consulta["minuta"]["descripcion_almuerzo"]) && self::$consulta["minuta"]["descripcion_almuerzo"] !== null ? self::$consulta["minuta"]["descripcion_almuerzo"] : 'No Refiere'), 1, 1, 'L');
        }

        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->Cell(93, 4, utf8_decode("Algo: ") . utf8_decode(isset(self::$consulta["minuta"]["algo_sino"]) && self::$consulta["minuta"]["algo_sino"] !== null ? (self::$consulta["minuta"]["algo_sino"] ? 'Si' : 'No') : 'No Refiere'), 1, 0, 'L');
        $algosino = self::$consulta["minuta"]["algo_sino"] ?? null;
        if ($algosino) {
            $pdf->Cell(93, 4, utf8_decode("Hora del algo: ") . utf8_decode(isset(self::$consulta["minuta"]["algo"]) && self::$consulta["minuta"]["algo"] !== null ? self::$consulta["minuta"]["algo"] : 'No Refiere'), 1, 0, 'L');
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->MultiCell(186, 4, utf8_decode("Descripción: ") . utf8_decode(isset(self::$consulta["minuta"]["descripcion_algo"]) && self::$consulta["minuta"]["descripcion_algo"] !== null ? self::$consulta["minuta"]["descripcion_algo"] : 'No Refiere'), 1, 0, 'L');
        }
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->Cell(93, 4, utf8_decode("Comida: ") . utf8_decode(isset(self::$consulta["minuta"]["comida_sino"]) && self::$consulta["minuta"]["comida_sino"] !== null ? (self::$consulta["minuta"]["comida_sino"] ? 'Si' : 'No') : 'No Refiere'), 1, 0, 'L');
        $comidasino = self::$consulta["minuta"]["comida_sino"] ?? null;
        if ($comidasino) {
            $pdf->Cell(93, 4, utf8_decode("Hora de la comida: ") . utf8_decode(isset(self::$consulta["minuta"]["comida"]) && self::$consulta["minuta"]["comida"] !== null ? self::$consulta["minuta"]["comida"] : 'No Refiere'), 1, 0, 'L');
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->MultiCell(186, 4, utf8_decode("Descripción: ") . utf8_decode(isset(self::$consulta["minuta"]["comida_descripcion"]) && self::$consulta["minuta"]["comida_descripcion"] !== null ? self::$consulta["minuta"]["comida_descripcion"] : 'No Refiere'), 1, 0, 'L');
        }
        $pdf->Ln();


        $pdf->SetX(12);
        $pdf->Cell(93, 4, utf8_decode("Merienda: ") . utf8_decode(isset(self::$consulta["minuta"]["merienda_sino"]) && self::$consulta["minuta"]["merienda_sino"] !== null ? (self::$consulta["minuta"]["merienda_sino"] ? 'Si' : 'No') : 'No Refiere'), 1, 0, 'L');
        $merienda_sino = self::$consulta["minuta"]["merienda_sino"] ?? null;
        if ($merienda_sino) {
            $pdf->Cell(93, 4, utf8_decode("Hora de la merienda: ") . utf8_decode(isset(self::$consulta["minuta"]["merienda"]) && self::$consulta["minuta"]["merienda"] !== null ? self::$consulta["minuta"]["merienda"] : 'No Refiere'), 1, 0, 'L');
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->MultiCell(186, 4, utf8_decode("Descripción: ") . utf8_decode(isset(self::$consulta["minuta"]["descripcion_merienda"]) && self::$consulta["minuta"]["descripcion_merienda"] !== null ? self::$consulta["minuta"]["descripcion_merienda"] : 'No Refiere'), 1, 1, 'L');
        }
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
