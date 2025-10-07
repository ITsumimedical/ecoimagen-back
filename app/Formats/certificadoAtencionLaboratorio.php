<?php

namespace App\Formats;

use App\Traits\PdfTrait;
use Codedge\Fpdf\Fpdf\Fpdf;

class CertificadoAtencionLaboratorio extends FPDF
{

    use PdfTrait;

    public static $ordenProcedimiento;
    public static $clase;

    public function generar($certificadoLaboratorio)
    {


        self::$ordenProcedimiento = $certificadoLaboratorio->ordenProcedimiento;
        self::$clase = $certificadoLaboratorio->clase;

        $this->generarPDF('I');
    }


    public function Header()
    {
        $this->SetFont('Arial', 'B', 50);
        $this->SetTextColor(255, 192, 203);
        $this->SetTextColor(0, 0, 0);

        if (self::$clase == 'sumi') {
            $logo1 = public_path() . "/images/logo.png";
        } else {
            $logo1 = public_path() . "/images/logoSynlab.png";
        }

        if (self::$ordenProcedimiento->entidad_id === 1) {
            $logo2 = public_path() . "/images/logoFomag.png";
        } elseif (self::$ordenProcedimiento->entidad_id === 3) {
            $logo2 = public_path() . "/images/logotipo_fps.jpg";
        }

        // Tamaño del rectángulo
        $rectX = 5;
        $rectY = 5;
        $anchoRectangulo = 55;
        $altoRectangulo = 20;
        $this->Rect($rectX, $rectY, $anchoRectangulo, $altoRectangulo);
        $anchoLogo1 = 20;
        $altoLogo1 = 15;
        $anchoLogo2 = 20;
        $altoLogo2 = 15;

        // Centrar logo1 en el rectángulo
        $posXLogo1 = $rectX + ($anchoRectangulo / 4) - ($anchoLogo1 / 2);
        $posYLogo1 = $rectY + ($altoRectangulo / 2) - ($altoLogo1 / 2);
        $this->Image($logo1, $posXLogo1, $posYLogo1, $anchoLogo1, $altoLogo1);

        // Centrar logo2 en el rectángulo
        $posXLogo2 = $rectX + (3 * $anchoRectangulo / 4) - ($anchoLogo2 / 2);
        $posYLogo2 = $rectY + ($altoRectangulo / 2) - ($altoLogo2 / 2);
        $this->Image($logo2, $posXLogo2, $posYLogo2, $anchoLogo2, $altoLogo2);


        $Y = 12;
        $this->SetFont('Arial', 'B', 9);
        $anchoRectangulo = 160; // Ancho del rectángulo
        $altoRectangulo = 20;  // Alto del rectángulo
        $posXRectangulo = 60;  // Posición X del rectángulo
        $posYRectangulo = 5;   // Posición Y del rectángulo

        // Dibuja el rectángulo
        $this->Rect($posXRectangulo, $posYRectangulo, $anchoRectangulo, $altoRectangulo);

        // Centrar el contenido dentro del rectángulo
        $anchoCelda = $anchoRectangulo - 10; // Resta un pequeño margen para evitar que el texto toque los bordes
        $Y = 12;
        $this->SetFont('Arial', 'B', 15);

        // Líneas alineadas a la izquierda
        $this->SetXY($posXRectangulo + 14, $Y);
        $this->Cell($anchoCelda, 0, utf8_decode('CERTIFICADO DE LABORATORIOS'), 0, 0, 'C');

        $rectX = 220;
        $rectY = 5;
        $anchoRectangulo = 60;
        $altoRectangulo = 20;
        $this->Rect($rectX, $rectY, $anchoRectangulo, $altoRectangulo);

        $anchoCelda = $anchoRectangulo - 10; // Resta un pequeño margen para evitar que el texto toque los bordes
        $Y = 12;
        $this->SetFont('Arial', 'B', 10);
        $this->SetXY($rectX + 10, $Y);
        $this->Cell($anchoCelda, 0, utf8_decode('CODIGO:FO-FC-007 '), 0, 0, 'L');
        // $this->Ln();
        $this->SetFont('Arial', 'B', 10);
        $this->SetXY($rectX + 10, $Y + 4);
        $this->Cell($anchoCelda, 0, utf8_decode('Versión: 01 '), 0, 0, 'L');
        $this->SetFont('Arial', 'B', 7);
        $this->SetXY($rectX + 10, $Y + 8);
        $this->Cell($anchoCelda, 0, utf8_decode('Fecha de aprobación:02/06/2023 '), 0, 0, 'L');

        $this->SetY(35);
        $this->SetFont('Arial', '', 10);
        $this->Cell(60, 6, utf8_decode('NOMBRE COMPLETO DEL USUARIO:' . ' ' . self::$ordenProcedimiento->primer_nombre . ' ' . self::$ordenProcedimiento->segundo_nombre . ' ' . self::$ordenProcedimiento->primer_apellido . ' ' . self::$ordenProcedimiento->segundo_apellido), 0, 0);
        $this->SetY($this->GetY() + 7);
        $this->Cell(50, 0, utf8_decode("DOCUMENTO DE IDENTIDAD:" . ' ' . self::$ordenProcedimiento->numero_documento), 0, 0, 'L');
        $this->SetY($this->GetY() + 4);
        $this->Cell(50, 0, utf8_decode("TELÉFONO:" . ' ' . self::$ordenProcedimiento->celular1), 0, 0, 'L');
        $this->SetY($this->GetY() + 4);
        $this->Cell(50, 0, utf8_decode('ENTIDAD RESPONSABLE DE PAGO:' . ' ' . self::$ordenProcedimiento->nombreSede), 0, 0, 'L');
        $this->SetY($this->GetY() + 4);
        $this->Cell(50, 0, utf8_decode('FECHA DE ATENCIÓN:' . ' ' . self::$ordenProcedimiento->fecha_firma), 0, 0, 'L');

        // $fechaFormateada = substr(self::$consulta->hora_inicio_atendio_consulta, 0, 10);
        // $fechaFormateada2 = substr(self::$consulta->hora_fin_atendio_consulta, 0, 10);
        // $this->Cell($anchoCelda, 0, utf8_decode("FECHA INGRESO:" . ' ' . $fechaFormateada . '  ' . 'FECHA EGRESO:' . ' ' . $fechaFormateada2), 0, 0, 'L');
        $this->SetY($this->GetY() + 10);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(260, 0, utf8_decode("CERTIFICO:"), 0, 0, 'C');
        // $this->SetY($this->GetY() + 7);
        $this->Ln();
        $this->Ln();
        $this->SetXY(14, 70);
        $this->SetFont('Arial', '', 10);
        $sede = self::$ordenProcedimiento->rep->nombre ?? 'Sin direccionamiento';
        $this->MultiCell(250, 4, utf8_decode('Que en Sumimedical sede ' . $sede . " me prestaron el servicio de " . self::$ordenProcedimiento->cup->codigo_nombre), 0, 'L', 0);
        $this->Ln();
    }

