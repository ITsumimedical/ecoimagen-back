<?php

namespace App\Formats;

use App\Http\Modules\ConsentimientosInformados\Models\ConsentimientosInformado;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Ordenamiento\Models\OrdenProcedimiento;
use App\Modelos\cup;
use App\User;
use App\Modelos\Paciente;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Modelos\citapaciente;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Support\Facades\Storage;

class ConsentimientosInformadosLaboratorio extends FPDF
{
    public static $data;
    public static $consentimientoC;
    public static $fechaHoy;
    public static $medicoAtendio;

    public function generar($datos)
    {

        self::$data = $datos;
        self::$fechaHoy = date('d-m-Y h:i:s a');

        if (isset(self::$data['orden_id'])) {
            self::$consentimientoC = ConsentimientosInformado::where('cup_id', self::$data['id'])->first();

            self::$medicoAtendio = OrdenProcedimiento::select(
                'afiliados.numero_documento',
                'afiliados.primer_nombre',
                'afiliados.segundo_nombre',
                'afiliados.primer_apellido',
                'afiliados.segundo_apellido',
                'afiliados.tipo_documento',
                'afiliados.edad_cumplida',
                'afiliados.fecha_nacimiento',
                'entidades.nombre as asegurador',
                'orden_procedimientos.aceptacion_consentimiento',
                'consultas.afiliado_id',
                'consultas.medico_ordena_id',
                'consultas.fecha_hora_inicio',
                'operadores.nombre as nombre_medico',
                'operadores.apellido as apellido_medico',
                'users.firma as firma_medico',
                'orden_procedimientos.numero_documento_representante',
                'orden_procedimientos.nombre_representante',
                'orden_procedimientos.declaracion_c',
                'orden_procedimientos.declaracion_b',
                'orden_procedimientos.declaracion_a',
                'orden_procedimientos.nombre_profesional',
                'orden_procedimientos.firma_consentimiento',
                'orden_procedimientos.firma_discentimiento',
                'orden_procedimientos.fecha_firma_discentimiento',
                'orden_procedimientos.firma_profesional',
                'orden_procedimientos.fecha_firma',
                'orden_procedimientos.firma_representante',
                'orden_procedimientos.firmante'
            )
                ->addSelect('tipo_documentos.nombre as nombre_tipo_documento')
                ->join('ordenes', 'ordenes.id', 'orden_procedimientos.orden_id')
                ->join('consultas', 'consultas.id', 'ordenes.consulta_id')
                ->join('afiliados', 'afiliados.id', 'consultas.afiliado_id')
                ->join('entidades', 'entidades.id', 'afiliados.entidad_id')
                ->join('tipo_documentos','tipo_documentos.id','afiliados.tipo_documento')
                ->join('users', 'consultas.medico_ordena_id', 'users.id')
                ->join('operadores', 'operadores.user_id', 'users.id')
                ->where('orden_procedimientos.id', self::$data['orden_id'])
                ->first();
            // dd(self::$medicoAtendio->firma_medico);
        } else {
            self::$consentimientoC = ConsentimientosInformado::where('cup_id', self::$data['id'])->first();
        }


        $pdf = new ConsentimientosInformadosLaboratorio('P', 'mm', 'A4');
        $pdf->AliasNbPages();
        $pdf->AddPage();


        $this->body($pdf);

        $pdf->Output();
    }

    function MultiCellBlt($w, $h, $blt, $txt, $border = 0, $align = 'J', $fill = false)
    {
        $blt_width = $this->GetStringWidth($blt) + $this->cMargin * 2;
        $bak_x = $this->x;
        $this->Cell($blt_width, $h, $blt, 0, '', $fill);
        $this->MultiCell($w - $blt_width, $h, $txt, $border, $align, $fill);
        $this->x = $bak_x;
    }

