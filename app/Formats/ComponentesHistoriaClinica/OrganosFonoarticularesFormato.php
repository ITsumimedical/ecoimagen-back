<?php

namespace App\Formats\ComponentesHistoriaClinica;

class OrganosFonoarticularesFormato
{
    public function bodyComponente($pdf, $consulta): void
    {
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('Organos Fonoarticulatorios'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "Lengua: " . utf8_decode(isset($consulta["organosFonoarticulatorios"]["lengua"]) && $consulta["organosFonoarticulatorios"]["lengua"] !== null ? $consulta["organosFonoarticulatorios"]["lengua"] : 'sin hallazgos'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "Paladar: " . utf8_decode(isset($consulta["organosFonoarticulatorios"]["paladar"]) && $consulta["organosFonoarticulatorios"]["paladar"] !== null ? $consulta["organosFonoarticulatorios"]["paladar"] : 'sin hallazgos'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "Labios: " . utf8_decode(isset($consulta["organosFonoarticulatorios"]["labios"]) && $consulta["organosFonoarticulatorios"]["labios"] !== null ? $consulta["organosFonoarticulatorios"]["labios"] : 'sin hallazgos'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "Mucosa: " . utf8_decode(isset($consulta["organosFonoarticulatorios"]["mucosa"]) && $consulta["organosFonoarticulatorios"]["mucosa"] !== null ? $consulta["organosFonoarticulatorios"]["mucosa"] : 'sin hallazgos'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "Amigdalas Palatinas: " . utf8_decode(isset($consulta["organosFonoarticulatorios"]["amigdalas_palatinas"]) && $consulta["organosFonoarticulatorios"]["amigdalas_palatinas"] !== null ? $consulta["organosFonoarticulatorios"]["amigdalas_palatinas"] : 'sin hallazgos'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "Tono: " . utf8_decode(isset($consulta["organosFonoarticulatorios"]["tono"]) && $consulta["organosFonoarticulatorios"]["tono"] !== null ? $consulta["organosFonoarticulatorios"]["tono"] : 'sin hallazgos'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "Timbre: " . utf8_decode(isset($consulta["organosFonoarticulatorios"]["timbre"]) && $consulta["organosFonoarticulatorios"]["timbre"] !== null ? $consulta["organosFonoarticulatorios"]["timbre"] : 'sin hallazgos'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "Volumen: " . utf8_decode(isset($consulta["organosFonoarticulatorios"]["volumen"]) && $consulta["organosFonoarticulatorios"]["volumen"] !== null ? $consulta["organosFonoarticulatorios"]["volumen"] : 'sin hallazgos'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "Modo Respiratorio: " . utf8_decode(isset($consulta["organosFonoarticulatorios"]["modo_respiratorio"]) && $consulta["organosFonoarticulatorios"]["modo_respiratorio"] !== null ? $consulta["organosFonoarticulatorios"]["modo_respiratorio"] : 'sin hallazgos'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "Tipo Respiratorio: " . utf8_decode(isset($consulta["organosFonoarticulatorios"]["tipo_respiratorio"]) && $consulta["organosFonoarticulatorios"]["tipo_respiratorio"] !== null ? $consulta["organosFonoarticulatorios"]["tipo_respiratorio"] : 'sin hallazgos'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "Evaluacion Postural: " . utf8_decode(isset($consulta["organosFonoarticulatorios"]["evaluacion_postural"]) && $consulta["organosFonoarticulatorios"]["evaluacion_postural"] !== null ? $consulta["organosFonoarticulatorios"]["evaluacion_postural"] : 'sin hallazgos'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "Rendimiento Vocal: " . utf8_decode(isset($consulta["organosFonoarticulatorios"]["rendimiento_vocal"]) && $consulta["organosFonoarticulatorios"]["rendimiento_vocal"] !== null ? $consulta["organosFonoarticulatorios"]["rendimiento_vocal"] : 'sin hallazgos'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "Prueba de Glatzel: " . utf8_decode(isset($consulta["organosFonoarticulatorios"]["prueba_de_glatzel"]) && $consulta["organosFonoarticulatorios"]["prueba_de_glatzel"] !== null ? $consulta["organosFonoarticulatorios"]["prueba_de_glatzel"] : 'sin hallazgos'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "Golpe Glotico: " . utf8_decode(isset($consulta["organosFonoarticulatorios"]["golpe_glotico"]) && $consulta["organosFonoarticulatorios"]["golpe_glotico"] !== null ? $consulta["organosFonoarticulatorios"]["golpe_glotico"] : 'sin hallazgos'), 1, 'L', 0);

        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, "Conducto Auditivo Externo: " . utf8_decode(isset($consulta["organosFonoarticulatorios"]["conducto_auditivo_externo"]) && $consulta["organosFonoarticulatorios"]["conducto_auditivo_externo"] !== null ? $consulta["organosFonoarticulatorios"]["conducto_auditivo_externo"] : 'sin hallazgos'), 1, 'L', 0);

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln();
    }
}
