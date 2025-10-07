<?php

namespace App\Formats;

use App\Http\Modules\Afiliados\Models\Afiliado;
use Illuminate\Support\Carbon;
use Codedge\Fpdf\Fpdf\Fpdf;

class CertificadoAfiliadoFerrocarriles extends FPDF
{

    public static $afiliado;

    /**
     * Genero la consulta para traer los datos del afiliado
     *
     * @param $id es el id del afiliado
     * @return void
     */
    function generar($afiliado)
    {

        self::$afiliado = Afiliado::select(
            'tipo_documentos.nombre as nombre_tipo_documento',
            'afiliados.numero_documento as numero_documento',
            'municipios.nombre as nombre_municipio',
            'estados.nombre as nombre_estado',
            'tipo_afiliados.nombre as tipo_afiliado',
            // 'reporte_certificados.id as idCertificado'
        )
            ->selectRaw("CONCAT(primer_nombre, ' ', segundo_nombre, ' ', primer_apellido, ' ', segundo_apellido) as nombre_afiliado")
            ->join('tipo_documentos', 'afiliados.tipo_documento', 'tipo_documentos.id')
            ->join('municipios', 'afiliados.municipio_atencion_id', 'municipios.id')
            ->join('estados', 'afiliados.estado_afiliacion_id', 'estados.id')
            ->join('tipo_afiliados', 'afiliados.tipo_afiliado_id', 'tipo_afiliados.id')
            ->where('afiliados.id', $afiliado)
            //     // ->join('reporte_certificados', 'afiliados.id', 'reporte_certificados.afiliado_id')
            //     // ->latest('reporte_certificados.id')

            ->first();
        $pdf = new CertificadoAfiliadoFerrocarriles('P', 'mm', 'A4');
        setlocale(LC_TIME, "es_ES");
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $this->body($pdf);
        $pdf->Output();
    }

    public function header()
    {
        $logo1 = public_path() . "/images/vidaColombia.jpg";
        $this->SetFont('Arial', 'B', 15);
        $this->SetDrawColor(255, 255, 255);
        $this->Rect(5, 5, 200, 287);
        $this->SetDrawColor(0, 0, 0);

        $logo2 = public_path() . "/images/logotipo_fps.jpg";
        $this->SetFont('Arial', 'B', 15);
        $this->SetDrawColor(255, 255, 255);
        $this->Rect(5, 5, 200, 287);
        $this->SetDrawColor(0, 0, 0);

        $this->Image($logo1, 18, 15, 40, 10);
        $this->Image($logo2, 140, 15, 50, 10);

        $this->SetXY(10, 40);
        // $this->Cell(192, 4, utf8_decode('NIT '), 0, 0, 'C');
        $this->Ln();
    }

    public function footer()
    {
        $this->SetY(-26);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $logo2 = public_path() . "/images/bannerFPS.jpg";
        $this->Image($logo2, 28, $this->GetY() + 0, 156);
        // Número de página
        //  $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}'), 0, 0, 'C');
    }

    public function body($pdf)
    {
        // dd(self::$afiliado);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln();

        $titulo = $pdf->GetY();
        $pdf->SetXY(16, $titulo + 16);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->MultiCell(175, 5, utf8_decode('EL FONDO DE PASIVO SOCIAL DE FERROCARRILES NACIONALES DE COLOMBIA
        NIT 800.112.806-2
        '), 0, 'C');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->MultiCell(175, 5, utf8_decode('CERTIFICA QUE'), 0, 'C');
        $pdf->Ln();

        $descripcion = $pdf->GetY();
        $pdf->SetXY(16, $descripcion + 12);
        $pdf->SetFont('Arial', '', 11);
        $pdf->MultiCell(175, 5, utf8_decode('Que el (la) señor (a)' . ' ' . utf8_decode(self::$afiliado->nombre_afiliado) . ' ' .
            'identificado(a) con' . ' ' . self::$afiliado->nombre_tipo_documento . ' ' . ' N°' . ' ' . self::$afiliado->numero_documento . ' ' .
            'se encuentra en estado ' . strtoupper(self::$afiliado->nombre_estado) . ' '
            . 'afiliado (a) a esta Entidad Adaptada en Salud en el Régimen Contributivo como' . ' ' .
            self::$afiliado->tipo_afiliado . ' ' . 'para la prestación de los servicios médicos en la ciudad de' . ' ' . self::$afiliado->nombre_municipio) . '.', 0, 'J');
        $pdf->Ln();

        $y = $pdf->GetY();
        $pdf->SetXY(16, $y + 10);
        $pdf->SetFont('Arial', '', 12);
        $pdf->MultiCell(175, 5, utf8_decode('El presente certificado se expide a solicitud del (la) interesado (a), a los ' . $dia = Carbon::now()->isoFormat('D [días del mes de] MMMM [del] YYYY' . '.')), 0, 'J');
        $pdf->Ln();
        $y = $pdf->GetY();
        $pdf->SetXY(16, $y + 10);
        $pdf->SetFont('Arial', '', 12);
        $pdf->MultiCell(175, 5, utf8_decode('Observaciones:'), 0, 'J');
        $y = $pdf->GetY();
        $pdf->SetXY(16, $y + 2);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(179, 5, utf8_decode('Información sujeta a verificación por parte del FONDO DE PASIVO SOCIAL DE FCN, cualquier aclaración con gusto será atendida en la línea (601) 3817171 - Documento no válido como autorización de traslado ni aclaración de multiafiliación en el SGSSS'), 0, 'J');
        $pdf->Ln();
        $y = $pdf->GetY();
        $pdf->SetXY(16, $y);
        $pdf->SetFont('Arial', '', 12);
        $pdf->MultiCell(175, 5, utf8_decode('Cordialmente,'), 0, 'J');
        $pdf->Image(public_path() . "/images/firmaFerro.jpg", 16, $y + 4, 30, 20);
        $pdf->SetXY(16, $y + 25);
        $pdf->SetFont('Arial', '', 12);
        $pdf->MultiCell(175, 5, utf8_decode('HEIDY YULI SANCHEZ GONZALEZ'), 0, 'J');
        $pdf->SetX(16);
        $pdf->MultiCell(175, 9, utf8_decode('FPS FCN: Subdirectora de Prestaciones Sociales'), 0, 'J');
        $pdf->SetX(16);
        $pdf->SetFont('Arial', '', 12);
        $pdf->MultiCell(175, 5, utf8_decode('Elaboró: AFILIACIONES Y COMPENSACION.'), 0, 'J');
        $pdf->SetX(16);
        // $pdf->SetFont('Arial', 'B', 12);
        // $pdf->MultiCell(175, 5, utf8_decode('Consecutivo:'. self::$afiliado->idCertificado), 0, 'J');

    }
}