    function footer()
    {

        if ($this->page >= 2) {

            $inicio = $this->GetY();

            $this->Line(23, $inicio + 3, 190, $inicio + 3);
            $this->Line(23, $inicio + 9, 190, $inicio + 9);
            $this->Line(23, $inicio + 36, 190, $inicio + 36);
            $this->Line(23, $inicio + 3, 23, $inicio + 36);
            $this->Line(106, $inicio + 9, 106, $inicio + 36);
            $this->Line(190, $inicio + 3, 190, $inicio + 36);

            $this->Ln();

            $y1 = $this->GetY();

            if (self::$medicoAtendio?->aceptacion_consentimiento == 'Si') {

                $this->SetTextColor(10, 10, 10);
                $this->SetFont('Arial', 'B', 9);
                $this->SetXY(23, $y1 + 3);
                $this->Cell(0, 0, 'Fecha y hora del consentimiento:' . (self::$medicoAtendio->fecha_firma ?? ''), 0, 0, 'L', 0);

                $this->Ln();
                $y2 = $this->GetY();

                $y4 = $this->GetY();
                $this->SetTextColor(255, 255, 255);
                $this->SetFont('Arial', 'B', 9);
                $this->SetXY(23, $y4 + 19);
                $this->SetFillColor(46, 44, 126);
                $this->Cell(84, 6, utf8_decode('Firma del paciente o representante legal'), 1, 1, 'C', 'true');

                $y5 = $this->GetY();
                $this->SetFont('Arial', 'B', 8);
                $this->SetXY(23, $y5);
                $this->SetTextColor(10, 10, 10);
                if (self::$medicoAtendio->firmante === 'Paciente') {
                    $this->Cell(0, 4, utf8_decode('Identificación: ' . (self::$medicoAtendio->numero_documento ?? '')), 0, 0, 'L', 0);
                } else if (self::$medicoAtendio->firmante === 'Representante Legal') {
                    $this->Cell(0, 4, utf8_decode('Identificación: ' . (self::$medicoAtendio->numero_documento_representante ?? '')), 0, 0, 'L', 0);
                }

                $y10 = $this->GetY();
                $this->SetTextColor(255, 255, 255);
                $this->SetFont('Arial', 'B', 9);
                $this->SetXY(106, $y4 + 19);
                $this->SetFillColor(46, 44, 126);
                $this->Cell(84, 6, utf8_decode('Firma del auxiliar de laboratorio'), 1, 1, 'C', 'true');

                $y7 = $this->GetY();
                $this->SetTextColor(10, 10, 10);
                $this->SetFont('Arial', 'B', 8);
                $this->SetXY(106, $y7 + 2);
                $this->Cell(50, 0, utf8_decode('Nombre: ' . (self::$medicoAtendio->nombre_profesional ?? '')), 0, 'C');


                $firma_paciente = self::$medicoAtendio->firma_consentimiento ?? null;
                $firma_representante = self::$medicoAtendio->firma_representante ?? null;

                $y8 = $this->GetY();
                $this->SetXY(23, $y2 + 12);
                if (isset($firma_paciente)) {
                    $base64Image = $firma_paciente;
                    $explodedData = explode(',', $base64Image);
                    $type = $explodedData[0];
                    $base64Data = $explodedData[1];
                    $imageData = base64_decode($base64Data);

                    $tempImage = tempnam(sys_get_temp_dir(), 'firma') . '.png';
                    file_put_contents($tempImage, $imageData);
                    $this->Image($tempImage, 50, $y8 - 22, 46, 11);
                } else {
                    $base64Image = $firma_representante;
                    $explodedData = explode(',', $base64Image);
                    $type = $explodedData[0];
                    $base64Data = $explodedData[1];
                    $imageData = base64_decode($base64Data);

                    $tempImage = tempnam(sys_get_temp_dir(), 'firma') . '.png';
                    file_put_contents($tempImage, $imageData);
                    $this->Image($tempImage, 50, $y8 - 22, 46, 11);
                }

                $y9 = $this->GetY();
                $this->SetXY(145, $y9 + 12);
                if (isset(self::$medicoAtendio->firma_profesional)) {
                    if (file_exists(storage_path(substr(self::$medicoAtendio->firma_profesional, 9)))) {
                        $this->Image(storage_path(substr(self::$medicoAtendio->firma_profesional, 9)), 130, $y9 - 7, 46, 11);
                    }
                }

                $sm = max($y1, $y2, $y4, $y5, $y7, $y8, $y9, $y10);
                $yt = $sm;

                $this->SetTextColor(10, 10, 10);
                $this->SetXY(80, $yt + 5);
                $this->SetFont('Arial', '', 8);
                $this->Cell(50, 0, utf8_decode('* La huella del paciente se toma únicamente para las personas que no saben firmar o que presentan perdida de la visión.'), 0, 0, 'C', 0);

                #si tengo firma de los dos, paciente y representante
                if (self::$medicoAtendio->firma_consentimiento && self::$medicoAtendio->firma_representante) {
                    $this->Ln();
                    $inicio = $this->GetY();

                    $this->Line(23, $inicio + 4, 107, $inicio + 4);
                    $this->Line(23, $inicio + 34, 107, $inicio + 34);
                    $this->Line(23, $inicio + 4, 23, $inicio + 34);
                    $this->Line(107, $inicio + 4, 107, $inicio + 34);

                    $y1 = $this->GetY();
                    $this->SetTextColor(10, 10, 10);
                    $this->SetFont('Arial', 'B', 9);
                    $this->SetXY(23, $y1 + 3);

                    $this->Ln();
                    $y2 = $this->GetY();

                    $y4 = $this->GetY();
                    $this->SetTextColor(255, 255, 255);
                    $this->SetFont('Arial', 'B', 9);
                    $this->SetXY(23, $y4 + 19);
                    $this->SetFillColor(46, 44, 126);
                    $this->Cell(84, 6, utf8_decode('Firma del representante legal'), 1, 1, 'C', 'true');

                    $y5 = $this->GetY();
                    $this->SetFont('Arial', 'B', 8);
                    $this->SetXY(23, $y5);
                    $this->SetTextColor(10, 10, 10);

                    $this->Cell(0, 4, utf8_decode('Identificación: ' . (self::$medicoAtendio->numero_documento_representante ?? '')), 0, 0, 'L', 0);

                    $firma_representante = self::$medicoAtendio->firma_representante ?? null;

                    $y8 = $this->GetY();
                    $this->SetXY(23, $y2 + 12);


                    if (isset($firma_representante)) {
                        $base64Image = $firma_representante;
                        $explodedData = explode(',', $base64Image);
                        $type = $explodedData[0];
                        $base64Data = $explodedData[1];
                        $imageData = base64_decode($base64Data);

                        $tempImage = tempnam(sys_get_temp_dir(), 'firma') . '.png';
                        file_put_contents($tempImage, $imageData);
                        $this->Image($tempImage, 50, $y8 - 22, 46, 11);
                    }

                    $sm = max($y1, $y2, $y4, $y5, $y7, $y8, $y9, $y10);
                    $yt = $sm;
                }
            } else {
                $this->SetTextColor(10, 10, 10);
                $this->SetFont('Arial', 'B', 9);
                $this->SetXY(23, $y1 + 3);
                $this->Cell(0, 0, 'Fecha y hora del consentimiento:   NO APLICA', 0, 0, 'L', 0);
                $this->Text(50,$y1+15,'NO APLICA');
                $this->Ln();
                $y2 = $this->GetY();

                $y4 = $this->GetY();
                $this->SetTextColor(255, 255, 255);
                $this->SetFont('Arial', 'B', 9);
                $this->SetXY(23, $y4 + 19);
                $this->SetFillColor(46, 44, 126);
                $this->Cell(84, 6, utf8_decode('Firma del paciente o representante legal'), 1, 1, 'C', 'true');

                $y5 = $this->GetY();
                $this->SetTextColor(10, 10, 10);
                $this->SetFont('Arial', 'B', 8);
                $this->SetXY(23, $y5);
                $this->Cell(0, 4, utf8_decode('Identificación:  NO APLICA' ), 0, 0, 'L', 0);
                

                $this->Text(135,$y4+12,'NO APLICA');
                $y10 = $this->GetY();
                $this->SetTextColor(255, 255, 255);
                $this->SetFont('Arial', 'B', 9);
                $this->SetXY(106, $y4 + 19);
                $this->SetFillColor(46, 44, 126);
                $this->Cell(84, 6, utf8_decode('Firma del auxiliar de laboratorio'), 1, 1, 'C', 'true');

                $y7 = $this->GetY();
                $this->SetTextColor(10, 10, 10);
                $this->SetFont('Arial', 'B', 8);
                $this->SetXY(106, $y7 + 2);
                $this->Cell(50, 0, utf8_decode('Nombre:   NO APLICA' ), 0, 'C');

                $sm = max($y1, $y2, $y4, $y5, $y7, $y10);
                $yt = $sm;

                $this->SetTextColor(10, 10, 10);
                $this->SetXY(80, $yt + 7);
                $this->SetFont('Arial', '', 8);
                $this->Cell(50, 0, utf8_decode('* La huella del paciente se toma únicamente para las personas que no saben firmar o que presentan perdida de la visión.'), 0, 0, 'C', 0);
            }

            $this->SetXY(70, $yt + 20);
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(186, 4, utf8_decode('DISENTIMIENTO O DESISTIMIENTO INFORMADO'), 0, 'C');

            $this->Ln();
            $this->SetX(13);
            $this->SetFont('Arial', '', 8);
            $this->MultiCell(186, 4, utf8_decode('En el presente documento manifiesto que he sido informado sobre mi condición, las eventuales complicaciones y/o riesgos que se deriven, los beneficios de los procedimientos planeados, de manera que se puedan tomar decisiones informadas; no obstante, reunido con el auxiliar de laboratorio ' . (self::$medicoAtendio?->aceptacion_consentimiento == 'No' || self::$medicoAtendio?->firma_discentimiento ? self::$medicoAtendio->nombre_profesional : '__________NO____APLICA______________') . ', decido de forma libre y consciente no aceptar/revocar la realización del procedimiento propuesto, haciéndome responsable de las consecuencias que puedan derivarse de esta decisión.'), 0, 'J');
            $inicio = $this->GetY();

            $this->Line(23, $inicio + 3, 190, $inicio + 3);
            $this->Line(23, $inicio + 9, 190, $inicio + 9);
            $this->Line(23, $inicio + 36, 190, $inicio + 36);
            $this->Line(23, $inicio + 3, 23, $inicio + 36);
            $this->Line(106, $inicio + 9, 106, $inicio + 36);
            $this->Line(190, $inicio + 3, 190, $inicio + 36);

            if (self::$medicoAtendio?->aceptacion_consentimiento == 'No') {
                $y1 = $this->GetY();
                $this->SetTextColor(10, 10, 10);
                $this->SetFont('Arial', 'B', 9);
                $this->SetXY(23, $y1 + 7);
                $this->Cell(50, 0, utf8_decode('Fecha y hora del disentimiento o desistimiento informado: ' . (self::$medicoAtendio->fecha_firma_discentimiento ?? '')), 0, 0, 'L', 0);

                $y2 = $this->GetY();

                $firma_paciente = self::$medicoAtendio->firma_discentimiento ?? null;
                $firma_representante = self::$medicoAtendio->firma_representante ?? null;

                $y4 = $this->GetY();
                if (isset($firma_paciente)) {
                    $base64Image = $firma_paciente;
                    $explodedData = explode(',', $base64Image);
                    $type = $explodedData[0];
                    $base64Data = $explodedData[1];
                    $imageData = base64_decode($base64Data);

                    $tempImage = tempnam(sys_get_temp_dir(), 'firma') . '.png';
                    file_put_contents($tempImage, $imageData);
                    $this->Image($tempImage, 40, $yt + 56, 46, 11);
                }else {
                    $base64Image = $firma_representante;
                    $explodedData = explode(',', $base64Image);
                    $type = $explodedData[0];
                    $base64Data = $explodedData[1];
                    $imageData = base64_decode($base64Data);

                    $tempImage = tempnam(sys_get_temp_dir(), 'firma') . '.png';
                    file_put_contents($tempImage, $imageData);
                    $this->Image($tempImage, 40, $yt + 56, 46, 11);
                }

                $y9 = $this->GetY();
                if (isset(self::$medicoAtendio->firma_profesional)) {
                    if (file_exists(storage_path(substr(self::$medicoAtendio->firma_profesional, 9)))) {
                        $this->Image(storage_path(substr(self::$medicoAtendio->firma_profesional, 9)), 130, $yt + 56, 46, 11);
                    }
                }

                $y5 = $this->GetY();
                $this->SetTextColor(255, 255, 255);
                $this->SetFont('Arial', 'B', 9);
                $this->SetXY(23, $y4 + 19);
                $this->SetFillColor(46, 44, 126);
                $this->Cell(84, 6, utf8_decode('Firma del paciente o representante legal'), 1, 1, 'C', 'true');


                $y10 = $this->GetY();
                $this->SetFont('Arial', 'B', 9);
                $this->SetXY(106, $y4 + 19);
                $this->SetFillColor(46, 44, 126);
                $this->Cell(84, 6, utf8_decode('Firma del auxiliar de laboratorio'), 1, 1, 'C', 'true');

                $y6 = $this->GetY();
                $this->SetTextColor(10, 10, 10);
                $this->SetFont('Arial', 'B', 8);
                $this->SetXY(106, $y6 + 2);
                $this->Cell(50, 0, utf8_decode('Nombre: ' . (self::$medicoAtendio->nombre_profesional ?? '')), 0, 'C');

                $y7 = $this->GetY();
                $this->SetFont('Arial', 'B', 8);
                $this->SetXY(23, $y7 - 2);
                if (self::$medicoAtendio?->firmante === 'Paciente') {
                    $this->Cell(0, 4, utf8_decode('Identificación: ' . (self::$medicoAtendio->numero_documento ?? '')), 0, 0, 'L', 0);
                } else {
                    $this->Cell(0, 4, utf8_decode('Identificación: ' . (self::$medicoAtendio->numero_documento_representante ?? '')), 0, 0, 'L', 0);
                }


                $y8 = $this->GetY();
                $this->SetXY(30, $y8 + 7);
                $this->SetFont('Arial', '', 8);
                $this->Cell(50, 1, utf8_decode('* La huella del paciente se toma únicamente para las personas que no saben firmar o que presentan perdida de la visión.'), 0, 0, 'L', 0);
                $this->Ln();
               
                #si tengo firma de los dos, paciente y representante
                if (self::$medicoAtendio->firma_discentimiento && self::$medicoAtendio->firma_representante) {
                    $this->Ln();
                    $inicio = $this->GetY();

                    $this->Line(23, $inicio + 3, 107, $inicio + 3);
                    
                    $this->Line(23, $inicio + 33, 107, $inicio + 33);
                    $this->Line(23, $inicio + 3, 23, $inicio + 33);
                    $this->Line(107, $inicio + 3, 107, $inicio + 33);
                    // $this->Line(190, $inicio + 3, 190, $inicio + 36);

                    $firma_representante = self::$medicoAtendio->firma_representante ?? null;

                    $y4 = $this->GetY();

                    if (isset($firma_representante)) {
                        $base64Image = $firma_representante;
                        $explodedData = explode(',', $base64Image);
                        $type = $explodedData[0];
                        $base64Data = $explodedData[1];
                        $imageData = base64_decode($base64Data);

                        $tempImage = tempnam(sys_get_temp_dir(), 'firma') . '.png';
                        file_put_contents($tempImage, $imageData);
                        $this->Image($tempImage, 40, $inicio + 5, 46, 11);
                    }


                    $y5 = $this->GetY();
                    $this->SetTextColor(255, 255, 255);
                    $this->SetFont('Arial', 'B', 9);
                    $this->SetXY(23, $y4 + 20);
                    $this->SetFillColor(46, 44, 126);
                    $this->Cell(84, 6, utf8_decode('Firma del representante legal'), 1, 1, 'C', 'true');


                   
                   

                    $y6 = $this->GetY();
                    $this->SetTextColor(10, 10, 10);
                    $this->SetFont('Arial', 'B', 8);
                    $this->SetXY(106, $y6 + 2);
                   

                    $y7 = $this->GetY();
                    $this->SetFont('Arial', 'B', 8);
                    $this->SetXY(23, $y7 - 2);
                
                    $this->Cell(0, 4, utf8_decode('Identificación: ' . (self::$medicoAtendio->numero_documento_representante ?? '')), 0, 0, 'L', 0);

                    $this->Ln();

                    
                }
            } else {
                $y1 = $this->GetY();
                $this->SetTextColor(10, 10, 10);
                $this->SetFont('Arial', 'B', 9);
                $this->SetXY(23, $y1 + 7);
                if(!self::$medicoAtendio->firma_discentimiento){
                    $this->Cell(50, 0, utf8_decode('Fecha y hora del disentimiento o desistimiento informado:          NO APLICA' ), 0, 0, 'L', 0);
                }else{
                    $this->Cell(50, 0, utf8_decode('Fecha y hora del disentimiento o desistimiento informado: ' . (self::$medicoAtendio->fecha_firma_discentimiento ?? '')), 0, 0, 'L', 0);
                }

                $y2 = $this->GetY();

                $firma_paciente = self::$medicoAtendio->firma_consentimiento ?? null;
                $firma_paciente_discentimiento = self::$medicoAtendio->firma_discentimiento ?? null;

                $y4 = $this->GetY();
                if (self::$medicoAtendio?->firma_discentimiento !== null) {
                    if (isset($firma_paciente_discentimiento)) {
                        $base64Image = $firma_paciente_discentimiento;
                        $explodedData = explode(',', $base64Image);
                        $type = $explodedData[0];
                        $base64Data = $explodedData[1];
                        $imageData = base64_decode($base64Data);

                        $tempImage = tempnam(sys_get_temp_dir(), 'firma') . '.png';
                        file_put_contents($tempImage, $imageData);
                        $this->Image($tempImage, 40, $yt + 56, 46, 11);
                    }
                }

                $y5 = $this->GetY();
                if(!self::$medicoAtendio->firma_discentimiento){$this->Text(50,$y4+12,'NO APLICA');}
                $this->SetTextColor(255, 255, 255);
                $this->SetFont('Arial', 'B', 9);
                $this->SetXY(23, $y4 + 19);
                $this->SetFillColor(46, 44, 126);
                $this->Cell(84, 6, utf8_decode('Firma del paciente o representante legal'), 1, 1, 'C', 'true');



                $y10 = $this->GetY();
                $this->SetFont('Arial', 'B', 9);
                $this->SetXY(106, $y4 + 19);
                $this->SetFillColor(46, 44, 126);
                $this->Cell(84, 6, utf8_decode('Firma del auxiliar de laboratorio'), 1, 1, 'C', 'true');

                $y6 = $this->GetY();
                $this->SetTextColor(10, 10, 10);
                if(!self::$medicoAtendio->firma_discentimiento){$this->Text(130,$y4+12,'NO APLICA');}

                $this->SetFont('Arial', 'B', 8);
                $this->SetXY(106, $y6 + 2);
                if(!self::$medicoAtendio->firma_discentimiento){
                    $this->Cell(50, 0, utf8_decode('Nombre:                NO APLICA' ), 0, 'C');
                }else{
                    $this->Cell(50, 0, utf8_decode('Nombre: ' . (self::$medicoAtendio->nombre_profesional ?? '')), 0, 'C');
                }
                

                $y7 = $this->GetY();
                $this->SetFont('Arial', 'B', 8);
                $this->SetXY(23, $y7 - 2);
                if(!self::$medicoAtendio->firma_discentimiento){
                      $this->Cell(0, 4, utf8_decode('Identificación:          NO APLICA' ), 0, 0, 'L', 0);
                    
                 }else{
                    if (self::$medicoAtendio?->numero_documento_representante == null) {
                      $this->Cell(0, 4, utf8_decode('Identificación: ' . (self::$medicoAtendio->numero_documento ?? '')), 0, 0, 'L', 0);
                    } else {
                      $this->Cell(0, 4, utf8_decode('Identificación: ' . (self::$medicoAtendio->numero_documento_representante ?? '')), 0, 0, 'L', 0);
                    }
                 }

                $y8 = $this->GetY();
                $this->SetXY(30, $y8 + 7);
                $this->SetFont('Arial', '', 8);
                $this->Cell(50, 1, utf8_decode('* La huella del paciente se toma únicamente para las personas que no saben firmar o que presentan perdida de la visión.'), 0, 0, 'L', 0);
                $this->Ln();
                $this->Ln();

                $y9 = $this->GetY();
                if (self::$medicoAtendio?->firma_discentimiento !== null) {
                    if (isset(self::$medicoAtendio->firma_profesional)) {
                        if (file_exists(storage_path(substr(self::$medicoAtendio->firma_profesional, 9)))) {
                            $this->Image(storage_path(substr(self::$medicoAtendio->firma_profesional, 9)), 130, $yt + 56, 46, 11);
                        }
                    }
                }
            }
        }
        $this->SetXY(190, 287);
        $this->SetFont('Arial', '', 7);
        $this->Cell(10, 4, utf8_decode('Página ') . $this->PageNo() . ' de {nb}', 0, 0, 'C');
        $this->Ln();
        $this->Cell(186, 4, utf8_decode('Una vez descargado o impreso este documento se considera copia no controlada'), 0, 0, 'C');
    }

