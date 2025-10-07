<?php

namespace App\Formats\ComponentesHistoriaClinica;

class valoracionAntropometricaFormato
{
    public function bodyComponente($pdf, $consulta): void
    {
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('VALORACION ANTROPOMETRICA'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(62, 4, utf8_decode("Registro del peso anterior: ") . utf8_decode(isset($consulta["valoracionAntropometrica"]["peso_anterior"]) && $consulta["valoracionAntropometrica"]["peso_anterior"] !== null ? $consulta["valoracionAntropometrica"]["peso_anterior"] . ' kilogramos'  : 'No Refiere'), 1, 0, 'L');
        $pdf->Cell(62, 4, utf8_decode("Fecha del registro: ") . utf8_decode(isset($consulta["valoracionAntropometrica"]["fecha_registro_peso_anterior"]) && $consulta["valoracionAntropometrica"]["fecha_registro_peso_anterior"] !== null ? $consulta["valoracionAntropometrica"]["fecha_registro_peso_anterior"] : 'No Refiere'), 1, 0, 'L');
        $pdf->Cell(62, 4, utf8_decode("Registro del peso actual: ") . utf8_decode(isset($consulta["valoracionAntropometrica"]["peso_actual"]) && $consulta["valoracionAntropometrica"]["peso_actual"] !== null ? $consulta["valoracionAntropometrica"]["peso_actual"] . ' Kilogramos' : 'No Refiere'), 1, 0, 'L');
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->Cell(93, 4, utf8_decode("Registro de la talla: ") . utf8_decode(isset($consulta["valoracionAntropometrica"]["altura_actual"]) && $consulta["valoracionAntropometrica"]["altura_actual"] !== null ? $consulta["valoracionAntropometrica"]["altura_actual"] . ' Centímetros' : 'No Refiere'), 1, 0, 'L');
        $pdf->Cell(93, 4, utf8_decode("IMC: ") . utf8_decode(isset($consulta["valoracionAntropometrica"]["imc"]) && $consulta["valoracionAntropometrica"]["imc"] !== null ? $consulta["valoracionAntropometrica"]["imc"] : 'No Refiere'), 1, 0, 'L');
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->Cell(93, 4, utf8_decode("Clasificacion: ") . utf8_decode(isset($consulta["valoracionAntropometrica"]["clasificacion"]) && $consulta["valoracionAntropometrica"]["clasificacion"] !== null ? $consulta["valoracionAntropometrica"]["clasificacion"] : 'No Refiere'), 1, 0, 'L');
        $pdf->Cell(93, 4, utf8_decode("Perimetro braquial: ") . utf8_decode(isset($consulta["valoracionAntropometrica"]["perimetro_braquial"]) && $consulta["valoracionAntropometrica"]["perimetro_braquial"] !== null ? $consulta["valoracionAntropometrica"]["perimetro_braquial"] . ' Centímetros' : 'No Refiere'), 1, 0, 'L');
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->Cell(93, 4, utf8_decode("Pliegue de grasa tricipital: ") . utf8_decode(isset($consulta["valoracionAntropometrica"]["pliegue_grasa_tricipital"]) && $consulta["valoracionAntropometrica"]["pliegue_grasa_tricipital"] !== null ? $consulta["valoracionAntropometrica"]["pliegue_grasa_tricipital"] . ' Centímetros' : 'No Refiere'), 1, 0, 'L');
        $pdf->Cell(93, 4, utf8_decode("Pliegue de grasa subescapular: ") . utf8_decode(isset($consulta["valoracionAntropometrica"]["pliegue_grasa_subescapular"]) && $consulta["valoracionAntropometrica"]["pliegue_grasa_subescapular"] !== null ? $consulta["valoracionAntropometrica"]["pliegue_grasa_subescapular"] . ' Centímetros' : 'No Refiere'), 1, 0, 'L');
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->Cell(93, 4, utf8_decode("Peso/Talla: ") . utf8_decode(isset($consulta["valoracionAntropometrica"]["peso_talla"]) && $consulta["valoracionAntropometrica"]["peso_talla"] !== null ? $consulta["valoracionAntropometrica"]["peso_talla"] : 'No Refiere'), 1, 0, 'L');
        $pdf->Cell(93, 4, utf8_decode("Talla o longitud: ") . utf8_decode(isset($consulta["valoracionAntropometrica"]["longitud_talla"]) && $consulta["valoracionAntropometrica"]["longitud_talla"] !== null ? $consulta["valoracionAntropometrica"]["longitud_talla"] : 'No Refiere'), 1, 0, 'L');
        $pdf->Ln();


    }
}