    public function body()
    {}

    public function footer()
    {
        $yOffset = $this->GetY() + 6;

        $this->SetY($this->GetY() + 22);
        $this->SetFont('Arial', 'B', 10);

        $base64Image = self::$ordenProcedimiento->firma_paciente;
        $explodedData = explode(',', $base64Image);
        $type = $explodedData[0];
        $base64Data = $explodedData[1];
        $imageData = base64_decode($base64Data);

        $tempImage = tempnam(sys_get_temp_dir(), 'firma') . '.png';
        file_put_contents($tempImage, $imageData);
        $this->Image($tempImage, 19, $yOffset + 7, 75, 10);
        unlink($tempImage);

        $this->Ln();
        $this->Cell(75, 10, utf8_decode('FIRMA DEL USUARIO '), 0, 0, 'C');
        $this->Cell(105, 10, utf8_decode('NUMERO IDENTIFICACION'), 0, 0, 'C');
        $this->Cell(90, 10, utf8_decode('TELEFONO'), 0, 0, 'C');
        $this->Ln();
        $this->Cell(250, -26, utf8_decode(self::$ordenProcedimiento->numero_documento), 0, 1, 'C', false);
        $this->Cell(450, 30, utf8_decode(self::$ordenProcedimiento->celular1), 0, 0, 'C', false);
        $this->SetFont('Arial', 'B', 50);
        $this->SetTextColor(255, 192, 203);
        $this->SetTextColor(0, 0, 0);

        $this->Ln();
        $logo1 = public_path() . "/images/banner2.jpg";
        $this->Image($logo1, 0, 130, 0, 20,);
    }
}
