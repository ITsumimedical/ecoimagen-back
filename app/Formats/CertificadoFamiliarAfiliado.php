<?php

namespace App\Formats;

use App\Http\Modules\Afiliados\Models\Afiliado;
use Illuminate\Support\Carbon;
use Codedge\Fpdf\Fpdf\Fpdf;

class CertificadoFamiliarAfiliado extends FPDF
{

    public static $cotizante;
    public static $beneficiarios;
    public static $yoAfiliado;



    /**
     * Genero la consulta para traer los datos del afiliado
     *
     * @param $id es el id del afiliado
     * @return void
     */
    function generar($afiliado)
    {

        self::$yoAfiliado = Afiliado::find($afiliado);
        // dd(self::$yoAfiliado->tipo_afiliado_id);
        if (in_array(self::$yoAfiliado->tipo_afiliado_id, [1, 3, 6])) {
            //Beneficiario
            self::$cotizante = Afiliado::select(
                'afiliados.primer_nombre',
                'afiliados.segundo_nombre',
                'afiliados.primer_apellido',
                'afiliados.segundo_apellido',
                'tipo_documentos.nombre as nombre_tipo_documento',
                'tipo_documentos.sigla as sigla_tipo_documento',
                'afiliados.numero_documento',
                'afiliados.estado_afiliacion_id',
                'afiliados.tipo_afiliado_id',
                'estados.nombre as nombreEstado',
                'municipios.nombre as nombreMunicipio',
                // 'reporte_certificados.id as idCertificado'
            )
                ->join('tipo_documentos', 'afiliados.tipo_documento', 'tipo_documentos.id')
                ->join('municipios', 'afiliados.municipio_atencion_id', '=', 'municipios.id')
                ->join('estados', 'afiliados.estado_afiliacion_id', '=', 'estados.id')
                // ->join('reporte_certificados', 'afiliados.id', 'reporte_certificados.afiliado_id')
                ->where('afiliados.id', self::$yoAfiliado->id)
                // ->latest('reporte_certificados.id')
                ->first();
            self::$beneficiarios = Afiliado::select(
                'afiliados.primer_nombre',
                'afiliados.segundo_nombre',
                'afiliados.primer_apellido',
                'afiliados.segundo_apellido',
                'tipo_documentos.nombre as nombre_tipo_documento',
                'tipo_documentos.sigla as sigla_tipo_documento',
                'afiliados.numero_documento',
                'afiliados.estado_afiliacion_id',
                'afiliados.tipo_afiliado_id',
                'afiliados.fecha_afiliacion',
                'municipios.nombre as nombreMunicipio',
                'estados.nombre as nombreEstado'
            )
                ->join('tipo_documentos', 'afiliados.tipo_documento', 'tipo_documentos.id')
                ->join('municipios', 'afiliados.municipio_atencion_id', '=', 'municipios.id')
                ->join('estados', 'afiliados.estado_afiliacion_id', '=', 'estados.id')
                ->where('afiliados.numero_documento', self::$yoAfiliado->numero_documento_cotizante)
                ->get();
            // return self::$beneficiarios;
        } else {
            //Cotizante
            self::$cotizante = Afiliado::select(
                'afiliados.primer_nombre',
                'afiliados.segundo_nombre',
                'afiliados.primer_apellido',
                'afiliados.segundo_apellido',
                'tipo_documentos.nombre as nombre_tipo_documento',
                'tipo_documentos.sigla as sigla_tipo_documento',
                'afiliados.numero_documento',
                'afiliados.estado_afiliacion_id',
                'afiliados.tipo_afiliado_id',
                'estados.nombre as nombreEstado',
                'municipios.nombre as nombreMunicipio',
                // 'reporte_certificados.id as idCertificado'
            )
                ->join('tipo_documentos', 'afiliados.tipo_documento', 'tipo_documentos.id')
                ->join('municipios', 'afiliados.municipio_atencion_id', '=', 'municipios.id')
                ->join('estados', 'afiliados.estado_afiliacion_id', '=', 'estados.id')
                // ->join('reporte_certificados', 'afiliados.id', 'reporte_certificados.afiliado_id')
                ->where('afiliados.id', self::$yoAfiliado->id)
                // ->latest('reporte_certificados.id')
                ->first();
            self::$beneficiarios = Afiliado::select(
                'afiliados.primer_nombre',
                'afiliados.segundo_nombre',
                'afiliados.primer_apellido',
                'afiliados.segundo_apellido',
                'tipo_documentos.nombre as nombre_tipo_documento',
                'tipo_documentos.sigla as sigla_tipo_documento',
                'afiliados.numero_documento',
                'afiliados.estado_afiliacion_id',
                'afiliados.tipo_afiliado_id',
                'afiliados.fecha_afiliacion',
                'municipios.nombre as nombreMunicipio',
                'estados.nombre as nombreEstado'
            )
                ->join('tipo_documentos', 'afiliados.tipo_documento', 'tipo_documentos.id')
                ->join('municipios', 'afiliados.municipio_atencion_id', '=', 'municipios.id')
                ->join('estados', 'afiliados.estado_afiliacion_id', '=', 'estados.id')
                ->where('numero_documento_cotizante', self::$yoAfiliado->numero_documento)
                ->get();
        }

        $pdf = new CertificadoFamiliarAfiliado('P', 'mm', 'A4');
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
        $this->Ln();

        $this->SetXY(10, 40);
        // $this->Cell(192, 4, utf8_decode('NIT '), 0, 0, 'C');
        $this->Ln();
    }

