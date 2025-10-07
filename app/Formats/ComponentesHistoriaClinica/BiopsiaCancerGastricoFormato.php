<?php

namespace App\Formats\ComponentesHistoriaClinica;

class BiopsiaCancerGastricoFormato
{
    public function bodyComponente($pdf, $datosCancer): void
    {
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('CÁNCER GÁSTRICO'), 1, 0, 'C', 1);
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 8);

        $this->addRow($pdf, 'Laboratorio que procesa', $datosCancer['laboratorio_procesa'] ?? 'No evaluado');
        $this->addRow($pdf, 'Ubicación de la lesión', $datosCancer['ubicacion_leson'] ?? 'No evaluado');
        $this->addRow($pdf, 'Nombre del patólogo', $datosCancer['nombre_patologo'] ?? 'No evaluado');
        $this->addRow($pdf, 'Fecha ingreso IHQ', isset($datosCancer['fecha_ingreso_ihq']) ? date('d/m/Y H:i', strtotime($datosCancer['fecha_ingreso_ihq'])) : 'No evaluado');
        $this->addRow($pdf, 'Fecha salida IHQ', isset($datosCancer['fecha_salida_ihq']) ? date('d/m/Y H:i', strtotime($datosCancer['fecha_salida_ihq'])) : 'No evaluado');
        $this->addRow($pdf, 'Tipo de cáncer gástrico', $datosCancer['tipo_cancer_gastrico'] ?? 'No evaluado');

        $pdf->Ln(2);
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('Clasificación TNM'), 1, 0, 'C', 1);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Ln();
        $this->addRow($pdf, 'Clasificación T', $datosCancer['clasificacion_t'] ?? 'No evaluado');
        $this->addRow($pdf, 'Clasificación N', $datosCancer['clasificacion_n'] ?? 'No evaluado');
        $this->addRow($pdf, 'Clasificación M', $datosCancer['clasificacion_m'] ?? 'No evaluado');

        $pdf->Ln(2);
        $pdf->SetX(12);
        $pdf->MultiCell(186, 5, utf8_decode('Estadio: ' . ($datosCancer['estadio'] ?? 'No evaluado')), 1);

        $this->addRow($pdf, 'PD-L1', $datosCancer['pd_l1'] ?? 'No evaluado');
        $this->addRow($pdf, 'Inestabilidad Microsatelital', $datosCancer['inestabilidad_microsatelital'] ?? 'No evaluado');
        $this->addRow($pdf, 'HER-2', $datosCancer['her_2'] ?? 'No evaluado');
        $this->addRow($pdf, 'Gen NTRK', $datosCancer['gen_ntrk'] ?? 'No evaluado');
    }

    private function addRow($pdf, $label, $value): void
    {
        $pdf->SetX(12);
        $pdf->Cell(60, 5, utf8_decode($label . ':'), 1);
        $pdf->Cell(126, 5, utf8_decode($value), 1);
        $pdf->Ln();
    }
}
