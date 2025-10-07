<?php

namespace App\Formats;

use DNS2D;
use Carbon\Carbon;
use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Certificados\Models\Certificado;
use Codedge\Fpdf\Fpdf\Fpdf;

class CertificadoAfiliado extends FPDF
{
    public static $paciente;
    public static $cotizante;
    public static $beneficiarios;
    public static $qr;
    public static $certificado;


    public function generar(string $valor): void
    {
        $pdf = new CertificadoAfiliado('p', 'mm', 'A4');
        setlocale(LC_TIME, "es_ES");

        $query = Afiliado::select(
            'tipo_afiliado_id',
            'numero_documento_cotizante',
            'numero_documento as documento',
            'm.nombre as municipio_Atencion',
            'tipo_documentos.nombre as tipoDocumento',
            'estados.id',
            'estados.nombre as estado',
            'reps.nombre as IPS_sede',
            'municipios.nombre as municipio',
            'tipo_afiliados.nombre as tipoAfiliado'
        )
            ->selectRaw("CONCAT(primer_nombre,' ',segundo_nombre,' ',primer_apellido,' ',segundo_apellido) as nombre")
            ->selectRaw("TO_CHAR(fecha_afiliacion, 'DD/MM/YYYY') as fechaAfiliado")
            ->join('estados', 'estados.id', 'afiliados.estado_afiliacion_id')
            ->join('reps', 'reps.id', 'afiliados.ips_id')
            ->join('tipo_documentos', 'tipo_documentos.id', 'afiliados.tipo_documento')
            ->join('municipios', 'municipios.id', 'reps.municipio_id')
            ->join('municipios as m', 'm.id', 'afiliados.municipio_atencion_id')
            ->leftJoin('tipo_afiliados', 'tipo_afiliados.id', 'afiliados.tipo_afiliado_id');

        if (Afiliado::where('numero_documento', $valor)->exists()) {
            $query->where('afiliados.numero_documento', $valor);
        } elseif (Afiliado::where('id', $valor)->exists()) {
            $query->where('afiliados.id', $valor);
        } else {
            throw new \Exception("Afiliado no encontrado con ID o documento: {$valor}");
        }

        self::$paciente = $query->first();

        if (!self::$paciente) {
            throw new \Exception("Afiliado no encontrado con valor: {$valor}");
        }

        self::$certificado = Certificado::selectRaw("CONCAT('Radicado # ',id,' documento ',numero_documento) as aditoria")
            ->where('numero_documento', self::$paciente->documento)
            ->orderBy('id', 'desc')
            ->first();

        if (!self::$certificado) {
            throw new \Exception("No se encontró certificado para el afiliado con documento: " . self::$paciente->documento);
        }

        $path = 'tempimg.png';
        $dataURI = "data:image/png;base64," . DNS2D::getBarcodePNG(self::$certificado->aditoria, 'QRCODE');
        $encodedImg = explode(',', $dataURI)[1];
        file_put_contents($path, base64_decode($encodedImg));

        self::$qr = $path;
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetTitle('Certificado Afiliacion');
        $pdf->SetMargins(26, 15, 26);
        $this->body($pdf);
        $pdf->Output();
    }

