<?php

namespace App\Formats\ComponentesHistoriaClinica;

class SistemasRespiratorioFormato
{
    public function bodyComponente($pdf, $consulta): void
    {
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();

        if (isset($consulta['sistemaRespiratorio'])) {

            $sistemaRespiratorios = $consulta['sistemaRespiratorio'];

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
    }
}