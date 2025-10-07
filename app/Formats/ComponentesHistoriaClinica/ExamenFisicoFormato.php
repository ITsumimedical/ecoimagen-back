<?php

namespace App\Formats\ComponentesHistoriaClinica;

use App\Http\Modules\GraficasOms\Services\GraficasOmsService;
use DateTime;
use Illuminate\Http\Request;

class ExamenFisicoFormato
{
    protected $graficasOmsService;

    function reemplazarSimbolos($texto)
    {
        $map = [
            '≤' => '<=',
            '≥' => '>=',
            '•' => '*',
            '→' => '->',
        ];
        return strtr($texto, $map);
    }

    public function bodyComponente($pdf, $consulta): void
    {
        if (!in_array($consulta["especialidad_id"], [43, 45])) {
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('MEDIDAS ANTROPOMÉTRICAS'), 1, 0, 'C', 1);

            $pdf->Ln();

            $pdf->SetX(12);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(45, 4, utf8_decode(isset($consulta["HistoriaClinica"]["peso"]) && $consulta["HistoriaClinica"]["peso"] !== null ? "Peso: " . $consulta["HistoriaClinica"]["peso"] . " Kilogramos" : "Peso: 0"), 1, 0, 'L', 0);
            $pdf->Cell(45, 4, utf8_decode(isset($consulta["HistoriaClinica"]["talla"]) && $consulta["HistoriaClinica"]["talla"] !== null ? "Talla: " . $consulta["HistoriaClinica"]["talla"] . " Centímetros" : "Talla: 0"), 1, 0, 'L', 0);
            $pdf->Cell(27, 4, utf8_decode(isset($consulta["HistoriaClinica"]["imc"]) && $consulta["HistoriaClinica"]["imc"] !== null ? "IMC: " . $consulta["HistoriaClinica"]["imc"] : "IMC: No Evaluado"), 1, 0, 'L', 0);
            $pdf->Cell(69, 4, utf8_decode(isset($consulta["HistoriaClinica"]["isc"]) && $consulta["HistoriaClinica"]["isc"] !== null ? "Índice de superficie corporal: " . $consulta["HistoriaClinica"]["isc"] : "Índice de superficie corporal: No Evaluado"), 1, 0, 'L', 0);
            $pdf->Ln();

            $pdf->SetX(12);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(186, 4, utf8_decode(isset($consulta["HistoriaClinica"]["clasificacion"]) && $consulta["HistoriaClinica"]["clasificacion"] !== null ? "Clasificación: " . $consulta["HistoriaClinica"]["clasificacion"] : "Clasificación: No Evaluado"), 1, 0, 'L', 0);
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->Cell(186, 4, utf8_decode(isset($consulta["HistoriaClinica"]["perimetro_abdominal"]) && $consulta["HistoriaClinica"]["perimetro_abdominal"] !== null ? "Perímetro abdominal: " . $consulta["HistoriaClinica"]["perimetro_abdominal"] . " Centímetros" : "Perímetro abdominal: No Evaluado"), 1, 0, 'L', 0);
            $pdf->Ln();


            if ($consulta["afiliado"]["ciclo_vida_atencion"] === "Primera Infancia (0-5 Años)") {
                $pdf->SetX(12);
                $pdf->Cell(186, 4, utf8_decode('Perimetro Cefálico: ' . (isset($consulta["HistoriaClinica"]["perimetro_cefalico"]) ? utf8_decode($consulta["HistoriaClinica"]["perimetro_cefalico"]) . " Centímetros" : 'No Evaluado')), 1);
                // $pdf->Ln();
                // $pdf->SetX(12);
                // $pesoTalla = isset($consulta["HistoriaClinica"]["peso_talla"]) && $consulta["HistoriaClinica"]["peso_talla"] !== null
                //     ? $this->reemplazarSimbolos($consulta["HistoriaClinica"]["peso_talla"])
                //     : "No refiere";

                // $pdf->Cell(186, 4, utf8_decode("Peso para la talla: " . $pesoTalla), 1, 0, 'L', 0);
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->Cell(186, 4, utf8_decode("Clasificación peso para la talla: " .
                    (isset($consulta["HistoriaClinica"]["clasificacion_peso_talla"]) && $consulta["HistoriaClinica"]["clasificacion_peso_talla"] !== null
                        ? $consulta["HistoriaClinica"]["clasificacion_peso_talla"]
                        : "No refiere")), 1, 0, 'L', 0);
                $pdf->Ln();

                $pdf->SetX(12);
                $pdf->Cell(186, 4, utf8_decode("Clasificación perímetro cefálico para la edad:  " .
                    (isset($consulta["HistoriaClinica"]["clasificacion_cefalico_edad"]) && $consulta["HistoriaClinica"]["clasificacion_cefalico_edad"] !== null
                        ? $consulta["HistoriaClinica"]["clasificacion_cefalico_edad"]
                        : "No refiere")), 1, 0, 'L', 0);
                $pdf->Ln();

                // $pdf->SetX(12);
                // $pdf->Cell(186, 4, utf8_decode("Clasificación perímetro cefálico para la edad:  " .
                //     (isset($consulta["HistoriaClinica"]["cefalico_edad"]) && $consulta["HistoriaClinica"]["cefalico_edad"] !== null
                //         ? $this->reemplazarSimbolos($consulta["HistoriaClinica"]["cefalico_edad"])
                //         : "No refiere")), 1, 0, 'L', 0);
                // $pdf->Ln();

                // $pdf->SetX(12);
                // $pdf->Cell(186, 4, utf8_decode("Peso para la edad: " .
                //     (isset($consulta["HistoriaClinica"]["peso_edad"]) && $consulta["HistoriaClinica"]["peso_edad"] !== null
                //         ? $this->reemplazarSimbolos($consulta["HistoriaClinica"]["peso_edad"])
                //         : "No refiere")), 1, 0, 'L', 0);
                // $pdf->Ln();

                $pdf->SetX(12);
                $pdf->Cell(186, 4, utf8_decode("Clasificación peso para la edad: " .
                    (isset($consulta["HistoriaClinica"]["clasificacion_peso_edad"]) && $consulta["HistoriaClinica"]["clasificacion_peso_edad"] !== null
                        ? $consulta["HistoriaClinica"]["clasificacion_peso_edad"]
                        : "No refiere")), 1, 0, 'L', 0);
                $pdf->Ln();
            }

            if (
                $consulta["afiliado"]["ciclo_vida_atencion"] === "Primera Infancia (0-5 Años)" ||
                $consulta["afiliado"]["ciclo_vida_atencion"] === "Infancia (6-11 Años)" ||
                $consulta["afiliado"]["ciclo_vida_atencion"] === "Adolescencia (12 A 17 Años)"
            ) {
                $pdf->SetX(12);
                $pdf->Cell(186, 4, utf8_decode("Clasificación talla para la edad: " .
                    (isset($consulta["HistoriaClinica"]["clasificacion_talla_edad"]) && $consulta["HistoriaClinica"]["clasificacion_talla_edad"] !== null
                        ? $consulta["HistoriaClinica"]["clasificacion_talla_edad"]
                        : "No refiere")), 1, 0, 'L', 0);
                $pdf->Ln();

                // $pdf->SetX(12);
                // $pdf->Cell(186, 4, utf8_decode("IMC para la edad: " .
                //     (isset($consulta["HistoriaClinica"]["imc_edad"]) && $consulta["HistoriaClinica"]["imc_edad"] !== null
                //         ? $this->reemplazarSimbolos($consulta["HistoriaClinica"]["imc_edad"])
                //         : "No refiere")), 1, 0, 'L', 0);
                // $pdf->Ln();

                $pdf->SetX(12);
                $pdf->Cell(186, 4, utf8_decode("Clasificación IMC para la edad: " .
                    (isset($consulta["HistoriaClinica"]["clasificacion_imc_edad"]) && $consulta["HistoriaClinica"]["clasificacion_imc_edad"] !== null
                        ? $consulta["HistoriaClinica"]["clasificacion_imc_edad"]
                        : "No refiere")), 1, 0, 'L', 0);
                $pdf->Ln();
            }

            if (
                $consulta["afiliado"]["ciclo_vida_atencion"] === "Vejez (Mayor a 60 Años)"
            ) {
                $pdf->SetX(12);
                $pdf->Cell(62, 4, utf8_decode("Circunferencia brazo: " .
                    (isset($consulta["HistoriaClinica"]["circunferencia_brazo"]) && $consulta["HistoriaClinica"]["circunferencia_brazo"] !== null
                        ? $consulta["HistoriaClinica"]["circunferencia_brazo"] . " centímetros"
                        : "No Evaluado")), 1, 1, 'L', 0);
                $pdf->Ln();
            }

            if (
                $consulta["afiliado"]["ciclo_vida_atencion"] === "Primera Infancia (0-5 Años)" ||
                $consulta["afiliado"]["ciclo_vida_atencion"] === "Infancia (6-11 Años)"
            ) { {
                    $pdf->SetX(12);
                    $pdf->Cell(186, 4, utf8_decode("Circunferencia brazo: " .
                        (isset($consulta["HistoriaClinica"]["circunferencia_brazo"]) && $consulta["HistoriaClinica"]["circunferencia_brazo"] !== null
                            ? $consulta["HistoriaClinica"]["circunferencia_brazo"] . " centímetros"
                            : "No Evaluado")), 1, 1, 'L', 0);
                    $pdf->Ln();
                }
            }
        }

