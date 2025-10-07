<?php

namespace App\Formats\HistoriasClinicas;

use App\Http\Modules\Historia\AntecedentesFarmacologicos\Models\AntecedentesFarmacologico;
use App\Http\Modules\Historia\AntecedentesPersonales\Models\AntecedentePersonale;
use Codedge\Fpdf\Fpdf\Fpdf;
use DateTime;
use Illuminate\Support\Facades\Storage;

class HistoriaClinicaOdontoligaControl extends Fpdf
{
    protected static $consulta;

    public function bodyOdontologiaControl($pdf, $consulta)
    {
        self::$consulta = $consulta;
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

        $nota_evolucion = isset($consulta["HistoriaClinica"]["finalidad"]) ? $consulta["HistoriaClinica"]["finalidad"] : 'No Aplica';
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

        $pdf->SetXY(12, $y + 6);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('PROCEDIMIENTO REALIZADO'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell(186, 4, utf8_decode($consulta["HistoriaClinica"]["procedimiento_realizado_odontologia"]), 1, 0, 'L');
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('PACIENTE CONTROLADO'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(46.5, 4, utf8_decode('SI'), 1, 0, 'C');

        // Verificar si el campo es true o false y dibujar la X en la celda correspondiente
        $pdf->SetX(58.5);
        $pdf->SetFont('Arial', '', 8);
        if ($consulta["HistoriaClinica"]["paciente_controlado_odontologia"] == true) {
            $pdf->Cell(46.5, 4, 'X', 1, 0, 'C');
        } else {
            $pdf->Cell(46.5, 4, '', 1, 0, 'C');
        }

        $pdf->SetX(105);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(46.5, 4, utf8_decode('NO'), 1, 0, 'C');

        $pdf->SetX(151.5);
        $pdf->SetFont('Arial', '', 8);
        if ($consulta["HistoriaClinica"]["paciente_controlado_odontologia"] == false) {
            $pdf->Cell(46.5, 4, 'X', 1, 0, 'C');
        } else {
            $pdf->Cell(46.5, 4, '', 1, 0, 'C');
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

        // PLAN DE MANEJO
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

//        $fechaLimite = new DateTime('2024-12-22');
//        $fechaConsulta = isset(self::$consulta["hora_inicio_atendio_consulta"]) && !empty(self::$consulta["hora_inicio_atendio_consulta"]) ? self::$consulta["hora_inicio_atendio_consulta"] : self::$consulta["fecha_hora_inicio"];
//        if ($fechaConsulta > $fechaLimite) {
//            $this->odontograma($pdf, $consulta);
//        } else {
//            $this->odontogramaNuevo($pdf, $consulta);
//        }
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

}

