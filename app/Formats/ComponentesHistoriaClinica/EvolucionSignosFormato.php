<?php

namespace App\Formats\ComponentesHistoriaClinica;

use App\Http\Modules\TratamientoFarmacologico\Models\TratamientoFarmacologico;

class EvolucionSignosFormato
{
    public function bodyComponente($pdf, $consulta): void
    {
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('EVOLUCION DE SIGNOS Y SÍNTOMAS'), 1, 0, 'C', 1);
        $pdf->Ln();


        $fecha_inicio = $consulta["evolucionSignos"]["fecha_inicio"] ?? 'No refiere';
        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(93, 4, utf8_decode("Tiempo de inicio: $fecha_inicio"), 1, 0, 'L', 0);

        $tiempoInicio = $consulta["evolucionSignos"]["tiempo_inicio"] ?? 'No refiere';
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->Cell(93, 4, utf8_decode("Tiempo de inicio: $tiempoInicio"), 1, 0, 'L', 1);
        $pdf->SetX(12);
        $pdf->Ln();

        $sintomas = $consulta["evolucionSignos"]["signos_sintomas"] ?? 'No refiere';
        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Signos y sintomas: $sintomas"), 1, 0, 'L', 0);

        $estresores = $consulta["evolucionSignos"]["estresores_importantes"] ?? 'No refiere';
        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Estresores importantes: $estresores"), 1, 0, 'L', 0);

        $estadoActual = $consulta["evolucionSignos"]["estado_actual"] ?? 'No refiere';
        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Estado actual: $estadoActual"), 1, 0, 'L', 0);

        $profesionalConsultado = $consulta["evolucionSignos"]["profesional_consultado_antes"] ?? 'No refiere';
        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode("Profesionales consultados antes: $profesionalConsultado"), 1, 0, 'L', 0);
        $pdf->Ln();

        $afiliadoId = $consulta->afiliado_id;
        $tratamientos = TratamientoFarmacologico::with('viaAdministracion' ,'creadoPor.operador:user_id,nombre,apellido')
            ->whereHas('consulta', function ($query) use ($afiliadoId) {
                return $query->where('afiliado_id', $afiliadoId);
            })
            ->get();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('TRATAMIENTOS FARMACOLOGICOS'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetFillColor(230, 230, 230);
        $pdf->SetTextColor(0);
        $pdf->SetDrawColor(0);

        $pdf->SetX(12);
        $pdf->Cell(10, 6, utf8_decode('N°'), 1, 0, 'C', true);
        $pdf->Cell(15, 6, 'Dosis', 1, 0, 'C', true);
        $pdf->Cell(25, 6, 'Horario', 1, 0, 'C', true);
        $pdf->Cell(45, 6, utf8_decode('Metodo de Administración'), 1, 0, 'C', true);
        $pdf->Cell(55, 6, utf8_decode('Descripción'), 1, 0, 'C', true);
        $pdf->Cell(36, 6, utf8_decode('Registrado por'), 1, 1, 'C', true);

        $pdf->SetFont('Arial', '', 8);
        foreach ($tratamientos as $index => $tratamiento) {
            $creador = $tratamiento->creadoPor?->operador;
            $nombreUsuario = $creador ? "{$creador->nombre} {$creador->apellido}" : 'No refiere';

            $viaAdministracion = $tratamiento->viaAdministracion->nombre ?? 'No refiere';
            $horario = $tratamiento->horario ?: 'No refiere';
            $descripcion = $tratamiento->descripcion_tratamiento ?: 'No refiere';

            $pdf->SetX(12);
            $pdf->Cell(10, 5, $index + 1, 1);
            $pdf->Cell(15, 5, $tratamiento->dosis ?? 'No refiere', 1);
            $pdf->Cell(25, 5, utf8_decode($horario), 1);
            $pdf->Cell(45, 5, utf8_decode($viaAdministracion), 1);
            $pdf->Cell(55, 5, utf8_decode($descripcion), 1);
            $pdf->Cell(36, 5, utf8_decode($nombreUsuario), 1);
            $pdf->Ln();
        }


        $pdf->Ln();
    }
}
