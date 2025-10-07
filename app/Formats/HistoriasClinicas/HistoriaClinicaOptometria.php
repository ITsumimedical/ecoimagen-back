<?php

namespace App\Formats\HistoriasClinicas;

use App\Http\Modules\Historia\AntecedentesFamiliares\Models\AntecedenteFamiliare;
use App\Http\Modules\Historia\AntecedentesPersonales\Models\AntecedentePersonale;
use App\Http\Modules\ResultadoAyudasDiagnosticos\Model\ResultadoAyudasDiagnosticas;
use App\Http\Modules\RemisionProgramas\Model\RemisionProgramas;
use Codedge\Fpdf\Fpdf\Fpdf;
use DateTime;

class HistoriaClinicaOptometria extends Fpdf
{
    protected static $consulta;

    public function bodyOptometria($pdf, $consulta)
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
        $pdf->Cell(186, 4, utf8_decode('LENSOMETRIA'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetX(12);
        $pdf->Cell(186, 4, utf8_decode('OJO DERECHO'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->MultiCell(186, 4, utf8_decode("Descripción: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["lateralidad_od"]) && self::$consulta["HistoriaClinica"]["lateralidad_od"] !== null ? self::$consulta["HistoriaClinica"]["lateralidad_od"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->SetX(12);
        $pdf->Cell(46.5, 4, utf8_decode("ESF: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["esf_od"]) && self::$consulta["HistoriaClinica"]["esf_od"] !== null ? self::$consulta["HistoriaClinica"]["esf_od"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Cell(46.5, 4, utf8_decode("CYL: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["cyl_od"]) && self::$consulta["HistoriaClinica"]["cyl_od"] !== null ? self::$consulta["HistoriaClinica"]["cyl_od"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Cell(46.5, 4, utf8_decode("EJE: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["eje_od"]) && self::$consulta["HistoriaClinica"]["eje_od"] !== null ? self::$consulta["HistoriaClinica"]["eje_od"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Cell(46.5, 4, utf8_decode("ADD: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["add_od"]) && self::$consulta["HistoriaClinica"]["add_od"] !== null ? self::$consulta["HistoriaClinica"]["add_od"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetX(12);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->Cell(186, 4, utf8_decode('OJO IZQUIERDO'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->MultiCell(186, 4, utf8_decode("Descripción: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["lateralidad_oi"]) && self::$consulta["HistoriaClinica"]["lateralidad_oi"] !== null ? self::$consulta["HistoriaClinica"]["lateralidad_oi"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->SetX(12);
        $pdf->Cell(46.5, 4, utf8_decode("ESF: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["esf_oi"]) && self::$consulta["HistoriaClinica"]["esf_oi"] !== null ? self::$consulta["HistoriaClinica"]["esf_oi"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Cell(46.5, 4, utf8_decode("CYL: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["cyl_oi"]) && self::$consulta["HistoriaClinica"]["cyl_oi"] !== null ? self::$consulta["HistoriaClinica"]["cyl_oi"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Cell(46.5, 4, utf8_decode("EJE: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["eje_oi"]) && self::$consulta["HistoriaClinica"]["eje_oi"] !== null ? self::$consulta["HistoriaClinica"]["eje_oi"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Cell(46.5, 4, utf8_decode("ADD: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["add_oi"]) && self::$consulta["HistoriaClinica"]["add_oi"] !== null ? self::$consulta["HistoriaClinica"]["add_oi"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Ln();
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->Cell(186, 4, utf8_decode('AGUDEZA VISUAL'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $checkboxsc = 'No Refiere';
        if (isset(self::$consulta["HistoriaClinica"])) {
            $checkboxsc = self::$consulta["HistoriaClinica"]["checkboxsc"] ?? 'No Refiere';
        }
        $texto_completo = "SC: " . $checkboxsc;
        $pdf->MultiCell(186, 4, utf8_decode($texto_completo), 1, "L", 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $checkboxcc = 'No Refiere';
        if (isset(self::$consulta["HistoriaClinica"])) {
            $checkboxcc = self::$consulta["HistoriaClinica"]["checkboxcc"] ?? 'No Refiere';
        }
        $texto_completo = "CC: " . $checkboxcc;
        $pdf->MultiCell(186, 4, utf8_decode($texto_completo), 1, "L", 0);



        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(186, 4, utf8_decode('VL'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetX(12);
        $pdf->Cell(186, 4, utf8_decode('OJO DERECHO'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->MultiCell(186, 4, utf8_decode("Descripción: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["agudeza_od"]) && self::$consulta["HistoriaClinica"]["agudeza_od"] !== null ? self::$consulta["HistoriaClinica"]["agudeza_od"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->SetX(12);
        $pdf->Cell(186, 4, utf8_decode("VP: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["agudezavp_od"]) && self::$consulta["HistoriaClinica"]["agudezavp_od"] !== null ? self::$consulta["HistoriaClinica"]["agudezavp_od"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetX(12);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->Cell(186, 4, utf8_decode('OJO IZQUIERDO'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->MultiCell(186, 4, utf8_decode("Descripción: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["agudeza_oi"]) && self::$consulta["HistoriaClinica"]["agudeza_oi"] !== null ? self::$consulta["HistoriaClinica"]["agudeza_oi"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->SetX(12);
        $pdf->Cell(186, 4, utf8_decode("VP: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["agudezavp_oi"]) && self::$consulta["HistoriaClinica"]["agudezavp_oi"] !== null ? self::$consulta["HistoriaClinica"]["agudezavp_oi"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Ln();
        $pdf->Ln();



        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->Cell(186, 4, utf8_decode('MOTILIDAD OCULAR'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetX(12);
        $pdf->Cell(186, 4, utf8_decode("VL: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["ocular_vl"]) && self::$consulta["HistoriaClinica"]["ocular_vl"] !== null ? self::$consulta["HistoriaClinica"]["ocular_vl"] : 'sin hallazgos'), 1, 1, 'L');
        $pdf->SetX(12);
        $pdf->Cell(186, 4, utf8_decode("VP: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["ocular_vp"]) && self::$consulta["HistoriaClinica"]["ocular_vp"] !== null ? self::$consulta["HistoriaClinica"]["ocular_vp"] : 'sin hallazgos'), 1, 1, 'L');
        $pdf->SetX(12);
        $pdf->Cell(186, 4, utf8_decode("PPC: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["ocular_ppc"]) && self::$consulta["HistoriaClinica"]["ocular_ppc"] !== null ? self::$consulta["HistoriaClinica"]["ocular_ppc"] : 'sin hallazgos'), 1, 1, 'L');
        $pdf->Ln();



        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(186, 4, utf8_decode('BIOMICROSCOPIA'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $biomicroscopiaod = 'No Refiere';
        if (isset(self::$consulta["HistoriaClinica"])) {
            $biomicroscopiaod = self::$consulta["HistoriaClinica"]["biomicroscopiaod"] ?? 'No Refiere';
        }
        $texto_completo = "Ojo derecho: " . $biomicroscopiaod;
        $pdf->MultiCell(186, 4, utf8_decode($texto_completo), 1, "L", 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $biomicroscopiaoi = 'No Refiere';
        if (isset(self::$consulta["HistoriaClinica"])) {
            $biomicroscopiaoi = self::$consulta["HistoriaClinica"]["biomicroscopiaoi"] ?? 'No Refiere';
        }
        $texto_completo = "Ojo izquierdo: " . $biomicroscopiaoi;
        $pdf->MultiCell(186, 4, utf8_decode($texto_completo), 1, "L", 0);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(186, 4, utf8_decode('PIO'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $piood = 'No Refiere';
        if (isset(self::$consulta["HistoriaClinica"])) {
            $piood = self::$consulta["HistoriaClinica"]["piood"] ?? 'No Refiere';
        }
        $texto_completo = "Ojo derecho: " . $piood;
        $pdf->MultiCell(186, 4, utf8_decode($texto_completo), 1, "L", 0);


        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $piooi = 'No Refiere';
        if (isset(self::$consulta["HistoriaClinica"])) {
            $piooi = self::$consulta["HistoriaClinica"]["piooi"] ?? 'No Refiere';
        }
        $texto_completo = "Ojo izquierdo: " . $piooi;
        $pdf->MultiCell(186, 4, utf8_decode($texto_completo), 1, "L", 0);
        $pdf->Ln();


        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(186, 4, utf8_decode('OFTALMOSCOPIA'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);


        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $oftalmoscopiaod = 'No Refiere';
        if (isset(self::$consulta["HistoriaClinica"])) {
            $oftalmoscopiaod = self::$consulta["HistoriaClinica"]["oftalmoscopiaod"] ?? 'No Refiere';
        }
        $texto_completo = "Ojo derecho: " . $oftalmoscopiaod;
        $pdf->MultiCell(186, 4, utf8_decode($texto_completo), 1, "L", 0);


        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $queratometria_od = 'No Refiere';
        if (isset(self::$consulta["HistoriaClinica"])) {
            $oftalmoscopiaoi = self::$consulta["HistoriaClinica"]["oftalmoscopiaoi"] ?? 'No Refiere';
        }
        $texto_completo = "Ojo izquierdo: " . $oftalmoscopiaoi;
        $pdf->MultiCell(186, 4, utf8_decode($texto_completo), 1, "L", 0);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(186, 4, utf8_decode('QUERATOMETRIA'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $queratometria_od = 'No Refiere';
        if (isset(self::$consulta["HistoriaClinica"])) {
            $queratometria_od = self::$consulta["HistoriaClinica"]["queratometria_od"] ?? 'No Refiere';
        }
        $texto_completo = "Ojo derecho: " . $queratometria_od;
        $pdf->MultiCell(186, 4, utf8_decode($texto_completo), 1, "L", 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $queratometria_oi = 'No Refiere';
        if (isset(self::$consulta["HistoriaClinica"])) {
            $queratometria_oi = self::$consulta["HistoriaClinica"]["queratometria_oi"] ?? 'No Refiere';
        }
        $texto_completo = "Ojo izquierdo: " . $queratometria_oi;
        $pdf->MultiCell(186, 4, utf8_decode($texto_completo), 1, "L", 0);
        $pdf->Ln();


        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(186, 4, utf8_decode('REFRACCION'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $refraccion_od = 'No Refiere';
        if (isset(self::$consulta["HistoriaClinica"])) {
            $refraccion_od = self::$consulta["HistoriaClinica"]["refraccion_od"] ?? 'No Refiere';
        }
        $texto_completo = "OD: " . $refraccion_od;
        $pdf->MultiCell(186, 4, utf8_decode($texto_completo), 1, "L", 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $refraccionav_od = 'No Refiere';
        if (isset(self::$consulta["HistoriaClinica"])) {
            $refraccionav_od = self::$consulta["HistoriaClinica"]["refraccionav_od"] ?? 'No Refiere';
        }
        $texto_completo = "AV: " . $refraccionav_od;
        $pdf->MultiCell(186, 4, utf8_decode($texto_completo), 1, "L", 0);


        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $refraccion_oi = 'No Refiere';
        if (isset(self::$consulta["HistoriaClinica"])) {
            $refraccion_oi = self::$consulta["HistoriaClinica"]["refraccion_oi"] ?? 'No Refiere';
        }
        $texto_completo = "OI: " . $refraccion_oi;
        $pdf->MultiCell(186, 4, utf8_decode($texto_completo), 1, "L", 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $refraccionav_oi = 'No Refiere';
        if (isset(self::$consulta["HistoriaClinica"])) {
            $refraccionav_oi = self::$consulta["HistoriaClinica"]["refraccionav_oi"] ?? 'No Refiere';
        }
        $texto_completo = "AV: " . $refraccionav_oi;
        $pdf->MultiCell(186, 4, utf8_decode($texto_completo), 1, "L", 0);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(186, 4, utf8_decode('SUBJETIVO'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $subjetivo_od = 'No Refiere';
        if (isset(self::$consulta["HistoriaClinica"])) {
            $subjetivo_od = self::$consulta["HistoriaClinica"]["subjetivo_od"] ?? 'No Refiere';
        }
        $texto_completo = "OD: " . $subjetivo_od;
        $pdf->MultiCell(186, 4, utf8_decode($texto_completo), 1, "L", 0);


        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $subjetivoav_od = 'No Refiere';
        if (isset(self::$consulta["HistoriaClinica"])) {
            $subjetivoav_od = self::$consulta["HistoriaClinica"]["subjetivoav_od"] ?? 'No Refiere';
        }
        $texto_completo = "AV: " . $subjetivoav_od;
        $pdf->MultiCell(186, 4, utf8_decode($texto_completo), 1, "L", 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $subjetivo_oi = 'No Refiere';
        if (isset(self::$consulta["HistoriaClinica"])) {
            $subjetivo_oi = self::$consulta["HistoriaClinica"]["subjetivo_oi"] ?? 'No Refiere';
        }
        $texto_completo = "OI: " . $subjetivo_oi;
        $pdf->MultiCell(186, 4, utf8_decode($texto_completo), 1, "L", 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $subjetivoav_oi = 'No Refiere';
        if (isset(self::$consulta["HistoriaClinica"])) {
            $subjetivoav_oi = self::$consulta["HistoriaClinica"]["subjetivoav_oi"] ?? 'No Refiere';
        }
        $texto_completo = "AV: " . $subjetivoav_oi;
        $pdf->MultiCell(186, 4, utf8_decode($texto_completo), 1, "L", 0);
        $pdf->Ln();


        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('RX FINAL'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Ln();

        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetX(12);
        $pdf->Cell(20.6, 4, utf8_decode('Ojo derecho'), 1, 1, 'C', 1);

        $pdf->SetY($pdf->GetY() - 8);
        $pdf->SetX(32.6);
        $pdf->Cell(20.6, 4, utf8_decode('Esfera'), 1, 1, 'C', 1);
        $pdf->SetX(32.6);
        $pdf->Cell(20.6, 4, utf8_decode(isset(self::$consulta["rxFinal"]["esfera_ojo_derecho"]) && self::$consulta["rxFinal"]["esfera_ojo_derecho"] !== null ? self::$consulta["rxFinal"]["esfera_ojo_derecho"] : 'sin hallazgos'), 1, 1, 'L');

        $pdf->SetY($pdf->GetY() - 8);
        $pdf->SetX(53.2);
        $pdf->Cell(20.6, 4, utf8_decode('Cilindro'), 1, 1, 'C', 1);
        $pdf->SetX(53.2);
        $pdf->Cell(20.6, 4, utf8_decode(isset(self::$consulta["rxFinal"]["cilindro_ojo_derecho"]) && self::$consulta["rxFinal"]["cilindro_ojo_derecho"] !== null ? self::$consulta["rxFinal"]["cilindro_ojo_derecho"] : 'sin hallazgos'), 1, 1, 'L');

        $pdf->SetY($pdf->GetY() - 8);
        $pdf->SetX(73.8);
        $pdf->Cell(20.6, 4, utf8_decode('Eje'), 1, 1, 'C', 1);
        $pdf->SetX(73.8);
        $pdf->Cell(20.6, 4, utf8_decode(isset(self::$consulta["rxFinal"]["eje_ojo_derecho"]) && self::$consulta["rxFinal"]["eje_ojo_derecho"] !== null ? self::$consulta["rxFinal"]["eje_ojo_derecho"] : 'sin hallazgos'), 1, 1, 'L');

        $pdf->SetY($pdf->GetY() - 8);
        $pdf->SetX(94.4);
        $pdf->Cell(20.6, 4, utf8_decode('Adicion'), 1, 1, 'C', 1);
        $pdf->SetX(94.4);
        $pdf->Cell(20.6, 4, utf8_decode(isset(self::$consulta["rxFinal"]["add_ojo_derecho"]) && self::$consulta["rxFinal"]["add_ojo_derecho"] !== null ? self::$consulta["rxFinal"]["add_ojo_derecho"] : 'sin hallazgos'), 1, 1, 'L');

        $pdf->SetY($pdf->GetY() - 8);
        $pdf->SetX(115);
        $pdf->Cell(20.6, 4, utf8_decode('Prisma base'), 1, 1, 'C', 1);
        $pdf->SetX(115);
        $pdf->Cell(20.6, 4, utf8_decode(isset(self::$consulta["rxFinal"]["prima_base_ojo_derecho"]) && self::$consulta["rxFinal"]["prima_base_ojo_derecho"] !== null ? self::$consulta["rxFinal"]["prima_base_ojo_derecho"] : 'sin hallazgos'), 1, 1, 'L');

        $pdf->SetY($pdf->GetY() - 8);
        $pdf->SetX(135.6);
        $pdf->Cell(20.6, 4, utf8_decode('Grados'), 1, 1, 'C', 1);
        $pdf->SetX(135.6);
        $pdf->Cell(20.6, 4, utf8_decode(isset(self::$consulta["rxFinal"]["grados_ojo_derecho"]) && self::$consulta["rxFinal"]["grados_ojo_derecho"] !== null ? self::$consulta["rxFinal"]["grados_ojo_derecho"] : 'sin hallazgos'), 1, 1, 'L');


        $pdf->SetY($pdf->GetY() - 8);
        $pdf->SetX(156.2);
        $pdf->Cell(20.6, 4, utf8_decode('AV/Lejos'), 1, 1, 'C', 1);
        $pdf->SetX(156.2);
        $pdf->Cell(20.6, 4, utf8_decode(isset(self::$consulta["rxFinal"]["av_lejos_ojo_derecho"]) && self::$consulta["rxFinal"]["av_lejos_ojo_derecho"] !== null ? self::$consulta["rxFinal"]["av_lejos_ojo_derecho"] : 'sin hallazgos'), 1, 1, 'L');

        $pdf->SetY($pdf->GetY() - 8);
        $pdf->SetX(176.8);
        $pdf->Cell(20.6, 4, utf8_decode('AV/Cerca'), 1, 1, 'C', 1);
        $pdf->SetX(176.8);
        $pdf->Cell(20.6, 4, utf8_decode(isset(self::$consulta["rxFinal"]["av_cerca_ojo_derecho"]) && self::$consulta["rxFinal"]["av_cerca_ojo_derecho"] !== null ? self::$consulta["rxFinal"]["av_cerca_ojo_derecho"] : 'sin hallazgos'), 1, 1, 'L');


        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetX(12);
        $pdf->Cell(20.6, 4, utf8_decode('Ojo izquierdo'), 1, 0, 'C', 1);

        $pdf->SetX(32.6);
        $pdf->Cell(20.6, 4, utf8_decode(isset(self::$consulta["rxFinal"]["esfera_ojo_izquierdo"]) && self::$consulta["rxFinal"]["esfera_ojo_izquierdo"] !== null ? self::$consulta["rxFinal"]["esfera_ojo_izquierdo"] : 'sin hallazgos'), 1, 0, 'L');

        $pdf->SetX(53.2);
        $pdf->Cell(20.6, 4, utf8_decode(isset(self::$consulta["rxFinal"]["cilindro_ojo_izquierdo"]) && self::$consulta["rxFinal"]["cilindro_ojo_izquierdo"] !== null ? self::$consulta["rxFinal"]["cilindro_ojo_izquierdo"] : 'sin hallazgos'), 1, 0, 'L');

        $pdf->SetX(73.8);
        $pdf->Cell(20.6, 4, utf8_decode(isset(self::$consulta["rxFinal"]["eje_ojo_izquierdo"]) && self::$consulta["rxFinal"]["eje_ojo_izquierdo"] !== null ? self::$consulta["rxFinal"]["eje_ojo_izquierdo"] : 'sin hallazgos'), 1, 0, 'L');

        $pdf->SetX(94.4);
        $pdf->Cell(20.6, 4, utf8_decode(isset(self::$consulta["rxFinal"]["add_ojo_izquierdo"]) && self::$consulta["rxFinal"]["add_ojo_izquierdo"] !== null ? self::$consulta["rxFinal"]["add_ojo_izquierdo"] : 'sin hallazgos'), 1, 0, 'L');

        $pdf->SetX(115);
        $pdf->Cell(20.6, 4, utf8_decode(isset(self::$consulta["rxFinal"]["prima_base_ojo_izquierdo"]) && self::$consulta["rxFinal"]["prima_base_ojo_izquierdo"] !== null ? self::$consulta["rxFinal"]["prima_base_ojo_izquierdo"] : 'sin hallazgos'), 1, 0, 'L');

        $pdf->SetX(135.6);
        $pdf->Cell(20.6, 4, utf8_decode(isset(self::$consulta["rxFinal"]["grados_ojo_izquierdo"]) && self::$consulta["rxFinal"]["grados_ojo_izquierdo"] !== null ? self::$consulta["rxFinal"]["grados_ojo_izquierdo"] : 'sin hallazgos'), 1, 0, 'L');

        $pdf->SetX(156.2);
        $pdf->Cell(20.6, 4, utf8_decode(isset(self::$consulta["rxFinal"]["av_lejos_ojo_izquierdo"]) && self::$consulta["rxFinal"]["av_lejos_ojo_izquierdo"] !== null ? self::$consulta["rxFinal"]["av_lejos_ojo_izquierdo"] : 'sin hallazgos'), 1, 0, 'L');

        $pdf->SetX(176.8);
        $pdf->Cell(20.6, 4, utf8_decode(isset(self::$consulta["rxFinal"]["av_cerca_ojo_izquierdo"]) && self::$consulta["rxFinal"]["av_cerca_ojo_izquierdo"] !== null ? self::$consulta["rxFinal"]["av_cerca_ojo_izquierdo"] : 'sin hallazgos'), 1, 0, 'L');

        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetX(12);
        $pdf->Cell(20.6, 4, utf8_decode('Tipo Lentes:'), 1, 0, 'C', 1);
        $pdf->Cell(165.4, 4, utf8_decode(isset(self::$consulta["rxFinal"]["tipo_lentes"]) && self::$consulta["rxFinal"]["tipo_lentes"] !== null ? self::$consulta["rxFinal"]["tipo_lentes"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Ln();

        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetX(12);
        $pdf->Cell(20.6, 4, utf8_decode('Detalle:'), 1, 0, 'C', 1);
        $pdf->Cell(165.4, 4, utf8_decode(isset(self::$consulta["rxFinal"]["detalle"]) && self::$consulta["rxFinal"]["detalle"] !== null ? self::$consulta["rxFinal"]["detalle"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Ln();


        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetX(12);
        $pdf->Cell(20.6, 4, utf8_decode('Altura:'), 1, 0, 'C', 1);
        $pdf->Cell(165.4, 4, utf8_decode(isset(self::$consulta["rxFinal"]["altura"]) && self::$consulta["rxFinal"]["altura"] !== null ? self::$consulta["rxFinal"]["altura"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Ln();

        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetX(12);
        $pdf->Cell(20.6, 4, utf8_decode('Color y Ttos:'), 1, 0, 'C', 1);
        $pdf->Cell(165.4, 4, utf8_decode(isset(self::$consulta["rxFinal"]["color_ttos"]) && self::$consulta["rxFinal"]["color_ttos"] !== null ? self::$consulta["rxFinal"]["color_ttos"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Ln();

        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetX(12);
        $pdf->Cell(20.6, 4, utf8_decode('Dp:'), 1, 0, 'C', 1);
        $pdf->Cell(165.4, 4, utf8_decode(isset(self::$consulta["rxFinal"]["dp"]) && self::$consulta["rxFinal"]["dp"] !== null ? self::$consulta["rxFinal"]["dp"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Ln();

        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetX(12);
        $pdf->Cell(20.6, 4, utf8_decode('Uso:'), 1, 0, 'C', 1);
        $pdf->Cell(165.4, 4, utf8_decode(isset(self::$consulta["rxFinal"]["uso"]) && self::$consulta["rxFinal"]["uso"] !== null ? self::$consulta["rxFinal"]["uso"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Ln();

        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetX(12);
        $pdf->Cell(20.6, 4, utf8_decode('Control:'), 1, 0, 'C', 1);
        $pdf->Cell(165.4, 4, utf8_decode(isset(self::$consulta["rxFinal"]["control"]) && self::$consulta["rxFinal"]["control"] !== null ? self::$consulta["rxFinal"]["control"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Ln();

        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetX(12);
        $pdf->Cell(40.6, 4, utf8_decode('Duración y vigencia:'), 1, 0, 'C', 1);
        $pdf->Cell(145.4, 4, utf8_decode(isset(self::$consulta["rxFinal"]["duracion_vigencia"]) && self::$consulta["rxFinal"]["duracion_vigencia"] !== null ? self::$consulta["rxFinal"]["duracion_vigencia"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Ln();
        $pdf->Ln();

        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetX(12);
        $pdf->Cell(186, 4, utf8_decode('Observaciones:'), 1, 1, 'C', 1);
        $pdf->SetX(12);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->MultiCell(186, 4, utf8_decode(isset(self::$consulta["rxFinal"]["observaciones"]) && self::$consulta["rxFinal"]["observaciones"] !== null ? self::$consulta["rxFinal"]["observaciones"] : 'sin hallazgos'), 1, 0, 'L');



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