    public function footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-26);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $logo2 = public_path() . "/images/bannerFPS.jpg";
        $this->Image($logo2, 28, $this->GetY() + 0, 156);

        //  $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}'), 0, 0, 'C');
    }

    public function body($pdf)
    {
        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln();

        $titulo = $pdf->GetY();
        $pdf->SetXY(16, $titulo + 4);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->MultiCell(175, 5, utf8_decode('EL FONDO DE PASIVO SOCIAL DE FERROCARRILES NACIONALES DE COLOMBIA
        NIT 800.112.806-2
        '), 0, 'C');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->MultiCell(175, 5, utf8_decode('CERTIFICA QUE'), 0, 'C');
        $pdf->Ln();

        $description = $pdf->GetY();
        $pdf->SetXY(16, $description + 6);
        $pdf->SetFont('Arial', '', 11);
        $pdf->MultiCell(175, 5, utf8_decode('Que el (la) señor (a)' . ' ' . utf8_decode(self::$cotizante->primer_nombre . ' ' . self::$cotizante->segundo_nombre = '' ? '' : self::$cotizante->segundo_nombre . ' ' . self::$cotizante->primer_apellido . ' ' . self::$cotizante->segundo_apellido) . ' ' .
            'identificado(a) con' . ' ' . self::$cotizante->nombre_tipo_documento . ' ' . ' N°' . ' ' . self::$cotizante->numero_documento . ' ' .
            'se encuentra afiliado (a) en estado ' . strtoupper(self::$cotizante->nombreEstado) . ' '
            . 'a esta Entidad Adaptada en Salud en el Régimen Contributivo como' . ' ' .
            self::$cotizante->tipo_afiliado->nombre . ' ' . 'para la prestación de los servicios médicos en la ciudad de' . ' ' . self::$cotizante->nombreMunicipio . '.'), 0, 'J');
        $pdf->Ln();

        $pdf->SetX(16);
        $pdf->SetFont('Arial', '', 12);
        $pdf->MultiCell(175, 5, utf8_decode('Los beneficiarios que registran en su grupo familiar son:'), 0, 'J');
        $pdf->Ln();

        $y = $pdf->GetY();
        $pdf->SetX(16);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->MultiCell(50, 8, utf8_decode('NOMBRES'), 1, 'C');
        $pdf->SetXY(66, $y);
        $pdf->MultiCell(8, 8, utf8_decode('T.D'), 1, 'C');
        $pdf->SetXY(74, $y);
        $pdf->MultiCell(25, 4, utf8_decode('NO. IDENTIFICACIÓN'), 1, 'C');
        $pdf->SetXY(99, $y);
        $pdf->MultiCell(20, 4, utf8_decode('FECHA DE AFILIACIÓN'), 1, 'C');
        $pdf->SetXY(119, $y);
        $pdf->MultiCell(25, 4, utf8_decode('TIPO DE AFILIADO'), 1, 'C');
        $pdf->SetXY(144, $y);
        $pdf->MultiCell(25, 4, utf8_decode('PUNTO DE ATENCION'), 1, 'C');
        $pdf->SetXY(169, $y);
        $pdf->MultiCell(22, 8, utf8_decode('ESTADO'), 1, 'C');
        $start = $pdf->GetY();
        $y = $start;





        foreach (self::$beneficiarios as $beneficiario) {

            $pdf->SetXY(16, $y);
            $pdf->MultiCell(50, 4, utf8_decode($beneficiario->primer_nombre . ' ' . $beneficiario->segundo_nombre = '' ? '' : $beneficiario->segundo_nombre . ' ' . $beneficiario->primer_apellido . ' ' . $beneficiario->segundo_apellido), 0, 'J');
            $y7 = $pdf->GetY();
            $pdf->SetXY(66, $y);
            $pdf->MultiCell(50, 4, utf8_decode($beneficiario->sigla_tipo_documento), 0, 'J');
            $y1 = $pdf->GetY();
            $pdf->SetXY(70, $y);
            $pdf->MultiCell(25, 4, utf8_decode($beneficiario->numero_documento), 0, 'C');
            $y2 = $pdf->GetY();
            $pdf->SetXY(96, $y);
            $pdf->MultiCell(25, 4, utf8_decode($beneficiario->fecha_afiliacion), 0, 'C');
            $y3 = $pdf->GetY();
            $pdf->SetXY(117, $y);
            $pdf->MultiCell(31, 4, utf8_decode($beneficiario->tipo_afiliado->nombre = '' ? '' : $beneficiario->tipo_afiliado->nombre), 0, 'C');
            $y4 = $pdf->GetY();
            $pdf->SetXY(142, $y);
            $pdf->MultiCell(28, 4, utf8_decode($beneficiario->nombreMunicipio), 0, 'C');
            $y5 = $pdf->GetY();
            $pdf->SetXY(166, $y);
            $pdf->MultiCell(25, 4, utf8_decode($beneficiario->nombreEstado), 0, 'C');
            $y6 = $pdf->GetY();
            $y = max($y1, $y2, $y3, $y4, $y5, $y6, $y7);

            $pdf->Line(16, $y, 191, $y);
            $pdf->Line(191, $start, 191, $y);
            $pdf->Line(16, $start, 16, $y);
            $pdf->Line(58, $y, 191, $y);
            $pdf->Line(66, $start, 66, $y);
            $pdf->Line(74, $start, 74, $y);
            $pdf->Line(99, $start, 99, $y);
            $pdf->Line(119, $start, 119, $y);
            $pdf->Line(144, $start, 144, $y);
            $pdf->Line(169, $start, 169, $y);
        }

        $y = $pdf->GetY();
        $pdf->SetXY(16, $y + 10);
        $pdf->SetFont('Arial', '', 12);
        $pdf->MultiCell(175, 5, utf8_decode('El presente certificado se expide a solicitud del (la) interesado (a), a los ' . $dia = Carbon::now()->isoFormat('D [días del mes de] MMMM [del] YYYY' . '.')), 0, 'J');
        $pdf->Ln();
        $y = $pdf->GetY();
        $pdf->SetXY(16, $y + 2);
        $pdf->SetFont('Arial', '', 12);
        $pdf->MultiCell(175, 5, utf8_decode('Observaciones:'), 0, 'J');
        $y = $pdf->GetY();
        $pdf->SetXY(16, $y + 1);
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
        $pdf->SetFont('Arial', 'B', 12);
        // $pdf->MultiCell(175, 5, utf8_decode('Consecutivo:' . self::$cotizante->idCertificado), 0, 'J');
    }
}
