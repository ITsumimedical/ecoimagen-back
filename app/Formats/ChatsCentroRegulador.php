<?php

namespace App\Formats;

use App\Traits\PdfTrait;
use Codedge\Fpdf\Fpdf\Fpdf;

class ChatsCentroRegulador extends Fpdf
{
    use PdfTrait;

    public function generar($mensajes)
    {

        $this->SetAutoPageBreak(true, 15);
        $this->AddPage();
        $this->SetFont('Arial', '', 10);

        // Calcular el ancho máximo de usuario
        $maxUserWidth = 0;
        foreach ($mensajes as $msg) {
            $texto = utf8_decode($msg->user->email ?? 'N/A');
            $w = $this->GetStringWidth($texto) + 6; // 6 = margen interno
            if ($w > $maxUserWidth) {
                $maxUserWidth = $w;
            }
        }

        if ($maxUserWidth > 90) {
            $maxUserWidth = 90;
        }

        // Ahora definimos anchos
        $widths = [
            15, // Hora
            20, // Fecha
            $maxUserWidth, // Usuario dinámico
            190 - (15 + 20 + $maxUserWidth) // Mensaje = resto disponible
        ];

        $this->printHeader($widths);

        foreach ($mensajes as $mensaje) {
            $createdAt = isset($mensaje->created_at) ? strtotime($mensaje->created_at) : time();
            $fecha = date('Y-m-d', $createdAt);
            $hora  = date('H:i', $createdAt);
            $email = isset($mensaje->user->email) ? utf8_decode($mensaje->user->email) : 'N/A';
            $texto = utf8_decode((string)($mensaje->mensaje ?? ''));

            $height = $this->calculateHeight($widths[3], $texto, 10);

            // Si no cabe en la página, agregar página y reimprimir encabezado
            if ($this->GetY() + $height > $this->PageBreakTrigger) {
                $this->AddPage();
                $this->printHeader($widths);
            }

            $x = $this->GetX();
            $y = $this->GetY();

            // Dibujar celdas Fecha, Hora, Usuario
            $this->Cell($widths[1], $height, $fecha, 1, 0, 'C');
            $this->Cell($widths[0], $height, $hora, 1, 0, 'C');
            $this->Cell($widths[2], $height, $email, 1, 0, 'C');

            // MultiCell para el mensaje (se posiciona al final en la columna de mensaje)
            $this->SetXY($x + $widths[1] + $widths[0] + $widths[2], $y);
            $this->MultiCell($widths[3], 10, $texto, 1);

            // Mover cursor al inicio de la siguiente fila
            $this->SetXY($x, $y + $height);
        }
        $this->Output();
    }

    private function printHeader(array $widths)
    {
        $this->SetFont('Arial', 'B', 12);
        $this->SetFillColor(200, 220, 255);
        $this->Cell($widths[1], 10, 'Fecha', 1, 0, 'C', true);
        $this->Cell($widths[0], 10, 'Hora', 1, 0, 'C', true);
        $this->Cell($widths[2], 10, 'Usuario', 1, 0, 'C', true);
        $this->Cell($widths[3], 10, 'Mensaje', 1, 1, 'C', true);

        $this->SetFont('Arial', '', 10);
        $this->SetFillColor(245, 245, 245);
    }

    // Calcula la altura necesaria sin crear un FPDF temporal
    private function calculateHeight($width, $text, $lineHeight = 10)
    {
        // Crear un FPDF temporal
        $tempPdf = new Fpdf();
        $tempPdf->AddPage();
        $tempPdf->SetFont('Arial', '', 10);

        $x = $tempPdf->GetX();
        $y = $tempPdf->GetY();
        $tempPdf->MultiCell($width, 10, $text);
        $newY = $tempPdf->GetY();

        // Calcular la altura como la diferencia entre la nueva y la antigua posición Y
        $height = $newY - $y;

        return $height;
    }

    // Implementación de NbLines (basada en la versión de FPDF)
    private function nbLines($w, $txt)
    {
        $cw = $this->CurrentFont['cw'];
        if ($w == 0) {
            $w = $this->w - $this->rMargin - $this->x;
        }
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = ord($s[$i]);
            if ($c == 10) {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == 32) {
                $sep = $i;
            }
            $l += isset($cw[$c]) ? $cw[$c] : 0;
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j) {
                        $i++;
                    }
                } else {
                    $i = $sep + 1;
                }
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else {
                $i++;
            }
        }
        return $nl;
    }
}
