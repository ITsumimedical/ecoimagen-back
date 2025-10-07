<?php

namespace App\Formats\HistoriasClinicas;

use App\Http\Modules\Historia\AntecedentesFarmacologicos\Models\AntecedentesFarmacologico;
use App\Http\Modules\Historia\AntecedentesPersonales\Models\AntecedentePersonale;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Http\Modules\Historia\AntecedentesFamiliares\Models\AntecedenteFamiliare;
use App\Http\Modules\Historia\Odontograma\Models\OdontogramaParametrizacion;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HistoriaPrimariaOdontologia extends Fpdf
{

    protected static $consulta;

    public function bodyPrimariaOdontologia($pdf, $consulta)
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

        $pdf->SetX(12);
        $pdf->Cell(186, 4, utf8_decode('MOTIVO DE CONSULTA'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();


        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $motivoConsulta = 'No Refiere';
        if (isset($consulta["HistoriaClinica"])) {
            $motivoConsulta = $consulta["HistoriaClinica"]["motivo_consulta"] ?? 'No Refiere';
        }
        $pdf->MultiCell(186, 4, utf8_decode($motivoConsulta), 1, "L", 0);
        $pdf->Ln();

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
        if (isset($consulta["HistoriaClinica"])) {
            $enfermedadActual = $consulta["HistoriaClinica"]["enfermedad_actual"] ?? 'No especificado';
        }
        $pdf->MultiCell(186, 4, utf8_decode($enfermedadActual), 1, "L", 0);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('RESULTADOS AYUDAS DIAGNOSTICAS'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $resultadoAyudaDiagnostica = 'No Refiere';
        if (isset($consulta["HistoriaClinica"])) {
            $resultadoAyudaDiagnostica = $consulta["HistoriaClinica"]["resultado_ayuda_diagnostica"] ?? 'No Refiere';
        }
        $pdf->MultiCell(186, 4, utf8_decode($resultadoAyudaDiagnostica), 1, "L", 0);
        $pdf->Ln();

        // Antecedentes Personales
        $afiliadoId = self::$consulta->afiliado_id;
        $antecedentesPersonales = AntecedentePersonale::with('consulta.medicoOrdena.operador')
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

        if ($antecedentesPersonales->isEmpty()) {
            $pdf->SetX(12);
            $pdf->Cell(186, 4, utf8_decode('No refiere antecedentes personales.'), 1, 0, 'L');
            $pdf->Ln();
        } else {
            foreach ($antecedentesPersonales as $antecedente) {
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

        // Antecedentes Odontologicos
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('ANTECEDENTES ODONTOLÓGICOS'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Ultima consulta: " . utf8_decode($consulta["antecedentesOdontologicos"] !== null ? $consulta["antecedentesOdontologicos"]["ultima_consulta_odontologo"] : 'No Evaluado')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Descripción ultima consulta: " . utf8_decode($consulta["antecedentesOdontologicos"] !== null ? $consulta["antecedentesOdontologicos"]["descripcion_ultima_consulta"] : 'No Evaluado')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Aplicacion de fluor y sellantes: " . utf8_decode($consulta["antecedentesOdontologicos"] !== null ? $consulta["antecedentesOdontologicos"]["aplicacion_fluor_sellantes"] == true ? 'SI - Descripcion: ' . $consulta["antecedentesOdontologicos"]["descripcion_aplicacion_fl_sellante"] : 'NO' : 'NO')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Exodoncias: " . utf8_decode($consulta["antecedentesOdontologicos"] !== null ? $consulta["antecedentesOdontologicos"]["descripcion_exodoncia"] == true ? 'SI - Descripcion: ' . $consulta["antecedentesOdontologicos"]["descripcion_exodoncia"] : 'NO' : 'NO')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Traumas: " . utf8_decode($consulta["antecedentesOdontologicos"] !== null ? $consulta["antecedentesOdontologicos"]["traumas"] == true ? 'SI - Descripcion: ' . $consulta["antecedentesOdontologicos"]["descripcion_trauma"] : 'NO' : 'NO')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Aparatologia: " . utf8_decode($consulta["antecedentesOdontologicos"] !== null ? $consulta["antecedentesOdontologicos"]["aparatologia"] == true ? 'SI - Descripcion: ' . $consulta["antecedentesOdontologicos"]["descripcion_aparatologia"] : 'NO' : 'NO')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Biopsias: " . utf8_decode($consulta["antecedentesOdontologicos"] !== null ? $consulta["antecedentesOdontologicos"]["biopsias"] == true ? 'SI - Descripcion: ' . $consulta["antecedentesOdontologicos"]["descripcion_biopsia"] : 'NO' : 'NO')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Cirugias orales: " . utf8_decode($consulta["antecedentesOdontologicos"] !== null ? $consulta["antecedentesOdontologicos"]["cirugias_orales"] == true ? 'SI - Descripcion: ' . $consulta["antecedentesOdontologicos"]["descripcion_cirugia_oral"] : 'NO' : 'NO')), 1, 'L', 0);

        $pdf->Ln();
        #antecedentes familiares
        // Imprimimos los antecedentes familiares del afiliado
        $afiliadoId = self::$consulta->afiliado_id;

        // Obtener antecedentes familiares del afiliado
        $antecedentesFamiliares = AntecedenteFamiliare::with('consulta.medicoOrdena.operador', 'cie10')
            ->whereHas('consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId);
            })
            ->get();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(186, 4, utf8_decode('ANTECEDENTES FAMILIARES'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);

        // Revisar si el afiliado tiene antecedentes o no
        $noTieneAntecedentes = $antecedentesFamiliares->every(function ($familiares) {
            return $familiares->no_tiene_antecedentes;
        });

        if ($noTieneAntecedentes) {
            // Si todos los antecedentes tienen no_tiene_antecedentes como true
            $textoAntecedentesFamiliares = utf8_decode('No hay antecedentes familiares');
            $pdf->SetX(12);
            $pdf->MultiCell(186, 4, $textoAntecedentesFamiliares, 1, 'L');
        } else {
            // Si hay algún antecedente que no tenga no_tiene_antecedentes como true, mostramos los detalles
            foreach ($antecedentesFamiliares as $familiares) {
                if ($familiares->no_tiene_antecedentes) {
                    continue; // Si el antecedente tiene no_tiene_antecedentes como true, no se muestra
                }

                // Obtener el nombre del médico que ordena la consulta
                if ($familiares->consulta && $familiares->consulta->medicoOrdena && $familiares->consulta->medicoOrdena->operador) {
                    $nombreCompletoMedico = utf8_decode($familiares->consulta->medicoOrdena->operador->nombre) . " " . utf8_decode($familiares->consulta->medicoOrdena->operador->apellido);
                } else {
                    $nombreCompletoMedico = "N/A";
                }

                // Obtener el nombre del diagnóstico CIE10
                $diagnostico = $familiares->cie10 ? utf8_decode($familiares->cie10->nombre) : "Diagnóstico no especificado";

                $fecha = (new DateTime($familiares->created_at))->format('Y-m-d');
                $fallecio = ($familiares->fallecido == 1) ? 'Sí' : 'No';

                // Incluir el nombre del diagnóstico en el texto a mostrar
                $textoAntecedentesFamiliares = "FECHA: " . utf8_decode($fecha) .
                    ", MEDICO: " . utf8_decode($nombreCompletoMedico) .
                    ", PARENTESCO: " . utf8_decode($familiares->parentesco) .
                    ", FALLECIO: " . utf8_decode($fallecio) .
                    ", DIAGNOSTICO: " . utf8_decode($diagnostico);

                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, $textoAntecedentesFamiliares, 1, 'L');
            }

            // Si no hay detalles de antecedentes después de filtrar, mostramos un mensaje de no refiere
            if ($pdf->GetY() <= $pdf->GetY() - 4) {
                $textoAntecedentesFamiliares = utf8_decode('No Refiere');
                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, $textoAntecedentesFamiliares, 1, 'L');
            }
        }

        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('HÁBITOS HIGIENE ORAL'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Frecuencia de cepillado: " . utf8_decode($consulta["HistoriaClinica"] !== null ? $consulta["HistoriaClinica"]["frecuencia_cepillado"] : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Quien realiza la higiene: " . utf8_decode($consulta["HistoriaClinica"] !== null ? $consulta["HistoriaClinica"]["realiza_higiene"] : ' ')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Uso de crema dental: " . utf8_decode($consulta["HistoriaClinica"] !== null ? $consulta["HistoriaClinica"]["uso_crema_dental"] !== null ? $consulta["HistoriaClinica"]["uso_crema_dental"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Uso de seda dental: " . utf8_decode($consulta["HistoriaClinica"] !== null ? $consulta["HistoriaClinica"]["uso_seda_dental"] !== null ? $consulta["HistoriaClinica"]["uso_seda_dental"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Uso de enjuague bucal: " . utf8_decode($consulta["HistoriaClinica"] !== null ? $consulta["HistoriaClinica"]["uso_enjuague_bucal"] !== null ? $consulta["HistoriaClinica"]["uso_enjuague_bucal"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Uso de aparatología ortopédica: " . utf8_decode($consulta["HistoriaClinica"] !== null ? $consulta["HistoriaClinica"]["uso_aparatologia_ortopedica"] !== null ? $consulta["HistoriaClinica"]["uso_aparatologia_ortopedica"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Uso de aditamentos protésicos removibles: " . utf8_decode($consulta["HistoriaClinica"] !== null ? $consulta["HistoriaClinica"]["uso_adimentos_protesicos_removibles"] !== null ? $consulta["HistoriaClinica"]["uso_adimentos_protesicos_removibles"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Higiene de los aparatos o prótesis: " . utf8_decode($consulta["HistoriaClinica"] !== null ? $consulta["HistoriaClinica"]["higiene_aparatos_protesis"] !== null ? $consulta["HistoriaClinica"]["higiene_aparatos_protesis"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('HÁBITOS CAVIDAD ORAL'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Respiración bucal:	" . utf8_decode($consulta["HistoriaClinica"] !== null ? $consulta["HistoriaClinica"]["respiracion_bucal"] !== null ? $consulta["HistoriaClinica"]["respiracion_bucal"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Succión digital: " . utf8_decode($consulta["HistoriaClinica"] !== null ? $consulta["HistoriaClinica"]["succion_digital"] !== null ? $consulta["HistoriaClinica"]["succion_digital"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Lengua protactil: " . utf8_decode($consulta["HistoriaClinica"] !== null ? $consulta["HistoriaClinica"]["lengua_protactil"] !== null ? $consulta["HistoriaClinica"]["lengua_protactil"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Onicofagia: " . utf8_decode($consulta["HistoriaClinica"] !== null ? $consulta["HistoriaClinica"]["onicofagia"] !== null ? $consulta["HistoriaClinica"]["onicofagia"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Queilofagia: " . utf8_decode($consulta["HistoriaClinica"] !== null ? $consulta["HistoriaClinica"]["queilofagia"] !== null ? $consulta["HistoriaClinica"]["queilofagia"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Mordisqueo: " . utf8_decode($consulta["HistoriaClinica"] !== null ? $consulta["HistoriaClinica"]["mordisqueo"] !== null ? $consulta["HistoriaClinica"]["mordisqueo"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Biberón: " . utf8_decode($consulta["HistoriaClinica"] !== null ? $consulta["HistoriaClinica"]["biberon"] !== null ? $consulta["HistoriaClinica"]["biberon"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Chupos: " . utf8_decode($consulta["HistoriaClinica"] !== null ? $consulta["HistoriaClinica"]["chupos"] !== null ? $consulta["HistoriaClinica"]["chupos"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Otros: " . utf8_decode($consulta["HistoriaClinica"] !== null ? $consulta["HistoriaClinica"]["otros"] !== null ? $consulta["HistoriaClinica"]["otros"] : 'No' : 'No')), 1, 'L', 0);


        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('EXAMÉN FISICO'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('CARA Y CUELLO'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Asimetrías: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["asimetria"] !== null ? $consulta["examenFisicoOdontologicos"]["asimetria"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Lunares, manchas, tatuajes: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["lunares_manchas_tatuajes"] !== null ? $consulta["examenFisicoOdontologicos"]["lunares_manchas_tatuajes"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Aumento de volúmen: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["aumento_volumen"] !== null ? $consulta["examenFisicoOdontologicos"]["aumento_volumen"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Ganglios linfáticos: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["ganglios_linfaticos"] !== null ? $consulta["examenFisicoOdontologicos"]["ganglios_linfaticos"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Senos maxilares: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["senos_maxilares"] !== null ? $consulta["examenFisicoOdontologicos"]["senos_maxilares"] : 'No' : 'No')), 1, 'L', 0);

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
        $pdf->Cell(186, 4, utf8_decode('EXAMÉN DE ARTICULACIÓN TEMPOROMANDIBULAR'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Ruidos: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["ruidos"] !== null ? $consulta["examenFisicoOdontologicos"]["ruidos"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Chasquidos: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["chasquidos"] !== null ? $consulta["examenFisicoOdontologicos"]["chasquidos"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Crepitaciones: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["crepitaciones"] !== null ? $consulta["examenFisicoOdontologicos"]["crepitaciones"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Bloqueo mandibular: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["bloqueo_mandibular"] !== null ? $consulta["examenFisicoOdontologicos"]["bloqueo_mandibular"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Dolor: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["dolor"] !== null ? $consulta["examenFisicoOdontologicos"]["dolor"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Apertura y cierre:	" . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["apertura_cierre"] !== null ? $consulta["examenFisicoOdontologicos"]["apertura_cierre"] : 'No' : 'No')), 1, 'L', 0);


        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('EXÁMEN ESTOMATOLÓGICO'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Labio inferior: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["labio_inferior"] !== null ? $consulta["examenFisicoOdontologicos"]["labio_inferior"] : 'Normal' : 'Normal')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Labio superior: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["labio_superior"] !== null ? $consulta["examenFisicoOdontologicos"]["labio_superior"] : 'Normal' : 'Normal')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Comisuras: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["comisuras"] !== null ? $consulta["examenFisicoOdontologicos"]["comisuras"] : 'Normal' : 'Normal')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Mucosa oral: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["mucosa_oral"] !== null ? $consulta["examenFisicoOdontologicos"]["mucosa_oral"] : 'Normal' : 'Normal')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Carrillos: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["carrillos"] !== null ? $consulta["examenFisicoOdontologicos"]["carrillos"] : 'Normal' : 'Normal')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Surcos yugales: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["surcos_yugales"] !== null ? $consulta["examenFisicoOdontologicos"]["surcos_yugales"] : 'Normal' : 'Normal')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Frenillos: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["frenillos"] !== null ? $consulta["examenFisicoOdontologicos"]["frenillos"] : 'Normal' : 'Normal')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Orofaringe: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["orofaringe"] !== null ? $consulta["examenFisicoOdontologicos"]["orofaringe"] : 'Normal' : 'Normal')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Paladar: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["paladar"] !== null ? $consulta["examenFisicoOdontologicos"]["paladar"] : 'Normal' : 'Normal')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Glándulas salivares: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["glandulas_salivares"] !== null ? $consulta["examenFisicoOdontologicos"]["glandulas_salivares"] : 'Normal' : 'Normal')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Piso de boca: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["piso_boca"] !== null ? $consulta["examenFisicoOdontologicos"]["piso_boca"] : 'Normal' : 'Normal')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Dorso de lengua: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["dorso_lengua"] !== null ? $consulta["examenFisicoOdontologicos"]["dorso_lengua"] : 'Normal' : 'Normal')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Vientre de lengua:	" . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["vientre_lengua"] !== null ? $consulta["examenFisicoOdontologicos"]["vientre_lengua"] : 'Normal' : 'Normal')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Músculos masticadores: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["musculos_masticadores"] !== null ? $consulta["examenFisicoOdontologicos"]["musculos_masticadores"] : 'Normal' : 'Normal')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Riesgo de caídas: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["riesgo_caidas"] !== null ? $consulta["examenFisicoOdontologicos"]["riesgo_caidas"] : 'Normal' : 'Normal')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Otros:	" . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["otros"] !== null ? $consulta["examenFisicoOdontologicos"]["otros"] : 'Normal' : 'Normal')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('EXÁMEN FUNCIONAL'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Masticación: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["masticacion"] !== null ? $consulta["examenFisicoOdontologicos"]["masticacion"] : 'Normal' : 'Normal')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Deglución:	" . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["deglucion"] !== null ? $consulta["examenFisicoOdontologicos"]["deglucion"] : 'Normal' : 'Normal')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Habla: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["habla"] !== null ? $consulta["examenFisicoOdontologicos"]["habla"] : 'Normal' : 'Normal')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Fonación: " . utf8_decode($consulta["examenFisicoOdontologicos"] !== null ? $consulta["examenFisicoOdontologicos"]["fonacion"] !== null ? $consulta["examenFisicoOdontologicos"]["fonacion"] : 'Normal' : 'Normal')), 1, 'L', 0);


        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('OCLUSIÓN'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Relaciones molares: " . utf8_decode(isset($consulta["examenFisicoOdontologicos"]["relaciones_molares"]) ? $consulta["examenFisicoOdontologicos"]["relaciones_molares"] : 'No se puede determinar')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Relaciones caninas: " . utf8_decode(isset($consulta["examenFisicoOdontologicos"]["relaciones_caninas"]) ? $consulta["examenFisicoOdontologicos"]["relaciones_caninas"] : 'No se puede determinar')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Relación interdental: " . utf8_decode(isset($consulta["examenFisicoOdontologicos"]["relacion_interdental"]) ? $consulta["examenFisicoOdontologicos"]["relacion_interdental"] : 'No se puede determinar')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Tipo de oclusión: " . utf8_decode(isset($consulta["examenFisicoOdontologicos"]["tipo_oclusion"]) ? $consulta["examenFisicoOdontologicos"]["tipo_oclusion"] : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Apiñamiento: " . utf8_decode(isset($consulta["examenFisicoOdontologicos"]["apiñamiento"]) ? $consulta["examenFisicoOdontologicos"]["apiñamiento"] : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Mordida abierta: " . utf8_decode(isset($consulta["examenFisicoOdontologicos"]["mordida_abierta"]) ? $consulta["examenFisicoOdontologicos"]["mordida_abierta"] : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Mordida profunda: " . utf8_decode(isset($consulta["examenFisicoOdontologicos"]["mordida_profunda"]) ? $consulta["examenFisicoOdontologicos"]["mordida_profunda"] : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Mordida cruzada: " . utf8_decode(isset($consulta["examenFisicoOdontologicos"]["mordida_cruzada"]) ? $consulta["examenFisicoOdontologicos"]["mordida_cruzada"] : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Discrepancias óseas: " . utf8_decode(isset($consulta["examenFisicoOdontologicos"]["discrepancias_oseas"]) ? $consulta["examenFisicoOdontologicos"]["discrepancias_oseas"] : 'No')), 1, 'L', 0);


        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('EXÁMEN DE TEJIDOS DUROS'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('EXÁMEN PULPAR'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Sensibilidad al frio: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["sensibilidad_frio"] !== null ? $consulta["examenTejidoOdontologicos"]["sensibilidad_frio"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Sensibilidad al calor: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["sensibilidad_calor"] !== null ? $consulta["examenTejidoOdontologicos"]["sensibilidad_calor"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Cambio de color: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["cambio_de_color"] !== null ? $consulta["examenTejidoOdontologicos"]["cambio_de_color"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Percusión positiva: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["percusion_positiva"] !== null ? $consulta["examenTejidoOdontologicos"]["percusion_positiva"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Exposición pulpar: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["exposicion_pulpar"] !== null ? $consulta["examenTejidoOdontologicos"]["exposicion_pulpar"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Otros: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["otros"] !== null ? $consulta["examenTejidoOdontologicos"]["otros"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('EXÁMEN DE TEJIDOS DENTARIOS'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Supernumerarios: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["supernumerarios"] !== null ? $consulta["examenTejidoOdontologicos"]["supernumerarios"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Agenesia: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["agenesia"] !== null ? $consulta["examenTejidoOdontologicos"]["agenesia"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Anodoncia: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["anodoncia"] !== null ? $consulta["examenTejidoOdontologicos"]["anodoncia"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Decoloración: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["decoloracion"] !== null ? $consulta["examenTejidoOdontologicos"]["decoloracion"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Descalcificación: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["descalcificacion"] !== null ? $consulta["examenTejidoOdontologicos"]["descalcificacion"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Facetas de desgaste: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["facetas_desgaste"] !== null ? $consulta["examenTejidoOdontologicos"]["facetas_desgaste"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Atrición: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["atricion"] !== null ? $consulta["examenTejidoOdontologicos"]["atricion"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Abrasión, abfracción y/o erosión: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["abrasion"] !== null ? $consulta["examenTejidoOdontologicos"]["abrasion"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Fluorosis: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["fluorosis"] !== null ? $consulta["examenTejidoOdontologicos"]["fluorosis"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Prótesis fija: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["protesis_fija"] !== null ? $consulta["examenTejidoOdontologicos"]["protesis_fija"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Prótesis removible: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["protesis_removible"] !== null ? $consulta["examenTejidoOdontologicos"]["protesis_removible"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Prótesis total: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["protesis_total"] !== null ? $consulta["examenTejidoOdontologicos"]["protesis_total"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Implantes dentales: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["implantes_dentales"] !== null ? $consulta["examenTejidoOdontologicos"]["implantes_dentales"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Aparatología ortopédica u ortodoncia: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["aparatologia_ortopedica"] !== null ? $consulta["examenTejidoOdontologicos"]["aparatologia_ortopedica"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('ALTERACIONES PERIODONTALES'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Inflamación: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["inflamacion"] !== null ? $consulta["examenTejidoOdontologicos"]["inflamacion"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Sangrado: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["sangrado"] !== null ? $consulta["examenTejidoOdontologicos"]["sangrado"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Exudado: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["exudado"] !== null ? $consulta["examenTejidoOdontologicos"]["exudado"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Supuración: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["supuracion"] !== null ? $consulta["examenTejidoOdontologicos"]["supuracion"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Placa blanda: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["placa_blanda"] !== null ? $consulta["examenTejidoOdontologicos"]["placa_blanda"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Placa calcificada: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["placa_calcificada"] !== null ? $consulta["examenTejidoOdontologicos"]["placa_calcificada"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Retracciones: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["retracciones"] !== null ? $consulta["examenTejidoOdontologicos"]["retracciones"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Presencia de bolsas: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["presencia_bolsas"] !== null ? $consulta["examenTejidoOdontologicos"]["presencia_bolsas"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Cuellos sensibles: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["cuellos_sensibles"] !== null ? $consulta["examenTejidoOdontologicos"]["cuellos_sensibles"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Movilidad: " . utf8_decode($consulta["examenTejidoOdontologicos"] !== null ? $consulta["examenTejidoOdontologicos"]["movilidad"] !== null ? $consulta["examenTejidoOdontologicos"]["movilidad"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->Ln(3);
        $y = $pdf->GetY();
        if ($y === 257.00125 || $y === 239.00125 || $y === 255.00125) {
            $y = $pdf->AddPage() + 10;
        }

        //ODONTOGRAMA
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(186, 4, utf8_decode('ODONTOGRAMA'), 1, 0, 'C', 1);
        $pdf->SetFont('Arial', '', 8);

        if (isset($consulta['odontogramaImagen'])) {

            $odontogramaImagen = $consulta['odontogramaImagen'];

            $tempDir = public_path('temp/');
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0755, true);
            }

            $tempImagePath = $tempDir . basename($odontogramaImagen->imagen);

            $url = Storage::disk('server37')->temporaryUrl($odontogramaImagen->imagen, now()->addMinutes(30));
            try {
                file_put_contents($tempImagePath, file_get_contents($url));
            } catch (\Exception $e) {
                throw new \Error('Error al descargar la imagen: ' . $e->getMessage());
            }

            if (file_exists($tempImagePath)) {
                $pdf->Image($tempImagePath, 10, $y + 5, 190, 85);
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
            $pdf->Ln(90);
            $y = $pdf->GetY();
        }


        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('PARACLINICOS'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);
        if (count($consulta["paraclinicosOdontologicos"]) > 0) {
            foreach ($consulta["paraclinicosOdontologicos"] as $odontograma) {
                $textoOdontograma = "Laboratorio: " . utf8_decode($odontograma->laboratorio) . ", Lectura Radiografica: " . utf8_decode($odontograma->lectura_radiografica) .
                    ", otros: " . utf8_decode($odontograma->oclusal ? $odontograma->otros : 'No Refiere');
                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode($textoOdontograma), 1, 'L');
            }
        } else {
            $textoOdontograma = utf8_decode('No Refiere');
            $pdf->SetX(12);
            $pdf->MultiCell(186, 4, utf8_decode($textoOdontograma), 1, 'L');
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
        $diagnosticoPrincipal = $consulta->cie10Afiliado->first();
        $codigoCie10 = isset($diagnosticoPrincipal->cie10->codigo_cie10) ? $diagnosticoPrincipal->cie10->codigo_cie10 : '';
        $descripcionDiagnostico = isset($diagnosticoPrincipal->cie10->nombre) ? $diagnosticoPrincipal->cie10->nombre : '';
        $tipoDiagnostico = isset($diagnosticoPrincipal->tipo_diagnostico) ? $diagnosticoPrincipal->tipo_diagnostico : '';

        $textoDXprincipal = "CODIGO CIE10: " . utf8_decode($codigoCie10) .
            ", DESCRIPCION DEL DIAGNOSTICO: " . utf8_decode($descripcionDiagnostico) .
            ", TIPO DEL DIAGNOSTICO: " . utf8_decode($tipoDiagnostico);

        $pdf->SetX(12);
        $pdf->MultiCell(186, 4, $textoDXprincipal, 1, "L", 0);
        // Filtrar diagnósticos secundarios
        $diagnosticosSecundarios = $consulta->cie10Afiliado->slice(1);
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

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('PLAN DE TRATAMIENTO'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Operatoria: " . utf8_decode($consulta["planTramientoOdontologia"] !== null ? $consulta["planTramientoOdontologia"]["operatoria"] !== null ? $consulta["planTramientoOdontologia"]["operatoria"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Periodancia: " . utf8_decode($consulta["planTramientoOdontologia"] !== null ? $consulta["planTramientoOdontologia"]["periodancia"] !== null ? $consulta["planTramientoOdontologia"]["periodancia"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Endodoncia: " . utf8_decode($consulta["planTramientoOdontologia"] !== null ? $consulta["planTramientoOdontologia"]["endodoncia"] !== null ? $consulta["planTramientoOdontologia"]["endodoncia"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Cirugia oral: " . utf8_decode($consulta["planTramientoOdontologia"] !== null ? $consulta["planTramientoOdontologia"]["cirugia_oral"] !== null ? $consulta["planTramientoOdontologia"]["cirugia_oral"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Remision: " . utf8_decode($consulta["planTramientoOdontologia"] !== null ? $consulta["planTramientoOdontologia"]["remision"] !== null ? $consulta["planTramientoOdontologia"]["remision"] : 'No' : 'No')), 1, 'L', 0);
        $pdf->Ln();


        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('PROMOCIÓN Y PREVENCIÓN'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Educacion higiene oral: " . utf8_decode($consulta["planTramientoOdontologia"] !== null ? $consulta["planTramientoOdontologia"]["educacion_higiene_oral"] !== null ? $consulta["planTramientoOdontologia"]["educacion_higiene_oral"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Control de placa: " . utf8_decode($consulta["planTramientoOdontologia"] !== null ? $consulta["planTramientoOdontologia"]["control_de_placa"] !== null ? $consulta["planTramientoOdontologia"]["control_de_placa"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Profilaxis: " . utf8_decode($consulta["planTramientoOdontologia"] !== null ? $consulta["planTramientoOdontologia"]["profilaxis"] !== null ? $consulta["planTramientoOdontologia"]["profilaxis"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Detrartraje: " . utf8_decode($consulta["planTramientoOdontologia"] !== null ? $consulta["planTramientoOdontologia"]["detrartraje"] !== null ? $consulta["planTramientoOdontologia"]["detrartraje"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Topización barniz de fluor: " . utf8_decode($consulta["planTramientoOdontologia"] !== null ? $consulta["planTramientoOdontologia"]["topizacion_barniz_fluor"] !== null ? $consulta["planTramientoOdontologia"]["topizacion_barniz_fluor"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Sellantes: " . utf8_decode($consulta["planTramientoOdontologia"] !== null ? $consulta["planTramientoOdontologia"]["sellantes"] !== null ? $consulta["planTramientoOdontologia"]["sellantes"] : 'No' : 'No')), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Remision RIAS: " . utf8_decode($consulta["planTramientoOdontologia"] !== null ? $consulta["planTramientoOdontologia"]["remision_rias"] !== null ? $consulta["planTramientoOdontologia"]["remision_rias"] : 'No' : 'No')), 1, 'L', 0);
        $pdf->Ln();

        //proxima consulta
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('PROXIMA CONSULTA'), 1, 0, 'C', 1);
        $pdf->Ln();
        $y = $pdf->GetY();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, utf8_decode("Fecha próxima consulta: ") . utf8_decode($consulta["HistoriaClinica"]["proximo_control"] ?? 'No Aplica'), 1, 'L', 0);
        $pdf->Line(12, $pdf->GetY(), 198, $pdf->GetY());
        $y = $pdf->GetY();

        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('CONDUCTA'), 1, 0, 'C', 1);
        $pdf->Ln();
        $y = $pdf->GetY();


        // Verificar el valor de tipo_historia_id
        if (isset($consulta["cita"]["tipo_historia_id"]) && !in_array($consulta["cita"]["tipo_historia_id"], [16, 17, 18])) {
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(186, 4, utf8_decode("PLAN DE MANEJO:"), 0, 0, 'L', 0);
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);

            $planManejo = isset($consulta["HistoriaClinica"]["plan_manejo"]) ? $consulta["HistoriaClinica"]["plan_manejo"] : 'No Aplica';
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

            $recomendaciones = isset($consulta["HistoriaClinica"]["recomendaciones"]) ? $consulta["HistoriaClinica"]["recomendaciones"] : 'No Aplica';
            $pdf->SetX(12);
            $pdf->MultiCell(186, 4, utf8_decode($recomendaciones), 0, 'L');
            $pdf->Line(12, $pdf->GetY(), 198, $pdf->GetY());
            $y = $pdf->GetY();
        }

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetX(12);
        $pdf->Cell(186, 4, utf8_decode("DESTINO DEL PACIENTE:"), 0, 0, 'L', 0);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);

        $destino = isset($consulta["HistoriaClinica"]["destino_paciente"]) ? $consulta["HistoriaClinica"]["destino_paciente"] : 'No Aplica';
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

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetX(12);
        $pdf->Cell(186, 4, utf8_decode("Nota de evolución:"), 0, 0, 'L', 0);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);

        $nota_evolucion = isset($consulta["HistoriaClinica"]["nota_evolucion"]) ? $consulta["HistoriaClinica"]["nota_evolucion"] : 'No Aplica';
        $pdf->SetX(12);
        $pdf->MultiCell(186, 4, utf8_decode($nota_evolucion), 0, 'L');
        $pdf->Line(12, $pdf->GetY(), 198, $pdf->GetY());
        $y = $pdf->GetY();

//        $fechaLimite = new DateTime('2024-12-22');
//        $fechaConsulta = isset(self::$consulta["hora_inicio_atendio_consulta"]) && !empty(self::$consulta["hora_inicio_atendio_consulta"]) ? self::$consulta["hora_inicio_atendio_consulta"] : self::$consulta["fecha_hora_inicio"];
//        if ($fechaConsulta > $fechaLimite) {
//            $this->odontograma($pdf, $consulta);
//        } else {
//            $this->odontogramaNuevo($pdf, $consulta);
//        }
    }

    protected function drawTeethSection($pdf, $x, $y, $teeth, $width, $height, $spacing, $consulta)
    {
        foreach ($teeth as $index => $toothNumber) {
            $currentX = $x + $index * ($width + $spacing);
            $this->drawTooth($pdf, $currentX, $y, $width, $height, $toothNumber, $consulta);
        }
    }

    protected function drawTooth($pdf, $x, $y, $width, $height, $toothNumber, $consulta)
    {
        // Dibujar la cruz del diente hecha de cuadros
        $pdf->SetTextColor(0, 0, 0);
        // Inicializar variables
        $caras = [];

        // Obtener todas las instancias del diente
        foreach ($consulta["odontograma"] as $diente) {
            if ($diente['diente'] == $toothNumber) {
                $caras[] = $diente;
            }
        }
        $pdf->Rect($x, $y, $width, $height); // Cuadro central
        $pdf->Rect($x - $width, $y, $width, $height); // Cuadro izquierda
        $pdf->Rect($x + $width, $y, $width, $height); // Cuadro derecha
        $pdf->Rect($x, $y - $height, $width, $height); // Cuadro superior
        $pdf->Rect($x, $y + $height, $width, $height); // Cuadro inferior

        // Dibujar el número del diente
        $pdf->Text($x - 2, $y - $height - 2, (string)$toothNumber);

        // Aplicar los estados del diente y las marcas en las caras
        foreach ($caras as $cara) {
            $state = $cara['diente_tipo'];
            switch ($state) {
                case 'DIENTE SANO':
                    $pdf->SetTextColor(0, 0, 0); // Negro
                    $pdf->SetFont('Arial', '', 40);
                    $pdf->Text($x - 2, $y + 7, 'S');
                    $pdf->SetFont('Arial', '', 9);
                    $pdf->SetTextColor(0, 0, 0);
                    break;
                case 'REQUIERE RADIOGRAFIA':
                    $pdf->SetTextColor(255, 0, 0); // Negro
                    $pdf->SetFont('Arial', '', 12);
                    $pdf->Text($x - 2, $y - 10, 'RX');
                    $pdf->SetFont('Arial', '', 9);
                    $pdf->SetTextColor(0, 0, 0);
                    break;
                case 'ANODONCIA':
                    $pdf->SetDrawColor(0, 0, 255); // Azul
                    $pdf->SetLineWidth(1);
                    $pdf->Line($x - $width + 1, $y + 2, $x + $width + 3, $y + 2); // Raya horizontal
                    $pdf->SetLineWidth(0);
                    $pdf->SetDrawColor(0, 0, 0);
                    break;
                case 'EXFOLIACION DE LOS DIENTES DEBIDA A CAUSAS SISTEMICAS':
                case 'DIENTE PERDIDO POR CARIES':
                case 'PERDIDA DE DIENTES DEBIDA A ACCIDENTE, EXTRACCION O ENFERMEDAD PERIODONTAL LOCAL':
                    $pdf->SetDrawColor(255, 0, 0); // Rojo
                    $pdf->SetLineWidth(1);
                    $pdf->Line($x + 2, $y - $height + 1, $x + 2, $y + $height + 3); // Raya vertical
                    $pdf->SetLineWidth(0);
                    $pdf->SetDrawColor(0, 0, 0);
                    break;
                case 'DIENTE NO ERUPCIONADO':
                    $pdf->SetDrawColor(0, 0, 255); // Azul
                    $pdf->SetLineWidth(1);
                    $pdf->Line($x - $width + 1, $y + 2, $x + $width + 3, $y + 2); // Raya horizontal
                    $pdf->SetLineWidth(0);
                    $pdf->SetDrawColor(0, 0, 0);
                    break;
                case 'RAIZ DENTAL RETENIDA':
                    $pdf->SetDrawColor(255, 0, 0); // Rojo
                    $pdf->SetLineWidth(1);
                    $pdf->Line($x + 2 - $width, $y + 2 - $height, $x + 2 + $width, $y + 2 + $height); // Diagonal \
                    $pdf->Line($x + 2 + $width, $y + 2 - $height, $x + 2 - $width, $y + 2 + $height); // Diagonal /
                    $pdf->SetLineWidth(0);
                    $pdf->SetDrawColor(0, 0, 0);
                    break;
                case 'DIENTE INCLUIDO':
                case 'DIENTE IMPACTADO':
                    $pdf->SetTextColor(255, 0, 0); // Rojo
                    $pdf->SetFont('Arial', '', 90);
                    $pdf->SetLineWidth(1);
                    $pdf->Text($x - 4, $y + 20, '*');
                    $pdf->SetLineWidth(0);
                    $pdf->SetFont('Arial', '', 9);
                    $pdf->SetTextColor(0, 0, 0);
                    break;
                case 'CORONA EN MAL ESTADO':
                case 'PROVISIONAL EN MAL ESTADO':
                    $pdf->SetDrawColor(255, 0, 0); // Rojo
                    $pdf->SetLineWidth(1); // Ajusta el grosor del contorno
                    $this->Ellipse($x + 2, $y + 2, $width, $height, 'D', $pdf); // Círculo
                    $pdf->SetLineWidth(0); // Ajusta el grosor del contorno
                    $pdf->SetDrawColor(0, 0, 0);
                    break;
                case 'CORONA EN BUEN ESTADO':
                case 'PROVISIONAL EN BUEN ESTADO':
                    $pdf->SetDrawColor(0, 0, 255); // Azul
                    $pdf->SetLineWidth(1); // Ajusta el grosor del contorno
                    $this->Ellipse($x + 2, $y + 2, $width, $height, 'D', $pdf); // Círculo
                    $pdf->SetLineWidth(0); // Ajusta el grosor del contorno
                    $pdf->SetDrawColor(0, 0, 0);
                    break;
                default:
                    // DIENTE PRESENTE y otras condiciones
                    if ($cara['diente_tipo'] == 'DIENTE PRESENTE') {
                        $this->subDiagnosticos($pdf, $x, $y, $width, $height, $cara);
                    }
                    break;
            }
        }
    }

    protected function drawTeethSectionNuevo($pdf, $x, $y, $teeth, $width, $height, $spacing, $consulta)
    {
        foreach ($teeth as $index => $toothNumber) {
            $currentX = $x + $index * ($width + $spacing);
            $this->drawToothNuevo($pdf, $currentX, $y, $width, $height, $toothNumber, $consulta);
        }
    }

    protected function drawToothNuevo($pdf, $x, $y, $width, $height, $toothNumber, $consulta)
    {

        // Dibujar 5 círculos en lugar de 5 rectángulos
        $radio = $width / 2;

        // Centro
        $pdf->Circle($x + $radio, $y + $radio, $radio);

        // Izquierda
        $pdf->Circle(($x - $width) + $radio, $y + $radio, $radio);

        // Derecha
        $pdf->Circle(($x + $width) + $radio, $y + $radio, $radio);

        // Superior
        $pdf->Circle($x + $radio, ($y - $height) + $radio, $radio);

        // Inferior
        $pdf->Circle($x + $radio, ($y + $height) + $radio, $radio);

        // Imprimir número del diente por encima
        $pdf->Text($x - 2, $y - $height - 2, (string)$toothNumber);
    }


    protected function odontogramaNuevo($pdf, $consulta)
    {

        $pdf->AddPage('L'); // Orientación horizontal
        // #odontograma
        // $pdf->SetX(12);
        // $pdf->SetFont('Arial', 'B', 12);
        // $pdf->Cell(270, 6, utf8_decode('ODONTOGRAMA'), 1, 0, 'C', 1);
        // $pdf->Ln();
        // $pdf->SetFont('Arial', '', 8);
        // $pdf->SetTextColor(0, 0, 0);
        // $pdf->SetDrawColor(0, 0, 0);

        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();


        $xStart = 5;
        $yStart = $pdf->GetY();
        $width = 4;
        $height = 4;
        $spacing = 2;

        $pdf->Text(5, 82, 'Circle and ellipse examples');
        $pdf->Circle(25, 105, 10, 270, 360, 'F');
        $pdf->SetDrawColor(255, 0, 0); // dibujar en rojo
        $pdf->SetTextColor(255, 0, 0);
        $pdf->Circle(5, 5, 10, 'F');
        $pdf->Circle(50, 50, 100, 'F');


        // // // Dientes de leche superiores derecho
        // $this->drawTeethSectionNuevo($pdf, $xStart + 30, $yStart + 1.5 * ($height + $spacing), [55, 54, 53, 52, 51], $width, $height, $spacing, $consulta);

        // // Dientes superiores izquierdo
        // $this->drawTeethSectionNuevo($pdf, $xStart + 9 * ($width + $spacing), $yStart, [21, 22, 23, 24, 25, 26, 27, 28], $width, $height, $spacing, $consulta);
        // $this->drawTeethSectionNuevo($pdf, $xStart + 9 * ($width + $spacing), $yStart + 1.5 * ($height + $spacing), [61, 62, 63, 64, 65], $width, $height, $spacing, $consulta);

        // // Dientes de leche inferiores derecho
        // $this->drawTeethSectionNuevo($pdf, $xStart + 30, $yStart + 3.0 * ($height + $spacing), [85, 84, 83, 82, 81], $width, $height, $spacing, $consulta);

        // // Dientes inferiores derecho
        // $this->drawTeethSectionNuevo($pdf, $xStart, $yStart + 4.5 * ($height + $spacing), [48, 47, 46, 45, 44, 43, 42, 41], $width, $height, $spacing, $consulta);


        // // Dientes inferiores izquierdo
        // $this->drawTeethSectionNuevo($pdf, $xStart + 9 * ($width + $spacing), $yStart + 3.0 * ($height + $spacing), [71, 72, 73, 74, 75], $width, $height, $spacing, $consulta);

        // $this->drawTeethSectionNuevo($pdf, $xStart + 9 * ($width + $spacing), $yStart + 4.5 * ($height + $spacing), [31, 32, 33, 34, 35, 36, 37, 38], $width, $height, $spacing, $consulta);


        // $pdf->SetX(12);
        // $pdf->SetDrawColor(0, 0, 0);
        // $pdf->SetFillColor(214, 214, 214);
        // $pdf->SetTextColor(0, 0, 0);
        // $pdf->SetFont('Arial', 'B', 12);
        // $pdf->Cell(270, 6, utf8_decode('DIAGNOSTICOS'), 1, 0, 'C', 1);
        // $pdf->Ln();
        // $pdf->SetTextColor(0, 0, 0);
        // $pdf->SetDrawColor(0, 0, 0);
        // $pdf->SetFont('Arial', '', 12);
        // if (count($consulta["odontogramaNuevo"]) > 0) {
        //     foreach ($consulta["odontogramaNuevo"] as $odontograma) {
        //         $diente = explode('_', $odontograma->cara)[0];
        //         $detalleProcedimiento = OdontogramaParametrizacion::where('id',$odontograma->odontograma_parametrizacion_id)->first();
        //         $textoOdontograma = "Tipo: " . utf8_decode($odontograma->tipo) . ", Diente: " . utf8_decode($diente) . ", ".utf8_decode($detalleProcedimiento->descripcion);
        //             $pdf->SetX(12);
        //             $pdf->MultiCell(270, 6, utf8_decode($textoOdontograma), 1, 'L');
        //         }
        // } else {
        //     $textoOdontograma = utf8_decode('No Refiere');
        //     $pdf->SetX(12);
        //     $pdf->MultiCell(270, 6, utf8_decode($textoOdontograma), 1, 'L');
        // }
        // $pdf->SetTextColor(0, 0, 0);
        // $pdf->SetDrawColor(0, 0, 0);
    }

    protected function odontograma($pdf, $consulta)
    {

        $pdf->AddPage('L'); // Orientación horizontal
        #odontograma
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(270, 6, utf8_decode('ODONTOGRAMA'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);

        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();


        $xStart = 18;
        $yStart = $pdf->GetY();
        $width = 4;
        $height = 4;
        $spacing = 12;


        // Dientes superiores derecho
        // Dientes superiores derecho
        $this->drawTeethSection($pdf, $xStart, $yStart, [18, 17, 16, 15, 14, 13, 12, 11], $width, $height, $spacing, $consulta);

        // Dientes de leche superiores derecho
        $this->drawTeethSection($pdf, $xStart + 30, $yStart + 1.5 * ($height + $spacing), [55, 54, 53, 52, 51], $width, $height, $spacing, $consulta);

        // Dientes superiores izquierdo
        $this->drawTeethSection($pdf, $xStart + 9 * ($width + $spacing), $yStart, [21, 22, 23, 24, 25, 26, 27, 28], $width, $height, $spacing, $consulta);
        $this->drawTeethSection($pdf, $xStart + 9 * ($width + $spacing), $yStart + 1.5 * ($height + $spacing), [61, 62, 63, 64, 65], $width, $height, $spacing, $consulta);

        // Dientes de leche inferiores derecho
        $this->drawTeethSection($pdf, $xStart + 30, $yStart + 3.0 * ($height + $spacing), [85, 84, 83, 82, 81], $width, $height, $spacing, $consulta);

        // Dientes inferiores derecho
        $this->drawTeethSection($pdf, $xStart, $yStart + 4.5 * ($height + $spacing), [48, 47, 46, 45, 44, 43, 42, 41], $width, $height, $spacing, $consulta);


        // Dientes inferiores izquierdo
        $this->drawTeethSection($pdf, $xStart + 9 * ($width + $spacing), $yStart + 3.0 * ($height + $spacing), [71, 72, 73, 74, 75], $width, $height, $spacing, $consulta);

        $this->drawTeethSection($pdf, $xStart + 9 * ($width + $spacing), $yStart + 4.5 * ($height + $spacing), [31, 32, 33, 34, 35, 36, 37, 38], $width, $height, $spacing, $consulta);

        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();


        $pdf->SetX(12);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(270, 6, utf8_decode('DIAGNOSTICOS'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 12);
        if (count($consulta["odontograma"]) > 0) {
            foreach ($consulta["odontograma"] as $odontograma) {
                $textoOdontograma = "Diente: " . utf8_decode($odontograma->diente) . ", Estado: " . utf8_decode($odontograma->diente_tipo);
                $dxDiente = ", oclusal: " . utf8_decode($odontograma->oclusal ? $odontograma->oclusal : 'Sano') .
                    ", mesial: " . utf8_decode($odontograma->mesial ? $odontograma->mesial : 'Sano') .
                    ", distal: " . utf8_decode($odontograma->distal ? $odontograma->distal : 'Sano') .
                    ", vestibular: " . utf8_decode($odontograma->vestibular ? $odontograma->vestibular : 'Sano') .
                    ", palatino: " . utf8_decode($odontograma->palatino ? $odontograma->palatino : 'Sano') .
                    ", requiere endodoncia: " . utf8_decode($odontograma->requiere_endodoncia ? $odontograma->requiere_endodoncia : 'No') .
                    ", requiere sellante: " . utf8_decode($odontograma->requiere_sellante ? $odontograma->requiere_sellante : 'No') .
                    ", endodocia presente: " . utf8_decode($odontograma->endodocia_presente ? $odontograma->endodocia_presente : 'No');
                if ($odontograma->diente_tipo == 'DIENTE PRESENTE') {
                    $texto = $textoOdontograma . ' ' . $dxDiente;
                    $pdf->SetX(12);
                    $pdf->MultiCell(270, 6, utf8_decode($texto), 1, 'L');
                } else {
                    $pdf->SetX(12);
                    $pdf->MultiCell(270, 6, utf8_decode($textoOdontograma), 1, 'L');
                }
            }
        } else {
            $textoOdontograma = utf8_decode('No Refiere');
            $pdf->SetX(12);
            $pdf->MultiCell(270, 6, utf8_decode($textoOdontograma), 1, 'L');
        }
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
    }

    protected function subDiagnosticos($pdf, $x, $y, $width, $height, $caras)
    {
        //centro
        switch ($caras['oclusal']) {
            case 'CARIES DE LA DENTINA':
                $pdf->SetTextColor(255, 0, 0); // rojo
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x, $y + 5, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            case 'OBTURACION EN RESINA':
                $pdf->SetTextColor(0, 0, 255); // azul
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x, $y + 5, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            case 'OBTURACION EN AMALGAMA':
                $pdf->SetTextColor(0, 0, 255); // azul
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x, $y + 5, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            case 'OBTURACION EN RESINA DESADAPTADA':
                $pdf->SetTextColor(255, 165, 0); // amarillo
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x, $y + 5, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            case 'OBTURACION EN AMALGAMA DESADAPTADA':
                $pdf->SetTextColor(255, 165, 0); // amarillo
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x, $y + 5, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            case 'SELLANTE EN BUEN ESTADO':
                $pdf->SetTextColor(0, 0, 255); // azul
                $pdf->SetFont('Arial', '', 40);
                $pdf->Text($x - 2, $y + 7, 'S');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
                break;
            default:
                $pdf->SetTextColor(0, 0, 0);
                // DIENTE PRESENTE (sin color específico)
                break;
        }

        //derecha
        switch ($caras['mesial']) {
            case 'CARIES DE LA DENTINA':
                $pdf->SetTextColor(255, 0, 0); // rojo
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x - 4, $y + 5, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            case 'OBTURACION EN RESINA':
                $pdf->SetTextColor(0, 0, 255); // azul
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x - 4, $y + 5, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            case 'OBTURACION EN AMALGAMA':
                $pdf->SetTextColor(0, 0, 255); // azul
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x - 4, $y + 5, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            case 'OBTURACION EN RESINA DESADAPTADA':
                $pdf->SetTextColor(255, 165, 0); // amarillo
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x - 4, $y + 5, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            case 'OBTURACION EN AMALGAMA DESADAPTADA':
                $pdf->SetTextColor(255, 165, 0); // amarillo
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x - 4, $y + 5, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            default:
                $pdf->SetTextColor(0, 0, 0);
                // DIENTE PRESENTE (sin color específico)
                break;
        }

        switch ($caras['requiere_endodoncia']) {
            case 'Si':
                $pdf->SetFillColor(255, 0, 0); // Rojo
                $pdf->SetLineWidth(1); // Ajusta el grosor del contorno
                $this->drawTriangleNomral($pdf, $x + 6, $y + 6, $width, $height); // Dibujar triángulo
                $pdf->SetLineWidth(0); // Ajusta el grosor del contorno
                $pdf->SetFillColor(0, 0, 0);
                break;
        }

        switch ($caras['requiere_sellante']) {
            case 'Si':
                $pdf->SetTextColor(255, 0, 0); // rojo
                $pdf->SetFont('Arial', '', 40);
                $pdf->Text($x - 2, $y + 7, 'S');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
        }

        switch ($caras['endodocia_presente']) {
            case 'Si':
                $pdf->SetFillColor(0, 0, 0); // negro
                $pdf->SetLineWidth(1); // Ajusta el grosor del contorno
                $this->drawTriangle($pdf, $x + 5, $y + 5, $width, $height); // Dibujar triángulo
                $pdf->SetLineWidth(0); // Ajusta el grosor del contorno
                $pdf->SetFillColor(0, 0, 0);
                break;
        }

        //izquierda
        switch ($caras['distal']) {
            case 'CARIES DE LA DENTINA':
                $pdf->SetTextColor(255, 0, 0); // rojo
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x + 4, $y + 5, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            case 'OBTURACION EN RESINA':
                $pdf->SetTextColor(0, 0, 255); // azul
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x + 4, $y + 5, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            case 'OBTURACION EN AMALGAMA':
                $pdf->SetTextColor(0, 0, 255); // azul
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x + 4, $y + 5, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            case 'OBTURACION EN RESINA DESADAPTADA':
                $pdf->SetTextColor(255, 165, 0); // amarillo
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x + 4, $y + 5, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            case 'OBTURACION EN AMALGAMA DESADAPTADA':
                $pdf->SetTextColor(255, 165, 0); // amarillo
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x + 4, $y + 5, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            default:
                $pdf->SetTextColor(0, 0, 0);
                // DIENTE PRESENTE (sin color específico)
                break;
        }

        //afuera
        switch ($caras['vestibular']) {
            case 'CARIES DE LA DENTINA':
                if (
                    $caras['diente'] == 11 ||
                    $caras['diente'] == 12 ||
                    $caras['diente'] == 13 ||
                    $caras['diente'] == 14 ||
                    $caras['diente'] == 15 ||
                    $caras['diente'] == 16 ||
                    $caras['diente'] == 17 ||
                    $caras['diente'] == 18 ||
                    $caras['diente'] == 21 ||
                    $caras['diente'] == 22 ||
                    $caras['diente'] == 23 ||
                    $caras['diente'] == 24 ||
                    $caras['diente'] == 25 ||
                    $caras['diente'] == 26 ||
                    $caras['diente'] == 27 ||
                    $caras['diente'] == 28 ||
                    $caras['diente'] == 51 ||
                    $caras['diente'] == 52 ||
                    $caras['diente'] == 53 ||
                    $caras['diente'] == 54 ||
                    $caras['diente'] == 61 ||
                    $caras['diente'] == 62 ||
                    $caras['diente'] == 63 ||
                    $caras['diente'] == 64 ||
                    $caras['diente'] == 65
                ) {
                    $pdf->SetTextColor(255, 0, 0); // rojo
                    $pdf->SetFont('Arial', '', 23);
                    $pdf->Text($x, $y + 1, '+');
                    $pdf->SetFont('Arial', '', 9);
                    $pdf->SetTextColor(0, 0, 0);
                    break;
                }
                $pdf->SetTextColor(255, 0, 0); // rojo
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x, $y + 9, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;

            case 'OBTURACION EN RESINA':
                if (
                    $caras['diente'] == 11 ||
                    $caras['diente'] == 12 ||
                    $caras['diente'] == 13 ||
                    $caras['diente'] == 14 ||
                    $caras['diente'] == 15 ||
                    $caras['diente'] == 16 ||
                    $caras['diente'] == 17 ||
                    $caras['diente'] == 18 ||
                    $caras['diente'] == 21 ||
                    $caras['diente'] == 22 ||
                    $caras['diente'] == 23 ||
                    $caras['diente'] == 24 ||
                    $caras['diente'] == 25 ||
                    $caras['diente'] == 26 ||
                    $caras['diente'] == 27 ||
                    $caras['diente'] == 28 ||
                    $caras['diente'] == 51 ||
                    $caras['diente'] == 52 ||
                    $caras['diente'] == 53 ||
                    $caras['diente'] == 54 ||
                    $caras['diente'] == 61 ||
                    $caras['diente'] == 62 ||
                    $caras['diente'] == 63 ||
                    $caras['diente'] == 64 ||
                    $caras['diente'] == 65
                ) {
                    $pdf->SetTextColor(0, 0, 255); // azul
                    $pdf->SetFont('Arial', '', 23);
                    $pdf->Text($x, $y + 1, '+');
                    $pdf->SetFont('Arial', '', 9);
                    $pdf->SetTextColor(0, 0, 0);
                    break;
                }
                $pdf->SetTextColor(0, 0, 255); // azul
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x, $y + 9, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            case 'OBTURACION EN AMALGAMA':
                if (
                    $caras['diente'] == 11 ||
                    $caras['diente'] == 12 ||
                    $caras['diente'] == 13 ||
                    $caras['diente'] == 14 ||
                    $caras['diente'] == 15 ||
                    $caras['diente'] == 16 ||
                    $caras['diente'] == 17 ||
                    $caras['diente'] == 18 ||
                    $caras['diente'] == 21 ||
                    $caras['diente'] == 22 ||
                    $caras['diente'] == 23 ||
                    $caras['diente'] == 24 ||
                    $caras['diente'] == 25 ||
                    $caras['diente'] == 26 ||
                    $caras['diente'] == 27 ||
                    $caras['diente'] == 28 ||
                    $caras['diente'] == 51 ||
                    $caras['diente'] == 52 ||
                    $caras['diente'] == 53 ||
                    $caras['diente'] == 54 ||
                    $caras['diente'] == 61 ||
                    $caras['diente'] == 62 ||
                    $caras['diente'] == 63 ||
                    $caras['diente'] == 64 ||
                    $caras['diente'] == 65
                ) {
                    $pdf->SetTextColor(0, 0, 255); // azul
                    $pdf->SetFont('Arial', '', 23);
                    $pdf->Text($x, $y + 1, '+');
                    $pdf->SetFont('Arial', '', 9);
                    $pdf->SetTextColor(0, 0, 0);
                    break;
                }
                $pdf->SetTextColor(0, 0, 255); // azul
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x, $y + 9, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            case 'OBTURACION EN RESINA DESADAPTADA':
                if (
                    $caras['diente'] == 11 ||
                    $caras['diente'] == 12 ||
                    $caras['diente'] == 13 ||
                    $caras['diente'] == 14 ||
                    $caras['diente'] == 15 ||
                    $caras['diente'] == 16 ||
                    $caras['diente'] == 17 ||
                    $caras['diente'] == 18 ||
                    $caras['diente'] == 21 ||
                    $caras['diente'] == 22 ||
                    $caras['diente'] == 23 ||
                    $caras['diente'] == 24 ||
                    $caras['diente'] == 25 ||
                    $caras['diente'] == 26 ||
                    $caras['diente'] == 27 ||
                    $caras['diente'] == 28 ||
                    $caras['diente'] == 51 ||
                    $caras['diente'] == 52 ||
                    $caras['diente'] == 53 ||
                    $caras['diente'] == 54 ||
                    $caras['diente'] == 61 ||
                    $caras['diente'] == 62 ||
                    $caras['diente'] == 63 ||
                    $caras['diente'] == 64 ||
                    $caras['diente'] == 65
                ) {
                    $pdf->SetTextColor(255, 165, 0); // amarillo
                    $pdf->SetFont('Arial', '', 23);
                    $pdf->Text($x, $y + 1, '+');
                    $pdf->SetFont('Arial', '', 9);
                    $pdf->SetTextColor(0, 0, 0);
                    break;
                }
                $pdf->SetTextColor(255, 165, 0); // amarillo
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x, $y + 9, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            case 'OBTURACION EN AMALGAMA DESADAPTADA':
                if (
                    $caras['diente'] == 11 ||
                    $caras['diente'] == 12 ||
                    $caras['diente'] == 13 ||
                    $caras['diente'] == 14 ||
                    $caras['diente'] == 15 ||
                    $caras['diente'] == 16 ||
                    $caras['diente'] == 17 ||
                    $caras['diente'] == 18 ||
                    $caras['diente'] == 21 ||
                    $caras['diente'] == 22 ||
                    $caras['diente'] == 23 ||
                    $caras['diente'] == 24 ||
                    $caras['diente'] == 25 ||
                    $caras['diente'] == 26 ||
                    $caras['diente'] == 27 ||
                    $caras['diente'] == 28 ||
                    $caras['diente'] == 51 ||
                    $caras['diente'] == 52 ||
                    $caras['diente'] == 53 ||
                    $caras['diente'] == 54 ||
                    $caras['diente'] == 61 ||
                    $caras['diente'] == 62 ||
                    $caras['diente'] == 63 ||
                    $caras['diente'] == 64 ||
                    $caras['diente'] == 65
                ) {
                    $pdf->SetTextColor(255, 165, 0); // amarillo
                    $pdf->SetFont('Arial', '', 23);
                    $pdf->Text($x, $y + 1, '+');
                    $pdf->SetFont('Arial', '', 9);
                    $pdf->SetTextColor(0, 0, 0);
                    break;
                }
                $pdf->SetTextColor(255, 165, 0); // amarillo
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x, $y + 9, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            case 'ABRASION DE LOS DIENTES':
                if (
                    $caras['diente'] == 11 ||
                    $caras['diente'] == 12 ||
                    $caras['diente'] == 13 ||
                    $caras['diente'] == 14 ||
                    $caras['diente'] == 15 ||
                    $caras['diente'] == 16 ||
                    $caras['diente'] == 17 ||
                    $caras['diente'] == 18 ||
                    $caras['diente'] == 21 ||
                    $caras['diente'] == 22 ||
                    $caras['diente'] == 23 ||
                    $caras['diente'] == 24 ||
                    $caras['diente'] == 25 ||
                    $caras['diente'] == 26 ||
                    $caras['diente'] == 27 ||
                    $caras['diente'] == 28 ||
                    $caras['diente'] == 51 ||
                    $caras['diente'] == 52 ||
                    $caras['diente'] == 53 ||
                    $caras['diente'] == 54 ||
                    $caras['diente'] == 61 ||
                    $caras['diente'] == 62 ||
                    $caras['diente'] == 63 ||
                    $caras['diente'] == 64 ||
                    $caras['diente'] == 65
                ) {
                    $pdf->SetTextColor(255, 0, 0); // rojo
                    $pdf->SetFont('Arial', '', 15);
                    $this->TextWithDirection($x + 1, $y - 6, '(', 'D', $pdf); // 180 grados para dibujar una paréntesis boca abajo
                    $pdf->SetFont('Arial', '', 9);
                    $pdf->SetTextColor(0, 0, 0);
                    break;
                }
                $pdf->SetTextColor(255, 0, 0); // rojo
                $pdf->SetFont('Arial', '', 15);
                $this->TextWithDirection($x + 4, $y + 10, '(', 'U', $pdf); // 180 grados para dibujar una paréntesis boca abajo
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            case 'EROSION DE LOS DIENTES':
                if (
                    $caras['diente'] == 11 ||
                    $caras['diente'] == 12 ||
                    $caras['diente'] == 13 ||
                    $caras['diente'] == 14 ||
                    $caras['diente'] == 15 ||
                    $caras['diente'] == 16 ||
                    $caras['diente'] == 17 ||
                    $caras['diente'] == 18 ||
                    $caras['diente'] == 21 ||
                    $caras['diente'] == 22 ||
                    $caras['diente'] == 23 ||
                    $caras['diente'] == 24 ||
                    $caras['diente'] == 25 ||
                    $caras['diente'] == 26 ||
                    $caras['diente'] == 27 ||
                    $caras['diente'] == 28 ||
                    $caras['diente'] == 51 ||
                    $caras['diente'] == 52 ||
                    $caras['diente'] == 53 ||
                    $caras['diente'] == 54 ||
                    $caras['diente'] == 61 ||
                    $caras['diente'] == 62 ||
                    $caras['diente'] == 63 ||
                    $caras['diente'] == 64 ||
                    $caras['diente'] == 65
                ) {
                    $pdf->SetTextColor(255, 0, 0); // rojo
                    $pdf->SetFont('Arial', '', 15);
                    $this->TextWithDirection($x + 1, $y - 6, '(', 'D', $pdf); // 180 grados para dibujar una paréntesis boca abajo
                    $pdf->SetFont('Arial', '', 9);
                    $pdf->SetTextColor(0, 0, 0);
                    break;
                }
                $pdf->SetTextColor(255, 0, 0); // rojo
                $pdf->SetFont('Arial', '', 15);
                $this->TextWithDirection($x + 4, $y + 10, '(', 'U', $pdf); // 180 grados para dibujar una paréntesis boca abajo
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;

            default:
                $pdf->SetTextColor(0, 0, 0);
                // DIENTE PRESENTE (sin color específico)
                break;
        }

        //adentro
        switch ($caras['palatino']) {
            case 'CARIES DE LA DENTINA':
                $pdf->SetTextColor(255, 0, 0); // rojo
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x, $y + 9, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            case 'OBTURACION EN RESINA':
                $pdf->SetTextColor(0, 0, 255); // azul
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x, $y + 9, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            case 'OBTURACION EN AMALGAMA':
                $pdf->SetTextColor(0, 0, 255); // azul
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x, $y + 9, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            case 'OBTURACION EN RESINA DESADAPTADA':
                $pdf->SetTextColor(255, 165, 0); // amarillo
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x, $y + 9, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            case 'OBTURACION EN AMALGAMA DESADAPTADA':
                $pdf->SetTextColor(255, 165, 0); // amarillo
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x, $y + 9, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            default:
                $pdf->SetTextColor(0, 0, 0);
                // DIENTE PRESENTE (sin color específico)
                break;
        }
    }

    // Función para dibujar texto rotado
    protected function TextWithDirection($x, $y, $txt, $direction = 'R', $pdf)
    {
        if ($direction == 'R')
            $s = sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', 1, 0, 0, 1, $x * $pdf->k, ($pdf->h - $y) * $pdf->k, $pdf->_escape($txt));
        elseif ($direction == 'L')
            $s = sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', -1, 0, 0, -1, $x * $pdf->k, ($pdf->h - $y) * $pdf->k, $pdf->_escape($txt));
        elseif ($direction == 'U')
            $s = sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', 0, 1, -1, 0, $x * $pdf->k, ($pdf->h - $y) * $pdf->k, $pdf->_escape($txt));
        elseif ($direction == 'D')
            $s = sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', 0, -1, 1, 0, $x * $pdf->k, ($pdf->h - $y) * $pdf->k, $pdf->_escape($txt));
        else
            $s = sprintf('BT %.2F %.2F Td (%s) Tj ET', $x * $pdf->k, ($pdf->h - $y) * $pdf->k, $pdf->_escape($txt));
        if ($pdf->ColorFlag)
            $s = 'q ' . $pdf->TextColor . ' ' . $s . ' Q';
        $pdf->_out($s);
    }

    protected function drawTriangle($pdf, $x, $y, $width, $height)
    {
        // Dibujar un triángulo
        $points = [
            $x,
            $y + 7, // Punto superior
            $x - $width / 2,
            $y + $height, // Punto inferior izquierdo
            $x + $width / 2,
            $y + $height // Punto inferior derecho
        ];
        $this->Polygon($points, 'F', $pdf);
    }

    protected function drawTriangleNomral($pdf, $x, $y, $width, $height)
    {
        // Dibujar un triángulo
        $points = [
            $x,
            $y, // Punto superior
            $x - $width / 2,
            $y + $height, // Punto inferior izquierdo
            $x + $width / 2,
            $y + $height // Punto inferior derecho
        ];
        $this->Polygon($points, 'F', $pdf);
    }

    protected function Polygon($points, $style = 'F', $pdf)
    {
        // Draw a polygon
        $n = count($points) / 2;
        $op = 'h';
        if ($style == 'F')
            $op = 'f';
        elseif ($style == 'FD' || $style == 'DF')
            $op = 'b';
        $pdf->_out(sprintf('%.2F %.2F m', $points[0] * $pdf->k, ($pdf->h - $points[1]) * $pdf->k));
        for ($i = 2; $i < $n * 2; $i += 2)
            $pdf->_out(sprintf('%.2F %.2F l', $points[$i] * $pdf->k, ($pdf->h - $points[$i + 1]) * $pdf->k));
        $pdf->_out($op);
    }

    protected function Ellipse($x, $y, $rx, $ry, $style = 'D', $pdf)
    {
        if ($style == 'F')
            $op = 'f';
        elseif ($style == 'FD' || $style == 'DF')
            $op = 'B';
        else
            $op = 'S';
        $lx = 4 / 3 * (M_SQRT2 - 1) * $rx;
        $ly = 4 / 3 * (M_SQRT2 - 1) * $ry;
        $k = $pdf->k;
        $h = $pdf->h;
        $pdf->_out(sprintf(
            '%.2F %.2F m %.2F %.2F %.2F %.2F %.2F %.2F c',
            ($x + $rx) * $k,
            ($h - $y) * $k,
            ($x + $rx) * $k,
            ($h - ($y - $ly)) * $k,
            ($x + $lx) * $k,
            ($h - ($y - $ry)) * $k,
            $x * $k,
            ($h - ($y - $ry)) * $k
        ));
        $pdf->_out(sprintf(
            '%.2F %.2F %.2F %.2F %.2F %.2F c',
            ($x - $lx) * $k,
            ($h - ($y - $ry)) * $k,
            ($x - $rx) * $k,
            ($h - ($y - $ly)) * $k,
            ($x - $rx) * $k,
            ($h - $y) * $k
        ));
        $pdf->_out(sprintf(
            '%.2F %.2F %.2F %.2F %.2F %.2F c',
            ($x - $rx) * $k,
            ($h - ($y + $ly)) * $k,
            ($x - $lx) * $k,
            ($h - ($y + $ry)) * $k,
            $x * $k,
            ($h - ($y + $ry)) * $k
        ));
        $pdf->_out(sprintf(
            '%.2F %.2F %.2F %.2F %.2F %.2F c %s',
            ($x + $lx) * $k,
            ($h - ($y + $ry)) * $k,
            ($x + $rx) * $k,
            ($h - ($y + $ly)) * $k,
            ($x + $rx) * $k,
            ($h - $y) * $k,
            $op
        ));
    }
}
