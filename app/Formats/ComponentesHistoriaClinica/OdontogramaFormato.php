<?php

namespace App\Formats\ComponentesHistoriaClinica;

use Illuminate\Support\Facades\Storage;

class OdontogramaFormato
{
    public function bodyComponente($pdf, $consulta): void
    {
                $y = $pdf->GetY();
        if ($y === 257.00125 || $y === 239.00125 || $y === 255.00125) {
            $y = $pdf->AddPage() + 10;
        }

                //ODONTOGRAMA IMAGEN
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
        $pdf->Ln();
        $pdf->Ln();
         

          if ($consulta->OdontogramaIndicadores) {
            $odonto = $consulta->OdontogramaIndicadores;

            $pdf->SetFont('Arial','B',12);
           
            $pdf->SetDrawColor(0,0,0);    // Borde negro
            $pdf->SetFillColor(200,200,200); // Fondo gris
            $pdf->Rect(12, $y, 186, 8, 'DF'); // Franja //$y representa el valor para la ubicacion 
            $pdf->SetXY(12, $y);

            $pdf->Cell(31, 8, 'COP-C', 1, 0, 'C'); 
            $pdf->Cell(31, 8, 'COP-O', 1, 0, 'C'); 
            $pdf->Cell(31, 8, 'COP-P', 1, 0, 'C'); 
            $pdf->Cell(31, 8, 'CEO-C', 1, 0, 'C'); 
            $pdf->Cell(31, 8, 'CEO-E', 1, 0, 'C'); 
            $pdf->Cell(31, 8, 'CEO-O', 1, 1, 'C'); 

            $pdf->SetFont('Arial','',11);
             $pdf->SetX(12);
            $pdf->Cell(31, 8, $odonto->cop_c, 1, 0, 'C');
            $pdf->Cell(31, 8, $odonto->cop_o, 1, 0, 'C');
            $pdf->Cell(31, 8, $odonto->cop_p, 1, 0, 'C');
            $pdf->Cell(31, 8, $odonto->ceo_c, 1, 0, 'C');
            $pdf->Cell(31, 8, $odonto->ceo_e, 1, 0, 'C');
            $pdf->Cell(31, 8, $odonto->ceo_o, 1, 0, 'C');
        } else {
            $pdf->Cell(0, 8, 'No hay indicadores registrados para esta consulta.', 1, 1, 'C');
        }

        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
    }
}
