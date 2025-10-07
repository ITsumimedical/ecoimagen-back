<?php

namespace App\Formats;

use Carbon\Carbon;
use Codedge\Fpdf\Fpdf\Fpdf;

class FormatoNegacion extends Fpdf
{
    protected static $informacion;
    protected static $tipo_orden;

    public function generar($tipo_orden, $detalle)
    {
        self::$informacion = $detalle;
        self::$tipo_orden = $tipo_orden;
    }

    public function Header()
    {
        $this->SetFont('Arial', '', 9);

        // Obtener el ancho total de la página y restar los márgenes
        $anchoPagina = $this->GetPageWidth() - $this->lMargin - $this->rMargin;

        // empezamos desde el borde izquierdo sin margen
        $this->SetX($this->lMargin);

        $this->Cell($anchoPagina, 6, utf8_decode('REPUBLICA DE COLOMBIA'), 0, 1, 'C');
        $this->Cell($anchoPagina, 6, utf8_decode('SUPERINTENDENCIA NACIONAL DE SALUD'), 0, 1, 'C');
        $this->Cell($anchoPagina, 6, utf8_decode('FORMATO DE NEGACIÓN DE SERVICIOS DE SALUD Y/O MEDICAMENTOS'), 0, 1, 'C');

        $logo = public_path() . "/images/logo_republica_colombia.png";
        $this->Image($logo, 170, 4, 30, 25);
        $logo2 = public_path() . "/images/institutoNacional.png";
        $this->Image($logo2, 6, 4, 40, 25);

        $this->Ln();

        $this->SetFont('Arial', '', 7);
        $this->SetFillColor(255, 255, 255);
        $this->Cell($anchoPagina, 4, utf8_decode('CUANDO NO SE AUTORICE LA PRESTACION DE UN SERVICIO DE SALUD O EL SUMINSTRO DE MEDICAMENTOS, ENTREGE ESTE FORMULARIO AL'), 0, 1, 'C');
        $this->Cell($anchoPagina, 4, utf8_decode('USUARIO DEBIDAMENTE DILIGENCIANDO'), 0, 1, 'C');
        $this->Ln(5);
    }



