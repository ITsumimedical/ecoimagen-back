<?php

namespace App\Formats;

use App\Http\Modules\AdmisionesUrgencias\Models\AdmisionesUrgencia;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Modules\Reps\Models\Rep;
use App\Http\Modules\Agendas\Models\Agenda;
use App\Http\Modules\Entidad\Models\Entidad;
use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Consultas\Models\Consulta;

use App\Http\Modules\Consultorios\Models\Consultorio;
use App\Http\Modules\TipoDocumentos\Models\TipoDocumento;
use App\Traits\PdfTrait;

class CertificadoAtencionMedicinaIntegral extends FPDF
{
    use PdfTrait;


    public static $consulta;

    public function generar($certificadoAtencionMedicinaIntegral)
    {
        self::$consulta = $certificadoAtencionMedicinaIntegral;
        $this->generarPDF('I');
    }

    public function Header()
    {
        $this->SetFont('Arial', 'B', 50);
        $this->SetTextColor(255, 192, 203);
        $this->SetTextColor(0, 0, 0);

        $logo1 = public_path() . "/images/logoEcoimagen.png";
        $logo2 = public_path() . "/images/medicinaIntegral.jpg";
        // if (self::$afiliado->entidad_id === 1) {
        //     $logo2 = public_path() . "/images/logoFomag.png";
        // } elseif (self::$afiliado->entidad_id === 3) {
        //     $logo2 = public_path() . "/images/logotipo_fps.jpg";
        // }

        // Tamaño del rectángulo
        $rectX = 5;
        $rectY = 5;
        $anchoRectangulo = 55;
        $altoRectangulo = 20;
        $this->Rect($rectX, $rectY, $anchoRectangulo, $altoRectangulo);
        $anchoLogo1 = 20;
        $altoLogo1 = 15;
        $anchoLogo2 = 25;
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
        $this->SetFont('Arial', 'B', 11);

        // Líneas alineadas a la izquierda
        $this->SetXY($posXRectangulo + 7, $Y);
        $this->Cell($anchoCelda, 0, utf8_decode('Código del prestador: 230010092401 Nit: 800250634-3'), 0, 0, 'C');
        $this->SetXY($posXRectangulo + 7, $Y + 5);
        $this->Cell($anchoCelda, 0, utf8_decode('Dirección: CALLE 44 # 14 - 282 MONTERIA Teléfono: Call Center 6046041571'), 0, 0, 'C');
        $this->SetXY($posXRectangulo + 7, $Y + 10);
        $this->Cell($anchoCelda, 0, utf8_decode(' Web: www.medicinaintegralsa.com Email: info@medicinaintegralsa.com'), 0, 0, 'C');

        $rectX = 220;
        $rectY = 5;
        $anchoRectangulo = 53;
        $altoRectangulo = 20;
        $this->Rect($rectX, $rectY, $anchoRectangulo, $altoRectangulo);

        $anchoCelda = $anchoRectangulo - 7; // Resta un pequeño margen para evitar que el texto toque los bordes
        $Y = 12;
        $this->SetFont('Arial', 'B', 8);
        $this->SetXY($rectX, $Y);
        $this->Cell($anchoCelda, 0, utf8_decode('Fecha de impresión:' . date('d/m/Y H:i')), 0, 0, 'L');
        $this->SetFont('Arial', 'B', 10);
        $this->SetXY($rectX, $Y + 5);
        $this->Cell($anchoCelda, 0, utf8_decode('REGISTRO DE ATENCIÓN'), 0, 0, 'L');


        $this->SetY(38);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(280, 6, utf8_decode('CERTIFICADO DE ATENCIÓN'), 0, 0, 'C');
        $this->SetY(43);
        $this->Ln();
        $this->Cell(60, 10, utf8_decode('No ingreso: '), 0, 0, 'R');
        $this->SetFont('Arial', '', 10);
        $this->Cell(5, 10, utf8_decode(self::$consulta->id), 0, 0, 'L');
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(60, 10, utf8_decode('No estudio'), 0, 0, 'R');
        $this->Cell(5, 10, utf8_decode(''), 0, 0, 'L');
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(60, 10, utf8_decode('No Autorización'), 0, 0, 'R');
        $this->Cell(5, 10, utf8_decode(''), 0, 0, 'L');
        $this->Ln();
        $this->SetY(65);
        $this->SetFont('Arial', '', 13);
        $this->MultiCell(280, 4, utf8_decode('Este formato se diligencia ante la imposibilidad de generar factura en el momente del egreso del paciente. Yo ' . self::$consulta->afiliado->primer_nombre . self::$consulta->afiliado->segundo_nombre . ' ' . 'identificado (a) con ' . self::$consulta->afiliado->tipoDocumento->sigla . '-' . self::$consulta->afiliado->numero_documento . ' Certifico que he recibido la atencion medica por la cual consulte a MEDICINA INTEGRAL S.A.S y para constancia queda registrado en mi historia clinica.'), 0, 'L', 0);

        $this->Ln();
        $this->SetFont('Arial', 'B', 13);
        $this->Cell(31, 4, utf8_decode('Aseguradora:'), 0, 0, 'l');
        $this->SetFont('Arial', '', 13);
        $this->Cell(100, 4, utf8_decode(self::$consulta->afiliado->entidad->nombre), 0, 0, 'l');
        $this->Ln();
        $this->Ln();
        $this->SetFont('Arial', 'B', 13);
        $this->Cell(35, 4, utf8_decode('Fecha ingreso:'), 0, 0, 'l');
        $this->SetFont('Arial', '', 13);
        $this->Cell(100, 4, utf8_decode(self::$consulta->hora_inicio_atendio_consulta), 0, 0, 'l');
        $this->SetFont('Arial', 'B', 13);
        $this->Cell(35, 4, utf8_decode('Fecha egreso:'), 0, 0, 'l');
        $this->SetFont('Arial', '', 13);
        $this->Cell(80, 4, utf8_decode(self::$consulta->hora_fin_atendio_consulta), 0, 0, 'l');
    }

