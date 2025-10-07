<?php

namespace App\Formats\HistoriasClinicas;

use App\Http\Modules\Historia\AntecedentesFamiliares\Models\AntecedenteFamiliare;
use App\Http\Modules\Historia\AntecedentesFarmacologicos\Models\AntecedentesFarmacologico;
use App\Http\Modules\Historia\AntecedentesGinecologicos\CupGinecologico;
use App\Http\Modules\Historia\AntecedentesGinecologicos\CupMamografia;
use App\Http\Modules\Historia\AntecedentesHospitalarios\Models\AntecedentesHospitalario;
use App\Http\Modules\Historia\AntecedentesPersonales\Models\AntecedentePersonale;
use App\Http\Modules\Historia\AntecedentesQuirurgicos\Models\AntecedenteQuirurgico;
use App\Http\Modules\Historia\AntecedentesTransfusionales\Models\AntecedenteTransfusionale;
use App\Http\Modules\Historia\Vacunacion\Models\Vacuna;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Http\Modules\Historia\ResultadoLaboratorio\Models\ResultadoLaboratorio;
use App\Http\Modules\ResultadoAyudasDiagnosticos\Model\ResultadoAyudasDiagnosticas;
use App\Http\Modules\RemisionProgramas\Model\RemisionProgramas;
use Illuminate\Support\Facades\DB;

use DateTime;
use Illuminate\Support\Facades\Storage;

class HistoriaClinicaVejez extends Fpdf
{
    protected static $consulta;

    public function bodyHcVejez($pdf, $consulta)
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


        // Imprimir ayudas diagnósticas
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