    public function header()
    {
        $this->SetFont('Arial', 'B', 11);

        $this->Line(20, 5, 190, 5);
        $this->Line(20, 35, 190, 35);
        $this->Line(20, 5, 20, 35);
        $this->Line(190, 5, 190, 35);

        // $logo = public_path() . "/logoFomag.png";
        $logo = public_path('images/logoEcoimagen.png');
        $this->Image($logo, 24, 7, -240);
        $this->SetXY(73, 15);
        $this->MultiCell(68, 5, utf8_decode(self::$consentimientoC->nombre ?? ''), 0, 'C');

        $this->Line(67, 5, 67, 35);
        $this->Line(147, 5, 147, 35);
        $this->Line(147, 25, 190, 25);
        $this->Line(147, 16, 190, 16);

        $this->SetXY(112, 13);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(0, 0, utf8_decode('Código:'), 0, 0, 'C', 0);

        $this->SetX(149);
        $this->SetFont('Arial', '', 11);
        $this->Cell(0, 0, utf8_decode(self::$consentimientoC->codigo ?? ''), 0, 0, 'C', 0);

        $this->SetFont('Arial', 'B', 11);
        $this->SetXY(113, 22);
        $this->Cell(0, 0, utf8_decode('Versión:'), 0, 0, 'C', 0);

        $this->SetFont('Arial', '', 11);
        $this->SetX(140);
        $this->Cell(0, 0, utf8_decode(self::$consentimientoC->version ?? ''), 0, 0, 'C', 0);

        $this->SetFont('Arial', 'B', 11);
        $this->SetXY(136, 28);
        $this->Cell(0, 0, utf8_decode('Fecha de aprobación:'), 0, 0, 'C', 0);
        $this->SetFont('Arial', '', 11);

        $this->SetX(115);

        $this->Cell(0, 10, utf8_decode(self::$consentimientoC->fecha_aprobacion ?? ''), 0, 0, 'C', 0);

        $this->Ln();
    }