    public function Header()
    {
        $logo1 = public_path() . "/images/logoFomag.png";
        $logo2 = public_path() . "/images/fiduPrevisora.png";
        $this->Image(self::$qr, 12, 8, 40, 40);
        $this->SetFont('Arial', 'B', 15);
        $this->SetDrawColor(255, 255, 255);
        $this->Rect(5, 5, 200, 287);
        $this->SetDrawColor(0, 0, 0);

        $this->Image($logo1, 150, 9, 40, 20);
        $this->Ln();

        $this->Image($logo2, 76, 15, 50, 10);
        $this->Ln();

        $this->SetXY(10, 50);
        $this->SetFont('Arial', '', 12);
        $this->Cell(192, 4, utf8_decode('CERTIFICACIÓN'), 0, 1, 'C');
        $this->Ln();
    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}'), 0, 0, 'C');
    }

    public function body($pdf)
    {

        $descripcion = $pdf->GetY();
        $pdf->SetXY(16, $descripcion + 4);
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(175, 5, utf8_decode('El (la) señor(a)' . ' ' . utf8_decode(self::$paciente->nombre) . ' ' . 'identificado(a) con ' . ' ' . self::$paciente->tipoDocumento . ' '
            . ' N°' . ' ' . self::$paciente->documento . ' ' . 'su fecha de afiliación es del ' . self::$paciente->FechaAfiliado . ', Afiliado al municipio de ' . self::$paciente->municipio_Atencion . ' y registra en estado ' . ' ' . self::$paciente->estado . ' ' . ' como' . ' ' . self::$paciente->tipoAfiliado . ' '
            . 'en el Fondo Nacional de Prestaciones Sociales del Magisterio- FOMAG, con IPS primaria' . ' ' . self::$paciente->IPS_sede . ' municipio de ' . self::$paciente->municipio . '.'), 0, 'J');
        $pdf->Ln();
        if (self::$paciente->tipoAfiliado == 'BENEFICIARIO' || self::$paciente->tipoAfiliado == 'SUSTITUTO PENSIONAL' || self::$paciente->tipoAfiliado == 'COTIZANTE DEPENDIENTE' && self::$paciente->numero_documento_cotizante != null) {
            self::$cotizante = Afiliado::select(
                'tipo_afiliado_id',
                'parentesco',
                'numero_documento as documento',
                'tipo_documentos.nombre as tipoDocumento',
                'estados.id',
                'estados.nombre as estado',
                'reps.nombre as IPS',
                'tipo_afiliados.nombre as tipoAfiliado'
            )
                ->selectRaw("CONCAT(primer_nombre,' ',segundo_nombre,' ',primer_apellido,' ',segundo_apellido) as nombre")
                ->selectRaw("TO_CHAR(fecha_afiliacion, 'DD/MM/YYYY') as FechaAfiliado")
                ->join('estados', 'estados.id', 'afiliados.estado_afiliacion_id')
                ->join('reps', 'reps.id', 'afiliados.ips_id')
                ->join('tipo_documentos', 'tipo_documentos.id', 'afiliados.tipo_documento')
                ->leftjoin('tipo_afiliados', 'tipo_afiliados.id', 'afiliados.tipo_afiliado_id')
                ->where('afiliados.numero_documento', self::$paciente->numero_documento_cotizante)->first();

            if (self::$cotizante != null) {

                $pdf->SetX(16);
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->MultiCell(175, 5, utf8_decode('Información del Cotizante'), 0, 'C');
                $pdf->Ln();

                $y = $pdf->GetY();
                $pdf->SetX(16);
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->MultiCell(25, 4, utf8_decode('Tipo Identificacion'), 1, 'C');
                $pdf->SetXY(41, $y);
                $pdf->MultiCell(25, 4, utf8_decode('Numero Identificación'), 1, 'C');
                $pdf->SetXY(66, $y);
                $pdf->MultiCell(50, 8, utf8_decode('Nombres'), 1, 'C');
                $pdf->SetXY(116, $y);
                $pdf->MultiCell(25, 8, utf8_decode('Parentesco'), 1, 'C');
                $pdf->SetXY(141, $y);
                $pdf->MultiCell(25, 8, utf8_decode('Estado Actual'), 1, 'C');
                $pdf->SetXY(166, $y);
                $pdf->MultiCell(25, 4, utf8_decode('Tipo de Afiliación'), 1, 'C');
                $inicio = $pdf->GetY();
                $y = $inicio;

                $pdf->SetX(16);
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->MultiCell(25, 4, utf8_decode(self::$cotizante->tipoDocumento), 0, 'C');
                $y1 = $pdf->GetY();
                $pdf->SetXY(41, $y);
                $pdf->MultiCell(25, 4, utf8_decode(self::$cotizante->documento), 0, 'C');
                $y2 = $pdf->GetY();
                $pdf->SetXY(66, $y);
                $pdf->MultiCell(50, 4, utf8_decode(self::$cotizante->nombre), 0, 'C');
                $y3 = $pdf->GetY();
                $pdf->SetXY(116, $y);
                $pdf->MultiCell(25, 4, utf8_decode(self::$cotizante->parentesco), 0, 'C');
                $y4 = $pdf->GetY();
                $pdf->SetXY(141, $y);
                $pdf->MultiCell(25, 4, utf8_decode(self::$cotizante->estado), 0, 'C');
                $y5 = $pdf->GetY();
                $pdf->SetXY(166, $y);
                $pdf->MultiCell(25, 4, utf8_decode(self::$cotizante->tipoAfiliado), 0, 'C');
                $y6 = $pdf->GetY();

                $y = max($y1, $y2, $y3, $y4, $y5, $y6);

                $pdf->Line(16, $y, 191, $y);
                $pdf->Line(191, $inicio, 191, $y);
                $pdf->Line(16, $inicio, 16, $y);
                $pdf->Line(41, $inicio, 41, $y);
                $pdf->Line(66, $inicio, 66, $y);
                $pdf->Line(116, $inicio, 116, $y);
                $pdf->Line(141, $inicio, 141, $y);
                $pdf->Line(166, $inicio, 166, $y);


                $y = $pdf->GetY();
            } else {
                // $pdf->SetX(16);
                // $pdf->SetFont('Arial', '', 12);
                // $pdf->MultiCell(175, 5, utf8_decode('La información de grupo familiar no se encuentra Disponible en UT Región 8. Si requiere que se adiciones su grupo familiar al certificado se debe realizar esta solicitud a través de pagina web https://www.horus-health.com/gestion ingresando por la opción TRAMITES ADMINISTRATIVOS Y DE AFILIACIONES.'), 0, 'J');
                // $pdf->Ln();
                $inicio = $pdf->GetY();
                $y = $inicio;
            }
        } elseif (self::$paciente->tipoAfiliado == 'COTIZANTE' || self::$paciente->tipoAfiliado == 'COTIZANTEN FALLECIDO' || self::$paciente->tipoAfiliado == 'COTIZANTE PENSIONADO' || self::$paciente->tipoAfiliado == 'SUSTITUTO PENSIONAL' && (empty(self::$paciente->numero_documento_cotizante) == true || self::$paciente->numero_documento_cotizante == null)) {
            self::$beneficiarios = Afiliado::select(
                'tipo_afiliado_id',
                'parentesco',
                'numero_documento as documento',
                'tipo_documentos.nombre as tipoDocumento',
                'estados.id',
                'estados.nombre as estado',
                'reps.nombre as IPS',
                'tipo_afiliados.nombre as tipoAfiliado'
            )
                ->selectRaw("CONCAT(primer_nombre,' ',segundo_nombre,' ',primer_apellido,' ',segundo_apellido) as nombre")
                ->selectRaw("TO_CHAR(fecha_afiliacion, 'DD/MM/YYYY') as FechaAfiliado")
                ->join('estados', 'estados.id', 'afiliados.estado_afiliacion_id')
                ->join('reps', 'reps.id', 'afiliados.ips_id')
                ->join('tipo_documentos', 'tipo_documentos.id', 'afiliados.tipo_documento')
                ->leftjoin('tipo_afiliados', 'tipo_afiliados.id', 'afiliados.tipo_afiliado_id')
                ->where('afiliados.numero_documento_cotizante', self::$paciente->documento)->get();
            if (count(self::$beneficiarios) == 0) {
                // $pdf->SetX(16);
                // $pdf->SetFont('Arial', '', 12);
                // $pdf->MultiCell(175, 5, utf8_decode('La información de grupo familiar no se encuentra Disponible en en UT Región 8, se debe hacer la gestión por módulo de solicitudes Horus.'), 0, 'J');
                // $pdf->Ln();
                $inicio = $pdf->GetY();
                $y = $inicio;
            } else {
                $pdf->SetX(16);
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->MultiCell(175, 5, utf8_decode('Información de los Beneficiarios'), 0, 'C');
                $pdf->Ln();

                $y = $pdf->GetY();
                $pdf->SetX(16);
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->MultiCell(25, 4, utf8_decode('Tipo Identificacion'), 1, 'C');
                $pdf->SetXY(41, $y);
                $pdf->MultiCell(25, 4, utf8_decode('Numero Identificación'), 1, 'C');
                $pdf->SetXY(66, $y);
                $pdf->MultiCell(50, 8, utf8_decode('Nombres'), 1, 'C');
                $pdf->SetXY(116, $y);
                $pdf->MultiCell(25, 8, utf8_decode('Parentesco'), 1, 'C');
                $pdf->SetXY(141, $y);
                $pdf->MultiCell(25, 8, utf8_decode('Estado Actual'), 1, 'C');
                $pdf->SetXY(166, $y);
                $pdf->MultiCell(25, 4, utf8_decode('Tipo de Afiliación'), 1, 'C');
                $inicio = $pdf->GetY();
                $y = $inicio;

                foreach (self::$beneficiarios as $beneficiario) {

                    $pdf->SetFont('Arial', 'B', 8);

                    $pdf->SetXY(16, $y);
                    $pdf->MultiCell(25, 4, utf8_decode($beneficiario->tipoDocumento), 0, 'C');
                    $y1 = $pdf->GetY();
                    $pdf->SetXY(41, $y);
                    $pdf->MultiCell(25, 4, utf8_decode($beneficiario->documento), 0, 'C');
                    $y2 = $pdf->GetY();
                    $pdf->SetXY(66, $y);
                    $pdf->MultiCell(50, 4, utf8_decode($beneficiario->nombre), 0, 'C');
                    $y3 = $pdf->GetY();
                    $pdf->SetXY(116, $y);
                    $pdf->MultiCell(25, 4, utf8_decode($beneficiario->parentesco), 0, 'C');
                    $y4 = $pdf->GetY();
                    $pdf->SetXY(141, $y);
                    $pdf->MultiCell(25, 4, utf8_decode($beneficiario->estado), 0, 'C');
                    $y5 = $pdf->GetY();
                    $pdf->SetXY(166, $y);
                    $pdf->MultiCell(25, 4, utf8_decode($beneficiario->tipoAfiliado), 0, 'C');
                    $y6 = $pdf->GetY();
                    $y = max($y1, $y2, $y3, $y4, $y5, $y6);

                    $pdf->Line(16, $y, 191, $y);
                    $pdf->Line(191, $inicio, 191, $y);
                    $pdf->Line(16, $inicio, 16, $y);
                    $pdf->Line(41, $inicio, 41, $y);
                    $pdf->Line(66, $inicio, 66, $y);
                    $pdf->Line(116, $inicio, 116, $y);
                    $pdf->Line(141, $inicio, 141, $y);
                    $pdf->Line(166, $inicio, 166, $y);
                }
            }
        } else {
            // $pdf->SetX(16);
            // $pdf->SetFont('Arial', '', 12);
            // $pdf->MultiCell(175, 5, utf8_decode('La información de grupo familiar no se encuentra Disponible en UT Región 8. Si requiere que se adiciones su grupo familiar al certificado se debe realizar esta solicitud a través de pagina web https://www.horus-health.com/gestion ingresando por la opción TRAMITES ADMINISTRATIVOS Y DE AFILIACIONES.'), 0, 'J');
            // $pdf->Ln();
            $inicio = $pdf->GetY();
            $y = $inicio;
        }
        if ($y > 220) {
            $pdf->AddPage();
            $y = 50;
        }
        $pdf->SetXY(16, $y + 10);
        // $pdf->SetFont('Arial', '', 9);
        // $pdf->MultiCell(175, 5, utf8_decode('Adicionalmente se le informa que de acuerdo al decreto 1703 de 2002, la persona afiliada como cotizante a un régimen de excepción y que tenga una relación laboral o ingresos adicionales sobre los cuales esté obligado a cotizar al Sistema General de Seguridad Social en Salud, su empleador o administrador de pensiones deberá efectuar la respectiva cotización al Fosyga, igualmente los servicios asistenciales serán prestados exclusivamente a través del régimen de excepción; las prestaciones económicas a cargo del Sistema General de Seguridad Social en Salud serán cubiertas por el Fosyga.'), 0, 'J');
        // $pdf->Ln();
        //$pdf->SetXY(15, $y+43);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(175, 5, utf8_decode('Es importante indicar que por ser régimen especial los servicios de salud, Riesgos Laborales y la afiliación de pensión están a cargo del Fondo de Prestaciones del Magisterio, generando la claridad, que Fiduprevisora no es una ARL, sino una Fiduciaria que, en contrato con el Magisterio, genera la contratación de terceros para cumplir con las Actividades de Seguridad y Salud en el Trabajo de los docentes afiliados al Magisterio."'), 0, 'J');
        $pdf->Ln();

        $dia = Carbon::now()->isoFormat('D [ de] MMMM [del] YYYY');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln();
        $pdf->SetXY(16, $y + 34);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(10, 5, utf8_decode("Dada la solicitud, " . $dia), 0, 0, '');

        $pdf->SetXY(20, $y + 80);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(10, 5, utf8_decode('Cordialmente,'), 0, 0, 'C');

        $y = $pdf->GetY();
        $logo2 = public_path() . "/images/fimaCertificadoFomag.png";
        $pdf->Image($logo2, 15, $y + 8, 50, 15);
        $y = $pdf->GetY();

        $pdf->SetXY(15, $y + 25);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->MultiCell(170, 5, utf8_decode('Coordinadora de Gestión de información y afiliaciones de docentes, pensionados y beneficiarios'), 0);

        $pdf->SetXY(16, $y + 30);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->MultiCell(170, 5, utf8_decode('Fondo Nacional de Prestaciones Sociales del Magisterio'), 0);

        // $pdf->SetX(16);
        // $pdf->SetFont('Arial', 'b', 9);
        // $pdf->MultiCell(170, 5, utf8_decode('Elaboró: HosvitalAseguramiento by Ophelia Suite'), 0);

        $pdf->SetX(16);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(170, 5, utf8_decode('Nota: La información referente a los periodos compensados debe solicitarlo directamente a la Secretaría de Educación, ya que es competencia de los entes territoriales suministrar la información relacionada con la historia laboral como docente y la certificación del tiempo cotizado y los aportes efectuados al Fondo'), 0);
    }
}