        if (!in_array($consulta["especialidad_id"], [42, 43, 44, 45])) {
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('SIGNOS VITALES'), 1, 0, 'C', 1);
            $pdf->SetX(12);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFont('Arial', '', 8);
            if ($consulta["afiliado"]["edad_cumplida"] >= 3) {
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->Cell(58, 4, utf8_decode(
                    isset($consulta["HistoriaClinica"]["presion_sistolica"]) && $consulta["HistoriaClinica"]["presion_sistolica"] !== null
                        ? "Presión sistólica: " . $consulta["HistoriaClinica"]["presion_sistolica"] . " milimetros de mercurio"
                        : "Presión sistólica: No Aplica"
                ), 1, 0, 'L', 0);

                $pdf->Cell(59, 4, utf8_decode(
                    isset($consulta["HistoriaClinica"]["presion_diastolica"]) && $consulta["HistoriaClinica"]["presion_diastolica"] !== null
                        ? "Presión Diastólica: " . $consulta["HistoriaClinica"]["presion_diastolica"] . " milimetros de mercurio"
                        : "Presión Diastólica: No Aplica"
                ), 1, 0, 'L', 0);

                $pdf->Cell(69, 4, utf8_decode(
                    isset($consulta["HistoriaClinica"]["presion_arterial_media"]) && $consulta["HistoriaClinica"]["presion_arterial_media"] !== null
                        ? "Presión arterial media: " . $consulta["HistoriaClinica"]["presion_arterial_media"] . " milimetros de mercurio"
                        : "Presión arterial media: No Aplica"
                ), 1, 0, 'L', 0);
            }

            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(58, 4, utf8_decode(
                isset($consulta["HistoriaClinica"]["frecuencia_cardiaca"]) && $consulta["HistoriaClinica"]["frecuencia_cardiaca"] !== null
                    ? "Frecuencia cardiaca: " . $consulta["HistoriaClinica"]["frecuencia_cardiaca"] . " latidos por minuto"
                    : "Frecuencia cardiaca: No Aplica"
            ), 1, 0, 'L', 0);