    public function body()
    {
        $this->SetFont('Arial', 'B', 8);

        $anchoTotal = $this->GetPageWidth() - $this->lMargin - $this->rMargin;
        $anchoCelda1 = $anchoTotal * 0.6;
        $anchoCelda2 = $anchoTotal * 0.4;



        $this->Cell($anchoCelda1, 4, utf8_decode('NOMBRE DE LA ADMINISTRADORA I.P.S O ENTIDAD TERRITORIAL'), 1, 0, 'L');
        $this->Cell($anchoCelda2, 4, utf8_decode('NÚMERO'), 1, 1, 'L');
        $this->SetFont('Arial', '', 8);
        $this->Cell($anchoCelda1, 4, utf8_decode(self::$informacion->rep->nombre ?? 'No disponible'), 1, 0, 'L');
        $this->Cell($anchoCelda2, 4, utf8_decode(self::$informacion->rep->codigo_habilitacion ?? 'No disponible'), 1, 0, 'L');
        $this->Ln();
        $this->Ln();
        $this->SetFont('Arial', 'B', 8);
        $this->Cell($anchoCelda1, 4, utf8_decode('FECHA DE LA SOLICITUD'), 1, 0, 'L');
        $this->Cell($anchoCelda2, 4, utf8_decode('FECHA DE DILIGENCIAMIENTO'), 1, 1, 'L');
        $this->SetFont('Arial', '', 8);
        $this->Cell($anchoCelda1, 4, utf8_decode(Carbon::parse(self::$informacion->created_at)->format('Y-m-d') ?? 'No disponible'), 1, 0, 'L');
        $fechaDiligenciamiento = self::$informacion->auditoria?->first()?->created_at ?? self::$informacion->auditorias?->first()?->created_at ?? null;
        $this->Cell($anchoCelda2, 4, utf8_decode(Carbon::parse($fechaDiligenciamiento)->format('Y-m-d') ?? 'No disponible'), 1, 0, 'L');
        $this->Ln();
        $this->Ln();
        $this->SetFont('Arial', 'B', 8);
        $this->Cell($anchoCelda1, 4, utf8_decode('1.DATOS GENERALES DEL SOLICITANTE DEL SERVICIO'), 0, 0, 'L');
        $this->Ln();
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(63.3, 4, utf8_decode('1er. APELLIDO'), 1, 0, 'C');
        $this->Cell(63.3, 4, utf8_decode('2do. APELLIDO'), 1, 0, 'C');
        $this->Cell(63.3, 4, utf8_decode('NOMBRES'), 1, 0, 'C');
        $this->Ln();
        $this->SetFont('Arial', '', 8);
        $this->Cell(63.3, 4, utf8_decode(self::$informacion->orden->consulta->afiliado->primer_apellido ?? 'No disponible'), 1, 0, 'C');
        $this->Cell(63.3, 4, utf8_decode(self::$informacion->orden->consulta->afiliado->segundo_apellido ?? 'No disponible'), 1, 0, 'C');
        $primer_nombre = self::$informacion->orden->consulta->afiliado->primer_nombre ?? '';
        $segundo_nombre = self::$informacion->orden->consulta->afiliado->segundo_nombre ?? '';
        $nombre_completo = trim($primer_nombre . ' ' . $segundo_nombre);
        $this->Cell(63.3, 4, utf8_decode($nombre_completo), 1, 0, 'C');
        $this->Ln();
        $this->Ln();
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(63.3, 4, utf8_decode('TIPO DE IDENTIFICACIÓN'), 1, 0, 'C');
        $this->Cell(63.3, 4, utf8_decode('No. DOCUMENTO DE IDENTIFICACION'), 1, 0, 'C');
        $this->Cell(63.3, 4, utf8_decode('No. DE CONTRATO'), 1, 1, 'C');

        $tipo_identificacion = self::$informacion->orden->consulta->afiliado->tipoDocumento->sigla ?? '';

        $opciones = ['TI' => ' ', 'CC' => ' ', 'CE' => ' '];

        if (isset($opciones[$tipo_identificacion])) {
            $opciones[$tipo_identificacion] = 'X';
        }

        $this->SetFont('Arial', '', 8);
        $this->Cell(21.1, 4, utf8_decode('TI [' . $opciones['TI'] . ']'), 1, 0, 'C');
        $this->Cell(21.1, 4, utf8_decode('CC [' . $opciones['CC'] . ']'), 1, 0, 'C');
        $this->Cell(21.1, 4, utf8_decode('CE [' . $opciones['CE'] . ']'), 1, 0, 'C');

        $this->Cell(63.3, 4, utf8_decode(self::$informacion->orden->consulta->afiliado->numero_documento ?? 'No disponible'), 1, 0, 'C');
        $this->Cell(63.3, 4, utf8_decode(self::$informacion->orden->consulta->afiliado->numero_documento ?? 'No disponible'), 1, 0, 'C');

        $this->Ln();
        $this->Ln();
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(63.3, 4, utf8_decode('TELEFONO'), 1, 0, 'C');
        $this->Cell(63.3, 4, utf8_decode('CIUDAD/MUNICIPIO'), 1, 0, 'C');
        $this->Cell(63.3, 4, utf8_decode('DEPARTAMENTO'), 1, 1, 'C');
        $this->SetFont('Arial', '', 8);
        $this->Cell(63.3, 4, utf8_decode(self::$informacion->orden->consulta->afiliado->celular1 ?? 'No disponible'), 1, 0, 'C');
        $this->Cell(63.3, 4, utf8_decode(self::$informacion->orden->consulta->afiliado->municipio_afiliacion->nombre ?? 'No disponible'), 1, 0, 'C');
        $this->Cell(63.3, 4, utf8_decode(self::$informacion->orden->consulta->afiliado->departamento_afiliacion->nombre ?? 'No disponible'), 1, 0, 'C');
        $this->Ln();
        $this->Ln();
        $this->SetFont('Arial', 'B', 8);
        $this->Cell($anchoCelda1, 4, utf8_decode('TIPO PLAN USUARIO'), 0, 0, 'L');
        $this->Ln();

        $auditoria = self::$informacion->auditoria ? self::$informacion->auditoria->first() : null;
        $auditorias = self::$informacion->auditorias ? self::$informacion->auditorias->first() : null;

        $tipo_planes = $auditoria ? $auditoria->tipo_plan_usuario : ($auditorias ? $auditorias->tipo_plan_usuario : '');

        $planes_array = array_map('trim', explode(',', $tipo_planes));


        $opciones = [
            'POS' => ' ',
            'POS-S' => ' ',
            'PLAN COMPLEMENTARIO (PAC)' => ' ',
            'POBLACIÓN POBRE NO CUBIERTA CON SUBSIDIO A LA DEMANDA' => ' ',
            'NRO. DE SEMANAS COTIZADAS POR EL USUARIO AL SGSSS' => ' ',
            'ESTADO DE LA AFILIACION / CONTRATO DEL USUARIO' => ' ',
            'VIGENTE' => ' ',
            'SUSPENDIDO' => ' '
        ];

        foreach ($planes_array as $plan) {
            $plan = trim($plan);
            if (isset($opciones[$plan])) {
                $opciones[$plan] = 'X';
            }
        }
        $this->SetFont('Arial', '', 8);
        $this->Cell(20, 4, utf8_decode('POS [' . $opciones['POS'] . ']'), 1, 0, 'C');
        $this->Cell(20, 4, utf8_decode('POS-S [' . $opciones['POS-S'] . ']'), 1, 0, 'C');
        $this->Cell(50, 4, utf8_decode('PLAN COMPLEMENTARIO (PAC) [' . $opciones['PLAN COMPLEMENTARIO (PAC)'] . ']'), 1, 0, 'C');
        $this->Cell(100, 4, utf8_decode('POBLACIÓN POBRE NO CUBIERTA CON SUBSIDIO A LA DEMANDA [' . $opciones['POBLACIÓN POBRE NO CUBIERTA CON SUBSIDIO A LA DEMANDA'] . ']'), 1, 1, 'C');
        $this->Cell(100, 4, utf8_decode('NRO. DE SEMANAS COTIZADAS POR EL USUARIO AL SGSSS [' . $opciones['NRO. DE SEMANAS COTIZADAS POR EL USUARIO AL SGSSS'] . ']'), 1, 0, 'C');
        $this->Cell(90, 4, utf8_decode('ESTADO DE LA AFILIACION / CONTRATO DEL USUARIO [' . $opciones['ESTADO DE LA AFILIACION / CONTRATO DEL USUARIO'] . ']'), 1, 1, 'C');
        $this->Cell(100, 4, utf8_decode('VIGENTE [' . $opciones['VIGENTE'] . ']'), 1, 0, 'C');
        $this->Cell(90, 4, utf8_decode('SUSPENDIDO [' . $opciones['SUSPENDIDO'] . ']'), 1, 1, 'C');

        $this->Ln();
        $this->Ln();
        $this->SetFont('Arial', 'B', 8);
        $this->Cell($anchoCelda1, 4, utf8_decode('2. CLASE DE SERVICIO NO AUTORIZADO Y RECOMENDACIONES AL USUARIO'), 0, 0, 'L');
        $this->Ln();
        $this->SetDrawColor(0, 0, 0);
        $this->SetFillColor(214, 214, 214);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(190, 4, utf8_decode('SERVICIO NO AUTORIZADO / CODIGO O MEDICAMENTO NO AUTORIZADO'), 1, 1, 'C', 1);
        if (self::$tipo_orden === 'Servicio') {
            $this->SetFillColor(255, 255, 255);
            $this->MultiCell(190, 4, utf8_decode(self::$informacion->cup->codigo . ' - ' . (self::$informacion->cup->nombre ?? 'No disponible')), 1, 1, 'C');
        } else {
            $this->SetFillColor(255, 255, 255);
            $this->MultiCell(190, 4, utf8_decode(self::$informacion->codesumi->nombre ?? 'No disponible'), 1, 1, 'C');
        }
        $this->SetFillColor(214, 214, 214);
        $this->Cell(190, 4, utf8_decode('DESCRIPCION : (Señale el servicio / procedimiento / intervención)'), 1, 1, 'C', 1);
        $this->SetFillColor(255, 255, 255);
        $this->MultiCell(190, 4, utf8_decode(self::$informacion->observacion ?? 'No disponible'), 1, 1, 'C');
        $this->SetFillColor(214, 214, 214);
        $this->Cell(190, 4, utf8_decode('JUSTIFICACION: Indique el motivo de la negación'), 1, 1, 'C', 1);
        $this->SetFillColor(255, 255, 255);
        $this->MultiCell(190, 4, utf8_decode(self::$informacion->auditoria ? self::$informacion->auditoria->first()->observaciones : (self::$informacion->auditorias ? self::$informacion->auditorias->first()->observaciones : 'No disponible')), 1, 1, 'C');
        $this->SetFillColor(214, 214, 214);
        $this->Cell(190, 4, utf8_decode('FUNDAMENTO LEGAL: Relaciones las disposiciones que presuntamente respaldan la decisión'), 1, 1, 'C', 1);
        $this->SetFillColor(255, 255, 255);
        $this->MultiCell(190, 4, utf8_decode(self::$informacion->auditoria ? self::$informacion->auditoria->first()->fundamento_legal : (self::$informacion->auditorias ? self::$informacion->auditorias->first()->fundamento_legal : 'No disponible')), 1, 1, 'C');

        $this->Ln();
        $this->Ln();
        $this->SetFont('Arial', 'B', 8);
        $this->MultiCell(190, 4, utf8_decode('3. ALTERNATIVAS PARA QUE EL USUARIO ACCEDA AL SERVICIO DE SALUD O MEDICAMENTO SOLICITADO Y HAGA VALER SUS DERECHOS LEGALES Y CONSTITUCIONALES '), 0, 0, 'L');
        $this->Ln();
        $this->MultiCell(190, 4, utf8_decode(self::$informacion->auditoria ? self::$informacion->auditoria->first()->alternativas_acceso_salud : (self::$informacion->auditorias ? self::$informacion->auditorias->first()->alternativas_acceso_salud : 'No disponible')), 1, 1, 'C');
        $this->Ln();
        $this->Ln();
        $this->Cell(190, 4, utf8_decode('FIRMA DEL USUARIO O DE QUIEN RECIBE'), 1, 1, 'L');
        $this->Cell($anchoCelda1, 4, utf8_decode('NOMBRE Y CARGO DEL FUNCIONARIO QUE NIEGA EL SERVICIO'), 1, 0, 'L');
        $this->Cell($anchoCelda2, 4, utf8_decode('FIRMA'), 1, 1, 'L');
        $this->Cell($anchoCelda1, 4, utf8_decode(self::$informacion->auditoria && self::$informacion->auditoria->first() ? self::$informacion->auditoria->first()->user->operador->nombre : (self::$informacion->auditorias && self::$informacion->auditorias->first() ? self::$informacion->auditorias->first()->user->operador->nombre : 'No disponible')), 1, 1, 'L');
    }

