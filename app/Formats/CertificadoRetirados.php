<?php

namespace App\Formats;

use App\Modelos\Empleado;
use App\Modelos\gestion_humana_certificados;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CertificadoRetirados extends FPDF
{
    public static $empleado;

    protected $B = 0;
    protected $I = 0;
    protected $U = 0;
    protected $HREF = '';

    public function generar($cedula)
    {
        $pdf = new CertificadoRetirados('p', 'mm', 'A4');
        // self::$empleado = gestion_humana_certificados::select('*')
        //     ->where('documento', $cedula)->where('estado_empleado', 'RETIRADO')
        //     ->orderBy('fecha_ingreso', 'desc')->first();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetTitle('Certificado laboral retirado');
        $this->body($pdf);
        $pdf->Output();
    }
    public function WriteHTML($html)
    {
        // Intérprete de HTML
        $html = str_replace("\n", ' ', $html);
        $a = preg_split('/<(.*)>/U', $html, -1, PREG_SPLIT_DELIM_CAPTURE);
        foreach ($a as $i => $e) {
            if ($i % 2 == 0) {
                // Text
                if ($this->HREF)
                    $this->PutLink($this->HREF, $e);
                else
                    $this->Write(5, $e);
            } else {
                // Etiqueta
                if ($e[0] == '/')
                    $this->CloseTag(strtoupper(substr($e, 1)));
                else {
                    // Extraer atributos
                    $a2 = explode(' ', $e);
                    $tag = strtoupper(array_shift($a2));
                    $attr = array();
                    foreach ($a2 as $v) {
                        if (preg_match('/([^=]*)=["\']?([^"\']*)/', $v, $a3))
                            $attr[strtoupper($a3[1])] = $a3[2];
                    }
                    $this->OpenTag($tag, $attr);
                }
            }
        }
    }

    public function OpenTag($tag, $attr)
    {
        // Etiqueta de apertura
        if ($tag == 'B' || $tag == 'I' || $tag == 'U')
            $this->SetStyle($tag, true);
        if ($tag == 'A')
            $this->HREF = $attr['HREF'];
        if ($tag == 'BR')
            $this->Ln(5);
    }

    public function CloseTag($tag)
    {
        // Etiqueta de cierre
        if ($tag == 'B' || $tag == 'I' || $tag == 'U')
            $this->SetStyle($tag, false);
        if ($tag == 'A')
            $this->HREF = '';
    }

    public function SetStyle($tag, $enable)
    {
        // Modificar estilo y escoger la fuente correspondiente
        $this->$tag += ($enable ? 1 : -1);
        $style = '';
        foreach (array('B', 'I', 'U') as $s) {
            if ($this->$s > 0)
                $style .= $s;
        }
        $this->SetFont('', $style);
    }

    public function PutLink($URL, $txt)
    {
        // Escribir un hiper-enlace
        $this->SetTextColor(0, 0, 255);
        $this->SetStyle('U', true);
        $this->Write(5, $txt, $URL);
        $this->SetStyle('U', false);
        $this->SetTextColor(0);
    }

    public function Header()
    {
        $logo1 = public_path(). "images/descargas.png";
        $this->SetFont('Arial', 'B', 15);
        $this->SetDrawColor(255, 255, 255);
        $this->Rect(5, 5, 200, 287);
        $this->SetDrawColor(0, 0, 0);

        $this->Image($logo1, 158, 10, 40);
        $this->Ln();
    }

    public function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetXY(0, -15);
        $this->SetFont('Arial', 'I', 12);
        $this->SetFillColor(172, 208, 61);
        $this->SetTextColor(247, 248, 244);
        $this->MultiCell(210, 5, utf8_decode('www.sumimedical.com'), 0, 'C', true);
    }

    public function body($pdf){

        $pdf->SetXY(10, 50);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->cell(190, 5, utf8_decode("SUMIMEDICAL S.A.S"), 0, '0', 'C');
        $pdf->Ln();

        $pdf->SetXY(10, 64);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->cell(190, 5, utf8_decode("CERTIFICA QUE"), 0, '0', 'C');
        $pdf->Ln();

        //Carbon::parse(self::$empleado->fecha_ingreso)->isoFormat('D MMMM YYYY');
        $fechanicio = '18 MMMM 2018';
        //Carbon::parse(self::$empleado->fecha_retiro)->isoFormat('D MMMM YYYY')
        $fechafin = '22 MMMM 2023';
        //Carbon::now()->isoFormat('D [dias del mes de] MMMM [de] YYYY');
        $dia = 26;

        $cedula = number_format(0, 0, ",", ".");

        $pdf->SetXY(25, 80);
        $pdf->SetFont('Arial', '', 12);
        $pdf->MultiCell(155, 5, utf8_decode('$empleado,' . ' identificado(a) con cédula de ciudadanía número' . ' ' .
            '$cedula' . ',' . ' ' . 'laboró en esta empresa como' . ' ' . 'cargo_empleado' . ' ' .
            'desde el día ' . $fechanicio . ' hasta el día ' . $fechafin . ';' . ' con un contrato a término fijo' . '.'), 0, 'J');
        $pdf->Ln();

        $pdf->SetXY(25, 110);
        $pdf->SetFont('Arial', '', 12);
        $pdf->MultiCell(155, 5, utf8_decode('La presente se expide a solicitud del interesado a los ' . $dia . '.'), 0, 'J');
        $pdf->Ln();

        $pdf->SetXY(25, 140);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(171, 5, utf8_decode('Sumimedical'), 0, 0, 'J');
        $pdf->Ln();

        $pdf->SetXY(25, 145);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(171, 5, utf8_decode('Nit: ' . '900033371-4'), 0, 0, 'J');
        $pdf->Ln();

        $pdf->SetXY(25, 150);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(171, 5, utf8_decode('Teléfono: ' . '5201040 extensión 110'), 0, 0, 'J');
        $pdf->Ln();
        $html = 'Correo: <a href="mailto:talento.humano@sumimedical.com">talento.humano@sumimedical.com</a>';
        $pdf->SetXY(25, 155);
        $pdf->SetFont('Arial', '', 12);
        //$pdf->WriteHTML($html);
        $pdf->Ln();

        $logo2 = public_path(). "images/sello.png";

        $pdf->SetXY(125, 150);
        $pdf->Image($logo2);
        $pdf->Ln();

        $pdf->SetXY(25, 190);
        $pdf->Cell(171, 5, utf8_decode('Atentamente,'), 0, 0, 'J');
        $pdf->Ln();

        $logo3 = public_path(). "images/firma.png";

        $pdf->SetXY(25, 200);
        $pdf->Image($logo3);
        $pdf->Ln();

        $pdf->SetXY(25, 215);
        $pdf->Cell(155, 5, utf8_decode('PAOLA ISABEL FONSECA DIAZ'), 0, 0, 'J');
        $pdf->Ln();

        $pdf->SetXY(25, 220);
        $pdf->Cell(155, 5, utf8_decode('Directora Gestión Humana'), 0, 0, 'J');
        $pdf->Ln();


    }

}


