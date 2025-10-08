<?php

namespace App\Formats;

use App\Http\Modules\Agendas\Models\Agenda;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Facades\Auth;

class CertificadoCitas extends FPDF
{
    public static $citas;

    public function generar($datos)
    {
        $pdf = new CertificadoCitas('p', 'mm', 'A4');
        self::$citas = Agenda::select(
            'afiliados.tipo_documento',
            'afiliados.numero_documento',
            'tipo_documentos.sigla',
            'agendas.id',
            'agendas.consultorio_id',
            'agendas.cita_id',
            'reps.nombre as sede',
            'reps.direccion as direcionSede',
            'agendas.fecha_inicio',
            'agendas.fecha_fin'
        )
            ->selectRaw("CONCAT(afiliados.primer_nombre,' ',afiliados.segundo_nombre,' ',afiliados.primer_apellido,' ',afiliados.segundo_apellido) as paciente")
            ->join('consultas', 'consultas.agenda_id', 'agendas.id')
            ->join('afiliados', 'afiliados.id', 'consultas.afiliado_id')
            ->join('tipo_documentos', 'tipo_documentos.id', 'afiliados.tipo_documento')
            ->join('consultorios as c', 'c.id', 'agendas.consultorio_id')
            ->join('reps', 'reps.id', 'c.rep_id')
            ->whereIn('consultas.estado_id', [13, 14, 59, 67])
            ->where('afiliados.id', $datos['afiliado_id'])
            ->where('agendas.id', $datos['id'])
            ->first();

        // dd(self::$citas);

        $pdf->AliasNbPages();
        $pdf->AddPage();
        $this->body($pdf);
        $pdf->Output();
    }

    public function Header()
    {
        $this->SetDrawColor(140, 190, 56);
        $this->Rect(8, 5, 195, 287);
        $this->SetDrawColor(0, 0, 0);

        $this->SetFont('Arial', 'B', 9);
        $logo = public_path() . "/images/logoEcoimagen.png";
        $this->Image($logo, 16, 9, -220);
        $this->SetFont('Arial', '', 7);
        $this->SetXY(8, 37);
        $this->Cell(60, 3, utf8_decode('NIT:900033371-4 Res: 004 '), 0, 0, 'C');

        $this->SetFont('Arial', 'I', 8);
        $this->TextWithDirection(206, 85, 'Funcionario que Imprime:', 'U');

        $this->TextWithDirection(206, 50, utf8_decode(Auth::user()->email), 'U');
        $this->TextWithDirection(209, 85, utf8_decode('Fecha Impresión:'), 'U');
        $this->TextWithDirection(209, 60, Carbon::now()->isoFormat('dddd D MMMM [de] YYYY, [hora] h:mm a'), 'U');
    }

    public function TextWithDirection($x, $y, $txt, $direction = 'R')
    {
        if ($direction == 'U') {
            $s = sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', 0, 1, -1, 0, $x * $this->k, ($this->h - $y) * $this->k, $this->_escape($txt));
        }
        if ($this->ColorFlag) {
            $s = 'q ' . $this->TextColor . ' ' . $s . ' Q';
        }
        $this->_out($s);
    }

    public function body($pdf)
    {
        $pdf->SetXY(35, 25);
        $pdf->SetFont('Arial', 'B', 15);
        $pdf->Cell(186, 4, utf8_decode('COMPROBANTE DE ASIGNACIÓN DE CITAS'), 0, 0, 'C');

        $pdf->SetXY(12, 43);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('DATOS DE LA CITA'), 1, 0, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetXY(12, 49);
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(187, 4, utf8_decode('Señor(A)' . ' ' . self::$citas->paciente . ' ' . 'con número de documento' . ' ' . self::$citas->sigla . ' ' . self::$citas->numero_documento . ' ' . 'se le informa que su cita de' . ' ' .
            self::$citas['cita']['nombre'] . ' ' . 'de' . ' ' . self::$citas['cita']['especialidad']['nombre'] . ' ' . 'es el dia' . ' ' . Carbon::parse(self::$citas->fecha_inicio)->isoFormat('dddd D MMMM [de] YYYY, [hora] h:mm a') . ' con el medico' . ' ' . self::$citas['medicos'][count(self::$citas['medicos']) - 1]['operador']['nombre_completo'] . ' en la sede' . ' ' . self::$citas->sede . ' '
            . 'con direccion' . ' ' . self::$citas->direcionSede .
            ' ' . 'en la modalidad' . ' ' . self::$citas['cita']['modalidad']['nombre'] . '. ' . ' Si su cita es con especialista por favor llevar a la consulta, historias clínicas de atenciones previas.'), 0, 'J');


        $pdf->Cell(186, 14, utf8_decode('Señor usuario recuerde llegar 20 min antes de la hora asignada .'), 0, 1, 'C', 0);
        $link = 'https://www.horus-health.com/gestion/citas';
        $pdf->ln();
        $pdf->ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 12);
        // $pdf->Cell(185, 4, utf8_decode('Puede ingresar a la página dando clic AQUI'), 0, 0, 'C', false, $link);
    }
}