    function firma()
    {
        $yDinamica = $this->GetY();

        $this->Rect(124, $yDinamica - 8, 76, 18);

        $firma = null;

        if (self::$informacion->auditoria && self::$informacion->auditoria->first() && self::$informacion->auditoria->first()->user && self::$informacion->auditoria->first()->user->firma) {
            $firma = self::$informacion->auditoria->first()->user->firma;
        } elseif (self::$informacion->auditorias && self::$informacion->auditorias->first() && self::$informacion->auditorias->first()->user && self::$informacion->auditorias->first()->user->firma) {
            $firma = self::$informacion->auditorias->first()->user->firma;
        }

        if ($firma && file_exists(storage_path(substr($firma, 9)))) {
            $this->Image(storage_path(substr($firma, 9)), 125, $yDinamica - 3, 50, 11);
        }

        $firma_paciente = self::$informacion->auditoria ? self::$informacion->auditoria->first()->firma_electronica : null;
        $firma_paciente = $firma_paciente ?? (self::$informacion->auditorias ? self::$informacion->auditorias->first()->firma_electronica : null);
        $firma_paciente = $firma_paciente ?? '';

        $y8 = $this->GetY();
        $this->SetXY(10, 12);


        $this->Rect(10, $y8 + 6, 90, 15);

        $this->SetXY(10, $y8 + 6);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(90, 5, 'Usuario que recibe ', 0, 1, 'L');

        if (!empty($firma_paciente) && preg_match('/^data:image\/(?:png|jpg|jpeg);base64,/', $firma_paciente)) {
            $base64Data = substr($firma_paciente, strpos($firma_paciente, ',') + 1);
            $imageData = base64_decode($base64Data);
            $tempImage = tempnam(sys_get_temp_dir(), 'firma') . '.png';
            file_put_contents($tempImage, $imageData);
            $this->Image($tempImage, 45, $y8 + 9, 30, 11);
        }
    }

    public function Footer()
    {
        $this->firma();
        $this->SetFont('Arial', 'B', 12);
    }
}
