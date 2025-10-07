<?php

namespace App\Formats\ComponentesHistoriaClinica;

class RxFinalFormato
{
	public function bodyComponente($pdf, $consulta): void
    {
        $y = $pdf->GetY();
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
        $pdf->Cell(20.6, 4, utf8_decode(isset($consulta["rxFinal"]["esfera_ojo_derecho"]) && $consulta["rxFinal"]["esfera_ojo_derecho"] !== null ? $consulta["rxFinal"]["esfera_ojo_derecho"] : 'sin hallazgos'), 1, 1, 'L');

        $pdf->SetY($pdf->GetY() - 8);
        $pdf->SetX(53.2);
        $pdf->Cell(20.6, 4, utf8_decode('Cilindro'), 1, 1, 'C', 1);
        $pdf->SetX(53.2);
        $pdf->Cell(20.6, 4, utf8_decode(isset($consulta["rxFinal"]["cilindro_ojo_derecho"]) && $consulta["rxFinal"]["cilindro_ojo_derecho"] !== null ? $consulta["rxFinal"]["cilindro_ojo_derecho"] : 'sin hallazgos'), 1, 1, 'L');

        $pdf->SetY($pdf->GetY() - 8);
        $pdf->SetX(73.8);
        $pdf->Cell(20.6, 4, utf8_decode('Eje'), 1, 1, 'C', 1);
        $pdf->SetX(73.8);
        $pdf->Cell(20.6, 4, utf8_decode(isset($consulta["rxFinal"]["eje_ojo_derecho"]) && $consulta["rxFinal"]["eje_ojo_derecho"] !== null ? $consulta["rxFinal"]["eje_ojo_derecho"] : 'sin hallazgos'), 1, 1, 'L');

        $pdf->SetY($pdf->GetY() - 8);
        $pdf->SetX(94.4);
        $pdf->Cell(20.6, 4, utf8_decode('Adicion'), 1, 1, 'C', 1);
        $pdf->SetX(94.4);
        $pdf->Cell(20.6, 4, utf8_decode(isset($consulta["rxFinal"]["add_ojo_derecho"]) && $consulta["rxFinal"]["add_ojo_derecho"] !== null ? $consulta["rxFinal"]["add_ojo_derecho"] : 'sin hallazgos'), 1, 1, 'L');

        $pdf->SetY($pdf->GetY() - 8);
        $pdf->SetX(115);
        $pdf->Cell(20.6, 4, utf8_decode('Prisma base'), 1, 1, 'C', 1);
        $pdf->SetX(115);
        $pdf->Cell(20.6, 4, utf8_decode(isset($consulta["rxFinal"]["prima_base_ojo_derecho"]) && $consulta["rxFinal"]["prima_base_ojo_derecho"] !== null ? $consulta["rxFinal"]["prima_base_ojo_derecho"] : 'sin hallazgos'), 1, 1, 'L');

        $pdf->SetY($pdf->GetY() - 8);
        $pdf->SetX(135.6);
        $pdf->Cell(20.6, 4, utf8_decode('Grados'), 1, 1, 'C', 1);
        $pdf->SetX(135.6);
        $pdf->Cell(20.6, 4, utf8_decode(isset($consulta["rxFinal"]["grados_ojo_derecho"]) && $consulta["rxFinal"]["grados_ojo_derecho"] !== null ? $consulta["rxFinal"]["grados_ojo_derecho"] : 'sin hallazgos'), 1, 1, 'L');


        $pdf->SetY($pdf->GetY() - 8);
        $pdf->SetX(156.2);
        $pdf->Cell(20.6, 4, utf8_decode('AV/Lejos'), 1, 1, 'C', 1);
        $pdf->SetX(156.2);
        $pdf->Cell(20.6, 4, utf8_decode(isset($consulta["rxFinal"]["av_lejos_ojo_derecho"]) && $consulta["rxFinal"]["av_lejos_ojo_derecho"] !== null ? $consulta["rxFinal"]["av_lejos_ojo_derecho"] : 'sin hallazgos'), 1, 1, 'L');

        $pdf->SetY($pdf->GetY() - 8);
        $pdf->SetX(176.8);
        $pdf->Cell(20.6, 4, utf8_decode('AV/Cerca'), 1, 1, 'C', 1);
        $pdf->SetX(176.8);
        $pdf->Cell(20.6, 4, utf8_decode(isset($consulta["rxFinal"]["av_cerca_ojo_derecho"]) && $consulta["rxFinal"]["av_cerca_ojo_derecho"] !== null ? $consulta["rxFinal"]["av_cerca_ojo_derecho"] : 'sin hallazgos'), 1, 1, 'L');


        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetX(12);
        $pdf->Cell(20.6, 4, utf8_decode('Ojo izquierdo'), 1, 0, 'C', 1);

        $pdf->SetX(32.6);
        $pdf->Cell(20.6, 4, utf8_decode(isset($consulta["rxFinal"]["esfera_ojo_izquierdo"]) && $consulta["rxFinal"]["esfera_ojo_izquierdo"] !== null ? $consulta["rxFinal"]["esfera_ojo_izquierdo"] : 'sin hallazgos'), 1, 0, 'L');

        $pdf->SetX(53.2);
        $pdf->Cell(20.6, 4, utf8_decode(isset($consulta["rxFinal"]["cilindro_ojo_izquierdo"]) && $consulta["rxFinal"]["cilindro_ojo_izquierdo"] !== null ? $consulta["rxFinal"]["cilindro_ojo_izquierdo"] : 'sin hallazgos'), 1, 0, 'L');

        $pdf->SetX(73.8);
        $pdf->Cell(20.6, 4, utf8_decode(isset($consulta["rxFinal"]["eje_ojo_izquierdo"]) && $consulta["rxFinal"]["eje_ojo_izquierdo"] !== null ? $consulta["rxFinal"]["eje_ojo_izquierdo"] : 'sin hallazgos'), 1, 0, 'L');

        $pdf->SetX(94.4);
        $pdf->Cell(20.6, 4, utf8_decode(isset($consulta["rxFinal"]["add_ojo_izquierdo"]) && $consulta["rxFinal"]["add_ojo_izquierdo"] !== null ? $consulta["rxFinal"]["add_ojo_izquierdo"] : 'sin hallazgos'), 1, 0, 'L');

        $pdf->SetX(115);
        $pdf->Cell(20.6, 4, utf8_decode(isset($consulta["rxFinal"]["prima_base_ojo_izquierdo"]) && $consulta["rxFinal"]["prima_base_ojo_izquierdo"] !== null ? $consulta["rxFinal"]["prima_base_ojo_izquierdo"] : 'sin hallazgos'), 1, 0, 'L');

        $pdf->SetX(135.6);
        $pdf->Cell(20.6, 4, utf8_decode(isset($consulta["rxFinal"]["grados_ojo_izquierdo"]) && $consulta["rxFinal"]["grados_ojo_izquierdo"] !== null ? $consulta["rxFinal"]["grados_ojo_izquierdo"] : 'sin hallazgos'), 1, 0, 'L');

        $pdf->SetX(156.2);
        $pdf->Cell(20.6, 4, utf8_decode(isset($consulta["rxFinal"]["av_lejos_ojo_izquierdo"]) && $consulta["rxFinal"]["av_lejos_ojo_izquierdo"] !== null ? $consulta["rxFinal"]["av_lejos_ojo_izquierdo"] : 'sin hallazgos'), 1, 0, 'L');

        $pdf->SetX(176.8);
        $pdf->Cell(20.6, 4, utf8_decode(isset($consulta["rxFinal"]["av_cerca_ojo_izquierdo"]) && $consulta["rxFinal"]["av_cerca_ojo_izquierdo"] !== null ? $consulta["rxFinal"]["av_cerca_ojo_izquierdo"] : 'sin hallazgos'), 1, 0, 'L');

        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetX(12);
        $pdf->Cell(20.6, 4, utf8_decode('Tipo Lentes:'), 1, 0, 'C', 1);
        $pdf->Cell(165.4, 4, utf8_decode(isset($consulta["rxFinal"]["tipo_lentes"]) && $consulta["rxFinal"]["tipo_lentes"] !== null ? $consulta["rxFinal"]["tipo_lentes"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Ln();

        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetX(12);
        $pdf->Cell(20.6, 4, utf8_decode('Detalle:'), 1, 0, 'C', 1);
        $pdf->Cell(165.4, 4, utf8_decode(isset($consulta["rxFinal"]["detalle"]) && $consulta["rxFinal"]["detalle"] !== null ? $consulta["rxFinal"]["detalle"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Ln();


        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetX(12);
        $pdf->Cell(20.6, 4, utf8_decode('Altura:'), 1, 0, 'C', 1);
        $pdf->Cell(165.4, 4, utf8_decode(isset($consulta["rxFinal"]["altura"]) && $consulta["rxFinal"]["altura"] !== null ? $consulta["rxFinal"]["altura"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Ln();

        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetX(12);
        $pdf->Cell(20.6, 4, utf8_decode('Color y Ttos:'), 1, 0, 'C', 1);
        $pdf->Cell(165.4, 4, utf8_decode(isset($consulta["rxFinal"]["color_ttos"]) && $consulta["rxFinal"]["color_ttos"] !== null ? $consulta["rxFinal"]["color_ttos"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Ln();

        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetX(12);
        $pdf->Cell(20.6, 4, utf8_decode('Dp:'), 1, 0, 'C', 1);
        $pdf->Cell(165.4, 4, utf8_decode(isset($consulta["rxFinal"]["dp"]) && $consulta["rxFinal"]["dp"] !== null ? $consulta["rxFinal"]["dp"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Ln();

        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetX(12);
        $pdf->Cell(20.6, 4, utf8_decode('Uso:'), 1, 0, 'C', 1);
        $pdf->Cell(165.4, 4, utf8_decode(isset($consulta["rxFinal"]["uso"]) && $consulta["rxFinal"]["uso"] !== null ? $consulta["rxFinal"]["uso"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Ln();

        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetX(12);
        $pdf->Cell(20.6, 4, utf8_decode('Control:'), 1, 0, 'C', 1);
        $pdf->Cell(165.4, 4, utf8_decode(isset($consulta["rxFinal"]["control"]) && $consulta["rxFinal"]["control"] !== null ? $consulta["rxFinal"]["control"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Ln();

        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetX(12);
        $pdf->Cell(40.6, 4, utf8_decode('Duración y vigencia:'), 1, 0, 'C', 1);
        $pdf->Cell(145.4, 4, utf8_decode(isset($consulta["rxFinal"]["duracion_vigencia"]) && $consulta["rxFinal"]["duracion_vigencia"] !== null ? $consulta["rxFinal"]["duracion_vigencia"] : 'sin hallazgos'), 1, 0, 'L');
        $pdf->Ln();
        $pdf->Ln();

        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetX(12);
        $pdf->Cell(186, 4, utf8_decode('Observaciones:'), 1, 1, 'C', 1);
        $pdf->SetX(12);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->MultiCell(186, 4, utf8_decode(isset($consulta["rxFinal"]["observaciones"]) && $consulta["rxFinal"]["observaciones"] !== null ? $consulta["rxFinal"]["observaciones"] : 'sin hallazgos'), 1, 0, 'L');


	}
}