    public function body()
    {
    }

    public function footer()
    {
        $yOffset = $this->GetY() + 6;
        $this->SetY($this->GetY() + 22);
        $this->SetFont('Arial', 'B', 10);

        // Firma del paciente
        $base64Image = self::$consulta->admision->firma_afiliado ?? null;
        if ($base64Image) {
            $explodedData = explode(',', $base64Image);

            if (count($explodedData) === 2) {
                $base64Data = $explodedData[1];
                $imageData = base64_decode($base64Data);

                $tempImage = tempnam(sys_get_temp_dir(), 'firma') . '.png';
                file_put_contents($tempImage, $imageData);
                $this->Image($tempImage, 152, $yOffset + 9, 65, 10);
                unlink($tempImage);
            }
        }

        // Firma del acompañante (si existe)
        $firmaAcompanante = self::$consulta->admision->firma_acompanante ?? null;
        if ($firmaAcompanante) {
            $explodedData = explode(',', $firmaAcompanante);

            if (count($explodedData) === 2) {
                $base64Data = $explodedData[1];
                $imageData = base64_decode($base64Data);

                $tempImage = tempnam(sys_get_temp_dir(), 'firma') . '.png';
                file_put_contents($tempImage, $imageData);
                $this->Image($tempImage, 28, $yOffset + 9, 65, 10);
                unlink($tempImage);
            }
        }

        // Etiquetas de firma
        $this->Ln();
        $this->Cell(110, 10, utf8_decode('FIRMA DEL ACOMPAÑANTE '), 0, 0, 'C');
        $this->Cell(130, 10, utf8_decode('FIRMA DEL PACIENTE'), 0, 0, 'C');

        // Usuario
        $this->Ln();
        $this->Ln();
        $this->SetFont('Arial', '', 10);

        $usuarioNombre = auth()->user()->operador->nombre_completo ?? 'Usuario desconocido';
        $this->Cell(100, 4, utf8_decode('Usuario: ' . $usuarioNombre), 0, 0, 'l');
    }

}
