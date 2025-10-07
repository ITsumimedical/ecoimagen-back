<?php

namespace App\Formats\HistoriasClinicas;

use App\Http\Modules\Historia\AntecedentesFamiliares\Models\AntecedenteFamiliare;
use App\Http\Modules\Historia\AntecedentesFarmacologicos\Models\AntecedentesFarmacologico;
use App\Http\Modules\Historia\AntecedentesHospitalarios\Models\AntecedentesHospitalario;
use App\Http\Modules\Historia\AntecedentesPersonales\Models\AntecedentePersonale;
use App\Http\Modules\Historia\AntecedentesQuirurgicos\Models\AntecedenteQuirurgico;
use App\Http\Modules\Historia\AntecedentesTransfusionales\Models\AntecedenteTransfusionale;
use App\Http\Modules\Historia\Vacunacion\Models\Vacuna;
use App\Http\Modules\RemisionProgramas\Model\RemisionProgramas;
use Codedge\Fpdf\Fpdf\Fpdf;
use DateTime;

class HistoriaClinicaOftalmologia extends Fpdf
{
    protected static $consulta;

    public function bodyOftalmologia($pdf, $consulta)
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

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('OFTALMOLOGIA'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "AVCC OJO DERECHO: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["avcc_ojoderecho"]) && self::$consulta["HistoriaClinica"]["avcc_ojoderecho"] !== null ? self::$consulta["HistoriaClinica"]["avcc_ojoderecho"] : 'No Evaluado'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "AVCC OJO IZQUIERDO: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["avcc_ojoizquierdo"]) && self::$consulta["HistoriaClinica"]["avcc_ojoizquierdo"] !== null ? self::$consulta["HistoriaClinica"]["avcc_ojoizquierdo"] : 'No Evaluado'), 1, 'L', 0);


        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "AVSC OJO DERECHO: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["avsc_ojoderecho"]) && self::$consulta["HistoriaClinica"]["avsc_ojoderecho"] !== null ? self::$consulta["HistoriaClinica"]["avsc_ojoderecho"] : 'No Evaluado'), 1, 'L', 0);


        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "AVSC OJO IZQUIERDO: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["avsc_ojoizquierdo"]) && self::$consulta["HistoriaClinica"]["avsc_ojoizquierdo"] !== null ? self::$consulta["HistoriaClinica"]["avsc_ojoizquierdo"] : 'No Evaluado'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "PH OJO DERECHO: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["ph_ojoderecho"]) && self::$consulta["HistoriaClinica"]["ph_ojoderecho"] !== null ? self::$consulta["HistoriaClinica"]["ph_ojoderecho"] : 'No Evaluado'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "PH OJO IZQUIERDO: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["ph_ojoizquierdo"]) && self::$consulta["HistoriaClinica"]["ph_ojoizquierdo"] !== null ? self::$consulta["HistoriaClinica"]["ph_ojoizquierdo"] : 'No Evaluado'), 1, 'L', 0);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('MOTILIDAD OCULAR'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "OJO DERECHO: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["motilidad_ojoderecho"]) && self::$consulta["HistoriaClinica"]["motilidad_ojoderecho"] !== null ? self::$consulta["HistoriaClinica"]["motilidad_ojoderecho"] : 'No Evaluado'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "COVERT TEST DERECHO: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["covert_ojoderecho"]) && self::$consulta["HistoriaClinica"]["covert_ojoderecho"] !== null ? self::$consulta["HistoriaClinica"]["covert_ojoderecho"] : 'No Evaluado'), 1, 'L', 0);


        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "OJO IZQUIERDO: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["motilidad_ojoizquierdo"]) && self::$consulta["HistoriaClinica"]["motilidad_ojoizquierdo"] !== null ? self::$consulta["HistoriaClinica"]["motilidad_ojoizquierdo"] : 'No Evaluado'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "COVERT TEST IZQUIERDO: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["covert_ojoizquierdo"]) && self::$consulta["HistoriaClinica"]["covert_ojoizquierdo"] !== null ? self::$consulta["HistoriaClinica"]["covert_ojoizquierdo"] : 'No Evaluado'), 1, 'L', 0);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('BIOMICROSCOPIA'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "OJO DERECHO: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["biomicros_ojoderecho"]) && self::$consulta["HistoriaClinica"]["biomicros_ojoderecho"] !== null ? self::$consulta["HistoriaClinica"]["biomicros_ojoderecho"] : 'No Evaluado'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "OJO IZQUIERDO: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["biomicros_ojoizquierdo"]) && self::$consulta["HistoriaClinica"]["biomicros_ojoizquierdo"] !== null ? self::$consulta["HistoriaClinica"]["biomicros_ojoizquierdo"] : 'No Evaluado'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('PRESION INTRAOCULAR'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "OJO DERECHO: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["presionintra_ojoderecho"]) && self::$consulta["HistoriaClinica"]["presionintra_ojoderecho"] !== null ? self::$consulta["HistoriaClinica"]["presionintra_ojoderecho"] : 'No Evaluado'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "OJO IZQUIERDO: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["presionintra_ojoizquierdo"]) && self::$consulta["HistoriaClinica"]["presionintra_ojoizquierdo"] !== null ? self::$consulta["HistoriaClinica"]["presionintra_ojoizquierdo"] : 'No Evaluado'), 1, 'L', 0);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('GIONIOSCOPIA'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "OJO DERECHO: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["gionios_ojoderecho"]) && self::$consulta["HistoriaClinica"]["gionios_ojoderecho"] !== null ? self::$consulta["HistoriaClinica"]["gionios_ojoderecho"] : 'No Evaluado'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "OJO IZQUIERDO: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["gionios_ojoizquierdo"]) && self::$consulta["HistoriaClinica"]["gionios_ojoizquierdo"] !== null ? self::$consulta["HistoriaClinica"]["gionios_ojoizquierdo"] : 'No Evaluado'), 1, 'L', 0);
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
