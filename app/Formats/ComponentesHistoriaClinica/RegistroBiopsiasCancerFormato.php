<?php

namespace App\Formats\ComponentesHistoriaClinica;

use App\Http\Modules\RegistroBiopsias\Models\BiopsiaCancerMama;
use App\Http\Modules\RegistroBiopsias\Models\RegistroBiopsiasPatologias;
use App\Http\Modules\RegistroBiopsias\Models\RegistroCancerColon;
use App\Http\Modules\RegistroBiopsias\Models\RegistroCancerGastrico;
use App\Http\Modules\RegistroBiopsias\Models\RegistroCancerOvarios;
use App\Http\Modules\RegistroBiopsias\Models\RegistroCancerProstata;
use App\Http\Modules\RegistroBiopsias\Models\RegistroCancerPulmon;
use Illuminate\Support\Facades\DB;

class RegistroBiopsiasCancerFormato
{
    public function bodyComponente($pdf, $consulta): void
    {
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('REGISTRO BIOPSIAS'), 1, 0, 'C', 1);
        $pdf->Ln();

        if (isset($consulta["registroBiopsias"])) {
            $biopsia = $consulta["registroBiopsias"];

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(63, 4, utf8_decode('Fecha inicial biopsia: ' . ($biopsia["fecha_inicial_biopsia"] ?? 'No evaluado')), 1, 0);
            $pdf->Cell(63, 4, utf8_decode('Fecha final biopsia: ' . ($biopsia["fecha_final_biopsia"] ?? 'No evaluado')), 1, 0);
            $pdf->Cell(60, 4, utf8_decode('Lateralidad: ' . ($biopsia["lateralidad"] ?? 'No evaluado')), 1, 1);

            $pdf->SetX(12);
            $pdf->Cell(93, 4, utf8_decode('Fecha inicial patología: ' . ($biopsia["fecha_inicio_patologia"] ?? 'No evaluado')), 1, 0);
            $pdf->Cell(93, 4, utf8_decode('Fecha final patología: ' . ($biopsia["fecha_final_patologia"] ?? 'No evaluado')), 1, 1);

            $diagnostico = isset($biopsia["cie10"]["nombre"]) ? $biopsia["cie10"]["nombre"] : 'No evaluado';
            $pdf->SetX(12);
            $pdf->MultiCell(186, 4, utf8_decode('Diagnóstico: ' . $diagnostico), 1, 0);
            $pdf->Ln(2);

            $datosCancerMasReciente = $this->obtenerRegistroCancerAfiliado($biopsia['id']);

            if ($datosCancerMasReciente) {
                $tipoCancerId = $datosCancerMasReciente->tipo_cancer_id;
                $registroCancer = $datosCancerMasReciente->registro;

                switch ($tipoCancerId) {
                    case 1:
                        $formato = new BiopsiaCancerMamaFormato();
                        $formato->bodyComponente($pdf, $registroCancer);
                        break;
                    case 2:
                        $formato = new BiopsiaCancerProstataFormato();
                        $formato->bodyComponente($pdf, $registroCancer);
                        break;
                    case 3:
                        $formato = new BiopsiaCancerColonFormato();
                        $formato->bodyComponente($pdf, $registroCancer);
                        break;
                    case 4:
                        $formato = new BiopsiaCancerOvarioFormato();
                        $formato->bodyComponente($pdf, $registroCancer);
                        break;
                    case 5:
                        $formato = new BiopsiaCancerPulmonFormato();
                        $formato->bodyComponente($pdf, $registroCancer);
                        break;
                    case 6:
                        $formato = new BiopsiaCancerGastricoFormato();
                        $formato->bodyComponente($pdf, $registroCancer);
                        break;
                }
            }
        }
    }

    public function obtenerRegistroCancerAfiliado(int $biopsia_id)
    {
        // Obtener el registro de biopsia por ID
        $registro = RegistroBiopsiasPatologias::findOrfail($biopsia_id);
  

        $modelos = [
            1 => BiopsiaCancerMama::class,
            2 => RegistroCancerProstata::class,
            3 => RegistroCancerColon::class,
            4 => RegistroCancerOvarios::class,
            5 => RegistroCancerPulmon::class,
            6 => RegistroCancerGastrico::class,
        ];

        $registrosMasRecientes = [];

        // Buscar en todos los tipos de cáncer 
        foreach ($modelos as $tipoId => $modelo) {
            $registroCancer = $modelo::where('registro_biopsias_patologia_id', $registro->id)
                ->orderBy('created_at', 'desc') 
                ->first();

            if ($registroCancer) {
                $registrosMasRecientes[] = [
                    'tipo_cancer_id' => $tipoId,
                    'registro' => $registroCancer,
                    'fecha' => $registroCancer->created_at 
                ];
            }
        }

        // Si no hay registros, retorno null
        if (empty($registrosMasRecientes)) {
            return null;
        }

        // Ordenar por fecha y obtener el más reciente
        usort($registrosMasRecientes, function ($a, $b) {
            return $b['fecha'] <=> $a['fecha'];
        });

        $masReciente = $registrosMasRecientes[0];
        return (object) [
            'tipo_cancer_id' => $masReciente['tipo_cancer_id'],
            'registro' => $masReciente['registro']
        ];
    }
}