        if ($historiaClinica && !empty($historiaClinica['resultado_ayuda_diagnostica'])) {
            $resultados[] = [
                'ayuda_diagnostica' => $historiaClinica['cup']['nombre'] ?? 'No especificado',
                'observaciones' => $historiaClinica['resultado_ayuda_diagnostica'],
                'registrado_por' => self::$consulta["medicoOrdena"]["operador"]["nombre_completo"] ?? 'No Refiere',
            ];
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
                $pdf->SetFont('Arial', '', 8);

                // Ayuda Diagnóstica
                if (!empty($resultado['ayuda_diagnostica'])) {
                    $pdf->SetX(12);
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



        $afiliadoId = $consulta->afiliado_id;
        $resultadosLaboratorio = ResultadoLaboratorio::whereHas('consulta', function ($query) use ($afiliadoId) {
            $query->where('afiliado_id', $afiliadoId);
        })->with(['user.operador'])
            ->when(empty($consulta["HistoriaClinica"]["imprimir_resultados_laboratorios"]), function ($query) use ($consulta) {
                $query->where('consulta_id', $consulta->id);
            })
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
        $pdf->Cell(186, 4, utf8_decode('ANTECEDENTES FAMILIARES'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 8);

        $noTieneAntecedentes = $antecedentesFamiliares->every(function ($familiares) {
            return $familiares->no_tiene_antecedentes;
        });

        if ($noTieneAntecedentes) {
            // Si no hay antecedentes familiares, mostrar mensaje
            $pdf->SetX(12);
            $pdf->Cell(186, 4, utf8_decode('No refiere antecedentes familiares'), 1, 0, 'L');
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
                $detalle = utf8_decode('FECHA: ' . $fecha . ' | FALLECIDO: ' . $fallecio . ' | REGISTRADO POR: ' . $nombreCompletoMedico);

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


        $afiliadoId = self::$consulta->afiliado_id;
        $antecedentesVacunales = Vacuna::with('consulta.medicoOrdena.operador')
            ->whereHas('consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId);
            })->get();


        // Imprimir encabezado de antecedentes vacunales
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('ANTECEDENTES VACUNALES'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 8);

        // Verificar si todos los antecedentes vacunales indican "No refiere antecedentes vacunales"
        $noTieneAntecedentesVacunales = $antecedentesVacunales->every(function ($vacuna) {
            return $vacuna->no_tiene_antecedente === 'No refiere antecedentes vacunales';
        });

        if ($noTieneAntecedentesVacunales) {
            // Si no hay antecedentes vacunales, mostrar mensaje
            $pdf->SetX(12);
            $pdf->Cell(186, 4, utf8_decode('No refiere antecedentes vacunales'), 1, 0, 'L');

            $pdf->Ln();
        } else {
            foreach ($antecedentesVacunales as $vacuna) {
                if ($vacuna->no_tiene_antecedente === 'No refiere antecedentes vacunales') {
                    continue; // Si el antecedente tiene no_tiene_antecedentes como true, no se muestra
                }

                $pdf->SetX(12);
                // $pdf->SetFont('Arial', 'B', 8);
                // $pdf->Cell(186, 4, utf8_decode('Registro ' . $contador), 1, 0, 'L', 1);
                // $pdf->Ln();

                $pdf->SetFont('Arial', '', 8);

                // Laboratorio
                $laboratorio = utf8_decode($vacuna->laboratorio ?? 'No especificado');
                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode('LABORATORIO: ' . $laboratorio), 1, 'L');

                // Médico que ordenó
                $nombreCompletoMedico = ($vacuna->consulta && $vacuna->consulta->medicoOrdena && $vacuna->consulta->medicoOrdena->operador)
                    ? utf8_decode($vacuna->consulta->medicoOrdena->operador->nombre . ' ' . $vacuna->consulta->medicoOrdena->operador->apellido)
                    : utf8_decode('No especificado');

                // Fecha de dosis
                $fechaDosis = utf8_decode($vacuna->fecha_dosis ?? 'No especificada');

                // Nombre de la vacuna
                $vacunaNombre = utf8_decode($vacuna->vacuna ?? 'No especificada');

                // Dosis
                $dosis = utf8_decode($vacuna->dosis ?? 'No especificada');

                // Concatenar los tres campos
                $detalleVacuna = utf8_decode('VACUNA: ' . $vacunaNombre . ' | DOSIS: ' . $dosis . ' | FECHA DE DOSIS: ' . $fechaDosis . ' | REGISTRADO POR: ' . $nombreCompletoMedico);

                // Imprimir el texto concatenado
                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, $detalleVacuna, 1, 'L');

                $pdf->Ln(2);
            }

            if ($antecedentesVacunales->isEmpty()) {
                $pdf->SetX(12);
                $pdf->Cell(186, 6, utf8_decode('No refiere antecedentes vacunales.'), 1, 0, 'L');
                $pdf->Ln();
            }
        }

        $pdf->Ln();


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

                $detalleQuirurgico = utf8_decode('EDAD: ' . $edad . ' | REGISTRADO POR: ' . $nombreCompletoMedico);

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

        $afiliadoId = self::$consulta->afiliado_id;
        $antecedentesHospitalarios = AntecedentesHospitalario::whereHas('consulta', function ($query) use ($afiliadoId) {
            $query->where('afiliado_id', $afiliadoId)
                ->whereNotNull(['hospitalizacion_uci', 'hospitalizacion_ultimo_anio']);
        })->get();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('ANTECEDENTES HOSPITALARIOS'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 7);

        if ($antecedentesHospitalarios->isEmpty()) {
            $pdf->SetX(12);
            $pdf->Cell(186, 4, utf8_decode('No refiere'), 1, 0, 'L');
            $pdf->Ln();
        } else {
            $contador = 1;

            foreach ($antecedentesHospitalarios as $antecedente) {
                $pdf->SetX(12);
                $pdf->Cell(186, 6, utf8_decode('Registro #' . $contador), 1, 0, 'L', 1);
                $pdf->Ln();

                $pdf->SetX(12);
                $pdf->Cell(62, 6, utf8_decode('Hospitalización último año: ' . ($antecedente->hospitalizacion_ultimo_anio ?? 'No Evaluado')), 1);
                if ($antecedente->hospitalizacion_ultimo_anio == 'Si') {
                    $pdf->Cell(62, 6, utf8_decode('Cuántas hospitalizaciones ha tenido: ' . ($antecedente->cantidad_hospitalizaciones ?? 'No Evaluado')), 1);
                    $pdf->Cell(62, 6, utf8_decode('Fecha: ' . ($antecedente->fecha_ultimas_hospitalizaciones ?? 'No Evaluado')), 1);
                }
                if ($antecedente->hospitalizacion_ultimo_anio == 'Si') {
                    $pdf->Ln();
                    $pdf->SetX(12);
                    $pdf->MultiCell(186, 6, utf8_decode('Descripción hospitalización: ' . ($antecedente->descripcion_hospiurg ?? 'No Evaluado')), 1);
                }
                $pdf->SetX(12);

                $pdf->Cell(93, 6, utf8_decode('Hospitalización en UCI: ' . ($antecedente->hospitalizacion_uci ?? 'No Evaluado')), 1);
                if ($antecedente->hospitalizacion_uci == 'Si') {
                    $pdf->Cell(93, 6, utf8_decode('Fecha de hospitalización en UCI: ' . ($antecedente->fecha_hospitalizacion_uci_ultimo_ano ?? 'No Evaluado')), 1);
                }
                if ($antecedente->hospitalizacion_uci == 'Si') {
                    $pdf->Ln();
                    $pdf->SetX(12);
                    $pdf->MultiCell(186, 6, utf8_decode('Descripción hospitalización UCI: ' . ($antecedente->descripcion_hospi_uci ?? 'No Evaluado')), 1);
                }
                $contador++;
            }
        }
        $pdf->Ln();



        //Imprimir los ginecobtstetricos en caso de que sea mujer
        if (self::$consulta["afiliado"]["sexo"] == 'F' && self::$consulta["afiliado"]["edad_cumplida"] >= 13 && self::$consulta["afiliado"]["edad_cumplida"] <= 50) {
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

            $presenteMenarquia = isset(self::$consulta["HistoriaClinica"]["presente_menarquia"]) ? self::$consulta["HistoriaClinica"]["presente_menarquia"] : 'No Evaluado';
            $pdf->SetX(12);
            $pdf->Cell(186, 6, utf8_decode('Menarquia: ' . $presenteMenarquia), 1, 0, 'L');
            $pdf->Ln();
            if ($presenteMenarquia === 'Si') {
                $edadMenarquia = isset(self::$consulta["HistoriaClinica"]["edad"]) ? self::$consulta["HistoriaClinica"]["edad"] : 'No especificado';
                $textoAntecedentesGineco = "Menarquia: " . $presenteMenarquia . " (Edad: " . $edadMenarquia . ")";
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
                $pdf->Cell(46.5, 6, utf8_decode('Clasificación:' . (isset(self::$consulta["HistoriaClinica"]["clasificacion_ciclos"]) ? (self::$consulta["HistoriaClinica"]["clasificacion_ciclos"]) : 'No Evaluado')), 1);
                $pdf->Cell(46.5, 6, utf8_decode('Frecuencia:' . (isset(self::$consulta["HistoriaClinica"]["frecuencia_ciclos"]) ? (self::$consulta["HistoriaClinica"]["frecuencia_ciclos"]) : 'No Evaluado')), 1);
                $pdf->Cell(38.5, 6, utf8_decode('Duración: ' . (isset(self::$consulta["HistoriaClinica"]["frecuencia_ciclos"]) ? self::$consulta["HistoriaClinica"]["frecuencia_ciclos"] : 'No Evaluado')), 1);
                $pdf->Cell(54.5, 6, utf8_decode('Fecha última menstruación:' . utf8_decode(isset(self::$consulta["HistoriaClinica"]["fecha_ultima_menstruacion"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["fecha_ultima_menstruacion"]) : 'No Evaluado')), 1);
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->Cell(60.5, 6, utf8_decode('Infecciones de transmisión sexual:' . (isset(self::$consulta["HistoriaClinica"]["presente_transmisionsexual"]) ? (self::$consulta["HistoriaClinica"]["presente_transmisionsexual"]) : 'No Evaluado')), 1);
                $pdf->Cell(46.5, 6, utf8_decode('Edad primera relación sexual:' . (isset(self::$consulta["HistoriaClinica"]["edad_primera"]) ? (self::$consulta["HistoriaClinica"]["edad_primera"]) : 'No Evaluado')), 1);
                $pdf->Ln();
                $pdf->SetX(12);
                if (self::$consulta["HistoriaClinica"]["presente_transmisionsexual"] == 'Si') {
                    $pdf->MultiCell(186, 6, utf8_decode('Descripción ITS:' . (isset(self::$consulta["HistoriaClinica"]["descripcion_transmision_sexual"]) ? (self::$consulta["HistoriaClinica"]["descripcion_transmision_sexual"]) : 'No Evaluado')), 1);
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
                $pdf->Cell(46.5, 6, utf8_decode('Presente:' . (isset(self::$consulta["HistoriaClinica"]["presente_metodo_anticonceptivo"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["presente_metodo_anticonceptivo"]) : 'No Evaluado')), 1);
                $pdf->Cell(46.5, 6, utf8_decode('Descripción:' . (isset(self::$consulta["HistoriaClinica"]["descripcion_metodo_anticonceptivo"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["descripcion_metodo_anticonceptivo"]) : 'No Evaluado')), 1);
                $pdf->Cell(46.5, 6, utf8_decode('Tipo:' . (isset(self::$consulta["HistoriaClinica"]["tipo_metodo_anticonceptivo"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["tipo_metodo_anticonceptivo"]) : 'No Evaluado')), 1);
                $pdf->Cell(46.5, 6, utf8_decode('Tratamiento:' . (isset(self::$consulta["HistoriaClinica"]["tratamiento_metodo_anticonceptivo"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["tratamiento_metodo_anticonceptivo"]) : 'No Evaluado')), 1);
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->Cell(46.5, 6, utf8_decode('Fecha de diagnóstico:' . (isset(self::$consulta["HistoriaClinica"]["fecha_metodo_anticonceptivo"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["fecha_metodo_anticonceptivo"]) : 'No Evaluado')), 1);
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
                $pdf->Cell(93, 6, utf8_decode('Procedimientos en el cuello uterino:' . (isset(self::$consulta["HistoriaClinica"]["presente_procedimiento_cuello_uterino"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["presente_procedimiento_cuello_uterino"]) : 'No Evaluado')), 1);
                if (isset(self::$consulta["HistoriaClinica"]["presente_procedimiento_cuello_uterino"]) == 'Si') {
                    $pdf->Cell(93, 6, utf8_decode('Tratamiento en el cuello uterino:' . (isset(self::$consulta["HistoriaClinica"]["tratamiento_procedimiento_cuello_uterino"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["tratamiento_procedimiento_cuello_uterino"]) : 'No Evaluado')), 1);
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
                $pdf->Cell(93, 6, utf8_decode('¿Planea embarazo antes de 1 año?:' . (isset(self::$consulta["HistoriaClinica"]["planea_embarazo"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["planea_embarazo"]) : 'No Evaluado')), 1);
                if (isset(self::$consulta["HistoriaClinica"]["fecha_ultimo_parto"]) && self::$consulta["HistoriaClinica"]["fecha_ultimo_parto"] !== null) {
                    $pdf->Cell(46.5, 6, utf8_decode('Fecha de último parto: ' . utf8_decode(self::$consulta["HistoriaClinica"]["fecha_ultimo_parto"])), 1);
                    $pdf->Cell(46.5, 6, utf8_decode('Gestas:' . (isset(self::$consulta["HistoriaClinica"]["gesta"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["gesta"]) : 'No Evaluado')), 1);
                    $pdf->Ln();
                    $pdf->SetX(12);
                    $pdf->Cell(46.5, 6, utf8_decode('Partos:' . (isset(self::$consulta["HistoriaClinica"]["parto"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["parto"]) : 'No Evaluado')), 1);
                    $pdf->Cell(46.5, 6, utf8_decode('Aborto:' . (isset(self::$consulta["HistoriaClinica"]["aborto"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["aborto"]) : 'No Evaluado')), 1);
                    $pdf->Cell(46.5, 6, utf8_decode('Vivos:' . (isset(self::$consulta["HistoriaClinica"]["vivos"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["vivos"]) : 'No Evaluado')), 1);
                    $pdf->Cell(46.5, 6, utf8_decode('Cesárea:' . (isset(self::$consulta["HistoriaClinica"]["cesarea"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["cesarea"]) : 'No Evaluado')), 1);
                    $pdf->Ln();
                    $pdf->SetX(12);
                    $pdf->Cell(46.5, 6, utf8_decode('Mortinato:' . (isset(self::$consulta["HistoriaClinica"]["mortinato"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["mortinato"]) : 'No Evaluado')), 1);
                    $pdf->Cell(46.5, 6, utf8_decode('Ectópicos:' . (isset(self::$consulta["HistoriaClinica"]["ectopicos"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["ectopicos"]) : 'No Evaluado')), 1);
                    $pdf->Cell(46.5, 6, utf8_decode('Molas:' . (isset(self::$consulta["HistoriaClinica"]["molas"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["molas"]) : 'No Evaluado')), 1);
                    $pdf->Cell(46.5, 6, utf8_decode('Gemelos:' . (isset(self::$consulta["HistoriaClinica"]["gemelos"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["gemelos"]) : 'No Evaluado')), 1);
                }
                $pdf->Ln();

                if (isset(self::$consulta["HistoriaClinica"]["fecha_ultima_menstruacion_gestante"]) && self::$consulta["HistoriaClinica"]["fecha_ultima_menstruacion_gestante"] !== null) {
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
                    $pdf->Cell(62, 6, utf8_decode('Fecla última mentruación:' . (isset(self::$consulta["HistoriaClinica"]["fecha_ultima_menstruacion_gestante"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["fecha_ultima_menstruacion_gestante"]) : 'No Evaluado')), 1);
                    $pdf->Cell(62, 6, utf8_decode('Edad gestacional por FUM:' . (isset(self::$consulta["HistoriaClinica"]["gestacional_fum"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["gestacional_fum"]) : 'No Evaluado')), 1);
                    $pdf->Cell(62, 6, utf8_decode('Fecha probable de parto:' . (isset(self::$consulta["HistoriaClinica"]["fecha_probable"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["fecha_probable"]) : 'No Evaluado')), 1);
                    $pdf->Ln();
                    $pdf->SetX(12);
                    $pdf->Cell(42.5, 6, utf8_decode('Embarazo deseado:' . (isset(self::$consulta["HistoriaClinica"]["embarazo_deseado"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["embarazo_deseado"]) : 'No Evaluado')), 1);
                    $pdf->Cell(43.5, 6, utf8_decode('Embarazo planeado:' . (isset(self::$consulta["HistoriaClinica"]["embarazo_planeado"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["embarazo_planeado"]) : 'No Evaluado')), 1);
                    $pdf->Cell(44.5, 6, utf8_decode('Embarazo aceptado:' . (isset(self::$consulta["HistoriaClinica"]["embarazo_aceptado"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["embarazo_aceptado"]) : 'No Evaluado')), 1);
                    $pdf->Cell(55.5, 6, utf8_decode('Embarazo Fecha ecografia:' . (isset(self::$consulta["HistoriaClinica"]["fecha_primera_eco"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["fecha_primera_eco"]) : 'No Evaluado')), 1);
                    $pdf->Ln();
                    $pdf->SetX(12);
                    $pdf->Cell(62, 6, utf8_decode('Edad gestacional en la ecografia:' . (isset(self::$consulta["HistoriaClinica"]["gestacional_eco_1"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["gestacional_eco_1"]) : 'No Evaluado')), 1);
                    $pdf->Cell(62, 6, utf8_decode('Edad gestacional por ecografia:' . (isset(self::$consulta["HistoriaClinica"]["edad_gestacional_ecografia1"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["edad_gestacional_ecografia1"]) : 'No Evaluado')), 1);
                    $pdf->Cell(62, 6, utf8_decode('Descripción:' . (isset(self::$consulta["HistoriaClinica"]["descripcion_eco_1"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["descripcion_eco_1"]) : 'No Evaluado')), 1);
                    $pdf->Ln();

                    $pdf->SetX(12);
                    $pdf->Cell(62, 6, utf8_decode('Edad gestacional en la ecografia 2:' . (isset(self::$consulta["HistoriaClinica"]["gestacional_eco_2"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["gestacional_eco_2"]) : 'No Evaluado')), 1);
                    $pdf->Cell(62, 6, utf8_decode('Edad gestacional por ecografia 2:' . (isset(self::$consulta["HistoriaClinica"]["edad_gestacional_ecografia2"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["edad_gestacional_ecografia2"]) : 'No Evaluado')), 1);
                    $pdf->Cell(62, 6, utf8_decode('Descripción:' . (isset(self::$consulta["HistoriaClinica"]["descripcion_eco_2"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["descripcion_eco_2"]) : 'No Evaluado')), 1);
                    $pdf->Ln();


                    $pdf->SetX(12);
                    $pdf->Cell(62, 6, utf8_decode('Edad gestacional en la ecografia 3:' . (isset(self::$consulta["HistoriaClinica"]["gestacional_eco_3"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["gestacional_eco_3"]) : 'No Evaluado')), 1);
                    $pdf->Cell(62, 6, utf8_decode('Edad gestacional por ecografia 3:' . (isset(self::$consulta["HistoriaClinica"]["edad_gestacional_ecografia3"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["edad_gestacional_ecografia3"]) : 'No Evaluado')), 1);
                    $pdf->Cell(62, 6, utf8_decode('Descripción:' . (isset(self::$consulta["HistoriaClinica"]["descripcion_eco_3"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["descripcion_eco_3"]) : 'No Evaluado')), 1);

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
            $pdf->Cell(93, 6, utf8_decode('¿Practica autoexamen de senos?:' . (isset(self::$consulta["HistoriaClinica"]["presente_auto_examen_senos"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["presente_auto_examen_senos"]) : 'No Evaluado')), 1);
            if (self::$consulta["HistoriaClinica"]["presente_auto_examen_senos"] == 'Si') {
                $pdf->Cell(93, 6, utf8_decode('Frecuencia en que lo realiza:' . (isset(self::$consulta["HistoriaClinica"]["frecuencia_auto_examen_senos"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["frecuencia_auto_examen_senos"]) : 'No Evaluado')), 1);
            }
            $pdf->Ln();


            $buscarCitologia = CupGinecologico::where('consulta_id', self::$consulta->id)
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
                    $pdf->MultiCell(186, 4, utf8_decode('TIPO CITOLOGÍA:') . ' ' . utf8_decode($citologias->cup->nombre), 1, 'L');
                    $pdf->SetX(12);
                    $pdf->Cell(186, 4, utf8_decode('RESULTADOS:' . ' ' . utf8_decode($citologias->resultados)), 1, 'L');
                    $pdf->SetX(12);
                    $pdf->Cell(93, 4, utf8_decode('FECHA REALIZACIÓN:') . ' ' . utf8_decode($citologias->fecha_realizacion), 1, 0, 'L');
                    $pdf->Cell(93, 4, utf8_decode('PROFESIONAL QUE REGISTRA:' . ' ' . utf8_decode($citologias->usuarioCrea->operador->nombre_completo)), 1, 0, 'L');
                    $pdf->Ln();
                }
            } else {
                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 9);
                $pdf->Cell(186, 4, utf8_decode('No Refiere'), 1, 0, 'L');
            }

            $pdf->Ln();

            $buscarMamografia = CupMamografia::where('consulta_id', self::$consulta->id)
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
                    $pdf->MultiCell(186, 4, utf8_decode('TIPO MAMOGRAFIA:') . ' ' . utf8_decode($mamografia->cup->nombre), 1, 'L');
                    $pdf->SetX(12);
                    $pdf->Cell(186, 4, utf8_decode('RESULTADOS:' . ' ' . utf8_decode($mamografia->resultados)), 1, 'L');
                    $pdf->SetX(12);
                    $pdf->Cell(93, 4, utf8_decode('FECHA REALIZACIÓN:') . ' ' . utf8_decode($mamografia->fecha_realizacion), 1, 0, 'L');
                    $pdf->Cell(93, 4, utf8_decode('PROFESIONAL QUE REGISTRA:' . ' ' . utf8_decode($mamografia->usuarioCrea->operador->nombre_completo)), 1, 0, 'L');
                    $pdf->Ln();
                }
            } else {
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetX(12);
                $pdf->Cell(186, 4, utf8_decode('No Refiere'), 1, 0, 'L');
            }

            $pdf->Ln();
        }

        $pdf->SetX(12);
        $pdf->SetFont('arial', 'B', '9');
        $pdf->Cell(186, 4, utf8_decode('ESTILOS DE VIDA'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('arial', '', '8');
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
        $pdf->SetFont('arial', 'B', '9');
        $pdf->Cell(186, 4, utf8_decode('SUSTANCIAS PSICOACTIVAS'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('arial', '', '9');
        $pdf->Cell(62, 4, utf8_decode("Frecuencia de exposicion: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["anios_expuesto_sustancias"]) && self::$consulta["HistoriaClinica"]["anios_expuesto_sustancias"] !== null ? self::$consulta["HistoriaClinica"]["anios_expuesto_sustancias"] : 'No Refiere'), 1, 0, 'L');
        $pdf->Cell(62, 4, utf8_decode("Fecha inicio de consumo: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["consumo_psicoactivo"]) && self::$consulta["HistoriaClinica"]["consumo_psicoactivo"] !== null ? self::$consulta["HistoriaClinica"]["consumo_psicoactivo"] : 'No Refiere'), 1, 0, 'L');
        $pdf->Cell(62, 4, utf8_decode("Cantidad consumo: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["psicoactivo_cantidad"]) && self::$consulta["HistoriaClinica"]["psicoactivo_cantidad"] !== null ? self::$consulta["HistoriaClinica"]["psicoactivo_cantidad"] : 'No Refiere'), 1, 0, 'L');
        $pdf->Ln();
        if (self::$consulta["afiliado"]["edad_cumplida"] >= 11) {
            $pdf->SetX(12);
            $pdf->SetFont('arial', 'B', '9');
            $pdf->Cell(186, 4, utf8_decode('CONSUMO BEBIDAS ALCOHOLICAS'), 1, 0, 'C', 1);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFont('arial', '', '8');
            $pdf->Cell(93, 4, utf8_decode("Cantidad de tragos: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["cantidad_licor"]) && self::$consulta["HistoriaClinica"]["cantidad_licor"] !== null ? self::$consulta["HistoriaClinica"]["cantidad_licor"] : 'No Refiere'), 1, 0, 'L');
            $pdf->Cell(93, 4, utf8_decode("Frecuencia consumo de bebidas: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["licor_frecuencia"]) && self::$consulta["HistoriaClinica"]["licor_frecuencia"] !== null ? self::$consulta["HistoriaClinica"]["licor_frecuencia"] : 'No Refiere'), 1, 0, 'L');
            $pdf->Ln();
        }
        $pdf->SetX(12);
        $pdf->SetFont('arial', 'B', '9');
        $pdf->Cell(186, 4, utf8_decode('OBSERVACIONES'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetFont('arial', '', '9');
        $pdf->MultiCell(186, 4, utf8_decode("Observaciones adicionales: ") . utf8_decode(isset(self::$consulta["HistoriaClinica"]["estilo_vida_observaciones"]) && self::$consulta["HistoriaClinica"]["estilo_vida_observaciones"] !== null ? self::$consulta["HistoriaClinica"]["estilo_vida_observaciones"] : 'No Refiere'), 1, 0, 'L');
        $pdf->Ln();



        $pdf->SetX(12);
        $pdf->SetFont('arial', 'B', '9');
        $pdf->SetFillColor(214, 214, 214);
        $pdf->Cell(186, 4, utf8_decode('ACTIVIDAD ECONOMICA'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetFont('arial', '', '9');
        $pdf->Cell(93, 4, utf8_decode("Edad de inicio: ") . utf8_decode(isset(self::$consulta["antecedenteFamiliograma"]["actividad_laboral"]) && self::$consulta["antecedenteFamiliograma"]["actividad_laboral"] !== null ? self::$consulta["antecedenteFamiliograma"]["actividad_laboral"] : 'No refiere'), 1, 0, 'L');
        $pdf->Cell(93, 4, utf8_decode("¿Alteraciones por el trabajo?: ") . utf8_decode(isset(self::$consulta["antecedenteFamiliograma"]["alteraciones"]) && self::$consulta["antecedenteFamiliograma"]["alteraciones"] !== null ? self::$consulta["antecedenteFamiliograma"]["alteraciones"] : 'No refiere'), 1, 0, 'L');
        $pdf->Ln();
        if (isset(self::$consulta["antecedenteFamiliograma"]["alteraciones"]) == 'Si') {
            $pdf->SetX(12);
            $pdf->MultiCell(186, 4, utf8_decode("¿Cual?: ") . utf8_decode(isset(self::$consulta["antecedenteFamiliograma"]["descripcion_actividad"]) && self::$consulta["antecedenteFamiliograma"]["descripcion_actividad"] !== null ? self::$consulta["antecedenteFamiliograma"]["descripcion_actividad"] : 'No refiere'), 1, 0, 'L');
        }
        $pdf->Ln();

        if (isset(self::$consulta['apgarFamiliar'])) {
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('APGAR FAMILIAR'), 1, 0, 'C', 1);
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(186, 4, "Resultado: " . utf8_decode(isset(self::$consulta["apgarFamiliar"]["resultado"]) && self::$consulta["apgarFamiliar"]["resultado"] !== null ? self::$consulta["apgarFamiliar"]["resultado"] : 'sin hallazgos'), 1, 1, 'L');
            $pdf->SetX(12);
        }


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
            $pdf->Cell(45, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["talla"]) && self::$consulta["HistoriaClinica"]["talla"] !== null ? "Talla: " . self::$consulta["HistoriaClinica"]["talla"] . " Centimetros" : "Talla: 0"), 1, 0, 'L', 0);
            $pdf->Cell(27, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["imc"]) && self::$consulta["HistoriaClinica"]["imc"] !== null ? "IMC: " . self::$consulta["HistoriaClinica"]["imc"] : "IMC: No Evaluado"), 1, 0, 'L', 0);
            $pdf->Cell(69, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["isc"]) && self::$consulta["HistoriaClinica"]["isc"] !== null ? "Índice de superficie corporal: " . self::$consulta["HistoriaClinica"]["isc"] : "Índice de superficie corporal: No Evaluado"), 1, 0, 'L', 0);
            $pdf->Ln();

            $pdf->SetX(12);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(186, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["perimetro_abdominal"]) && self::$consulta["HistoriaClinica"]["perimetro_abdominal"] !== null ? "Perímetro abdominal: " . self::$consulta["HistoriaClinica"]["perimetro_abdominal"] . "centímetros" : "Perímetro abdominal: No Evaluado"), 1, 0, 'L', 0);
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->Cell(186, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["clasificacion"]) && self::$consulta["HistoriaClinica"]["clasificacion"] !== null ? "Clasificación: " . self::$consulta["HistoriaClinica"]["clasificacion"] : "Clasificación: No Evaluado"), 1, 0, 'L', 0);
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
                    isset(self::$consulta["HistoriaClinica"]["presion_sistolica"]) &&  self::$consulta["HistoriaClinica"]["presion_sistolica"] !== null
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

                $pdf->Ln();
            }

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
                    ? "Pulso: " . self::$consulta["HistoriaClinica"]["pulsos"] . " Pulsaciones por minuto"
                    : "Pulso: " . (self::$consulta["HistoriaClinica"]["frecuencia_cardiaca"]) . " Pulsaciones por minuto"
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
            $pdf->Cell(62, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["fio"]) && self::$consulta["HistoriaClinica"]["fio"] !== null ? "Fracción inspiratoria de oxígeno: " . self::$consulta["HistoriaClinica"]["fio"] : "Fracción inspiratoria de oxígeno: No Evaluado"), 1, 0, 'L', 0);
            $pdf->Ln();
            $pdf->Ln();
        }

        //Imprimir el examen fisico
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
            $pdf->MultiCell(186, 4, "Examen Cardiorespiratorio: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["examen_cardiorespiratorio"]) && self::$consulta["HistoriaClinica"]["examen_cardiorespiratorio"] !== null ? self::$consulta["HistoriaClinica"]["examen_cardiorespiratorio"] : 'No Refiere'), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 9);
            $pdf->MultiCell(186, 4, "Genitales: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["examen_genitales"]) && self::$consulta["HistoriaClinica"]["examen_genitales"] !== null ? self::$consulta["HistoriaClinica"]["examen_genitales"] : 'No Refiere'), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 9);
            $pdf->MultiCell(186, 4, "Extremidades: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["examen_extremidades"]) && self::$consulta["HistoriaClinica"]["examen_extremidades"] !== null ? self::$consulta["HistoriaClinica"]["examen_extremidades"] : 'No Refiere'), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 9);
            $pdf->MultiCell(186, 4, "Piel y anexos: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["piel_anexos"]) && self::$consulta["HistoriaClinica"]["piel_anexos"] !== null ? self::$consulta["HistoriaClinica"]["piel_anexos"] : 'No Refiere'), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 9);
            $pdf->MultiCell(186, 4, "Neurologico: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["neurologico"]) && self::$consulta["HistoriaClinica"]["neurologico"] !== null ? self::$consulta["HistoriaClinica"]["neurologico"] : 'No Refiere'), 1, 'L', 0);

            $pdf->Ln();
        }

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
        $pdf->MultiCell(186, 4, utf8_decode("Lista de chequeo de factores de riesgo de las enfermedades del oído: ") . utf8_decode(self::$consulta["HistoriaClinica"]["factores_oido"] ?? 'No evaluado'), 1, 'L', 0);
        $pdf->Ln();

        //Imprimos las valoracion psicosocial
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

        if (self::$consulta["afiliado"]["edad_cumplida"] >= 12 && self::$consulta["afiliado"]["edad_cumplida"] <= 50) {
            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, "Violencia sexual: " . utf8_decode(self::$consulta["HistoriaClinica"]["violencia_sexual"] ?? 'No evaluado'), 1, 'L', 0);
        }

        if (self::$consulta["afiliado"]["edad_cumplida"] >= 12 && self::$consulta["afiliado"]["edad_cumplida"] <= 50) {
            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, "Lesiones autoinflingidas: " . utf8_decode(self::$consulta["HistoriaClinica"]["lesiones_auto_inflingidas"] ?? 'No evaluado'), 1, 'L', 0);
            $pdf->Ln();
        }



        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('RESULTADO TEST MINIMENTAL'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode(self::$consulta["testMental"]["resultado"] ?? 'No evaluado'), 1, 'L', 0);
        $pdf->Ln();


        $pdf->SetX(12);
        $pdf->SetFont('arial', 'B', '9');
        $pdf->SetFillColor(214, 214, 214);
        $pdf->Cell(186, 4, utf8_decode('CUESTIONARIO VALE'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('arial', '', '8');
        $pdf->Cell(186, 4, utf8_decode("Resultado del cuestionario: ") . utf8_decode(isset(self::$consulta["cuestionarioVale"]["interpretacion_resultado"]) && self::$consulta["cuestionarioVale"]["interpretacion_resultado"] !== null ? self::$consulta["cuestionarioVale"]["interpretacion_resultado"] : 'No refiere'), 1, 0, 'L');
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('arial', 'B', '9');
        $pdf->SetFillColor(214, 214, 214);
        $pdf->Cell(186, 4, utf8_decode('WHOOLEY'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('arial', '', '8');
        $pdf->Cell(186, 4, utf8_decode("Resultado del cuestionario: ") . utf8_decode(isset(self::$consulta["whooley"]["interpretacion_resultado"]) && self::$consulta["whooley"]["interpretacion_resultado"] !== null ? self::$consulta["whooley"]["interpretacion_resultado"] : 'No refiere'), 1, 0, 'L');
        $pdf->Ln();


        $pdf->SetX(12);
        $pdf->SetFont('arial', 'B', '9');
        $pdf->SetFillColor(214, 214, 214);
        $pdf->Cell(186, 4, utf8_decode('CUESTIONARIO GAD-2'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('arial', '', '8');
        $pdf->Cell(186, 4, utf8_decode("Resultado del cuestionario: ") . utf8_decode(isset(self::$consulta["gad2"]["resultado"]) && self::$consulta["gad2"]["resultado"] !== null ? self::$consulta["gad2"]["resultado"] : 'No refiere'), 1, 0, 'L');
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('arial', 'B', '9');
        $pdf->SetFillColor(214, 214, 214);
        $pdf->Cell(186, 4, utf8_decode('AUDIT'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('arial', '', '8');
        $pdf->Cell(186, 4, utf8_decode("Resultado del cuestionario: ") . utf8_decode(isset(self::$consulta["audit"]["interpretacion_resultados"]) && self::$consulta["audit"]["interpretacion_resultados"] !== null ? self::$consulta["audit"]["interpretacion_resultados"] : 'No refiere'), 1, 0, 'L');
        $pdf->Ln();



        $pdf->Ln(3);
        $y = $pdf->GetY();
        if ($y === 257.00125 || $y === 239.00125 || $y === 255.00125) {
            $y = $pdf->AddPage() + 10;
        }

        // Familigramas
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->Cell(186, 4, utf8_decode('FAMILIOGRAMA'), 1, 0, 'C', 1);
        $pdf->SetFont('Arial', '', 8);

        if (isset($consulta['familiograma']) && !empty($consulta['familiograma'])) {
            $familiogramaImagen = $consulta['familiograma'];

            $tempDir = public_path('temp/');
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0755, true);
            }

            $tempImagePath = $tempDir . basename($familiogramaImagen->imagen);

            $url = Storage::disk('server37')->temporaryUrl($familiogramaImagen->imagen, now()->addMinutes(30));
            try {
                file_put_contents($tempImagePath, file_get_contents($url));
            } catch (\Exception $e) {
                throw new \Error('Error al descargar la imagen: ' . $e->getMessage());
            }

            if (file_exists($tempImagePath)) {
                $pdf->Image($tempImagePath, 25, $y + 5, 160, 55);
            } else {
                throw new \Error('No se pudo encontrar la imagen descargada para incluir en el PDF.');
            }

            if (file_exists($tempImagePath)) {
                unlink($tempImagePath);
            } else {
                error_log('El archivo temporal no se encontró para eliminar.');
            }

            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->Ln(60);
            $y = $pdf->GetY();
        } else {
            $pdf->Ln();
            $pdf->SetFont('Arial', '', 8);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetX(12);
            $pdf->Cell(186, 4, utf8_decode('No Refiere'), 1, 0, 'L', 1);
            $pdf->Ln();
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