    public function body($pdf)
    {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetXY(12, 45);
        $fechaHoraDiligenciamiento = self::$medicoAtendio?->fecha_hora_inicio ? Carbon::parse(self::$medicoAtendio?->fecha_hora_inicio)->format('Y-m-d H:i') : '';
        $pdf->Cell(0, 0, 'Fecha y hora de diligenciamiento: ' . $fechaHoraDiligenciamiento, 0, 0, 'L', 0);

        $pdf->SetTextColor(10, 10, 10);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetX(90);
        $pdf->Cell(0, 0, 'Servicio: Toma de muestras - laboratorio', 0, 0, 'C', 0);
        $inicio = $pdf->GetY();

        $pdf->Line(14, 50, 197, 50);// linea arriba
        $pdf->Line(14, 65, 197, 65);// linea fondo
        $pdf->Line(14, 50, 14, 65); //linea izq
        $pdf->Line(197, 50, 197, 65); // linea der
        
        $pdf->Ln();
        $pdf->SetXY(10, 55);
        // $pdf->Cell(40, 4, 'Paciente', 0, 0, 'L', 0);


        $pdf->SetFont('Arial', '', 9);
        $y1 = $pdf->GetY();
        $pdf->SetX(8);
         $pdf->MultiCell(68, 4, utf8_decode((self::$medicoAtendio->primer_nombre ?? '') . "  " . (self::$medicoAtendio->segundo_nombre ?? '') . " " . (self::$medicoAtendio->primer_apellido ?? '') . "  " . (self::$medicoAtendio->segundo_apellido ?? '')), 0, 'C');

        $y2 = $pdf->GetY();
        $pdf->SetXY(75, $y1);
        $pdf->MultiCell(55, 4, utf8_decode(self::$medicoAtendio->nombre_tipo_documento ?? ''), 0, 'C');


        $y4 = $pdf->GetY();
        $pdf->SetXY(135, $y1);
        $pdf->MultiCell(32, 4, utf8_decode(self::$medicoAtendio->numero_documento ?? ''), 0, 'C');


        $y5 = $pdf->GetY();
        $pdf->SetXY(170, $y1);
        $edad = $this->calcularEdad(self::$medicoAtendio?->fecha_nacimiento,self::$medicoAtendio?->fecha_hora_inicio);
        $pdf->MultiCell(20, 4, utf8_decode($edad ?? ''), 0, 'C');

        $conteo = max($y1, $y2, $y4, $y5);
        $pdf->Line(14, $conteo, 197, $conteo); //linea divisoria
        $pdf->Line(80, $inicio + 5, 80, $conteo + 6); //tipo nombre, tipo id
        $pdf->Line(130, $inicio + 5, 130, $conteo + 6); // tipo id, doc
        $pdf->Line(170, $inicio + 5, 170, $conteo + 6); //documento edad

        $pdf->SetFont('Arial', 'B', 9);
        $y = $pdf->GetY();
        $y10 = $pdf->GetY();
        $pdf->SetX(20);
        $pdf->Cell(45, 4, 'Nombre completo', 0, 0, 'C', 0);
        $y12 = $pdf->GetY();
        $pdf->SetX(80);
        $pdf->Cell(45, 4, mb_convert_encoding('Tipo identificación','ISO-8859-1'), 0, 0, 'C', 0);
        $y13 = $pdf->GetY();
        $pdf->SetX(135);
        $pdf->Cell(32, 4, 'Documento', 0, 0, 'C', 0);
        $y14 = $pdf->GetY();
        $pdf->SetX(170);
        $pdf->Cell(20, 4, 'Edad', 0, 0, 'C', 0);
        $max = max($y10,  $y12, $y13, $y14);
        $yt = $max;
        $y = $pdf->GetY();

        $pdf->SetXY(13, $y + 8);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(186, 4, utf8_decode('DESCRIPCIÓN DEL PROCEDIMIENTO'), 0, 0, 'J', 0);

        $pdf->Ln();
        $pdf->SetX(13);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode(self::$consentimientoC->descripcion ?? ''), 0, 'J');

        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetX(13);
        $pdf->Cell(186, 4, utf8_decode('BENEFICIOS DEL PROCEDIMIENTO'), 0, 0, 'L', 0);

