<?php

namespace App\Formats;

use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Agendas\Models\Agenda;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Consultorios\Models\Consultorio;
use App\Http\Modules\Entidad\Models\Entidad;
use App\Http\Modules\Movimientos\Models\Movimiento;
use App\Http\Modules\Ordenamiento\Models\Orden;
use App\Http\Modules\Reps\Models\Rep;
use Codedge\Fpdf\Fpdf\Fpdf;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CertificadoAtencionMedica extends FPDF
{

    public static $consulta;
    public static $afiliado;
    public static $entidad;
    public static $rep;

    public function generar($data, $guardar = false, $rutaCertificado = null)
    {
        self::$consulta = Consulta::find($data['consulta']);
        self::$afiliado = Afiliado::find(self::$consulta->afiliado_id);
        self::$entidad = Entidad::find(self::$afiliado->entidad_id);
        if (self::$consulta->agenda_id) {
            $agenda = Agenda::find(self::$consulta->agenda_id);
            $consultorio = Consultorio::find($agenda->consultorio_id);
            self::$rep = Rep::find($consultorio->rep_id);
        } else {
            self::$rep = Rep::find(self::$consulta->rep_id);
        }

        // return self::$ordenesCompra;

        $pdf = new CertificadoAtencionMedica('L', 'mm', [285, 150]);
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $this->body($pdf);
        if (!$guardar) {
            $pdf->Output();
        } else {
            $rutaAfiliado = $rutaCertificado . '/' . self::$afiliado->numero_documento;
            if (!File::exists($rutaAfiliado)) {
                File::makeDirectory($rutaAfiliado, 0777, true, true);
            }
            $pdf->Output('F', $rutaAfiliado . '/' . $data['consulta'] . '_' . self::$afiliado->numero_documento . '_' . date('Y_m_d') . '.pdf');
        }
    }


    public function Header()
    {
        $this->SetFont('Arial', 'B', 50);
        $this->SetTextColor(255, 192, 203);
        $this->SetTextColor(0, 0, 0);

        $logo1 = public_path() . "/images/logo.png";
        if (self::$afiliado->entidad_id === 1) {
            $logo2 = public_path() . "/images/logoFomag.png";
        } elseif (self::$afiliado->entidad_id === 3) {
            $logo2 = public_path() . "/images/logotipo_fps.jpg";
        } else {
            $logo2 = public_path() . "/images/logoNuevaEps.png";
        }

        // Tamaño del rectángulo
        $rectX = 5;
        $rectY = 5;
        $anchoRectangulo = 55;
        $altoRectangulo = 20;
        $this->Rect($rectX, $rectY, $anchoRectangulo, $altoRectangulo);
        $anchoLogo1 = 20;
        $altoLogo1 = 15;
        $anchoLogo2 = 17;
        $altoLogo2 = 14;

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
        $this->SetXY($posXRectangulo + 15, $Y);
        $this->Cell($anchoCelda, 0, utf8_decode('CERTIFICADO DE SERVICIOS DE FACTURACIÓN '), 0, 0, 'L');

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
        $this->Cell(60, 6, utf8_decode('NOMBRE COMPLETO DEL USUARIO:' . ' ' . self::$afiliado->nombre_completo), 0, 0);
        $this->SetY($this->GetY() + 7);
        $this->Cell($anchoCelda, 0, utf8_decode("DOCUMENTO DE IDENTIDAD:" . ' ' . self::$afiliado->numero_documento), 0, 0, 'L');
        $this->SetY($this->GetY() + 4);
        $this->Cell($anchoCelda, 0, utf8_decode("TELÉFONO:" . ' ' . self::$afiliado->celular1 . '  ' . 'ENTIDAD RESPONSABLE DE PAGO:' . ' ' . self::$entidad->nombre), 0, 0, 'L');
        $this->SetY($this->GetY() + 4);

        $fechaFormateada = substr(self::$consulta->hora_inicio_atendio_consulta, 0, 10);
        $fechaFormateada2 = substr(self::$consulta->hora_fin_atendio_consulta, 0, 10);
        $this->Cell($anchoCelda, 0, utf8_decode("FECHA INGRESO:" . ' ' . $fechaFormateada . '  ' . 'FECHA EGRESO:' . ' ' . $fechaFormateada2), 0, 0, 'L');
        $this->SetY($this->GetY() + 10);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(260, 0, utf8_decode("CERTIFICO:"), 0, 0, 'C');
        $this->SetY($this->GetY() + 7);
        $this->SetFont('Arial', '', 10);
        $this->MultiCell(260, 4, utf8_decode("Que he sido atendido (a) en " . self::$rep->nombre . ", recibiendo los servicios que se facturan y de los cuales existe evidencia en mi historia clínica."), 0, 'L', 0);
        $this->SetY($this->GetY() + 7);
        $this->Cell($anchoCelda, 0, utf8_decode("Se diligencia este documento para que sea enviado con la respectiva factura."), 0, 0, 'L');
    }

    public function body($pdf) {}

    public function footer()
    {
        $yOffset = $this->GetY() + 6;

        $this->SetY($this->GetY() + 22);
        $this->SetFont('Arial', 'B', 10);

        $firma = Movimiento::select('firma_persona_recibe')
            ->join('ordenes as o', 'o.id', '=', 'movimientos.orden_id')
            ->join('consultas as c', 'c.id', '=', 'o.consulta_id')
            ->join('afiliados as a', 'a.id', '=', 'c.afiliado_id')
            ->where('a.numero_documento', self::$afiliado->numero_documento)
            ->whereNotNull('movimientos.firma_persona_recibe')
            ->orderByDesc('movimientos.updated_at')
            ->first();
        Consulta::where('id', self::$consulta->id)
            ->update(['firma_paciente' => $firma['firma_persona_recibe']]);
        $base64Image = $firma['firma_persona_recibe'];

        $explodedData = explode(',', $base64Image);
        $type = $explodedData[0];
        $base64Data = $explodedData[1];
        $imageData = base64_decode($base64Data);

        $tempImage = tempnam(sys_get_temp_dir(), 'firma') . '.png';
        file_put_contents($tempImage, $imageData);
        $this->Image($tempImage, 15, $yOffset + 4, 73, 14);
        unlink($tempImage);

        if (isset(self::$consulta->firma_acompanante)) {
            $base64Image = self::$consulta->firma_acompanante;
            $explodedData = explode(',', $base64Image);
            $type = $explodedData[0];
            $base64Data = $explodedData[1];
            $imageData = base64_decode($base64Data);

            $tempImage = tempnam(sys_get_temp_dir(), 'firma') . '.png';
            file_put_contents($tempImage, $imageData);
            $this->Image($tempImage, 93, $yOffset + 5, 65, 10);
            unlink($tempImage);
        }

        if (isset(self::$consulta->firma_acompanante)) {
            $this->Ln();
            $this->Cell(70, 10, utf8_decode('FIRMA DEL USUARIO '), 0, 0, 'C');
            $this->Cell(70, 10, utf8_decode('FIRMA DEL ACOMPAÑANTE'), 0, 0, 'C');
            $this->Cell(70, 10, utf8_decode('NUMERO IDENTIFICACION'), 0, 0, 'C');
            $this->Cell(70, 10, utf8_decode('TELEFONO'), 0, 0, 'C');

            $this->Ln();
            $this->Cell(345, -26, utf8_decode(self::$afiliado->numero_documento), 0, 1, 'C', false);
            $this->Cell(490, 30, utf8_decode(self::$afiliado->celular1), 0, 0, 'C', false);
        } else {
            $this->Ln();
            $this->Cell(70, 10, utf8_decode('FIRMA DEL USUARIO '), 0, 0, 'C');
            // $this->Cell(70, 10, utf8_decode('FIRMA DEL ACOMPAÑANTE'), 0, 0, 'C');
            $this->Cell(110, 10, utf8_decode('NUMERO IDENTIFICACION'), 0, 0, 'C');
            $this->Cell(90, 10, utf8_decode('TELEFONO'), 0, 0, 'C');
            $this->Ln();
            $this->Cell(250, -26, utf8_decode(self::$afiliado->numero_documento), 0, 1, 'C', false);
            $this->Cell(450, 30, utf8_decode(self::$afiliado->celular1), 0, 0, 'C', false);
        }
        $this->SetFont('Arial', 'B', 50);
        $this->SetTextColor(255, 192, 203);
        $this->SetTextColor(0, 0, 0);

        $this->Ln();
        // $logo1 = public_path() . "/images/banner.jpg";
        // $this->Image($logo1,0,130,0,20,);

    }
}
