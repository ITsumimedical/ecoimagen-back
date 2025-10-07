<?php

namespace App\Formats\HistoriasClinicas;

use App\Http\Modules\Historia\AntecedentesPersonales\Models\AntecedentePersonale;
use App\Http\Modules\ResultadoAyudasDiagnosticos\Model\ResultadoAyudasDiagnosticas;
use App\Http\Modules\Historia\ResultadoLaboratorio\Models\ResultadoLaboratorio;
use App\Http\Modules\RemisionProgramas\Model\RemisionProgramas;

use Codedge\Fpdf\Facades\Fpdf;

class HistoriaClinicaTerapiaRespiratoria extends Fpdf
{
    protected static $consulta;

    public function bodyTerapiaRespiratoria($pdf, $consulta)
    {
        self::$consulta = $consulta;

        $y = $pdf->GetY();

        $pdf->SetXY(12, $y + 8);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('MOTIVO DE CONSULTA'), 1, 0, 'C', 1);
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
            })->when(empty($consulta["HistoriaClinica"]["imprimir_ayudas_diagnosticas"]), function ($query) use ($consulta) {
                $query->where('consulta_id', $consulta->id);
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
                    $pdf->MultiCell(186, 4, utf8_decode('REGISTRADO POR: ' . $resultado['registrado_por']), 1, 'L');
                }

                $pdf->Ln(2);
            }
        }
        $pdf->Ln();

        // Imprimir resultados de laboratorio
        $afiliadoId = $consulta->afiliado_id;
        $resultadosLaboratorio = ResultadoLaboratorio::whereHas('consulta', function ($query) use ($afiliadoId) {
            $query->where('afiliado_id', $afiliadoId);
        })->with(['user.operador'])
            ->get();

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
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
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
                $detalle = utf8_decode('FECHA DIAGNÓSTICO: ' . $fechaDiagnostico . ' | REGISTRADO POR: ' . $nombreCompletoMedico);

                // Imprimir el texto concatenado
                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, $detalle, 1, 'L');

                $pdf->Ln(2);
            }
        }
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
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();


        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('PATOLOGIAS RESPIRATORIAS'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();
        if (isset(self::$consulta['patologiaRespiratoria'])) {

            $patologiaRespiratoria = self::$consulta['patologiaRespiratoria'];
            foreach ($patologiaRespiratoria as $patologiaRespiratorias) {
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 9);
                $pdf->Cell(186, 4, utf8_decode("Hipoapnea obstructiva del Sueño: ") . '' . utf8_decode($patologiaRespiratorias->hipoapnea_obstructiva_sueno ? "Sí" : "No"), 1, 0, 'L');
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->Cell(93, 4, utf8_decode("Tipo de Apnea: ") . '' . utf8_decode($patologiaRespiratorias->tipoApnea), 1, 0, 'L');
                $pdf->Cell(93, 4, utf8_decode("Origen: ") . '' . utf8_decode($patologiaRespiratorias->origen), 1, 0, 'L');
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->Cell(186, 4, utf8_decode("Uso de CPAP/BIPAP: ") . '' . utf8_decode($patologiaRespiratorias->uso_cpap_bipap ? "Sí" : "No"), 1, 0, 'L');
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 9);
                $pdf->MultiCell(186, 4, "Observaciones: " . utf8_decode($patologiaRespiratorias->observacion_uso), 1, 'L', 0);
                $pdf->SetX(12);
                $pdf->Cell(186, 4, utf8_decode("Adherencia de CPAP/BIPAP: ") . '' . utf8_decode($patologiaRespiratorias->adherencia_cpap_bipap ? "Sí" : "No"), 1, 1, 'L');
                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 9);
                $pdf->MultiCell(186, 4, "Observaciones: " . utf8_decode($patologiaRespiratorias->observacion_adherencia), 1, 'L', 0);
                $pdf->SetX(12);
                $pdf->Cell(80, 4, utf8_decode("Uso de Oxigeno ") . utf8_decode($patologiaRespiratorias->uso_oxigeno ? "Sí" : "No"), 1, 0, 'L');
                $pdf->Cell(106, 4, utf8_decode("Litros de  Oxigeno: ") . '' . utf8_decode($patologiaRespiratorias->litro_oxigeno), 1, 0, 'L');
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->Cell(186, 4, utf8_decode("Clasificación del Control del Asma: ") . '' . utf8_decode($patologiaRespiratorias->clasificacion_control_asma), 1, 0, 'L');
                $pdf->Ln();
                $pdf->SetX(12);
            }
        } else {
            $pdf->Cell(186, 4, utf8_decode("No hay Registros en Patologia Respiratoria"), 1, 0, 'L');
            $pdf->Ln();
            $pdf->SetX(12);
        }

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();

        //medidas antropometricas
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

        //signos vitales
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

        //Imprimir el examen fisico
        if (self::$consulta["especialidad_id"] !== 43) {
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


        $pdf->Ln();


        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();


        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();

        if (isset(self::$consulta['sistemaRespiratorio'])) {

            $sistemaRespiratorios = self::$consulta['sistemaRespiratorio'];

            foreach ($sistemaRespiratorios as $sistemaRespiratorio) {

                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetFillColor(214, 214, 214);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->Cell(186, 4, utf8_decode('SISTEMA RESPIRATORIO'), 1, 0, 'C', 1);
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 9);
                $pdf->Cell(93, 4, utf8_decode("Escala disnea MRC : ") . utf8_decode($sistemaRespiratorio->escala_disnea_mrc), 1, 0, 'L');
                $pdf->Cell(93, 4, utf8_decode("Indice de bode: ") . utf8_decode($sistemaRespiratorio->indice_bode), 1, 0, 'L');
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->Cell(93, 4, utf8_decode("Bodex :") . utf8_decode($sistemaRespiratorio->bodex), 1, 0, 'L');
                $pdf->Cell(93, 4, utf8_decode("Escala de Epworth (ESE):") . utf8_decode($sistemaRespiratorio->escala_de_epworth), 1, 0, 'L');
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->Cell(93, 4, utf8_decode("Escala de Borg :") . utf8_decode($sistemaRespiratorio->escala_de_borg), 1, 0, 'L');
                $pdf->Cell(93, 4, utf8_decode("Evaluación de CAT:") . utf8_decode($sistemaRespiratorio->evaluacion_cat), 1, 0, 'L');
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->Cell(62, 4, utf8_decode("Stop-Bang:") . utf8_decode($sistemaRespiratorio->stop_bang), 1, 0, 'L');
            }
        } else {
            $pdf->Cell(186, 4, utf8_decode("No hay Registros en sistema Respiratorio"), 1, 0, 'L');
        }


        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
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

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();

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

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();

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