            $pdf->Cell(59, 4, utf8_decode(
                isset($consulta["HistoriaClinica"]["pulsos"]) && $consulta["HistoriaClinica"]["pulsos"] !== null
                    ? "Pulsos: " . $consulta["HistoriaClinica"]["pulsos"] . " Pulsaciones por minuto"
                    : "Pulsos: " . ($consulta["HistoriaClinica"]["frecuencia_cardiaca"]) . " Pulsaciones por minuto"
            ), 1, 0, 'L', 0);

            $pdf->Cell(69, 4, utf8_decode(
                isset($consulta["HistoriaClinica"]["frecuencia_respiratoria"]) && $consulta["HistoriaClinica"]["frecuencia_respiratoria"] !== null
                    ? "Frecuencia Respiratoria: " . $consulta["HistoriaClinica"]["frecuencia_respiratoria"] . " respiraciones por minuto"
                    : "Frecuencia Respiratoria: No Aplica"
            ), 1, 0, 'L', 0);
            $pdf->Ln();

            $pdf->SetX(12);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(62, 4, utf8_decode(
                isset($consulta["HistoriaClinica"]["temperatura"]) && $consulta["HistoriaClinica"]["temperatura"] !== null
                    ? "Temperatura: " . $consulta["HistoriaClinica"]["temperatura"] . " °C"
                    : "Temperatura: Afebril"
            ), 1, 0, 'L', 0);
            $pdf->Cell(62, 4, utf8_decode(
                isset($consulta["HistoriaClinica"]["saturacion_oxigeno"]) && $consulta["HistoriaClinica"]["saturacion_oxigeno"] !== null
                    ? "Saturación de oxígeno: " . $consulta["HistoriaClinica"]["saturacion_oxigeno"] . " %"
                    : "Saturación de oxígeno: No Aplica"
            ), 1, 0, 'L', 0);
            $pdf->Cell(62, 4, utf8_decode(isset($consulta["HistoriaClinica"]["fio"]) && $consulta["HistoriaClinica"]["fio"] !== null ? "Fracción inspiratoria de oxígeno: " . $consulta["HistoriaClinica"]["fio"] : "Fracción inspiratoria de oxígeno: 0.21"), 1, 0, 'L', 0);
            $pdf->Ln();
            $pdf->Ln();
        }


        //Imprimir el examen fisico
        if ($consulta["especialidad_id"] !== 43) {
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('EXAMEN FÍSICO'), 1, 0, 'C', 1);
            $pdf->Ln();

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 9);
            $pdf->MultiCell(186, 4, "Aspecto General: " . utf8_decode(isset($consulta["HistoriaClinica"]["aspecto_general"]) && $consulta["HistoriaClinica"]["aspecto_general"] !== null ? $consulta["HistoriaClinica"]["aspecto_general"] : ($consulta["HistoriaClinica"]["condicion_general"] !== null ? $consulta["HistoriaClinica"]["condicion_general"] : 'sin hallazgos')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 9);
            $pdf->MultiCell(186, 4, "Cabeza y cuello: " . utf8_decode(isset($consulta["HistoriaClinica"]["cabeza_cuello"]) && $consulta["HistoriaClinica"]["cabeza_cuello"] !== null ? $consulta["HistoriaClinica"]["cabeza_cuello"] : 'sin hallazgos'), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 9);
            $abdomenExamen = $consulta["HistoriaClinica"]["abdomen_examen"] ?? null;
            $abdomen = $consulta["HistoriaClinica"]["abdomen"] ?? null;
            $abdomenTexto = $abdomenExamen !== null ? $abdomenExamen : ($abdomen !== null ? $abdomen : 'sin hallazgos');
            $pdf->MultiCell(186, 4, "Abdomen: " . utf8_decode($abdomenTexto), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 9);
            $pdf->MultiCell(186, 4, "Cardiorrespiratorio: " . utf8_decode(isset($consulta["HistoriaClinica"]["examen_cardiorespiratorio"]) && $consulta["HistoriaClinica"]["examen_cardiorespiratorio"] !== null ? $consulta["HistoriaClinica"]["examen_cardiorespiratorio"] : 'sin hallazgos'), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 9);
            $pdf->MultiCell(186, 4, "Genitales: " . utf8_decode(isset($consulta["HistoriaClinica"]["examen_genitales"]) && $consulta["HistoriaClinica"]["examen_genitales"] !== null ? $consulta["HistoriaClinica"]["examen_genitales"] : 'sin hallazgos'), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 9);
            $pdf->MultiCell(186, 4, "Extremidades: " . utf8_decode(isset($consulta["HistoriaClinica"]["examen_extremidades"]) && $consulta["HistoriaClinica"]["examen_extremidades"] !== null ? $consulta["HistoriaClinica"]["examen_extremidades"] : 'sin hallazgos'), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 9);
            $pdf->MultiCell(186, 4, "Piel y anexos: " . utf8_decode(isset($consulta["HistoriaClinica"]["piel_anexos"]) && $consulta["HistoriaClinica"]["piel_anexos"] !== null ? $consulta["HistoriaClinica"]["piel_anexos"] : 'sin hallazgos'), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 9);
            $pdf->MultiCell(186, 4, "Neurologico: " . utf8_decode(isset($consulta["HistoriaClinica"]["neurologico"]) && $consulta["HistoriaClinica"]["neurologico"] !== null ? $consulta["HistoriaClinica"]["neurologico"] : 'sin hallazgos'), 1, 'L', 0);

            $pdf->Ln();
            $pdf->Ln();

            $pdf->Ln();
        }

        $tipoHistoriaId = $consulta['cita']['tipo_historia_id'];
        $sexo = $consulta["afiliado"]["sexo"];
        $afiliadoId = $consulta["afiliado"]["id"];
        $peso = $consulta["HistoriaClinica"]["peso"];
        $altura = $consulta["HistoriaClinica"]["talla"];
        $imc = $consulta["HistoriaClinica"]["imc"];
        $perimetro_cefalico = $consulta["HistoriaClinica"]["perimetro_cefalico"];
        $fechaNacimiento = $consulta["afiliado"]["fecha_nacimiento"] ?? null;
        $graficasHistoria = false;
        $consultaId = $consulta->id;

        if ($fechaNacimiento) {
            $fechaNacimientoDate = new DateTime($fechaNacimiento);
            $hoy = new DateTime();

            $diferencia = $hoy->diff($fechaNacimientoDate);

            $edad_meses = ($diferencia->y * 12) + $diferencia->m;
            if($edad_meses >60 && $edad_meses <= 72){
                $edad_meses = 60;
            }
        } else {
            $edad_meses = 0;
        }
        $edad = $edad_meses;

        if ($edad == null) {
            $edad = 0;
        }

        // CONDICION EDADES Y TIPOS DE HISTORIA
        if ($edad < 205 && ($tipoHistoriaId == 5 || $tipoHistoriaId == 6 || $tipoHistoriaId == 7 )) {
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('GRÁFICAS DE MEDIDAS ANTROPOMÉTRICAS'), 1, 0, 'C', 1);
            $pdf->Ln();


            $datosGraficas = new Request([
                'sexo' => $sexo,
                'afiliadoId' => $afiliadoId,
                'peso' => $peso,
                'altura' => $altura,
                'imc' => $imc,
                'perimetro_cefalico' => $perimetro_cefalico,
                'fechaNacimiento' => $fechaNacimiento,
                'graficasHistoria' => $graficasHistoria,
                'edad' => $edad,
                'consultaId' => $consultaId
            ]);

            $funciones = [
                'generarGraficaPesoTalla',
                'generarGraficaTallaEdad',
                'generarGraficaPerimetroCefalico',
                'generarGraficaIMC',
                'generarGraficaPesoEdad'
            ];

            $graficaPesoTalla = app(\App\Http\Modules\GraficasOms\Services\GraficasOmsService::class);
            $resultadosGraficas = [];

            foreach ($funciones as $funcion) {
                $resultado = $graficaPesoTalla->$funcion($datosGraficas);
                $resultadosGraficas[$funcion] = $resultado;
            }
            $carpeta = 'graficasOms';
            $nombresImagenes = [
                'graficaPesoTalla.png',
                'graficaTallaEdad.png',
                'graficaPerimetroCefalico.png',
                'graficaIMC.png',
                'graficaPesoEdad.png',
            ];

            $espacioExtra = 5;
            $anchoImagen = 160;
            $altoImagen = 80;

            $pageHeight = $pdf->GetPageHeight();
            $bottomMargin = 10;
            $pageBreakTrigger = $pageHeight - $bottomMargin;

            foreach ($nombresImagenes as $index => $nombreImagen) {
                $imagePath = public_path($carpeta . '/' . $nombreImagen);

                if (file_exists($imagePath)) {
                    $yActual = $pdf->GetY() + $espacioExtra;

                    if ($yActual + $altoImagen > $pageBreakTrigger) {
                        $pdf->AddPage();
                        $yActual = $pdf->GetY();
                    }

                    $pdf->Image($imagePath, 10, $yActual, $anchoImagen, $altoImagen);
                    $pdf->SetY($yActual + $altoImagen + $espacioExtra);

                    $nombreFuncion = $funciones[$index] ?? null;

                    if ($nombreFuncion && isset($resultadosGraficas[$nombreFuncion])) {
                        foreach ($resultadosGraficas[$nombreFuncion] as $resultado) {
                            $fecha = $resultado['fecha'] ?? 'Sin fecha';
                            $clasificacion = $resultado['clasificacion'] ?? 'Sin clasificación';

                            $pdf->SetX(12);
                            $pdf->SetFont('Arial', '', 9);
                            $pdf->Cell(50, 4, "Fecha: " . utf8_decode($fecha), 1, 0, 'L', 0);
                            $pdf->Cell(133, 4, utf8_decode("Clasificación: " . $clasificacion), 1, 0, 'L', 0);
                            $pdf->Ln();
                        }
                    }
                }
            }
            foreach ($nombresImagenes as $nombreImagen) {
                $imagePath = public_path($carpeta . '/' . $nombreImagen);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            $pdf->Ln();
        }
    }
}