        $pdf->Ln();
        $pdf->setX(13);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode(self::$consentimientoC->beneficios ?? ''), 0, 'J');

        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetX(13);
        $pdf->Cell(186, 4, utf8_decode('RIESGOS DEL PROCEDIMIENTO:'), 0, 0, 'L', 0);

        $pdf->Ln();
        $pdf->setX(13);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode(self::$consentimientoC->riesgos ?? ''), 0, 'J');

        $y = $pdf->GetY();
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetXY(13, $y + 8);
        $pdf->Cell(186, 4, 'ALTERNATIVAS DISPONIBLES AL PROCEDIMIENTO', 0, 0, 'L', 0);

        $pdf->Ln();
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetX(13);
        $pdf->MultiCell(186, 4, utf8_decode(self::$consentimientoC->alternativas ?? ''), 0, 'J');

        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetX(13);
        $pdf->Cell(186, 4, 'RIESGO DE NO ACEPTAR EL PROCEDIMIENTO', 0, 0, 'L', 0);

        $pdf->Ln();
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetX(13);
        $pdf->MultiCell(186, 4, utf8_decode(self::$consentimientoC->riesgo_no_aceptar ?? ''), 0, 'J');

        $pdf->Ln();
        $pdf->SetX(13);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(186, 4, utf8_decode('¿QUÉ HACER SI NECESITA MÁS INFORMACIÓN?'), 0, 0, 'L', 0);

        $pdf->Ln();
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetX(13);
        $pdf->MultiCell(186, 4, utf8_decode(self::$consentimientoC->informacion ?? ''), 0, 'J');

        $pdf->Ln();
        $pdf->SetX(13);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(186, 4, utf8_decode('RECOMENDACIONES'), 0, 0, 'L', 0);

        $pdf->Ln();
        $pdf->SetX(13);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode(self::$consentimientoC->recomendaciones ?? ''), 0, 'J');

        $pdf->Ln();
        $pdf->SetX(13);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(186, 4, utf8_decode('DECLARACIÓN DE CONSENTIMIENTO INFORMADO:'), 0, 0, 'L', 0);

        $pdf->Ln();
        $pdf->SetX(13);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode('En caso de realización de procedimiento en menor de edad o persona en condición de discapacidad, nombre del representante legal: ' . (self::$medicoAtendio->nombre_representante ?? '')), 0, 'J');

        $pdf->Ln();
        $pdf->SetX(13);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode('a) Declaro que he entendido las condiciones y objetivos del procedimiento que se me va a practicar, los cuidados que debo tener antes y después de ella, manifiesto que la información recibida del médico tratante ha sido en un lenguaje claro y sencillo, y me ha dado la oportunidad de preguntar y resolver las dudas a satisfacción; comprendo y acepto el alcance y los riesgos que conlleva el procedimiento que me indican, por lo que manifiesto sentirme satisfecho(a) con la información recibida: ' . (self::$medicoAtendio?->declaracion_a === 'Si' ? 'SI_X_ NO_' : 'SI_ NO_X_') . ' (marque con una X).'), 0, 'J');

        $pdf->Ln();
        $pdf->SetX(13);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode('b) Sumimedical S.A.S. es una institución Docente – Asistencial, por tanto, se cuenta con personal de salud en entrenamiento que puede hacer parte de su atención pero que en todo momento estará supervisado por los profesionales de la institución, usted como usuario acepta recibir atención por parte de personal en proceso de formación: ' . (self::$medicoAtendio?->declaracion_b === 'Si' ? 'SI_X_ NO_' : 'SI_ NO_X_') . ' (marque con una X).'), 0, 'J');


        $pdf->Ln();
        $pdf->SetX(13);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode('c)	El profesional me ha planteado la posibilidad de participar en estudios investigativos que adelanta la institución con fines de mejoramiento continuo, me ha explicado que en caso de que sea sujeto de investigación mis datos serán empleados guardando estricta confidencialidad, asimismo existe posibilidad de que se tomen registros fotográficos y/o audiovisuales en el proceso con fines exclusivamente académicos, por lo que manifiesto sentirme satisfecho(a) con la información recibida y aceptarlo: ') . (self::$medicoAtendio?->declaracion_c === 'Si' ? 'SI_X_ NO_' : 'SI_ NO_X_') . ' (marque con una X).', 0, 'J');

        $pdf->Ln();
        $pdf->SetX(13);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(186, 4, utf8_decode('d)	Por lo anteriormente dicho, y en pleno uso de mis facultades, autorizo al equipo de salud de la Sumimedical S.A.S. para que se me realice el procedimiento arriba descrito (o a mi representado según el caso) el cual fue solicitado por mi médico tratante. Entiendo y asumo los riesgos relacionados con la realización de este y autorizo a que se tomen las medidas necesarias ante cualquier complicación derivada del procedimiento ') . (self::$medicoAtendio?->aceptacion_consentimiento === 'Si' ? 'SI_X_ NO_' : 'SI_ NO_X_') . ' (marque con una X).', 0, 'J');


        $pdf->Ln();
        $pdf->SetX(13);
        $pdf->MultiCell(186, 4, utf8_decode('Nota: como paciente, usted tiene derecho a retractarse de este consentimiento informado en cualquier momento antes o durante la realización de la intervención.'), 0, 'J');
    }
    private function calcularEdad($fechaNacimiento, $fechaConsulta)
    {
        if(!$fechaNacimiento){return '';}
        $fechaNacimiento = new DateTime($fechaNacimiento);
        $fechaConsulta = new DateTime($fechaConsulta);
        $diferencia = $fechaNacimiento->diff($fechaConsulta);
        $totalMeses = ($diferencia->y * 12) + $diferencia->m;
        if ($totalMeses === 0) {
            // Si la edad es menor a un mes
            return $diferencia->d . ' Días';
        } elseif ($totalMeses < 24) {
            // Entre 1 mes y menos de 24 meses
            return $totalMeses . ' Meses';
        } else {
            // 2 años o más
            return $diferencia->y . ' Años';
        }
    }
}
